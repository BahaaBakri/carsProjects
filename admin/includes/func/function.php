<?php

/* function get title V 1 */

use function PHPSTORM_META\type;

function gettitle() {
	global $pagetitle;
	if (isset($pagetitle)) {
		return $pagetitle;
	} else {
		return "eCommerce";
	}
}

/* function redirect V2 */

function redirect($message, $direction = '', $name= "Custom Page", $seconds = 5) {
		if (empty($direction)) { // user does not wirte url parameter
			$url = "index.php";
			$page = "Home Page";
		} elseif ($direction === "back") {
			echo $_SERVER['HTTP_REFERER'];
			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
				$url = $_SERVER['HTTP_REFERER'];
				echo $_SERVER['HTTP_REFERER'];
				$page = "Previous Page";
			} else {
					$url = "index.php";
					$page = "Dashboard Page";
				}

		} else {
			$url = $direction;
			$page = $name;
		}
		echo "<div class='mycontainer'>";
		echo $message;?>
		<div class='alert alert-info text-center'>You will be directed to <?php echo $page; ?> after <span class='timer'><?php echo $seconds; ?></span> seconds</div>
		<?php echo "</div>";
		header("refresh:$seconds;url=$url");
}

// function isinddb v1


function isindb($select, $table, $value, $userid, $useridval) {
		global $con;
		$statment =$con->prepare("SELECT $select FROM $table WHERE $select = ? AND $userid != ?");
		$statment->execute(array($value, $useridval));
		$result = $statment->rowCount();
		return $result;
	}

// function isAdmin V1

function isadmin($select, $table, $value, $groupid) {
	global $con;
	$statment = $con->prepare("SELECT $select FROM $table WHERE $select = ? AND $groupid = ?");
	$statment->execute(array($value, 1));
	$result = $statment->rowCount();
	return $result;
}
 // function ispending V1

 function ispending($select, $table, $value, $regstatus) {
 		global $con;
 		$statment =$con->prepare("SELECT $select FROM $table WHERE $select = ? AND $regstatus != 1");
 		$statment->execute(array($value));
 		$result = $statment->rowCount();
 		return $result;
 	}

/*
	count_and_fetch(

									table_name

									, type of members ['all', 'admins', 'users', 'pending']

									, functionalty of this function ['count', 'fetch']

									, groupid column name

									, regstatus column name)
 */
function count_and_fetch($table, $type = "all", $functionalty = "fetch", $groupid = "", $regstatus = "", $sort = "", $search = "") {
	global $con;
	// Search
	// echo gettype($search);
	if (!empty($search)) {
		$serachStatment = "AND username Like'%$search%'";
		
	} else {
		$serachStatment = '';
	}
	// echo $serachStatment;
	if ($type === "admins") {
		$statment = $con->prepare("SELECT * FROM $table WHERE $groupid = 1  $serachStatment $sort");
	} elseif ($type === "users") {
		$statment = $con->prepare("SELECT * FROM $table WHERE $groupid != 1  $serachStatment $sort");
	} elseif ($type === "pending") {
		$statment = $con->prepare("SELECT * FROM $table WHERE $groupid != 1 AND $regstatus != 1  $serachStatment $sort");
	} else {
		$statment = $con->prepare("SELECT * FROM $table WHERE 5>2  $serachStatment $sort");
	}
	$statment->execute();

	// check functionalty

	if ($functionalty === "count") {
		return $statment->rowCount();
	} else {
		$rows = $statment->fetchAll();
		return $rows;
	}
}
function count_and_fetch_items($table, $functionalty = "fetch", $status="", $sort = "", $catid = "", $userid = "") {
	global $con;
	if (!empty($catid)) {
		$catStatment = "AND catid_bind = $catid";
		
	} else {
		$catStatment = '';
	}

	if (!empty($userid)) {
		$userOfferdStatment = "AND items.userid_bind = $userid";
		$userSellsStatment = "AND sells.userid_bind = $userid";
	} else {
		$userOfferdStatment = '';
		$userSellsStatment = '';
	}

	if ($table == "items") {
		if ($status == "") {
			$statment = $con->prepare("SELECT * FROM $table WHERE 5>2 $catStatment $sort ");
		} else {
			$statment = $con->prepare("SELECT * FROM $table WHERE status = $status $catStatment  $sort");
		}
		$statment->execute();

	}	else if ($table == "offered") {
		if ($status == "") {
			$statment = $con->prepare("SELECT * FROM items WHERE bought = 0 $catStatment $userOfferdStatment $sort ");
		} else {
			$statment = $con->prepare("SELECT * FROM items WHERE bought = 0 AND status = $status $catStatment $userOfferdStatment  $sort");
		}
		$statment->execute();

	}
	 else if ($table == "sells") {
		if ($status == "") {
			$statment = $con->prepare("SELECT * FROM items INNER JOIN sells ON items.itemid = sells.itemid_bind WHERE 5>2 $catStatment $userSellsStatment $sort ");
		} else {
			$statment = $con->prepare("SELECT * FROM items INNER JOIN sells ON items.itemid = sells.itemid_bind  WHERE status = $status $catStatment $userSellsStatment  $sort");
		}
		$statment->execute();	
	}
	
	// check functionalty

	if ($functionalty === "count") {
		$rows = $statment->rowCount();
	} else {
		$rows = $statment->fetchAll();
		
	}
	return $rows;
}
/*
function select_user_data */

