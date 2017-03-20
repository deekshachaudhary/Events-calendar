<!--http://www.codexworld.com/build-event-calendar-using-jquery-ajax-php/-->

<!DOCTYPE html>
<html>
<?php
require 'database.php';
session_start();
//$username = $_SESSION['username']; 
?>

<head>
<title>Calendar</title>
<?php
if(isset($_SESSION['username']))
?>
<?php
echo $_SESSION['username'];
?>
<link rel="stylesheet" type="text/css" href=mainStyle.css>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>
<script type = "text/javascript" src = "date.js"></script>
<script src="calendar.js"></script>
<script src="calendar.min.js"></script>

<!--<script type="text/javascript">-->
<!--    var daysClassNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];-->
<!--    var monthsNames = ['January', 'Februray','March','April','May','June','July',-->
<!--                       'August','September','October','November','December'];-->
<!--    var daysClassInMonths = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];-->
<!--    -->
<!--    currDate = new Date();-->
<!--    currDay = currDate.getDate();-->
<!--    currMonth = currDate.getMonth();-->
<!--    currYear = currDate.getFullYear();-->
<!--    -->
<!--    function Calendar(month, year) {-->
<!--        if(month === null) {-->
<!--            this.month = currMonth;-->
<!--        }-->
<!--        else {-->
<!--            this.month = month;-->
<!--        }-->
<!--        if(year === null) {-->
<!--            thisyear = currYear;-->
<!--        }-->
<!--        else {-->
<!--            this.year = year;-->
<!--        }-->
<!--        this.html = '';-->
<!--    }-->
<!--    -->
<!--    Calendar.prototype.generateHTML = function() {-->
<!--        var startingDate = new Date(this.year, this.month, 1);-->
<!--        var startingDay = startingDate.getDay();-->
<!--        var numDays = Date.getDaysInMonth(currDate.year, curr.month);-->
<!--        var monthName = monthsNames[this.month];-->
<!--        var html = '<table class = "skeleton">';-->
<!--        html += monthName + "&nbsp;" +this.year + '</th></tr>' + '<tr class="cal_daysClass_on_top">';-->
<!--        for(var i = 0; i < 7; i++) {-->
<!--            html += '<td class="cal_daysClass_on_top">' + daysClassNames[i] + '</td>';-->
<!--        }-->
<!--        html += '</tr><tr>';-->
<!--        var day = 1;-->
<!--        for(var i = 0; i < 9; i++) {-->
<!--            for(var j = 0; j < 7; j++){-->
<!--                html += '<td class = "cal_daysClass_on_top">';-->
<!--                if(day <= numDays && (i > 0 || j >= startingDay)){-->
<!--                    html += '<div onclick = showDayDialog('+day+') id="dayevents">' +day+ '</div><div onClick=ajaxFunction('+currYear+currMonth+day+') id='+currYear+currMonth+day+'</div><div id="result_table" style="display:none;">events here on' +currMonth+day+currYear+ '<br></div><input type="hidden" name="date" value="' + currYear + currMonth + day + '"/><input type="submit" name="" value="click to show events"/></div>';-->
<!--                    day++;-->
<!--                }-->
<!--                html += '</td>';-->
<!--            }-->
<!--            if(day > numDays) {-->
<!--                break;-->
<!--            }-->
<!--            else {-->
<!--                html += '</tr><tr>';-->
<!--            }-->
<!--        }-->
<!--        html += '</tr></table>';-->
<!--        this.html = html;-->
<!--    };-->
<!--    Calendar.prototype.getHTML = function() {-->
<!--        return this.html;-->
<!--    };-->
<!--    function goToPrevMonth(){-->
<!--        var prevMonth;-->
<!--        if(currMonth == -1) {-->
<!--            this.currMonth = 11;-->
<!--            this.currYear = currYear - 1;-->
<!--            //prevMonth = new Calendar(this.currMonth, this.currYear);-->
<!--            //prevMonth.generateHTML();-->
<!--            //document.getElementById("calendar").innerHTML = prevMonth.getHTML();-->
<!--        }-->
<!--        //else {-->
<!--        //    prevMonth = new Calendar(this.currMonth, this.currYear);-->
<!--        //    -->
<!--        //}-->
<!--        prevMonth = new Calendar(this.currMonth, this.currYear);-->
<!--        prevMonth.generateHTML();-->
<!--        document.getElementById("calendar").innerHTML = prevMonth.getHTML();-->
<!--    }-->
<!--    function goToNextMonth(){-->
<!--        var prevMonth;-->
<!--        if(currMonth == -1) {-->
<!--            this.currMonth = 11;-->
<!--            this.currYear = currYear - 1;-->
<!--            //prevMonth = new Calendar(this.currMonth, this.currYear);-->
<!--            //prevMonth.generateHTML();-->
<!--            //document.getElementById("calendar").innerHTML = prevMonth.getHTML();-->
<!--        }-->
<!--        //else {-->
<!--        //    prevMonth = new Calendar(this.currMonth, this.currYear);-->
<!--        //    -->
<!--        //}-->
<!--        prevMonth = new Calendar(this.currMonth, this.currYear);-->
<!--        prevMonth.generateHTML();-->
<!--        document.getElementById("calendar").innerHTML = prevMonth.getHTML();-->
<!--    }-->
<!--    -->
<!--    -->
<!---->
<!--</script>-->

    <script type="text/javascript">
        
    //var currentMonth;
    //var monthStartDay;
    //$(function() {
    //    currentMonth = new Date();
    //    updateCalendar(currentMonth.getFullYear(), currentMonth.getMonth());
    //    document.getElementById("prev_month_btn").addEventListener("click", function(event) {
    //        updateCalendar(currentMonth.getFullYear(), currentMonth.getMonth().prevMonth());
    //    }, false);
    //    
    //    document.getElementById("next_month_btn").addEventListener("click", function(event) {
    //        //currentMonth = currentMonth.nextMonth();
    //        updateCalendar(currentMonth.getFullYear(), current.getMonth().nextMonth());
    //    }, false);
    //
    //});
    var currentMonth;
    var currentMonthOnWiki;
    var monthStartDay;
    var monthNames = ['January', 'February', 'March', 'April', 'May',
                          'June', 'July', 'August', 'September',
                          'October', 'November', 'December'];
    $(function() {
        currentMonth = new Date();
        updateCalendar(currentMonth.getFullYear(), currentMonth.getMonth());
        currentMonthOnWiki = new Month(currentMonth.getFullYear(), currentMonth.getMonth());

        // on click listeners for previous month and next month buttons
        document.getElementById("prev_month_btn").addEventListener("click", function(event) {
            currentMonthOnWiki = currentMonthOnWiki.prevMonth();
            updateCalendar(currentMonthOnWiki.year, currentMonthOnWiki.month);
        }, false);
        
        document.getElementById("next_month_btn").addEventListener("click", function(event) {
            currentMonthOnWiki = currentMonthOnWiki.nextMonth();
            updateCalendar(currentMonthOnWiki.year, currentMonthOnWiki.month);
        }, false);

        //hide all event divs        
        $("#createEventDiv").hide();
        $("#viewEventDiv").hide();
        //$("#shareEventDiv").hide();
        
        // hide div if close button clicked
        $("#closeCreateEventBox").click(function(){
            $("#createEventDiv").hide();
        });

        $("#closeViewEventBox").click(function(){
            $("#viewEventDiv").hide();
        });
        
        //$("#closeShareEventBox").click(function(){
        //    $("#viewEventDiv").hide();
        //});
        
        $("#createNewEvent").click(function(){
            $("#createEventDiv").show();
            $("#createEvent").click(function(){
                createEvent();
            });
        });
        $("#viewEventEdit").click(function(){
            editEvent();
        });
        $("#viewEventDelete").click(function(){
            deleteEvent();
        });
        //$("#viewEventShare").click(function(){
        //    shareEvent();
        //});
        //$("#shareCalendar").click(function() {
        //    shareCalendar();    
        //});
    
    });
    
        
        function updateCalendar(year, month) {
            currentMonth = new Date(year, month);
            $ajaxMonth = new Date(year, month);
            $newMonth = new Month($ajaxMonth.getFullYear(), $ajaxMonth.getMonth());
            $displayMonthOnTop = (monthNames[$newMonth.month])+ ' ' + $newMonth.year;
            $("#dateOnTop").text($displayMonthOnTop);
            monthStartDay = $newMonth.getDateObject(1).getDay();
            $numDaysInMonth = Date.getDaysInMonth($newMonth.year, $newMonth.month);
            
            //var weeks = $newMonth.getWeeks();

            // empty all the date divs and events to render the new calendar
            for(var i = 0; i < 42; i++){
                //$("#day" + i + ".daysClass").empty();
                $("#day" + i + " .daysClass").empty();
                $("#day" + i + " ul").empty();
                //console.log("#day" + i + ".daysClass");
                //console.log($("#day" + i + " ul"));
            
            }
            
                
            //for(var w in weeks){
            //    var daysClass = weeks[w].getDates();
                
                //for(var d in daysClass) {
            for(var j = 1; j <= $numDaysInMonth; j++) {
                $("#day" + (monthStartDay + j - 1)).text(j);
                //console.log($("#day" + (monthStartDay + j - 1)).text(j));
            }
            if($numDaysInMonth + monthStartDay <= 35) {
                $("#week5").hide();
            }
            else {
                $("#week5").show();
            }
            console.log("Year: " +year);
            console.log("Monht: " +month);
            console.log("Day: " +$numDaysInMonth);
            
            addElements(year, month+1, $numDaysInMonth);
        }
        
