<?php

// login page for admins

	session_start();

	// Variables

	$loginfaild = "";
	$nonavbar = "";
	$pagetitle = "Login";

	// if user in session when open page direct
	if (isset($_SESSION['username'])) {
			header('location: dashbord.php');
			exit;
	}
	include "ini.php";

	//include "includes/lang/ar.php";

	if ($_SERVER['REQUEST_METHOD'] === "POST") {

		// register username and password

		$username = $_POST['username'];
		$password = $_POST['password'];
		$hashedpass = sha1($password);

		// requist a query from DB to check if the user is admin

		$stmt = $con->prepare("SELECT userid, username, password from users WHERE username = ? AND password = ? AND groupid = 1");
		$stmt->execute(array($username, $hashedpass));
		$row = $stmt->fetch();

		// if num of query from DB > 0 it means we found an admin

		if ($stmt->rowCount() > 0) {
			// Admin

			//echo "hello " . $username . "    " . $hashedpass;

			// regist username in session

			$_SESSION['username'] = $username;

			// regist userid in session

			$_SESSION['userid'] = $row["userid"];

			// if user in session when login

			if (isset($_SESSION['username'])) {
				header('location: dashbord.php');
				exit;
			}


		} else {

			// Not Admin
			$loginfaild = "Your username or password is not correct try again";
		}
	}
?>
<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
	<h4>Admins Login</h4>
	<input type="text" class="form-control form-control-lg " autocomplete="off" placeholder="Username" name="username"/>
	<input type="password" class="form-control form-control-lg" autocomplete="new-password" placeholder="Password" name="password" />
	<input type="submit" value="Login" class="btn btn-lg btn-primary btn-block" />
	<label class="text-danger"><?php echo $loginfaild; ?></label>
</form>

<?php
	include $temp . "footer.php";
?>
