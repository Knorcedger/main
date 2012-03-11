//today_date must be given: 22/02/2012

//calculate today, yesterday, one month back
var temp = today_date.split("/");

var today = new Date(temp[2], temp[1], temp[0]);

//calculate yesterday
var yesterday = new Date();
yesterday.setDate(today.getDate()-1);
var yesterday_date = add_zero(yesterday.getDate()) + "/" + add_zero(yesterday.getMonth() + 1) + "/" + yesterday.getFullYear();

//calculate one month back
var one_month_back = new Date();
var days_in_previous_month = 32 - new Date(today.getFullYear(), today.getMonth()-2, 32).getDate();
one_month_back.setDate(today.getDate()-days_in_previous_month);
var one_month_back_date = add_zero(one_month_back.getDate()) + "/" + add_zero(one_month_back.getMonth() + 1) + "/" + one_month_back.getFullYear();

function add_zero(value){
	if(value < 10){
		var result = '0' + value;
	}else{
		var result = value;
	}

	return result;
}