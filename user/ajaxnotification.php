<?php
session_start();
 include "../connect.php";
 include "includes/func/function.php";
 include "../admin/includes/func/function.php";
 $uid = $_SESSION['uid'];
 global $con;
 $statment1 = $con->prepare("UPDATE notification SET notification.showen = 1 WHERE notification.userid_not = $uid ");
 $statment1->execute();
 $statment2 = $con->prepare("SELECT notification.*, users.*, items.* FROM notification INNER JOIN items ON items.itemid=notification.itemid_bind INNER JOIN users ON users.userid=notification.userid_bind WHERE notification.userid_not=$uid ORDER BY notid DESC");
 $statment2->execute();
 $rows = $statment2->fetchAll();
 $json = json_encode($rows);
 echo $json;

