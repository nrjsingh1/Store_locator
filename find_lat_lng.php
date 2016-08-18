<?php

$add=$_POST['add'];
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAzVl02-CpAwjdQwm9qNTbBqD4FHiUwm0"
            type="text/javascript"></script>

<script type="text/javascript">
var geocoder = new google.maps.Geocoder();
var address = "<?php echo $add;?>";
geocoder.geocode( { 'address': address}, function(results, status) {
  if (status == google.maps.GeocoderStatus.OK) {
    var latitude = results[0].geometry.location.lat();
    var longitude = results[0].geometry.location.lng();
    //alert(latitude);
    //alert(longitude);
    var retUrl="search.php?latitude="+latitude+"&longitude="+longitude;
    //alert(retUrl);
    window.location = retUrl;
 //   	$.post("search.php", {"latitude":latitude,"longitude":longitude}, function(result){
	// 	alert(result);
	// });
    //document.getElementById("p1").innerHTML=latitude;
    //document.getElementById("p2").innerHTML=longitude;
   } 
 }); 
</script>


</head>
<body> 


 
  </body> 
 </html> 