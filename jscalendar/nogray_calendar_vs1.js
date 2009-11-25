/* 

Script: nogray_calendar_vs1.js 

	Calendar class (see below)

 

License: 

	http://www.nogray.com/license.php

		

provided by the NoGray.com

by Wesam Saif

http://www.nogray.com

support: support@nogray.com

*/

/*

Class:

	Calendar

	The calendar class will create a calendar component and attach it to

	an input field or drop down select menus. It uses the nogray_date.js for

	easier formatting and date processing.

	

	features:

	create any numbers of months per calendar

	

	set the weekend, days off, holidays (dates off), start day of the week

	

	start and end date

	

	multiselection and limits

	

	and much more....

	

	

	date object:

	The calendar can process any format of date when supplying options or arguments

	The date object can be one of the following

		- JavaScript Date

		- a Date in a string format (check nogray_date.js for details)

		- a Date in an object format (check nogray_date.js for details)

		- a number (JavaScript time value- number of milliseconds)

		

	

	

Options:

	visible: indicates weather the calendar will be visible when loaded or not

			default is false

			

	offset:	The calender by default will show at the lower left corner of the input field.

			offset allows for moving the offsetting the calendar position

			default x:0 y:0

			

	dateFormat: The format of the date output (for text field).

				check nogray_date.js for details

				check http://us3.php.net/manual/en/function.date.php for formatting details

				default D, d M Y

				

	numMonths: the number of months per calendar

				Warrning: Firefox is a little slow when handling date objects. If using datesoff or forcedSelection

				try to use 1 month per calendar

				default 1

				

	classPrefix: the CSS class prefix, check the skining manual for instructions

			default ng-

	

	idPrefix: the id prefix for the dates, use this if using more than one calendar

			default ng-

			

	startDay: the first day of the week 0 for Sunday 6 for Saturday

			default 0

			

	startDate: the first selectable date, use a date object (check above).

			default today

		

	endDate: the last selectable date, use a date object (check above).

			default year+10

			

	inputType: the type of input fields can be one of the following

				- text (default)

				- select

				- none

	

	inputField: the input field to be used

				if the inputType is text it can be either an HTML input object or the object ID

				Example:

					HTML: <input type="text" name="date" id="date" />

					later ....

					Script:

						inputField:'date'

				if the inputType is select it must be an object with the date, month and year HTML object

				Example:

					HTML: 	<select name="date" id="date"></select>

							<select name="month" id="month"></select>

							<select name="year" id="year"></select>

					later ....

					Script:

						inputField:{date:'date',

									month:'month',

									year:'year'}

	

	

	allowSelection: allow the user to select a date

					default true

					

	

	multiSelection: allow the user to select more than one date

					default false

					

	maxSelection: the maximum number of dates the user can select if multiSelection is true

					set to 0 for unlimited number of dates

					default 0

					

	selectedDate: the initially selected date

					default null

					

	datesOff: an Array of date objects for the holidays. Holidays are unselectable unless allowDatesOffSelection is true

			default []

			

	allowDatesOffSelection: allow the user to select the dates off

			default false

			

	daysOff: an Array of numbers for the days off in the week (beside weekends). daysOff are unselectable unless allowDaysOffSelection is true

			default []

	

	allowDaysOffSelection: allow the user to select days off

			default false

	

	weekend: an Array of numbers for the weekend. weekend is unselectable unless allowWeekendSelection is true

	

	allowWeekendSelection: allow the user to select the weekend

			default false

			

	forceSelections: an Array of date objects that are forced to be selectable regardless where they fall

				(e.g. if the user can select the last Saturday of the month but not other weekend days)

				default []

				

	

	formatter: a function that will return the HTML for the table cell.

				arguments JavaScript Date

				default returns the date

				

	outOfRangeFormatter: a function that will return the HTML for out of range date table cell.

				arguments JavaScript Date

				default returns the date

				

	weekendFormatter: a function that will return the HTML for the weekend table cell.

				arguments JavaScript Date

				default returns the date

				

	

	daysOffFormatter: a function that will return the HTML for the days off table cell.

				arguments JavaScript Date

				default returns the date

				

	datesOffFormatter: a function that will return the HTML for dates off table cell.

				arguments JavaScript Date

				default returns the date

				

	selectedDateFormatter: a function that will return the HTML for the selected date table cell.

				arguments JavaScript Date

				default returns the date

				

	language: a language object (check nogray_date.js for details) for translation

			default null (English will be used)

			

	daysText: the days format to be used on the calendar

			default mid

			

	monthsText: the month format to be used on the calendar

			default long

			

	preTdHTML: the HTML for the previous months arrow

			defualt &laquo;

		

	preTdHTMLOff: the HTML for the previous months arrow when the calendar at the very first mont

			default &nbsp;

	

	nexTdHTML: the HTML for the previous months arrow

		default &raquo;

		

	nexTdHTMLOff: the HTML for the previous months arrow when the calendar at the very last mont

		default: &nbsp;

		

	closeLinkHTML: the HTML for the close link 

		default Close

	

	clearLinkHTML: the HTML for the clear link

		default: Clear

		

	calEvents: an Events object for all the selectable table cell

			Events objects are  objects that the key is a javascript event (without the on, e.g. click, mouseover, mouseout)

			and the value is the function to execute when the event occure.

			default: mouseover add a mouse-over class to the table cell

					mouseout remove the mouse-over class from the table cell

					

	

	tdEvents: an array of Events objects to attach events to sepecific table cells

			the array key must be the date in the following format

			month-date-year

			for example events_arr['8-15-2007'] = {click:function(td, date_str){alert(td.innerHTML+" "+new Date().fromString(date_str));}};

				arguments passed td (the table cell)

								date_str (the date in a string format)

			default []

			

	dateOnAvailable: an array of functions to run when a specific date is rendered

			the array key must be the date in the following format

			month-date-year

			

			for example date_on_arr['8-15-2007'] = function(td, date_str){td.setHTML(date_str);}

				arguments passed td (the table cell)

								date_str (the date in a string format)

			default []

			

	

	speedFireFox: option to speed the calendar creation in Firefox, 

				since firefox is slow when handling date objects, this option will illimenate

				the datesOff (holidays) daysOff and forcedSelection for better performance.

				default false

	

	closeOpenCalendars: close all the open calendars when the calendar opens

			default true



Events:

	onSelect: an event that will be fired everytime a date is selected

	

	onUnSelect: an event that will be fired everytime a date is unselected

	

	onCalendarLoad: an event that will be fired once all the tables for the calendar are created.

	

	onOpen: an event that will be fired when the calendar is opened

	

	onClose: an event that will be fired when the calendar is closed

	

	onClear: an event that will be fired when all the selected dates are cleared

	

Object Variables:

	visibleMonth:

		an array that hold all the visible months values in the key in the following format

		month-year

		Example:

			alert(this.visibleMonth[8-2007]); // will alert true if september is visible

			

	selectedDates:

		an array of all the selected dates in time value (milliseconds)

			

*/



