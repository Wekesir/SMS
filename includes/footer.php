<!DOCTYPE html>
<html>
    <head>
      
    </head>
    <body>
        <div class="container-fluid" id="footer_div">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p id="copyright">©<?=date('Y');?> Hillstop Academy MIrera</p>
                    <p id="top" class="scroll"> <a href="index.php#carousel">Back to top.</a> </p>
                </div>
            </div><!--Closing row div-->
            <div class="row">
                <div class="col-md-6">
                    <a href="https://www.facebook.com/hillstopacademymirera"><i class="fab fa-facebook-f"></i> Facebook</a>
                    <a href="https://accounts.google.com/servicelogin/signinchooser?flowName=GlifWebSignIn&flowEntry=ServiceLogin"><i class="fas fa-envelope-open-text"></i> Gmail</a>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
function openLogin(){
    window.open("login.php","_blank");
}

jQuery('.scrollTop').click(function(event){
    event.preventDefault();//prevents the link from reloading page
    jQuery('body,html').animate({
        scrollTop:0
    },200);
     
});

function showfees(){
    event.preventDefault();
    var request='';//requests the page that contains the modalal
    jQuery.ajax({
        url:'/school/modals/showfees.php',
        method:'post',
        data:{request:request},
        success:function(data){
            jQuery("body").append(data);
            jQuery("#feesmodal").modal({
                keyboard:false,
                backdrop:'static'
            });
        }
    });

    
}  

</script>