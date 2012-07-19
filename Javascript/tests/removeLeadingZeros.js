// TODO: Make it work with a today date given by server
// TODO: 11/03/2012, shows one month back as 09/02/2012

var leadingZeros = {

	remove: function(value){
		var result = value.replace(/^[0]+/g, "");

		return result;
	}
	
}