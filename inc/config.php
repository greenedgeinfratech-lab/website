<?php
/** Site-wide business details. Change them here once; every page uses these. */
const SITE_URL          = 'https://greenedgeinfratech.com';
const SITE_HOSTS        = ['greenedgeinfratech.com', 'www.greenedgeinfratech.com'];
const BIZ_NAME          = 'Greenedge Infratech Private Limited';
const BIZ_SHORT         = 'Greenedge Infratech';
const BIZ_PHONE         = '+919837067681';
const BIZ_PHONE_DISPLAY = '+91 98370 67681';
const BIZ_WHATSAPP      = '919837067681';
const BIZ_EMAIL         = 'greenedgeinfratech@gmail.com';
const BIZ_STREET        = 'Opp. BJP Office, Kayampur, Quarsi Bypass';
const BIZ_CITY          = 'Aligarh';
const BIZ_REGION        = 'Uttar Pradesh';
const BIZ_PIN           = '202001';
const BIZ_HOURS         = 'Monday to Saturday, 9:00 AM to 6:00 PM';
const BIZ_SINCE         = 2016;
const BIZ_INSTALLS      = '200+';
const BIZ_PMSG_VENDOR   = 'Registered vendor under PM Surya Ghar: Muft Bijli Yojana, Uttar Pradesh';
const BIZ_SERVICE_AREA  = ['Aligarh', 'Hathras', 'Kasganj', 'Etah', 'Bulandshahr', 'Mathura'];

// Lead delivery (email only for now; WhatsApp/CRM to be added later)
const LEAD_EMAIL_TO  = 'greenedgeinfratech@gmail.com';
const MAIL_FROM      = 'noreply@greenedgeinfratech.com';
const MAIL_FROM_NAME = 'Greenedge Website';

// Google Ads tag already used on the site
const GOOGLE_TAG_ID = 'AW-11515555005';

date_default_timezone_set('Asia/Kolkata');

function e(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function wa_link(string $text): string { return 'https://wa.me/' . BIZ_WHATSAPP . '?text=' . rawurlencode($text); }
