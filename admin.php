<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smspanelNew";
$today = date("Y-m-d");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Count records in the sms table
$sql_sms = "SELECT COUNT(*) as smsCount FROM sms";
$result_sms = $conn->query($sql_sms);

$smsCount = 0;

if ($result_sms->num_rows > 0) {
    $row_sms = $result_sms->fetch_assoc();
    $smsCount = $row_sms["smsCount"];
}

// Count records in the service table
$sql_service = "SELECT COUNT(*) as serviceCount FROM service";
$result_service = $conn->query($sql_service);

$serviceCount = 0;

if ($result_service->num_rows > 0) {
    $row_service = $result_service->fetch_assoc();
    $serviceCount = $row_service["serviceCount"];
}

$conn->close();
?>
<!--  Start content-->
<div class="app-main__inner">

    <div class="row">
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-night-sky">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Total SMS</div>
                        <div class="widget-subheading">Over All SMS</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><?= $smsCount ?></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-asteroid">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Today <?= $today ?></div>
                        <div class="widget-subheading">Total Hits Today</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span>0</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-grow-early">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Sevices</div>
                        <div class="widget-subheading">Total Active Service</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><?= $serviceCount ?></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="mb-3 card">
                <div class="card-header-tab card-header-tab-animation card-header">
                    <div class="card-header-title">
                        <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                        <!-- Hit Report -->
                    </div>

                </div>
                <div class="card-body" style="display: flex;">
                    <div class="calendar">
                        <div class="calendar-header">
                            <span class="month-picker" id="month-picker">February</span>
                            <div class="year-picker">
                                <span class="year-change" id="prev-year">
                                    <pre><</pre>
                                </span>
                                <span id="year">2021</span>
                                <span class="year-change" id="next-year">
                                    <pre>></pre>
                                </span>
                            </div>
                        </div>
                        <div class="calendar-body">
                            <div class="calendar-week-day">
                                <div>Sun</div>
                                <div>Mon</div>
                                <div>Tue</div>
                                <div>Wed</div>
                                <div>Thu</div>
                                <div>Fri</div>
                                <div>Sat</div>
                            </div>
                            <div class="calendar-days"></div>
                        </div>
                        <div class="month-list"></div>
                    </div>

                    <main class="main">
                        <div class="clockbox">
                            <svg id="clock" xmlns="http://www.w3.org/2000/svg" width="400" height="400" viewBox="0 0 600 600">
                                <g id="face">
                                    <circle class="circle" cx="300" cy="300" r="253.9" />
                                    <path class="hour-marks" d="M300.5 94V61M506 300.5h32M300.5 506v33M94 300.5H60M411.3 107.8l7.9-13.8M493 190.2l13-7.4M492.1 411.4l16.5 9.5M411 492.3l8.9 15.3M189 492.3l-9.2 15.9M107.7 411L93 419.5M107.5 189.3l-17.1-9.9M188.1 108.2l-9-15.6" />
                                    <circle class="mid-circle" cx="300" cy="300" r="16.2" />
                                </g>
                                <g id="hour">
                                    <path class="hour-arm" d="M300.5 298V142" />
                                    <circle class="sizing-box" cx="300" cy="300" r="253.9" />
                                </g>
                                <g id="minute">
                                    <path class="minute-arm" d="M300.5 298V67" />
                                    <circle class="sizing-box" cx="300" cy="300" r="253.9" />
                                </g>
                                <g id="second">
                                    <path class="second-arm" d="M300.5 350V55" />
                                    <circle class="sizing-box" cx="300" cy="300" r="253.9" />
                                </g>
                            </svg>
                        </div><!-- .clockbox -->
                    </main>

                </div>
            </div>
        </div>
    </div>
    <!--end row -->



