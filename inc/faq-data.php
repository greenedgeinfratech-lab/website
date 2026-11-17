<?php
require_once __DIR__ . '/config.php';
/** FAQ groups: [group => [[question, answer], ...]]. Edited in /manage/ (saved to private_content/faqs.json). */
$GE_FAQ_DEFAULTS = [
 'Cost & savings' => [
  ['How much does rooftop solar cost?', 'For on-grid home systems, a typical budget is about ₹55,000–65,000 per kW including GST before subsidy. Larger commercial and industrial plants cost less per kW. Hybrid systems with batteries cost more. Your site survey gives an exact quotation.'],
  ['How much will I save?', 'Many homes reduce their bill by 70–80% or more with a correctly sized system. Fixed charges stay on the bill. Try the [calculator](/calculator) with your own bill.'],
  ['What is the payback period?', 'For eligible homes with PM Surya Ghar subsidy it is often 3–5 years; for businesses with daytime use it is commonly 3–5 years as well. It depends on your tariff and usage.'],
 ],
 'Subsidy & approvals' => [
  ['How much subsidy can I get?', 'Eligible homes get central subsidy of ₹30,000 for 1 kW, ₹60,000 for 2 kW and ₹78,000 for 3 kW or more under PM Surya Ghar. Some states add their own subsidy on top. See our [PM Surya Ghar guide](/pmsuryaghar/).'],
  ['Can shops or factories get the subsidy?', 'No. PM Surya Ghar subsidy is only for residential consumers (and housing societies for common areas). Businesses may get tax benefits such as depreciation – ask your CA.'],
  ['What is net metering?', 'A two-way meter records units you import from and export to the grid. Exported units are adjusted against imported units in your bill. Any annual surplus is settled at a lower rate set by the regulator.'],
 ],
 'Technical' => [
  ['How much roof space do I need?', 'About 100 sq ft of shadow-free roof per kW.'],
  ['How many units does 1 kW produce?', 'In most of India, about 4–5 units a day on average across the year, roughly 120–150 units a month. Sunny months produce more; cloudy, monsoon and foggy months less.'],
  ['Will solar run during a power cut?', 'A standard on-grid system switches off during outages for safety. If you need backup, choose a hybrid system with batteries.'],
  ['Mono PERC or TOPCon panels?', 'Both are reliable. TOPCon panels are a newer technology with slightly higher efficiency and better performance in heat, useful when roof space is limited. Mono PERC is often more economical.'],
 ],
 'Maintenance & warranty' => [
  ['How do I clean the panels?', 'Rinse with clean water and a soft mop, early morning or evening, about twice a month in dusty seasons. Avoid detergent, hard brushes and walking on the panels.'],
  ['What warranties come with the system?', 'Panel and inverter warranties are given by their manufacturers (panels usually 25–30 years on power output). Installation workmanship terms are written in your Greenedge quotation.'],
 ],
];
$__f = ge_load_json('faqs', []);
return $__f ?: $GE_FAQ_DEFAULTS;
