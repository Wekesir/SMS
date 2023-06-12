<script>
jQuery(document).ready(function(){     

    jQuery(function(){
    
    function timeDifference(timeString){

        var currentTime=new Date();
        var pastTime=new Date(timeString);
        var timediff=currentTime-pastTime; 
        var minpast=Math.floor( (timediff/60000) );//converts milliseconds to mins
            
                if(minpast >=30){//if the time past is more than or equal to 30 mins
                    window.location="../admin/logout.php";
                }           

    }

     function timeChecker(){
        setInterval(function(){
            var lasttime =sessionStorage.getItem('LAST_TIME_STAMP');
            timeDifference(lasttime);
        }, 1000);
    }

     jQuery(document).mousemove(function(){
         var timeStamp=new Date();
         sessionStorage.setItem('LAST_TIME_STAMP',timeStamp);
        });

        timeChecker();
    });


});
</script>