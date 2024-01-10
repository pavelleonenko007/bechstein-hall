document.querySelectorAll('.grey-z').forEach((trigger) => {
  new IntersectionObserver(
    (entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          console.log(entry.isIntersecting);
          $('.navbar').addClass('grey-head-scroll');
        } else {
          //$(".navbar").removeClass('grey-head');
        }
      });
    },
    {
      threshold: 1,
    }
  ).observe(trigger);
});

document.querySelectorAll('.white-z').forEach((trigger) => {
  new IntersectionObserver(
    (entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          console.log(entry.isIntersecting);
          $('.navbar').removeClass('grey-head-scroll');
        } else {
          //$(".navbar").removeClass('grey-head');
        }
      });
    },
    {
      threshold: 1,
    }
  ).observe(trigger);
});

class SvgLoader {
  static instance;

  constructor() {
    if (SvgLoader.instance) {
      return SvgLoader.instance;
    }
    this.svg = document.getElementById('svg');
    this.path = this.svg.querySelector('#path');
    this.timeLine = gsap.timeline();
    this.beforeCurve = 'M0 0 V100 Q50 95, 100 100 V100 0 Z';
    this.curve = 'M0 0 V100 Q50 50, 100 100 V100 0 Z';
    this.revertCurve = 'M0 0 V0 Q50 20, 100 0 V0 0 Z';
    this.revertCurveBeforeEnd = 'M0 0 V90 Q50 110, 100 90 V0 0 Z';
    this.revertCurveEnd = 'M0 0 V100 Q50 100, 100 100 V100 0 Z';
    this.flat = 'M0 0 V0 Q50 0, 100 0 V0 0 Z';
    SvgLoader.instance = this;
  }

  static create() {
    return new SvgLoader();
  }

  open(asMenuBackground = false) {
    this.svg.style.zIndex = asMenuBackground ? 1 : 2;
    this.timeLine
      .to(this.path, {
        duration: 0.5,
        attr: {
          d: this.beforeCurve,
        },
        ease: 'power2.easeIn',
      })
      .to(this.path, {
        duration: 0.4,
        attr: {
          d: this.curve,
        },
        ease: 'power2.easeIn',
      })
      .to(this.path, {
        duration: 0.8,
        attr: { d: this.flat },
        ease: 'power2.easeOut',
      })
      .to(this.path, {
        y: -1500,
      });
  }

  close(asMenuBackground = false) {
    this.svg.style.zIndex = asMenuBackground ? 1 : 2;
    this.timeLine
      .to(this.path, {
        y: 0,
      })
      .to(this.path, {
        duration: 0.3,
        attr: {
          d: this.revertCurve,
        },
        ease: 'power2.easeIn',
      })
      .to(this.path, {
        duration: 1,
        attr: {
          d: this.revertCurveBeforeEnd,
        },
        ease: 'power2.easeOut',
      })
      .to(this.path, {
        duration: 0.2,
        attr: {
          d: this.revertCurveEnd,
        },
        ease: 'power2.easeOut',
      });
  }
}

window.svgLoader = SvgLoader.create();

const initBurgerMenu = () => {
  const burgerMenuButton = document.querySelector('.b-menu');

  if (!burgerMenuButton) return;

  burgerMenuButton.addEventListener('click', (event) => {
    event.preventDefault();
    // console.log(window.svgLoader.close());
    if (burgerMenuButton.classList.contains('menuopenedb')) {
      burgerMenuButton.classList.remove('menuopenedb');
      window.svgLoader.open(true);
    } else {
      burgerMenuButton.classList.add('menuopenedb');
      window.svgLoader.close(true);
    }
  });
};

function animate(element, styles = {}, duration, callback = () => {}) {
  let startAnimation;
  const currentStyles = {};

  for (const prop in styles) {
    if (Object.hasOwnProperty.call(styles, prop)) {
      currentStyles[prop] = parseFloat(window.getComputedStyle(element)[prop]);
    }
  }

  const step = (time) => {
    if (!startAnimation) {
      startAnimation = time;
    }

    let progress = (time - startAnimation) / duration;

    for (const prop in styles) {
      if (Object.hasOwnProperty.call(styles, prop)) {
        const value = styles[prop];
        element.style[prop] =
          currentStyles[prop] + (value - currentStyles[prop]) * progress;
      }
    }

    if (progress < 1) {
      return window.requestAnimationFrame(step);
    } else {
      callback();
    }
  };

  return window.requestAnimationFrame(step);
}

function formatDate(date) {
  var d = new Date(date),
    month = '' + (d.getMonth() + 1),
    day = '' + d.getDate(),
    year = d.getFullYear();

  if (month.length < 2) month = '0' + month;
  if (day.length < 2) day = '0' + day;

  return [year, month, day].join('-');
}

class CustomCursor {
  constructor(cursorId, parentElementSelector, options = {}) {
    this.cursor = document.getElementById(cursorId);
    if (!this.cursor) return;
    this.parentElement = parentElementSelector
      ? this.cursor.closest(parentElementSelector)
      : document.body;
    this.options = {
      ratio: 0.2,
      ...options,
    };

    gsap.set(this.cursor, {
      xPercent: -50,
      yPercent: -50,
    });

    this.handleMouseMove = this.handleMouseMove.bind(this);
    this.handleHover = this.handleHover.bind(this);
    this.handleLeave = this.handleLeave.bind(this);

    this.parentElement.addEventListener('mousemove', this.handleMouseMove);
    this.parentElement.addEventListener('mouseover', this.handleHover);
    this.parentElement.addEventListener('mouseleave', this.handleLeave);
  }

  handleLeave(event) {
    this.cursor.classList.remove('custom-cursor--active');
  }

  handleHover(event) {
    if (event.target.closest('.slider-wvwnts_bottom')) {
      this.cursor.classList.remove('custom-cursor--active');
      return;
    }
    this.cursor.classList.add('custom-cursor--active');
  }

  handleMouseMove(event) {
    const targetCoords = this.parentElement.getBoundingClientRect();
    const xCoord = event.clientX - targetCoords.left;
    const yCoord = event.clientY - targetCoords.top;

    gsap.to(this.cursor, this.options.ratio, {
      x: xCoord,
      y: yCoord,
    });
  }
}

new CustomCursor('whats-on-cursor', '.slider-wvwnts-home');

new CustomCursor(
  'ball',
  '#w-node-f68b1e07-4cf2-4c60-76f8-48cbef9b803c-89261594'
);

class WOCalendar {
  constructor(selector, options = {}) {
    this.calendarNode = document.querySelector(selector);
    if (!this.calendarNode) return;
    this.options = {
      theme: 'dark',
      beforeDispatchEvent: () => {},
      selectDayCallback: () => {},
      ...options,
    };
    this.months = [
      'January',
      'February',
      'March',
      'April',
      'May',
      'June',
      'July',
      'August',
      'September',
      'October',
      'November',
      'December',
    ];
    this.today = new Date();
    this.fromInput = document.querySelector('input[name="from"]');
    this.toInput = document.querySelector('input[name="to"]');
    this.selectedDates = [];
    if (this.fromInput && this.fromInput.value) {
      this.selectedDates.push(formatDate(this.fromInput.value));
    }

    if (this.toInput && this.toInput.value) {
      this.selectedDates.push(formatDate(this.toInput.value));
    }

    this.setCalendarHTML();
    this.setDate();
    this.setEvents();
  }

  static create(selector, options) {
    return new WOCalendar(selector, options);
  }

  setDate(date) {
    this.selectedDate = date ? new Date(date) : new Date();
    this.date = this.selectedDate.getDate();
    this.weekDay = this.selectedDate.getDay();
    this.month = this.selectedDate.getMonth();
    this.year = this.selectedDate.getFullYear();
    this.firstDayInMonth = new Date(this.year, this.month, 1);
    this.lastDayInMonth = new Date(this.year, this.month + 1, 0);

    this.setCurrentMonth();
    this.setDaysMarkup();
  }

  selectDates(dates = {}) {
    this.selectedDates = [];
    if (!dates.from) {
      throw new Error('Add date from');
    }

    this.selectedDates[0] = dates.from;

    if (dates.to) {
      this.selectedDates[1] = dates.to;
    }

    this.setDatesInInputs();
    this.setDate(dates.from);
  }

  setEvents() {
    this.handleNext = this.handleNext.bind(this);
    this.handlePrev = this.handlePrev.bind(this);
    this.handleSelectDay = this.handleSelectDay.bind(this);

    this.nextMonthButton =
      this.calendarNode.querySelector('[data-type="next"]');
    this.prevMonthButton =
      this.calendarNode.querySelector('[data-type="prev"]');
    this.calendarBodyNode =
      this.calendarNode.querySelector('[data-type="body"]');

    this.nextMonthButton.addEventListener('click', this.handleNext);
    this.prevMonthButton.addEventListener('click', this.handlePrev);
    this.calendarBodyNode.addEventListener('click', this.handleSelectDay);
  }

  setCurrentMonth() {
    const monthNode = this.calendarNode.querySelector('[data-type="month"]');
    monthNode.textContent = this.months[this.month];
  }

  setCalendarHTML() {
    this.calendarNode.innerHTML = `
      <div class="wo-calendar ${
        this.options.theme !== 'dark' ? 'wo-calendar--light' : ''
      }" data-type="calendar">
        <div class="wo-calendar__header">
          <button class="wo-calendar__button" data-type="prev">←</button>
          <div class="wo-calendar__month" data-type="month"></div>
          <button class="wo-calendar__button wo-calendar__button--right" data-type="next">→</button>
        </div>
        <div class="wo-calendar__body" data-type="body"></div>
      </div>
    `;
  }

