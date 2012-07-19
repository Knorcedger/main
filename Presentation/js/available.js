var availableClasses = {
	"selected": "Used to indicate a selected item in lists, or dropdowns (dsq-dialog)",
	"dialog-message-button": "If that button has an id='button-delete', it will open the modal with id='modal-delete'",
	"save-state-classes": "Please refer to the save state documentation",
	"format-iban": "Resizes the iban inside an input field so that it fits inside the input field",
	"iban": "Splits the iban in group of 4 characters",
	"no-reset": "Used to prevent a field from being reset on reset button click",
	"none-preselected": "Used for dropdowns, to make them reset to no-option-selected status",
	"has-counter": "Indicates that a field has a character counter next to it",
	"non-selectable": "Can be used only on an li item inside a .list item and makes this a li not selectable"
	"single-preselect": "Is applied on .list only and makes this list preselect the li if it has only one",
	"resizable": "The .list that has this class can have its height changed",
	"filter": "Applied on li and means that this is a special li that contains an input field",
	".hidden-value": "Used for spans to save values that js needs"
}

/**
 * The following functions are not a part of an object and if defined, will be called after certain actions
 */
var callbackFunctions = {
	"listClicked": "If defined, triggered after an li inside a .list was clicked. Not triggered for .non-selectable",
	"listActionClicked": "If defined, triggered when an action (the little buttons at the right of an li inside a list) is called",
	"listAllowClick": "If defined and returns false, it will stop the usual list action click or list click from executing",
	"checkboxWithDialogClicked": "If defined, triggered when a checkbox that opens a dialog is clicked (like agree with terms)",
	"dialogClicked": "If defined, triggered when a selection is made (click on li) in a dropdown"
}

var availableObjects = {
	"all": "Please check the js/library/ folder. All available objects must reside in there"
}

var attachedEvents = {
	"all": "Various events exist for small things that happen more than once on the website"
}