<?php
	// Session
	session_start();

	// Variables
	$loginfaild = "";

  $do = $_GET['do'];

  if ($do === "login") {
      $pagetitle = "Login";
    }
  elseif ($do === "signup") {
      $pagetitle = "Sign up";
    }

  // if user in session when open page direct
  if (isset($_SESSION['user'])) {
      header('location: index.php');
      exit;
  }
  include "ini.php";

	if ($_SERVER['REQUEST_METHOD'] === "POST") {

		if (isset($_POST['login'])) {
			// you come from login form
			// register username and password
			$username = $_POST['username'];
			$password = $_POST['password'];
			$hashedpass = sha1($password);

			// requist a query from DB to check if the user is exists

			$stmt = $con->prepare("SELECT userid, username, password from users WHERE username = ? AND password = ?");
			$stmt->execute(array($username, $hashedpass));

			// if num of query from DB > 0 it means we found an user

			if ($stmt->rowCount() > 0) {
				$out = $stmt->fetch();
				// regist username in session

				$_SESSION['user'] = $username;
				$_SESSION['uid'] = $out['userid'];


				// if user in session when login

				if (isset($_SESSION['user'])) {
					header('location: index.php');
					exit;
				}


			} else {

				// Not Correct
				$loginfaild = "Your username or password is not correct try again";
			}
		} else {
			// you come from signup form
			// register all user data
			$username = $_POST['username'];
			$fullname = $_POST['fullname'];
			$password = $_POST['password'];
			$conpassword = $_POST['conpassword'];
			$email = $_POST['email'];

			$errormessg = array();
			// validate in backend
			// username
			if (empty($username)) {
				array_push($errormessg, "Please fill out your username");
			}
			if (empty($fullname)) {
				array_push($errormessg, "Please fill out your fullname");
			}
			if (strlen($username) < 3) {
				array_push($errormessg, "Please type at least 3 letters in username");
			}

			// password
			if (empty($password)) {
				array_push($errormessg, "Please fill out your password");
			}

			if (!preg_match("/^[a-zA-Z0-9]*$/", $password)) {
				array_push($errormessg, "Password must contains numbers and letters only");
			}

			//confirm password
			if ($password !== $conpassword) {
				array_push($errormessg, "Password must be mutched in two fields");
			}

			//email
			$emailsanitize = filter_var($email, FILTER_SANITIZE_EMAIL);
			if (!filter_var($emailsanitize, FILTER_VALIDATE_EMAIL)) {
				array_push($errormessg, "Email must contains [@ .]");
				array_push($errormessg, "Email must contains numbers, letters and [@._-] only");
			}
			// Upload image
			if(!empty($_FILES["image"]["name"])) { 
				// Get file info
				// echo "cccccccccccccc"; 
				$fileName = $_FILES['image']['name'];
				$fileBaseName = basename($_FILES["image"]["name"]); 
				$target_dir = "../dataset/uploaded/uploaded_avatar/";
				$target_file = $target_dir . $fileBaseName;
				$fileType = pathinfo($fileBaseName, PATHINFO_EXTENSION); 
				
				// Allow certain file formats 
				$allowTypes = array('jpg','png','jpeg','gif'); 
				if(in_array($fileType, $allowTypes)){ 
					move_uploaded_file($_FILES['image']['tmp_name'],$target_dir.$fileName);
				} else{ 
				array_push($errorarray, "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.");
				} 
			} else {
				// echo "eeeeeeeeeee"; 
				$fileName = '';
			}
			echo($fileName);
			if (!empty($errormessg)) {
				// print error messages
				echo "<div class='mt-5'>";
				foreach ($errormessg as $messg) {
					echo "<div class='alert alert-danger' style='width:450px'>" . $messg . "</div>";
				}
				echo "</div>";
			} else {
				// validate true

				// check if username in DB

				if (isindb("username", "users", $username, "userid", -1) > 0) {

					// username is exisits in DB
					echo "<div class='alert alert-danger text-center m-auto' style='width:fit-content'>";
						echo "Username $username is exists try other username";
					echo "</div>";

				} else {
					$sha1password = sha1($password);
					$check = insert_user_data("users", "username", "'$username'", "fullname", "'$fullname'", "password", "'$sha1password'", "email", "'$emailsanitize'", "regdatetime", "now()", "avatar", "'$fileName'");
					if ($check > 0) {
						$stmt = $con->prepare("SELECT userid from users WHERE username = ?");
						$stmt->execute(array($username));
						$out = $stmt->fetch();
						$_SESSION['user'] = $username;
						$_SESSION['uid'] = $out['userid'];
						if (isset($_SESSION['user'])) {
							header('location: index.php');
							exit;
						}
					}
				}
			}
		}
  }
  if ($do === "login") {


        // LOCIN PAGE ?>
				<div class="logindiv">
          <form class="login" novalidate action="<?php echo $_SERVER['PHP_SELF']  . '?do=login'; ?>" method="post">
            <div class="inputparent">
              <input type="text" class="form-control user" autocomplete="off" placeholder="Username" name="username" required="required"/>
              <p class="col-md-9 mr-auto mb-3 validate reqvalidate">Please fill out your username</p>
            </div>
            <div class="inputparent">
              <input type="password" class="form-control pass" autocomplete="new-password" placeholder="Password" name="password" required="required"/>
              <p class="col-md-9 mr-auto mb-3 validate reqvalidate">Please fill out your password</p>
              <a class ='btn showpass showen eye'><i class='fa fa-eye fa-lg'></i></a>
							<a class ='btn showpass seye'><i class='fa fa-eye-slash fa-lg'></i></a>
            </div>
            <input type="submit" name="login" value="Login" class="btn btn-primary btn-block" />
            <label class="text-danger"><?php echo $loginfaild; ?></label>
          </form>
				</div>

<?php  } elseif ($do === "signup") {

	// SIGN UP PAGE ?>
	<div class="signupdiv">
		<form class="signup" novalidate action="<?php echo $_SERVER['PHP_SELF']  . '?do=signup'; ?>" method="post" enctype="multipart/form-data">

			<div class="row">
				<div class="col-md-7">
					<div class="inputparent form-group row">
						<label class="col-md-5 text-white">Username :</label>
						<input type=" text" class="form-control col-md-7 user" style="margin-top: 15px;" autocomplete="off" placeholder="Type username here" name="username" required="required"/>
						<p class="mr-auto mb-2 validate reqvalidate">Please fill out your username</p>
						<p class="mr-auto mb-2 validate uservalidate1">Please type at least 3 letters in username</p>
					</div>
					<div class="inputparent form-group row">
						<label class="col-md-5 text-white">Full Name :</label>
						<input type="text" class="form-control col-md-7 user" style="margin-top: 15px;" autocomplete="off" placeholder="Type full name here" name="fullname" required="required"/>
						<p class="mr-auto mb-2 validate reqvalidate">Please fill out your full name</p>
						
					</div>

					<div class="inputparent form-group row">
						<label class="col-md-5 text-white">Password :</label>
						<input type="password" class="form-control col-md-7 pass" style="margin-top: 15px;" autocomplete="new-password" placeholder="Type password here" name="password" required="required"/>
						<p class="mr-auto mb-2 validate reqvalidate">Please fill out your password</p>
						<p class="mr-auto mb-2 validate passvalidate1">Password must contains numbers and letters only</p>
					</div>

					<div class="inputparent form-group row">
						<label class="col-md-5 text-white">Confirm password :</label>
						<input type="password" class="form-control col-md-7 pass" style="margin-top: 15px;" autocomplete="new-password" placeholder="Confirm password" name="conpassword" required="required"/>
						<p class="mr-auto mb-2 validate reqvalidate">Please confirm your password</p>
						<p class="mr-auto mb-2 validate passvalidate1">Password must contains numbers and letters only</p>
						<p class="mr-auto mb-2 validate passvalidate2">Password must be mutched in two fields</p>
					</div>

					<div class="inputparent form-group row">
						<label class=" col-md-5 text-white">Email :</label>
						<input type="email" class="form-control col-md-7" style="margin-top: 15px;" autocomplete="off" placeholder="Type email here" name="email" required="required"/>
						<p class="mr-auto mb-2 validate reqvalidate">Please fill out your email</p>
						<p class="mr-auto mb-2 validate emailvalidate1">Email must contains [@ .] </p>
						<p class="mr-auto mb-2 validate emailvalidate2">Email must contains numbers, letters and [@._-] only </p>
						<p class="mr-auto mb-2 validate emailvalidate3">Email must be like something@something.something </p>
					</div>
				</div>
				<div class="col-md-5">
						<div class="imageAdd" style="position: relative; margin-top:10px">
							<img class="blah blahAvatar" width="300" height="300" src="layout/images/avatar.jpg" />
							<label for="upload" class="blahbutton" style="cursor: pointer; background-color:#fff; padding:5px">
								<span class="add"><i class="fa fa-plus fa-lg"></i></span>
								<span class="edit"><i class="fa fa-edit fa-lg"></i></span>
								<input type="file" id="upload" class="imgInp" name="image" accept="image/gif, image/jpeg, image/png" hidden>
							</label>
							<label for="delete" class="blahbutton delete" style="cursor: pointer; background-color:#fff; padding:5px; top:35px">
									<span  id="delete"><i class="fa fa-trash fa-lg"></i></span>
							</label>
						</div>
				</div>
				<input type="submit" value="Sign up" name="signup" class="btn btn-success btn-block" />

			</div>
		</form>
	</div>
	<?php } else {
    // ERROR 404
  }


	include $temp . "footer.php";
?>