function select_user_data($table, $userid, $useridval, $functionalty = "") {
	global $con;
	$statment = $con->prepare("SELECT * FROM $table WHERE $userid = ?");
	$statment->execute(array($useridval));
	if ($functionalty === "count") {
		 return $statment->rowCount();
	} else {
		$row = $statment->fetch();
		return $row;
	}

}

// function update_user_data

function update_user_data($table,
													$id,
 													$val1 = "",
 													$val2 = "",
													$val3 = "",
													$val4 = "",
													$val5 = "",
													$val6 = "",
													$val7 = "",
													$val8 = "",
													$val9 = "",
													$val10 = "",
													$val11 = "")

												 {
													$alldataupdate = array($val1, $val2, $val3, $val4, $val5, $val6, $val7, $val8, $val9, $val10, $val11);
													$mydataupdate = [];
													foreach ($alldataupdate as  $value) {
														if (!empty($value)) {
															array_push($mydataupdate, $value);
														}
													}
													$mydataupdatestr = implode(", ", $mydataupdate);

													global $con;

													$statment = $con->prepare("UPDATE $table SET $mydataupdatestr WHERE $id");
													$statment->execute();
													return $statment->rowCount();
												}

	function insert_user_data($table,
														$attr1 = "",
														$attr1val = "",
														$attr2 = "",
														$attr2val = "",
														$attr3 = "",
														$attr3val = "",
														$attr4 = "",
														$attr4val = "",
														$attr5 = "",
														$attr5val = "",
														$attr6 = "",
	 													$attr6val = "",
														$attr7 = "",
	 													$attr7val = "",
														$attr8 = "",
	 													$attr8val = "",
														$attr9 = "",
	 													$attr9val = "",
														$attr10 = "",
														$attr10val = "",
														$attr11 = "",
	 													$attr11val = "")

														{
															$name = array($attr1, $attr2, $attr3, $attr4, $attr5, $attr6, $attr7, $attr8, $attr9, $attr10, $attr11);
															$namedata = [];
															$value = array($attr1val, $attr2val, $attr3val, $attr4val, $attr5val, $attr6val, $attr7val, $attr8val, $attr9val, $attr10val,$attr11val);
															$valuedata = [];
															foreach ($name as  $nameval) {
																if (!empty($nameval)) {
																	array_push($namedata, $nameval);
																}
															}
															$namedatastr = implode(", ", $namedata);
															foreach ($value as  $valueval) {
																if (!empty($valueval)) {
																	array_push($valuedata, $valueval);
																}
															}
															$valuedatastr = implode(", ", $valuedata);

															global $con;
															$statment = $con->prepare("INSERT INTO $table ($namedatastr) VALUES ($valuedatastr)");
															$statment->execute();
															return $statment->rowCount();
														}
