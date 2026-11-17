<?php
/**
 * Reusable enquiry form. Optional before including:
 * $lf = ['type'=>'quotation', 'category'=>'residential', 'heading'=>'...', 'sub'=>'...', 'message'=>true,
 *        'button'=>'...', 'business'=>true (asks organisation + monthly bill), 'partner'=>true (partner application)]
 */
require_once __DIR__ . '/config.php';
$lf = $lf ?? [];
$lfType = $lf['type'] ?? 'contact';
$lfCat  = $lf['category'] ?? 'residential';
$lfId   = $lf['id'] ?? 'lead-form';
$lfPartner = !empty($lf['partner']);
$lfCats = [
    'residential'     => 'Home (residential)',
    'pm-surya-ghar'   => 'Home with PM Surya Ghar subsidy',
    'housing-society' => 'Housing society / RWA',
    'commercial'      => 'Commercial / institution',
    'industrial'      => 'Industrial / factory',
    'government'      => 'Government / PSU / public body',
    'agriculture'     => 'Farm / solar pump / PM-KUSUM',
    'other'           => 'Other',
];
?>
<form id="<?= e($lfId) ?>" class="lead-form card p-6 sm:p-8 space-y-4" novalidate>
  <div>
    <h2 class="text-2xl font-bold text-slate-900"><?= e($lf['heading'] ?? 'Get your free solar consultation') ?></h2>
    <p class="text-slate-600 mt-1 text-sm"><?= e($lf['sub'] ?? 'Share your details and a Greenedge solar expert will call you within one working day.') ?></p>
  </div>
  <div class="grid sm:grid-cols-2 gap-4">
    <label class="block"><span class="label">Full name *</span>
      <input name="name" type="text" autocomplete="name" required maxlength="80" class="input" placeholder="Your name"></label>
    <label class="block"><span class="label">Mobile number *</span>
      <input name="phone" type="tel" inputmode="numeric" autocomplete="tel-national" required maxlength="14" pattern="[0-9+\s-]{10,14}" class="input" placeholder="10-digit mobile"></label>
    <label class="block"><span class="label">City / locality *</span>
      <input name="city" type="text" autocomplete="address-level2" required maxlength="80" class="input" placeholder="e.g. Aligarh, Ramghat Road"></label>
    <?php if ($lfPartner): ?>
    <input type="hidden" name="category" value="other">
    <label class="block"><span class="label">I want to join as *</span>
      <select name="partner_type" class="input" required>
        <?php foreach (['Channel partner / dealer', 'Installer / EPC sub-contractor', 'Referral partner (architect, electrician, consultant)', 'Investor / RESCO finance partner', 'Supplier / manufacturer', 'Other'] as $o): ?><option><?= e($o) ?></option><?php endforeach; ?>
      </select></label>
    <label class="block"><span class="label">Firm / business name</span>
      <input name="company" type="text" autocomplete="organization" maxlength="120" class="input" placeholder="Optional"></label>
    <?php else: ?>
    <label class="block"><span class="label">I am enquiring for</span>
      <select name="category" class="input">
        <?php foreach ($lfCats as $v => $t): ?><option value="<?= $v ?>" <?= $lfCat === $v ? 'selected' : '' ?>><?= e($t) ?></option><?php endforeach; ?>
      </select></label>
    <?php if (!empty($lf['business'])): ?>
    <label class="block"><span class="label">Organisation name</span>
      <input name="company" type="text" autocomplete="organization" maxlength="120" class="input" placeholder="Company, school, society…"></label>
    <?php endif; ?>
    <?php endif; ?>
    <label class="block <?= ($lfPartner || !empty($lf['business'])) ? '' : 'sm:col-span-2' ?>"><span class="label"><?= e($lf['email_label'] ?? 'Email (optional)') ?></span>
      <input name="email" type="email" autocomplete="email" maxlength="120" class="input" placeholder="you@example.com"></label>
    <?php if (!empty($lf['message']) || $lfPartner): ?>
    <label class="block sm:col-span-2"><span class="label"><?= $lfPartner ? 'Tell us about your experience (optional)' : 'Your requirement (optional)' ?></span>
      <textarea name="message" rows="3" maxlength="1500" class="input h-auto py-2" placeholder="<?= $lfPartner ? 'Years in business, area you cover, team size, projects done' : 'Monthly bill, roof type, sanctioned load, anything we should know' ?>"></textarea></label>
    <?php endif; ?>
  </div>
  <?php if (!empty($lf['hide_type']) || $lfPartner): ?>
  <input type="hidden" name="enquiry_type" value="<?= $lfPartner ? 'partner' : e($lfType) ?>">
  <?php else: ?>
  <fieldset>
    <legend class="label">I would like</legend>
    <div class="flex flex-wrap gap-2 mt-1">
      <?php foreach (['site-survey' => 'Free site survey', 'quotation' => 'Solar quotation / proposal', 'callback' => 'Call from a solar expert'] as $v => $t): ?>
      <label class="chip"><input type="radio" name="enquiry_type" value="<?= $v ?>" <?= ($lfType === $v || ($lfType === 'calculator' && $v === 'quotation') || ($lfType === 'contact' && $v === 'callback')) ? 'checked' : '' ?>> <?= $t ?></label>
      <?php endforeach; ?>
    </div>
  </fieldset>
  <?php endif; ?>
  <label class="flex items-start gap-2 text-sm text-slate-600">
    <input type="checkbox" name="consent" value="1" required class="mt-1 w-4 h-4 accent-green-700">
    <span>I agree that Greenedge Infratech may call, WhatsApp or email me about my enquiry. See our <a href="/privacy_policy" class="underline">privacy policy</a>.</span>
  </label>
  <div class="hidden" aria-hidden="true"><label>Website <input name="website" type="text" tabindex="-1" autocomplete="off"></label></div>
  <input type="hidden" name="calc_summary" value="">
  <input type="hidden" name="ts" value="">
  <input type="hidden" name="source_type" value="<?= e($lfType) ?>">
  <button type="submit" class="btn-primary w-full text-base py-3"><?= e($lf['button'] ?? 'Request My Free Consultation') ?></button>
  <p class="form-status hidden text-sm rounded-md p-3" role="status" aria-live="polite"></p>
  <p class="text-xs text-slate-500">Prefer to talk now? Call <a href="tel:<?= BIZ_PHONE ?>" class="underline" data-track="phone_click"><?= BIZ_PHONE_DISPLAY ?></a> or <a href="<?= e(wa_link('Hello Greenedge, I have a solar enquiry.')) ?>" target="_blank" rel="noopener" class="underline" data-track="whatsapp_click">WhatsApp us</a>.</p>
</form>
