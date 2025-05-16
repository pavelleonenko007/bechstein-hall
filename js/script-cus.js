const SEARCH_MODE_CLASS_NAME = 'searchmode';

let textovf;
let ovfindex = 0;
$(document).ready(function () {
  $('.head-event-content_in .h1-75-90, .head-event-content_in .p-25-40').each(
    function (index) {
      ovfindex = ovfindex + 1;
      $(this).addClass('ovfjs');
      textovf = $(this).text();
      $(this).html(
        '<div class="textovf" style="--ovfindex:' +
          ovfindex +
          '">' +
          textovf +
          '</div>'
      );
    }
  );

  if ($('.body').hasClass('historypage')) {
    $('.body').addClass('page-ready');
  } else {
    $('.body').addClass('page-ready');
  }
});

$(document).ready(function () {
  if ($('.body').hasClass('black-theme')) {
    $('.navbar').addClass('grey-head-scroll');
  }

  $('html').addClass('pageload');

  //$('.burger-menu').append('<svg class="overlay-nav_bg" width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none"><path id="p1" class="overlay-nav_path" vector-effect="non-scaling-stroke" d="M 0 0 V 0 Q 50 0 100 0 V 0 Z"><animate class="opensvg" xlink:href="#p1" repeatCount="1" attributeName="d"attributeType="XML"values="M 0 0 V 0 Q 50 0 100 0 V 0 Z;M 0 0 V 20 Q 50 50 100 20 V 0 Z;M 0 0 V 80 Q 50 90 100 80 V 0 Z;M 0 0 V 100 Q 50 100 100 100 V 0 Z"dur="1s"keyTimes="0; 0.5; 0.75; 1"calcMode="linear" /><animate class="closesvg" xlink:href="#p1" repeatCount="1" attributeName="d"attributeType="XML" values="M 0 0 V 100 Q 50 100 100 100 V 0 Z;M 0 0 V 100 Q 50 100 100 100 V 0 Z;M 0 0 V 100 Q 50 50 100 100 V 0 Z;M 0 0 V 0 Q 50 0 100 0 V 0 Z" dur="1.5s" keyTimes="0; 0.5; 0.75; 1" calcMode="linear" /></path></svg>');

  // добавляем кнопку Play
//   $('.header-video-link').append(
//     '<svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 11L9.2855e-07 21.3923L1.83707e-06 0.607695L18 11Z" fill="white"/></svg>'
//   );
//   $('.header-video-link').addClass('playicosvg');

  $('.ui-event-link_img-mom').append(
    '<svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 11L9.2855e-07 21.3923L1.83707e-06 0.607695L18 11Z" fill="white"/></svg>'
  );
  $('.ui-event-link_img-mom').addClass('playicosvg');

  // $('.calendar-btn').append(
  //   '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="0.5" y="1" width="23" height="23" rx="1.5" stroke="#030E14"/><rect x="1" y="1.5" width="22" height="6" fill="#030E14"/><path d="M9.24651 19.2793C10.9841 19.2793 12.1501 18.2619 12.1501 16.8215C12.1501 15.4726 11.087 14.5467 9.50943 14.5467C9.18935 14.5467 8.89213 14.5924 8.64064 14.661C10.0238 13.9294 11.4871 13.255 11.4871 12.0775C11.4871 11.1859 10.7554 10.5 9.6809 10.5C8.80068 10.5 6.45725 11.4602 6.45725 12.4776C6.45725 12.832 6.69731 13.0721 7.02882 13.0721C7.90904 13.0721 7.47464 11.7117 8.10337 11.1973C8.332 11.003 8.58349 10.9458 8.84641 10.9458C9.52086 10.9458 10.0353 11.5174 10.0353 12.2604C10.0353 13.2778 9.31509 14.1237 7.77186 15.004C8.18339 14.9125 8.49204 14.8668 8.78925 14.8668C9.90952 14.8668 10.664 15.667 10.664 16.7987C10.664 18.079 9.88666 18.9135 8.75496 18.9135C8.37772 18.9135 8.00049 18.8335 7.77186 18.6963C7.12027 18.319 7.50894 16.7301 6.583 16.7301C6.24006 16.7301 6 16.9816 6 17.3474C6 18.2276 8.08051 19.2793 9.24651 19.2793Z" fill="#030E14"/><path d="M13.3763 19.1421H17L15.9255 18.5134V10.5L13.0676 11.4831L14.4965 11.9289V18.5134L13.3763 19.1421Z" fill="#030E14"/></svg>'
  // );
  // $('.calendar-btn').addClass('playicosvg');

  $('.event-ticket_calendar-btn').append(
    '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="0.5" y="1" width="23" height="23" rx="1.5" stroke="#030E14"/><rect x="1" y="1.5" width="22" height="6" fill="#030E14"/><path d="M9.24651 19.2793C10.9841 19.2793 12.1501 18.2619 12.1501 16.8215C12.1501 15.4726 11.087 14.5467 9.50943 14.5467C9.18935 14.5467 8.89213 14.5924 8.64064 14.661C10.0238 13.9294 11.4871 13.255 11.4871 12.0775C11.4871 11.1859 10.7554 10.5 9.6809 10.5C8.80068 10.5 6.45725 11.4602 6.45725 12.4776C6.45725 12.832 6.69731 13.0721 7.02882 13.0721C7.90904 13.0721 7.47464 11.7117 8.10337 11.1973C8.332 11.003 8.58349 10.9458 8.84641 10.9458C9.52086 10.9458 10.0353 11.5174 10.0353 12.2604C10.0353 13.2778 9.31509 14.1237 7.77186 15.004C8.18339 14.9125 8.49204 14.8668 8.78925 14.8668C9.90952 14.8668 10.664 15.667 10.664 16.7987C10.664 18.079 9.88666 18.9135 8.75496 18.9135C8.37772 18.9135 8.00049 18.8335 7.77186 18.6963C7.12027 18.319 7.50894 16.7301 6.583 16.7301C6.24006 16.7301 6 16.9816 6 17.3474C6 18.2276 8.08051 19.2793 9.24651 19.2793Z" fill="#030E14"/><path d="M13.3763 19.1421H17L15.9255 18.5134V10.5L13.0676 11.4831L14.4965 11.9289V18.5134L13.3763 19.1421Z" fill="#030E14"/></svg>'
  );
  $('.event-ticket_calendar-btn').addClass('playicosvg');

  $('.slider-days_rad').click(function () {
    $('.today-date').addClass('disable-day');
  });

  $('.head-search-btn').click(function () {
    const $body = $('body');
    
    $body.toggleClass(SEARCH_MODE_CLASS_NAME);
    
    if ($body.hasClass(SEARCH_MODE_CLASS_NAME)) {
        $('input[type="search"].search-input').get(0).focus();
    } else {
        document.activeElement.blur();
    }
  });

  $('.head-search-btn-closen').click(function () {
    $('body').removeClass('searchmode');
  });

  $('.wrapper').click(function () {
    $('.body').removeClass('searchmode');
  });

  // $( ".header-book-head-btn" ).click(function() {
  //         $('body').toggleClass('opencart')
  // });

  // $( "a" ).click(function() {
  //     if ($(this).hasClass("header-book-head-btn")){}
  //     else {$('body').removeClass('opencart')}
  // });

  //   document.querySelector('.b-menu').addEventListener('click', (evt) => {
  //     if ($('.b-menu').hasClass('menuopenedb')) {
  //       $('.b-menu').removeClass('menuopenedb');
  //       $('#p1').attr('d', 'M 0 0 V 0 Q 50 0 100 0 V 0 Z');
  //       document.querySelectorAll('.closesvg').forEach((element) => {
  //         element.beginElement();
  //         //$('#p1').attr("d", "M 0 0 V 0 Q 50 0 100 0 V 0 Z");
  //         setTimeout(function () {}, 1500);
  //       });
  //     } else {
  //       $('.b-menu').addClass('menuopenedb');
  //       $('#p1').attr('d', 'M 0 0 V 100 Q 50 100 100 100 V 0 Z');
  //       document.querySelectorAll('.opensvg').forEach((element) => {
  //         element.beginElement();
  //         //$('#p1').attr("d", "M 0 0 V 100 Q 50 100 100 100 V 0 Z");
  //         setTimeout(function () {}, 1000);
  //       });
  //     }
  //   });
});