// function delete_row

function delete_row ($table, $userid, $useridval, $other = "") {
	global $con;
	$statment = $con->prepare("DELETE FROM $table WHERE $userid = $useridval $other");
	$statment->execute();
	return $statment->rowCount();
}

// function get_latest

function get_latest($table, $status = "", $catid ="", $userid = "") {
	global $con;
	// Statments maybe will added to query
	//Cat
	if (!empty($catid)) {
		$catStatment = "AND catid_bind = $catid";
		
	} else {
		$catStatment = '';
	}
	// User
	if (!empty($userid)) {
		$userItemsStatment = "AND items.userid_bind = $userid";
		$userSellsStatment = "AND sells.userid_bind = $userid";
	} else {
		$userItemsStatment = '';
		$userSellsStatment = '';
	}
	// Status
	if (!empty($status)) {
		$statusStatment = "AND status = $status";
		
	} else {
		$statusStatment = '';
	}

	// create query depend on table
	if ($table == "users") {
		$statment = $con->prepare("SELECT * FROM users  ORDER BY userid DESC limit 5");
	} else if ($table == "allItems") {
		$statment = $con->prepare("SELECT * FROM items WHERE 5>2 $catStatment $statusStatment  ORDER BY itemid DESC limit 5");

	} else if ($table == "offered") {
		$statment = $con->prepare("SELECT * FROM items WHERE bought = 0 $catStatment $statusStatment $userItemsStatment  ORDER BY itemid DESC limit 5");

	} else if ($table == "selled") {
		$statment = $con->prepare("SELECT items.* FROM items INNER JOIN sells ON items.itemid = sells.itemid_bind WHERE 5>2 $catStatment $statusStatment $userSellsStatment  ORDER BY sellsid DESC limit 5");

	}
	$statment->execute();
 	$rows = $statment->fetchAll();
	return $rows;

}

function boughtStatus($itemid) {
	global $con;
	$statment =$con->prepare("SELECT bought FROM items WHERE itemid = $itemid");
	$statment->execute();
	$result = $statment->fetchColumn(0);
	return $result;
}

function sum_price($table, $status = "", $catid = "",$userid = "") {
	global $con;
	if (!empty($catid)) {
		$catStatment = "AND catid_bind = $catid";
		
	} else {
		$catStatment = '';
	}

	if (!empty($userid)) {
		$userItemsStatment = "AND items.userid_bind = $userid";
		$userSellsStatment = "AND sells.userid_bind = $userid";
	} else {
		$userItemsStatment = '';
		$userSellsStatment = '';
	}
	if ($table == "items") {
		if ($status == "") {
			$statment =$con->prepare("SELECT SUM(price) From items WHERE 5>2 $catStatment $userItemsStatment");
		} else {
			$statment =$con->prepare("SELECT SUM(price) From items WHERE status = $status $catStatment $userItemsStatment");
		}

	} else 	if ($table == "itemsoffered") {
		if ($status == "") {
			$statment =$con->prepare("SELECT SUM(price) From items WHERE bought = 0 $catStatment $userItemsStatment");
		} else {
			$statment =$con->prepare("SELECT SUM(price) From items WHERE bought = 0 AND status = $status $catStatment $userItemsStatment");
		}

	} else 	if ($table == "itemsbought") {
		if ($status == "") {
			$statment =$con->prepare("SELECT SUM(price) From items WHERE bought = 1  $catStatment $userItemsStatment");
		} else {
			$statment =$con->prepare("SELECT SUM(price) From items WHERE bought = 1 AND status = $status $catStatment $userItemsStatment");
		}

	} else if ($table == "sells") {
		if ($status == "") {
			$statment =$con->prepare("SELECT SUM(price) From items INNER JOIN sells ON items.itemid = sells.itemid_bind WHERE sells.approve = 1 $catStatment $userSellsStatment");
		} else {
			$statment =$con->prepare("SELECT SUM(price) From items INNER JOIN sells ON items.itemid = sells.itemid_bind WHERE  sells.approve = 1  AND status = $status $catStatment $userSellsStatment");
		}
	} else if ($table == "pending") {
		if ($status == "") {
			$statment =$con->prepare("SELECT SUM(price) From items INNER JOIN sells ON items.itemid = sells.itemid_bind WHERE sells.approve = 0 $catStatment $userSellsStatment");
		} else {
			$statment =$con->prepare("SELECT SUM(price) From items INNER JOIN sells ON items.itemid = sells.itemid_bind WHERE  sells.approve = 0  AND status = $status $catStatment $userSellsStatment");
		}
	}
	 else if ($table == "all") {
		if ($status == "") {
			$statment =$con->prepare("SELECT SUM(price) From items LEFT JOIN sells ON items.itemid = sells.itemid_bind  WHERE 5>2 $catStatment $userItemsStatment $userSellsStatment");
		} else {
			$statment =$con->prepare("SELECT SUM(price) From items LEFT JOIN sells ON items.itemid = sells.itemid_bind WHERE status = $status $catStatment $userItemsStatment $userSellsStatment");
		}
	}
	$statment->execute();
	$row = $statment->fetchColumn();
	if ($row !== NULL) {
		return $row;
	} else {
		return 0;
	}

}