</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap');

    :root {
        --dark-body: #3a3a4f;
        --dark-main: #121221;
        --dark-second: #6e6e80;
        --dark-hover: #292b39;
        --dark-text: #e0e0e0;

        --light-body: #f7f8fc;
        --light-main: #ffffff;
        --light-second: #dcdce0;
        --light-hover: #f2f4f9;
        --light-text: #212121;

        --blue: #004080;
        --white: #ffffff;

        --shadow: rgba(0, 0, 0, 0.2) 0px 7px 29px 0px;

        --font-family: 'Inter', serif;
    }


    .light {
        --bg-body: var(--light-body);
        --bg-main: var(--light-main);
        --bg-second: var(--light-second);
        --color-hover: var(--light-hover);
        --color-txt: var(--light-text);
    }

    .calendar {
        height: max-content;
        width: max-content;
        background-color: var(--bg-main);
        border-radius: 30px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        border: 1px solid black;
    }

    .light .calendar {
        box-shadow: var(--shadow);
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 25px;
        font-weight: 600;
        color: var(--color-txt);
        padding: 10px;
    }

    .calendar-body {
        padding: 10px;
    }

    .calendar-week-day {
        height: 50px;
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        font-weight: 600;
    }

    .calendar-week-day div {
        display: grid;
        place-items: center;
        color: #FF4B4B;
    }

    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
        color: var(--color-txt);
    }

    .calendar-days div {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
        position: relative;
        cursor: pointer;
        animation: to-top 1s forwards;
    }

    .calendar-days div:hover {
        background-color: var(--light-hover);
        border-radius: 10px;
        transition: background-color 0.3s ease;
    }

    .dark .calendar-days div:hover {
        background-color: var(--dark-hover);
    }

    .calendar-days div span {
        position: absolute;
    }

    .calendar-days div.curr-date span {
        display: none;
    }

    .calendar .curr-date {
        border: 2px solid #4C53AF;
        border-radius: 50%;
        background-color: #EAE6FF;
        color: #333;
        padding: 5px;
        box-sizing: border-box;
        text-align: center;
    }

    .month-picker {
        padding: 5px 10px;
        border-radius: 10px;
        cursor: pointer;
        color: #FF4B4B;
    }

    .month-picker:hover {
        background-color: var(--color-hover);
    }

    .year-picker {
        display: flex;
        align-items: center;
    }

    .year-change {
        height: 40px;
        width: 40px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        margin: 0 10px;
        cursor: pointer;
    }

    .year-change:hover {
        background-color: var(--color-hover);
    }

    .calendar-footer {
        padding: 10px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .toggle {
        display: flex;
    }

    .toggle span {
        margin-right: 10px;
        color: var(--color-txt);
    }

    .dark-mode-switch {
        position: relative;
        width: 48px;
        height: 25px;
        border-radius: 14px;
        background-color: var(--bg-second);
        cursor: pointer;
    }

    .dark-mode-switch-ident {
        width: 21px;
        height: 21px;
        border-radius: 50%;
        background-color: var(--bg-main);
        position: absolute;
        top: 2px;
        left: 2px;
        transition: left 0.2s ease-in-out;
    }

    .dark .dark-mode-switch .dark-mode-switch-ident {
        top: 2px;
        left: calc(2px + 50%);
    }

    .month-list {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: var(--bg-main);
        padding: 20px;
        grid-template-columns: repeat(3, auto);
        gap: 5px;
        display: grid;
        transform: scale(1.5);
        visibility: hidden;
        pointer-events: none;
    }

    .month-list.show {
        transform: scale(1);
        visibility: visible;
        pointer-events: visible;
        transition: all 0.2s ease-in-out;
    }

    .month-list>div {
        display: grid;
        place-items: center;
    }

    .month-list>div>div {
        width: 100%;
        padding: 5px 20px;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        color: var(--color-txt);
    }

    .month-list>div>div:hover {
        background-color: var(--color-hover);
    }

    @keyframes to-top {
        0% {
            transform: translateY(100%);
            opacity: 0;
        }

        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .main {
        display: flex;
        padding: 2em;
        justify-content: center;
        align-items: middle;
        margin-left: 10%;
    }

    .clockbox,
    #clock {
        width: 100%;
    }

    .circle {
        fill: none;
        stroke: #404040;
        stroke-width: 9;
        stroke-miterlimit: 10;
    }

    .mid-circle {
        fill: #404040;
    }

    .hour-marks {
        fill: none;
        stroke: #404040;
        stroke-width: 9;
        stroke-miterlimit: 10;
    }

    .hour-arm {
        fill: none;
        stroke: #404040;
        stroke-width: 17;
        stroke-miterlimit: 10;
    }

    .minute-arm {
        fill: none;
        stroke: #404040;
        stroke-width: 11;
        stroke-miterlimit: 10;
    }

    .second-arm {
        fill: none;
        stroke: #404040;
        stroke-width: 4;
        stroke-miterlimit: 10;
    }

    /* Transparent box ensuring arms center properly. */
    .sizing-box {
        fill: none;
    }

    #dateAndTime {
        color: red
    }

    /* Make all arms rotate around the same center point. */
    /* Optional: Use transition for animation. */
    #hour,
    #minute,
    #second {
        transform-origin: 300px 300px;
        transition: transform .7s ease-in-out;
    }

    #clock2 h2 {
        position: static;
        display: block;
        color: #404040;
        text-align: center;
        margin: 10px 0;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4em;
        font-size: 0.8em;
    }

    #clock2 #time {
        display: flex;
        justify-content: center;

    }

    #clock2 #time div {
        position: relative;
        margin: 0 5px;

    }

    #clock2 #time div span {
        position: relative;
        display: block;
        width: 100px;
        height: 80px;
        background: #2196f3;
        color: #fff;
        font-weight: 300;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 3em;
        z-index: 10;
        box-shadow: 0 0 0 1px rgba(0, 0, 0, .2);
    }

    #clock2 #time div span:nth-child(2) {
        height: 30px;
        font-size: 0.7em;
        letter-spacing: 0.2em;
        font-weight: 500;
        z-index: 9;
        box-shadow: none;
        background: #127fd6;
        text-transform: unset;
    }

    #clock2 #time div:last-child span {
        background: #ff006a;
    }

    #clock2 #time div:last-child span:nth-child(2) {
        background: #ec0062;
    }
