<?php $view->extend('BtcTripMainBundle::layout.html.php') ?>

<?php $view['slots']->set('bodyClass', 'checkout') ?>

<?php $view['slots']->start('stylesheets') ?>
<link href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/checkout-flights.css') ?>" rel="stylesheet">
<link href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/common.css') ?>" rel="stylesheet">
<link href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/checkout.css') ?>" rel="stylesheet">

<?php $view['slots']->stop() ?>

<?php $view['slots']->start('breadcrumb') ?>
   
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('mainContent') ?>


<form method="POST" action="<?php echo $view['router']->generate('btc_trip_checkoutSubmit') ?>" class="form" id="form">

<div class="purchase-form span8 ">
<fieldset class="section form-title">
	<span class="page-title">Last step: Secure your room now!</span>
</fieldset>

<fieldset class="passengers section" id="passengers">
<span class="description">Adult in charge of the room</span>
<div class="fields">

<?php for ($p = 0; $p < $passengersArray['adult']; $p++) {  ?> 
	<div data-type="<?php echo $p; ?>" data-index="<?php echo $p ?>" class="passenger">
	<span class="reference">Room <?php echo $p +1 ?></span>
	<div class="inputs">
	<div class="line-form first">
	<div class="names">
	<div class="item passenger-first-name-container" id="passengerDefinitions[<?php echo $p ?>].firstName.value">
	<label for="passenger-first-name-<?php echo $p ?>" class="custom-label">First Name/s</label>
	<input type="text" data-regex-size="1" data-regex-<?php echo $p ?>-pattern="^.*[a-zA-ZÁÉÍÓÚáéíóúäëïöüÄËÏÖÜÇç????????????????????????ãõ?ÃÕ?ñÑÂâÊêÔôÛûÎî]+.*$" data-regex-0-code="invalid_name" placeholder="As in passport" name="passengerDefinitions[<?php echo $p ?>].firstName.value" id="passenger-first-name-0" class="input checkout-textfield input-passenger-first-name
	required">
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicVisibility("passengerDefinitions[<?php echo $p ?>].firstName.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicExtraData("passengerDefinitions[<?php echo $p ?>].firstName.value", {"events":[],"rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicRegex("passengerDefinitions[<?php echo $p ?>].firstName.value", {"events":[],"rules":[{"regexValidations":[{"regex":"^.*[a-zA-ZÁÉÍÓÚáéíóúäëïöüÄËÏÖÜÇç????????????????????????ãõ?ÃÕ?ñÑÂâÊêÔôÛûÎî]+.*$","errorCode":"INVALID_NAME"}],"dependencies":[]}]});
	});
	</script>
	<span class="commonSprite errorCrossIcon icon-error"></span>
	<span class="error-message error-field_empty-message" id="passenger-first-name-<?php echo $p ?>-field_empty">
	Please, input the first name of the passenger.
	</span>
	<span class="error-message error-invalid_name-message" id="passenger-first-name-<?php echo $p ?>-invalid_name">
	Please, check that first name of the passenger only contains letters.
	</span>
	<span class="error-message error-invalid_length-message" id="passenger-first-name-<?php echo $p ?>-invalid_length">
	The first name must be less than 58 characters.
	</span>
	</div>
	<div class="item passenger-last-name-container" id="passengerDefinitions[<?php echo $p ?>].lastName.value">
	<label for="passenger-last-name-<?php echo $p ?>" class="custom-label">Last Name/s</label>
	<input type="text" data-regex-size="1" data-regex-0-pattern="^.*[a-zA-ZÁÉÍÓÚáéíóúäëïöüÄËÏÖÜÇç????????????????????????ãõ?ÃÕ?ñÑÂâÊêÔôÛûÎî]+.*$" data-regex-0-code="invalid_name" placeholder="As in passport" name="passengerDefinitions[<?php echo $p ?>].lastName.value" id="passenger-last-name-0" class="input checkout-textfield input-passenger-last-name
	required">
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicVisibility("passengerDefinitions[<?php echo $p ?>].lastName.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicExtraData("passengerDefinitions[<?php echo $p ?>].lastName.value", {"events":[],"rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicRegex("passengerDefinitions[<?php echo $p ?>].lastName.value", {"events":[],"rules":[{"regexValidations":[{"regex":"^.*[a-zA-ZÁÉÍÓÚáéíóúäëïöüÄËÏÖÜÇç????????????????????????ãõ?ÃÕ?ñÑÂâÊêÔôÛûÎî]+.*$","errorCode":"INVALID_NAME"}],"dependencies":[]}]});
	});
	</script>
	<span class="commonSprite errorCrossIcon icon-error"></span>
	<span class="error-message error-field_empty-message" id="passenger-last-name-<?php echo $p ?>-field_empty">
	Please, input the last name of the passenger.
	</span>
	<span class="error-message error-invalid_name-message" id="passenger-last-name-<?php echo $p ?>-invalid_name">
	Please, check that last name of the passenger only contains letters.
	</span>
	<span class="error-message error-invalid_length-message" id="passenger-last-name-<?php echo $p ?>-invalid_length">
	The last name must be less than 58 characters.
	</span>
	</div>
	</div>
	<div class="names-length-error " id="names-length-error-<?php echo $p ?>">
	<p class="paragraph">
	First name + last name contain more than 58 characters, allowed by the airlines. You can take following steps to reduce:
	</p>
	<ul class="tips">
	<li class="tip">
	Stripping your first / last name of words like "de" and "los"
	</li>
	<li class="tip">
	Reducing first and last names, beginning with the last in order
	</li>
	</ul>
	</div>
	<span class="equal-names-error error-message" id="equal-names-error-<?php echo $p ?>">Unfortunately, you can't buy a ticket for two passengers under same name. Either change the last name or make separate purchases</span>
	</div>

	
	<div class="clear"></div>
	
	</div>
	</div>
	<input type="hidden" name="passengerDefinitions[<?php echo $p ?>].type" value="<?php echo strtoupper($p) ?>" />