  setDaysMarkup() {
    const dates = [];
    const firstAvailableDay = new Date(
      this.today.getFullYear(),
      this.today.getMonth(),
      this.today.getDate()
    );
    let dayNumber = 1;
    let paddingDays =
      this.firstDayInMonth.getDay() - 1 < 0
        ? 6
        : this.firstDayInMonth.getDay() - 1;

    for (let i = 0; i < 42; i++) {
      if (i < paddingDays || i >= this.lastDayInMonth.getDate() + paddingDays) {
        dates.push('');
      } else {
        dates.push(new Date(this.year, this.month, dayNumber));
        dayNumber++;
      }
    }

    this.calendarNode.querySelector('[data-type="body"]').innerHTML = dates
      .map((date) => {
        if (date === '') {
          return '<div class="wo-day"></div>';
        } else {
          let dateString = formatDate(date);
          let classes = ['wo-day', 'day'];

          if (dateString === formatDate(this.today)) {
            classes.push('wo-day--today');
          }

          if (this.selectedDates.includes(dateString)) {
            classes.push('wo-day--selected');
          }
          return `<button type="button" class="${classes.join(
            ' '
          )}" data-date="${dateString}" ${
            date < firstAvailableDay ? 'disabled' : ''
          }>
            <div class="wo-day__label">${date.getDate()}</div>
          </button>`;
        }
      })
      .join('');
    this.options.selectDayCallback(this.selectedDates);
  }

  handleNext(event) {
    event.preventDefault();
    this.nextMonth();
  }

  handlePrev(event) {
    event.preventDefault();
    this.prevMonth();
  }

  handleSelectDay(event) {
    event.preventDefault();
    event.stopPropagation();
    if (!this.fromInput) {
      return;
    }
    const day = event.target.closest('.wo-day');

    if (!day || !day.dataset?.date || day.disabled) {
      return;
    }

    const maxSelectedDates = this.toInput ? 2 : 1;

    if (this.selectedDates.length >= maxSelectedDates) {
      this.selectedDates = [];
    }
    this.selectedDates.push(day.dataset.date);
    this.setDatesInInputs();
    this.setDaysMarkup();
  }

  formatSelectedDates() {
    const formattedSelectedDates = this.selectedDates.map(
      (dateString) => new Date(dateString)
    );
    const sortedFormattedDates = quickSort(formattedSelectedDates);
    if (sortedFormattedDates.length > 2) {
      sortedFormattedDates = [];
    }

    this.selectedDates = sortedFormattedDates.map((date) => formatDate(date));
  }

  setDatesInInputs() {
    this.formatSelectedDates();
    if (this.fromInput) {
      this.fromInput.value = this.selectedDates[0] || '';
    }

    if (this.toInput) {
      this.toInput.value = this.selectedDates[1] || '';
      // this.toInput.dispatchEvent(new Event('change'));
    }

    if (this.fromInput) {
      this.options.beforeDispatchEvent();
      this.fromInput.dispatchEvent(new Event('change', { bubbles: true }));
    }
  }

  nextMonth() {
    this.setDate(new Date(this.year, this.month + 1, 1));
  }

  prevMonth() {
    this.setDate(new Date(this.year, this.month - 1, 1));
  }

  reset() {
    this.selectedDates = [];
    if (this.fromInput.value !== '') {
      this.setDatesInInputs();
    }
    // if (this.fromInput) {
    //   this.fromInput.value = '';
    // }
    // if (this.toInput) {
    //   this.toInput.value = '';
    // }
    this.setDaysMarkup();
  }
}

class Calendar {
  constructor(container, options = {}) {
    this.containerNode =
      container instanceof HTMLElement
        ? container
        : document.querySelector(container);
    if (!this.containerNode) return;
    this.options = {
      dateInput: '#date',
      theme: 'dark',
      ...options,
    };
    this._months = [
      'January',
      'February',
      'March',
      'April',
      'May',
      'June',
      'July',
      'August',
      'September',
      'October',
      'November',
      'December',
    ];
    this._today = new Date();
    this._monthOffset = 0;
    this._chosenDate = this._today;

    this._setCalendarHTML();
    this._setDate();

    console.log(this);
  }

  _setDate() {
    this._settedDate = new Date();
    this._settedDate.setMonth(new Date().getMonth() + this._monthOffset);
    this._month = this._settedDate.getMonth();
    this._day = this._settedDate.getDate();
    this._weekday = this._settedDate.getDay();
    this._year = this._settedDate.getFullYear();
    this._numberOfDays = new Date(this._year, this._month + 1, 0).getDate();
    this._firstDay = new Date(this._year, this._month, 1).getDay();
    this._lastDay = new Date(this._year, this._month + 1, 0).getDay();

    this._setMonthHTML();
    this._setArrayOfDays();
    this._setDaysHTML();
  }

  _setCalendarHTML() {
    const classes = ['wo-calendar'];

    if (this.options.theme === 'light') {
      classes.push('wo-calendar--light');
    }

    const classesString = classes.join(' ');

    this.containerNode.innerHTML = `<div class="${classesString}" data-type="calendar">
      <div class="wo-calendar__header">
        <button class="wo-calendar__button" data-type="prev">←</button>
        <div class="wo-calendar__month" data-type="month"></div>
        <button class="wo-calendar__button wo-calendar__button--right" data-type="next">→</button>
      </div>
      <div class="wo-calendar__body" data-type="body"></div>
    </div>`;
  }

  _setArrayOfDays() {
    this._arrayOfDays = [];
    const cellsCount =
      this._firstDay + this._numberOfDays + (6 - this._lastDay);
    let dayNum = 1;

    for (let index = 1; index < cellsCount; index++) {
      if (index < this._firstDay) {
        this._arrayOfDays.push('');
        continue;
      }

      if (dayNum > this._numberOfDays) {
        break;
      }

      this._arrayOfDays.push(new Date(this._year, this._month, dayNum));
      dayNum++;
    }
  }

  _formatDate(date) {
    const formattedMonth =
      date.getMonth() + 1 < 10
        ? `0${date.getMonth() + 1}`
        : (date.getMonth() + 1).toString();
    const formattedDay =
      date.getDate() < 10 ? `0${date.getDate()}` : date.getDate().toString();
    return `${date.getFullYear()}.${formattedMonth}.${formattedDay}`;
  }

  _setDaysHTML() {
    this.calendarBodyNode =
      this.containerNode.querySelector('[data-type="body"]');
    this.calendarBodyNode.innerHTML = this._arrayOfDays
      .map((day) => {
        if (day) {
          const classes = ['wo-day'];

          if (this._formatDate(day) === this._formatDate(this._today)) {
            classes.push('wo-day--today');
          }

          if (this._formatDate(day) === this._formatDate(this._chosenDate)) {
            classes.push('wo-day--selected');
          }
          return `<div class="${classes.join(
            ' '
          )}"><div class="wo-day__label">${day.getDate()}</div></div>`;
        } else {
          return '<div class="wo-day"></div>';
        }
      })
      .join('');
  }

  _setMonthHTML() {
    this.monthNode = this.containerNode.querySelector('[data-type="month"]');
    this.monthNode.textContent = this._months[this._month];
  }
}

// new Calendar(document.getElementById('calendar'));

class BechCalendar {
  constructor(containerId = '', options = {}) {
    this.containerNode = document.getElementById(containerId);
    if (!this.containerNode) {
      return console.warn('There is no element to insert into');
    }
    this.options = {
      parentElement: 'form',
      onlyCurrentMonth: true,
      inputSelector: '#date',
      theme: 'dark',
      callback: () => {},
      ...options,
    };

    this._months = [
      'January',
      'February',
      'March',
      'April',
      'May',
      'June',
      'July',
      'August',
      'September',
      'October',
      'November',
      'December',
    ];
    this._today = new Date();
    this._num = 0;
    this._chosenDate = this._today;

    this.containerNode.innerHTML = this._getCalendarHTML();
    this._setDate();

    this.Prev = new Date(this._year, this._month - 1, 1);
    if (this._month == 0) {
      this.Prev = new Date(this._year - 1, 11, 1);
    }
    this.Prev.Days = new Date(
      this.Prev.getFullYear(),
      this.Prev.getMonth() + 1,
      0
    ).getDate();

    this.Next = new Date(this._year, this._month + 1, 1);
    if (this._month == 11) {
      this.Next = new Date(this._year + 1, 0, 1);
    }
    this.Next.Days = new Date(
      this.Next.getFullYear(),
      this.Next.getMonth() + 1,
      0
    ).getDate();

    this._handleButtonClick = this._handleButtonClick.bind(this);
    this._handleBodyClick = this._handleBodyClick.bind(this);
    this._setEvents();
  }

  get chosenDate() {
    return this._chosenDate;
  }

  set chosenDate(dateString) {
    const dateParts = dateString.split('.');
    this._chosenDate = new Date(
      Number(dateParts[0]),
      Number(dateParts[1][1]),
      Number(dateParts[2])
    );
  }

  _setEvents() {
    this.buttonNodes = this.containerNode.querySelectorAll(
      '[data-type="prev"], [data-type="next"]'
    );

    this.buttonNodes.forEach((button) => {
      button.addEventListener('click', this._handleButtonClick);
    });

    this.calendarBody.addEventListener('click', this._handleBodyClick);
  }

