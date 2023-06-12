<!DOCTYPE html>
<html>
<head>
<?php
 require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
 include 'includes/header.php';
 include 'includes/decodefees.php';//includes the script for decoding and getting fees from the databse
?>
</head>
<body>
        <div class="container">
                <div class="jumbotron">
                <table>
                   <tbody>
                        <tr>
                        <td> <img src="school_images/hillstoplogo.png" alt="Schoollogo"> </td>
                        <td>
                          <div id="schoolname">HILLSTOP ACADEMY MIRERA</div>
                          <div id="motto">Always merry and bright.</div>
                        </td>
                        </tr>
                    </tbody>
                </table>
                </div><!--Closing jumbotron div-->

                <?php include 'includes/navigation.php'?>

                <section id="carousel">

                        <div class="row">

                        <div class="col-md-8" style="padding-right: 0px;">
                
                        <div class="bd-example">
                                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                                        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                                        <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                <div class="carousel-item active">
                                        <img src="school_images/hillstopgames.jpg" class="d-block w-100" alt="National Games">
                                        <div class="caption d-none d-md-block">
                                        <h5>The Hillstop Queens</h5>
                                        <p>Hillstop Queens at the County games.</p>
                                        </div>
                                </div>
                                <div class="carousel-item">
                                        <img src="school_images/hillstopboys.jpg" class="d-block w-100" alt="The Boys Squard">
                                        <div class="caption d-none d-md-block">
                                        <h5>The HIllstop Boys Squard.</h5>
                                        <p>The boys at the county games, they came out with confidence and carried the flag high.</p>
                                        </div>
                                </div>
                                <div class="carousel-item">
                                        <img src="school_images/hillstoplogo.png" class="d-block w-100" alt="School Logo">
                                        <div class="caption d-none d-md-block">
                                        <h5>The new school logo</h5>
                                        <p>Our school is undergoing a face lift and this is our new logo.</p>
                                        </div>
                                </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                                </a>
                                </div>
                                </div>

                                </div><!--closing col-md-8 div-->

                                <div class="col-md-4" style="padding-left:0px;margin-left:0px;">
                                        <div id="school_news">

                                                <h5 class="text-center">SCHOOL NEWS & EVENTS.</h5> <hr>

                                                <div id="accordion">
                                                <?php 
                                                $query=$db->query("SELECT * FROM news ORDER BY id DESC LIMIT 5");
                                                while($queryData=mysqli_fetch_array($query)) :
                                                ?>

                                                        <h6> <?=$queryData['headline'];?> </h6>
                                                        <div id="accordionBody">
                                                            <p> <?=$queryData['news'];?> </p>
                                                        </div>     
                                                <?php endwhile;?>   

                                                </div>
  

                                        </div><!--Closing school_news div-->
                                </div><!--closing col-md-4 div-->

                                </div><!--closing row div-->

                </section><!--closing carousel section-->

                <section id="about_us">
                        <div class='container-fluid'>
                                 <h4 class="text-center">ABOUT US.</h1> 

                                <div class="row">
                                        <div class="col-md-4 wow fadeInLeftBig">
                                                <div id="contentWrapper">
                                                        <h6 id="header">SCHOOL MOTTO</h6>
                                                        <p id="content"></p>
                                                </div>
                                        </div>
                                        <div class="col-md-4 wow flipInX">
                                                <div id="contentWrapper">
                                                        <h6 id="header">SCHOOL MISSION</h6>
                                                        <p id="content"></p>
                                                </div>
                                        </div>
                                        <div class="col-md-4 wow fadeInRightBig">
                                                <div id="contentWrapper">
                                                        <h6 id="header">SCHOOL VISION</h6>
                                                        <p id="content"></p>
                                                </div>
                                        </div>
                                </div>
                        </div>
                       


                </section><!--Closing about_us section-->
               

                <section id="contact_us">
                   <h4 class="text-center">CONTACT US.</h1>
                   <div class="contact_div wow flipInX" data-wow-duration='2s'>
                        <div id="notificationsDiv"></div>                           
                        <form action="index.php#contact_us" method="POST">
                        <div class="form-group">
                                <label for="name">Name*</label>
                                <input type="text" name="name" class="form-control" required=required>
                        </div>
                        <div class="form-group">
                                <label for="phone">Phone Number*</label>
                                <input type="text" name="phone" class="form-control" required=required>
                        </div>
                        <div class="form-group">
                                <label for="message">Your Message*</label>
                                <textarea name="message" class="form-control" id="message" rows="5" required=required></textarea>
                        </div>
                        <div class="form-group">                                                    
                        <button class="btn btn-primary btn-block" type="submit">
                           <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                           Submit
                        </button>       
                        </div>
                        </form>                           
                   </div><!--closing row div-->
                </section>

                <section id="gallery">
                <h4 class="text-center">GALLERY.</h1>
                       <div style="padding:10px;">
                        <div class="row">                                
                                <?php 
                                $galleryquery = $db->query("SELECT * FROM school_gallery ORDER BY id");
                                while($queryArray = mysqli_fetch_array($galleryquery)) :
                                ?>
                                <div class="col-md-3 wow rotateInDownLeft" style="margin-right:0px;">
                                        <div id="imageContainer" class="text-center">
                                                <img src="<?=$queryArray['image'];?>" class="galleryImage" alt="Image" style="height:240px;width:206px;">
                                                <h6 class="imagedetails" id="<?=$queryArray['description'];?>"> <b><?=$queryArray['description'];?></b></h6>
                                        </div>
                                </div><!--Closing col-md-3 div-->
                                <?php endwhile;?>
                          
                        </div><!--Closing row div-->
                        </div>
                </section><!--Closing gallery div-->
                
                <?php include 'includes/footer.php';?>

        </div><!--closing container div tag-->

   
