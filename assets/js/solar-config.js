/*
 * Greenedge Infratech - Solar calculator assumptions
 * ----------------------------------------------------------------------------
 * Every number the calculator uses lives in this one file, so it can be
 * updated without touching the calculation code (assets/js/calculator.js).
 *
 * Items marked CONFIRM are business inputs that Greenedge should check
 * against its own current pricing before relying on them.
 * Last reviewed: 15 Nov 2026
 */
window.SOLAR_CONFIG = {
  // Average daily generation per kWp of rooftop solar in Aligarh / Western UP,
  // across the year, after typical system losses (inverter, wiring, dust, heat).
  // Conservative planning value; real output varies with orientation and shade.
  generationPerKwPerDay: 4.2,          // kWh per kWp per day
  generationUncertainty: 0.10,         // +/- 10% shown as a range

  // Shadow-free roof area needed per kWp (MNRE guidance is roughly 10 m2 = 100 sq ft)
  roofAreaPerKw: 100,                  // sq ft

  // Panel output loss per year (typical manufacturer linear warranty ~0.5%/yr)
  annualDegradation: 0.005,

  // Electricity price growth assumed for long-term savings
  tariffEscalation: 0.03,              // 3% per year

  lifetimeYears: 25,

  // CO2 avoided per unit of grid electricity replaced.
  // CEA CO2 Baseline Database v20 (2023-24) weighted average: 0.727 tCO2/MWh.
  co2PerKwh: 0.727,                    // kg CO2 per kWh

  // Value of surplus units exported beyond your own consumption over a year.
  // Units you export and then import back are offset at your tariff under net
  // metering; only the annual surplus is credited at this lower rate. CONFIRM
  // against the current UPERC net-metering order.
  surplusExportRate: 2.5,              // Rs per kWh

  categories: {
    residential: {
      label: 'Residential (home)',
      defaultTariff: 7.0,              // Rs/kWh, energy charge average. CONFIRM
      fixedCharges: 220,               // Rs/month approx. fixed + other charges in a bill
      minKw: 1, maxKw: 10, step: 0.5,
      subsidyEligible: true
    },
    society: {
      label: 'Housing society / RWA (common areas)',
      defaultTariff: 8.0,              // Rs/kWh, common-area connection. CONFIRM
      fixedCharges: 1500,
      minKw: 5, maxKw: 500, step: 1,
      subsidyEligible: true,
      subsidyType: 'ghs'               // PM Surya Ghar GHS/RWA rate, see subsidy.ghs
    },
    commercial: {
      label: 'Commercial (shop, office, school, hospital)',
      defaultTariff: 9.0,              // CONFIRM
      fixedCharges: 800,
      minKw: 2, maxKw: 500, step: 1,
      subsidyEligible: false
    },
    industrial: {
      label: 'Industrial (factory, cold store, mill)',
      defaultTariff: 8.0,              // CONFIRM
      fixedCharges: 3000,
      minKw: 10, maxKw: 2000, step: 5,
      subsidyEligible: false
    }
  },

  // Indicative installed price per kWp (GST included) for on-grid systems.
  // The calculator shows a range around this value. CONFIRM with Greenedge pricing.
  costBands: [
    { uptoKw: 3,        perKw: 60000 },
    { uptoKw: 5,        perKw: 57000 },
    { uptoKw: 10,       perKw: 54000 },
    { uptoKw: 50,       perKw: 48000 },
    { uptoKw: 100,      perKw: 44000 },
    { uptoKw: Infinity, perKw: 40000 }
  ],
  costRange: 0.08,                     // +/- 8%

  // PM Surya Ghar: Muft Bijli Yojana - residential consumers only.
  // Central (MNRE, amended guidelines July 2025): Rs 30,000/kW for the first 2 kW,
  // Rs 18,000 for the 3rd kW, capped at Rs 78,000.
  // Uttar Pradesh (UPNEDA): Rs 15,000/kW, capped at Rs 30,000 per consumer.
  // Eligibility is decided by the National Portal, DISCOM and UPNEDA, not by this tool.
  subsidy: {
    central: [
      { fromKw: 0, toKw: 2, perKw: 30000 },
      { fromKw: 2, toKw: 3, perKw: 18000 }
    ],
    centralCap: 78000,
    state: { perKw: 15000, cap: 30000, label: 'Uttar Pradesh (UPNEDA)' },
    // Group Housing Societies / RWAs, common facilities incl. EV charging:
    // Rs 18,000/kW on the lowest of (installed kW, 3 kW x houses, 500 kW).
    // No UP state top-up is assumed for societies. CONFIRM if UPNEDA adds one.
    ghs: { perKw: 18000, capKw: 500, kwPerHouse: 3 }
  },

  // Indicative EMI shown for homes and societies. Bank rates and terms vary;
  // PM Surya Ghar home loans are concessional and collateral-free up to set limits.
  finance: { rate: 0.07, years: 7 }
};

// Values saved in the admin panel (/manage/ > Calculator) override the defaults above.
(function (c, o) {
  if (!o) return;
  ['generationPerKwPerDay', 'surplusExportRate', 'tariffEscalation', 'costRange'].forEach(function (k) {
    if (typeof o[k] === 'number' && isFinite(o[k]) && o[k] >= 0) c[k] = o[k];
  });
  if (o.categories) Object.keys(c.categories).forEach(function (k) {
    var src = o.categories[k] || {};
    ['defaultTariff', 'fixedCharges'].forEach(function (f) { if (typeof src[f] === 'number' && src[f] >= 0) c.categories[k][f] = src[f]; });
  });
  if (Array.isArray(o.costPerKw) && o.costPerKw.length === c.costBands.length) {
    o.costPerKw.forEach(function (v, i) { if (typeof v === 'number' && v > 0) c.costBands[i].perKw = v; });
  }
  if (o.subsidy) {
    var s = o.subsidy;
    if (s.centralFirst2 > 0) c.subsidy.central[0].perKw = s.centralFirst2;
    if (s.centralThird >= 0) c.subsidy.central[1].perKw = s.centralThird;
    if (s.centralCap > 0) c.subsidy.centralCap = s.centralCap;
    if (s.statePerKw >= 0) c.subsidy.state.perKw = s.statePerKw;
    if (s.stateCap >= 0) c.subsidy.state.cap = s.stateCap;
  }
})(window.SOLAR_CONFIG, window.SOLAR_OVERRIDES);