  _setDate() {
    this._selectedDate = new Date();
    this._selectedDate.setMonth(new Date().getMonth() + this._num);
    this._month = this._selectedDate.getMonth();
    this._day = this._selectedDate.getDate();
    this._weekday = this._selectedDate.getDay();
    this._year = this._selectedDate.getFullYear();
    this.Days = new Date(this._year, this._month + 1, 0).getDate();
    this.FirstDay = new Date(this._year, this._month, 1).getDay();
    this.LastDay = new Date(this._year, this._month + 1, 0).getDay();

    this._setArrayDays();
    this._setMonthHTML();
    this._setLabelsHTML();
  }

  _handleButtonClick(event) {
    event.preventDefault();
    event.stopPropagation();
    const button = event.target.closest('button');
    const { type } = button.dataset;

    type === 'prev' ? this.prev() : this.next();
    this._setDate();
  }

  _handleBodyClick(event) {
    event.preventDefault();
    const dayNode = event.target.closest('[data-date]');

    if (!dayNode) return;

    const { date } = dayNode.dataset;
    const dateInput = document.querySelector(this.options.inputSelector);
    const dateNodes = this.calendarBody.querySelectorAll('[data-date]');

    dateInput.value = date;
    this.chosenDate = date;

    this.options.callback();

    dateNodes.forEach((node) => node.classList.remove('wo-day--selected'));
    dayNode.classList.add('wo-day--selected');
    dateInput.dispatchEvent(new Event('change'));
  }

  next() {
    this._num += 1;
  }

  prev() {
    this._num -= 1;
  }

  _setArrayDays() {
    this.arrayOfDays = [];
    const cellsCount = this.FirstDay + this.Days + (6 - this.LastDay);
    let dayNum = 1;

    for (let index = 1; index < cellsCount; index++) {
      if (index < this.FirstDay) {
        this.arrayOfDays.push('');
        continue;
      }

      if (dayNum > this.Days) {
        if (this.options.onlyCurrentMonth) {
          break;
        }

        dayNum = 1;
      }

      this.arrayOfDays.push(new Date(this._year, this._month, dayNum));
      dayNum++;
    }
  }

  _getFormattedDate(date) {
    const formattedMonth =
      date.getMonth() + 1 < 10
        ? `0${date.getMonth() + 1}`
        : (date.getMonth() + 1).toString();
    const formattedDay =
      date.getDate() < 10 ? `0${date.getDate()}` : date.getDate().toString();
    return `${date.getFullYear()}.${formattedMonth}.${formattedDay}`;
  }

  _setMonthHTML() {
    const monthNode = this.containerNode.querySelector('[data-type="month"]');
    monthNode.innerHTML = this._months[this._month];
  }

  _getCalendarHTML() {
    const classes = [];
    classes.push('wo-calendar');

    if (this.options.theme === 'light') {
      classes.push('wo-calendar--light');
    }

    return `<${this.options.parentElement} class="${classes.join(
      ' '
    )}" data-type="calendar">
      <div class="wo-calendar__header">
        <button class="wo-calendar__button" data-type="prev">←</button>
        <div class="wo-calendar__month" data-type="month"></div>
        <button class="wo-calendar__button wo-calendar__button--right" data-type="next">→</button>
      </div>
      <div class="wo-calendar__body" data-type="body"></div>
    </${this.options.parentElement}>`;
  }

  _setLabelsHTML() {
    this.calendarBody = this.containerNode.querySelector('[data-type="body"]');
    this.calendarBody.innerHTML = this.arrayOfDays
      .map((day) =>
        day
          ? `<div 
            class="wo-day ${
              this._getFormattedDate(day) ===
              this._getFormattedDate(this._today)
                ? 'wo-day--today'
                : ''
            } ${
              this._getFormattedDate(day) ===
              this._getFormattedDate(this._chosenDate)
                ? 'wo-day--selected'
                : ''
            }"
              data-date="${this._getFormattedDate(day)}"
            >
            <div class="wo-day__label">${day.getDate()}</div>
      
    </div>`
          : '<div class="wo-day"></div>'
      )
      .join('');
  }

  reset() {
    this._num = 0;
    this._chosenDate = this._today;
    this._setDate();
  }
}

const calendarOnMainPage = WOCalendar.create('#calendar');

// new BechCalendar('calendar', {
//   parentElement: 'div',
//   onlyCurrentMonth: true,
// });

class UserCart {
  constructor(userData = {}) {
    this.cartButton = document.querySelector('.header-book-head-btn');
    this.cartContainerNode = document.querySelector('.cart-block_contant');
    this.mobileCloseButton = document.querySelector('.cart-block_mob-close');
    this._orders = userData.order?.items || [];
    this._user = userData?.user || {};
    this._profileUrl = userData?.profile || '#';
    this._logoutUrl = 'https://tickets.new.bechsteinhall.com/en/logout/';
    this._loginUrl = 'https://tickets.new.bechsteinhall.com/en/login/';
    this._checkoutUrl =
      'https://tickets.new.bechsteinhall.com/en/buyingflow/order/';
    this.expiresTime = Math.floor(userData.order?.expires);
    this.timerInterval = null;
    this.opened = false;
    this.handleClick = this.handleClick.bind(this);
    this._init();
  }

  open() {
    this.opened = true;
    document.body.classList.add('opencart');
  }

  close() {
    this.opened = false;
    document.body.classList.remove('opencart');
  }

  handleClick(event) {
    if (this._orders.length === 0) return;

    if (
      event.target.closest('.header-book-head-btn') ||
      event.target.closest('.cart-block')
    ) {
      event.preventDefault();
    }

    if (event.target.closest('.header-book-head-btn')) {
      this.opened ? this.close() : this.open();
      return;
    }

    if (event.target.closest('.cart-block')) {
      event.stopPropagation();
      if (event.target.closest('.header-book-head-btn-chk')) {
        window.location.href = event.target
          .closest('.header-book-head-btn-chk')
          .getAttribute('href');
      }

      if (event.target.closest('.cart-block_mob-close')) {
        this.close();
      }

      return;
    }

    this.close();
  }

  formatTime(time) {
    const minutes =
      Math.floor(time / 60) < 10
        ? `0${Math.floor(time / 60)}`
        : `${Math.floor(time / 60)}`;
    const seconds =
      Math.floor(time % 60) < 10
        ? `0${Math.floor(time % 60)}`
        : `${Math.floor(time % 60)}`;
    return `${minutes}:${seconds}`;
  }

  setExpiresTime() {
    if (this.expiresTime === 0) {
      document.body.classList.remove('opencart');
      clearInterval(this.timerInterval);
      this.setData({
        user: this._user,
        profile: this._profileUrl,
      });
      return;
    }

    if (!this.expiresTime) {
      document.body.classList.remove('opencart');
      clearInterval(this.timerInterval);
      this.setData({
        user: this._user,
        profile: this._profileUrl,
      });
      return;
    }
    this.expiresTime -= 1;
    const timerNode = this.cartContainerNode.querySelector(
      '[data-cart="timer"]'
    );

    timerNode.textContent = this.formatTime(this.expiresTime);
  }

  setData(data = {}) {
    this._orders = data?.order?.items || [];
    this._user = data?.user || null;
    this._profileUrl = data?.profile || '#';
    clearInterval(this.timerInterval);
    this.timerInterval = null;
    this.expiresTime = Math.floor(data?.order?.expires);
    this._setMarkup();
    this._setTicketsCount();
  }

  _setTicketsCount() {
    if (this._orders.length > 0) {
      const ticketSting = this._orders.length % 10 !== 1 ? 'tickets' : 'ticket';
      this.cartButton.querySelector('div').textContent =
        this._orders.length + ' ' + ticketSting;
    } else {
      this.cartButton.querySelector('div').textContent = 'Book tickets';
    }
  }

  _setMarkup() {
    let markup = '';
    this.setExpiresTime = this.setExpiresTime.bind(this);
    if (this._orders.length >= 1) {
      const links = this._user
        ? `<div id="user-actions">
            <a href="${this._profileUrl}" class="p-17-25 card-block-a">View your account</a>
            <a href="${this._logoutUrl}" class="p-17-25 card-block-a">Log out</a>
         </div>`
        : `<div id="user-actions">
             <a href="${this._loginUrl}" class="p-17-25 card-block-a">Log in</a>
          </div>`;

      const userNameHTML = this._user
        ? `<div id="user-name">
              <div class="p-20-30 cart-block_top">${this._user.name}</div>
              <div class="cart-block_divider"></div>
          </div>`
        : '';

      const userCartHTML =
        this._orders.length > 0
          ? `<div id="user-basket">
              <div class="p-17-25 card-block-txt">Your basket contains</div>
              <div class="p-20-30 cart-block-text">${
                this._orders.length
              } tickets</div>
              <div class="p-17-25 card-block-txt">for a total amount of</div>
              <div class="p-20-30">£ ${this._orders.reduce(
                (partialSum, item) => partialSum + item.price,
                0
              )}</div>
              <a bgline="1" href="${
                this._checkoutUrl
              }" class="header-book-head-btn-chk w-inline-block">
                  <div>checkout</div>
              </a>
              <div class="p-17-25 card-block-txt"><span data-cart="timer">${this.formatTime(
                this.expiresTime
              )}</span>&nbsp;left to purchase</div>
              <div class="cart-block_divider"></div>
          </div>`
          : '';

      markup = userNameHTML + userCartHTML + links;
      this.timerInterval = setInterval(this.setExpiresTime, 1000);
    }

    this.cartContainerNode.innerHTML = markup;
  }

  _init() {
    this._setMarkup();
    this._setTicketsCount();

    // this.handleClick = this.handleClick.bind(this);
    document.body.addEventListener('click', this.handleClick);
    // this.cartButton.addEventListener('click', this.handleClick);
  }
}

