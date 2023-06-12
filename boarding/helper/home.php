<div id="mainDormsDiv">
    <div class="text-center row">   
        <?php
        $dormQuery = $db->query("SELECT * FROM dorms");
        while($queryData = mysqli_fetch_array($dormQuery)) :?>
            <div class="col-md-4">                
                <div id="head">
                    <h5>Dorm: <?=strtoupper($queryData['dorm']);?></h5>
                </div>
                <div id="body">
                    <?php 
                        $dormId = (int)$queryData['id'];
                        $studentCount = mysqli_num_rows($db->query("SELECT * FROM students WHERE dorm='$dormId'"));
                    ?>
                    <label class="counter-count"><?=$studentCount;?></label> <h4> Students </h4> 
                </div>
                <div id="footer">                
                    <a href="/school/boarding/dorms.php?dormId=<?=$queryData['id'];?>" class="btn btn-default students" id="<?=$queryData['id'];?>" title="Click to edit form info."> <i class="fas fa-info-circle"></i> Dorm Info. </a>
                </div>

            </div>
        <?php endwhile; ?>        
    </div>
</div><!--Closing mainDormsDiv-->
<script>
var count = $(".counter-count").html();
$('.counter-count').each(function () {
    $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {            
        //change count up speed here
        duration: 4000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});

</script>


