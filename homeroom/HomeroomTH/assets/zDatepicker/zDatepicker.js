// Zyser Custom Date Picker V.1.0

var zDatepickerList = [];
var zRangeDatepickerList = [];

jQuery(document).ready(function() {
	//Builder
	for(var i = 0 ; i < jQuery(".zDatepicker").length ; i++) {
		var eID = jQuery(jQuery(".zDatepicker")[i]).attr("id");
		zDatepickerList[eID] = new zDatepicker(eID);
	}

	for(var i = 0 ; i < jQuery(".zRangeDatepicker").length ; i++) {
		var eID = jQuery(jQuery(".zRangeDatepicker")[i]).attr("id");
		zRangeDatepickerList[eID] = new zRangeDatepicker(eID);
	}
});

function zDatepicker(id) {
	//public property

	//private property
	var elementID;
	var date, startDate, endDate;
	var day, month, year;
	var disabled = "";
	var monthOnly = false;
	var yearOnly = false;

	var monthDay = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	var monthText = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
	//private constructor
	var __construct = function() {
		elementID = id;
		if(jQuery("#" + elementID).data("date") != null && jQuery("#" + elementID).data("date").length != 0) {
			date = jQuery("#" + elementID).data("date");
			var tmp = date.split("-");
			day = parseInt(tmp[2], 10);
			month = parseInt(tmp[1], 10);
			year = parseInt(tmp[0], 10);
			updateDate();
		} else {
			var toDay = new Date();
			day = toDay.getDate();
			month = toDay.getMonth() + 1;
			year = toDay.getFullYear();
			updateDate();
		}
		if(year % 4 == 0) {
			monthDay[1] = 29;
		} else {
			monthDay[1] = 28;
		}
		if(jQuery("#" + elementID).data("startdate") != null && jQuery("#" + elementID).data("startdate").length != 0) {
			startDate = jQuery("#" + elementID).data("startdate");
		} else {
			startDate = null;
		}
		if(jQuery("#" + elementID).data("enddate") != null && jQuery("#" + elementID).data("enddate").length != 0) {
			endDate = jQuery("#" + elementID).data("enddate");
		} else {
			endDate = null;
		}

		if(jQuery("#" + elementID).data("disabled") == true) {
			disabled = "disabled";
		}

		if(jQuery("#" + elementID).data("monthonly") == true) {
			monthOnly = true;
		}
		if(jQuery("#" + elementID).data("yearonly") == true) {
			yearOnly = true;
		}
		appendHTML();
		addListenner();
		return this;
	}();
	//private method
	function appendHTML() {
		var space = '';
		var html = '<span class="form-inline">';

		if(!monthOnly && !yearOnly) {
			html += '<select class="form-control" name="' + elementID + '_day" id="' + elementID + '_day" ' + disabled + '></select>' + space;
		}
		if(!yearOnly) {
		html += '<select class="form-control" name="' + elementID + '_month" id="' + elementID + '_month" ' + disabled + '></select>' + space;
		}
		html += '<select class="form-control" name="' + elementID + '_year" id="' + elementID + '_year" ' + disabled + '></select>';
		html += '<input name="' + elementID + '" type="hidden" value="' + date + '">';
		html += '</span>';
		jQuery("#" + elementID).html(html);
		addYear();
		addMonth();
		addDay();
	}

	function addYear() {
		var s, e;
		var html = "";
		if(startDate != null) {
			var tmp = startDate.split("-");
			s = parseInt(tmp[0], 10);
		} else {
			s = new Date().getFullYear() - 10;
		}
		if(endDate != null) {
			var tmp = endDate.split("-");
			e = parseInt(tmp[0], 10);
		} else {
			e = new Date().getFullYear() + 10;
		}

		var isContain = false;
		for(var i = s ; i <= e ; i++) {
			if(i == year) {
				isContain = true;
			}
			var dispYear = i + 543;
			html += '<option value="' + dispYear + '">' + dispYear + '</option>';
		}
		jQuery("#" + elementID + "_year").html(html);
		if(isContain) {
			jQuery("#" + elementID + "_year").val(year + 543);
		} else {
			year = parseInt(jQuery("#" + elementID + "_year").val(), 10) - 543;
			if(year % 4 == 0) {
				monthDay[1] = 29;
			} else {
				monthDay[1] = 28;
			}
			updateDate();
		}
	}

	function addMonth() {
		var s = 1, e = 12;
		var html = "";
		if(startDate != null) {
			var tmp = startDate.split("-");
			var sYear = parseInt(tmp[0], 10);
			var sMonth = parseInt(tmp[1], 10);

			if(year == sYear) {
				s = sMonth;
			}
		}
		if(endDate != null) {
			var tmp = endDate.split("-");
			var eYear = parseInt(tmp[0], 10);
			var eMonth = parseInt(tmp[1], 10);

			if(year == eYear) {
				e = eMonth;
			}
		}

		var isContain = false;
		for(var i = s ; i <= e ; i++) {
			if(i == month) {
				isContain = true;
			}
			html += '<option value="' + i + '">' + monthText[i - 1] + '</option>';
		}
		jQuery("#" + elementID + "_month").html(html);
		if(isContain) {
			jQuery("#" + elementID + "_month").val(month);
		} else {
			month = parseInt(jQuery("#" + elementID + "_month").val(), 10);
			updateDate();
		}
	}

	function addDay() {
		var s = 1, e = monthDay[month - 1];
		var html = "";
		if(startDate != null) {
			var tmp = startDate.split("-");
			var sYear = parseInt(tmp[0], 10);
			var sMonth = parseInt(tmp[1], 10);
			var sDay = parseInt(tmp[2], 10);

			if(year == sYear && month == sMonth) {
				s = sDay;
			}
		}
		if(endDate != null) {
			var tmp = endDate.split("-");
			var eYear = parseInt(tmp[0], 10);
			var eMonth = parseInt(tmp[1], 10);
			var eDay = parseInt(tmp[2], 10);

			if(year == eYear && month == eMonth) {
				e = eDay;
			}
		}

		var isContain = false;
		for(var i = s ; i <= e ; i++) {
			if(i == day) {
				isContain = true;
			}
			html += '<option value="' + i + '">' + i + '</option>';
		}
		jQuery("#" + elementID + "_day").html(html);
		if(isContain) {
			jQuery("#" + elementID + "_day").val(day);
		} else {
			day = parseInt(jQuery("#" + elementID + "_day").val(), 10);
			updateDate();
		}
	}

	function addListenner() {
		jQuery("#" + elementID + "_year").change(function() {
			year = parseInt(jQuery(this).val(), 10) - 543;
			if(year % 4 == 0) {
				monthDay[1] = 29;
			} else {
				monthDay[1] = 28;
			}
			updateDate();
			addMonth();
			addDay();
		});

		jQuery("#" + elementID + "_month").change(function() {
			month = parseInt(jQuery(this).val(), 10);
			updateDate();
			addDay();
		});

		jQuery("#" + elementID + "_day").change(function() {
			day = parseInt(jQuery(this).val(), 10);
			updateDate();
		});
	}

	function updateDate() {
		if(isNaN(month)) {
			month = 1;
		}
		if(isNaN(day)) {
			day = 1;
		}
		date = zeroFill(year,4) + "-" + zeroFill(month,2) + "-" + zeroFill(day,2);
		jQuery("input[name=" + elementID + "]").val(date).trigger("change");
	}

	function compareTo(target) {
		//Compare two date
		// - If date < target
		// 0 IF date = target
		// + IF date > target
		return new Date(date).getTime() - new Date(target).getTime();
	}

	function zeroFill(number, length, format) {
		var n = number;
		var p = length;
		var pad_char = typeof format !== 'undefined' ? format : '0';
		var pad = new Array(1 + p).join(pad_char);
		return (pad + n).slice(-pad.length);
	}

	//public method
	this.getDate = function() {
		return date;
	};
	this.getDay = function() {
		return day;
	};
	this.getMonth = function() {
		return month;
	};
	this.getYear = function() {
		return year;
	};
	this.setDay = function(d) {
		day = parseInt(d);
		addDay();
		updateDate();
	};
	this.setMonth = function(m) {
		month = parseInt(m, 10);
		addMonth();
		addDay();
		updateDate();
	};
	this.setYear = function(y) {
		year = parseInt(y, 10);
		addYear();
		addMonth();
		addDay();
		updateDate();
	};
	this.setDate = function(d) {
		var tmp = d.split("-");
		year = parseInt(tmp[0], 10);
		month = parseInt(tmp[1], 10);
		day = parseInt(tmp[2], 10);

		addYear();
		addMonth();
		addDay();
		updateDate();
	};
	this.setStartDate = function(d) {
		startDate = d;
		addYear();
		addMonth();
		addDay();
	};
	this.setEndDate = function(d) {
		endDate = d;
		addYear();
		addMonth();
		addDay();
	};
	this.disabled = function(b) {
		jQuery("#" + elementID + "_year").prop("disabled",b == true);
		jQuery("#" + elementID + "_month").prop("disabled",b == true);
		jQuery("#" + elementID + "_day").prop("disabled",b == true);
	};
}