window.tixCart = new UserCart();

class WhatsOnSlider {
  constructor(data = []) {
    this._data = data;
    this.sliderContainerNode = document.querySelector('.wo-slider');

    if (!this.sliderContainerNode) {
      return;
    }

    this.sliderContainerNode.innerHTML = this._getMarkup();
    this.slideNodes = this.sliderContainerNode.querySelectorAll('.wo-slide');
    this._slideSize = this.slideNodes[0].getBoundingClientRect();
    this.prevButtonNode = document.querySelector('[data-button="prev"]');
    this.nextButtonNode = document.querySelector('[data-button="next"]');
    this._currentIndex = 0;
    this.wasDragging = false;

    this.pageScrolling = false;
    this.slideScrolling = false;

    this.freeCardsCount;
    this.resize();

    // console.log(this.freeCardsCount);

    // this.setSlidesPosition();
    this.sliderContainerNode.classList.add('wo-slider--ready');

    this.handleScroll = this.handleScroll.bind(this);
    this.handleUp = this.handleUp.bind(this);
    this.handleClick = this.handleClick.bind(this);
    this.resize = this.resize.bind(this);

    this.sliderContainerNode.addEventListener(
      'mousedown',
      this.handleDown.bind(this)
    );
    this.sliderContainerNode.addEventListener(
      'touchstart',
      this.handleDown.bind(this)
    );
    this.sliderContainerNode.addEventListener('click', this.handleClick);
    this.sliderContainerNode.addEventListener('mouseleave', this.handleUp);
    document.addEventListener('mouseup', this.handleUp);
    document.addEventListener('touchend', this.handleUp);
    window.addEventListener('resize', debounce(this.resize, 100));
    // document.addEventListener('pointercancel', this.handleUp);
    this.nextButtonNode?.addEventListener('click', this.next.bind(this));
    this.prevButtonNode?.addEventListener('click', this.prev.bind(this));
  }

  get currentIndex() {
    return this._currentIndex;
  }

  set currentIndex(val) {
    switch (true) {
      case val < 0:
        val = 0;
        break;
      case val >= this._data.length - this.freeCardsCount:
        val = this._data.length - this.freeCardsCount;
        break;
    }

    this._currentIndex = val;
    return this._currentIndex;
  }

  _getMarkup() {
    return this._data
      .map((item) => {
        if (item instanceof HTMLDivElement) {
          return item.outerHTML;
        } else {
          return `<div class="wo-slider_item wo-slide">${item.id}</div>`;
        }
      })
      .join('');
  }

  resize() {
    switch (true) {
      case window.innerWidth > 479 && window.innerWidth <= 991:
        this.freeCardsCount = 2;
        break;
      case window.innerWidth <= 479:
        this.freeCardsCount = 1;
        break;
      default:
        this.freeCardsCount = 2;
        break;
    }

    this.setSlidesPosition();
  }

  handleClick(event) {
    if (this.wasDragging) {
      event.preventDefault();
      this.wasDragging = false;
    }
  }

  handleScroll(event) {
    if (this.pageScrolling) return;

    if (this.slideScrolling) {
      event.preventDefault();
    }

    const dragY = event.clientY || event.touches[0].clientY;
    const dragX = event.clientX || event.touches[0].clientX;
    const dragShiftX = dragX - this.x;
    const dragShiftY = dragY - this.y;
    const x = dragShiftX / this._slideSize.width;
    this.wasDragging = true;

    if (Math.abs(dragShiftY) > 5 && !this.slideScrolling) {
      this.pageScrolling = true;
    } else if (Math.abs(dragShiftX) > 5) {
      event.preventDefault();
      this.slideScrolling = true;
    }

    console.log('скроллится ' + this.pageScrolling ? 'страница' : 'слайдер');

    // console.log('dragshiftX', dragShiftX);
    // console.log('dragshiftY', dragShiftY);

    this.sliderContainerNode.removeEventListener('click', this.handleClick);
    // if (Math.abs(dragShift) < 10) return;
    this.dragging(x);
  }

  handleDown(event) {
    this.startIndex = this.currentIndex;
    this.x = event.clientX || event.touches[0].clientX;
    this.y = event.clientY || event.touches[0].clientY;

    // console.log('start', this.y);
    this.sliderContainerNode.addEventListener('mousemove', this.handleScroll);
    this.sliderContainerNode.addEventListener('touchmove', this.handleScroll);
    this.sliderContainerNode.classList.add('wo-slider--dragging');
  }

  handleUp(event) {
    this.pageScrolling = false;
    this.slideScrolling = false;
    document.body.classList.remove('whats-on-dragging');
    this.sliderContainerNode.classList.remove('wo-slider--dragging');
    this.sliderContainerNode.removeEventListener(
      'mousemove',
      this.handleScroll
    );
    this.sliderContainerNode.removeEventListener(
      'touchmove',
      this.handleScroll
    );

    this.currentIndex = Math.round(this.currentIndex);
    this.setSlidesPosition();
    this.sliderContainerNode.addEventListener('click', this.handleClick);
  }

  dragging(x) {
    this.currentIndex = this.startIndex - x;
    this.setSlidesPosition();
  }

  next() {
    this.currentIndex = this.currentIndex + 1;
    this.setSlidesPosition();
  }

  prev() {
    this.currentIndex = this.currentIndex - 1;
    this.setSlidesPosition();
  }

  setSlidesPosition() {
    this.firstSlides = [];
    this.deckSlides = [];

    this.slideNodes.forEach((slide, index) => {
      if (index >= Math.ceil(this._currentIndex)) {
        this.firstSlides.push(slide);
      } else {
        this.deckSlides.unshift(slide);
      }
    });

    const diff = this.currentIndex - Math.ceil(this.currentIndex);

    this.firstSlides.forEach((slide, index) => {
      this.setSlideStyles(slide, {
        transform: `translate3d(${
          this._slideSize.width * (index - diff)
        }px, 0, 0)`,
        zIndex: '',
        opacity: '',
        pointerEvents: '',
      });
    });

    this.deckSlides.forEach((slide, index) => {
      if (index < 2) {
        this.setSlideStyles(slide, {
          pointerEvents: 'none',
          opacity: '',
          transform: `translate3d(-${
            this._slideSize.width * 0.05 * (index + 1 + diff)
          }px, 0, 0) scale(${1 - 0.05 * (index + 1 + diff)})`,
        });
      } else {
        this.setSlideStyles(slide, {
          zIndex: -(index + 1),
        });
      }
    });
  }

  setSlideStyles(slide, properties = {}) {
    for (const property in properties) {
      if (Object.hasOwnProperty.call(properties, property)) {
        const value = properties[property];
        slide.style[property] = value;
      }
    }
  }

  reset(data) {
    this.currentIndex = 0;
    this._data = data ? data : this._data;
    this.sliderContainerNode.innerHTML = this._getMarkup();
    this.slideNodes = this.sliderContainerNode.querySelectorAll('.wo-slide');
    console.log(this.slideNodes);
    this._slideSize = this.slideNodes[0].getBoundingClientRect();
    this.setSlidesPosition();
    this.sliderContainerNode.classList.add('wo-slider--ready');
  }
}

function debounce(callback, delay) {
  let timer;
  return function (...args) {
    clearTimeout(timer);
    timer = setTimeout(() => {
      callback.apply(this, args);
    }, delay);
  };
}

/**
 * <svg width="24" height="25" viewBox="0 0 24 25" fill="none">
        <rect x="0.5" y="1" width="23" height="23" rx="1.5" stroke="#030E14"></rect><rect x="1" y="1.5" width="22" height="6" fill="#030E14"></rect>
        <path d="M9.24651 19.2793C10.9841 19.2793 12.1501 18.2619 12.1501 16.8215C12.1501 15.4726 11.087 14.5467 9.50943 14.5467C9.18935 14.5467 8.89213 14.5924 8.64064 14.661C10.0238 13.9294 11.4871 13.255 11.4871 12.0775C11.4871 11.1859 10.7554 10.5 9.6809 10.5C8.80068 10.5 6.45725 11.4602 6.45725 12.4776C6.45725 12.832 6.69731 13.0721 7.02882 13.0721C7.90904 13.0721 7.47464 11.7117 8.10337 11.1973C8.332 11.003 8.58349 10.9458 8.84641 10.9458C9.52086 10.9458 10.0353 11.5174 10.0353 12.2604C10.0353 13.2778 9.31509 14.1237 7.77186 15.004C8.18339 14.9125 8.49204 14.8668 8.78925 14.8668C9.90952 14.8668 10.664 15.667 10.664 16.7987C10.664 18.079 9.88666 18.9135 8.75496 18.9135C8.37772 18.9135 8.00049 18.8335 7.77186 18.6963C7.12027 18.319 7.50894 16.7301 6.583 16.7301C6.24006 16.7301 6 16.9816 6 17.3474C6 18.2276 8.08051 19.2793 9.24651 19.2793Z" fill="#030E14"></path>
        <path d="M13.3763 19.1421H17L15.9255 18.5134V10.5L13.0676 11.4831L14.4965 11.9289V18.5134L13.3763 19.1421Z" fill="#030E14"></path>
      </svg>
 */

