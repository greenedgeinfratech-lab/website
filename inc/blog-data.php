<?php
require_once __DIR__ . '/config.php';
/** Blog articles (migrated from the previous site and fact-checked, Nov 2026). Old numeric id kept for redirects. */
$GE_BLOG_DEFAULTS = [
  'pm-surya-ghar-yojana-subsidy-uttar-pradesh' => [
    'old_id' => 1,
    'title' => 'PM Surya Ghar Yojana: Solar Subsidy in Uttar Pradesh Explained',
    'description' => 'How much subsidy UP homes get under PM Surya Ghar (central + UPNEDA), who is eligible and the step-by-step process to apply.',
    'date' => '2025-09-02', 'updated' => '2026-11-15',
    'image' => '/uploads/1756835849_about-bg.png',
    'body' => <<<'TXT'
PM Surya Ghar: Muft Bijli Yojana, launched in 2024, helps households install grid-connected rooftop solar with a direct subsidy from the Government of India. Its aim is to let homes generate up to 300 units of electricity a month from their own roofs.

## Subsidy for homes in Uttar Pradesh

UP homes can combine the central subsidy with the UP state subsidy given through UPNEDA:

- 1 kW: about ₹30,000 central + ₹15,000 state = ₹45,000
- 2 kW: about ₹60,000 central + ₹30,000 state = ₹90,000
- 3 kW and above: ₹78,000 central + ₹30,000 state = ₹1,08,000

The central amount does not increase beyond 3 kW, and the state subsidy is capped at ₹30,000 per consumer. Subsidy is approved and paid by the government after inspection, subject to eligibility and the funds available.

## Main benefits

- Lower electricity bills: a correctly sized system can bring energy charges close to zero.
- Net metering: units you export are adjusted against units you import.
- Long life: panels typically carry 25-year output warranties from the manufacturer.
- Concessional bank loans are available under the scheme.

## How to apply

1. Register on the National Portal, pmsuryaghar.gov.in.
2. Apply for rooftop solar and get feasibility approval from your DISCOM.
3. Choose a registered vendor and get a written quotation.
4. Install the system and apply for net metering.
5. After inspection and commissioning, submit bank details; the subsidy is credited to your account.

Read our full [PM Surya Ghar guide for Aligarh and UP](/pmsuryaghar/), or [calculate your savings](/calculator?cat=residential).
TXT,
    'format' => 'text'],

  'solar-panel-myths' => [
    'old_id' => 2,
    'title' => 'Top 5 Solar Panel Myths Busted',
    'description' => 'Do solar panels work in clouds? Are they too expensive? Five common myths about rooftop solar, answered for homes in UP.',
    'date' => '2025-09-04', 'updated' => '2026-11-15',
    'image' => '/uploads/1756969736_commercial.jpg',
    'body' => <<<'TXT'
## Myth 1: Solar panels don’t work in cloudy or cold weather

Panels generate from light, not heat. On cloudy days output drops, but they still produce from diffused light. In fact panels are slightly more efficient when they are cooler.

## Myth 2: Solar is too expensive

With PM Surya Ghar central subsidy and the UP state subsidy, eligible homes can recover their investment in a few years from lower bills. Use our [calculator](/calculator) to see the payback for your own bill.

## Myth 3: Solar needs a lot of maintenance

There are no moving parts. Regular cleaning with plain water, especially in dusty months, and an occasional electrical check are usually enough.

## Myth 4: Panels will damage my roof

A properly designed structure is anchored without harming waterproofing, and the panels shade the roof from direct sun and rain.

## Myth 5: Solar isn’t reliable

Modern panels convert over 20% of sunlight into electricity and carry long output warranties. With the right size, inverter and net metering, a rooftop system can cover most of a household’s daytime and yearly needs.
TXT,
    'format' => 'text'],

  'cleaning-solar-panels' => [
    'old_id' => 3,
    'title' => 'Why Cleaning Solar Panels Matters in Aligarh’s Dusty Climate',
    'description' => 'Dust can noticeably cut solar output in Western UP. How often to clean rooftop solar panels and how to do it safely.',
    'date' => '2025-09-04', 'updated' => '2026-11-15',
    'image' => '/uploads/1756969845_hero-solar.jpg',
    'body' => <<<'TXT'
As more homes and businesses in Aligarh install rooftop solar, keeping panels clean is the simplest way to protect your generation and savings.

## Why cleaning matters

- **More output:** dust, bird droppings and pollution block light. In dry, dusty months the loss can be significant if panels are left uncleaned for weeks.
- **Longer life:** removing grime early prevents permanent stains and hot spots.
- **Better return:** clean panels mean more units and faster payback.

## How often and how

In Aligarh and northern India, clean at least twice a month in dry seasons and after dust storms; rain helps during the monsoon. Use clean water and a soft sponge or mop, early in the morning or in the evening when panels are cool. Avoid detergents, hard brushes and pressure washers, and never stand on the panels.

Greenedge offers [maintenance and cleaning plans](/services) for homes and businesses.
TXT,
    'format' => 'text'],

  'solar-for-housing-societies-pm-surya-ghar' => [
    'old_id' => 4,
    'title' => 'Solar for Residential Societies and RWAs under PM Surya Ghar',
    'description' => 'How housing societies and RWAs can use rooftop solar to cut common-area electricity bills, and the subsidy available for common facilities.',
    'date' => '2025-10-20', 'updated' => '2026-11-15',
    'image' => '/uploads/1760964311_Housing-society-solar-system.png',
    'body' => <<<'TXT'
PM Surya Ghar: Muft Bijli Yojana also covers Group Housing Societies and Residential Welfare Associations (GHS/RWA) for solar systems that power common facilities.

## Why societies benefit

Lifts, water pumps, street lights, security cabins and clubhouses use a lot of daytime electricity. A rooftop plant on common roofs can:

- cut common-area electricity bills substantially,
- reduce maintenance charges for residents,
- support green-building and sustainability goals.

## Subsidy for societies

For GHS/RWA common facilities, central assistance is ₹18,000 per kW, for capacity up to 500 kW (calculated at up to 3 kW per house), as per MNRE guidelines. Check the current rules on the National Portal before applying.

Greenedge designs and installs society systems across Western UP, including DISCOM net-metering work. [Request a site survey](/contact?type=site-survey).
TXT,
    'format' => 'text'],

  'solar-system-size-hindi' => [
    'old_id' => 5,
    'title' => 'मेरी बिजली खपत के हिसाब से सोलर सिस्टम कितना होना चाहिए?',
    'description' => 'कितने kW का सोलर लगवाएँ? बिजली बिल, दिन-रात की खपत और भविष्य के लोड से सही साइज़ कैसे तय करें।',
    'date' => '2026-02-14', 'updated' => '2026-11-15',
    'image' => '/uploads/1771066660_Sahi System.png',
    'lang' => 'hi',
    'body' => <<<'TXT'
अक्सर लोग पूछते हैं — “कितने kW का सोलर लगवाएँ?” इसका सही जवाब आपकी बिजली खपत (लोड प्रोफाइल) में छुपा होता है, सिर्फ़ छत के साइज़ में नहीं।

## सोलर सिस्टम का साइज़ तय करने के 3 ज़रूरी आधार

1. पिछले 12 महीनों का बिजली बिल — औसत मासिक यूनिट से सही kW का अनुमान।
2. दिन और रात की बिजली खपत का पैटर्न।
3. भविष्य के लोड — AC, कूलर, मोटर, EV चार्जर।

पश्चिमी उत्तर प्रदेश में 1 kW सोलर सिस्टम साल भर में औसतन लगभग 120–135 यूनिट प्रति माह बनाता है। यानी 400 यूनिट महीने की खपत वाले घर के लिए लगभग 3–3.5 kW सही रहता है।

## गलत kW चुनने से नुकसान

- कम kW: पूरी खपत कवर नहीं होगी, बिल फिर भी आएगा।
- ज़्यादा kW: बेवजह ज़्यादा निवेश, और अतिरिक्त यूनिट कम दर पर एडजस्ट होती हैं।

Greenedge की सलाह: सोलर सिस्टम छत देखकर नहीं, बिजली खपत समझकर लगवाना चाहिए। अपना अनुमान देखने के लिए हमारा [सोलर कैलकुलेटर](/calculator) इस्तेमाल करें या [फ्री साइट सर्वे](/contact?type=site-survey) बुक करें।
TXT,
    'format' => 'text'],
];

$__b = ge_load_json('blogs', []);
return $__b ?: $GE_BLOG_DEFAULTS;
