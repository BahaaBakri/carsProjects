<?php 
$year = $_POST['year'];
$Kilometers = $_POST['Kilometers'];
$transmission = $_POST['transmission'];
$owner = $_POST['owner'];
$cc = $_POST['cc'];
$power = $_POST['power'];
$seats = $_POST['seats'];
$fuel = $_POST['fuel'];

$myData = (object) [
    "year" => $year,
    "Kilometers" => $Kilometers,
    "transmission" => $transmission,
    "owner" => $owner,
    "cc" => $cc,
    "power" => $power,
    "seats" => $seats,
    "fuel" => $fuel
];
// print_r($myData);
shell_exec("python car_rent.py "  . $myData);



?>