const getTickets = async (filters) => {
  const formData = filters instanceof FormData ? filters : new FormData();

  if (!filters instanceof FormData) {
    for (const property in filters) {
      if (Object.hasOwnProperty.call(filters, property)) {
        const value = filters[property];
        formData.set(property, value);
      }
    }
  }

  try {
    const response = await (
      await fetch(bech_var.url, {
        method: 'POST',
        body: formData,
      })
    ).json();

    console.log(response);

    if (response.status !== 'success') {
      throw new Error(data.message);
    }

    return response;
  } catch (e) {
    return {
      status: 'bad',
      message: e.message,
    };
  }
};

class CalendarWidget {
  constructor(containerId = '') {
    this.containerNode = document.getElementById(containerId);
    if (!this.containerNode) return;
    this.setHTML();
    this.widget = this.containerNode.querySelector(
      '[data-type="calendar_widget"]'
    );
    this.selectedDatesNode = this.widget.querySelector(
      '[data-type="selected_dates"]'
    );
    this.calendarContainerNode = this.widget.querySelector(
      '[data-type="calendar"]'
    );
    this.calendar = WOCalendar.create('[data-type="calendar"]', {
      theme: 'light',
      beforeDispatchEvent: () => {
        const inputsWithNameTime = this.calendarContainerNode
          .closest('form')
          .querySelectorAll('input[name="time"]');

        inputsWithNameTime.forEach((input) => {
          input.removeAttribute('checked');
          input.checked = false;
        });
      },
      selectDayCallback: (dates = []) => {
        let datesString;
        if (dates.length !== 0) {
          datesString = dates
            .map((date) => {
              return this.formatDate(new Date(date));
            })
            .join('—');
          this.widget.classList.add('calendar-btn--selected');
        } else {
          datesString = 'Calendar';
        }
        this.selectedDatesNode.textContent = datesString;
      },
    });

    this.setEvents();
  }

  setHTML() {
    this.containerNode.innerHTML = `
    <div class="calendar-btn w-inline-block playicosvg" data-type="calendar_widget">
      <img src="https://uploads-ssl.webflow.com/62bc3fe7d9cc6134bf261592/62bc3fe7d9cc6162b22615c0_calendar.svg" loading="lazy" alt="" class="img-calendar">
      <span data-type="selected_dates">Calendar</span>
      <button type="button" class="calendar-btn__reset" data-type="reset">✕</button>
      <div class="calendar-btn__close">Close</div>
      <div class="filter-calendar" data-type="calendar"></div>
    </div>`;
  }

  handleToggle(event) {
    if (!event.target.closest('[data-type="calendar_widget"]')) {
      return this.widget.classList.remove('calendar-btn--active');
    }

    if (event.target.closest('[data-type="calendar"]')) {
      return event.stopPropagation();
    }

    if (event.target.closest('[data-type="reset"]')) {
      return this.reset();
    }

    this.widget.classList.toggle(
      'calendar-btn--active',
      !this.widget.classList.contains('calendar-btn--active')
    );
  }

  setEvents() {
    this.handleToggle = this.handleToggle.bind(this);
    document.addEventListener('click', this.handleToggle);
  }

  formatDate(date = new Date()) {
    const abbrMonths = [
      'Jan',
      'Feb',
      'Mar',
      'Apr',
      'May',
      'June',
      'July',
      'Aug',
      'Sept',
      'Oct',
      'Nov',
      'Dec',
    ];
    const day = date.getDate();
    const month = date.getMonth();

    return `${day} ${abbrMonths[month]}`;
  }

  reset() {
    this.widget.classList.remove('calendar-btn--selected');
    this.selectedDatesNode.textContent = 'Calendar';
    this.calendar.reset();
  }
}

class VideoPlayer {
  constructor(playerNode) {
    this.playerNode = playerNode;
    if (!this.playerNode) {
      console.error('Player node is not defined');
      return;
    }
    this._video = this.playerNode.querySelector('video');
    this._soundButton = this.playerNode.querySelector('[data-type="sound"]');
    this._playButton = this.playerNode.querySelector('[data-type="play"]');
    this._progressBar = this.playerNode.querySelector(
      '[data-type="progress-bar"]'
    );
    this._progressLine = this.playerNode.querySelector(
      '[data-type="progress-line"]'
    );
    this._timeCounter = this.playerNode.querySelector(
      '[data-type="time-counter"]'
    );
    this.handleMute();

    this.handleMute = this.handleMute.bind(this);
    this.handlePlay = this.handlePlay.bind(this);
    this.handleProgress = this.handleProgress.bind(this);
    this.handlePointerDown = this.handlePointerDown.bind(this);
    this.handleProgressHover = this.handleProgressHover.bind(this);
    this.handleProgressUnHover = this.handleProgressUnHover.bind(this);

    this.handleMute();
    this.play();

    this._soundButton.addEventListener('click', this.handleMute);
    this._playButton?.addEventListener('click', this.handlePlay);
    this._video.addEventListener('timeupdate', this.handleProgress);
    this._progressBar.addEventListener('pointerover', this.handleProgressHover);
    this._progressBar.addEventListener(
      'pointerout',
      this.handleProgressUnHover
    );
    this._progressBar.addEventListener('pointerdown', this.handlePointerDown);
  }

  handleMute(event) {
    this._video.muted ? this.unmute() : this.mute();
    this._soundButton.textContent = this._video.muted ? 'unmute' : 'mute';
  }

  handlePlay(event) {
    this._video.paused ? this.play() : this.pause();
  }

  handleProgress(event) {
    const percent = (this._video.currentTime / this._video.duration) * 100;
    const timeLeft = this._video.duration - this._video.currentTime;

    this._progressLine.style.width = `${percent}%`;
    this._timeCounter.textContent = this.formatTime(timeLeft);
  }

  handleProgressHover(event) {
    this._progressBar.classList.add('progress--hover');
  }

  handleProgressUnHover(event) {
    this._progressBar.classList.remove('progress--hover');
  }

  handlePointerDown(event) {
    const progressBarRect = this._progressBar.getBoundingClientRect();
    const xCoord = event.clientX - progressBarRect.left;
    const progressBarWidth = progressBarRect.width;
    const progressBersent = (xCoord / progressBarWidth) * 100;

    this._video.currentTime = (this._video.duration * progressBersent) / 100;
  }

  formatTime(time) {
    const minutes =
      Math.floor(time / 60) < 10
        ? `0${Math.floor(time / 60)}`
        : `${Math.floor(time / 60)}`;
    const seconds =
      Math.floor(time % 60) < 10
        ? `0${Math.floor(time % 60)}`
        : `${Math.floor(time % 60)}`;
    return `${minutes}:${seconds}`;
  }

  replay() {
    this._video.currentTime = 0;
    this.play();
  }

  play() {
    this._video.play();
  }

  pause() {
    this._video.pause();
  }

  mute() {
    this._video.muted = true;
  }

  unmute() {
    this._video.muted = false;
  }
}

class SkipVideoPlayer extends VideoPlayer {
  constructor(playerNode, skipCallback) {
    super(playerNode);
    this._callback = skipCallback;
    this._skipButton = this.playerNode.querySelector(
      '[data-type="skip-button"]'
    );

    this.handleSkip = this.handleSkip.bind(this);
    this._skipButton.addEventListener('click', this.handleSkip);
  }

  handleSkip(event) {
    this.skip();
  }

  skip() {
    this._video.pause();
    this._callback();
  }
}

class BechCarouser {
  constructor(sliderNode, options) {
    this.sliderNode = sliderNode;
    if (!this.sliderNode) return;
    this.options = {
      duration: 5000,
      changingDuration: 600,
      ...options,
    };
    this._currentIndex = 0;
    this.slidesArray = Array.from(
      this.sliderNode.querySelectorAll('[data-type="slide"]')
    );
    this.prevButton = this.sliderNode.querySelector('[data-type="prev"]');
    this.nextButton = this.sliderNode.querySelector('[data-type="next"]');
    this.slidesCurrentNumberNode = this.sliderNode.querySelector(
      '[data-type="current"]'
    );
    this.slidesCountNode = this.sliderNode.querySelector('[data-type="count"]');
    this.cursor = this.sliderNode.querySelector('[data-type="cursor"]');

    this.handleButtonClick = this.handleButtonClick.bind(this);
    this.hoverCallback = this.hoverCallback.bind(this);
    this.unhoverCallback = this.unhoverCallback.bind(this);
    this.mouseMoveCallback = this.mouseMoveCallback.bind(this);
    this.buttonMouseLeave = this.buttonMouseLeave.bind(this);
    this.buttonMouseOver = this.buttonMouseOver.bind(this);

    this.prevButton.addEventListener('click', this.handleButtonClick);
    this.prevButton.addEventListener('mouseover', this.buttonMouseOver);
    this.prevButton.addEventListener('mouseleave', this.buttonMouseLeave);

    this.nextButton.addEventListener('click', this.handleButtonClick);
    this.nextButton.addEventListener('mouseover', this.buttonMouseOver);
    this.nextButton.addEventListener('mouseleave', this.buttonMouseLeave);

    this.sliderNode.addEventListener('mouseover', this.hoverCallback);
    this.sliderNode.addEventListener('mouseleave', this.unhoverCallback);
    this.sliderNode.addEventListener('mousemove', this.mouseMoveCallback);

    this.slidesCountNode.innerText = this.slidesArray.length;

    this.setCurrentSlideNumber();
    this.setSlidesStyles();
    this.initDuration();
  }

  get currentIndex() {
    return this._currentIndex;
  }

  set currentIndex(num) {
    let number = parseInt(num);
    switch (true) {
      case number < 0:
        this._currentIndex = this.slidesArray.length - 1;
        break;
      case number >= this.slidesArray.length:
        this._currentIndex = 0;
        break;
      default:
        this._currentIndex = number;
        break;
    }

    return this._currentIndex;
  }

