<!DOCTYPE html>
<html>
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../admin/header.php';?>
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
          <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
</head>
<body>   
    <?php include '../admin/navigation.php';?>
 <div class="container-fluid">
    <div class="row">
        <div class="col-md-3 bg-dark">
            <?php include '../admin/left.php';?>
        </div><!--Closing col-md-3 div-->
        <div class="col-md-9" id="wrapper">
            <div id="menuDiv">
                <ul>
                    <li class="main_list"><a href="dates.php" title="Click to return to dates homepage.">Term Dates.</a></li>
                    <li class="main_list"><a href="dates.php?edit=1" title="Click to edit school term dates.">Edit term dates</a></li>
                    <li class="main_list"><a href="calendar.php" title="Click to view school calendar.">School Calendar</a></li>
                </ul>
            </div>
            <div id="calendar"></div>           
 </div><!--closing container div-->
    <?php include '../admin/footer.php';?>
</body>
</html>

<script>
  $(document).ready(function(){
   var calendar = $('#calendar').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
    events: '/school/calendar/load.php',
    selectable:true,
    selectHelper:true,
    select:function(start, end, allDay){
     var title = prompt("Enter Event Title");
     if(title){
      var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
      var end   = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
      $.ajax({
       url:"/school/calendar/insert.php",
       type:"POST",
       data:{title:title, start:start, end:end},
       success:function(){
        calendar.fullCalendar('refetchEvents');
       }
      })
     }
    },
    editable:true,
    eventResize:function(event){
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end   = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id    = event.id;
     $.ajax({
      url:"/school/calendar/update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function(){
       calendar.fullCalendar('refetchEvents');
      }
     })
    },

    eventDrop:function(event){
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end   = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id    = event.id;
     $.ajax({
      url:"/school/calendar/update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function(){
       calendar.fullCalendar('refetchEvents');
      }
     });
    },

    eventClick:function(event){
     if(confirm("Are you sure you want to remove it?")){
      var id = event.id;
      $.ajax({
       url:"/school/calendar/delete.php",
       type:"POST",
       data:{id:id},
       success:function(){
        calendar.fullCalendar('refetchEvents');
        alert("Event Removed");
       }
      })
     }
    },

   });
  });   
  </script>