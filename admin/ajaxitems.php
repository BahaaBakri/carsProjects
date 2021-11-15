<?php
 include "connect.php";
 include "includes/func/function.php";
 $status_array = array("New", "Like New", "Old");
 if (isset($_GET['status']) && in_array($_GET['status'], $status_array)) {
    $status = $_GET['status'];
 }
 $statment = $con->prepare("SELECT items.*, users.username, categories.name as catname FROM users RIGHT OUTER JOIN items ON users.userid = items.userid_bind LEFT OUTER JOIN categories ON categories.catid = items.catid_bind WHERE status = ? ORDER BY itemid DESC");
 $statment->execute(array($status));
 $rows = $statment->fetchAll();
 /*foreach($rows as $row) {
    $row['image'] = (base64_encode($row['image']));
 }*/
 $json = json_encode($rows);
 echo $rows;