// http://stackoverflow.com/questions/9436534/ajax-tutorial-for-post-and-get        
        function addElements(year, month, numDaysInMonth) {
            for(var i = 1; i <= numDaysInMonth; i++) {
                console.log("Year: " +year);
                console.log("Monht: " +month);
                console.log("Day: " +i);
                var dataArray = {event_year: year, event_month: month, event_day: i};
                $.ajax({
                    url: 'displayEvents.php', type: 'post',
                    //data: {'event_year': 2017, 'event_month': 3, 'event_day': 20},
                    data: dataArray,
                    success: function(data) {
                        $eventsToday = jQuery.parseJSON(data);
                        console.log(data);
                        $.each($eventsToday, function(key, value) {
                            $tempKey = key;
                            $event_id = value[0];
                            $username = value[1];
                            $event_name = value[4];
                            $description = value[5];
                            $event_date = value[6];
                            
                            var eventDate = $event_date.split('/');
                            $eventMonth = (parseInt(eventDate[0]) + 1);
                            $eventDay = eventDate[1];
                            $eventYear = eventDate[2];
                            $dayNumInDiv = (monthStartDay + parseInt(value[2]));
                            $tempTime = new Date(year, month, parseInt(value[2]),
                                                 parseInt(value[3])).toString("hh:mm tt");
                            $eventTime = value[3];
                            //$hiddenFields = '<input type="hidden" id="event_id" value="' + $event_id + '"><input type="hidden" id="username" value="' + $username + '"><input type="hidden" id="event_name" value="' + $event_name + '"><input type="hidden" id="description" value="' + $description + '"><input type="hidden" id="event_date" value="' + $eventMonth + '/' + $eventDay + '/' + $eventYear + '"><input type="hidden" id="eventTime" value="' + $eventTime + '">';
                            //$('<li id="Event' + $event_id + '" class="event">' + $hiddenFields + '<div id="tagline">' + value[4] + '<br>' + $tempTime + '</div></li>').appendTo("#day"+ $dayNumInDiv + " ul");
                            //$x = 'li#Event' + $event_id;
                            //$("#day"+ $dayNumInDiv).on("click", $x, function() {
                            console.log("#day" +$dayNumInDiv);
                            
                            $("#day" +$dayNumInDiv).val = $eventDay+$eventsToday;

                            $("#day" +$dayNumInDiv).on("click", function() {
                            
                                $("#viewEventDiv").show();
                                //viewEvent($(this).find('#event_id').val(),
                                //          $(this).find('#event_date').val(),
                                //          $(this).find('#eventTime').val(),
                                //          $(this).find('#event_name').val(),
                                //          $(this).find('#description').val());
                                    
                                    console.log($event_name);
                                    $("#viewEventId").val($event_id);
                                    $("#viewEventDate").val($eventMonth + '/' + $eventDay + '/' + $eventYear);
                                    $("#viewEventTime").val($eventTime);
                                    $("#viewEventName").val($event_name);
                                    $("#viewEventDescription").val($description);
            
                                    $("#viewEventEdit").show();
                                    $("#viewEventDelete").show();

                            });
                        });
                    }
                });
            }
        }
        
        //function viewEvent(viewEventId, viewEventDate, viewEventTime,
        //                   viewEventName, viewEventDescription){
        //    $("#viewEventId").val(viewEventId);
        //    $("#viewEventDate").val(viewEventDate);
        //    $("#viewEventTime").val(viewEventTime);
        //    $("#viewEventName").val(viewEventName);
        //    $("#viewEventDescription").val(viewEventDescription);
        //    
        //    $("#viewEventEdit").show();
        //    $("#viewEventDelete").show();
        //}
        
        function createEvent() {
            $createEventName = $("#createEventName").val();
            $createEventDate = $("#createEventDate").val();
            $createEventTime = $("#createEventTime").val();
            $createEventDescription = $("#createEventDescription").val();
            
            if($createEventName !== "" && $createEventDescription !== "") {
                var date = $createEventDate.split('/');
                $createEventMonth = parseInt(date[0]);
                $createEventDay = parseInt(date[1]);
                $createEventYear = parseInt(date[2]);
                
                $.ajax({
                   url: 'createEvent.php',
                   type: 'post',
                   data: {'event_year': $createEventYear,
                   'event_month': $createEventMonth,
                   'event_day': $createEventDay,
                   'event_time': $createEventTime,
                   'event_name': $createEventName,
                   'event_description': $createEventDescription},
                   success: function(data) {
                        if(data=="Success"){
                        alert("Event created");
                        $("#createEventName").val('');
                        $("#createEventDate").val('');
                        $("#createEventTime").val('');
                        $("#createEventDescription").val('');
                        $("#createEventDiv").hide();
                        updateCalendar(currentMonth.getFullYear(), currentMonth.getMonth());                    
                        }
                   }
                });
            }
            else{
                alert("Invalid entries, please try again");
            }
        }
        
        
        function editEvent() {
            $viewEventId = $("#viewEventId").val();
            $viewEventName = $("#viewEventName").val();
            $viewEventDate = $("#viewEventDate").val();
            $viewEventTime = $("#viewEventTime").val();
            $viewEventDescription = $("#viewEventDescription").val();
            
            if($viewEventName !== "" && $viewEventDescription !== "") {
                var date = $viewEventDate.split('/');
                $viewEventMonth = parseInt(date[0]) - 1;
                $viewEventDay = parseInt(date[1]);
                $viewEventYear = parseInt(date[2]);
                var dataArray = {event_id: $viewEventId,
                    event_year: $viewEventYear,
                   event_month: $viewEventMonth,
                   event_day: $viewEventDay,
                   event_time: $viewEventTime,
                   event_name: $viewEventName,
                   event_description: $viewEventDescription}
                $.ajax({
                   url: 'editEvent.php',
                   type: 'post',
                   data: dataArray,
                   success: function(data) {
                        if(data=="Success"){
                        alert("Event edited successfully");
                        $("#viewEventName").val('');
                        $("#viewEventDate").val('');
                        $("#viewEventTime").val('');
                        $("#viewEventDescription").val('');
                        $("#viewEventDiv").hide();
                        updateCalendar(currentMonth.getFullYear(), currentMonth.getMonth());                    
                        }
                   }
                });
            }
            else{
                alert("Invalid entries, please try again");
            }
        }
        
        function deleteEvent(){
            $viewEventId = $("#viewEventId").val();
            $viewEventName = $("#viewEventName").val();
            $viewEventDate = $("#viewEventDate").val();
            console.log($viewEventId);
            var dataArray = {event_id: $viewEventId};
            $.ajax({
               url: 'deleteEvent.php',
                type: 'post',
                data: dataArray,
                success: function(data) {
                    if(data == "Success") {
                    alert("Event deleted successfully");
                    $("#viewEventId").val('');
                    $("#viewEventName").val('');
                    $("#viewEventDate").val('');
                    $("#viewEventTime").val('');
                    $("#viewEventDescription").val('');
                    $("#viewEventDiv").hide();
                    updateCalendar(currentMonth.getFullYear(), currentMonth.getMonth());
                    }
                }
            });            
        }
        
        //function shareCalendar(){
        //    $("#shareEventDiv").show();
        //    $("#shareEvent").click(function(){
        //        $shareWithUsers = $("#shareWithUsers").val();
        //        $.ajax({
        //            url: 'updateShareWithUsers.php',
        //            type: 'post',
        //            data: {''}
        //        })
        //    })
        //}
        
        
