<?php
session_start();
 include "../connect.php";
 include "includes/func/function.php";
 include "../admin/includes/func/function.php";
$uid = $_SESSION['uid'];
   if (isset($_POST['func']) && ($_POST['func'] == "add")) {
    $itemid = $_POST['itemid'];
    $userid = get_item_user($itemid);
     $comment = $_POST['comment'];
     $check = insert_user_data("comments", "comment", "'$comment'", "datetime", "now()", "itemid_bind", "$itemid", "userid_bind", "$uid");
     // add notification
     $not =  insert_user_data("notification", "notstatus", "'comment'", "notdatetime", "now()", "itemid_bind", "$itemid", "userid_bind", "$uid", "userid_not", "$userid");
    //  $json = json_encode($check);
    //  echo $json;
    }
    if (isset($_POST['func']) && ($_POST['func'] == "edit")) {
       $comid = $_POST['comid'];
       $comment = $_POST['comment'];
       $check = update_user_data("comments", "comid = '$comid'", "comment = '$comment'" );
    }
    if (isset($_POST['func']) && ($_POST['func'] == "delete")) {
      $comid = $_POST['comid'];
      $check = delete_row("comments", "comid", $comid);
   }
 echo $check;
