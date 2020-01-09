/**
 * Contains the functions that modify various GUI elements in the 
 * WPAdmin interface.
 * @version 1.0
 */

jQuery(document).ready(function($){
    moveRememberMeCheckBox($);
    checkRememberMeCheckBox($);
});

/**
 * Moves the "Remember Me" button below the Log In button.
 * @param $ - the jQuery selector. 
 */
function moveRememberMeCheckBox($) {
    $('.forgetmenot').appendTo('.submit');
}
/**
 * Checks the "Remmeber Me" checkbox.
 * @param {jQuery} $ 
 */
function checkRememberMeCheckBox($) {
    $('#rememberme').prop('checked', true);
}