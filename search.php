<?php  

$center_lat=37;//$_POST['lat'];
$center_lng=-122;//$_POST['lng'];
$radius=25;//$_POST['radius'];

include 'credential.php';

session_start();
$servername= $_SESSION['servername'];   
$database=$_SESSION['database'];
$username=$_SESSION['username'];
$password=$_SESSION['password'];

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("stores");
$parnode = $dom->appendChild($node);

try{

// Opens a connection to a mySQL server
$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



$stmt = $conn->prepare("SELECT name,address, lat,lng,( 3959 * acos( cos( radians(:LAT) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(:LNG) ) + sin( radians(:LAT) ) * sin( radians( lat ) ) ) ) AS distance FROM stores HAVING distance < :RADIUS ORDER BY distance LIMIT 0 ,20;");


$stmt->bindParam(':LAT', $center_lat);
$stmt->bindParam(':LNG', $center_lng);
$stmt->bindParam(':RADIUS', $radius);

$stmt->execute();

header("Content-type: text/xml");

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $row) {
    $node = $dom->createElement("store");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("name", $row['name']);
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("distance", $row['distance']);
  //echo $row['name']." ".$row['distance'];
}
echo $dom->saveXML();
//$dom->save("stores.xml");


}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

    /* close statement */
    $stmt->close();


?>