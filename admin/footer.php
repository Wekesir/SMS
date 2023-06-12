
<script>
load_complains();
load_outbox_count();
load_messages();
load_notifications();   

function closeForecastModal(){
   location.reload(true);
}
//when the weather dropdown is clicked from the navbar
jQuery("#navweather").click(function(e){
    e.preventDefault(); 
    var getForecast = "";
    jQuery.ajax({
        url:"/school/modals/weather-forecast.php",
        method:"POST",
        data:{getForecast:getForecast},
        success:function(data){
            jQuery("body").append(data);
            jQuery("#weather-forecast-modal").modal({
                keyboard:false,
                backdrop:'static'
            });            
        },
        error:function(){
            alert("There was a problem trying to display modal.");
        }
    });
});

function printData(){//this function sends any data to the print page  
    //Get the HTML of div
    var divElements = jQuery("#tableContainerDiv > table").innerHTML;
    //Get the HTML of whole page
    var oldPage = document.body.innerHTML;

    //Reset the page's HTML with div's HTML only
    document.body.innerHTML = 
        "<html><head><title></title></head><body>" + 
        divElements + "</body>";
    //Print Page
    window.print();
    //Restore orignal HTML
    document.body.innerHTML = oldPage;   
} 

jQuery(function(){//function that keeps record of the last time the mouse moved within the pag  
    function timeDifference(timeString){
    var currentTime=new Date();
    var pastTime=new Date(timeString);
    var timediff=currentTime-pastTime
    var minpast=Math.floor( (timediff/60000) );
        if(minpast >=30){
            window.location="../admin/logout.php";
        }
}
    function timeChecker(){
        setInterval(function(){
            var lasttime =sessionStorage.getItem('LAST_TIME_STAMP');
            timeDifference(lasttime);
        }, 30000);
    }
    jQuery(document).mousemove(function(){
        var timeStamp=new Date();
        sessionStorage.setItem('LAST_TIME_STAMP',timeStamp);
    });

    timeChecker();

});//end of the anonymous function
function load_complains(complains=''){//fucntion for loading messages from the database
    jQuery.ajax({
        url:'/school/admin/fetch.php',
        method:'POST',
        data:{complains:complains},
        success:function(data){
            jQuery('.complains_count').html(data);
            jQuery('.complains_count').css("border-radius","50%");
        },
        error:function(){
            alert("Something went wrong fetching messages");
        },
    });
}   
function load_outbox_count(outbox_count=''){//function for loading outbox from the database
    jQuery.ajax({
        url:'/school/messages/helper.php',
        method:'POST',
        data:{outbox_count:outbox_count},
        success:function(data){
            jQuery('.outbox_count').html(data);
            jQuery('.outbox_count').css("border-radius","50%");
        },
        error:function(){
            alert("Something went wrong fetching messages from outbox");
        },
    });
};  
function load_messages(messages=''){//fucntion for loading messages from the database
    jQuery.ajax({
        url:'/school/admin/fetch.php',
        method:'POST',
        data:{messages:messages},
        success:function(data){
            jQuery('.message_count').html(data);
            jQuery('.message_count').css("border-radius","50%");
        },
        error:function(){
            alert("Something went wrong fetching messages");
        },
    });
};
function load_notifications(notifications=''){//function for displaying unread notifications
    jQuery.ajax({
        url:'/school/admin/fetch.php',
        method:'POST',
        data:{notifications:notifications},
        success:function(data){
            jQuery('.notifications_count').html(data);
            jQuery('.notifications_count').css("border-radius","50%");
        },
        error:function(){
            alert('Something went wrong fetching notifications');
        },
    });
};  

$('ul li a').click(function(){//code for changing active class when menu items are clicked
    $(this).addClass("active");
});

</script>

      

   

        
