<?php ob_start();?>
<!-- Modal -->
<div class="modal fade" id="weather-forecast-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Weather Forecast</h5>
        <button type="button" class="close"  onclick="closeForecastModal()" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div id="forecastDiv">
            <form action="#" id="weatherForecastDiv" method="post">
                <div class="form-group">
                    <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2" required=required>
                    <div class="input-group-append ml-2">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-cloud-sun"></i> View Forecast</button>
                    </div>
                    </div>
                </div>
            </form> 
            <h1><?php echo date("h:m A");?></h1>
            <div id="showForecast"></div>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
<?=ob_get_clean();?>
 <script>

jQuery("#weather-forecast-modal").on("shown.bs.modal",function(){
    jQuery("#forecastDiv").find("input[type='text']").focus();

    jQuery("#weatherForecastDiv").submit(function(e){
        e.preventDefault();
        var city = jQuery(this).find("input[type='text']").val();//gets the name that hes been provided
        var api_key = "50e12a5486fdebe760635cd5d17828f0";//my api key
        jQuery.ajax({
            url:'http://api.openweathermap.org/data/2.5/weather',
            method:'get',
            data:{q:city, appid:api_key, units:'metric'},
            success:function(data){
                var forecast = "";
                jQuery.each(data.weather,function(index, val){//loop only through the weather array from the data object
                    forecast += '<p><b>'+data.name+"</b><img src="+val.icon+".png"+"></p><b>"+data.main.temp+"&deg;C </b>"+ "| "+val.main+", "+val.description;
                });
                jQuery("#showForecast").html(forecast);
            },
            error:function(){
                alert('Thre was a problem trying to get weather info. Check the city name you have provided');
            }
        });
    });               
});
 </script>
