<?php
/**
 * Custom Form to Request a quote — Massload
 *
 * @package YITH\RequestAQuote
 * @since   1.0.0
 * @author  Massload Technologies
 */

$ywraq_current_user = array();
if (is_user_logged_in()) {
	$ywraq_current_user = get_user_by('id', get_current_user_id());
}

$user_fname = (!empty($ywraq_current_user)) ? $ywraq_current_user->first_name : '';
$user_lname = (!empty($ywraq_current_user)) ? $ywraq_current_user->last_name : '';
$user_mail = (!empty($ywraq_current_user)) ? $ywraq_current_user->user_email : '';
?>

<style>
	/* Quote Cart Table Styling */
	#yith-ywrq-table-list thead th {
		background-color: #000 !important;
		color: #fff !important;
		text-transform: uppercase;
		font-weight: 700;
		border: none;
		padding: 15px;
	}

	#yith-ywrq-table-list .cart_item td {
		vertical-align: middle;
		border-bottom: 1px solid #eee;
		padding: 15px;
	}

	#yith-ywrq-table-list .product-thumbnail img {
		max-width: 80px;
		height: auto;
		border-radius: 4px;
	}

	.ywraq-mail-form-wrapper {
		margin-top: 30px;
	}

	.ywraq-mail-form-wrapper h3 {
		font-size: 24px;
		font-weight: 700;
		margin-bottom: 25px;
		text-transform: uppercase;
	}

	.ywraq-form-grid {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 15px 20px;
	}

	.ywraq-form-grid .form-field {
		display: flex;
		flex-direction: column;
	}

	.ywraq-form-grid .form-field label {
		font-weight: 600;
		font-size: 14px;
		margin-bottom: 5px;
		color: #333;
	}

	.ywraq-form-grid .form-field label abbr {
		color: #e30913;
		text-decoration: none;
	}

	.ywraq-form-grid .form-field input,
	.ywraq-form-grid .form-field select {
		padding: 10px 12px;
		border: 1px solid #ccc;
		border-radius: 4px;
		font-size: 14px;
		transition: border-color 0.2s;
		background: #fff;
		width: 100%;
		box-sizing: border-box;
	}

	.ywraq-form-grid .form-field input:focus,
	.ywraq-form-grid .form-field select:focus {
		border-color: #e30913;
		outline: none;
		box-shadow: 0 0 0 2px rgba(227, 9, 19, 0.1);
	}

	.ywraq-form-full {
		grid-column: 1 / -1;
	}

	.ywraq-checkboxes {
		grid-column: 1 / -1;
		display: flex;
		flex-direction: column;
		gap: 10px;
		margin-top: 5px;
	}

	.ywraq-checkboxes label {
		display: flex;
		align-items: flex-start;
		gap: 8px;
		font-size: 14px;
		color: #555;
		cursor: pointer;
		line-height: 1.4;
	}

	.ywraq-checkboxes input[type="checkbox"] {
		margin-top: 3px;
		width: 16px;
		height: 16px;
		accent-color: #e30913;
		flex-shrink: 0;
	}

	.ywraq-submit-row {
		grid-column: 1 / -1;
		text-align: center;
		margin-top: 15px;
	}

	.ywraq-submit-row .raq-send-request {
		background: #e30913 !important;
		color: #fff !important;
		border: none !important;
		padding: 14px 50px !important;
		font-size: 16px !important;
		font-weight: 700 !important;
		text-transform: uppercase !important;
		letter-spacing: 1px !important;
		border-radius: 4px !important;
		cursor: pointer !important;
		transition: background 0.3s !important;
	}

	.ywraq-submit-row .raq-send-request:hover {
		background: #c00710 !important;
	}

	@media (max-width: 768px) {
		.ywraq-form-grid {
			grid-template-columns: 1fr;
		}
	}
</style>