<?php }   // fin ciclo por pasajero  ?>
</div>
</fieldset>
    
    
    
<fieldset class="supported-operation section hidden" id="supportedOperation.value">
<div class="item supported-operation-container
" id="supportedOperation.value">
<select name="supportedOperation.value" id="supported-operation" class="input checkout-select select-supported-operation
required">
<option value="RESERVATION">RESERVATION</option>
<option selected="" value="PURCHASE">PURCHASE</option>
</select>
<span class="commonSprite errorCrossIcon icon-error"></span>
<span class="error-message error-reservation_not_available-message
" id="supported-operation-reservation_not_available">You can't use the button CAC. Please, make a new purchase</span>
<span class="error-message error-reservation_not_supported_by_prov-message
" id="supported-operation-reservation_not_supported_by_prov">The operation couldn't be done with your airline of choice.</span>
</div>
</fieldset>


<script type="text/x-handlebars-template" id="popup-fast-checkout-template">
&lt;div id="{{id}}" class="checkout-popup"&gt;
&lt;div class="popup-container"&gt;
&lt;div class="popup-content"&gt;
&lt;ul class="options"&gt;
{{#_each $data}}
{{#compare ../dataType "names"}}
&lt;li class="item" data-index="{{_data.index}}" data-passenger-type="{{../../passengerType}}" data-passenger-index="{{../../passengerIndex}}" data-type="names"&gt;
{{#compare ../../highlight "name"}}
&lt;span class="bold"&gt;{{data.name}}&lt;/span&gt;
{{else}}
{{data.name}}
{{/compare}}
{{#compare ../../highlight "surname"}}
&lt;span class="bold"&gt;{{data.surname}}&lt;/span&gt;
{{else}}
{{data.surname}}
{{/compare}}
&lt;/li&gt;
{{/compare}}
{{#compare ../dataType "emails"}}
&lt;li class="item" data-index="{{_data.index}}" data-type="emails"&gt;
{{data}}
&lt;/li&gt;
{{/compare}}
{{#compare ../dataType "phones"}}
&lt;li class="item" data-index="{{_data.index}}" data-type="phones"&gt;
{{data.countryCode}} {{data.areaCode}} {{data.number}}
&lt;/li&gt;
{{/compare}}
{{/_each}}
&lt;/ul&gt;
&lt;/div&gt;
{{#unless hideIndicator}}
&lt;span class="popup-arrow popup-arrow-{{indicatorPosition}} arrow-border"&gt;&lt;/span&gt;
&lt;span class="popup-arrow popup-arrow-{{indicatorPosition}}"&gt;&lt;/span&gt;
{{/unless}}
&lt;/div&gt;
&lt;/div&gt;
</script>
<fieldset class="supported-operation section hidden" id="supportedOperation.value">
<div class="item supported-operation-container
" id="supportedOperation.value">
<select name="supportedOperation.value" id="supported-operation" class="input checkout-select select-supported-operation
required">
<option value="RESERVATION">RESERVATION</option>
<option selected="" value="PURCHASE">PURCHASE</option>
</select>
<script type="text/javascript">
$(function(){
CheckoutHotels.Checkout.Modules.Form.registerDynamicExtraData("supportedOperation.value", {"events":[],"rules":[]});
});
</script>
<script type="text/javascript">
$(function(){
CheckoutHotels.Checkout.Modules.Form.registerDynamicContent("supportedOperation.value", {"events":[],"defaultProvider":"5d7eb336-183b-452e-9124-b08221549be0","rules":[]});
});
</script>
<script type="text/javascript">
$(function(){
var name = "supportedOperation.value";
$('[name="'+name+'"]').change(function(e) {
amplify.publish(name);
});
});
</script>
<span class="commonSprite errorCrossIcon icon-error"></span>
<span class="error-message error-reservation_not_available-message
" id="supported-operation-reservation_not_available">You can't use the button CAC. Please, make a new purchase</span>
<span class="error-message error-reservation_not_supported_by_prov-message
" id="supported-operation-reservation_not_supported_by_prov">The operation couldn't be done with your airline of choice.</span>
</div>
</fieldset>


<div id="contactDefinition">
<fieldset class="contact section" id="contact">
<span class="description">Contact Information</span>
<div class="content">
<div class="line-form contact-full-name">
<div class="item contact-full-name-container hidden" id="contactDefinition.contactFullName.value">
<label for="contact-contact-full-name" class="custom-label">Contact's name</label>
<input type="text" autocomplete="off" data-regex-size="0" placeholder="As in passport" name="contactDefinition.contactFullName.value" id="contact-contact-full-name" class="input checkout-textfield input-contact-full-name required">
<script type="text/javascript">
$(function(){
CheckoutHotels.Checkout.Modules.Form.registerDynamicVisibility("contactDefinition.contactFullName.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
});
</script>
<script type="text/javascript">
$(function(){
CheckoutHotels.Checkout.Modules.Form.registerDynamicExtraData("contactDefinition.contactFullName.value", {"events":[],"rules":[]});
});
</script>
<span class="commonSprite errorCrossIcon icon-error"></span>
</div>
</div>
<div class="emails">
<div class="line-form first">
<label for="contact-email" class="custom-label email-label">E-mail (where you will receive your <a class="ticket" href="#">voucher</a>)</label>
<div class="item email-container" id="contactDefinition.email.value">
<input type="text" data-regex-size="2" data-regex-1-pattern="^[\w\.-]+@([\w-]+\.)+[\w-]{2,12}$" data-regex-1-code="invalid_email" data-regex-0-pattern="^.{0,100}$" data-regex-0-code="invalid_length" placeholder="" name="contactDefinition.email.value" id="contact-email" class="input checkout-textfield input-email required">
<script type="text/javascript">
$(function(){
CheckoutHotels.Checkout.Modules.Form.registerDynamicVisibility("contactDefinition.email.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
});
</script>
<script type="text/javascript">
$(function(){
CheckoutHotels.Checkout.Modules.Form.registerDynamicExtraData("contactDefinition.email.value", {"events":[],"rules":[]});
});
</script>
<script type="text/javascript">
$(function(){
CheckoutHotels.Checkout.Modules.Form.registerDynamicRegex("contactDefinition.email.value", {"events":[],"rules":[{"regexValidations":[{"regex":"^.{0,100}$","errorCode":"INVALID_LENGTH"},{"regex":"^[\\w\\.-]+@([\\w-]+\\.)+[\\w-]{2,4}$","errorCode":"INVALID_EMAIL"}],"dependencies":[]}]});
});
</script>
<span class="commonSprite errorCrossIcon icon-error"></span>
<span class="error-message error-field_empty-message" id="contact-email-field_empty">
Please, complete your e-mail where we'll send your e-ticket.
</span>
<span class="error-message error-invalid_length-message" id="contact-email-invalid_length">
The e-mail can't be more than 100 characters
</span>
<span class="error-message error-not-match-message" id="contact-email-not-match">
Please, make sure the e-mails match.
</span>
<span class="error-message error-invalid_email-message" id="contact-email-invalid_email">
Invalid characters. Please, check
</span>
</div>
</div>
<div class="line-form">
<div class="item email-repeat-container
" id="contactDefinition.emailRepeat.value">
<label for="contact-email-repeat" class="custom-label">Confirm your e-mail</label>
<input type="text" autocomplete="off" data-regex-size="2" data-regex-1-pattern="^[\w\.-]+@([\w-]+\.)+[\w-]{2,12}$" data-regex-1-code="invalid_email" data-regex-0-pattern="^.{0,100}$" data-regex-0-code="invalid_length" placeholder="" name="contactDefinition.emailRepeat.value" id="contact-email-repeat" class="input checkout-textfield input-email-repeat required">
<script type="text/javascript">
$(function(){
CheckoutHotels.Checkout.Modules.Form.registerDynamicVisibility("contactDefinition.emailRepeat.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
});
</script>
<script type="text/javascript">
$(function(){
CheckoutHotels.Checkout.Modules.Form.registerDynamicExtraData("contactDefinition.emailRepeat.value", {"events":[],"rules":[]});
});
</script>
<script type="text/javascript">
$(function(){
CheckoutHotels.Checkout.Modules.Form.registerDynamicRegex("contactDefinition.emailRepeat.value", {"events":[],"rules":[{"regexValidations":[{"regex":"^.{0,100}$","errorCode":"INVALID_LENGTH"},{"regex":"^[\\w\\.-]+@([\\w-]+\\.)+[\\w-]{2,4}$","errorCode":"INVALID_EMAIL"}],"dependencies":[]}]});
});
</script>
<span class="commonSprite errorCrossIcon icon-error"></span>
<span class="error-message error-field_empty-message" id="contact-email-repeat-field_empty">
Please verify that e-mails match.
</span>
<span class="error-message error-invalid_length-message" id="contact-email-repeat-invalid_length">
The e-mail address must be less than 100 characters.
</span>
<span class="error-message error-not-match-message
" id="contact-email-repeat-not-match">
Please verify that e-mails match.</span>
<span class="error-message error-invalid_email-message
" id="contact-email-repeat-invalid_email">
Invalid characters. Please, check
</span>
</div>
</div>
</div>
<div class="phones">
<div class="phone line-form">
	<div class="item phone-type-container" id="contactDefinition.phoneDefinitions[0].type.value">
	<label for="phone-type-0" class="custom-label">Phone</label>
	<select name="contactDefinition.phoneDefinitions[0].type.value" id="phone-type-0" class="input checkout-select select-phone-type required">
	<option value="HOME">Home</option>
	<option value="CELULAR">Cellphone</option>
	<option value="WORK">Work</option>
	<option value="FAX">Fax</option>
	<option value="OTHER">Other</option>
	</select>
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicVisibility("contactDefinition.phoneDefinitions[0].type.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicExtraData("contactDefinition.phoneDefinitions[0].type.value", {"events":[],"rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicContent("contactDefinition.phoneDefinitions[0].type.value", {"events":[],"defaultProvider":"9c11a77a-49cd-436d-aafc-3aef126cfd47","rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	var name = "contactDefinition.phoneDefinitions[0].type.value";
	$('[name="'+name+'"]').change(function(e) {
	amplify.publish(name);
	});
	});
	</script>
	<span class="commonSprite errorCrossIcon icon-error"></span>
	</div>
	<div class="group phone-group" id="phone-group-0">
	<div class="item country-code-container
	" id="contactDefinition.phoneDefinitions[0].countryCode.value">
	<label for="country-code-0" class="custom-label">Country</label>
	<input type="text" value="" data-regex-size="2" data-regex-1-pattern="^.*[0-9].*$" data-regex-1-code="invalid_phone_country_code" data-regex-0-pattern="^.{1}.*$" data-regex-0-code="invalid_length" placeholder="" name="contactDefinition.phoneDefinitions[0].countryCode.value" id="country-code-0" class="input checkout-textfield input-country-code required">
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicVisibility("contactDefinition.phoneDefinitions[0].countryCode.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicExtraData("contactDefinition.phoneDefinitions[0].countryCode.value", {"events":[],"rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicRegex("contactDefinition.phoneDefinitions[0].countryCode.value", {"events":[],"rules":[{"regexValidations":[{"regex":"^.{1}.*$","errorCode":"INVALID_LENGTH"},{"regex":"^.*[0-9].*$","errorCode":"INVALID_PHONE_COUNTRY_CODE"}],"dependencies":[]}]});
	});
	</script>
	<span class="commonSprite errorCrossIcon icon-error"></span>
	</div>
	<div class="item area-code-container" id="contactDefinition.phoneDefinitions[0].areaCode.value">
	<label for="area-code-0" class="custom-label">Area</label>
	<input type="text" value="" data-regex-size="2" data-regex-1-pattern="^.*[0-9].*$" data-regex-1-code="invalid_phone_area_code" data-regex-0-pattern="^.{1}.*$" data-regex-0-code="invalid_length" placeholder="" name="contactDefinition.phoneDefinitions[0].areaCode.value" id="area-code-0" class="input checkout-textfield input-area-code required">
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicVisibility("contactDefinition.phoneDefinitions[0].areaCode.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicExtraData("contactDefinition.phoneDefinitions[0].areaCode.value", {"events":[],"rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicRegex("contactDefinition.phoneDefinitions[0].areaCode.value", {"events":[],"rules":[{"regexValidations":[{"regex":"^.{1}.*$","errorCode":"INVALID_LENGTH"},{"regex":"^.*[0-9].*$","errorCode":"INVALID_PHONE_AREA_CODE"}],"dependencies":[]}]});
	});
	</script>
	<span class="commonSprite errorCrossIcon icon-error"></span>
	</div>
	<div class="item phone-number-container" id="contactDefinition.phoneDefinitions[0].number.value">
	<label for="phone-number-0" class="custom-label">Number</label>
	<input type="text" data-regex-size="2" data-regex-1-pattern="^.*[0-9].*[0-9].*[0-9].*[0-9].*[0-9].*$" data-regex-1-code="invalid_phone_number" data-regex-0-pattern="^.{5}.*$" data-regex-0-code="invalid_length" placeholder="" name="contactDefinition.phoneDefinitions[0].number.value" id="phone-number-0" class="input checkout-textfield input-phone-number required">
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicVisibility("contactDefinition.phoneDefinitions[0].number.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicExtraData("contactDefinition.phoneDefinitions[0].number.value", {"events":[],"rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutHotels.Checkout.Modules.Form.registerDynamicRegex("contactDefinition.phoneDefinitions[0].number.value", {"events":[],"rules":[{"regexValidations":[{"regex":"^.{5}.*$","errorCode":"INVALID_LENGTH"},{"regex":"^.*[0-9].*[0-9].*[0-9].*[0-9].*[0-9].*$","errorCode":"INVALID_PHONE_NUMBER"}],"dependencies":[]}]});
	});
	</script>
	<span class="commonSprite errorCrossIcon icon-error"></span>
	</div>
	<span class="commonSprite errorCrossIcon icon-error group-icon"></span>
	<span class="group-message error-field_empty-message error-message" id="phone-0-field_empty">Please, complete your telephone number.</span>
	<span class="group-message error-invalid-message error-message" id="phone-0-invalid">Please, input a valid telephone number.</span>
	</div>
	<span class="text"></span>
</div>
</div>
</div>
</fieldset>

<div class="popup-ticket template" id="popup-ticket-template">
	<div class="content-wrapper">
	After finishing the purchase you will receive an e-mail with the voucher that you will print to present when you arrive to the hotel.
	</div>
</div>
<div class="popup-remove-phone-confirmation template" id="popup-remove-phone-confirmation-template">
	<div class="content-wrapper">
		<span class="confirmation-text"> Are you sure you want to delete phone number? </span>
		<div class="buttons">
			<a class="popup-button checkout-second-button confirm">
			<span>Yes</span>
			</a>
			<a class="popup-button checkout-second-button cancel">
			<span>No</span>
			</a>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
CheckoutHotels.Checkout.Modules.Form.registerDynamicVisibility("contactDefinition", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
});
</script>
</div>


<div>
	<fieldset class="payment section" id="payment">
		<span class="description">Payment</span>
		<div class="content">
			<div class="payment-option" >
				<input type="radio" name="paymentOption" value="BTC" checked/> 
				<img src="/bundles/btctrip/images/Bitcoin-accepted-ch.jpg" class="payment-logo-coin" alt="bitcoin" /> 
			</div>	
			<div class="payment-option" >
				<input type="radio" name="paymentOption" value="XDG"/> 
				<img src="/bundles/btctrip/images/Dogecoin-accepted-ch.jpg" class="payment-logo-coin" alt="dogecoin" /> 
			</div>
			<div class="payment-option" >
				<input type="radio" name="paymentOption" value="LTC"/> 
				<img src="/bundles/btctrip/images/Litecoin-accepted-ch.jpg" class="payment-logo-coin" alt="litecoin" /> 
				<br>
			</div>
		</div>
	<fieldset>
</div>


<fieldset class="agreement section" id="agreement">
<div class="content">
<div class="line-form">
<div class="item read-agreement-container check-container
" id="agreement.value">
<input type="checkbox" name="agreement.value" id="read-agreement" class="input checkout-checkbox check-read-agreement required">
<label for="read-agreement" class="custom-label">I read and accept the <a class="agreement-link" href="#">purchasing conditions</a></label>
<script type="text/javascript">
$(function(){
CheckoutHotels.Checkout.Modules.Form.registerDynamicExtraData("agreement.value", {"events":[],"rules":[]});
});
</script>
<script type="text/javascript">
$(function(){
var name = "agreement.value";
$('[name="'+name+'"]').change(function(e) {
amplify.publish(name);
});
});
</script>
<span class="commonSprite errorCrossIcon icon-error"></span>
</div>
</div>
</div>
</fieldset>
<div class="popup-agreement-content template" id="popup-agreement-template">
<div class="content-wrapper">
<p class="item">
<strong>1)</strong>
Customer hereby acknowledges that the information provided above is accurate. This is acknowledged by pressing the "Pay" button.
</p>
<p class="item">
<strong> 2) </strong>
The client acknowledges and accepts the cancellation and refund rules and restrictions of the products purchased, as well as any surcharges that such actions could generate.
</p>
<p class="item">
<strong> 3) </strong>
Any controversy related to these issues will come under the jurisdiction of Miami City Courts.
</p>
<p class="item">
<strong> 4) </strong>
Customer acknowledges that is responsible for ensuring all required travel documents, including passports, visas, permits, health certificates, among others.
</p>
</div>
</div>

	<fieldset class="buy section" id="buy">
		<div class="content">
			<div class="line-form">
				<a id="pay" class="submit checkout-button" >
				<span>Pay</span>
				</a>
				<span id="payment-msg" class="text">Please, check all your data before finishing.</span>
			</div>
		</div>
	</fieldset>

	<div class="transition checkout-transition template" id="popup-checkout-transition-template">
		<div class="content-wrapper">

				<div id="paymentDefinition">
					<fieldset class="payment section" id="payment">
						<span class="description">Payment</span>
						<div class="content">
							<iframe id="invoice"  ></iframe>
							<br><br>
							<a id="submit" class="submit checkout-button disabled" >
							<span>I have paid</span> </a>
						</div>
					</fieldset>
				</div>
			
		</div>
	</div>

	<div class="modal" style="display: none;"></div>
	<div class="transition checkout-transition" id="popup-initial-transition" style="display: none;">

	</div>
</div>

<div class="purchase-info span4 omega">
<div class="detail" id="detail">


<?php			 
				 $date_from = new DateTime($searchParameters['check_in']);
                 $date_to = new DateTime($searchParameters['check_out']);
                 $day_from = date_format($date_from, 'j');
                 $day_to = date_format($date_to, 'j');
                 $cant_day = $day_to-$day_from;
?>

<?php foreach ($cryptoPrices as $price) { ?>
<div id="price-info" class="price-info price-<?php echo $price['currency'] ?> <?php echo $price['currency'] != 'BTC' ? 'hidden' : '' ?>">
	<div class="average-section"> 
		<div class="average-title">Room per night</div>
		<div class="average-price"> <?php echo $price['avgPriceWithoutTax']/$cantidad_habitacion; ?> <?php echo $price['currency'] ?></div>
	</div>
    <div class="prices">

   		<ul class="fare-detail">
			<li class="item">
				<span class="description"><?php echo $cant_day ?> nights - <?php echo $cantidad_habitacion ?> rooms</span>
				<span class="price-currency" id="adults-price">
				<span class="amount"><?php echo $price['totalPriceWithoutTaxes']; // $btcTotalPriceWithouTaxes; ?></span>
				<span class="currency"><?php echo $price['currency'] ?></span>
				</span>
			</li>
			<li class="item">
				<span class="description">Taxes and fees</span>
				<span class="price-currency" id="adults-price">
				<span class="amount"><?php echo $price['totalPrice'] - $price['totalPriceWithoutTaxes'] // $btcTotalPrice - $btcTotalPriceWithouTaxes ?></span>
				<span class="currency"><?php echo $price['currency'] ?></span>
				</span>
			</li>
                                        
			<li class="item total">
				<span class="description-for-hotels">Total</span>
				<div class="price-currency" id="total-price">
					<span class="amount"><?php echo $price['totalPrice'] // $btcTotalPrice ?></span>
					<span class="currency"><?php echo $price['currency'] ?></span><br>
                    <span class="aclaration">(<?php echo ceil($totalPrice) ?> USD)</span> 
				</div>
			</li>
		</ul>
</div>
</div>
<?php  }  ?>

<div class="content">
<div class="best-price">
<span class="commonSprite iconCheck icon"></span>
<div class="text">
<span class="main-title">Good choice!</span>
<span class="description">With bitcoins you get the best price.</span>
</div>
</div>


<?php echo $view->render('BtcTripHotelsBundle:Checkout:detailHotel.html.php',
					array('info' => $info,'searchParameters' => $searchParameters, 'room' => $room, 'cantidad_adultos' => $passengersArray['adult'])) ?>

</div>


<div class="popup-best-price hidden" id="popup-best-price-content">
We work every day to help you save time and money on buying the trips. We want you to rest assured that every time you purchase BtcTrip.com is accessing the best rates available. So now we guarantee that BtcTrip.com you find the best rates on flights, hotels and rental cars, in the event you a better rate encontrase give you the difference up to a maximum of USD 100, the official exchange rate of the day issuance of the voucher, as a credit on a future purchase in our site. <a href="http://www.us.BtcTrip.com/commercial-web/betterprice/termsandconditions"> Best Price Guarantee </a>
</div>


<fieldset class="section additionals" id="additionals">
<span class="description">Additional options</span>
<fieldset class="section vouchers">
<div class="fields">
<div class="line-form">
<div class="item vouchers-container check-container
" id="vouchersDefinition.selected.value">
<input type="checkbox" name="vouchersDefinition.selected.value" id="vouchers" class="input checkout-checkbox check-vouchers">
<label for="vouchers" class="custom-label">Discount voucher</label>
<script type="text/javascript">
$(function(){
CheckoutHotels.Checkout.Modules.Form.registerDynamicExtraData("vouchersDefinition.selected.value", {"events":[],"rules":[]});
});
</script>
<script type="text/javascript">
$(function(){
var name = "vouchersDefinition.selected.value";
$('[name="'+name+'"]').change(function(e) {
amplify.publish(name);
});
});
</script>
<span class="commonSprite errorCrossIcon icon-error"></span>
</div>
</div>
<div class="line-form hidden" id="vouchersDefinition">
	<div class="codes">
		<div class="code">
			<div class="item voucher-code-container" id="vouchersDefinition.codes[0].value">
			<input type="text" data-regex-size="0" placeholder="Input the voucher number" name="vouchersDefinition.codes[0].value" id="voucher-code-0" class="input checkout-textfield input-voucher-code">
			<script type="text/javascript">
			$(function(){
			CheckoutHotels.Checkout.Modules.Form.registerDynamicVisibility("vouchersDefinition.codes[0].value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
			});
			</script>
			<script type="text/javascript">
			$(function(){
			CheckoutHotels.Checkout.Modules.Form.registerDynamicExtraData("vouchersDefinition.codes[0].value", {"events":[],"rules":[]});
			});
			</script>
			<span class="commonSprite errorCrossIcon icon-error"></span>
		</div>
		<a class="remove-voucher hidden" href="#">Remove</a>
	</div>
</div>
<div class="declaimer"><span>The voucher discount will be refunded after the ticket issue.</span></div>
<?php // <a class="add-voucher" href="#">+ Add a coupon</a> ?>
<script type="text/javascript">
$(function(){
CheckoutHotels.Checkout.Modules.Form.registerDynamicVisibility("vouchersDefinition", {"events":["supportedOperation.value","vouchersDefinition.selected.value"],"rules":[{"dependencies":[{"values":[true],"fieldName":"vouchersDefinition.selected.value"},{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
});
</script>
</div>
</div>
</fieldset>

<div class="popup-remove-voucher-confirmation template" id="popup-remove-voucher-confirmation-template">
<div class="content-wrapper">
<span class="confirmation-text">
Are you sure you want to remove the voucher?
</span>
<div class="buttons">
<a class="popup-button checkout-second-button confirm">
<span>Yes</span>
</a>
<a class="popup-button checkout-second-button cancel">
<span>No</span>
</a>
</div>
</div>
</div>
</fieldset></div>
</div>
<input type="hidden" name="poi" value="<?php echo $preOrderId ?>" >
</form>
<form method="POST" action="<?php echo $view['router']->generate('btc_trip_checkout_form_payment_notification') ?>" id="payment_notification">
    <input type="hidden" name="poi" value="<?php echo $preOrderId ?>" >
</form>	

<?php $view['slots']->stop() ?>


<?php $view['slots']->start('javascripts') ?>



<script type="text/x-handlebars-template" id="popup-checkout-template">
<div id="{{id}}" class="checkout-popup">
<div class="popup-border"></div>
<div class="popup-container">
{{#if title}}
<div class="popup-header"><h4>{{title}}</h4></div>
{{/if}}
<div class="popup-content"></div>
</div>
{{#unless hideCloseIcon}}
<span class="popup-close-button popup-close">x</span>{{/unless}}
{{#unless noPuntita}}
<span class="popup-arrow popup-arrow-{{indicatorPosition}}"></span>
{{/unless}}
</div>
</script>
<script src="<?php echo $view['assets']->getUrl('bundles/btctriphotels/js/checkout-hotels.js') ?>" charset="utf-8" type="text/javascript"></script>
<script src="<?php echo $view['assets']->getUrl('bundles/btctriphotels/js/common.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('bundles/btctriphotels/js/checkout.js') ?>"></script>


<script>
	window.addEventListener("message", function(event) {
		if (event.origin === 'https://gateway.gocoin.com') {
			var event_name = event.data.split('|')[0], invoice_id = event.data.split('|')[1];
		    //Act on event notification
		    switch (event_name) {
		      case 'invoice_paid':
		        $("#submit").removeClass('disabled');
				$("#payment_notification").submit();
		        break;
		    }
		} else if (event.data.status == 'paid') {
			$("#submit").removeClass('disabled');
			$("#payment_notification").submit();
		} 
	}, false);
</script>

<script>
$(function () {
    var options = {
        imgPath: "/img-versioned/1.23.8",
        messages: {
            form: {
                agreement: {
                    agreementPopupTitle: 'Purchase Conditions'
                }
            },
            detail: {
                itinerary: {
                    detailPopupTitle: 'Hotels details'
                }
            }
        },
        flowDependencies: {
            isNewHotel: false,
            showLastNameHelper: false,
            passengerNamesMaxLength: 58,
            validateEqualNames: false,
            showInitialTransition: true
        }
   	 };
        
	CheckoutHotels.Checkout.init(options);
});
</script>

<?php $view['slots']->stop() ?>