  setSlidesStyles() {
    this.slidesArray.forEach((slide, index) => {
      if (index === this.currentIndex) {
        slide.classList.add('bech-slider__slide--active');
        animate(slide, { opacity: 1 }, this.options.changingDuration);
      } else {
        slide.classList.remove('bech-slider__slide--active');
        animate(slide, { opacity: 0 }, this.options.changingDuration);
      }
    });
  }

  initDuration() {
    if (this.options.duration < 1000) {
      this.options.duration = 1000;
    }

    clearInterval(this.interval);
    cancelAnimationFrame(this.animation);

    this.animation = animate(
      this.nextButton.querySelector('.arrow-button__progress'),
      { strokeDashoffset: 0 },
      this.options.duration
    );

    this.interval = setInterval(() => {
      this.nextButton.querySelector(
        '.arrow-button__progress'
      ).style.strokeDashoffset = Math.PI * (24 * 2);
      this.next();
      this.animation = animate(
        this.nextButton.querySelector('.arrow-button__progress'),
        { strokeDashoffset: 0 },
        this.options.duration
      );
    }, this.options.duration);
  }

  hoverCallback(event) {
    clearInterval(this.interval);
    cancelAnimationFrame(this.animation);
  }

  unhoverCallback(event) {
    this.initDuration();
  }

  mouseMoveCallback(event) {
    const targetCoords = this.sliderNode.getBoundingClientRect();
    const xCoord =
      event.clientX - targetCoords.left + this.cursor.clientWidth / 2;
    const yCoord =
      event.clientY - targetCoords.top + this.cursor.clientHeight / 2;

    this.cursor.style.transform = `translate3d(${xCoord}px, ${yCoord}px, 0)`;
  }

  buttonMouseLeave() {
    this.cursor.classList.remove('hidden');
  }

  buttonMouseOver() {
    this.cursor.classList.add('hidden');
  }

  handleButtonClick(event) {
    event.preventDefault();
    event.stopPropagation();
    const button = event.target.closest('button');
    if (!button) return;
    const { type } = button.dataset;

    type === 'prev' ? this.prev() : this.next();
    this.initDuration();
  }

  setCurrentSlideNumber() {
    this.slidesCurrentNumberNode.innerText = this.currentIndex + 1;
  }

  prev() {
    this.currentIndex = this.currentIndex - 1;
    this.setCurrentSlideNumber();
    this.setSlidesStyles();
  }

  next() {
    this.currentIndex = this.currentIndex + 1;
    this.setCurrentSlideNumber();
    this.setSlidesStyles();
  }
}

new BechCarouser(document.querySelector('[data-type="slider"]'), {
  duration: 5000,
});

function initSplideCarousel() {
  const splideCarouselContainer = document.querySelector('.splide');

  if (!splideCarouselContainer) return;
  // const customCursor = splideCarouselContainer.querySelector('.splide__cursor');
  // const mouseOverCallback = event => {
  //   customCursor.classList.add('splide__cursor--loading');
  //   setTimeout(() => customCursor.classList.remove('splide__cursor--loading'), 200);
  // }
  // const mouseLeaveCallback = event => {
  //   customCursor.classList.add('splide__cursor--loading');
  //   customCursor.style.transform = 'scale(0)';
  //   setTimeout(() => customCursor.classList.remove('splide__cursor--loading'), 200);
  // }
  // const mouseMoveCallback = event => {
  //   const target = event.target.closest('.splide'); // Здесь что-то уникальное, что может указать на род. блок
  //   const targetCoords = target.getBoundingClientRect();
  //   const xCoord = (event.clientX - targetCoords.left) - (customCursor.clientWidth / 2);
  //   const yCoord = (event.clientY - targetCoords.top) - (customCursor.clientHeight / 2);
  //
  //   customCursor.style.transform = `scale(1) translate3d(${xCoord}px, ${yCoord}px, 0)`;
  // }

  // splideCarouselContainer.addEventListener('mouseenter', mouseOverCallback)
  // splideCarouselContainer.addEventListener('mouseleave', mouseLeaveCallback)
  // splideCarouselContainer.addEventListener('mousemove', mouseMoveCallback)

  new Splide('.splide', {
    perPage: 1,
    perMove: 1,
    focus: 'center',
    type: 'loop',
    gap: '20px',
    breakpoints: {
      991: {
        perPage: 1,
        focus: 'left',
      },
      479: {
        perPage: 1,
        focus: 'left',
      },
    },
  }).mount();

  new CustomCursor('splide-cursor', '.section.home-white.wf-section');
}

const initLoader = () => {
  const loaderNode = document.querySelector('.loader');

  if (!loaderNode || loaderNode.dataset.show === 'false') {
    window.localStorage.removeItem('loader');
    // return;
  }

  const loaderData = JSON.parse(window.localStorage.getItem('loader'));
  const skipCallback = async () => {
    const data = {
      skipped: true,
      date: Date.now() + 1000 * 60 * 60 * 24,
    };
    window.localStorage.setItem('loader', JSON.stringify(data));
    await $(loaderNode).animate({ opacity: 0 }, 500).promise();
    setTimeout(() => {
      loaderNode.classList.remove('loader--active');
      document.body.classList.remove('body--freeze');
    }, 200);
  };
  const openPlayerButton = document.querySelector(
    '[data-button="open-player"]'
  );
  const player = new SkipVideoPlayer(
    loaderNode.querySelector('[data-type="video-player"]'),
    skipCallback
  );
  player.pause();
  const openVideoPlayer = async (event) => {
    event?.preventDefault();
    loaderNode.classList.add('loader--active');
    document.body.classList.add('body--freeze');
    await $(loaderNode).animate({ opacity: 1 }, 400).promise();
    player.replay();
  };

  if (
    (!loaderData || loaderData.date <= Date.now()) &&
    loaderNode.dataset.show === 'true'
  ) {
    openVideoPlayer();
  } else {
    console.log('hide loader');
  }

  if (openPlayerButton) {
    openPlayerButton.addEventListener('click', openVideoPlayer);
  }

};

const initWhatsOnFilters = () => {
  const calendarWidget = new CalendarWidget('calendar-widget');
  const filterFormNode = document.querySelector('[data-filter="form"]');
  const ticketsContainer = document.getElementById('tickets-container');
  if (!filterFormNode && !ticketsContainer) return;
  const filterInputs = Array.from(filterFormNode.querySelectorAll('input'));
  const searchInput = filterInputs.find((input) => input.type === 'search');
  const clearFiltersButton = document.getElementById('clear');
  const showSelectedFilters = (selectedString = '') => {
    const selectedBlock = document.getElementById('selected-filters');
    const selectedTextBlock = selectedBlock?.querySelector(
      '[data-filter="choosen"]'
    );

    selectedBlock.classList.toggle(
      'filters-line-text--active',
      !!selectedString
    );
    selectedTextBlock.textContent = selectedString;
  };

  const changeInputHandler = async (event) => {
    const target = event?.target;
    if (target?.getAttribute('name') === 'time') {
      filterInputs.find(
        (input) => input.getAttribute('name') === 'from'
      ).value = '';
      calendarWidget.reset();
    }
    const formData = new FormData(filterFormNode);
    const response = await getTickets(formData);

    console.log(response);

    if (response.status !== 'success') {
      window.alert(`Error: ${response.message}`);
    }

    // const ticketsHTML = response.data.html;
    // const selectedString = response?.data?.selected_string;

    // showSelectedFilters(selectedString);
    // ticketsContainer.innerHTML = ticketsHTML;
  };

  const clearFilters = (event) => {
    event?.preventDefault();
    filterFormNode.reset();
    calendarWidget.reset();
    filterInputs.forEach((filterInput) => {
      if (filterInput.type === 'hidden') return;

      if (filterInput.type === 'checkbox' || filterInput.type === 'radio') {
        filterInput.removeAttribute('checked');
        filterInput.checked = false;
      } else {
        filterInput.value = '';
      }
    });
    changeInputHandler();
  };

  const searchInputMiddleware = (callback) => {
    let inputValue = '';
    return function (...args) {
      if (inputValue !== args[0].target.value) {
        inputValue = args[0].target.value;
        return callback.apply(this, args);
      } else {
        return;
      }
    };
  };

  // filterInputs.forEach((filterInput) => {
  //   if (filterInput.type === 'search') {
  //     filterInput.addEventListener(
  //       'change',
  //       searchInputMiddleware(changeInputHandler)
  //     );
  //   } else {
  //     filterInput.addEventListener('change', changeInputHandler);
  //   }
  // });

  // searchInput.addEventListener(
  //   'input',
  //   debounce((event) => {
  //     event.target.dispatchEvent(new Event('change', { bubbles: true }));
  //   }, 500)
  // );

  clearFiltersButton.addEventListener('click', clearFilters);

  filterFormNode.addEventListener('submit', async (event) => {
    event.preventDefault();
    const formData = new FormData(filterFormNode);
    const response = await getTickets(formData);
    const ticketsHTML = response.html;
    const selectedString = response?.selected_string;

    showSelectedFilters(selectedString);
    ticketsContainer.innerHTML = ticketsHTML;
  });

  filterFormNode.addEventListener('change', changeInputHandler);
};

// initWhatsOnFilters();