<div class="yith-ywraq-mail-form-wrapper ywraq-mail-form-wrapper">
	<div class="heading-block text-center mb-4">
		<h2 class="font-weight-normal"><span style="color:#e30913;">Request A</span> Solution</h2>
		<p class="text-center mt-3" style="color:#303030;">Review the products in your Quote Cart above, and fill the
			form below.</br>Our team will review your request and get back to you shortly.</p>
	</div>


	<form id="yith-ywraq-mail-form" name="yith-ywraq-mail-form"
		action="<?php echo esc_url(YITH_Request_Quote()->get_raq_page_url()); ?>" method="post">

		<div class="ywraq-form-grid">

			<!-- First Name -->
			<div class="form-field">
				<label for="rqa-first-name">First Name <abbr class="required" title="required">*</abbr></label>
				<input type="text" name="rqa_name" id="rqa-first-name" value="<?php echo esc_attr($user_fname); ?>"
					required>
			</div>

			<!-- Last Name -->
			<div class="form-field">
				<label for="rqa-last-name">Last Name <abbr class="required" title="required">*</abbr></label>
				<input type="text" name="rqa_last_name" id="rqa-last-name" value="<?php echo esc_attr($user_lname); ?>"
					required>
			</div>

			<!-- Email -->
			<div class="form-field">
				<label for="rqa-email">Email <abbr class="required" title="required">*</abbr></label>
				<input type="email" name="rqa_email" id="rqa-email" value="<?php echo esc_attr($user_mail); ?>"
					required>
			</div>

			<!-- Phone -->
			<div class="form-field">
				<label for="rqa-phone">Phone Number <abbr class="required" title="required">*</abbr></label>
				<input type="tel" name="rqa_phone" id="rqa-phone" required>
			</div>

			<!-- Company -->
			<div class="form-field">
				<label for="rqa-company">Company Name <abbr class="required" title="required">*</abbr></label>
				<input type="text" name="rqa_company" id="rqa-company" required>
			</div>

			<!-- Country -->
			<div class="form-field">
				<label for="rqa-country">Country <abbr class="required" title="required">*</abbr></label>
				<select name="rqa_country" id="rqa-country" required>
					<option value="">— Select Country —</option>
					<?php
					$countries = WC()->countries->get_countries();
					foreach ($countries as $code => $name) {
						echo '<option value="' . esc_attr($name) . '">' . esc_html($name) . '</option>';
					}
					?>
				</select>
			</div>

			<!-- Priority -->
			<div class="form-field">
				<label for="rqa-priority">Please select your priority <abbr class="required"
						title="required">*</abbr></label>
				<select name="rqa_priority" id="rqa-priority" required>
					<option value="">— Select Priority —</option>
					<option value="I need a solution right away">I need a solution right away</option>
					<option value="I need a solution within a month to two">I need a solution within a month to two
					</option>
					<option value="I need a solution within 6 months or more">I need a solution within 6 months or more
					</option>
					<option value="I just need budgetary pricing for now">I just need budgetary pricing for now</option>
				</select>
			</div>

			<!-- How did you hear about us -->
			<div class="form-field">
				<label for="rqa-source">How did you hear about us?</label>
				<select name="rqa_source" id="rqa-source">
					<option value="">— Select —</option>
					<option value="Google Search">Google Search</option>
					<option value="Google Ad">Google Ad</option>
					<option value="Social Media">Social Media</option>
					<option value="LinkedIn">LinkedIn</option>
					<option value="Online Advertising">Online Advertising</option>
					<option value="Thomasnet.com">Thomasnet.com</option>
					<option value="Mfg.com">Mfg.com</option>
					<option value="IQS Directory">IQS Directory</option>
					<option value="Engineering 360">Engineering 360</option>
					<option value="Zycon">Zycon</option>
					<option value="Kompass">Kompass</option>
					<option value="Direct Email">Direct Email</option>
					<option value="Direct Mail">Direct Mail</option>
					<option value="Print Advertising">Print Advertising</option>
					<option value="Referral">Referral</option>
					<option value="Word of mouth">Word of mouth</option>
					<option value="Other">Other</option>
				</select>
			</div>

			<!-- Checkboxes -->
			<div class="ywraq-checkboxes">
				<label>
					<input type="checkbox" name="rqa_send_copy" value="yes">
					Send a copy of this form to my email
				</label>
				<label>
					<input type="checkbox" name="rqa_newsletter" value="yes">
					Yes, I'd like to receive periodic updates from Massload (You can unsubscribe at any time)
				</label>
			</div>

			<!-- Submit -->
			<div class="ywraq-submit-row">
				<input type="hidden" id="raq-mail-wpnonce" name="raq_mail_wpnonce"
					value="<?php echo esc_attr(wp_create_nonce('send-request-quote')); ?>">
				<input class="button raq-send-request" type="submit" value="SUBMIT REQUEST">
			</div>

		</div>

	</form>
</div>