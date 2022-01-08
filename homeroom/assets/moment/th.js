//! moment.js locale configuration
//! locale : Thai [th]
//! author : Kridsada Thanabulpong : https://github.com/sirn

;(function (global, factory) {
   typeof exports === 'object' && typeof module !== 'undefined'
       && typeof require === 'function' ? factory(require('../moment')) :
   typeof define === 'function' && define.amd ? define(['../moment'], factory) :
   factory(global.moment)
}(this, (function (moment) { 'use strict';


var th = moment.defineLocale('th', {
    months : 'January_February_March_April_May_June_July_August_September_October_November_December'.split('_'),
    monthsShort : 'JAN_FEB_MAR_APR_MAY_JUN_JUL_AUG_SEP_OCT_NOV_DEC'.split('_'),
    monthsParseExact: true,
    weekdays : 'Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturay'.split('_'),
    weekdaysShort : 'Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturay'.split('_'), // yes, three characters difference
    weekdaysMin : 'Sun_Mon_Tue_Wed_Thu_Fri_Sat'.split('_'),
    weekdaysParseExact : true,
    longDateFormat : {
        LT : 'H:mm',
        LTS : 'H:mm:ss',
        L : 'DD/MM/YYYY',
        LL : 'D MMMM YYYY',
        LLL : 'D MMMM YYYY Time H:mm',
        LLLL : 'Date dddd D MMMM YYYY Time H:mm'
    },
    meridiemParse: /ก่อนเที่ยง|หลังเที่ยง/,
    isPM: function (input) {
        return input === 'หลังเที่ยง';
    },
    meridiem : function (hour, minute, isLower) {
        if (hour < 12) {
            return 'ก่อนเที่ยง';
        } else {
            return 'หลังเที่ยง';
        }
    },
    calendar : {
        sameDay : '[Today Time] LT',
        nextDay : '[Tomorrow Time] LT',
        nextWeek : 'dddd[หน้า เวลา] LT',
        lastDay : '[Yesterday เวลา] LT',
        lastWeek : '[วัน]dddd[ที่แล้ว เวลา] LT',
        sameElse : 'L'
    },
    relativeTime : {
        future : 'more %s',
        past : '%sทago',
        s : 'ไม่กี่วินาที',
        m : '1 minute',
        mm : '%d minute',
        h : '1 hour',
        hh : '%d hour',
        d : '1 day',
        dd : '%d day',
        M : '1 month',
        MM : '%d month',
        y : '1 year',
        yy : '%d year'
    }
});

return th;

})));