</style>
<script>
    let calendar = document.querySelector('.calendar')

    const month_names = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']

    isLeapYear = (year) => {
        return (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) || (year % 100 === 0 && year % 400 === 0)
    }

    getFebDays = (year) => {
        return isLeapYear(year) ? 29 : 28
    }

    generateCalendar = (month, year) => {

        let calendar_days = calendar.querySelector('.calendar-days')
        let calendar_header_year = calendar.querySelector('#year')

        let days_of_month = [31, getFebDays(year), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]

        calendar_days.innerHTML = ''

        let currDate = new Date()
        if (!month) month = currDate.getMonth()
        if (!year) year = currDate.getFullYear()

        let curr_month = `${month_names[month]}`
        month_picker.innerHTML = curr_month
        calendar_header_year.innerHTML = year

        let first_day = new Date(year, month, 1)

        for (let i = 0; i <= days_of_month[month] + first_day.getDay() - 1; i++) {
            let day = document.createElement('div')
            if (i >= first_day.getDay()) {
                day.classList.add('calendar-day-hover')
                day.innerHTML = i - first_day.getDay() + 1
                day.innerHTML += `<span></span>
                            <span></span>
                            <span></span>
                            <span></span>`
                if (i - first_day.getDay() + 1 === currDate.getDate() && year === currDate.getFullYear() && month === currDate.getMonth()) {
                    day.classList.add('curr-date') // Add this class for current date
                }
            }
            calendar_days.appendChild(day)
        }
    }

    let month_list = calendar.querySelector('.month-list')

    month_names.forEach((e, index) => {
        let month = document.createElement('div')
        month.innerHTML = `<div data-month="${index}">${e}</div>`
        month.querySelector('div').onclick = () => {
            month_list.classList.remove('show')
            curr_month.value = index
            generateCalendar(index, curr_year.value)
        }
        month_list.appendChild(month)
    })

    let month_picker = calendar.querySelector('#month-picker')

    month_picker.onclick = () => {
        month_list.classList.add('show')
    }

    let currDate = new Date()

    let curr_month = {
        value: currDate.getMonth()
    }
    let curr_year = {
        value: currDate.getFullYear()
    }

    generateCalendar(curr_month.value, curr_year.value)

    document.querySelector('#prev-year').onclick = () => {
        --curr_year.value
        generateCalendar(curr_month.value, curr_year.value)
    }

    document.querySelector('#next-year').onclick = () => {
        ++curr_year.value
        generateCalendar(curr_month.value, curr_year.value)
    }

    const HOURHAND = document.querySelector("#hour");
    const MINUTEHAND = document.querySelector("#minute");
    const SECONDHAND = document.querySelector("#second");
    const GETREALTIME = document.querySelector("#dateAndTime");
    const DATEDOTAY = document.getElementById("date")
    var HOURHAND2 = document.querySelector("#Hours");
    var MINUTEHAND2 = document.querySelector("#Minutes");
    var SECONDHAND2 = document.querySelector("#Seconds");
    var date = new Date();
    console.log(date);
    let hr = date.getHours();
    let min = date.getMinutes();
    let sec = date.getSeconds();
    console.log("Hour: " + hr + " Minute: " + min + " Second: " + sec);

    let hrPosition = (hr * 360 / 12) + (min * (360 / 60) / 12);
    let minPosition = (min * 360 / 60) + (sec * (360 / 60) / 60);
    let secPosition = sec * 360 / 60;

    function runTheClock() {
        var date = new Date();
        console.log(date);
        let hr = date.getHours();
        let min = date.getMinutes();
        let sec = date.getSeconds();
        let currentHour = function() {
            let realHour = 0;
            let realHourInPM = 0;
            if (hr >= 13) {
                realHour = hr - 12;
                realHourInPM = `${realHour}`;
            } else {
                realHour = hr;
                realHourInPM = `${realHour}`;
            }

            return realHourInPM;
        }
        hrPosition = hrPosition + (3 / 360);
        minPosition = minPosition + (6 / 60);
        secPosition = secPosition + 6;

        HOURHAND.style.transform = "rotate(" + hrPosition + "deg)";
        MINUTEHAND.style.transform = "rotate(" + minPosition + "deg)";
        SECONDHAND.style.transform = "rotate(" + secPosition + "deg)";
        HOURHAND2.innerHTML = currentHour();
        MINUTEHAND2.innerHTML = min;
        SECONDHAND2.innerHTML = sec;

    }

    var interval = setInterval(runTheClock, 1000);
</script>