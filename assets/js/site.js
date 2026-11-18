/* Greenedge Infratech - shared site behaviour */
(function () {
  'use strict';

  function track(name, params) {
    try {
      window.dataLayer = window.dataLayer || [];
      window.dataLayer.push(Object.assign({ event: name }, params || {}));
      if (typeof window.gtag === 'function') window.gtag('event', name, params || {});
      if (name === 'generate_lead' && typeof window.fbq === 'function') window.fbq('track', 'Lead', { content_category: (params || {}).category || '' });
    } catch (e) { /* ignore */ }
  }
  window.geTrack = window.geTrack || track;

  // Remember campaign parameters for the whole visit
  try {
    var qs = new URLSearchParams(location.search);
    ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid'].forEach(function (k) {
      if (qs.get(k)) sessionStorage.setItem('ge_' + k, qs.get(k).slice(0, 200));
    });
    if (!sessionStorage.getItem('ge_referrer') && document.referrer && document.referrer.indexOf(location.host) === -1) {
      sessionStorage.setItem('ge_referrer', document.referrer.slice(0, 300));
    }
  } catch (e) { /* storage may be blocked */ }

  document.addEventListener('DOMContentLoaded', function () {
    // Mobile menu
    var t = document.getElementById('menu-toggle'), m = document.getElementById('mobile-menu');
    if (t && m) t.addEventListener('click', function () {
      var open = m.classList.toggle('hidden') === false;
      t.setAttribute('aria-expanded', open ? 'true' : 'false');
    });

    // Click tracking for calls, WhatsApp and CTAs
    document.addEventListener('click', function (e) {
      var a = e.target.closest && e.target.closest('[data-track]');
      if (a) track(a.getAttribute('data-track'), { page: location.pathname });
    });

    // Pre-select enquiry type from ?type=
    try {
      var want = new URLSearchParams(location.search).get('type');
      if (want) {
        var r = document.querySelector('.lead-form input[name="enquiry_type"][value="' + want.replace(/[^a-z-]/g, '') + '"]');
        if (r) r.checked = true;
      }
    } catch (e) { /* ignore */ }

    Array.prototype.forEach.call(document.querySelectorAll('.lead-form'), function (form) {
      var startedAt = 0;
      form.addEventListener('focusin', function () { if (!startedAt) { startedAt = Date.now(); form.elements.ts.value = String(startedAt); } });
      var status = form.querySelector('.form-status');
      function show(ok, msg) {
        status.textContent = msg;
        status.className = 'form-status text-sm rounded-md p-3 ' + (ok ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200');
      }
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        var phone = (form.elements.phone.value || '').replace(/\D/g, '').replace(/^(91|0)(?=\d{10}$)/, '');
        if ((form.elements.name.value || '').trim().length < 2) return show(false, 'Please enter your name.');
        if (!/^[6-9]\d{9}$/.test(phone)) return show(false, 'Please enter a valid 10-digit mobile number.');
        if ((form.elements.city.value || '').trim().length < 2) return show(false, 'Please enter your city or locality.');
        if (!form.elements.consent.checked) return show(false, 'Please tick the consent box so we can contact you.');

        var data = {};
        new FormData(form).forEach(function (v, k) { data[k] = v; });
        data.phone = phone;
        if (data.calc_summary) data.enquiry_type = data.enquiry_type || 'calculator';
        if (data.calc_summary && data.enquiry_type === 'callback') data.enquiry_type = 'calculator';
        data.source_page = location.pathname + location.search.replace(/([?&])(name|phone|email)=[^&]*/g, '');
        try {
          ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'referrer'].forEach(function (k) {
            var v = sessionStorage.getItem('ge_' + k); if (v) data[k] = v;
          });
        } catch (err) { /* ignore */ }

        var btn = form.querySelector('button[type="submit"]');
        var label = btn.textContent;
        btn.disabled = true; btn.textContent = 'Sending…';
        fetch('/api/lead.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
          body: JSON.stringify(data),
          credentials: 'same-origin'
        }).then(function (r) {
          return r.json().catch(function () { return { ok: false, message: 'Unexpected response.' }; }).then(function (j) { j.status = r.status; return j; });
        }).then(function (j) {
          if (j.ok) {
            show(true, j.message);
            track('generate_lead', { enquiry_type: data.enquiry_type, category: data.category, page: location.pathname });
            form.dispatchEvent(new CustomEvent('ge:lead-success', { bubbles: true, detail: data }));
            form.reset();
          } else {
            show(false, j.message || 'Sorry, that did not go through. Please call us on +91 98370 67681.');
          }
        }).catch(function () {
          show(false, 'Network problem. Please try again, or call / WhatsApp +91 98370 67681.');
        }).then(function () { btn.disabled = false; btn.textContent = label; });
      });
    });
  });
})();
