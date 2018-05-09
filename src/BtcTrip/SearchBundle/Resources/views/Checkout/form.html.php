<?php $view->extend('BtcTripSearchBundle::layout.html.php') ?>

<?php $view['slots']->set('bodyClass', 'checkout') ?>

<?php $view['slots']->start('stylesheets') ?>
	<link href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/checkout-flights.css') ?>" rel="stylesheet">
	<link href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/common.css') ?>" rel="stylesheet">
	<link href="<?php echo $view['assets']->getUrl('bundles/btctrip/styles/checkout.css') ?>" rel="stylesheet">
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('breadcrumb') ?>
   
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('mainContent') ?>

<form method="POST" action="<?php echo $view['router']->generate('checkout_form_submit') ?>" class="form" id="form">

<div class="purchase-form span8 ">
<fieldset class="section form-title">
	<span class="page-title">Last step: reserve your place!</span>
</fieldset>

<fieldset class="passengers section" id="passengers">
<span class="description">Passengers</span>
<div class="fields">

<?php for ($p = 0; $p < count($passengersArray); $p++) {  ?> 
	<div data-type="<?php echo $passengersArray[$p][0] ?>" data-index="<?php echo $p ?>" class="passenger">
	<span class="reference"><?php echo ucwords($passengersArray[$p][0]) ?> <?php echo $passengersArray[$p][1]+1 ?></span>
	<div class="inputs">
	<div class="line-form first">
	<div class="names">
	<div class="item passenger-first-name-container" id="passengerDefinitions[<?php echo $p ?>].firstName.value">
	<label for="passenger-first-name-<?php echo $p ?>" class="custom-label">First Name</label>
	<input type="text" data-regex-size="1" data-regex-<?php echo $p ?>-pattern="^.*[a-zA-ZÁÉÍÓÚáéíóúäëïöüÄËÏÖÜÇç????????????????????????ãõ?ÃÕ?ñÑÂâÊêÔôÛûÎî]+.*$" data-regex-0-code="invalid_name" placeholder="As in passport" name="passengerDefinitions[<?php echo $p ?>].firstName.value" id="passenger-first-name-0" class="input checkout-textfield input-passenger-first-name
	required">
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicVisibility("passengerDefinitions[<?php echo $p ?>].firstName.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("passengerDefinitions[<?php echo $p ?>].firstName.value", {"events":[],"rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicRegex("passengerDefinitions[<?php echo $p ?>].firstName.value", {"events":[],"rules":[{"regexValidations":[{"regex":"^.*[a-zA-ZÁÉÍÓÚáéíóúäëïöüÄËÏÖÜÇç????????????????????????ãõ?ÃÕ?ñÑÂâÊêÔôÛûÎî]+.*$","errorCode":"INVALID_NAME"}],"dependencies":[]}]});
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
	<label for="passenger-last-name-<?php echo $p ?>" class="custom-label">Last name/s</label>
	<input type="text" data-regex-size="1" data-regex-0-pattern="^.*[a-zA-ZÁÉÍÓÚáéíóúäëïöüÄËÏÖÜÇç????????????????????????ãõ?ÃÕ?ñÑÂâÊêÔôÛûÎî]+.*$" data-regex-0-code="invalid_name" placeholder="As in passport" name="passengerDefinitions[<?php echo $p ?>].lastName.value" id="passenger-last-name-0" class="input checkout-textfield input-passenger-last-name
	required">
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicVisibility("passengerDefinitions[<?php echo $p ?>].lastName.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("passengerDefinitions[<?php echo $p ?>].lastName.value", {"events":[],"rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicRegex("passengerDefinitions[<?php echo $p ?>].lastName.value", {"events":[],"rules":[{"regexValidations":[{"regex":"^.*[a-zA-ZÁÉÍÓÚáéíóúäëïöüÄËÏÖÜÇç????????????????????????ãõ?ÃÕ?ñÑÂâÊêÔôÛûÎî]+.*$","errorCode":"INVALID_NAME"}],"dependencies":[]}]});
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
	<div class="line-form">
	<?php
		$dateDataValidationRange = 'data-to="01/02/2002" data-from="05/19/1913"';
		
		if($passengersArray[$p][0] == 'infant') {
			$dateDataValidationRange = 'data-to="01/02/2014" data-from="01/02/2012"';
		} else if($passengersArray[$p][0] == 'child') {
			$dateDataValidationRange = 'data-to="01/02/2012" data-from="01/02/2002"';
		}
	?>
	<div <?php echo $dateDataValidationRange ?> class="group birthday-group date" id="birthday-group-<?php echo $p ?>">
	<label class="custom-label">Birthdate</label>
	<div class="item day-container" id="passengerDefinitions[<?php echo $p ?>].birthday.day.value">
	<select name="passengerDefinitions[<?php echo $p ?>].birthday.day.value" id="passenger-birthday-day-<?php echo $p ?>" class="input checkout-select select-day
	required">
	<option class="default" value="">Day</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14">14</option>
	<option value="15">15</option>
	<option value="16">16</option>
	<option value="17">17</option>
	<option value="18">18</option>
	<option value="19">19</option>
	<option value="20">20</option>
	<option value="21">21</option>
	<option value="22">22</option>
	<option value="23">23</option>
	<option value="24">24</option>
	<option value="25">25</option>
	<option value="26">26</option>
	<option value="27">27</option>
	<option value="28">28</option>
	<option value="29">29</option>
	<option value="30">30</option>
	<option value="31">31</option>
	</select>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("passengerDefinitions[<?php echo $p ?>].birthday.day.value", {"events":[],"rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicContent("passengerDefinitions[<?php echo $p ?>].birthday.day.value", {"events":[],"defaultProvider":"8bbe7643-8aea-4a6f-897b-8dbd31aaab0e","rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	var name = "passengerDefinitions[<?php echo $p ?>].birthday.day.value";
	$('[name="'+name+'"]').change(function(e) {
	amplify.publish(name);
	});
	});
	</script>
	<span class="commonSprite errorCrossIcon icon-error"></span>
	</div>
	<div class="item month-container" id="passengerDefinitions[<?php echo $p ?>].birthday.month.value">
	<select name="passengerDefinitions[<?php echo $p ?>].birthday.month.value" id="passenger-birthday-month-<?php echo $p ?>" class="input checkout-select select-month
	required">
	<option class="default" value="">Month</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	</select>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("passengerDefinitions[<?php echo $p ?>].birthday.month.value", {"events":[],"rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicContent("passengerDefinitions[<?php echo $p ?>].birthday.month.value", {"events":[],"defaultProvider":"7ba4fa22-5133-4a71-989a-1cdcc75a3b62","rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	var name = "passengerDefinitions[<?php echo $p ?>].birthday.month.value";
	$('[name="'+name+'"]').change(function(e) {
	amplify.publish(name);
	});
	});
	</script>
	<span class="commonSprite errorCrossIcon icon-error"></span>
	</div>
	<div class="item year-container" id="passengerDefinitions[<?php echo $p ?>].birthday.year.value">
	<select name="passengerDefinitions[<?php echo $p ?>].birthday.year.value" id="passenger-birthday-year-<?php echo $p ?>" class="input checkout-select select-year
	required">
	<option class="default" value="">Year</option>
	<option value="2013">2014</option>
	<option value="2013">2013</option>
	<option value="2012">2012</option>
	<option value="2011">2011</option>
	<option value="2010">2010</option>
	<option value="2009">2009</option>
	<option value="2008">2008</option>
	<option value="2007">2007</option>
	<option value="2006">2006</option>
	<option value="2005">2005</option>
	<option value="2004">2004</option>
	<option value="2003">2003</option>
	<option value="2002">2002</option>
	<option value="2001">2001</option>
	<option value="2000">2000</option>
	<option value="1999">1999</option>
	<option value="1998">1998</option>
	<option value="1997">1997</option>
	<option value="1996">1996</option>
	<option value="1995">1995</option>
	<option value="1994">1994</option>
	<option value="1993">1993</option>
	<option value="1992">1992</option>
	<option value="1991">1991</option>
	<option value="1990">1990</option>
	<option value="1989">1989</option>
	<option value="1988">1988</option>
	<option value="1987">1987</option>
	<option value="1986">1986</option>
	<option value="1985">1985</option>
	<option value="1984">1984</option>
	<option value="1983">1983</option>
	<option value="1982">1982</option>
	<option value="1981">1981</option>
	<option value="1980">1980</option>
	<option value="1979">1979</option>
	<option value="1978">1978</option>
	<option value="1977">1977</option>
	<option value="1976">1976</option>
	<option value="1975">1975</option>
	<option value="1974">1974</option>
	<option value="1973">1973</option>
	<option value="1972">1972</option>
	<option value="1971">1971</option>
	<option value="1970">1970</option>
	<option value="1969">1969</option>
	<option value="1968">1968</option>
	<option value="1967">1967</option>
	<option value="1966">1966</option>
	<option value="1965">1965</option>
	<option value="1964">1964</option>
	<option value="1963">1963</option>
	<option value="1962">1962</option>
	<option value="1961">1961</option>
	<option value="1960">1960</option>
	<option value="1959">1959</option>
	<option value="1958">1958</option>
	<option value="1957">1957</option>
	<option value="1956">1956</option>
	<option value="1955">1955</option>
	<option value="1954">1954</option>
	<option value="1953">1953</option>
	<option value="1952">1952</option>
	<option value="1951">1951</option>
	<option value="1950">1950</option>
	<option value="1949">1949</option>
	<option value="1948">1948</option>
	<option value="1947">1947</option>
	<option value="1946">1946</option>
	<option value="1945">1945</option>
	<option value="1944">1944</option>
	<option value="1943">1943</option>
	<option value="1942">1942</option>
	<option value="1941">1941</option>
	<option value="1940">1940</option>
	<option value="1939">1939</option>
	<option value="1938">1938</option>
	<option value="1937">1937</option>
	<option value="1936">1936</option>
	<option value="1935">1935</option>
	<option value="1934">1934</option>
	<option value="1933">1933</option>
	<option value="1932">1932</option>
	<option value="1931">1931</option>
	<option value="1930">1930</option>
	<option value="1929">1929</option>
	<option value="1928">1928</option>
	<option value="1927">1927</option>
	<option value="1926">1926</option>
	<option value="1925">1925</option>
	<option value="1924">1924</option>
	<option value="1923">1923</option>
	<option value="1922">1922</option>
	<option value="1921">1921</option>
	<option value="1920">1920</option>
	<option value="1919">1919</option>
	<option value="1918">1918</option>
	<option value="1917">1917</option>
	<option value="1916">1916</option>
	<option value="1915">1915</option>
	<option value="1914">1914</option>
	<option value="1913">1913</option>
	</select>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("passengerDefinitions[<?php echo $p ?>].birthday.year.value", {"events":[],"rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicContent("passengerDefinitions[<?php echo $p ?>].birthday.year.value", {"events":[],"defaultProvider":"28ca5859-b224-4dea-b955-3b005ed672c7","rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	var name = "passengerDefinitions[<?php echo $p ?>].birthday.year.value";
	$('[name="'+name+'"]').change(function(e) {
	amplify.publish(name);
	});
	});
	</script>
	<span class="commonSprite errorCrossIcon icon-error"></span>
	</div>
	<span class="commonSprite errorCrossIcon icon-error group-icon"></span>
	<span class="group-message error-field_empty-message error-message" id="passenger-<?php echo $p ?>-birthday-field_empty">Please, input a birthday.</span>
	<span class="group-message error-invalid_date-message error-message" id="passenger-<?php echo $p ?>-birthday-invalid_date">Please, check the birthday, it must be valid.</span>
	<span class="group-message error-invalid_date_max-message error-message" id="passenger-<?php echo $p ?>-birthday-invalid_date_max">Please, check the birthday.</span>
	<span class="group-message error-invalid_date_min-message error-message" id="passenger-<?php echo $p ?>-birthday-invalid_date_min">Please, check the birthday.</span>
	</div>
	<div class="item passenger-gender-container" id="passengerDefinitions[<?php echo $p ?>].gender.value">
	<label for="passenger-gender-<?php echo $p ?>" class="custom-label">Gender</label>
	<select name="passengerDefinitions[<?php echo $p ?>].gender.value" id="passenger-gender-<?php echo $p ?>" class="input checkout-select select-passenger-gender
	required">
	<option class="default" value="">- Select -</option>
	<option value="MALE">Male</option>
	<option value="FEMALE">Female</option>
	</select>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicVisibility("passengerDefinitions[<?php echo $p ?>].gender.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("passengerDefinitions[<?php echo $p ?>].gender.value", {"events":[],"rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicContent("passengerDefinitions[<?php echo $p ?>].gender.value", {"events":[],"defaultProvider":"7d09c1cb-ac1f-4b96-aaf1-e4c9345298fa","rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	var name = "passengerDefinitions[<?php echo $p ?>].gender.value";
	$('[name="'+name+'"]').change(function(e) {
	amplify.publish(name);
	});
	});
	</script>
	<span class="commonSprite errorCrossIcon icon-error"></span>
	<span class="error-message error-field_empty-message" id="passenger-gender-<?php echo $p ?>-field_empty">Please, pick the passenger's gender.</span>
	</div>
	</div>
	</div>
	</div>
<?php }   // fin ciclo por pasajero  ?>
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
CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("supportedOperation.value", {"events":[],"rules":[]});
});
</script>
<script type="text/javascript">
$(function(){
CheckoutFlights.Checkout.Modules.Form.registerDynamicContent("supportedOperation.value", {"events":[],"defaultProvider":"5d7eb336-183b-452e-9124-b08221549be0","rules":[]});
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
CheckoutFlights.Checkout.Modules.Form.registerDynamicVisibility("contactDefinition.contactFullName.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
});
</script>
<script type="text/javascript">
$(function(){
CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("contactDefinition.contactFullName.value", {"events":[],"rules":[]});
});
</script>
<span class="commonSprite errorCrossIcon icon-error"></span>
</div>
</div>
<div class="emails">
<div class="line-form first">
<label for="contact-email" class="custom-label email-label">E-mail (where you will receive your <a class="ticket" href="#">electronic ticket</a>)</label>
<div class="item email-container
" id="contactDefinition.email.value">
<input type="text" data-regex-size="2" data-regex-1-pattern="^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$" data-regex-1-code="invalid_email" data-regex-0-pattern="^.{0,100}$" data-regex-0-code="invalid_length" placeholder="" name="contactDefinition.email.value" id="contact-email" class="input checkout-textfield input-email
required
">
<script type="text/javascript">
$(function(){
CheckoutFlights.Checkout.Modules.Form.registerDynamicVisibility("contactDefinition.email.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
});
</script>
<script type="text/javascript">
$(function(){
CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("contactDefinition.email.value", {"events":[],"rules":[]});
});
</script>
<script type="text/javascript">
$(function(){
CheckoutFlights.Checkout.Modules.Form.registerDynamicRegex("contactDefinition.email.value", {"events":[],"rules":[{"regexValidations":[{"regex":"^.{0,100}$","errorCode":"INVALID_LENGTH"},{"regex":"^[\\w\\.-]+@([\\w-]+\\.)+[\\w-]{2,4}$","errorCode":"INVALID_EMAIL"}],"dependencies":[]}]});
});
</script>
<span class="commonSprite errorCrossIcon icon-error"></span>
<span class="error-message error-field_empty-message
" id="contact-email-field_empty">
Please, input your E-Mail where we'll send you your E-Ticket.
</span>
<span class="error-message error-invalid_length-message
" id="contact-email-invalid_length">
The E-Mail can't be more than 100 characters
</span>
<span class="error-message error-not-match-message
" id="contact-email-not-match">
Please, make sure the E-Mails match.
</span>
<span class="error-message error-invalid_email-message
" id="contact-email-invalid_email">
Invalid characters. Please, check
</span>
</div>
</div>
<div class="line-form">
<div class="item email-repeat-container
" id="contactDefinition.emailRepeat.value">
<label for="contact-email-repeat" class="custom-label">Confirm your e-mail</label>
<input type="text" autocomplete="off" data-regex-size="2" data-regex-1-pattern="^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$" data-regex-1-code="invalid_email" data-regex-0-pattern="^.{0,100}$" data-regex-0-code="invalid_length" placeholder="" name="contactDefinition.emailRepeat.value" id="contact-email-repeat" class="input checkout-textfield input-email-repeat
required
">
<script type="text/javascript">
$(function(){
CheckoutFlights.Checkout.Modules.Form.registerDynamicVisibility("contactDefinition.emailRepeat.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
});
</script>
<script type="text/javascript">
$(function(){
CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("contactDefinition.emailRepeat.value", {"events":[],"rules":[]});
});
</script>
<script type="text/javascript">
$(function(){
CheckoutFlights.Checkout.Modules.Form.registerDynamicRegex("contactDefinition.emailRepeat.value", {"events":[],"rules":[{"regexValidations":[{"regex":"^.{0,100}$","errorCode":"INVALID_LENGTH"},{"regex":"^[\\w\\.-]+@([\\w-]+\\.)+[\\w-]{2,4}$","errorCode":"INVALID_EMAIL"}],"dependencies":[]}]});
});
</script>
<span class="commonSprite errorCrossIcon icon-error"></span>
<span class="error-message error-field_empty-message" id="contact-email-repeat-field_empty">
Please verify that E-Mails match.
</span>
<span class="error-message error-invalid_length-message" id="contact-email-repeat-invalid_length">
The e-mail address must be less than 100 characters.
</span>
<span class="error-message error-not-match-message
" id="contact-email-repeat-not-match">
Please verify that E-Mails match.</span>
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
	CheckoutFlights.Checkout.Modules.Form.registerDynamicVisibility("contactDefinition.phoneDefinitions[0].type.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("contactDefinition.phoneDefinitions[0].type.value", {"events":[],"rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicContent("contactDefinition.phoneDefinitions[0].type.value", {"events":[],"defaultProvider":"9c11a77a-49cd-436d-aafc-3aef126cfd47","rules":[]});
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
	CheckoutFlights.Checkout.Modules.Form.registerDynamicVisibility("contactDefinition.phoneDefinitions[0].countryCode.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("contactDefinition.phoneDefinitions[0].countryCode.value", {"events":[],"rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicRegex("contactDefinition.phoneDefinitions[0].countryCode.value", {"events":[],"rules":[{"regexValidations":[{"regex":"^.{1}.*$","errorCode":"INVALID_LENGTH"},{"regex":"^.*[0-9].*$","errorCode":"INVALID_PHONE_COUNTRY_CODE"}],"dependencies":[]}]});
	});
	</script>
	<span class="commonSprite errorCrossIcon icon-error"></span>
	</div>
	<div class="item area-code-container" id="contactDefinition.phoneDefinitions[0].areaCode.value">
	<label for="area-code-0" class="custom-label">Area</label>
	<input type="text" value="" data-regex-size="2" data-regex-1-pattern="^.*[0-9].*$" data-regex-1-code="invalid_phone_area_code" data-regex-0-pattern="^.{1}.*$" data-regex-0-code="invalid_length" placeholder="" name="contactDefinition.phoneDefinitions[0].areaCode.value" id="area-code-0" class="input checkout-textfield input-area-code required">
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicVisibility("contactDefinition.phoneDefinitions[0].areaCode.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("contactDefinition.phoneDefinitions[0].areaCode.value", {"events":[],"rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicRegex("contactDefinition.phoneDefinitions[0].areaCode.value", {"events":[],"rules":[{"regexValidations":[{"regex":"^.{1}.*$","errorCode":"INVALID_LENGTH"},{"regex":"^.*[0-9].*$","errorCode":"INVALID_PHONE_AREA_CODE"}],"dependencies":[]}]});
	});
	</script>
	<span class="commonSprite errorCrossIcon icon-error"></span>
	</div>
	<div class="item phone-number-container" id="contactDefinition.phoneDefinitions[0].number.value">
	<label for="phone-number-0" class="custom-label">Number</label>
	<input type="text" data-regex-size="2" data-regex-1-pattern="^.*[0-9].*[0-9].*[0-9].*[0-9].*[0-9].*$" data-regex-1-code="invalid_phone_number" data-regex-0-pattern="^.{5}.*$" data-regex-0-code="invalid_length" placeholder="" name="contactDefinition.phoneDefinitions[0].number.value" id="phone-number-0" class="input checkout-textfield input-phone-number required">
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicVisibility("contactDefinition.phoneDefinitions[0].number.value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("contactDefinition.phoneDefinitions[0].number.value", {"events":[],"rules":[]});
	});
	</script>
	<script type="text/javascript">
	$(function(){
	CheckoutFlights.Checkout.Modules.Form.registerDynamicRegex("contactDefinition.phoneDefinitions[0].number.value", {"events":[],"rules":[{"regexValidations":[{"regex":"^.{5}.*$","errorCode":"INVALID_LENGTH"},{"regex":"^.*[0-9].*[0-9].*[0-9].*[0-9].*[0-9].*$","errorCode":"INVALID_PHONE_NUMBER"}],"dependencies":[]}]});
	});
	</script>
	<span class="commonSprite errorCrossIcon icon-error"></span>
	</div>
	<span class="commonSprite errorCrossIcon icon-error group-icon"></span>
	<span class="group-message error-field_empty-message error-message" id="phone-0-field_empty">Please, input your telephone number.</span>
	<span class="group-message error-invalid-message error-message" id="phone-0-invalid">Please, input a valid telephone number.</span>
	</div>
	<span class="text"></span>
</div>
</div>
</div>
</fieldset>

<div class="popup-ticket template" id="popup-ticket-template">
	<div class="content-wrapper">
	Your E-Ticket will be mailed soon. Please, print it and take it with you on your flight, together with a passport/travel document/ID.
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
CheckoutFlights.Checkout.Modules.Form.registerDynamicVisibility("contactDefinition", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
});
</script>
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
CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("agreement.value", {"events":[],"rules":[]});
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
Customer hereby acknowledges that the above mentioned data have been completed correctly. You acknowledge that by pressing "Buy". 
</p>
<p class="item">
<strong> 2) </strong>
The client acknowledges and accepts the rules and restrictions of cancellation and refund of the products purchased, and surcharges that such actions could generate.
</p>
<p class="item">
<strong> 3) </strong>
Attaches to Miami City Courts to resolve any dispute relating to this issues.
</p>
<p class="item">
<strong> 4) </strong>
Customer acknowledges that it is responsible for ensuring all required travel documents, including passports, visas, permits, vaccinations, among others.
</p>
</div>
</div>

	<fieldset class="buy section" id="buy">
		<div class="content">
			<div class="line-form">
				<a id="pay" class="submit checkout-button" >
				<span>Pay</span>
				</a>
				<span id="payment-msg" class="text">Please, before finishing check the input data.</span>
			</div>
		</div>
	</fieldset>

	<div class="transition checkout-transition template" id="popup-checkout-transition-template">
		<div class="content-wrapper">

				<div id="paymentDefinition">
					<fieldset class="payment section" id="payment">
						<span class="description">Payment</span>
						<div class="content">
							<iframe id="bitpay-invoice" width="520" height="160"></iframe>
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
<div id="price-info" class="price-info">
<div class="prices">

