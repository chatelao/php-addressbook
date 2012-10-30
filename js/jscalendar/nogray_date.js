/* 

Script: nogray_date.js 

	these functions will extend javascript Date object

 

License: 

	http://www.nogray.com/license.php

		

provided by the NoGray.com

by Wesam Saif

support: support@nogray.com

*/ 



var _ng_date_object = {

	/*

		Variable:

			language

			

			an object that contain the language to be used in formatting

			the output from the print function

			

		Example

			alert(new Date().language.days.short[1]); // will alert Mo

	*/

	language:{

		'days':{

			'char':['S','M','T','W','T','F','S'],

			'short':['Su','Mo','Tu','We','Th','Fr','Sa'],

			'mid':['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],

			'long':['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']

		},

		'months':{

			'short':['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],

			'long':['January','February','March','April','May','June','July','August','September','October','November','December']

		},

		'am_pm':{

			'lowerCase':['am','pm'],

			'upperCase':['AM','PM']

		}

	},

	

	/*

		Function:

			daysInMonth

		

		Returns:

			the number of days in the date month

			

		Example:

			alert(new Date(2007, 8, 1).daysInMonth());	// will alert 30 (30 days in Septembar)

	*/

	daysInMonth : function (){

		var date = new Date(this.getFullYear(), this.getMonth(), 28);

		var i = 28;

		for (i=28; i<=32; i++){

			date.setDate(i);

			if (date.getMonth() != this.getMonth())

				return (i-1);

		}

	},

	

	/*

		Function:

			isLeapYear

		

		Returns:

			Boolean. True if the yea is a leap year, false otherwise

			

		Example:

			alert(new Date(2008,0,1).isLeapYear());	// will alert true

			alert(new Date(2009,0,1).isLeapYear()); // will alert false

	*/

	isLeapYear: function (){

		var date = new Date(this.getFullYear(), 1, 29);

		return (date.getMonth() == 1);

	},

	

	/*

		Function:

			fromString

			

		Returns:

			a date object from the string provided

			

		Arguments:

			str: the string variable for the date. If the date can't be parsed using Date.parse() a list of custom values are provided below.

				All custom values are relative to the date object 

			Possible values:

			- Any string that can be parsed by Date.parse()

				* Short dates can use either a "/", "\" or "-" date separator, but must follow the month/day/year format, for example "7/20/96".

					month are 1 for January 12 for December

				* Long dates of the form "July 10 1995" can be given with the year, month, and day in any order, and the year in 2-digit or 4-digit form. If you use the 2-digit form, the year must be greater than or equal to 70. 

				* Month and day names must have two or more characters. Two character names that are not unique are resolved as the last match. For example, "Ju" is resolved as July, not June. 

				* Handles all standard time zones, as well as Universal Coordinated Time (UTC) and Greenwich Mean Time (GMT).

				* Colons separate hours, minutes, and seconds, although all need not be specified. "10:", "10:11", and "10:11:12" are all valid.

				* If the 24-hour clock is used, it is an error to specify "PM" for times later than 12 noon. For example, "23:15 PM" is an error. 

				* A string containing an invalid date is an error. For example, a string containing two years or two months is an error. 

			- "yesterday" a day before relative to the date object

			- "tomorrow" a day after relative to the date object

			- "today+[n]" [n] is any number

				add the [n] number of days to the date

			- "today-[n]" [n] is any number

				subtract the [n] number of days from the date

			- "last month" a month before relative to the date object

			- "next month" a month after relative to the date object

			- "month+[n]" [n] is any number

				add the [n] number of months to the date

			- "month-[n]" [n] is any number

				subtract the [n] number of days from the date

			- "last year"

			- "next year"

			- "year+[n]"

			- "year-[n]"

			

		Example:

			alert(new Date().fromString("yesterday"));	// will alert yesterday's day



	*/

	fromString: function(str){

		var prs_dt = Date.parse(str.replace(/[-|\\]/g,"/"));

		

		if (isNaN(prs_dt)){

			str = str.toLowerCase();

			str = str.replace(/(\s)*([\+|-])(\s)*/g, "$2");

			

			var y = this.getFullYear();

			var m = this.getMonth();

			var d = this.getDate();

			

			str = str.replace("yesterday", "today-1")

					.replace("tomorrow", "today+1")

					.replace("last month", "month-1")

					.replace("next month", "month+1")

					.replace("last year", "year-1")

					.replace("next year", "year+1");

			

			if(str.indexOf("today+") >= 0)

				d = d+str.replace("today+","").toInt();

			else if(str.indexOf("today-") >= 0)

				d = d-str.replace("today-","").toInt();

			else if(str.indexOf("month+") >= 0){

				m = m+str.replace("month+","").toInt();

				var mx_dys = new Date(y, m, 1).daysInMonth();

				if (d > mx_dys) d = mx_dys;

			}

			else if(str.indexOf("month-") >= 0){

				m = this.getMonth()-str.replace("month-","").toInt();

				var mx_dys = new Date(y, m, 1).daysInMonth();

				if (d > mx_dys) d = mx_dys;

			}

			else if(str.indexOf("year+") >= 0){

				y = y+str.replace("year+","").toInt();

				var mx_dys = new Date(y, m, 1).daysInMonth();

				if (d > mx_dys) d = mx_dys;

			}

			else if(str.indexOf("year-") >= 0){

				y = this.getFullYear()-str.replace("year-","").toInt();

				var mx_dys = new Date(y, m, 1).daysInMonth();

				if (d > mx_dys) d = mx_dys;

			}

			

			var dt = new Date(y, m, d, this.getHours(), this.getMinutes(), this.getSeconds(), this.getMilliseconds());

		}

		else {

			var dt = new Date(prs_dt);	

		}

		

		return dt;

	},

	

	/*

		Function:

			fromObject

			

		Returns:

			a date from the object provided

			

		Arguments:

			date_obj: an object that hold the date values

				the date_obj should have the following attributes

				

				- date: can be either a number or a string

					if string, the following values are allowed

					* "[1st | 2nd | 3rd | 4th | 5th | last] sunday" either the 1st, 2nd, or 3rd, etc... sunday of the month.

						will return the date for the [nth] or last sunday of the month

					* "[1st | 2nd | 3rd | 4th | 5th | last] monday" same as above but for monday

					* "[1st | 2nd | 3rd | 4th | 5th | last] tuesday"

					* "[1st | 2nd | 3rd | 4th | 5th | last] wednesday"

					* "[1st | 2nd | 3rd | 4th | 5th | last] thursday"

					* "[1st | 2nd | 3rd | 4th | 5th | last] friday"

					* "[1st | 2nd | 3rd | 4th | 5th | last] saturday"

				- month: a numerical value for the month

						0 for January 11 for December

				- year: a numerical value for the year (for digits format)

				- hour: a numerical value for the hour

				- minute: a numerical value for the minute

				- second: a numerical value for the second

				- millisecond: a numerical value for the millisecond

				

				if any of the values above is not defined, the current date value will be used.

				

			Example:

				alert(new Date(2007,8,1).fromObject({'date':'last friday'}));	// will alert the date for Sep 28th 2007

				alert(new Date(2007,8,1).fromObject({'date':'3rd Monday'}));	// will alert the date for Sep 17th 2007

					

	*/

	fromObject: function(date_obj){

		var obj = {};

		var p;

		for (p in date_obj)

			obj[p] = date_obj[p];

			

		

		if (!$defined(obj.date)) obj.date = this.getDate();

		if (!$defined(obj.month)) obj.month = this.getMonth();

		if (!$defined(obj.year)) obj.year = this.getFullYear();

		if (!$defined(obj.hour)) obj.hour = this.getHours();

		if (!$defined(obj.minute)) obj.minute = this.getMinutes();

		if (!$defined(obj.second)) obj.second = this.getSeconds();

		if (!$defined(obj.millisecond)) obj.millisecond = this.getMilliseconds();

				

		if ($type(obj.date) != "string"){

			var dt = new Date(obj.year, obj.month ,obj.date, obj.hour, obj.minute, obj.second, obj.millisecond);

			return dt;

		}

		

		obj.date = obj.date.toLowerCase();

		var date = new Date(obj.year, obj.month, 1);



		var cur_dy;

		if (obj.date.indexOf("sunday") != -1)

			cur_dy = 0;

		else if (obj.date.indexOf("monday") != -1)

			cur_dy = 1;

		else if (obj.date.indexOf("tuesday") != -1)

			cur_dy = 2;

		else if (obj.date.indexOf("wednesday") != -1)

			cur_dy = 3;

		else if (obj.date.indexOf("thursday") != -1)

			cur_dy = 4;

		else if (obj.date.indexOf("friday") != -1)

			cur_dy = 5;

		else if (obj.date.indexOf("saturday") != -1)

			cur_dy = 6;

			

		

		if (date.getDay() > cur_dy)

			var fd = (7 - date.getDay()) + cur_dy + 1;

		else if (date.getDay() < cur_dy)

			var fd = cur_dy -  date.getDay() + 1;

		else

			var fd = 1;

						

		var rp_arr = ["1st","2nd","3rd","4th","5th"];

		var c=5;

		var dnm = date.daysInMonth();

		while(obj.date.indexOf("last") != -1){

			if ((fd+(c*7)) <= dnm)

				obj.date = obj.date.replace("last",rp_arr[c]);

			c--;

			if (c < 0)

				obj.date = obj.date.replace("last","1st");

		}

		

		var after_dys;

		if (obj.date.indexOf("1st") != -1)

			after_dys = 0;

		else if (obj.date.indexOf("2nd") != -1)

			after_dys = 1;

		else if (obj.date.indexOf("3rd") != -1)

			after_dys = 2;

		else if (obj.date.indexOf("4th") != -1)

			after_dys = 3; 

		else if (obj.date.indexOf("5th") != -1)

			after_dys = 4;

		

		var dt = new Date(obj.year, obj.month, fd+(after_dys*7), obj.hour, obj.minute, obj.second, obj.millisecond);

		return dt;

	},

	

	/*

		Function:

			print

		

		Returns:

			a formatted date string similar to PHP date function

			

		Arguments:

			format: a string to format the return value from the date

				Please visit http://us.php.net/manual/en/function.date.php for more details

				on the possible values

				

				the only exception is the Y and o will return the same value

				

			lang:

				a language object if using a different language than the date object

				

		Example:

			alert(new Date(2007,8,12).print("D, d M Y")); // will alert Wed, 12 Sep 2007

				

	*/

	print: function(format, lang){

		if (!$defined(lang)) lang = this.language;

		else {

			if ($defined(lang.days)){

				if (!$defined(lang.days['char'])) lang.day['char'] = this.language.days['char'];

				if (!$defined(lang.days['short'])) lang.day['short'] = this.language.days['short'];

				if (!$defined(lang.days['mid'])) lang.day['mid'] = this.language.days['mid'];

				if (!$defined(lang.days['long'])) lang.day['long'] = this.language.days['long'];

			}

			else

				lang.days = this.language.days;

			

			if ($defined(lang.months)){

				if (!$defined(lang.months['short'])) lang.months['short'] = this.language.months['short'];

				if (!$defined(lang.months['long'])) lang.months['long'] = this.language.months['long'];

			}

			else

				lang.months = this.language.months;

				

			if ($defined(lang.am_pm)){

				if (!$defined(lang.am_pm['lowerCase'])) lang.am_pm['lowerCase'] = this.language.am_pm['lowerCase'];

				if (!$defined(lang.am_pm['upperCase'])) lang.am_pm['upperCase'] = this.language.am_pm['upperCase'];

			}

			else

				lang.am_pm = this.language.am_pm;

		}

		var i=0;

		var re = "";

		var ch = "";

		

		for (i=0; i<format.length; i++){

			ch = format.charAt(i);

			if (ch == "d"){

				if (this.getDate() < 10) re += "0";

				re += this.getDate();

			}

			else if (ch == "D")

				re += lang.days['mid'][this.getDay()];

			else if (ch == "j")

				re += day;

			else if (ch == "l")

				re += lang.days['long'][this.getDay()];

			else if (ch == "N"){

				var num = this.getDay();

				if (num == 0) num = 7;

				re += num;

			}

			else if (ch == "S"){

				if ((this.getDate() == "1") || (this.getDate() == "21") || (this.getDate() == "31"))

					re += "st";

				else if ((this.getDate() == "2") || (this.getDate() == "22"))

					re += "nd";

				else if ((this.getDate() == "3") || (this.getDate() == "23"))

					re += "rd";

				else

					re += "th";

			}

			else if (ch == "w")

				re += this.getDay();

			else if (ch == "z")

				re += this.getDayInYear();

			else if (ch == "F")

				re += lang.months['long'][this.getMonth()];

			else if (ch == "M")

				re += lang.months['short'][this.getMonth()];

			else if (ch == "m"){

				if (this.getMonth()+1 < 10) re += 0;

				re += this.getMonth()+1;

			}

			else if (ch == "n")

				re += this.getMonth();

			else if (ch == "t")

				re += this.daysInMonth();

			else if (ch == "L"){

				if (this.isLeapYear())

					re += 1;

				else

					re += 0;

			}

			else if ((ch == "Y") || (ch == "o"))

				re += this.getFullYear();

			else if (ch == "y")

				re += this.getFullYear().toString().substr(2,2);

				

			else if (ch == "a"){

				if (this.getHours() < 12)

					re += lang.am_pm['lowerCase'][0];

				else

					re += lang.am_pm['lowerCase'][1];

			}

			else if (ch == "A"){

				if (this.getHours() < 12)

					re += lang.am_pm['upperCase'][0];

				else

					re += lang.am_pm['upperCase'][1];

			}

			else if (ch == "B")

				re += this.toSwatchInternetTime();

			else if (ch == "g"){

				var hr = (this.getHours()%12);

				if (hr == 0) hr = 12;

				re += hr;

			}

			else if (ch == "G")

				re += this.getHours();

			else if (ch == "h"){

				var hr = (this.getHours()%12);

				if (hr == 0) hr = 12;

				if (h < 10) r += 0;

				re += hr;

			}

			else if (ch == "H"){

				if (this.getHours() < 10) re += 0;

				re += this.getHours();

			}

			else if (ch == "i"){

				if (this.getMinutes() < 10) re += 0;

				re += this.getMinutes();

			}

			else if (ch == "s"){

				if (this.getSeconds() < 10) re += 0;

				re += this.getSeconds();

			}

			else if (ch == "u")

				re += this.getMilliseconds();

			else if ((ch == "O") || (ch == "P")){

				var hr = (this.getTimezoneOffset())/60;

				var mn = hr - Math.floor(hr);

				mn = mn*60;

				hr = Math.floor(hr);

				mn = Math.floor(mn);

				if (hr == 0) hr = "00";

				else if ((hr > -10) && (hr < 0)) hr = "-0"+Math.abs(hr); 

				else if ((hr < 10) && (hr > 0)) hr = "0"+hr;

				else hr = hr.toString();

				if (hr > 0) re += "+";

				if (mn < 10) mn = "0"+mn;

				else mn = mn.toString();

				if (ch == "P") var sep = ":";

				else var sep = "";

				re += hr+sep+mn;

			}

			else if (ch == "Z")

				re += this.getTimezoneOffset();

			else if (ch == "c"){

				format = format.substr(0, i-0)+"Y-m-dTH:i:sP"+format.substr(0, i);

				i--;

			}

			else if (ch == "r"){

				format = format.substr(0, i-0)+"D, d M Y H:i:s O"+format.substr(0, i);

				i--;

			}

			else if (ch == "U")

				re += Math.floor(this.timeDifference(new Date(1970,0,1))/1000);

			else

				re += ch;

				

		}

		

		return re;	

	},

	

	

	/*

		Function:

			getWeekInYear

		

		Returns:

			the number of week in the year

			

		Example:

			alert(new Date(2007,8,12).getWeekInYear());	// will alert 36

	*/

	getWeekInYear: function(){

		return Math.floor(this.getDayInYear()/7);	

	},

	

	/*

		Function:

			getDayInYear

		

		Returns:

			the number of day in the year

			

		Example:

			alert(new Date(2007,8,12).getDayInYear());	// will alert 253

	*/

	

	getDayInYear: function(){

		return Math.floor(this.getHourInYear()/24);	

	},

	

	getHourInYear: function(){

		return Math.floor(this.getMinuteInYear()/60);

	},

	

	getMinuteInYear: function(){

		return Math.floor(this.getSecondInYear()/60);

	},

	

	getSecondInYear: function(){

		return Math.floor(this.getMillisecondInYear()/1000);

	},

	

	

	getMillisecondInYear: function(){

		return this.timeDifference(new Date(this.getFullYear(), 0, 1));

	},

	

	/*

		Function:

			getWeekSince

		

		Returns:

			the number of week since a given date

			

		Arguments:

			date: a javascript date object

			

		Example:

			alert(new Date(2007,8,12).getWeekSince(new Date(2006,2,14)));	// will alert 78

	*/

	

	getWeekSince: function(date){

		return Math.floor(this.getDaySince(date)/7);	

	},

	

	

	/*

		Function:

			getDaySince

		

		Returns:

			the number of days since a given date

			

		Arguments:

			date: a javascript date object

			

		Example:

			alert(new Date(2007,8,12).getDaySince(new Date(2006,2,14)));	// will alert 547

	*/

	

	getDaySince: function(date){

		return Math.floor(this.getHourSince(date)/24);	

	},

	

	getHourSince: function(date){

		return Math.floor(this.getMinuteSince(date)/60);

	},

	

	getMinuteSince: function(date){

		return Math.floor(this.getSecondSince(date)/60);

	},

	

	getSecondSince: function(date){

		return Math.floor(this.getMillisecondSince(date)/1000);

	},

	

	getMillisecondSince: function(date){

		return this.timeDifference(date);

	},

	

	

	/*

		Function:

			timeDifference

			

		Returns:

			return the time difference in milliseconds between the date and the arguments date

			

		Arguments:

			date: javascript date

			

		Example:

			alert(new Date(2007,8,12).timeDifference(new Date(2006,2,14))); // will alert 47260800000

	*/

	timeDifference: function(date){

		return this.getTime() - date.getTime();	

	},

	

	/*

		Function:

			toSwatchInternetTime

			for more details about the Swatch Internet Time, please visit http://www.swatch.com/internettime/

			

		Returns:

			the number of beats as a string (including the @ sign)

			This function assume the browser handles the time zone and day time saving

			

		Example:

			alert(new Date(2007,8,12,8,52,0).toSwatchInternetTime()); // will alert @702 (based on timezone)

		

	*/

	

	

	toSwatchInternetTime: function(){

		var sec = (this.getHours() * 3600) + (this.getMinutes() * 60) + this.getSeconds() + ((this.getTimezoneOffset() + 60)*60);

		var beat = Math.floor(sec/86.4);

		return ("@"+beat);

	},

	

	/*

		Function:

			fromSwatchInternetTime

			for more details about the Swatch Internet Time, please visit http://www.swatch.com/internettime/

			

		Returns:

			a javascript date object (approximate time)

			This function assume the browser handles the time zone and day time saving

			

		Arguments:

			beat: the beat value

			

		Example:

			alert(new Date().fromSwatchInternetTime(354)); // will alert the time at 10:47:31 (based on timezone)

	*/

	

	fromSwatchInternetTime: function (beat){

		if ($type(beat) == "string") beat = beat.replace("@","").toInt();

		var sec = Math.floor(beat*86.4) - ((this.getTimezoneOffset() + 60)*60);

				

		var dt = new Date(this.getFullYear(), this.getMonth(), this.getDate());

		dt.setTime(dt.getTime()+(sec*1000));

		

		return dt;

	}

	

	

};



try {

	$native(Date);

	Date.extend(_ng_date_object);

}

catch(e) {

	Native.implement([Date], _ng_date_object);	

}



delete _ng_date_object;