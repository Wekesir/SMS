<!DOCTYPE html>
<html>
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php'; include dirname(__DIR__).'/admin/header.php'; $levelQuery = $db->query("SELECT * FROM `grade`"); ?>
</head>
<body>
    <?php include dirname(__DIR__).'/admin/navigation.php';?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"> <?php include dirname(__DIR__).'/admin/left.php';?> </div>
            <!--Closing col-md-3 div-->
            <div class="col-md-9 px-3" id="wrapper"> 
                <div class="row border-bottom border-primary pb-2">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Select Level:</span>
                            </div>
                            <select class="custom-select" id="inputGroupSelect01">
                                <?php while($levelData = mysqli_fetch_array($levelQuery)) :?>
                                <option value="<?=$levelData['id']?>"><?=$levelData['grade']?></option>
                                <?php endwhile;?>
                            </select>
                            <div class="input-group-prepend ml-1">
                                <button class="btn btn-primary" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Load
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="button" id="createTimeTableBtn" class="btn btn-primary btn-sm my-auto"
                            title="create a new timetable"><i class="fas fa-plus"></i> Create Timetable</button>
                        <button type="button" id="timetaleScheduleBtn" class="btn btn-sm btn-success">TT
                            Schedule</button>
                    </div>
                </div>
                <div class="row">
                    <div id="containerDiv"></div>
                    <div id="scheduleTimetableDiv" class="border border-primary shadow-lg p-3 mb-5 bg-white rounded">
                                             
                        
                    </div>
                </div>
            </div>  <!--Closing col-md-9 div-->          
        </div> <!--Closing row dic-->       
    </div>   <!--closing container div--> 
    <?php include dirname(__DIR__).'/admin/footer.php';?>
</body>
</html>
