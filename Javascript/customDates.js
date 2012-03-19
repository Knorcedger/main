// TODO: Make it work with a today date given by server
// TODO: 11/03/2012, shows one month back as 09/02/2012

var customDates = {

	"today": "",

	todayDate: function(){
		var today = new Date();
		var todayDate = this.addZero(today.getDate()) + '/' + this.addZero(today.getMonth() + 1) + '/' + today.getFullYear();

		return todayDate;
	},

	yesterdayDate: function(){
		var yesterday = new Date();
		var yesterdayDate = this.addZero(yesterday.getDate()) + "/" + this.add_zero(yesterday.getMonth() + 1) + "/" + yesterday.getFullYear();

		return yesterdayDate;
	},

	oneMonthBackDate: function(){

		var oneMonthBack = new Date();
		var daysInPreviousMonth = this.daysInMonth(today.getMonth(), today.getFullYear());
		oneMonthBack.setDate( - (daysInPreviousMonth - today.getDate()));
		var oneMonthBackDate = thisaddZero(oneMonthBack.getDate()) + "/" + thisaddZero(oneMonthBack.getMonth() + 1) + "/" + oneMonthBack.getFullYear();

		return oneMonthBackDate;
	},

	daysInMonth: function(month, year) {
		return 32 - new Date(today.getFullYear(), today.getMonth()-1, 32).getDate();
	},

	addZero: function(value){
		if(value < 10){
			var result = '0' + value;
		}else{
			var result = value;
		}

		return result;
	}
	
}