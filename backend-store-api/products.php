<?php
header('Content-type: application/json');
include 'db.php';
$query=$conn->prepare("SELECT *FROM products");
$query->execute();
$result=$query->get_result();
$products =[];
if($result && $result->num_rows > 0){
    while($row =$result->fetch_assoc()) {
       $products[] = $row;
    }
}

echo json_encode([
    "status" =>"success",
    "data" => $products
]);
?>