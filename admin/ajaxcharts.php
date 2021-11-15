<?php
 include "../connect.php";
 include "includes/func/function.php";

 // Get top5 users chart data
 if (isset($_POST["chart"]) && $_POST["chart"] == "top5UserItems") {
    // echo "jsdhjsdhj";
    $top5UserItems = top5User("items");
    // print_r($top5UserItems);
    // foreach($top5UserItems as $top5UserItem) {
    //     base64_decode($top5UserItem['avatar']);
    // }
    $json = json_encode($top5UserItems);
 }
if (isset($_POST["chart"]) && $_POST["chart"] == "top5UserSells") {
    $top5UserSells = top5User("sells");
    $json = json_encode($top5UserSells);
}
/**********************************/

 // Get top5 users chart data per cat
 if (isset($_POST["chart"]) && $_POST["chart"] == "top5UserItemsCat") {
    $catid = $_POST['catid'];
    $top5UserItemsCat = top5User("items", $catid);
    $json = json_encode($top5UserItemsCat);
 }
if (isset($_POST["chart"]) && $_POST["chart"] == "top5UserSellsCat") {
    $catid = $_POST['catid'];
    $top5UserSellsCat = top5User("sells", $catid );
    $json = json_encode($top5UserSellsCat);
}
/**********************************/
 // Get top5 users chart data per cat
 if (isset($_POST["chart"]) && $_POST["chart"] == "top5CatItemsUser") {
    $userid = $_POST['userid'];
    $top5CatItemsUser = top5Cat("items", $userid);
    $json = json_encode($top5CatItemsUser);
 }
if (isset($_POST["chart"]) && $_POST["chart"] == "top5CatSellsUser") {
    $userid = $_POST['userid'];
    $top5CatSellsUser = top5Cat("sells", $userid );
    $json = json_encode($top5CatSellsUser);
}
/**********************************/

// Get rate of items and sells chart data

if (isset($_POST["chart"]) && $_POST["chart"] == "rateItemsSells") {

    $chartDataItems = ratesAll('items');
    $chartDataSells = ratesAll('sells');
    $rateItemsSells = [
        "items" => $chartDataItems,
        "sells" => $chartDataSells 
    ];
    $json = json_encode([$rateItemsSells]);
}

/******************************/
// Get top5 categories data
if (isset($_POST["chart"]) && $_POST["chart"] == "top5CatItems") {
    $top5CatItems = top5Cat("items");
    $json = json_encode($top5CatItems);
}
if (isset($_POST["chart"]) && $_POST["chart"] == "top5CatSells") {
    $top5CatSells = top5Cat("sells");
    $json = json_encode($top5CatSells);
}
/*********************************/
// Get category rate of items and sells chart data
if (isset($_POST["chart"]) && $_POST["chart"] == "rateCatItemsSells") {
    $catid = $_POST['catid'];
    $chartDataItems = ratesCat('items', $catid);
    $chartDataSells = ratesCat('sells', $catid);
    $rateCatItemsSells = [
        "items" => $chartDataItems,
        "sells" => $chartDataSells 
    ];
    $json = json_encode([$rateCatItemsSells]);
}
/*********************************/
// Get category rate of items and sells chart data
if (isset($_POST["chart"]) && $_POST["chart"] == "rateUserItemsSells") {
    $userid = $_POST['userid'];
    $chartDataItems = ratesUser('items', $userid);
    $chartDataSells = ratesUser('sells', $userid);
    $rateUserItemsSells = [
        "items" => $chartDataItems,
        "sells" => $chartDataSells 
    ];
    $json = json_encode([$rateUserItemsSells]);
}
echo $json;
?>