function top5User($table, $catid = "") {
	global $con;
	if (!empty($catid)) {
		$catStatment = "AND catid_bind = $catid";
		
	} else {
		$catStatment = '';
	}
	if ($table == "items") {
		$statment = $con->prepare("SELECT users.*, SUM(items.price) as sumation, COUNT(items.itemid) as counting from items INNER JOIN users ON items.userid_bind = users.userid WHERE items.bought = 0 $catStatment GROUP By users.userid ORDER BY SUM(items.price) DESC LIMIT 5");
	} else if ($table == "sells") {
		$statment = $con->prepare("SELECT users.*, SUM(items.price) as sumation, COUNT(sells.sellsid) as counting  from sells INNER JOIN users ON sells.userid_bind = users.userid INNER JOIN items ON sells.itemid_bind = items.itemid WHERE sells.approve=1 $catStatment GROUP BY users.userid ORDER BY SUM(items.price) DESC LIMIT 5 ");
	}
	$statment->execute();
	$row = $statment->fetchAll();
	return $row;
}

function top5Cat($table, $userid = "") {
	global $con;
	if (!empty($userid)) {
		$userOfferdStatment = "AND items.userid_bind = $userid";
		$userSellsStatment = "AND sells.userid_bind = $userid";
	} else {
		$userOfferdStatment = '';
		$userSellsStatment = '';
	}
	if ($table == "items") {
		$statment = $con->prepare("SELECT categories.name, categories.catid, SUM(items.price) as sumation, COUNT(items.itemid) as counting from items INNER JOIN categories ON items.catid_bind = categories.catid WHERE items.bought = 0 $userOfferdStatment GROUP BY categories.catid ORDER BY SUM(items.price) DESC LIMIT 5");
	} else if ($table == "sells") {
		$statment = $con->prepare("SELECT categories.name, categories.catid, SUM(items.price) as sumation, COUNT(sells.sellsid) as counting from items INNER JOIN categories ON items.catid_bind = categories.catid INNER JOIN sells ON sells.itemid_bind = items.itemid WHERE sells.approve=1 $userSellsStatment GROUP BY categories.catid ORDER BY SUM(items.price) DESC LIMIT 5");
	}
	$statment->execute();
	$row = $statment->fetchAll();
	return $row;
}

function ratesAll($table) {
	global $con;
	if ($table == "items") {
		$statment = $con->prepare("SELECT items.datetime, SUM(items.price) as sumation, COUNT(items.itemid) from items WHERE bought = 0 GROUP BY items.datetime ORDER BY items.datetime DESC  LIMIT 5");

	} else if ($table == "sells") {
		$statment = $con->prepare("SELECT sells.selldatetime, SUM(items.price) as sumation, COUNT(sells.sellsid) from items INNER JOIN sells ON items.itemid = sells.itemid_bind where sells.approve=1 GROUP BY sells.selldatetime ORDER BY sells.selldatetime DESC LIMIT 5");
	}
	$statment->execute();
	$row = $statment->fetchAll();
	return $row;

}

