//------------------------ DEHABILITA DIAS -------------------------------------
export function noLaborales(date) {
	var i = 0;
	var fechanueva = new Date();
	var ano = fechanueva.getFullYear();


	var disabledDays = 
		//m-d-aaaa
		[
		"1-1-"+ano, "1-2-"+ano, "1-3-"+ano, "1-4-"+ano, "1-7-"+ano,
		"2-4"+ano, 
		"3-18-"+ano,
		"4-18-"+ano, "4-19-"+ano,
		"5-1-"+ano,
		"7-22-"+ano,"7-23-"+ano,"7-24-"+ano,"7-25-"+ano,"7-26-"+ano,
		"9-16-"+ano,
		"11-18-"+ano,
		"12-23-"+ano,"12-24-"+ano,"12-25-"+ano,"12-26-"+ano,"12-27-"+ano,"12-30-"+ano,"12-31-"+ano
		];


		var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
		var day = date.getDay();
		for (i = 0; i < disabledDays.length; i++) 
		{
			if (day == 0 || day == 6) {	return [false, ""]	}
			if($.inArray((m+1) + '-' + d + '-' + y,disabledDays) != -1) {return [false];}
		}
		return [true];
}
