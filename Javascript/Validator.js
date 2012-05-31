

var Test = (function(error){
	debugger;
	this.error = error;
	this.flames = function(){
		this.error = fire();
	}
	function fire(){
		console.log(Test);
	}
});

var t = new Test("error1");
t.flames();
console.log(t.error);

var Validator = (function(validations, submit, displayErrors) {

	this.talk = function() {
		alert( this.name + " say meeow!" )
	}
	this.fire = "yeah";

	this.validate = function(){

		var foundError = false;

		for(var i = 0; i < validations.length; i++){
			
			var item = validations[i][0];
			var validationType = validations[i][1];
			var specifiedErrorMessage = validations[i][2];

			if(validationType == "valid_amount"){
				if(checkValidAmount(item)){
					foundError = true;
					errorManagement(item, foundError, validationType, specifiedErrorMessage);
				}
			}else if(validationType == "has_selected"){
				if(checkHasSelected(item)){
					foundError = true;
					errorManagement(item, foundError, validationType, specifiedErrorMessage);
				}
			}else if(validationType == "not_empty"){
				if(checkNotEmpty(item)){
					foundError = true;
					errorManagement(item, foundError, validationType, specifiedErrorMessage);
				}
			}else if(validationType == "valid_iban"){
				if(checkValidIban(item)){
					foundError = true;
					errorManagement(item, foundError, validationType, specifiedErrorMessage);
				}
			}else if(validationType == "equality"){
				if(checkEquality(item)){
					foundError = true;
					errorManagement(item, foundError, validationType, specifiedErrorMessage);
				}
			}else if(validationType == "char_length"){
				if(checkCharLength(item)){
					foundError = true;
					errorManagement(item, foundError, validationType, specifiedErrorMessage);
				}
			}else if(validationType == "compare_numbers"){
				if(checkCompareNumbers(item)){
					foundError = true;
					errorManagement(item, foundError, validationType, specifiedErrorMessage);
				}
			}else if(validationType == "is_checked"){
				if(checkIsChecked(item)){
					foundError = true;
					errorManagement(item, foundError, validationType, specifiedErrorMessage);
				}
			}else if(validationType == "not_zero"){
				if(checkNotZero(item)){
					foundError = true;
					errorManagement(item, foundError, validationType, specifiedErrorMessage);
				}
			}else if(validationType == "is_email"){
				if(checkIsEmail(item)){
					foundError = true;
					errorManagement(item, foundError, validationType, specifiedErrorMessage);
				}
			}else if(validationType == "has_letter"){
				if(checkHasLetter(item)){
					foundError = true;
					errorManagement(item, foundError, validationType, specifiedErrorMessage);
				}
			}else if(validationType == "has_number"){
				if(checkHasNumber(item)){
					foundError = true;
					errorManagement(item, foundError, validationType, specifiedErrorMessage);
				}
			}
		}
		
		if(foundError == true){
			return false;
		}else{
			return true;
		}
	};

	/**
	 * A function that decides whethere to call or not the displayError function
	 * We basically avoid the if for each validation
	 * 
	 * @param  {HTMLElement} item The element we validate
	 * @param  {boolean} foundError If we found an error or not
	 * @param  {string} validationType 
	 * @param  {string} specifiedErrorMessage 
	 */
	this.errorManagement = function(item, foundError, validationType, specifiedErrorMessage){
		if($.isArray(item)){
			var realItem = item[0];
		}else{
			var realItem = item;
		}
		if(foundError && displayErrors){
			if(specifiedErrorMessage != ""){
				displayError(realItem, validationType, specifiedErrorMessage);
			}
		}
	}

	/**
	 * Displays an error
	 * 
	 * @param  {HTMLElement} item The element we validate
	 * @param  {string} validationType 
	 * @param  {string} specifiedErrorMessage 
	 */
	this.displayError = function(item, validationType, specifiedErrorMessage){
		console.log("failed validation="+validationType+", on item="+item.attr("id"));
		if(submit){
			if(item.hasClass("dsq-dialog")){
				item.parent().focus();			
			}else{
				item.focus();
			}
			submit = false;
		}
		var errorTxt = errorMessages[specifiedErrorMessage];
		
		//check if it has class helper to add it
		if(item.parent().find(".helper").length > 0){
			var helper = item.parent().find(".helper");
			helper.children("span.validation-error").remove();
			helper.append("<span class='validation-error "+validationType+"'>"+errorTxt+"</span>");
		}else{
			item.parent().append('<div class="helper"><span class="validation-error '+validationType+'">'+errorTxt+'</span></div>');
		}
	}

	/**
	 * Checks if an amount is valid
	 * 
	 * @param  {string} value The value to be validated
	 * @return {boolean} Validation result
	 */
	this.checkValidAmount = function(value){
		var error = false;

		value = value.trim();
		
		if(value == ""){
			error = true;
		}else{
			//if we have more than one ,
			//first found is not the last one too..
			if(value.indexOf(decimal_separator, 0) != value.lastIndexOf(decimal_separator)){
				error = true;
			}
			if(value == "." || value == ","){
				error = true;
			}
			/*if(value.indexOf(".", 0) != value.lastIndexOf(".")){
				error = true;
			}*/
			/*if(locale == "en_US" && value.indexOf(",", 0)){
				error = true;
			}
			if(locale == "ro_RO" && value.indexOf(".", 0)){
				error = true;
			}*/
		}

		return error;
	}

	/**
	 * Check if a list has a selected item or not
	 * 
	 * @param  {HTMLElement} item The item to be validated
	 * @return {boolean} Validation result
	 */
	this.checkHasSelected = function(item){
		var error = false;
		if(!item.children("li").hasClass("selected")){
			error = true;
		}else{
			if(item.children("li.selected").hasClass("filter")){
				error = true;
			}
		}
		
		return error;
	}

	/**
	 * Check if a value is empty or not
	 * 
	 * @param  {string} value The value to be validated
	 * @return {boolean} Validation result
	 */
	this.checkNotEmpty = function(value){
		var error = false;
		if(value == undefined){
			error = true;
		}else if(value.trim() == ""){
			error = true;
		}
		
		return error;
	}

	/**
	 * Check if a value is a valid iban or not
	 * 
	 * @param  {string} value The value to be validated
	 * @return {boolean} Validation result
	 */
	this.checkValidIban = function(value){
		var error = false;
		var iban = value.trim();
		if(iban != ''){
			if(iban.length < 24){
				error = true;
			}else if(iban.substring(0, 2) != "RO"){
				error = true;
			}
		}else{
			error = true;
		}
		
		return error;
	}

	/**
	 * Check if a value is equal to another. Special validation!
	 * 
	 * The array contains 3 values
	 * 1. The value to be validated
	 * 2. The comparison to be made [equal, not_equal]
	 * 3. The comparison value
	 * 
	 * @param  {array} value
	 * @return {boolean} Validation result
	 */
	this.checkEquality = function(item){
		var error = false;

		var value = item[0].trim();
		var compareType = item[1];
		var compareValue = item[2].trim();

		if(compareType == "equal"){
			if(value != compareValue){
				error = true;
			}
		}else if(compareType == "not_equal"){
			if(value == compareValue){
				error = true;
			}		
		}

		return error;
	}

	/**
	 * Check if a value has more or less characters than we want. Special validation!
	 * 
	 * The array contains 3 values
	 * 1. The value to be validated
	 * 2. The comparison to be made [min, max, exactly]
	 * 3. The number to compare with
	 * 
	 * @param  {array} value
	 * @return {boolean} Validation result
	 */
	this.checkCharLength = function(item){
		var error = false;

		var value = item[0].trim();
		var compareType = item[1];
		var size = item[2];

		if(compareType == "min"){
			if(value.length < size){
				error = true;
			}
		}else if(compareType == "max"){
			if(value.length > size){
				error = true;
			}
		}else if(compareType == "exactly"){
			if(value.length != size){
				error = true;
			}
		}

		return error;
	}

	/**
	 * Check if a value (number) is bigger/smaller than we want. Special validation!
	 * 
	 * The array contains 3 values
	 * 1. The value to be validated
	 * 2. The comparison to be made [min, max]
	 * 3. The number to compare with
	 * 
	 * @param  {array} value
	 * @return {boolean} Validation result
	 */
	this.checkCompareNumbers = function(item){
		var error = false;

		var value = amount_to_number(item[0].trim());
		var compareType = item[1];
		var limit = amount_to_number(item[2]);

		if(compareType == "min"){
			if(value < limit){
				error = true;
			}
		}else if(compareType == "max"){
			if(value > limit){
				error = true;
			}
		}

		return error;
	}

	/**
	 * Validates if a checkbox is checked
	 * 
	 * @param  {HTMLElement} item The checkbox to be validated
	 * @return {boolean} Validation result
	 */
	this.checkIsChecked = function(item){
		var error = false;

		if(!item.attr("checked")){
			error = true;
		}

		return error;
	}

	/**
	 * Validates if a number is equal to zero or not
	 * @param  {float} value The value to be validated
	 * @return {boolean} Validation result
	 */
	this.checkNotZero = function(value){
		var error = false;

		value = amount_to_number(value.trim());
		if(value == 0){
			error = true;
		}

		return error;
	}

	/**
	 * Validates if a value has a valid email structure
	 * 
	 * @param  {string} value The value to be validated
	 * @return {boolean} Validation result
	 */
	this.checkIsEmail = function(value) {
		var error = false;

		var email = value.trim();

		var regex = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(regex.test(email) == false) {
			error = true;
		}

		return error;
	}

	/**
	 * Validates if a value has at least one letter in it
	 * 
	 * @param  {string} value The value to be validated
	 * @return {boolean} Validation result
	 */
	this.checkHasLetter = function(value) {
		var error = false;

		value = value.trim();

		var regex = /[a-zA-Z]/;
		if(regex.test(input) == false) {
			error = true;
		}

		return error;
	}

	/**
	 * Validates if a value has at least one number in it
	 * 
	 * @param  {string} value The value to be validated
	 * @return {boolean} Validation result
	 */
	this.checkHasNumber = function(value) {
		var error = false;

		value = value.trim();

		var regex = /[0-9]/;
		if(regex.test(input) == false) {
			error = true;
		}

		return error;
	}

});