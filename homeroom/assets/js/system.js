/*                         _
                        _ooOoo_
                       o8888888o
                       88" . "88
                       (| -_- |)
                       O\  =  /O
                    ____/`---'\____
                  .'  \\|     |//  `.
                 /  \\|||  :  |||//  \
                /  _||||| -:- |||||_  \
                |   | \\\  -  /'| |   |
                | \_|  `\`---'//  |   |
                \  .-\__ '-. -'__/-.  /
              ___`. .'  /--.--\  '. .'__
           ."" '<  `.__\_<|>_/__.'  _>  \"".
          | | : `- \`. ;'. _/; .'/ /  -'  ; |
          \ \ `-.  \_\_`. _.' _/_/  -'  _-' /
===========`-.'___`-.__\ \___ / __.-'_.-'_.-'===========
       "อบัคยา ปรมาลาภา" - การไม่มีบัคเป็นลาภอันประเสริฐ
   "การไม่มี Nul เป็นเรื่องงี่ดี"	
*/
var System = {
  helper: {
    DataTable: {}
  },
  global: {},
  template: {},
  settings: {
    pace_module: true,
    toastr_module: true
  }
};

System.helper.scrollTop = function () {
  return document.scrollTop || document.documentElement.scrollTop || document.body.scrollTop
}
System.helper.winHeight = function () {
  return window.innerHeight || document.documentElement.clientHeight;
}
System.helper.winWidth = function () {
  return window.innerWidth || document.documentElement.clientWidth;
}

System.setupAjax = function () {
  // toggle Pace on akax start
  $(document).ajaxStart(function () {
    if (System.settings.pace_module) {
      Pace.restart();
    }
  });
  // setup ajax
  $.ajaxSetup({
    type: 'POST',
    dataType: 'json',
    catch: false,
    error: function (xhr, status, error) {
      var message;
      if (xhr.status === 0) {
        message = 'Not connected.\nPlease verify your network connection.';
      } else if (xhr.status == 404) {
        message = 'The requested page not found. [404]';
      } else if (xhr.status == 500) {
        message = 'Internal Server Error [500].';
      } else if (status === 'parsererror') {
        message = 'Requested JSON parse failed.';
      } else if (status === 'timeout') {
        message = 'Time out error.';
      } else if (status === 'abort') {
        message = 'Ajax request aborted.';
      } else {
        message = 'Uncaught Error.\n' + xhr.responseText;
      }
      System.notification('error', message);
      console.log(xhr.responseText);
    }
  });
}

System.initTemplate = function () {
  $('.z-template').each(function (index, el) {
    var $template = $(el);
    var id = $template.attr('id');
    if (id) {
      System.template[id] = $template.html();
      $template.remove();
    }
  });
}
System.compileTemplate = function (templateID, data) {
  if (typeof (System.template[templateID]) == 'undefined') {
    var $template = $('#' + templateID);
    if ($template.length > 0) {
      System.template[templateID] = $template.html();
      $template.remove();
    } else {
      console.error('Undefined Template ID: ' + templateID);
      return null;
    }
  }
  var html = System.template[templateID];
  for (var key in data) {
    if (typeof (data[key]) != 'undefined') {
      var re = new RegExp('{{' + key + '}}', 'g');
      html = html.replace(re, data[key]);
    }
  }
  return html;
}
System.helper.imgUrl = function (url) {
  return 'style="background-image: url(\'' + url + '\')"';
}
System.helper.imgSrc = function (url) {
  return 'src="' + url + '"';
}
System.helper.videoYoutube = function (code) {
  return 'src="https://www.youtube.com/embed/' + code + '"';
}
System.helper.td = function (html, customClass) {
  customClass = (typeof (customClass) != 'undefined') ? customClass : '';
  return '<td class="' + customClass + '">' + html + '</td>';
}
System.helper.tr = function (html, customClass) {
  customClass = (typeof (customClass) != 'undefined') ? customClass : '';
  return '<tr class="' + customClass + '">' + html + '</tr>';
}
System.helper.short_text = function (text, length) {
  length = (typeof (length) != 'undefined') ? length : 200;
  var raw_text = $(text).text();
  if (raw_text.length > length) {
    return raw_text.substring(0, length) + '...';
  } else {
    return raw_text;
  }
}