function initWhatsOnFilters3() {
  let hasSelectedFilters = false;
  const filterForm = document.querySelector('[data-filter="form"]');

  if (!filterForm) return;

  const calendarWidget = new CalendarWidget('calendar-widget');
  const filters = Array.from(
    filterForm.querySelectorAll(
      'input:not([type="hidden"]):not([type="submit"])'
    )
  );
  const timeFilters = filters.filter((filter) => filter.name === 'time');
  const pageNumberInput = filterForm.querySelector('[name="paged"]');
  const clearFiltersButton = document.getElementById('clear');
  const clearPopupButtons = document.querySelectorAll(
    '.mobile-filter-popup__clear'
  );
  const showEventsPopupButtons = document.querySelectorAll(
    '.mobile-filter-popup__button'
  );
  const loadMoreTriggerNode = document.querySelector('[data-type="load_more"]');

  timeFilters.forEach((timeFilter) => {
    const label = timeFilter.nextElementSibling;

    label.addEventListener('click', (event) => {
      console.log(timeFilter.checked);
      if (timeFilter.checked) {
        event.preventDefault();
        timeFilter.removeAttribute('checked');
        timeFilter.checked = false;
        filterForm.dispatchEvent(new Event('change'));
      }
    });
  });

  async function submitFormCallback(event) {
    event?.preventDefault();

    const formData = new FormData(filterForm);

    if (
      formData.get('s') ||
      formData.get('from') ||
      formData.get('to') ||
      formData.get('genres[]') ||
      formData.get('instruments[]') ||
      formData.get('event_tag[]') ||
      formData.get('festival[]') ||
      formData.get('time')
    ) {
      hasSelectedFilters = true;
      console.log('has selected true');
    } else {
      console.log('has selected false');
      hasSelectedFilters = false;
    }

    if (Number(pageNumberInput.value) <= 1) {
      window.scrollTo({
        top: 0,
        behavior: 'smooth',
      });
    }

    try {
      const response = await getTickets(formData);

      if (response.status !== 'success') {
        throw new Error(response.message);
      }

      console.log(response);

      const ticketsContainer = document.querySelector('.cms-tems');
      const ticketsHTML = response.data.html;

      if (Number(pageNumberInput.value) > 1) {
        ticketsContainer.insertAdjacentHTML('beforeend', ticketsHTML);
      } else {
        ticketsContainer.innerHTML = ticketsHTML;
      }

      showEventsPopupButtons.forEach(
        (button) =>
          (button.querySelector(
            'strong'
          ).textContent = `Show ${response.data.posts_count} events`)
      );
      showSelectedFilters(response.data.selected_string);
      if (hasSelectedFilters) {
        showPopupShowEventsButtons();
      }
      loadMoreTriggerNode.setAttribute(
        'data-max-pages',
        response.data.max_pages
      );
    } catch (e) {
      window.alert(e.message);
    }
  }
  const clearFilters = (event) => {
    event?.preventDefault();
    filterForm.reset();
    calendarWidget.reset();
    filters.forEach((filter) => {
      if (filter.type === 'checkbox' || filter.type === 'radio') {
        filter.removeAttribute('checked');
        filter.checked = false;
      } else {
        filter.value = '';
      }
    });

    pageNumberInput.value = 1;
    hidePopupButtons();
    submitFormCallback();

    //close mobile filter popup
  };
  const showSelectedFilters = (selectedString = '') => {
    const selectedBlock = document.getElementById('selected-filters');
    const selectedTextBlock = selectedBlock?.querySelector(
      '[data-filter="choosen"]'
    );

    selectedBlock.classList.toggle(
      'filters-line-text--active',
      !!selectedString
    );
    selectedTextBlock.textContent = selectedString;
  };
  const changeInputsHandler = (event) => {
    pageNumberInput.value = 1;
    submitFormCallback();
  };

  function initScrollPagination() {
    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const maxPages = Number(entry.target.dataset.maxPages);
          const currentPage = Number(pageNumberInput.value);

          if (currentPage < maxPages) {
            pageNumberInput.value = currentPage + 1;
            submitFormCallback();
          }
        }
      });
    });

    observer.observe(loadMoreTriggerNode);
  }

  const showClearButtons = () => {
    clearPopupButtons.forEach((clearButton) =>
      clearButton.classList.add('mobile-filter-popup__button--open')
    );
  };

  const showPopupShowEventsButtons = () => {
    showEventsPopupButtons.forEach((showButton) =>
      showButton.classList.add('mobile-filter-popup__button--open')
    );
  };

  //clearButton.classList.add('mobile-filter-popup__button--open')

  function hidePopupButtons() {
    [...clearPopupButtons, ...showEventsPopupButtons].forEach((button) =>
      button.classList.remove('mobile-filter-popup__button--open')
    );
  }

  const openPopupHandler = (event) => {
    const button = event.target.closest('.calendar-btn[data-popup]');
    if (!button) return;
    event.preventDefault();
    const { popup } = button.dataset;
    const popupNode = document.querySelector(
      `.mobile-filter-popup[data-popup="${popup}"`
    );

    if (!popupNode) {
      console.warn(`there is no popup: ${popup}`);
      return;
    }

    popupNode.classList.add('mobile-filter-popup--open');
    document.body.classList.add('flires-popup-open');
    document.body.style.overflow = 'hidden';

    if (hasSelectedFilters) {
      // hidePopupButtons();
      showClearButtons();
    }
  };

  const closePopupHandler = (event) => {
    const closeButton =
      event.target.closest('.mobile-filter-popup__close') ||
      event.target.closest('.mobile-filter-popup__button') ||
      event.target.closest('.mobile-filter-popup__clear');

    if (!closeButton) return;
    event.stopPropagation();
    event.preventDefault();

    const popup = closeButton.closest('.mobile-filter-popup');

    popup.classList.remove('mobile-filter-popup--open');
    document.body.style.overflow = '';
    document.body.classList.remove('flires-popup-open');
    hidePopupButtons();
  };

  initScrollPagination();

  filterForm.addEventListener('change', changeInputsHandler);
  filterForm.addEventListener('submit', submitFormCallback);

  clearFiltersButton.addEventListener('click', clearFilters);
  clearPopupButtons.forEach((button) =>
    button.addEventListener('click', clearFilters)
  );

  document.body.addEventListener('click', openPopupHandler);
  document.body.addEventListener('click', closePopupHandler);
}

initWhatsOnFilters3();

const initShowMoreFilterButtons = () => {
  const SHOW_MORE_BUTTON_SELECTOR = '[data-button="show-all-filters"]';
  const showAllButtons = Array.from(
    document.querySelectorAll(SHOW_MORE_BUTTON_SELECTOR)
  );

  const showAllFilterButtons = (event) => {
    event.preventDefault();
    const filterButtons = Array.from(
      event.target
        .closest('.filters-bottom-div')
        .querySelectorAll('.w-checkbox')
    );

    event.target.classList.toggle('show-all-btn--hide');

    if (event.target.classList.contains('show-all-btn--hide')) {
      event.target.textContent = 'show all';
    } else {
      event.target.textContent = 'hide';
    }

    filterButtons.forEach((filter, index) => {
      if (index >= 4) {
        filter.classList.toggle(
          'hidden-item',
          !!event.target.classList.contains('show-all-btn--hide')
        );
      }
    });
  };

  showAllButtons.forEach((showAllButton) =>
    showAllButton.addEventListener('click', showAllFilterButtons)
  );
};

initShowMoreFilterButtons();

// const initWhatsOnFilters2 = () => {
//   const filterForm = document.querySelector('[data-filter="form"]');

//   if (!filterForm) return;
//   const calendarWidget = new CalendarWidget('calendar-widget');
//   const filterFields = filterForm.querySelectorAll(
//     '[name]:not([type="hidden"]):not([type="submit"])'
//   );
//   const clearFiltersButton = document.getElementById('clear');
//   const selectedFiltersStringContainer =
//     document.getElementById('selected-filters');

//   const getTickets = async (filters = {}) => {
//     const formData = filters instanceof FormData ? filters : new FormData();
//     if (!formData instanceof FormData) {
//       for (const property in filters) {
//         if (Object.hasOwnProperty.call(filters, property)) {
//           const value = filters[property];
//           formData.set(property, value);
//         }
//       }
//     }

//     try {
//       const response = await (
//         await fetch(bech_var.url, {
//           method: 'POST',
//           body: formData,
//         })
//       ).json();

//       console.log(response);

//       if (response.status !== 'success') {
//         throw new Error('Error: ' + response.message);
//       }

//       return response.data;
//     } catch (e) {
//       window.alert(e);
//     }
//   };

//   const getAndSetTickets = async () => {
//     console.log('get tickets');
//     const ticketsContainer = document.getElementById('tickets-container');
//     if (!ticketsContainer) return;
//     const formData = new FormData(filterForm);
//     const ticketsData = await getTickets(formData);

//     selectedFiltersStringContainer.querySelector(
//       '[data-filter="choosen"]'
//     ).textContent = ticketsData.selected_string;
//     selectedFiltersStringContainer.classList.add('filters-line-text--active');
//     ticketsContainer.innerHTML = ticketsData.html;
//   };

//   const changeFilterFieldsHandler = (event) => {
//     const targetFilter = event.target;
//     if (targetFilter.name === 'time') {
//       filterFields.find(
//         (input) => input.getAttribute('name') === 'from'
//       ).value = '';
//       calendarWidget.reset();
//     }

//     getAndSetTickets();
//   };

//   const resetForm = () => {
//     filterForm.reset();
//     calendarWidget.reset();
//     filterFields.forEach((input) => {
//       if (input.type === 'checkbox' || input.type === 'radio') {
//         input.removeAttribute('checked');
//         input.checked = false;
//       } else {
//         input.value = '';
//       }
//     });