//Util Functions
function formatFill(number, length, format) {
	var n = number;
	var p = length;
	var pad_char = typeof format !== 'undefined' ? format : '0';
	var pad = new Array(1 + p).join(pad_char);
	return (pad + n).slice(-pad.length);
}
function compareDate(date1, date2) {
		//Compare two date
		// - If date1 < date2
		// 0 IF date1 = date2
		// + IF date1 > date2
	return new Date(date1).getTime() - new Date(date2).getTime();
}

function zRangeDatepicker(id) {
	//private property
	var elementID;
	var startDate, endDate;
	var fromDate, toDate;

	//private constructor
	var __construct = function() {
		elementID = id;
		appendHTML();

		fromDate = new zDatepicker(elementID + "_fromDate");
		toDate = new zDatepicker(elementID + "_toDate");

		if(jQuery("#" + elementID).data("from") != null && jQuery("#" + elementID).data("from").length != 0) {
			fromDate.setDate(jQuery("#" + elementID).data("from"));
		}

		if(jQuery("#" + elementID).data("to") != null && jQuery("#" + elementID).data("to").length != 0) {
			toDate.setDate(jQuery("#" + elementID).data("to"));
		}

		if(jQuery("#" + elementID).data("startdate") != null && jQuery("#" + elementID).data("startdate").length != 0) {
			startDate = jQuery("#" + elementID).data("startdate");
			fromDate.setStartDate(startDate);
		} else {
			startDate = null;
		}
		if(jQuery("#" + elementID).data("enddate") != null && jQuery("#" + elementID).data("enddate").length != 0) {
			endDate = jQuery("#" + elementID).data("enddate");
			fromDate.setEndDate(endDate);
			toDate.setEndDate(endDate);
		} else {
			endDate = null;
		}

		toDate.setStartDate(fromDate.getDate());

		addListenner();
		return this;
	}();
	//private method
	function appendHTML() {
		jQuery("#" + elementID).html("");
		jQuery("#" + elementID).append('<span class="zDatepicker" id="' + elementID + '_fromDate"></span> ถึง ');
		jQuery("#" + elementID).append('<span class="zDatepicker" id="' + elementID + '_toDate"></span>');
	}

	function addListenner() {
		jQuery("input[name=" + elementID + "_fromDate]").change(function() {
			toDate.setStartDate(jQuery(this).val());
		});
	}

	this.getFromDate = function(d) {
		return fromDate.getDate();
	};
	this.getToDate = function(d) {
		return toDate.getDate();
	};
	this.setFromDate = function(d) {
		fromDate.setDate(d);
	};
	this.setToDate = function(d) {
		toDate.setDate(d);
	};
}