<ul class="fare-detail">

<li class="item adult-price">
<span class="description">
Price per adult
</span>
<span class="price-currency" id="adult-price">
<span class="amount"><?php echo $itenerariesBoxPriceInfoList[0]['adult']['totalOnlyOne']['formatted']['amount'] ?></span>
<span class="currency">USD</span>
</span>
</li>

<li class="item">
<?php if ($itenerariesBoxPriceInfoList[0]['adult']['quantity'] >= 2) {
	$textAdults = 's ('. $itenerariesBoxPriceInfoList[0]['adult']['quantity'] . ')';
} else {
	$textAdults = '';
} ?>
<span class="description">Adult<?php echo $textAdults ?></span>
<span class="price-currency" id="adults-price">
<span class="amount"><?php echo $itenerariesBoxPriceInfoList[0]['adult']['total']['formatted']['amount'] ?></span>
<span class="currency">USD</span>
</span>
</li>

<?php if (isset($itenerariesBoxPriceInfoList[0]['child']) && $itenerariesBoxPriceInfoList[0]['child']['quantity'] >= 1) { ?>
<li class="item">
<?php if ($itenerariesBoxPriceInfoList[0]['child']['quantity'] >= 2) {
	$textChildrens = 's ('. $itenerariesBoxPriceInfoList[0]['child']['quantity'] . ')';
} else {
	$textChildrens = '';
} ?>
<span class="description">Children<?php echo $textChildrens ?></span>
<span class="price-currency" id="childrens-price">
<span class="amount"><?php echo $itenerariesBoxPriceInfoList[0]['child']['total']['formatted']['amount'] ?></span>
<span class="currency">USD</span>
</span>
</li>
<?php } ?>