//     getAndSetTickets();
//   };

//   clearFiltersButton?.addEventListener('click', (event) => {
//     event.preventDefault();
//     selectedFiltersStringContainer.classList.remove(
//       'filters-line-text--active'
//     );
//     resetForm();
//   });

//   filterFields.forEach((filterField) => {
//     filterField.addEventListener('change', changeFilterFieldsHandler);
//   });
// };

// initWhatsOnFilters2();

const initPressReleaseFilters = () => {
  const formFiltersNode = document.getElementById('press-filter-form');

  if (!formFiltersNode) return;

  const inputNodes = Array.from(formFiltersNode.querySelectorAll('input'));
  const pressPostsContainerNode = document.getElementById(
    'press-office-container'
  );
  const changeInputHandler = async (event) => {
    if (event.target.name === 'tag') {
      inputNodes.find((input) => input.name === 'page').value = 1;
    }

    const formData = new FormData(formFiltersNode);

    try {
      const data = await (
        await fetch(bech_var.url, {
          method: 'POST',
          body: formData,
        })
      ).json();

      console.log(data);

      if (data.status !== 'success') {
        throw new Error('Something goes wrong');
      }

      if (parseInt(formData.get('page')) > 1) {
        pressPostsContainerNode.querySelector('.showmore-btn').remove();
        pressPostsContainerNode.insertAdjacentHTML('beforeend', data.html);
      } else {
        pressPostsContainerNode.innerHTML = data.html;
      }
    } catch (e) {
      console.error(e);
    }
  };
  const showMoreHandler = (event) => {
    const showMoreButton = event.target.closest('.showmore-btn');
    if (showMoreButton) {
      event.stopPropagation();
      event.preventDefault();
      showMoreButton.classList.add('showmore-btn--loading');

      const pageNomberInputNode = document.querySelector('[name="page"]');

      pageNomberInputNode.value = parseInt(pageNomberInputNode.value) + 1;
      pageNomberInputNode.dispatchEvent(new Event('change'));
    }
  };

  inputNodes.forEach((inputNode) =>
    inputNode.addEventListener('change', changeInputHandler)
  );

  document.addEventListener('click', showMoreHandler);
};

initPressReleaseFilters();

//<iframe src="https://tix.bechsteinhall.func.agency/en/itix" style="display: none;" onload="(function(){ console.log('iFrame Loaded'); })();" frameborder="0" id="tix"></iframe>

//tickets.new.bechsteinhall.com

const addTixFrame = () => {
  const frame = document.createElement('iframe');
  frame.setAttribute('src', 'https://tickets.new.bechsteinhall.com/en/itix');
  frame.setAttribute('id', 'tix');
  frame.setAttribute(
    'onload',
    '(function(){ console.log("iTix Loaded"); })();'
  );

  frame.style.display = 'none';

  document.body.insertAdjacentElement('afterbegin', frame);
};

const initTixSessions = () => {
  addTixFrame();
  const tixIframe = document.getElementById('tix');
  if (!tixIframe) return;

  const TIX_URL = 'https://tickets.new.bechsteinhall.com/en/itix';
  let isTixConnected = false;
  let tixConntectedInterval = null;
  let counter = 0;
  const getUserData = (event) => {
    isTixConnected = true;
    window.tixCart.setData(event.data);
    if (event.data.user !== null) {
      initBenefitsForUser(event.data.user);
    }
  };

  window.addEventListener('message', getUserData, false);

  tixConntectedInterval = setInterval(() => {
    if (isTixConnected || counter >= 9) {
      clearInterval(tixConntectedInterval);
      return;
    }
    console.log('Connecting to tix...');
    tixIframe.contentWindow.postMessage('GetSession', TIX_URL);
    counter++;
  }, 1000);

  // const user = {
  //   id: 5119,
  //   name: 'Pavel Leonenko',
  //   email: 'pavel.leonenko374@gmail.com',
  //   hash: '77c53fd8faa9cd5a5b83136dbeba99155f5b9c5ef7098bf700d20cfe18e20219',
  //   tags: [
  //     {
  //       id: 37,
  //       name: 'Friends',
  //       abbr: 'FR',
  //     },
  //     {
  //       id: 42,
  //       name: 'Unlimited',
  //       abbr: 'UL',
  //     },
  //     {
  //       id: 42,
  //       name: 'Unlimited',
  //       abbr: 'UL',
  //     },
  //   ],
  // };

  // initBenefitsForUser(user);
};

function quickSort(array = []) {
  if (array.length <= 1) {
    return array;
  }

  let pivotIndex = Math.floor(array.length / 2);
  let pivot = array[pivotIndex];
  let less = [];
  let greater = [];
  for (let i = 0; i < array.length; i++) {
    if (i === pivotIndex) {
      continue;
    }

    if (array[i] < pivot) {
      less.push(array[i]);
    } else {
      greater.push(array[i]);
    }
  }

  return [...quickSort(less), pivot, ...quickSort(greater)];
}

/**
 *
 *
 * - Проверяем на теги пользователя
 * -- если нет тегов, то ничего не делаем
 *
 * -- если теги есть
 * --- проверяем на бенефит с полем OnlineSaleStart
 * ---- если бенефита с таким полем нет
 * ----- проверяем на бенефит с ценой
 * ---- если бенефит есть
 * -----
 *
 *
 */

const initBenefitsForUser = (user = {}) => {
  if (!user && user.tags.length === 0) {
    return;
  }

  const userTags = user.tags;
  const ticketWithBenefitsNodes = Array.from(
    document.querySelectorAll(
      '[data-ticket_benefits]:not([data-ticket_benefits=""])'
    )
  );

  ticketWithBenefitsNodes.forEach((ticketWithBenefitsNode) => {
    const bookTicketsButton = ticketWithBenefitsNode.querySelector(
      'a.booktickets-btn.none'
    );
    const benefits = JSON.parse(ticketWithBenefitsNode.dataset.ticket_benefits);
    const benefitsForCurrentUser = benefits.filter((benefit) =>
      userTags.find((tag) => tag.id === benefit.CustomerTag.CustomerTagId)
    );
    // search benefit with OnlineSaleStart
    const timeBenefit = benefitsForCurrentUser.find(
      (benefit) => benefit.OnlineSaleStart
    );

    if (timeBenefit) {
      const timeForNow = new Date();
      const ticketOnlineSaleStartTime = new Date(timeBenefit.OnlineSaleStart);

      if (timeForNow > ticketOnlineSaleStartTime) {
        if (bookTicketsButton) {
          bookTicketsButton.style.display = 'flex';

          if (bookTicketsButton.previousElementSibling) {
            bookTicketsButton.previousElementSibling.style.display = 'none';
          }
        }
      }
    }

    let prices = [];

    benefitsForCurrentUser.forEach((benefit) => {
      benefit.Prices.forEach((priceObj) => {
        priceObj.Prices.forEach((innerPriceObj) => {
          prices.push(innerPriceObj.Price);
        });
      });
    });

    prices = quickSort([...new Set(prices)]);

    if (prices.length === 0) {
      return;
    }

    const priceNodes = ticketWithBenefitsNode.querySelectorAll('.cms-li_price');
    const priceString = `from £${prices[0]}`;

    priceNodes.forEach((priceNode) => {
      priceNode.textContent = priceString;
    });
  });
};

const initAddToCalendarButtons = () => {
  const addToCalendarButtons = document.querySelectorAll('[data-calendar]');
  addToCalendarButtons.forEach((button) => {
    button.addEventListener('click', (event) => {
      event.preventDefault();
      const eventCalendarObj = JSON.parse(button.dataset.calendar);
      const addToCalendarConfig = {
        options: ['Apple'],
        timeZone: 'Europe/London',
        trigger: 'click',
        ...eventCalendarObj,
      };

      atcb_action(addToCalendarConfig, button);
      setTimeout(
        () => document.getElementById('atcb-btn-custom-apple').click(),
        200
      );
    });
  });
};

const initMobileWhatsOnFilters = () => {
  // const calendarPopup = document.querySelector('.mobile-filter-popup[data-popup="calendar"]');
  // const filtersPopup = document.querySelector('.mobile-filter-popup[data-popup="filters"]');
  const openPopupHandler = (event) => {
    const button = event.target.closest('.calendar-btn[data-popup]');
    if (!button) return;
    event.preventDefault();
    const { popup } = button.dataset;
    const popupNode = document.querySelector(
      `.mobile-filter-popup[data-popup="${popup}"`
    );

    if (!popupNode) {
      console.warn(`there is no popup: ${popup}`);
      return;
    }

    popupNode.classList.add('mobile-filter-popup--open');
    document.body.style.overflow = 'hidden';
  };

  const closePopupHandler = (event) => {
    const closeButton = event.target.closest('.mobile-filter-popup__close');

    if (!closeButton) return;
    event.stopPropagation();
    event.preventDefault();

    const popup = closeButton.closest('.mobile-filter-popup');

    popup.classList.remove('mobile-filter-popup--open');
    document.body.style.overflow = '';
  };

  document.body.addEventListener('click', openPopupHandler);
  document.body.addEventListener('click', closePopupHandler);
};

document.addEventListener('DOMContentLoaded', () => {
  initAddToCalendarButtons();
  initLoader();
  // initTixSessions();
  initSplideCarousel();

  window.whatsOnSlider = new WhatsOnSlider(
    Array.from(document.querySelectorAll('.wo-slide'))
  );
});

window.addEventListener('load', () => {
  window.svgLoader.open();
  initTixSessions();
  initBurgerMenu();
  // initMobileWhatsOnFilters();
});
