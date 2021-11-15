<?php
/*function getcat()
	functionalty: fetch all categories

*/
function getcat() {
	global $con;
	$statment =$con->prepare("SELECT * FROM categories ORDER BY catid ASC");
	$statment->execute();
	$result = $statment->fetchAll();
	return $result;

}
/*function getitemsdepend
	functionalty: fetch all items depend on category or user
	parameters[1]: the field name in DB (catid_bind or userid_bind)
	parameters[2]: id for this category or user

*/
function getitemsdepend($valuename, $value) {
	global $con;
	$statment =$con->prepare("SELECT * FROM items WHERE $valuename = ? ORDER BY itemid DESC");
	$statment->execute(array($value));
	$result = $statment->fetchAll();
	return $result;
}
/*function checkuserstatus
	functionalty: check if user is activate or not
							return 1 ==> activate
							return 0 ==> Not activate
	parameters[1]: username
*/
function checkuserstatus($user) {
	global $con;
	$statment =$con->prepare("SELECT userid FROM users WHERE username = ? AND regstatus = 1");
	$statment->execute(array($user));
	return $statment->rowCount();
}

/*function fetchuserdata
	functionalty: fetch all user data
	parameters[1]: username
*/

function fetchuserdata($user) {
	global $con;
	$statment =$con->prepare("SELECT * FROM users WHERE username = ?");
	$statment->execute(array($user));
	return $statment->fetch();
}

/*function getcomitemdependuser
	functionalty: fetch all comments and items for this comments depend user
	parameters[1]: username
*/
function getcomitemdependuser($value) {
	global $con;
	$statment =$con->prepare("SELECT comments.*, items.name FROM comments INNER JOIN items ON comments.itemid_bind = items.itemid WHERE comments.userid_bind = ? ORDER BY comments.comid DESC");
	$statment->execute(array($value));
	$result = $statment->fetchAll();
	return $result;
}
function getNumberOfNotification($userid) {
	global $con;
	$statment =$con->prepare("SELECT notid FROM notification WHERE notification.userid_not = $userid AND showen = 0");
	$statment->execute();
	$result = $statment->rowCount();
	return $result;
}
function get_item_user ($itemid) {
	global $con;
	$statment = $con->prepare("SELECT userid FROM users INNER JOIN items ON users.userid=items.userid_bind WHERE  items.itemid = $itemid");
	$statment->execute();
	$result = $statment->fetch()['userid'];
	return $result;
}
