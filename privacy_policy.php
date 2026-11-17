<?php
require __DIR__ . '/inc/config.php';
$page = [
    'title' => 'Privacy Policy | Greenedge Infratech',
    'description' => 'How Greenedge Infratech Private Limited collects, uses and protects personal information shared through greenedgeinfratech.com.',
    'path' => '/privacy_policy',
    'crumbs' => [['Privacy policy', '/privacy_policy']],
];
include __DIR__ . '/inc/header.php';
?>
<article class="container mx-auto px-4 py-12 max-w-3xl prose-lite">
  <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Privacy policy</h1>
  <p><?= e(BIZ_NAME) ?> (&ldquo;Greenedge&rdquo;, &ldquo;we&rdquo;) operates greenedgeinfratech.com. This page explains what personal information we collect through the website, how we use it and the choices you have.</p>

  <h2>Information we collect</h2>
  <ul>
    <li><strong>Information you give us</strong> in enquiry, calculator, partner and career forms: such as your name, mobile number, email, city or locality, organisation, your requirement and calculator inputs (bill, units, system size).</li>
    <li><strong>Log data</strong> your browser sends when you visit: IP address, browser type, pages visited, time and date, and similar statistics.</li>
    <li><strong>Campaign information</strong> such as the advertisement or link that brought you to the site.</li>
  </ul>

  <h2>How we use it</h2>
  <ul>
    <li>To respond to your enquiry by call, WhatsApp or email, prepare a quotation, and provide our services</li>
    <li>To process partner and job applications</li>
    <li>To improve our website and understand which pages and campaigns are useful</li>
    <li>To meet legal and regulatory requirements</li>
  </ul>
  <p>We do not sell your personal information.</p>

  <h2>Cookies and analytics</h2>
  <p>The website uses cookies and similar technologies, including Google tags, to measure visits and the performance of our advertising. You can refuse or delete cookies in your browser settings; some features may not work as intended.</p>

  <h2>Service providers</h2>
  <p>We may use trusted third parties to host the website, deliver email, and analyse website use. They may access personal information only to perform these tasks for us and must not use it for any other purpose.</p>

  <h2>Storage and security</h2>
  <p>Enquiries are stored in a protected location on our hosting server that is not accessible from the web, and are emailed to our sales team. We use reasonable measures to protect your information, but no method of transmission or storage over the internet is completely secure.</p>

  <h2>Your choices</h2>
  <p>You can ask us to access, correct or delete the personal information you have shared, or to stop contacting you, by writing to <a href="mailto:<?= BIZ_EMAIL ?>"><?= BIZ_EMAIL ?></a> or calling <?= BIZ_PHONE_DISPLAY ?>.</p>

  <h2>Links to other sites</h2>
  <p>Our pages link to government and other websites that we do not control. Please review their privacy policies.</p>

  <h2>Children</h2>
  <p>Our services are not directed at children under 13, and we do not knowingly collect their personal information. If you believe a child has shared information with us, contact us and we will delete it.</p>

  <h2>Changes</h2>
  <p>We may update this policy from time to time. Changes take effect when posted on this page.</p>

  <h2>Contact</h2>
  <p><?= e(BIZ_NAME) ?>, <?= e(BIZ_STREET) ?>, <?= e(BIZ_CITY) ?>, <?= e(BIZ_REGION) ?> <?= e(BIZ_PIN) ?>. Email: <a href="mailto:<?= BIZ_EMAIL ?>"><?= BIZ_EMAIL ?></a>.</p>
  <p class="text-sm text-slate-500">Last updated: November 2026.</p>
</article>
<?php include __DIR__ . '/inc/footer.php'; ?>