System.helper.DataTable.lengthMenu = [
  [10, 25, 50, 100, -1],
  [10, 25, 50, 100, 'All']
];
System.helper.DataTable.language = {
  'decimal': '',
  'emptyTable': 'Data not found',
  'info': 'Show row data _START_ To _END_ From all _TOTAL_ Row',
  'infoEmpty': 'Data not found',
  'infoFiltered': '(Search all information _MAX_ Row)',
  'infoPostFix': '',
  'thousands': ',',
  'lengthMenu': 'Show _MENU_ Row',
  'loadingRecords': 'Loading...',
  'processing': '<i class="fa fa-spinner fa-pulse"></i> กำลังประมวลผล...',
  'search': 'Search',
  'zeroRecords': 'Data not found',
  'paginate': {
    'first': '<i class="fa fa-step-backward"></i>',
    'last': '<i class="fa fa-step-forward"></i>',
    'previous': '<i class="fa fa-chevron-left"></i>',
    'next': '<i class="fa fa-chevron-right"></i>'
  },
  'aria': {
    'sortAscending': ':Sorted ascending',
    'sortDescending': ':Sort Descending'
  }
}

System.handleAnimation = function () {
  $(window).on('scroll', function () {
    $('.viewpoint-animate').each(function (index, el) {
      var $this = $(el);
      var rect = $this[0].getClientRects();
      var currTop = rect[0].top;
      var winHeight = window.innerHeight;
      var animationName = $this.data('animation');
      if (currTop < (winHeight * 0.95)) {
        $this.addClass(animationName + ' animated');
        $this.removeClass('viewpoint-animate');
      }
    });;
  });

  // $('.aniview').AniView({
  //   'animateThreshold': 50,
  //   'scrollPollInterval': 10
  // });
  $(window).scroll();
}

System.handleScrollTop = function () {
  // Back To Top
  var offset = 450;
  var duration = 500;
  var upToTop = $('.btn-to-top');

  if (upToTop) {
    // $(window).on('scroll', function () {
    //   if (upToTop) {
    //     if ($(this).scrollTop() > offset) {
    //       upToTop.fadeIn(duration);
    //     } else {
    //       upToTop.fadeOut(duration);
    //     }
    //   }
    // });

    upToTop.on('click', function (event) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: 0
      }, duration);
      return false;
    });
  }
}

System.handleEqualHeight = function (scope) {
  var setEqualHeight = debounce(function () {
    $(scope).each(function (idx, ele) {
      var $elements = $(ele).find('.eq-height');
      $elements.css('min-height', 'auto');
      var max_height = 0;

      for (var i = 0; i < $elements.length; i++) {
        var curr_height = $($elements[i]).outerHeight();
        if (i == 0) {
          max_height = curr_height;
        } else if (curr_height > max_height) {
          max_height = curr_height;
        }
      }
      $elements.css('min-height', max_height + 'px');
    });
  }, 250);

  setTimeout(function () {
    setEqualHeight();
    window.addEventListener('resize', setEqualHeight);
  });
}

// require smoothscroll.js
System.smoothScroll = function () {
  /* Scroll Like Mac*/
  SmoothScroll({
    keyboardSupport: false,
    animationTime: 300, // [ms]
    stepSize: 50 // [px]
  });
}

