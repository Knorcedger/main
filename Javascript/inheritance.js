/**
 * Define Person
 */
var Person = function() {
		this.sex = "dont know";
	};
Person.prototype.sleep = function() {
	console.log("Im sleeping and im a " + this.sex);
};

/**
 * Define man
 */
var Man = function() {
		this.sex = "male";
	}

/**
 * Man inherits Person
 * Both following lines work the same way. Me like the second better
 * @type {Person}
 */
// Man.prototype = Object.create(new Person());
Man.prototype = new Person();
Man.prototype.wake = function() {
	console.log("Im awake");
};
/**
 * We overwrite the sleep function, but we also call the "super".
 * We use apply this to change this keywork
 *
 * @return {[type]} [description]
 */
Man.prototype.sleep = function() {
	Person.prototype.sleep.apply(this);
	console.log("Im snooring");
};
/*//var o = f();
var o = new Object();  
o.prototype = f.prototype; */
var me = new Man();
console.log(me);
me.sleep();