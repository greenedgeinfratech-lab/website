/*
 * Greenedge Infratech - Solar savings calculator
 * Calculation engine (pure function) + page wiring.
 * All assumptions come from window.SOLAR_CONFIG (assets/js/solar-config.js).
 */
(function (root) {
  'use strict';

  function round(n, step) { return Math.round(n / step) * step; }
  function clamp(n, lo, hi) { return Math.min(hi, Math.max(lo, n)); }
  function num(v) { var n = parseFloat(v); return isFinite(n) ? n : NaN; }

  function costPerKw(kw, cfg) {
    for (var i = 0; i < cfg.costBands.length; i++) {
      if (kw <= cfg.costBands[i].uptoKw) return cfg.costBands[i].perKw;
    }
    return cfg.costBands[cfg.costBands.length - 1].perKw;
  }

  function subsidyFor(kw, category, cfg, houses, state) {
    var cat = cfg.categories[category];
    if (!cat || !cat.subsidyEligible || state === 'Outside India') return { central: 0, state: 0, total: 0, abroad: state === 'Outside India' };
    if (cat.subsidyType === 'ghs') {
      var g = cfg.subsidy.ghs;
      var h = num(houses);
      var eligibleKw = Math.min(kw, g.capKw, h > 0 ? h * g.kwPerHouse : Infinity);
      var c = Math.round(eligibleKw * g.perKw);
      return { central: c, state: 0, total: c, eligibleKw: eligibleKw, needsHouses: !(h > 0) };
    }
    var central = 0;
    cfg.subsidy.central.forEach(function (slab) {
      var part = clamp(kw, slab.fromKw, slab.toKw) - slab.fromKw;
      if (part > 0) central += part * slab.perKw;
    });
    central = Math.min(central, cfg.subsidy.centralCap);
    var st = cfg.subsidy.state;
    var state = (st.appliesTo && state === st.appliesTo) ? Math.min(kw * st.perKw, st.cap) : 0;
    return { central: Math.round(central), state: Math.round(state), total: Math.round(central + state) };
  }

  /**
   * inputs: { category, mode: 'bill'|'units', value, tariff, roofArea?, sizeOverride? }
   * returns { ok:true, ... } or { ok:false, error }
   */
  function emi(principal, rate, years) {
    if (!(principal > 0)) return 0;
    var r = rate / 12, n = years * 12;
    return r > 0 ? principal * r * Math.pow(1 + r, n) / (Math.pow(1 + r, n) - 1) : principal / n;
  }

  function compute(inputs, cfg) {
    var cat = cfg.categories[inputs.category];
    if (!cat) return { ok: false, error: 'Please choose a customer type.' };
    if (cat.subsidyType === 'ghs' && !(num(inputs.houses) >= 2)) return { ok: false, error: 'Please enter the number of houses / flats in your society.' };

    var tariff = num(inputs.tariff);
    if (!(tariff >= 2 && tariff <= 25)) return { ok: false, error: 'Please enter your electricity rate per unit (between Rs 2 and Rs 25).' };

    var value = num(inputs.value);
    var monthlyUnits;
    if (inputs.mode === 'units') {
      if (!(value >= 30 && value <= 500000)) return { ok: false, error: 'Please enter your monthly units (between 30 and 5,00,000).' };
      monthlyUnits = value;
    } else {
      if (!(value >= 300 && value <= 5000000)) return { ok: false, error: 'Please enter your monthly bill (between Rs 300 and Rs 50,00,000).' };
      monthlyUnits = (value - cat.fixedCharges) / tariff;
      if (monthlyUnits < 30) return { ok: false, error: 'This bill is mostly fixed charges, so solar savings would be very small. Please call us to discuss.' };
    }

    var perKwMonth = cfg.generationPerKwPerDay * 30.4;
    var maxByRoof = Infinity;
    var roof = num(inputs.roofArea);
    if (roof > 0) maxByRoof = roof / cfg.roofAreaPerKw;

    var idealKw = monthlyUnits / perKwMonth;
    var kw;
    var sizeOverride = num(inputs.sizeOverride);
    if (sizeOverride > 0) {
      kw = clamp(round(sizeOverride, cat.step), cat.minKw, cat.maxKw);
    } else {
      kw = clamp(round(idealKw, cat.step), cat.minKw, cat.maxKw);
      if (kw > maxByRoof) kw = Math.max(cat.minKw, Math.floor(maxByRoof / cat.step) * cat.step);
    }
    if (!(kw > 0)) return { ok: false, error: 'Could not work out a system size from these inputs.' };

    var limitedByRoof = maxByRoof < idealKw && !(sizeOverride > 0);
    var limitedByCap = idealKw > cat.maxKw;

    // Generation and how it is used
    var monthlyGen = kw * perKwMonth;
    var annualGen = monthlyGen * 12;
    var annualUse = monthlyUnits * 12;
    var offsetUnits = Math.min(annualGen, annualUse);        // replaces units you would buy
    var surplusUnits = Math.max(0, annualGen - annualUse);   // left over after a year of netting

    var annualSavings = offsetUnits * tariff + surplusUnits * cfg.surplusExportRate;
    var currentMonthlyBill = inputs.mode === 'bill' ? value : monthlyUnits * tariff + cat.fixedCharges;
    var newMonthlyBill = Math.max(cat.fixedCharges, currentMonthlyBill - offsetUnits * tariff / 12);
    var billReductionPct = currentMonthlyBill > 0 ? (1 - newMonthlyBill / currentMonthlyBill) * 100 : 0;

    // Cost and subsidy
    var cost = kw * costPerKw(kw, cfg);
    var sub = subsidyFor(kw, inputs.category, cfg, inputs.houses, inputs.state);
    var netCost = Math.max(0, cost - sub.total);
    var payback = annualSavings > 0 ? netCost / annualSavings : null;

    // Lifetime with degradation and tariff growth
    var lifetime = 0;
    for (var y = 0; y < cfg.lifetimeYears; y++) {
      var genFactor = Math.pow(1 - cfg.annualDegradation, y);
      var priceFactor = Math.pow(1 + cfg.tariffEscalation, y);
      var g = annualGen * genFactor;
      var off = Math.min(g, annualUse);
      var sur = Math.max(0, g - annualUse);
      lifetime += off * tariff * priceFactor + sur * cfg.surplusExportRate;
    }

    var co2Year = annualGen * cfg.co2PerKwh / 1000; // tonnes
    var fin = cfg.finance || { rate: 0.07, years: 7 };
    var monthlyEmi = cat.subsidyEligible ? emi(netCost, fin.rate, fin.years) : 0;

    return {
      ok: true,
      category: inputs.category,
      monthlyUnits: monthlyUnits,
      kw: kw,
      idealKw: idealKw,
      limitedByRoof: limitedByRoof,
      limitedByCap: limitedByCap,
      roofNeeded: kw * cfg.roofAreaPerKw,
      dailyGen: kw * cfg.generationPerKwPerDay,
      monthlyGen: monthlyGen,
      monthlyGenLow: monthlyGen * (1 - cfg.generationUncertainty),
      monthlyGenHigh: monthlyGen * (1 + cfg.generationUncertainty),
      annualGen: annualGen,
      selfUsePct: annualGen > 0 ? offsetUnits / annualGen * 100 : 0,
      surplusUnits: surplusUnits,
      annualSavings: annualSavings,
      currentMonthlyBill: currentMonthlyBill,
      newMonthlyBill: newMonthlyBill,
      billReductionPct: billReductionPct,
      cost: cost,
      costLow: cost * (1 - cfg.costRange),
      costHigh: cost * (1 + cfg.costRange),
      subsidy: sub,
      netCost: netCost,
      payback: payback,
      lifetimeSavings: lifetime,
      monthlyEmi: monthlyEmi,
      monthlySavings: annualSavings / 12,
      houses: num(inputs.houses) || null,
      lifetimeNet: lifetime - netCost,
      co2Year: co2Year,
      co2Lifetime: co2Year * cfg.lifetimeYears * (1 - cfg.annualDegradation * cfg.lifetimeYears / 2)
    };
  }

  var api = { compute: compute, subsidyFor: subsidyFor, costPerKw: costPerKw, emi: emi };
  if (typeof module !== 'undefined' && module.exports) module.exports = api;
  root.SolarCalc = api;

  // ---------------------------------------------------------------- page UI
  if (typeof document === 'undefined') return;

  var inr = function (n) { return '₹' + Math.round(n).toLocaleString('en-IN'); };
  var fmt = function (n, d) { return Number(n).toLocaleString('en-IN', { maximumFractionDigits: d || 0, minimumFractionDigits: d || 0 }); };

  document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('calc-form');
    if (!form) return;
    var F = form.elements;
    var cfg = root.SOLAR_CONFIG;
    var $ = function (id) { return document.getElementById(id); };
    var started = false;
    var last = null;

    function setTariffDefault() {
      var c = cfg.categories[F.category.value];
      if (!F.tariff.dataset.touched) F.tariff.value = c.defaultTariff;
      var hw = $('houses-wrap');
      if (hw) hw.classList.toggle('hidden', c.subsidyType !== 'ghs');
    }
    function setMode() {
      var m = form.querySelector('input[name="mode"]:checked').value;
      $('value-label').textContent = m === 'bill' ? 'Average monthly electricity bill (₹)' : 'Average monthly consumption (units / kWh)';
      F.value.placeholder = m === 'bill' ? 'e.g. 3500' : 'e.g. 400';
    }
    F.category.addEventListener('change', function () { F.sizeOverride.value = ''; setTariffDefault(); });
    F.tariff.addEventListener('input', function () { F.tariff.dataset.touched = '1'; });
    Array.prototype.forEach.call(form.querySelectorAll('input[name="mode"]'), function (r) { r.addEventListener('change', setMode); });
    form.addEventListener('input', function () {
      if (!started) { started = true; track('calculator_start', {}); }
    });
    setTariffDefault(); setMode();

    // Prefill from links such as /calculator?cat=residential&bill=3500
    try {
      var q = new URLSearchParams(location.search);
      if (q.get('cat') && cfg.categories[q.get('cat')]) { F.category.value = q.get('cat'); setTariffDefault(); }
      var pre = q.get('bill') ? ['bill', q.get('bill')] : (q.get('units') ? ['units', q.get('units')] : null);
      if (pre) {
        form.querySelector('input[name="mode"][value="' + pre[0] + '"]').checked = true; setMode();
        F.value.value = pre[1].replace(/[^0-9.]/g, '');
        setTimeout(function () { form.requestSubmit ? form.requestSubmit() : form.dispatchEvent(new Event('submit', { cancelable: true })); }, 50);
      }
    } catch (err) { /* ignore */ }

    var pending = null;
    function isUnlocked() { try { return sessionStorage.getItem('ge_calc_unlocked') === '1'; } catch (e) { return false; } }
    function fillLead(r) {
      var lf = document.getElementById('lead-form');
      if (!lf) return;
      lf.elements.category.value = r.category === 'society' ? 'housing-society' : r.category;
      if (F.state && F.state.value && !lf.elements.city.value) lf.elements.city.value = F.state.value;
      lf.elements.calc_summary.value = JSON.stringify({
        system_kw: r.kw, monthly_units: Math.round(r.monthlyUnits), monthly_bill: Math.round(r.currentMonthlyBill),
        tariff: parseFloat(F.tariff.value), annual_savings: Math.round(r.annualSavings),
        cost_range: [Math.round(r.costLow), Math.round(r.costHigh)], subsidy: r.subsidy.total,
        net_cost: Math.round(r.netCost), payback_years: r.payback ? +r.payback.toFixed(1) : null,
        houses: r.houses
      });
    }
    function showGate(r) {
      pending = r;
      fillLead(r);
      $('calc-error').classList.add('hidden');
      if ($('results-empty')) $('results-empty').classList.add('hidden');
      $('results').classList.add('hidden');
      $('calc-gate').classList.remove('hidden');
      $('calc-gate').scrollIntoView({ behavior: 'smooth', block: 'start' });
      track('calculator_gate_shown', { system_kw: r.kw, category: r.category });
    }
    document.addEventListener('ge:lead-success', function (ev) {
      if (!ev.target || ev.target.id !== 'lead-form' || !pending) return;
      try { sessionStorage.setItem('ge_calc_unlocked', '1'); } catch (e) { /* ignore */ }
      var r = pending;
      setTimeout(function () { $('calc-gate').classList.add('hidden'); render(r); }, 1200);
    });

    function render(r) {
      $('calc-error').classList.add('hidden');
      $('results').classList.remove('hidden');
      if ($('results-empty')) $('results-empty').classList.add('hidden');
      $('r-kw').textContent = fmt(r.kw, r.kw % 1 ? 1 : 0) + ' kW';
      $('r-roof').textContent = fmt(r.roofNeeded) + ' sq ft shadow-free roof';
      $('r-gen').textContent = fmt(r.monthlyGenLow) + '–' + fmt(r.monthlyGenHigh) + ' units';
      $('r-gen-sub').textContent = 'per month (about ' + fmt(r.dailyGen, 1) + ' units a day, ' + fmt(r.annualGen) + ' a year)';
      $('r-save').textContent = inr(r.annualSavings);
      $('r-save-sub').textContent = 'in year 1 – bill drops from about ' + inr(r.currentMonthlyBill) + ' to ' + inr(r.newMonthlyBill) + ' a month (' + fmt(r.billReductionPct) + '% lower)';
      $('r-cost').textContent = inr(r.costLow) + ' – ' + inr(r.costHigh);
      if (r.subsidy.total > 0 && r.category === 'society') {
        $('r-sub').textContent = 'up to ' + inr(r.subsidy.total);
        $('r-sub-sub').textContent = 'PM Surya Ghar for housing societies: ₹18,000/kW on ' + fmt(r.subsidy.eligibleKw, 1) + ' kW (lowest of plant size, 3 kW per house, 500 kW), common facilities only';
        $('r-net').textContent = inr(r.netCost);
      } else if (r.subsidy.total > 0) {
        $('r-sub').textContent = 'up to ' + inr(r.subsidy.total);
        $('r-sub-sub').textContent = r.subsidy.state > 0
          ? inr(r.subsidy.central) + ' central (PM Surya Ghar) + ' + inr(r.subsidy.state) + ' ' + cfg.subsidy.state.label + ', if eligible'
          : inr(r.subsidy.central) + ' central subsidy under PM Surya Ghar, if eligible. Your state may add more.';
        $('r-net').textContent = inr(r.netCost);
      } else if (r.subsidy.abroad) {
        $('r-sub').textContent = 'Not applicable';
        $('r-sub-sub').textContent = 'Indian government subsidies apply only in India. Ask us about incentives in your country.';
        $('r-net').textContent = inr(r.netCost);
      } else {
        $('r-sub').textContent = 'Not applicable';
        $('r-sub-sub').textContent = 'PM Surya Ghar subsidy is for residential consumers only. Businesses may benefit from accelerated depreciation – ask your CA.';
        $('r-net').textContent = inr(r.netCost);
      }
      $('r-payback').textContent = r.payback ? fmt(r.payback, 1) + ' years' : '–';
      $('r-life').textContent = inr(r.lifetimeSavings);
      $('r-co2').textContent = fmt(r.co2Year, 1) + ' tonnes CO₂ a year';
      if ($('r-emi')) {
        var fin = cfg.finance;
        if (r.monthlyEmi > 0) {
          $('r-emi').textContent = inr(r.monthlyEmi) + ' / month';
          $('r-emi-sub').textContent = 'if your net investment is financed over ' + fin.years + ' years at about ' + fmt(fin.rate * 100, 1) + '% (indicative). Estimated saving: ' + inr(r.monthlySavings) + ' a month.';
        } else {
          $('r-emi').textContent = 'Zero-investment option';
          $('r-emi-sub').innerHTML = 'Businesses can also go solar with no upfront cost under the <a class="underline" href="/resco-solar">RESCO model</a>, or claim tax depreciation when they own the plant.';
        }
      }
      $('r-selfuse').textContent = fmt(r.selfUsePct) + '% of generation used against your own consumption' + (r.surplusUnits > 0 ? '; about ' + fmt(r.surplusUnits) + ' surplus units a year credited at a lower export rate' : '');
      var notes = [];
      if (r.limitedByRoof) notes.push('Your roof area limits the system to ' + fmt(r.kw, 1) + ' kW, so it will cover part of your use.');
      if (r.limitedByCap) notes.push('Your usage needs more than ' + cfg.categories[r.category].maxKw + ' kW. For larger needs please request a site survey.');
      $('r-notes').textContent = notes.join(' ');
      $('r-notes').classList.toggle('hidden', notes.length === 0);
      if ($('size-input')) { $('size-input').value = r.kw; $('size-input').step = cfg.categories[r.category].step; }

      $('results').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var resize = e.submitter && e.submitter.id === 'resize-btn';
      var r = compute({
        category: F.category.value,
        mode: form.querySelector('input[name="mode"]:checked').value,
        value: F.value.value,
        tariff: F.tariff.value,
        roofArea: F.roofArea.value,
        houses: F.houses ? F.houses.value : '',
        state: F.state ? F.state.value : '',
        sizeOverride: resize && $('size-input') ? $('size-input').value : ''
      }, cfg);
      if (!r.ok) {
        $('calc-error').textContent = r.error;
        $('calc-error').classList.remove('hidden');
        return;
      }
      last = r;
      if (isUnlocked() || resize) render(r); else showGate(r);
      track('calculator_complete', { system_kw: r.kw, category: r.category });
    });
  });

  function track(name, params) {
    try {
      root.dataLayer = root.dataLayer || [];
      root.dataLayer.push(Object.assign({ event: name }, params));
      if (typeof root.gtag === 'function') root.gtag('event', name, params);
    } catch (e) { /* ignore */ }
  }
  root.geTrack = track;
})(typeof window !== 'undefined' ? window : globalThis);