<?php if (isset($itenerariesBoxPriceInfoList[0]['infant']) && $itenerariesBoxPriceInfoList[0]['infant']['quantity'] >= 1) { ?>
<li class="item">
<?php if ($itenerariesBoxPriceInfoList[0]['infant']['quantity'] >= 2) {
	$textInfants = 's ('. $itenerariesBoxPriceInfoList[0]['infant']['quantity'] . ')';
} else {
	$textInfants = '';
} ?>
<span class="description">Infant<?php echo $textInfants ?></span>
<span class="price-currency" id="infants-price">
<span class="amount"><?php echo $itenerariesBoxPriceInfoList[0]['infant']['total']['formatted']['amount'] ?></span>
<span class="currency">USD</span>
</span>
</li>
<?php } ?>


<li class="item total">
<span class="description">Total</span>
<span class="price-currency" id="total-price">
	<span class="amount"><?php echo $btcTotalPrice ?></span>
	<span class="currency">BTC</span><br>
	<span class="aclaration">(<?php echo $totalPrice ?> USD)</span>
<span>
</li>
</ul>
</div>
<div class="container">
</div>
</div>
<div class="content">
<div class="best-price">
<span class="commonSprite iconCheck icon"></span>
<div class="text">
<span class="main-title">Good choice!</span>
<span class="description">With bitcoins you get the best price.</span>
</div>
</div>