function get_cat_items($catid, $functionalty = "") {
	global $con;
	$statment = $con->prepare("SELECT items.*, users.*, categories.name as catname from items INNER JOIN categories ON categories.catid = items.catid_bind INNER JOIN users ON users.userid = items.userid_bind WHERE categories.catid = $catid");
	$statment->execute();
	if (empty($functionalty)) {
		$rows = $statment->fetchAll();
	} else if ($functionalty == "count") {
		$rows = $statment->rowCount();
	}

	return $rows;
}

function ratesCat($table, $catid) {
	global $con;
	if ($table == "items") {
		$statment = $con->prepare("SELECT items.datetime, SUM(items.price) as sumation, COUNT(items.itemid) from items WHERE bought = 0 AND items.catid_bind = $catid GROUP BY items.datetime ORDER BY items.datetime DESC LIMIT 5");

	} else if ($table == "sells") {
		$statment = $con->prepare("SELECT sells.selldatetime, SUM(items.price) as sumation, COUNT(sells.sellsid) from items INNER JOIN sells ON items.itemid = sells.itemid_bind WHERE  sells.approve=1 AND items.catid_bind = $catid GROUP BY sells.selldatetime ORDER BY sells.selldatetime DESC LIMIT 5");
	}
	$statment->execute();
	$row = $statment->fetchAll();
	return $row;	
}

function ratesUser($table, $userid) {
	global $con;
	if ($table == "items") {
		$statment = $con->prepare("SELECT items.datetime, SUM(items.price) as sumation, COUNT(items.itemid) from items WHERE bought = 0 AND items.userid_bind = $userid GROUP BY items.datetime ORDER BY items.datetime DESC LIMIT 5");

	} else if ($table == "sells") {
		$statment = $con->prepare("SELECT sells.selldatetime, SUM(items.price) as sumation, COUNT(sells.sellsid) from items INNER JOIN sells ON items.itemid = sells.itemid_bind WHERE sells.userid_bind = $userid AND sells.approve=1 GROUP BY sells.selldatetime ORDER BY sells.selldatetime DESC  LIMIT 5");
	}
	$statment->execute();
	$row = $statment->fetchAll();
	return $row;
}

// get comments depend on item
function getAllComments($limit="") {
	global $con;
	$statment = $con->prepare("SELECT comments.*, users.*, items.* FROM comments INNER JOIN items ON items.itemid=comments.itemid_bind INNER JOIN users ON users.userid=comments.userid_bind ORDER BY comid DESC  $limit");
	$statment->execute();
	$row = $statment->fetchAll();
	return $row;	
}
function getCommentsItem($itemid, $limit="", $functionalty = "") {
	global $con;
	$statment = $con->prepare("SELECT comments.*, users.*, items.* FROM comments INNER JOIN items ON items.itemid=comments.itemid_bind INNER JOIN users ON users.userid=comments.userid_bind WHERE items.itemid=$itemid $limit");
	$statment->execute();
	if ($functionalty == "count") {
		$row = $statment->rowCount();
	} else {
		$row = $statment->fetchAll();
	}

	return $row;	
}

// get comments depend on cat
function getCommentsCat($catid, $functionalty = "", $limit = "") {
	global $con;
	$statment = $con->prepare("SELECT comments.*, users.*, items.* FROM comments INNER JOIN items ON items.itemid=comments.itemid_bind INNER JOIN users ON users.userid=comments.userid_bind WHERE items.catid_bind=$catid $limit");
	$statment->execute();
	if (empty($functionalty)) {
		$rows = $statment->fetchAll();
	} else if ($functionalty == "count") {
		$rows = $statment->rowCount();
	}
	return $rows;	
}