</script>
</head>
    <!--    //currentMonth = new Date();-->
    <!--    //drawCalendar(currentMonth.getFullYear(), currentMonth.getMonth());-->
    <!--    //$("#prevMonth").click(function() {-->
    <!--    //    drawCalendar(currentMonth.getFullYear(), currentMonth.getMonth()-1);-->
    <!--    //});-->
    <!--    //$("#nextMonth").click(function() {-->
    <!--    //    drawCalendar(currentMonth.getFullYear(), currentMonth.getMonth()+1);-->
    <!--    //});        -->
    <!--//});-->
    <!---->
    <!--function drawCalendar(year, month) {-->
    <!--    currentMonth = new Date(year, month);-->
    <!--    $ajaxMonth = new Date(year, month);-->
    <!--    $newMonth = new Month($ajaxMonth.getFullYear(),$ajaxMonth.getMonth());-->
    <!--}-->
<body>
   <!-- <fieldset>-->
   <!--<form action="login.php" method='POST'>-->
   <!---->
   <!--      <legend>Login</legend>-->
   <!--      <label><b>Username</b></label>-->
   <!--      <input name="username" placeholder="Enter Username" required="" type="text">-->
   <!--      <label><b>Password</b></label>-->
   <!--      <input name= "password" placeholder = "Enter Password" required= "" type ="password">-->
   <!--      <input type="submit" value="Login">-->
   <!--</form>-->
   <!---->
   <!-- <form action = "createNewUser.php" method = 'Post'>-->
   <!-- <legend>New User?</legend>-->
   <!-- <label><b>Username</b></label>-->
   <!-- <input name = "username" placeholder = "Create Username" required ="" type = "text">-->
   <!-- <label><b>Password</b></label>-->
   <!-- <input name= "password" placeholder = "Enter Password" required= "" type ="password">-->
   <!-- <input type = "submit" value = "Sign up">-->
   <!-- </form>-->
   <!-- </fieldset>-->