System.handleLanguage = function () {
  var lang = Cookies.get('language');
  if (typeof (lang) != 'undefined') {
    System.switchLanguage(lang);
  } else {
    $('.lang-switch[data-default-lang="true"]').addClass('active');
  }

  $(document).on('click', '.lang-switch', function (e) {
    e.preventDefault();
    var lang = $(this).data('lang');
    if (typeof (lang) != 'undefined') {
      System.switchLanguage(lang);
    }
  });
}
System.switchLanguage = function (lang) {
  Cookies.set('language', lang);
  $('.lang-switch').removeClass('active');
  $('.lang-switch[data-lang="' + lang + '"]').addClass('active');
  $('.multi-language').each(function (index, el) {
    var $this = $(el);
    var text = $this.data('lang-' + lang);
    if (typeof (text) != 'undefined') {
      $this.html(text);
    }
  });
}
System.refreshLanguage = function () {
  var lang = Cookies.get('language');
  if (typeof (lang) != 'undefined') {
    System.switchLanguage(lang);
  }
}

System.helper.submitFlag = function () {
  var rd = Math.floor((Math.random() * 10000) + 1);
  return {
    'html': '<input name="flag" type="text" class="form-control" id="flag_' + rd + '" required="required" style="display:none;">',
    'id': '#flag_' + rd
  }
}
// require toastr.js
System.notification = function (type, message, options) {
  if (System.settings.toastr_module) {
    var progressbar = true;
    var position = 'toast-bottom-right';
    var timeout = 3;
    var exTimeout = 1;
    if (typeof (options) !== 'undefined') {
      progressbar = (typeof (options.progressbar) === 'undefined') ? progressbar : options.progressbar;
      position = (typeof (options.position) === 'undefined') ? position : options.position;
      timeout = (typeof (options.timeout) === 'undefined') ? timeout : options.timeout;
      exTimeout = (typeof (options.exTimeout) === 'undefined') ? exTimeout : options.exTimeout;
    }
    toastr.options.progressBar = progressbar;
    toastr.options.positionClass = position;
    toastr.options.timeOut = parseInt(timeout, 10) * 1000;
    toastr.options.extendedTimeOut = parseInt(exTimeout, 10) * 1000;
    if (type === 'info') {
      toastr.info(message);
    } else if (type === 'success') {
      toastr.success(message);
    } else if (type === 'warning') {
      toastr.warning(message);
    } else if (type === 'error') {
      toastr.error(message);
    }
  } else {
    alert(message);
  }
}
System.confirm = function (title, text, onOK, onCancel) {
  swal({
    title: title,
    text: text,
    type: 'question',
    showCancelButton: true,
    confirmButtonText: '<i class="fa fa-check"></i> Yes',
    cancelButtonText: '<i class="fa fa-times"></i> No',
    confirmButtonClass: 'btn btn-default',
    cancelButtonClass: 'btn btn-link',
    buttonsStyling: false
  }).then(function () {
    if (typeof (onOK) === 'function') onOK();
  }, function (dismiss) {
    if (typeof (onCancel) === 'function') onCancel(dismiss);
  });
}

System.alert = function (title, text, onOK) {
  swal({
    title: title,
    text: text,
    type: 'warning',
    confirmButtonText: '<i class="fa fa-check"></i> Yes',
    confirmButtonClass: 'btn btn-default',
    buttonsStyling: false
  }).then(function () {
    if (typeof (onOK) === 'function') onOK();
  }, function (dismiss) {
    if (typeof (onCancel) === 'function') onCancel(dismiss);
  });
}

System.readImage = function (fileInput, onSuccess) {
  if (!fileInput.files || !fileInput.files[0]) return false;
  var imgPath = $(fileInput)[0].value;
  var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

  if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
    if (typeof (FileReader) != "undefined") {
      var reader = new FileReader();
      reader.onload = function (e) {
        // get loaded data and render thumbnail.
        if (typeof (onSuccess) === 'function') onSuccess(e);
      };
      // read the image file as a data URL.
      reader.readAsDataURL(fileInput.files[0]);
      return 'success';
    } else {
      return 'not support';
    }
  } else {
    return 'invalid type';
  }
}