</body> 
</html>

<script>
 function closeviewImageModal(){
  jQuery('#viewImagemodal').modal("hide");
    location.reload(true);
  }

        jQuery(document).ready(function(){    
                //when the submit buttonis clicked
             jQuery("form").submit(function(event){
                event.preventDefault();
                var data = jQuery(this).serialize();
                jQuery(".spinner-border").addClass("active");//makes the spinner visible
                jQuery.ajax({
                        url:'/school/helpers/sendmessage.php',
                        method:'post',
                        data:data,
                        success:function(data){
                           jQuery(".spinner-border").removeClass("active");//makes the spinner invisible
                           jQuery('#notificationsDiv').html();
                           jQuery('#notificationsDiv').html(data);
                           jQuery("form").reset();
                        },
                        error:function(){
                          alert("Something went wrong trying to send message!");
                        }
                });
             });               

                //VIEWING SCHOOL iMAGE
                jQuery('.galleryImage').click(function(){
                        var imageSource = jQuery(this).attr("src");//getx the current image souce
                        var imageDetails = jQuery(".imagedetails").attr("id")//gets the image name/description
                        jQuery.ajax({
                                url:'/school/modals/viewimage.php',
                                data:{imageSource:imageSource,imageDetails:imageDetails},
                                method:'post',
                                success:function(data){
                                      jQuery('body').append(data);
                                      jQuery('#viewImagemodal').modal({
                                              keyboard:false,
                                              backdrop:'static'
                                      });                                          
                                },
                                error:function(){
                                        alert("Something went wrong trying to view image");
                                },
                        });
                       
                });

                //sTATIC NAVBAR
                jQuery(window).scroll(function(){
                        var scroll = jQuery(document).scrollTop();
                        if(scroll >= 101){
                               jQuery('.navbar').removeClass('navbar-fixed-top').addClass('sticky-top');
                               jQuery('.navbar').css('opacity','.7');
                        }else{
                                jQuery('.navbar').css('opacity','1');
                        }
                });

                //SCROLLING SMOOOTH FRO NAVIGATION
                jQuery('.scroll').click(function(event){
                        event.preventDefault();
                        jQuery('body,html').animate({
                                scrollTop:jQuery(this.hash).offset().top
                        }, 1500);
                });               
                
                jQuery('.galleryImage').click(function(){
                  jQuery('#viewImage').fadeIn();
                });

                jQuery('.carousel').carousel({
                  interval: 10000
                });

                jQuery( "#accordion" ).accordion({
                  collapsible: true
                });               
                
        });
</script>