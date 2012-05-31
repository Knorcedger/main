Το μάθημα θα έχει δύο σκέλη, όπως και η πρώτη παρουσίαση. 1. τι ισχύει γενικά την javascript. 2. Τι κάνουμε εμείς στο AIBAS

Για το 2 πρέπει να είμαστε πολύ αναλυτικοί καθώς θα κάνω code review, και ότι δεν είναι σωστό θα το γυρίζω πίσω. Για να δείξω όμως ότι κάτι δεν είανι σωστό, πρέπει να μπορώ να αποδείξω ότι δεν τηρήθηκε κάτι που δεν είπαμε στην παρουσίαση.

JavaScript and jscript, explain browser implementations
automatic semicolor insertion
js, js variables
validator explanation
ODate.js as an object example
coding standards
dsq-dialogs, lists, all go through main

use strict example with global variable declaration https://developer.mozilla.org/en/JavaScript/Strict_mode
for (i = 0; i < 1; i++) {
		//
	};
no more wrong variable names (to Daphne :)

comma operator
var x, y, z;
var x = y = z = 1;

javascript evaluation is sequential

for (
    var i=2, r=[0,1];
    i<15;
    r.push(r[i-1] + r[i-2]), i++
); 

r //"0,1,1,2,3,5,8,13,21,34,55,89,144,233,377"

(function(){}()); selfexecuting/selfinvoked function

use jshint
use jsbeautifier
proper documentation with jsDoc
classes we use (e.g. check-iban, numeric-validated)
ODate.js as example or something from main.js e.g. scroll

difference between == and ===. Example g = 1, t = "1", use: typeof g

js is loosely types -> myf function(f, g), call: myf(), will use undefined,and the opposite, myf(1, 2, 3)

explain the scope -> https://developer.mozilla.org/en/JavaScript/Reference/Functions_and_function_scope
Javascript cannot just put a variable anywhere. It must belong to a variable container. 
If you are not in a variable container, javascript will look for the first pair of curly braces that represents a container. This is usually the function itself. 
So if you declare a variable inside a for loop, since the for loop is not a container, the function which contains the for loop will become the owner of this variable.

explain js variable types
which expressions === false (0, "", null, undefined, false, NaN)
is js all numbers are floats, thus 0.1 + 0.2 !== 0.3

define functions like this var getData = function getData() { }; in order to their name appear in the callstack TESTED, NAMES ALWAYS APPEAR IN CHROME
also other ways are  function name(), var name = function(), var name = new Function(), the last one is different and inefficient and must not be used, the same applies for New Number, new Boolean, New String
example new String("that") == "that", and use ===. Then use typeof to see the type

'' == '0'          // false
0 == ''            // true
0 == '0'           // true

false == 'false'   // false
false == '0'       // true

false == undefined // false
false == null      // false
null == undefined  // true
console.log(new Boolean(false)); // false, its an object

explain type coersion -> http://javascriptweblog.wordpress.com/2011/02/07/truth-equality-and-javascript/
1 == true //true
2 == true //false
when comparing, everything is converted to number before the actual comparing takes place

JavaScript lacks structural equality by default. [1, 2, 3] == [1, 2, 3] and [1, 2, 3] === [1, 2, 3] both evaluate to false

documentation in mainly in mdn, dont use w3schools

var f = p && p.name;

sync ajax calls must be avoid, see the mess we created in payments.js. The way to avoid it is, caller -> ajax -> resultfunction

how we debug js. alert and console an object to show why we use console. console may crash ie, so use this script,
currenctly found on top of settings.js// This will prevent js to crash on IE when cosnole is used
if (typeof console == "undefined" || typeof console.log == "undefined") var console = { log: function() {} }; 
show example breakpoint, use the the function definition we showed before to explain the call stack
breakpoints on elements change can be added too
event listeners breakpoints
pause on exceptions (usefull when an error happens inside a for loop, but it happens sometimes)
can view/change values
can edit js and css while paused.
all edits are saved as revisions and can be viewed in resources
example with console.dir console.dir(myFunction)
debugger command when an error happens on load.
How to make breadpoints being saved during page changes/refreshes

standardize ajax request format
response.hasErrors
response.errorMessage
response.data
Create one js function (not sure if it will be a separate file, maybe it fits inside main.js) that will handle all ajax requests

define js file structure

use ids to pass as argument into functions when possible, not $("#test"), or "#test"

Θα σταματήσουμε να χρησιμοποιούμε -variables.jsp αρχεία, αφού όλα τα requests θα περνάνε πλέον από το AjaxRequest

json