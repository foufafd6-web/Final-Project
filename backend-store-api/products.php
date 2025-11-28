<?php
header('Content-type: application/json');
include 'db.php';
$query=$conn->prepare("SELECT *FROM products");
$query->execute();
$result=$query->get_result();
//to store products in the array
$products =[];
//add to the array
if($result && $result->num_rows > 0){
    while($row =$result->fetch_assoc()) {
       $products[] = $row;
    }
}
//return json response
echo json_encode([
    "status" =>"success",
    "data" => $products
]);
?>