System.initTooltip = function () {
  $('[data-toggle="tooltip"]').tooltip({
    'container': 'body'
  });
}

System.detectIE = function () {
  /**
   * detect IE
   * returns version of IE or false, if browser is not Internet Explorer
   */
  var ua = window.navigator.userAgent;

  // Test values; Uncomment to check result …

  // IE 10
  // ua = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)';

  // IE 11
  // ua = 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko';

  // Edge 12 (Spartan)
  // ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0';

  // Edge 13
  // ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586';

  var msie = ua.indexOf('MSIE ');
  if (msie > 0) {
    // IE 10 or older => return version number
    return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
  }

  var trident = ua.indexOf('Trident/');
  if (trident > 0) {
    // IE 11 => return version number
    var rv = ua.indexOf('rv:');
    return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
  }

  var edge = ua.indexOf('Edge/');
  if (edge > 0) {
    // Edge (IE 12+) => return version number
    return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
  }

  // other browser
  return false;
}

System.helper.typeaheadMatcher = function (strs) {
  return function findMatches(q, cb) {
    var matches, substringRegex;
    // an array that will be populated with substring matches
    matches = [];
    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');
    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function (i, str) {
      if (substrRegex.test(str)) {
        matches.push(str);
      }
    });

    cb(matches);
  };
}
System.helper.zeroFill = function (width, number, pad) {
  if (pad === undefined) pad = '0';
  width -= number.toString().length;
  if (width > 0) return new Array(width + (/\./.test(number) ? 2 : 1)).join(pad) + number;
  return number + '';
}

$(document).ready(function () {
  System.setupAjax();
  System.initTemplate();
  //System.handleLanguage();
  System.handleScrollTop();
  System.smoothScroll();
  System.handleAnimation();
  System.handleEqualHeight('.has-eq-height');
  System.initTooltip();

  // Get IE or Edge browser version
  var version = System.detectIE();
  if (version === false) {
    // other browser
  } else if (version >= 12) {
    // ms edge
  } else {
    // ie 11 below
    System.alert('ตรวจพบบราวเซอร์รุ่นเก่า', 'กรุณาใช้บราวเซอร์รุ่นใหม่เพื่อประสิทธิภาพการใช้งานที่ดีกว่า');
  }

  $(document).on('click', '.toggle-modal', function(e) {
    e.preventDefault();
    var $this = $(this);
    $($this.data('target')).modal().on('shown.bs.modal', function () {
      $($this.data('target')).find('input').first().focus();
    });
  });

  $(document).on('click', '.toggle-confirm', function(e) {
    e.preventDefault();
    var $this = $(this);
    System.confirm('', $this.data('message'), function() {
      $this.parents('form').submit();
    }, function() {});
  });

  $('.pmd-data-table').each(function(idx, ele) {
    var $this = $(this);
    var paging = $this.data('paging');
    if (typeof (paging) == 'undefined') {
      paging = true;
    }
    $this.DataTable({
      'language': System.helper.DataTable.language,
      'columnDefs': [{
        'targets': 'no-sort',
        'orderable': false,
      }],
      'bDestroy': true
    });

    // disable input number on mouse wheel
    $('input[type=number]').on('mousewheel', function (e) { $(this).blur(); });
  });

  $(document).on('click', '.select-focus' , function(e) {
    var $this = $(this);
    $this.select();
  });
});

// Plugin -- Get Data from Query String
(function ($) {
  $.QueryString = (function (paramsArray) {
    let params = {};

    for (let i = 0; i < paramsArray.length; ++i) {
      let param = paramsArray[i]
        .split('=', 2);

      if (param.length !== 2)
        continue;

      params[param[0]] = decodeURIComponent(param[1].replace(/\+/g, " "));
    }

    return params;
  })(window.location.search.substr(1).split('&'))
})(jQuery);

