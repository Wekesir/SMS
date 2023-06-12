<!DOCTYPE html>
<html>
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/school/admin/header.php'; ?>
</head>
<body class="bg-light">
<div class="container-fluid" style="background-color:white;height: 100vh;overflow:auto">   
    <div id="backgroundImageDiv"></div>
    <div id="contentDiv">
        <h2 class="text-center"><span class="text-danger">Oops! </span>This WEB Application <span class="text-danger">CAN NOT</span> be accessed via phone.</h2>
    </div>
</div>
</body>
</html>
<style>
#contentDiv{
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
  color: white;
  font-weight: bold;
  border: 3px solid #f1f1f1;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 2;
  width: 80%;
  padding: 20px;
  text-align: center;
}
#backgroundImageDiv{
    background:url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRMo5iBCNfYlzzQ-rr43ojUYIxxGi6ECQBL8Q&usqp=CAU");
    background-size: cover;
    background-position:center;
    background-repeat:no-repeat;
    width: 100%;
    height: 100vh;
    filter: blur(2px);
    -webkit-filter: blur(2px);
}
</style>