// get comments depend on cat
function getCommentsUser($userid, $functionalty = "", $limit = "") {
	global $con;
	$statment = $con->prepare("SELECT comments.*, users.*, items.name as name FROM comments INNER JOIN items ON items.itemid=comments.itemid_bind INNER JOIN users ON users.userid=comments.userid_bind WHERE comments.userid_bind=$userid ORDER BY comid DESC $limit");
	$statment->execute();
	if (empty($functionalty)) {
		$rows = $statment->fetchAll();
	} else if ($functionalty == "count") {
		$rows = $statment->rowCount();
	}
	return $rows;	
}
// get image and image content
function getImage($table, $idLabel, $id) {
	global $con;
	$statment = $con->prepare("SELECT image From $table WHERE $idLabel = $id ");
	$statment->execute();
	$row = $statment->fetch();
	return $row;	
}

// get buy details for one item

function get_buy_details($itemid) {
	global $con;
	$statment = $con->prepare("SELECT sells.*, users.* From sells INNER JOIN users ON sells.userid_bind = users.userid WHERE sells.itemid_bind = $itemid ");
	$statment->execute();
	$row = $statment->fetch();
	return $row;		
}

function get_item_details($itemid) {
	global $con;
	$statment = $con->prepare("SELECT 
									items.*, users.*, categories.name AS catname
								FROM 
									items, users, categories
								WHERE
									items.userid_bind = users.userid
								AND
									items.catid_bind = categories.catid

								AND
									items.itemid = $itemid");

	$statment->execute();
	$row = $statment->fetch();
	return $row;
}
function get_user_items($table, $userid, $functionalty = "") {
	global $con;
	if ($table == "items") {
		$statment = $con->prepare("SELECT items.*, users.*, categories.name as catname from items INNER JOIN users ON users.userid = items.userid_bind INNER JOIN categories ON categories.catid = items.catid_bind WHERE  items.userid_bind=$userid");
	} else	if ($table == "itemsoffered") {
		$statment = $con->prepare("SELECT items.*, users.*, categories.name as catname from items INNER JOIN users ON users.userid = items.userid_bind INNER JOIN categories ON categories.catid = items.catid_bind WHERE bought = 0  items.userid_bind=$userid");
	} else	if ($table == "itemsbought") {
		$statment = $con->prepare("SELECT items.*, users.*, categories.name as catname from items INNER JOIN users ON users.userid = items.userid_bind INNER JOIN categories ON categories.catid = items.catid_bind WHERE bought = 1  items.userid_bind=$userid");
	} else if ($table == "sells") {
		$statment = $con->prepare("SELECT items.*, sells.*, users.*, categories.name as catname  from items INNER JOIN sells ON items.itemid=sells.itemid_bind INNER JOIN users ON users.userid = items.userid_bind INNER JOIN categories ON categories.catid = items.catid_bind WHERE sells.approve = 1 AND sells.userid_bind=$userid");
	}  else if ($table == "pending") {
		$statment = $con->prepare("SELECT items.*, sells.*, users.*, categories.name as catname  from items INNER JOIN sells ON items.itemid=sells.itemid_bind INNER JOIN users ON users.userid = items.userid_bind INNER JOIN categories ON categories.catid = items.catid_bind WHERE sells.approve = 0 AND sells.userid_bind=$userid");
	} else if ($table == "all") {
		$statment = $con->prepare("SELECT items.*,  sells.*, users.*, categories.name as catname from items LEFT JOIN sells ON items.itemid=sells.itemid_bind INNER JOIN users ON users.userid = items.userid_bind INNER JOIN categories ON categories.catid = items.catid_bind WHERE items.userid_bind=$userid
									UNION
								SELECT items.*, sells.*, users.*, categories.name as catname  from items INNER JOIN sells ON items.itemid=sells.itemid_bind INNER JOIN users ON users.userid = items.userid_bind INNER JOIN categories ON categories.catid = items.catid_bind WHERE sells.userid_bind=$userid");

	}
	$statment->execute();
	if ($functionalty == "count") {
		$row = $statment->rowCount();
	} else {
		$row = $statment->fetchAll();
	}
	return $row;
}
?>