<h2>Welcome to your calendar!</h2>
    <form action="logout.php" method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>

    <div class="cal_header">
        <input id="createNewEvent" type="button" name="createNewEvent" value="Create New Event">
        <!--<input id="shareCalendar" type="button" name="shareCalendar" value="Share Calendar">-->
     </div>   

    <div id="main">
        <div id="monthYearOnTop">
            <input id="prev_month_btn" type="button" name="prev_month_btn" value= "<<" >
            <div id="dateOnTop"><h2 id="dateOn_Top"></h2></div>
            <input id="next_month_btn" type="button" name="next_month_btn" value=">>">
        </div>
        <table id="currMonth">
            <tr id="daysNames">
                <td>Sunday</td>
                <td>Monday</td>
                <td>Tuesday</td>
                <td>Wednesday</td>
                <td>Thursday</td>
                <td>Friday</td>
                <td>Saturday</td>
            </tr>
            
            <tr id="week0">
                <td id="day0"><div class="daysClass"></div><ul></ul></td>
                <td id="day1"><div class="daysClass"></div><ul></ul></td>
                <td id="day2"><div class="daysClass"></div><ul></ul></td>
                <td id="day3"><div class="daysClass"></div><ul></ul></td>
                <td id="day4"><div class="daysClass"></div><ul></ul></td>
                <td id="day5"><div class="daysClass"></div><ul></ul></td>
                <td id="day6"><div class="daysClass"></div><ul></ul></td>
            </tr>
                
            <tr id="week1">
                <td id="day7"><div class="daysClass"></div><ul></ul></td>
                <td id="day8"><div class="daysClass"></div><ul></ul></td>
                <td id="day9"><div class="daysClass"></div><ul></ul></td>
                <td id="day10"><div class="daysClass"></div><ul></ul></td>
                <td id="day11"><div class="daysClass"></div><ul></ul></td>
                <td id="day12"><div class="daysClass"></div><ul></ul></td>
                <td id="day13"><div class="daysClass"></div><ul></ul></td>
            </tr>
                
            <tr id="week2">
                <td id="day14"><div class="daysClass"></div><ul></ul></td>
                <td id="day15"><div class="daysClass"></div><ul></ul></td>
                <td id="day16"><div class="daysClass"></div><ul></ul></td>
                <td id="day17"><div class="daysClass"></div><ul></ul></td>
                <td id="day18"><div class="daysClass"></div><ul></ul></td>
                <td id="day19"><div class="daysClass"></div><ul></ul></td>
                <td id="day20"><div class="daysClass"></div><ul></ul></td>
            </tr>
                
            <tr id="week3">
                <td id="day21"><div class="daysClass"></div><ul></ul></td>
                <td id="day22"><div class="daysClass"></div><ul></ul></td>
                <td id="day23"><div class="daysClass"></div><ul></ul></td>
                <td id="day24"><div class="daysClass"></div><ul></ul></td>
                <td id="day25"><div class="daysClass"></div><ul></ul></td>
                <td id="day26"><div class="daysClass"></div><ul></ul></td>
                <td id="day27"><div class="daysClass"></div><ul></ul></td>
            </tr>
                
            <tr id="week4">
                <td id="day28"><div class="daysClass"></div><ul></ul></td>
                <td id="day29"><div class="daysClass"></div><ul></ul></td>
                <td id="day30"><div class="daysClass"></div><ul></ul></td>
                <td id="day31"><div class="daysClass"></div><ul></ul></td>
                <td id="day32"><div class="daysClass"></div><ul></ul></td>
                <td id="day33"><div class="daysClass"></div><ul></ul></td>
                <td id="day34"><div class="daysClass"></div><ul></ul></td>
            </tr>
            
            <tr id="week5">
                <td id="day35"><div class="daysClass"></div><ul></ul></td>
                <td id="day36"><div class="daysClass"></div><ul></ul></td>
                <td id="day37"><div class="daysClass"></div><ul></ul></td>
                <td id="day38"><div class="daysClass"></div><ul></ul></td>
                <td id="day39"><div class="daysClass"></div><ul></ul></td>
                <td id="day40"><div class="daysClass"></div><ul></ul></td>
                <td id="day41"><div class="daysClass"></div><ul></ul></td>
            </tr>
        </table>
    </div>
    
    <div id="createEventDiv">
        <div id="closeCreateEventBox">X</div>
        <h4 id="createEventTitle">New Event</h4>
        <p><label><b>Name</b></label>
        <input name="createEventName" placeholder="Enter Event name" type="text" id="createEventName">
        </p>
        <p><label><b>Date</b></label>
        <input name="createEventDate" placeholder="Enter date (mm/dd/yyyy)" type="text" id="createEventDate">
        </p>
        <p><label><b>Time</b></label>
        <input name="createEventTime" placeholder="Enter time (hh:mm:ss)" type="text" id="createEventTime">
        </p>
        <p><label><b>Description</b></label>
        <input name="createEventDescription" placeholder="Enter description" type="text" id="createEventDescription">
        </p>
        <p><input type="submit" id="createEvent" value="Create Event">
        </p>
    </div>
    
    <div id="viewEventDiv">
        <div id="closeViewEventBox">X</div>
        <h4 id="viewEventTitle">View Event</h4>
        <input type="hidden" id="viewEventId">
        <p>Name:<input name="viewEventName" placeholder="Enter Event name" type="text" id="viewEventName">
        </p>
        
        <p>Date<input name="viewEventDate" placeholder="Enter date (mm/dd/yyyy)" type="text" id="viewEventDate">
        </p>
        
        <p>Time<input name="viewEventTime" placeholder="Enter time" type="text" id="viewEventTime">
        </p>
        
        <p>Description<input name="viewEventDescription" placeholder="Enter description" type="text" id="viewEventDescription">
        </p>
        
        <p><input type="Submit" id="viewEventEdit" value="Edit Event">
            <input type="Submit" id="viewEventDelete" value="Delete Event">      
        </p>
    </div>
    
    <!--<div id="shareEventDiv">-->
    <!--    <div id="closeShareEventBox">X</div>-->
    <!--    <h4 id="shareEventDivTitle">Share Event</h4>-->
    <!--    <input type="hidden" id="viewEventId">-->
    <!--    <p><label><b>Share with:</b></label>-->
    <!--    <input name="shareEventWith" placeholder="Enter users you want to share event with" type="text" id="shareEventWith">-->
    <!--    </p>-->
    <!--    <p><input type="submit" id="shareEvent" value="Share Event">-->
    <!--    </p>-->
    <!--</div>-->

</body>
</html>
                