var Calendar = new Class({

	options:{

		visible: false,

		

		offset:{x:0,

				y:0},

				

		dateFormat:'D, d M Y',

		

		numMonths: 1,

		

		classPrefix: 'ng-',

		idPrefix: 'ng-',

		

		startDay:0,

		

		startDate:'today',

		endDate:'year+10',

				

		inputType:'text',



		inputField:null,

		

		allowSelection: true,

		multiSelection: false,

		maxSelection: 0,

		

		selectedDate:null,

		

		datesOff:[],

		

		allowDatesOffSelection:false,

				

		daysOff:[],

		

		allowDaysOffSelection:false,

		

		weekend:[0,6],

		

		allowWeekendSelection:false,

		

		forceSelections:[],

		

		onSelect: function(){

			return;

		},

		

		onUnSelect: function(){

			return;

		},

		

		onCalendarLoad: function(){

			return;

		},

		

		onOpen: function(){

			return;

		},

		

		onClose: function(){

			return;

		},

		

		onClear: function(){

			return;

		},

		

		formatter: function(dt){

			return dt.getDate();

		},

		outOfRangeFormatter: function(dt){

			return dt.getDate();

		},

		weekendFormatter: function(dt){

			return dt.getDate();

		},

		daysOffFormatter: function(dt){

			return dt.getDate();

		},

		datesOffFormatter: function(dt){

			return dt.getDate();

		},

		selectedDateFormatter:function(dt){

			return dt.getDate();

		},

		

		language: null,

		daysText : 'mid',

		monthsText : 'long',

		

		preTdHTML: "&laquo;",

		preTdHTMLOff: "&nbsp;",

		nexTdHTML: "&raquo;",

		nexTdHTMLOff: "&nbsp;",

		closeLinkHTML: "Close",

		clearLinkHTML: "Clear",

					

		calEvents: {mouseenter:function(td){

				if (!td.hasClass(this.options.classPrefix+"selected-day")) td.addClass(this.options.classPrefix+"mouse-over");

			},

			mouseleave:function(td){

				td.removeClass(this.options.classPrefix+"mouse-over");

			}},

			

		tdEvents: [],

		

		dateOnAvailable: [],

		

		speedFireFox: false,

		

		closeOpenCalendars:true

		

	},

	

	initialize: function(el, toggler, options){

		this.element = $(el);

		if ($defined(toggler))

			this.toggler = $(toggler);

		else

			this.toggler = null;

			

		this.visibleMonth = [];

		this.manageTDs = [];

		this.selectedDates = [];

		

		this.setOptions(options);

		

		this.options.inputType = this.options.inputType.toLowerCase();

		

		this.date = new Date();

		this.date = new Date(this.date.getFullYear(), this.date.getMonth(), this.date.getDate());

		

		if ($defined(this.options.language))

			this.date.language = this.options.language;

		

		this.options.startDate = this.processDates(this.options.startDate);

		this.options.endDate = this.processDates(this.options.endDate);



		if (!$defined(this.options.startDate))

			this.options.startDate = this.date.fromObject({date:"year-10"});

		else

			this.date = this.processDates(new Date(this.options.startDate.getTime()));



		if (!$defined(this.options.endDate))

			this.options.endDate = this.date.fromObject({date:"year+10"});



		

		this.options.selectedDate = this.processDates(this.options.selectedDate);

		if (!this.isSelectable(this.options.selectedDate))

			this.options.selectedDate = null;

			

		this.options.selectedDate2 = this.processDates(this.options.selectedDate2);

		if (!this.isSelectable(this.options.selectedDate2))

			this.options.selectedDate2 = null;



		

		if (!this.options.visible){

			if ((window.ie) && (!window.ie7)){

				this.iframe = new Element("iframe", {'src':'about:Blank',

											'styles':{

												'position':'absolute',

												'z-index':20000,

												'opacity':0,

												'background-color':'#ffffff'

											},

											'frameborder':0

										});

										

				document.body.appendChild(this.iframe);

			}



			this.element.setStyles({

				'position':'absolute',

				'z-index':25000,

				'opacity':0

			});

			

			if ($defined(this.toggler)){

				this.toggler.addEvent("click", function(e){

					var e = new Event(e);

					if (this.element.getStyle('opacity') == 0) this.openCalendar();

					else this.closeCalendar();

					e.stop();

				}.bind(this));

			}

			

		}

		

		if (this.options.numMonths > 1){

			this.loading_div = new Element("div", {'styles':{

					'position':'absolute',

					'z-index':26000,

					'opacity':0,

					'background':'#FFFFFF'

				}});

				

			this.element.adopt(this.loading_div);

		}

		

		var ch = new Element("table", {'class':this.options.classPrefix+'cal-header-table'});

		var tbody = new Element("tbody");

		ch.adopt(tbody);

		

		var tr = new Element("tr");

		

		this.preTD = new Element("td", {'class':this.options.classPrefix+'cal-previous-td'});			

		this.preTD.addEvent("click", function(){

			var i=this.options.numMonths;

			var new_dt;

			while(i > 0){

				new_dt = this.date.fromString("month-"+i);

				new_dt.setDate(new_dt.daysInMonth());

				if (!this.isOutOfRange(new_dt)){

					new_dt.fromString("month-1");

					break;

				}

				i--;

			}

			if (i > 0) this.updateCalendar(new_dt);

		}.bind(this));

		

		tr.adopt(this.preTD);

		

		this.headerTD = new Element("td", {'class':this.options.classPrefix+'cal-header-td'});

		tr.adopt(this.headerTD);

		

		this.nexTD = new Element("td", {'class':this.options.classPrefix+'cal-next-td'});			

		this.nexTD.addEvent("click", function(){

			var i=this.options.numMonths;

			var new_dt;

			while(i > 0){

				new_dt = this.date.fromString("month+"+i);

				new_dt.setDate(1);

				if (!this.isOutOfRange(new_dt)){

					new_dt.fromString("month-1");

					break;

				}

				i--;

			}

			if (i > 0) this.updateCalendar(new_dt);

		}.bind(this));

		

		tr.adopt(this.nexTD);

		

		this.updateHeader();

		

		tbody.adopt(tr);

		

		this.element.adopt(ch);

		

		this.calendarHolder = new Element("div");

		this.element.adopt(this.calendarHolder);

		

		var footer = new Element("div", {'styles':{'clear':'both'}});

		this.element.adopt(footer);

		

		var clear_float = new Element("div", {'styles':{'clear':'both',

									  			'height':1,

												'font-size':'1px'}});

		clear_float.setHTML("&nbsp;");

		this.element.adopt(clear_float);

		

		if (!this.options.visible){

			var close_link = new Element("a", {'class':this.options.classPrefix+'close-link',

										'href':'#'});

			close_link.addEvent("click", function(e){

				var e = new Event(e);

				e.preventDefault();

				this.closeCalendar();

				

			}.bind(this));

			

			close_link.setHTML(this.options.closeLinkHTML);



			footer.adopt(close_link);

		}

		

		if (this.options.multiSelection){

			var clear_link = new Element("a", {'class':this.options.classPrefix+'clear-link',

										'href':'#'});

			clear_link.addEvent("click", function(e){

				var e = new Event(e);

				e.preventDefault();

				this.unselectAll();

				

			}.bind(this));

			

			clear_link.setHTML(this.options.clearLinkHTML);



			footer.adopt(clear_link);

		}

		

		this.populateCalendar();

		

		if (this.options.allowSelection){

			if (this.options.inputType == "select") {

				this.options.inputField.year = $(this.options.inputField.year);

				this.options.inputField.month = $(this.options.inputField.month);

				this.options.inputField.date = $(this.options.inputField.date);

				

				this.options.inputField.year.addEvent("change", function(){

					if (this.options.inputField.year.options[this.options.inputField.year.selectedIndex].value != ""){

						if ($defined(this.options.selectedDate))

							var use_dt = new Date(this.options.selectedDate.getTime());

						else

							var use_dt = new Date(this.date.getTime());

						use_dt.setYear(this.options.inputField.year.options[this.options.inputField.year.selectedIndex].value);

						if (!this.options.multiSelection)

							this.selectDate(use_dt);

						this.updateCalendar(use_dt);

						this.populateMonthSelect();

					}

				}.bind(this));

				

		

				this.options.inputField.month.addEvent("change", function(){

					if (this.options.inputField.month.options[this.options.inputField.month.selectedIndex].value != ""){

						if ($defined(this.options.selectedDate))

							var use_dt = new Date(this.options.selectedDate.getTime());

						else

							var use_dt = new Date(this.date.getTime());

						

						var temp_dt = use_dt.getDate();

						use_dt.setDate(1);

						use_dt.setMonth(this.options.inputField.month.options[this.options.inputField.month.selectedIndex].value.toInt()-1);

						if (use_dt.daysInMonth() > temp_dt) use_dt.setDate(temp_dt);

						else use_dt.setDate(use_dt.daysInMonth());

						

						if (!this.options.multiSelection)

							this.selectDate(use_dt);

							

						if (!$defined(this.visibleMonth[use_dt.getMonth()+"-"+use_dt.getFullYear()]))

							this.updateCalendar(use_dt);

						

						this.populateDateSelect(this.options.inputField);

					}

				}.bind(this));

	

				

				this.options.inputField.date.addEvent("change", function(){

						if ($defined(this.options.selectedDate))

							var use_dt = new Date(this.options.selectedDate.getTime());

						else

							var use_dt = new Date(this.date.getTime());

							

						use_dt.setDate(this.options.inputField.date.options[this.options.inputField.date.selectedIndex].value);

						this.selectDate(use_dt);

					}.bind(this));





					this.populateSelect();

			}

			else if (this.options.inputType == "text") {

				this.options.inputField = $(this.options.inputField);

				this.options.inputField.addEvent("focus", function(){

					this.openCalendar();

				}.bind(this));

				this.options.inputField.addEvent("keydown", function(e){

					var e = new Event(e);

					if ((e.key.length == 1) || (e.key == "space")) e.stop();

				});

			}

		}

			

		if ($defined(this.options.selectedDate)){

			if ((window.ie6) && (this.options.inputType == "select")){

				(function(){

					this.selectDate(this.options.selectedDate);

					this.updateCalendar(this.options.selectedDate);}).delay(100, this);

			}

			else {

				this.selectDate(this.options.selectedDate);

				this.updateCalendar(this.options.selectedDate);

			}

		}



		_all_page_calendars.push(this);

	},

	

	/*

		Function:

			populateSelect

			fill in the select menu values

			

	*/

	populateSelect: function(){

		if (this.options.inputType != "select") return;

		

		this.options.inputField.year.empty();

		

		var opt = new Element("option");

		this.options.inputField.year.adopt(opt);

		var i=0;

		for (i=this.options.startDate.getFullYear(); i<=this.options.endDate.getFullYear(); i++){

			opt = new Element("option", {'value':i});

			opt.setText(i);

			if (($defined(this.options.selectedDate))&&(this.options.selectedDate.getFullYear() == i)) opt.selected = "selected";

			this.options.inputField.year.adopt(opt);

		}

		this.populateMonthSelect();



	},

	

	/*

		Function:

			populateMonthSelect

			fill in the months select menu values

			

	*/

	populateMonthSelect: function(){

		if (this.options.inputType != "select") return;

		

		var st_mn = 0;

		if (this.options.startDate.getFullYear() == this.date.getFullYear())

			st_mn = this.options.startDate.getMonth();

			

		var en_mn = 11;

		if (this.options.endDate.getFullYear() == this.date.getFullYear())

			en_mn = this.options.endDate.getMonth();

		

		this.options.inputField.month.empty();

		

		opt = new Element("option");

		this.options.inputField.month.adopt(opt);



		for (i=st_mn; i<=en_mn; i++){

			opt = new Element("option", {'value':(i+1)});

			opt.setText(this.date.language.months[this.options.monthsText][i]);

			if (($defined(this.options.selectedDate))&&(this.options.selectedDate.getMonth() == i)) opt.selected = "selected";

			this.options.inputField.month.adopt(opt);

		}

		

		this.populateDateSelect();

	},

	

	/*

		Function:

			populateDateSelect

			fill in the date select menu values

			

	*/

	populateDateSelect: function(){

		if (this.options.inputType != "select") return;

		

		if ((this.options.inputField.year.options[this.options.inputField.year.selectedIndex].value != "")

			&& (this.options.inputField.month.options[this.options.inputField.month.selectedIndex].value != ""))

			var use_dt = new Date(this.options.inputField.year.options[this.options.inputField.year.selectedIndex].value, this.options.inputField.month.options[this.options.inputField.month.selectedIndex].value-1, 1);

		else if ($defined(this.options.selectedDate))

			var use_dt = this.options.selectedDate;

		else

			var use_dt = this.date;

		

		var en_dy = use_dt.daysInMonth();

		

		this.options.inputField.date.empty();

		

		opt = new Element("option");

		this.options.inputField.date.adopt(opt);

		var seletable;

		for (i=1; i<=en_dy; i++){

			opt = new Element("option", {'value':i});

			opt.setText(i);

			if (!this.isSelectable(new Date(use_dt.getFullYear(), use_dt.getMonth(), i))){

				opt.disabled = true;

				opt.setStyles({'color':'#cccccc'});

			}

			else

				if (($defined(this.options.selectedDate))&&(this.options.selectedDate.getDate() == i)

				&& (this.options.selectedDate.getMonth() == this.options.inputField.month.options[this.options.inputField.month.selectedIndex].value-1)

				&& (this.options.selectedDate.getFullYear() == this.options.inputField.year.options[this.options.inputField.year.selectedIndex].value)) opt.selected = "selected";

			this.options.inputField.date.adopt(opt);

		}

	},

	

	/* backward compaitiblity typo */

	populateCalender: function(){

		return 	this.populateCalendar();

	},

	

	

	/*

		Function:

			populateCalendar

			populate the calendar table from the calendar date

			

	*/

	

	populateCalendar: function(){

		var func = function(mn, yr){

			var i=0;

			this.visibleMonth = [];

			

			this.calendarHolder.setHTML("");

			for(i=0; i<this.options.numMonths; i++){

				this.calendarHolder.innerHTML += this.createCalenderTable(mn, yr);

				this.visibleMonth[mn+"-"+yr] = true;

				mn++;

				if (mn > 11){

					mn = 0;

					yr++;

				}

			}

			

			if (this.options.numMonths > 1){

				this.loading_div.setOpacity(0);

			}

			

			this.processTdEvents();

			

			if ($defined(this.iframe)){

				this.iframe.setStyles({

					'width':this.element.getStyle('width'),

					'height':this.element.getStyle('height')

				});

			}

		

			this.fireEvent("onCalendarLoad");

		};

		

		if (this.options.numMonths > 1){

			if (this.element.getStyle('opacity') > 0){

				this.loading_div.setStyles({'opacity':0.5,

							'height':this.element.getStyle('height'),

							'width':this.element.getStyle('width')});

			}

			func.delay(1, this, [this.date.getMonth(), this.date.getFullYear()]);

		}

		else {

			this.visibleMonth = [];

			

			this.calendarHolder.innerHTML = this.createCalenderTable(this.date.getMonth(), this.date.getFullYear());

			this.visibleMonth[this.date.getMonth()+"-"+this.date.getFullYear()] = true;

			

			this.processTdEvents();

			

			if ($defined(this.iframe)){

				this.iframe.width = this.element.getStyle('width');

				this.iframe.height = this.element.getStyle('height');

			}

			

			this.fireEvent("onCalendarLoad");

		}

	},

	

	

	/*

		Function:

			createCalenderTable

			create the month table for the given month and year

			

		Argumesnt:

			mn: month

			yr: year

			

		Returns:

			the table HTML

			

	*/

	createCalenderTable: function (mn, yr){

		var t = new Array();

		t[t.length] = '<table class="'+this.options.classPrefix+'cal" id="'+this.options.idPrefix+'month-'+(mn+1)+'-'+yr+'-table'+'"><tr>\

				<th class="'+this.options.classPrefix+'month-name-th'+'" id="'+this.options.idPrefix+'month-name-'+(mn+1)+'-'+yr+'-th'+'" colspan="7">'+this.date.language.months[this.options.monthsText][mn]+" "+yr+'</th></tr><tr>';





		var i=0;

		var wd = 0;			

		for(i=0; i<7; i++){

			wd = (i+this.options.startDay)%7;

			t[t.length] = '<td class="'+this.options.classPrefix+'days-name-td'+'" id="'+this.options.idPrefix+'days-name-'+wd+'-'+(mn+1)+'-'+yr+'-td'+'">'+this.date.language.days[this.options.daysText][wd]+'</td>';

		}

		

		t[t.length] = '</tr>';

		

		var date = new Date(yr, mn, 1);



		date.setDate(date.getDate()-(date.getDay()-this.options.startDay));

		

		if ((date.getDate() <= 7) && (date.getDate() != 1)){

			date.setDate(date.getDate() - 7);	

		}

		

		var i, j, className, title, html, id_str, selectable;

		

		var loop = 7;

		for (i=1; i<loop; i++){

			t[t.length] = '<tr>';

				for (j=1; j<=7; j++){

					className = "";

					html = "";

					id_str = "";

					if (date.getMonth() != mn){

						id_str = (date.getMonth()+1)+'-'+date.getDate()+'-'+date.getFullYear();

						t[t.length] = '<td class="'+this.options.classPrefix+'date-'+id_str+' '+this.options.classPrefix+'outOfRange'+'">'+this.options.outOfRangeFormatter(date)+'</td>';

					}

					else {

						selectable = this.isSelectable(date, true);

	

						if (selectable[1] == "outOfRange"){

							className = this.options.classPrefix+"outOfRange";

							html = this.options.outOfRangeFormatter(date);

						}

						else if (selectable[1] == "weekend"){

							className = this.options.classPrefix+"weekend";

							html = this.options.weekendFormatter(date);

						}

						else if (selectable[1] == "dayOff"){

							className = this.options.classPrefix+"dayOff";

							html = this.options.daysOffFormatter(date);

						}

						else if (selectable[1] == "dateOff"){

							className = this.options.classPrefix+"dateOff";

							html = this.options.datesOffFormatter(date);

						}

						else {

							html = this.options.formatter(date);

						}

						

						if (selectable[0]){

							if (this.isSelected(date)){

								className +=" "+this.options.classPrefix+"selected-day";

								html = this.options.selectedDateFormatter(date);

							}

						}



						

						id_str = (date.getMonth()+1)+'-'+date.getDate()+'-'+date.getFullYear();

						this.manageTDs[id_str] = [];

						t[t.length] = '<td class="'+this.options.classPrefix+'date-'+id_str+' '+className+'" id="'+this.options.idPrefix+'date-'+id_str+'">'+html+'</td>';

						if (selectable[0])

							this.manageTDs[id_str]['click'] = true;

							

						if ($defined(this.options.tdEvents[id_str])){

							if (!$defined(this.manageTDs[id_str]['event']))

								this.manageTDs[id_str]['event'] = [];

							for (e in this.options.tdEvents[id_str]){

								this.manageTDs[id_str]['event'][e] = this.options.tdEvents[id_str][e];

							}

						}

						

						if ($defined(this.options.dateOnAvailable[id_str])){

							if (!$defined(this.manageTDs[id_str]['dateOnAvailable']))

								this.manageTDs[id_str]['dateOnAvailable'] = [];

							this.manageTDs[id_str]['dateOnAvailable'].push(this.options.dateOnAvailable[id_str]);

						}

						

					}

					

					date.setDate(date.getDate() + 1);

				}

			t[t.length] = '</tr>';

			if ((date.getMonth() > mn) && (this.options.numMonths == 1)) loop = 6;

		}

		

		t[t.length] = '</table>';

		

		return t.join("");

	},

	

	/*

		Function: 

			processTdEvents

			assign custom events to the table cells

	*/

	processTdEvents: function(){

		var td, obj;

		for(p in this.manageTDs){

			obj = this.manageTDs[p];

			td = $(this.options.idPrefix+'date-'+p);

			var date_str = p;

			

			if ($defined(obj['click'])){

				td.addEvent("click", function(td, date_str){

					var date = new Date().fromString(date_str);

					if (this.isSelected(date))

						this.unselectDate(date);

					else 

						this.selectDate(date);

						

				}.bind(this, [td, date_str]));

				

				td.setStyle("cursor", "pointer");

				

				for (e in this.options.calEvents)

					td.addEvent(e, this.options.calEvents[e].bind(this, td));

			}

			

			if ($defined(obj['event'])){

				for (ep in obj['event']){

					if ($type(obj['event'][ep]) == "function"){

						td.addEvent(ep, obj['event'][ep].bind(this, [td, date_str]));

					}

				}

			}

			

			if ($defined(obj['dateOnAvailable'])){

				obj['dateOnAvailable'].each(function(func){

					func.attempt([td, date_str], this);

				}, this);

			}

		}

		

		this.manageTDs = [];

	},

	

	/*

		Function:

			isWeekend

			check if the day is a weekend in the calendar

			

		Arguments:

			weekDay: a number for the weekday. 0 for Sunday 6 for Saturday

			

		Returns:

			true or false

	*/

	isWeekend: function (weekDay){

		return this.options.weekend.contains(weekDay);

	},

	

	

	/*

		Function:

			isDayOff

			check if the day is a day off in the calendar

			

		Arguments:

			weekDay: a number for the weekday. 0 for Sunday 6 for Saturday

			

		Returns:

			true or false

	*/

	isDayOff: function (weekDay){

		if ((this.options.speedFireFox) && (window.gecko)) return false;

		return this.options.daysOff.contains(weekDay);

	},

	

	

	/*

		Function:

			isDateOff

			check if the date is a date off (holiday) in the calendar

			

		Arguments:

			date: date object (check above)

			

		Returns:

			true or false

	*/

	isDateOff: function (date){

		if ((this.options.speedFireFox) && (window.gecko)) return false;

		var date = this.processDates(date);

		if (!$defined(date)) return false;

			

		var j=0;

		var loop = this.options.datesOff.length;

		for(j=0; j<loop; j++){

			cur_date = this.processDates(this.options.datesOff[j], date);

			if ($defined(cur_date))

				if (date.getTime()==cur_date.getTime())

					return true;

		}

		return false;

	},

	

	/*

		Function:

			isOutOfRange

			check if the date is out of the selectable range in the calendar

			

		Arguments:

			date: date object (check above)

			

		Returns:

			true or false

	*/

	isOutOfRange: function (date){

		var date = this.processDates(date);

		if (!$defined(date)) return false;

		

		return ((date.getTime() < this.options.startDate.getTime())

				||

				(date.getTime() > this.options.endDate.getTime()));

	},

	

	/*

		Function:

			isSelectable

			check if the date is selectable

			

		Arguments:

			date: date object (check above)

			arr: returns true or false if null

				returns an array with the first element true or false

						the second element is either the reason for false or the date

					possible reasons

						outOfRange

						dayOff

						weekend

						dateOff

			

		Returns:

			check Arguments

	*/

	isSelectable: function (date, arr){

		var date = this.processDates(date);

		if (!$defined(date)) return false;

		

		if ((!$defined(arr)) && (!this.options.allowSelection)) return false;

		

		var re = [true,date];

		if (this.isOutOfRange(date))

			re = [false,'outOfRange'];

		else if (this.isDayOff(date.getDay()))

			re = [this.options.allowDaysOffSelection,'dayOff'];

		else if (this.isWeekend(date.getDay()))

			re = [this.options.allowWeekendSelection,'weekend'];

		else if (this.isDateOff(date))

			re = [this.options.allowDatesOffSelection,'dateOff'];

		

		if ((!this.options.allowSelection) && (re[0])) re=[false,'noSelection'];

		

		if (!re[0])

			if (this.isForcedSelection(date)) re = [true,date];

		if ($defined(arr))

			return re;

		else

			return re[0];



		

		return [false,date]

		

	},

	

	/*

		Function:

			isForcedSelection

			check if the date is forced to be selectable

			

		Arguments:

			date: date object (check above)

			

		Returns:

			true or false

	*/

	

	isForcedSelection: function(date){

		if ((this.options.speedFireFox) && (window.gecko)) return false;

		var i=0;

		var loop = this.options.forceSelections.length;

		var dt;

		for (i=0; i<loop; i++){

			dt = this.processDates(this.options.forceSelections[i], date);

			if (dt.getTime() == date.getTime()) return true;

		}

		return false;

	},

	

	

	/*

		Function:

			isSelected

			check if the date is selected or not

			

		Arguments:

			date: date object (check above)

			

		Returns:

			true or false

	*/

	isSelected: function (date){

		var date = this.processDates(date);

		if (!$defined(date)) return false;





		return this.selectedDates.contains(date.getTime());

	},

	

	/*

		Function:

			updateCalendar

			update the calendar months from the given date

			

		Arguments:

			date: date object (check above)



	*/

	

	updateCalendar: function(date){

		var date = this.processDates(date);

		if (!$defined(date)) return false;



		if (this.isOutOfRange(date))

			this.date = this.options.startDate;

		else

			this.date = date;

			

						

		this.populateCalendar();

		this.updateHeader();

	},

	

	/*

		Function:

			selectDate

			select the given date

			

		Arguments:

			date: date object (check above)

			

		Returns:

			true if selected

			false if not



	*/

	

	selectDate: function(date){

		if (!this.options.allowSelection) return false;

		

		var date = this.processDates(date);

		if (!$defined(date)) return false;

		if ((this.options.maxSelection > 0) && (this.selectedDates.length >= this.options.maxSelection)) return false;

		if (this.isSelectable(date)){

			if (this.options.inputType == "select"){

				var update_year = true;

				var update_month = true;

				if ($defined(this.options.selectedDate)){

					if (date.getFullYear() == this.options.selectedDate.getFullYear())

						update_year = false;

					else if (date.getMonth() == this.options.selectedDate.getMonth())

						update_month = false;

				}

			}

			

			if (!this.options.multiSelection)

				this.unselectDate(this.options.selectedDate);



			this.options.selectedDate = this.date = date;

			this.selectedDates.push(date.getTime());

			

			var id_str = this.options.idPrefix+'date-'+(date.getMonth()+1)+'-'+date.getDate()+'-'+date.getFullYear();

			if ($defined($(id_str))){

				$(id_str).removeClass(this.options.classPrefix+"mouse-over");

				$(id_str).addClass(this.options.classPrefix+"selected-day");

				$(id_str).setHTML(this.options.selectedDateFormatter(this.options.selectedDate));

			}

			

			if(this.options.inputType == "select"){

				if (update_year) this.populateMonthSelect();

				else if (update_month) this.populateDateSelect();

				this.selectSelectMenu();

			}

			else if (this.options.inputType == "text")

				this.fillInputField();

				

			this.fireEvent("onSelect");

			return true;

		}

		else {

			if (this.options.inputType == "select"){

				this.options.inputField.date.selectedIndex = 0;

				return false;

			}

		}

		

		this.updateHeader();

	},

	

	

	/*

		Function:

			unselectDate

			unselect the given date

			

		Arguments:

			date: date object (check above)



	*/

	

	unselectDate: function(date){

		if (!this.options.allowSelection) return false;

		

		var date = this.processDates(date);

		if (!$defined(date)) return false;

		

		this.selectedDates.remove(date.getTime());

		

		var id_str = this.options.idPrefix+'date-'+(date.getMonth()+1)+'-'+date.getDate()+'-'+date.getFullYear();



		if ($defined($(id_str)))

			$(id_str).removeClass(this.options.classPrefix+"selected-day");

		

		if (($defined(this.options.selectedDate)) && (this.options.multiSelection)){

			if (this.options.selectedDate.getTime() == date.getTime()){

				if ($defined(this.selectedDates.getLast())){

					this.options.selectedDate = new Date(this.selectedDates.getLast());

				}

				else 

					this.options.selectedDate = null;

			}

		}

		else 

			this.options.selectedDate = null;



		if (this.options.inputType == "select"){

			var update_year = true;

			var update_month = true;

			if ($defined(this.options.selectedDate)){

				if (date.getFullYear() == this.options.selectedDate.getFullYear())

					update_year = false;

				else if (date.getMonth() == this.options.selectedDate.getMonth())

					update_month = false;

			}

				

			if (update_year) this.populateMonthSelect();

			else if (update_month) this.populateDateSelect();

			this.selectSelectMenu();

		}

		else if (this.options.inputType == "text")

			this.options.inputField.value = this.options.inputField.value.replace(date.print(this.options.dateFormat, this.options.language), "");

					

		this.fireEvent("onUnSelect", date);

	},

	

	/*

		Function:

			unselectAll

			unselect all the selected dates



	*/

	unselectAll: function(){

		if (!this.options.allowSelection) return false;

		

		var arr = this.selectedDates.copy();

		arr.each(function (dt){

			this.unselectDate(new Date(dt));			  

	  	}, this);

		

		this.fireEvent("onClear");

	},

	

	

	/*

		Function:

			selectSelectMenu

			select the drop down menu if the user click on the a selectable date in the calendar



	*/

	selectSelectMenu: function (){

		if (this.options.inputType != "select") return;

		if (!$defined(this.options.selectedDate)){

			this.options.inputField.date.selectedIndex = 0;

			this.options.inputField.month.selectedIndex = 0;

			this.options.inputField.year.selectedIndex = 0;

			return;

		}

		

		this.options.inputField.date.selectedIndex = this.options.selectedDate.getDate();

		

		var loop;

		var i=0;

		

		var opts = $(this.options.inputField.month).getElements("option");

		loop = opts.length;

		for(i=0; i<loop; i++){

			if (opts[i].value.toInt()-1 == this.options.selectedDate.getMonth()){

				this.options.inputField.month.selectedIndex = i;

				break;

			}

		}

		

		var opts = $(this.options.inputField.year).getElements("option");

		loop = opts.length;

		for(i=0; i<loop; i++){

			if (opts[i].value.toInt() == this.options.selectedDate.getFullYear()){

				this.options.inputField.year.selectedIndex = i;

				break;

			}

		}	

	},

	

	/*

		Function:

			fillInputField

			Fill the inpute field when the user select a date



	*/

	fillInputField: function(){

		if (!this.options.multiSelection) this.options.inputField.value = "";

		this.options.inputField.value += this.options.selectedDate.print(this.options.dateFormat, this.options.language);

	},

	

	/*

		Function:

			updateHeader

			update the calendar headers (month and year and arrows)



	*/

	updateHeader: function(){

		this.headerTD.setHTML(this.date.language.months[this.options.monthsText][this.date.getMonth()]+" "+this.date.getFullYear());

		if (!this.isOutOfRange(new Date(this.date.getFullYear(), this.date.getMonth()-1, this.options.startDate.getDate()))){

			this.preTD.setHTML(this.options.preTdHTML);

			this.preTD.setStyle("cursor", "pointer");

		}

		else {

			this.preTD.setHTML(this.options.preTdHTMLOff);

			this.preTD.setStyle("cursor", "");

		}

		if (!this.isOutOfRange(new Date(this.date.getFullYear(), this.date.getMonth()+1, this.options.endDate.getDate()))){

			this.nexTD.setHTML(this.options.nexTdHTML);

			this.nexTD.setStyle("cursor", "pointer");

		}

		else {

			this.nexTD.setHTML(this.options.nexTdHTMLOff);

			this.nexTD.setStyle("cursor", "");

		} 

	},

	

	/*

		Function:

			processDates

			return a JavaScript date from the date object

			

		Arguments:

			dt: a date object (see above)

			use_date: the default date to use

		

		Return:

			JavaScript Date



	*/

	processDates: function(dt, use_date){

		if (!$defined(use_date)) use_date = this.date;

		var rdt;

		if ((($type(dt) == "object") && ($defined(dt.getFullYear))) || ($type(dt) == "date")) rdt = dt;

		else if ($type(dt) == "object") rdt = use_date.fromObject(dt);

		else if ($type(dt) == "string") rdt = use_date.fromString(dt);

		else if ($type(dt) == "number") rdt = new Date(dt);

		else return null;

		if ($defined(this.options.language))

			rdt.language = this.options.language;

		

		rdt.setHours(0); rdt.setSeconds(0); rdt.setMinutes(0); rdt.setMilliseconds(0);

		return rdt;

	},

	

	

	/*

		Function:

			openCalendar

			opens the calendar



	*/

	openCalendar: function(){

		if (this.options.closeOpenCalendars) $closeAllCalendars();

		if (this.options.inputType == "select")

			var inp_f = this.options.inputField.date;

		else 

			var inp_f = this.options.inputField;

			

		var coord = inp_f.getCoordinates();

		

		this.element.setStyles({

			   'top': coord.top+coord.height+this.options.offset.y,

			   'left': coord.left+this.options.offset.x,

			   'opacity':1

			});

		if ($defined(this.iframe)){

			this.iframe.setStyles({

				 'top': coord.top+coord.height+this.options.offset.y,

				 'left': coord.left+this.options.offset.x,

				 'opacity':1

			});

		}

		

		this.fireEvent("onOpen");

	},

	

	/*

		Function:

			closeCalendar

			closes the calendar



	*/

	closeCalendar: function(){

		if (this.options.visible) return false;

		this.element.setStyle('opacity', 0);

		if ($defined(this.iframe))

			this.iframe.setStyle('opacity', 0);

			

		this.fireEvent("onClose");

	}

	

});



Calendar.implement(new Events, new Options);



// array to hold all the calendar objects for the close all calendars

var _all_page_calendars = [];



// function to close all the open calendars

var $closeAllCalendars = function(){

	_all_page_calendars.each(function(obj){

			obj.closeCalendar();

		});

};