<?php echo $view->render('BtcTripSearchBundle:Checkout:briefItinerary.html.php',
					array('outboundRoute' => $outboundRoute, 'inboundRoute' => $inboundRoute)) ?>


<div id="update-search">
	<span class="choose-another">
	<a class="link" href="<?php echo $searchAgainUrl ?>">
	 Change flight
	</a>  
	</span>
</div>

<div class="popup-detail hidden" id="popup-detail-content">
<?php /*  ?>
<div class="route-1">
<div class="content-wrapper">
<div class="segment">
<ul class="detail">
<li class="flight">
<span class="item strecht">First Leg</span>
<span class="item">-</span>
<span class="item number">Flight 8019</span>
<span class="item">-</span>
<span class="item class">Economy class</span>
<span class="item airline">
<span class="airlines-content">
<span class="icon">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/JJ.png') ?>" alt="Tam" title="Tam" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/default.png') ?>'">
</span>
<span class="name">Tam</span>
</span>
</span>
</li>
<li class="itinerary">
<span class="location">Leaves Buenos Aires, Aeropuerto Buenos Aires Ministro Pistarini Ezeiza (EZE)</span>
<span class="date">11 may 2013 17:20</span>
</li>
<li class="itinerary">
<span class="location">Arrives to Sao Paulo, Aeropuerto Internacional Guarulhos (GRU)</span>
<span class="date">11 may 2013 20:00</span>
</li>
</ul>
</div>
<span class="connection">
1h 10m connection in Sao Paulo
</span>
<div class="segment">
<ul class="detail">
<li class="flight">
<span class="item strecht">Second Leg</span>
<span class="item">-</span>
<span class="item number">Vuelo 8280</span>
<span class="item">-</span>
<span class="item class">Economy Class</span>
<span class="item airline">
<span class="airlines-content">
<span class="icon">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/JJ.png') ?>" alt="Tam" title="Tam" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/default.png') ?>'">
</span>
<span class="name">Tam</span>
</span>
</span>
</li>
<li class="itinerary">
<span class="location">Leaves Sao Paulo, Aeropuerto Internacional Guarulhos (GRU)</span>
<span class="date">11 may 2013 21:10</span>
</li>
<li class="itinerary">
<span class="location">Arrives to Chicago, International Airport Chicago O'hare (ORD)</span>
<span class="date">12 may 2013 05:35</span>
</li>
<li class="operated-by">
<span class="description">Flight by:</span>
<span class="airline">
<span class="airlines-content">
<span class="icon">
<img src="/img-versioned/1.23.8/common/airlines/25x25/UA.png" alt="United Airlines" title="United Airlines" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/default.png') ?>'">
</span>
<span class="name">United Airlines</span>
</span>
</span>
</li>
</ul>
</div>
<span class="connection">
5h connection in Chicago
</span>
<div class="segment">
<ul class="detail">
<li class="flight">
<span class="item strecht">Third Leg</span>
<span class="item">-</span>
<span class="item number">Flight 1095</span>
<span class="item">-</span>
<span class="item class">Economy Class</span>
<span class="item airline">
<span class="airlines-content">
<span class="icon">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/AA.png') ?>" alt="American Airlines" title="American Airlines" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/default.png') ?>'">
</span>
<span class="name">American Airlines</span>
</span>
</span>
</li>
<li class="itinerary">
<span class="location">Leaves Chicagi, International Airport Chicago O'hare (ORD)</span>
<span class="date">12 may 2013 10:35</span>
</li>
<li class="itinerary">
<span class="location">Arrives to San José, International Airport Mineta San Jose (SJC)</span>
<span class="date">12 may 2013 13:10</span>
</li>
</ul>
</div>
<span class="connection">
Flight duration: 23h 50m
</span>
<span class="bottom-box">
<a class="show-rules" href="#">Ticket Terms and Conditions »</a>
<span class="local-time">Times are local time</span>
</span>
<div class="rules">
<span class="airlines">
<span class="airlines-content">
<span class="icon">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/JJ.png') ?>" alt="Tam" title="Tam" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/default.png') ?>'">
</span>
<span class="main-sprite icon-plus"></span>
<span class="icon">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/AA.png') ?>" alt="American Airlines" title="American Airlines" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/default.png') ?>'">
</span>
</span>
</span>
<div class="text">
<p class="paragraph"> The ticket you are buying is subject to rules and restrictions imposed by the airline carrier. In many cases, tickets are not returnable or refundable and changes are subject to charges by both the airline as BtcTrip.com. If you want to know the fees and restrictions that apply the airline you can read the text as it is provided by the airline by clicking <a target = "_blank" href = "http://www.us.BtcTrip.com/content/flights/ rules "> here </a>. If you have questions about it you can check these rules by calling the airline or our customer service center. The carrier airline rules that apply are those concerning the class as set out in the globalization of the airline system and any amendments by both the airline as BtcTrip.com agent shall be valid unless the same will be informed to you in writing. </p>
<p class="paragraph"> addition to the airline carrier charges may determine, in all cases of cancellations, returns or exchanges on travel dates, BtcTrip.com charged administrative fees of US$30. </p>
</div>
</div>
<a target="_blank" class="baggage-fees" href="http://BtcTrip.com/content/flights/baggagefees/">
Luggage costs
</a>
</div>
</div>
<div class="route-2">
<div class="content-wrapper">
<div class="segment">
<ul class="detail">
<li class="flight">
<span class="item strecht">First Leg</span>
<span class="item">-</span>
<span class="item number">Flight 1530</span>
<span class="item">-</span>
<span class="item class">Economy Class</span>
<span class="item airline">
<span class="airlines-content">
<span class="icon">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/AA.png') ?>" alt="American Airlines" title="American Airlines" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/default.png') ?>'">
</span>
<span class="name">American Airlines</span>
</span>
</span>
</li>
<li class="itinerary">
<span class="location">Leaves San José, International Airport Mineta San Jose (SJC)</span>
<span class="date">18 may 2013 13:50</span>
</li>
<li class="itinerary">
<span class="location">Arrives to Chicago, International Airport Chicago O'hare (ORD)</span>
<span class="date">18 may 2013 20:05</span>
</li>
</ul>
</div>
<span class="connection">
1h 25m connection in Chicago
</span>
<div class="segment">
<ul class="detail">
<li class="flight">
<span class="item strecht">Second Leg</span>
<span class="item">-</span>
<span class="item number">Flight 8281</span>
<span class="item">-</span>
<span class="item class">Economy Class</span>
<span class="item airline">
<span class="airlines-content">
<span class="icon">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/JJ.png') ?>" alt="Tam" title="Tam" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/default.png') ?>'">
</span>
<span class="name">Tam</span>
</span>
</span>
</li>
<li class="itinerary">
<span class="location">Leaves Chicago, International Airport Chicago O'hare (ORD)</span>
<span class="date">18 may 2013 21:30</span>
</li>
<li class="itinerary">
<span class="location">Arrives to Sao Paulo, Aeropuerto Internacional Guarulhos (GRU)</span>
<span class="date">19 may 2013 09:45</span>
</li>
<li class="operated-by">
<span class="description">Flight by:</span>
<span class="airline">
<span class="airlines-content">
<span class="icon">
<img src="/img-versioned/1.23.8/common/airlines/25x25/UA.png" alt="United Airlines" title="United Airlines" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/default.png') ?>'">
</span>
<span class="name">United Airlines</span>
</span>
</span>
</li>
</ul>
</div>
<span class="connection">
1h 30m connection in Sao Paulo
</span>
<div class="segment">
<ul class="detail">
<li class="flight">
<span class="item strecht">Third Leg</span>
<span class="item">-</span>
<span class="item number">Flight 8010</span>
<span class="item">-</span>
<span class="item class">Economy Class</span>
<span class="item airline">
<span class="airlines-content">
<span class="icon">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/JJ.png') ?>" alt="Tam" title="Tam" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/default.png') ?>'">
</span>
<span class="name">Tam</span>
</span>
</span>
</li>
<li class="itinerary">
<span class="location">Leaves Sao Paulo, Aeropuerto Internacional Guarulhos (GRU)</span>
<span class="date">19 may 2013 11:15</span>
</li>
<li class="itinerary">
<span class="location">Arrives to Buenos Aires, Aeropuerto Buenos Aires Jorge Newbery (AEP)</span>
<span class="date">19 may 2013 14:06</span>
</li>
</ul>
</div>
<span class="connection">
Flight duration: 20h 16m
</span>
<span class="bottom-box">
<a class="show-rules" href="#">Ticket Terms and Conditions »</a>
<span class="local-time">Times are local time</span>
</span>
<div class="rules">
<span class="airlines">
<span class="airlines-content">
<span class="icon">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/AA.png') ?>" alt="American Airlines" title="American Airlines" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/default.png') ?>'">
</span>
<span class="main-sprite icon-plus"></span>
<span class="icon">
<img src="<?php echo $view['assets']->getUrl('bundles/btctrip/images/JJ.png') ?>" alt="Tam" title="Tam" onerror="this.src='<?php echo $view['assets']->getUrl('bundles/btctrip/images/default.png') ?>'">
</span>
</span>
</span>
<div class="text">
<p class="paragraph"> The ticket you are buying is subject to rules and restrictions imposed by the airline carrier. In many cases, tickets are not returnable or refundable and changes are subject to charges by both the airline as BtcTrip.com. If you want to know the fees and restrictions that apply the airline you can read the text as it is provided by the airline by clicking <a target = "_blank" href = "http://www.us.BtcTrip.com/content/flights/ rules "> here </a>. If you have questions about it you can check these rules by calling the airline or our customer service center. The carrier airline rules that apply are those concerning the class as set out in the globalization of the airline system and any amendments by both the airline as BtcTrip.com agent shall be valid unless the same will be informed to you in writing. </p>
<p class="paragraph"> addition to the airline carrier charges may determine, in all cases of cancellations, returns or exchanges on travel dates, BtcTrip.com charged administrative fees of $ d 30. </p>
</div>
</div>
</div>
</div>
</div>
<? */ ?>
</div>
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
CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("vouchersDefinition.selected.value", {"events":[],"rules":[]});
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
			CheckoutFlights.Checkout.Modules.Form.registerDynamicVisibility("vouchersDefinition.codes[0].value", {"events":["supportedOperation.value"],"rules":[{"dependencies":[{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
			});
			</script>
			<script type="text/javascript">
			$(function(){
			CheckoutFlights.Checkout.Modules.Form.registerDynamicExtraData("vouchersDefinition.codes[0].value", {"events":[],"rules":[]});
			});
			</script>
			<span class="commonSprite errorCrossIcon icon-error"></span>
		</div>
		<a class="remove-voucher hidden" href="#">Remove</a>
	</div>
</div>
<div class="declaimer"><span>The voucher discount will be refunded after the ticket issue.</span></div>
<a class="add-voucher" href="#">+ Add a coupon</a>
<script type="text/javascript">
$(function(){
CheckoutFlights.Checkout.Modules.Form.registerDynamicVisibility("vouchersDefinition", {"events":["supportedOperation.value","vouchersDefinition.selected.value"],"rules":[{"dependencies":[{"values":[true],"fieldName":"vouchersDefinition.selected.value"},{"values":["PURCHASE","RESERVATION"],"fieldName":"supportedOperation.value"}]}]});
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
<input type="hidden" name="poi" value="<?php echo $preOrderId ?>" >
</form>

	<form method="POST" action="<?php echo $view['router']->generate('checkout_form_payment_notification') ?>" id="payment_notification">
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
<span class="popup-close-button popup-close">x</span>;
{{/unless}}
{{#unless noPuntita}}
<span class="popup-arrow popup-arrow-{{indicatorPosition}}"></span>
{{/unless}}
</div>
</script>

<script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/checkout-flights.js') ?>" charset="utf-8" type="text/javascript"></script>
<script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/common.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('bundles/btctrip/javascript/checkout.js') ?>"></script>

<script>
	window.addEventListener("message", function(event) {
		if (event.data.status == 'paid') {
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
                    detailPopupTitle: 'Flight details'
                }
            }
        },
        flowDependencies: {
            isNewFlight: false,
            showLastNameHelper: false,
            passengerNamesMaxLength: 58,
            validateEqualNames: false,
            showInitialTransition: true
        }
   	 };
        
	CheckoutFlights.Checkout.init(options);
});
</script>

<?php $view['slots']->stop() ?>
