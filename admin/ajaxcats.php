<?php
 include "connect.php";
 include "includes/func/function.php";
 $sort_array = array("ASC", "DESC");
 if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
  $sort = $_GET['sort'];
 }
 $rows = count_and_fetch("categories", "all", "fetch", "", "", "ORDER BY ordering $sort");
 $json = json_encode($rows);
 echo $json;
