$(document).ready(function(){
 
	var curr = new Date;

	//var firstday = new Date(curr.setDate(curr.getDate() - curr.getDay()));
	var smonth = new Date(curr.setDate(curr.getDate() - curr.getDay())).getMonth()+1;
	var sdate = new Date(curr.setDate(curr.getDate() - curr.getDay())).getDate();
	var syear = new Date(curr.setDate(curr.getDate() - curr.getDay())).getFullYear();

	//var last = new Date(curr.setDate(curr.getDate() - curr.getDay()+6));
	var lmonth = new Date(curr.setDate(curr.getDate() - curr.getDay()+6)).getMonth()+1;
	var ldate = new Date(curr.setDate(curr.getDate() - curr.getDay()+6)).getDate();
	var lyear = new Date(curr.setDate(curr.getDate() - curr.getDay()+6)).getFullYear();

	// $('#date-info').text("Displaying Tasks from "+smonth+"/"+sdate+"/"+syear+" - "+lmonth+"/"+ldate+"/"+lyear);
	// $("#from").html(smonth+"/"+sdate+"/"+syear);
	// $("#to").val(lmonth+"/"+ldate+"/"+lyear);
 
});

