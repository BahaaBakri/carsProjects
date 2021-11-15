
<?php

use function PHPSTORM_META\map;

ob_start();
	session_start();

	if (isset($_SESSION['username'])) {

		// when come from index.php and have registerd session

		$pagetitle = "Members";
		include "ini.php";
		$do = ""; ?>
	<div>
		<div style="width: 18%; height:100%; position:fixed; z-index:1000">
			<?php include "includes/temp/sidebar.php"?>
		</div>
		
		<div style="display: flex;">
			<div style="flex-basis: 18%;"></div>
			<div style="flex-basis: 82%; width:82%">

	<?php if (isset($_GET["do"])) {
			$do = $_GET['do'];
		} else {
			$do = "mange";
		}

		// Serach
		if (isset($_GET['search'])) {
			$search = $_GET['search'];
		} else {
			$search = '';
		}
		// Top 5
		if(isset($_GET['top5Users'])) {
			$top5Users = $_GET['top5Users'];
		} else {
			$top5Users = "";
		}
		if ($do === "mange") {

		 //Manger Page

		// build a query to fetch users data or admins data or pending data

		if (isset($_GET['show']) && $_GET['show'] === "admins") {

			$rows = count_and_fetch("users", "admins", "fetch", "groupid", "", "ORDER BY userid DESC", $search);
			
		
		} elseif (isset($_GET['show']) && $_GET['show'] === "pending") {

			$rows = count_and_fetch("users", "pending", "fetch", "groupid", "regstatus", "ORDER BY userid DESC", $search);

		} else {
			
			$_GET['show'] = "";
			
			// top5 Users Offered
			if ($top5Users == "offered")  {
	
				$rows = top5User("items");
			} else if ($top5Users == "bought") {
				$rows =  top5User("sells");	
			} else {
				$rows = count_and_fetch("users", "users", "fetch", "groupid", "", "ORDER BY userid DESC", $search);
			}
		}


			 ?>

			<!-- Show mange form -->
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a hidden class="navbar-brand" href="#">Navbar</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<form class="form-inline my-2 my-lg-0">
						<input class="inputSearch searchUser form-control mr-sm-2" type="search" placeholder="Search User" aria-label="Search" value="<?php echo $search; ?>">
						<a class="btn btn-outline-primary my-2 my-sm-0" href="#" >Search</a>
					</form>
				</ul>

			</div>
			</nav>
		<?php
			// We found this id in DB

			if (!empty($rows)) { ?>
			<!-- Show mange table -->
			<div class="mybigcontainer table-responsive">
			<?php if (isset($_GET['show']) && $_GET['show'] === "admins") { ?>
					<h2 class="text-center my-5">Admins</h2>
			<?php } elseif (isset($_GET['show']) && $_GET['show'] === "pending") {?>
					<h2 class="text-center my-5">Pending Members</h2>
				<?php } else { ?>
					<h2 class="text-center my-5"> Members</h2>
				<?php }
				if (isset($_GET['top5Users'])) {
					if($_GET['top5Users'] == 'offered') { ?>
					<p style="font-size: 32px; font-weight:bold">The most five users offerd items are : </p>
				<?php	} else if($_GET['top5Users'] == 'bought') { ?>
					<p  style="font-size: 32px; font-weight:bold">The most five users bought items are : </p>
				<?php	}
				} else if (isset($_GET['search'])) { ?>
					<p  style="font-size: 32px; font-weight:bold">Search result about '<?php echo $search;?>' : </p>
				<?php }
				?>
				<table class="table table-bordered text-center table-main">
				  <thead>
				    <tr>
						<th scope="col">#ID</th>
						<th scope="col">Profile</th>
				      <th scope="col">Username</th>
				      <th scope="col">Email</th>
				      <th scope="col">Full Name</th>
							<th scope="col">Registerd date</th>
							<?php if ($_GET['show'] !== "admins")  {?>
				      	<th scope="col">Control</th>
							<?php }  ?>
				    </tr>
				  </thead>
				  <tbody>
				    <?php
						foreach ($rows as $row) {
							echo "<tr>";
								echo "<td>" . $row['userid'] . "</td>"; ?>
								<td>
									<a href="members.php?do=profile&userid=<?php echo $row['userid']?>" class='btn  table-control' style="padding:5px; width: 100px; height:100px; border-radius: 50%; border: 1px solid #333"  > 
										<img style="border-radius: 50%" width="100%" height="100%"  src="../dataset/uploaded/uploaded_avatar/<?php echo $row['avatar']; ?>" onerror="this.src = 'layout/images/avatar.jpg'" />
									</a>
								</td>

								<?php 
								echo "<td>"  . $row['username'] . "</td>";
								echo "<td>"  . $row['email'] . "</td>";
								echo "<td>" . $row['fullname'] . "</td>";
								echo "<td>" . $row['regdatetime'] . "</td>"; ?>
								<?php if (isadmin("username", "users", $row['username'], "groupid") == 0) { ?>
									<td>

										<a href="members.php?do=edit&userid=<?php echo $row['userid']; ?>" class='btn btn-success table-control'> <i class='fa fa-edit'></i></a>
										<a href="members.php?do=delete&userid=<?php echo $row['userid']; ?>" class='btn btn-danger table-control'> <i class='fa fa-trash'></i></a>
										<?php if (ispending("username", "users", $row['username'] , "regstatus") > 0) { ?>
										<a href="members.php?do=activate&userid=<?php echo $row['userid']; ?>" class='btn btn-info table-control'> <i class='fa fa-check'></i></a>
									<?php } ?>
									</td>
								<?php }  ?>

									</tr>

						<?php } ?>
				  </tbody>
				</table>

		<?php	}
			else {
				if (isset($_GET['search'])) {

					$msg = "<div class='alert alert-warning text-center'>There is no any result about username '$search'</div>";
					redirect($msg, 'members.php', 'Members Page');?>
					<a href="members.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Members Page Now</a>

				<?php } else {
					$msg = "<div class='alert alert-warning text-center'>There is no any members yet</div>";
					redirect($msg, 'dashbord.php', 'Dashboard'); ?>
					<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

				<?php }

			}
			if ($_GET['show'] !== "admins")  {
			?>
			<a href="?do=add" class="save btn btn-primary text-white"><i class="fa fa-user-plus fa-lg"></i> New Member</a>
		</div>
	<?php } else { ?>

		<a href="?do=addadmin" class="save btn btn-danger text-white"><i class="fa fa-user-plus fa-lg"></i> New Admin</a>
	
	<?php	} }
		 elseif ($do === "edit") {

		// Edit Page

		// check if userid in get request and numeric

		$userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ?  $_GET['userid'] : 0;
		// build a query to fetch all data depend with that query

		$row = select_user_data("users", "userid", $userid);

		// if this user is other admin you can't modify his data

		if ((isadmin("username", "users", $row['username'], "groupid") > 0) && ($_SESSION['userid'] != $row['userid'])) {
			$msg = "<div class='alert alert-danger text-center'>Sorry , you don't have any permition to edit admins data</div>";
			redirect($msg, 'dashbord.php', 'Dashboard Page'); ?>
			<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

<?php	} else {
			//echo $row['username'];

			// check if userid in DB

			if (!empty($row)) {

				// We found this id in DB

				// Show Edit form ?>

				<div class="container">

					<h2 class="myblue text-center my-5">Edit Members</h2>
					<form class="members" novalidate action="?do=update" method="post" id="edit" enctype="multipart/form-data">
						<input type="hidden" name="userid" value="<?php echo $row['userid']; ?>">
						<div style="display: flex; justify-content:space-between">
							<div class="elements" style="flex-basis: 50%;">
								
									<div class="form-group row">
										<label class="col-md-3" for="username">Username:</label>
										<input type="text" class="form-control col-md-9" id="username" name="username" value="<?php echo $row['username']; ?>" autocomplete="off" required="required">
										<p class="col-md-9 ml-auto validate uservalidate0">Please fill out your username</p>
										<p class="col-md-9 ml-auto validate uservalidate1">Please type at least 3 letters in username</p>
									</div>
									<div class="form-group row" style="position: relative;">
										<label  class="col-md-3" for="password">Password:</label>
										<input type="hidden" name="oldpassword" value = "<?php echo $row['password']; ?>">
										<input type="password" class="form-control col-md-9" id="password" name="password" autocomplete="new-password" placeholder="Leave it blanck if you don't want to change">
										<a class ='btn showpass showen eye'><i class='fa fa-eye fa-lg'></i></a>
										<a class ='btn showpass seye'><i class='fa fa-eye-slash fa-lg'></i></a>
										<p class="col-md-9 ml-auto validate passvalidate1">Password must contains numbers and letters only</p>
									</div>
									<div class="form-group row">
										<label  class="col-md-3" for="email">Email:</label>
										<input type="email" class="form-control col-md-9" id="email" name="email" value="<?php echo $row['email']; ?>" autocomplete="off" required="required">
										<p class="col-md-9 ml-auto validate emailvalidate0">Please fill out your email</p>
										<p class="col-md-9 ml-auto validate emailvalidate1">Email must contains [@ .] </p>
										<p class="col-md-9 ml-auto validate emailvalidate2">Email must contains numbers, letters and [@._-] only </p>
									</div>
									<div class="form-group row">
										<label  class="col-md-3" for="fullname">Full Name:</label>
										<input type="text" class="form-control col-md-9" id="fullname" name="fullname" value="<?php echo $row['fullname']; ?>" autocomplete="off" required="required">
										<p class="col-md-9 ml-auto validate fullvalidate0">Please fill out your full name</p>
									</div>
							</div>


							<div class="imageEdit" style="position: relative;">
								<img class="blah blahAvatar" width="300" height="300" src="../dataset/uploaded/uploaded_avatar/<?php echo $row['avatar']; ?>" onerror="this.src = 'layout/images/avatar.jpg'; document.getElementById('deleteLabel').style.display = 'none'" />
								<label for="upload" class="blahbutton" style="cursor: pointer; background-color:#fff; padding:5px">
									<span class="edit"><i class="fa fa-edit fa-lg"></i></span>
									<input type="file" id="upload" class="imgInp" name="image" accept="image/gif, image/jpeg, image/png" hidden>
								</label>
								<label for="delete" id="deleteLabel" class="blahbutton delete" style="cursor: pointer; background-color:#fff; padding:5px; top:35px">
									<span  id="delete"><i class="fa fa-trash fa-lg"></i></span>
								</label>
							</div>
							<!--script type="text/javascript">
								function onCancelImage(image) {
									console.log("asasas")
								}								
								window.onload = function() {

								}								
							


							</script-->
						</div>

						<div class="form-group">
							<input class="save btn btn-primary"  type="submit"  value="Save">
						</div>

					</form>
				</div>

			<?php } else {

				// show Error alert [Error to find id]


					$msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
					redirect($msg, 'dashbord.php', 'Dashboard Page'); ?>
					<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

		<?php	}
			}
		}
		elseif ($do === "update") {


			// Update Page

			echo "<h2 class='myblue text-center my-5'>Update Members</h2>";

			if ($_SERVER['REQUEST_METHOD'] === "POST") {

				// we come from request method to update page

				// fetch data from form by post request

				$id = $_POST['userid'];
				$user = $_POST['username'];
				$pass = $_POST['password'];
				$oldpass = $_POST['oldpassword'];
				$em = $_POST['email'];
				$name = $_POST['fullname'];

				// password trick

				if (empty($pass)) {
					$finalpass = $oldpass;
				} else {
					$finalpass = sha1($pass);
				}


				// Validate in server side

				$errorarray = array();

				if (empty($user)) {
					array_push($errorarray, "You can't leave username empty, Please fill it");
				}

				if (strlen($user) < 3) {
					array_push($errorarray, "Username must be more than 3 letters");
				}

				if (empty($em)) {
					array_push($errorarray, "You can't leave email empty, Please fill it");
				}

				if (empty($name)) {
					array_push($errorarray, "You can't leave full name empty, Please fill it");
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
				if (empty($errorarray)) {
					// check if username in DB

					if (isindb("username", "users", $user, "userid", $id) > 0) {

						// username is exisits in DB

						$msg = "<div class='alert alert-danger text-center'>Username $user is existed try other username</div>";
						redirect($msg, 'dashbord.php', 'Dashboard Page'); ?>
						<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

		<?php		} else {

						// update DB depent of these data

						$check = update_user_data("users",
																			"userid = '$id'",
						 													"username = '$user'",
						 													"password = '$finalpass'",
																			"email = '$em'",
																			"fullname = '$name'",
																			"avatar = '$fileName'");

						// check if update success

						if ($check > 0) {


								$msg = "<div class='alert alert-success text-center'>Update Succeded, $check row updateded</div>";

								if (isadmin("username", "users", $user, "groupid") > 0) {
									redirect($msg, "members.php?do=mange&show=admins", "Admins Page",  7); ?>
									<a href="members.php?do=mange&show=admins" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Admins Page Now</a>

					<?php		} else {
									redirect($msg, 'members.php',"Members Page"); ?>
									<a href="members.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Members Page Now</a>
					<?php		}

						 } else {


								$msg = "<div class='alert alert-danger text-center'>Update Faild,  $check  row updateded</div>";
								redirect($msg, 'members.php',"Members Page"); ?>
								<a href="members.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Members Page Now</a>

					<?php	 }


					}

				} else {

					// Validation Error

					foreach ($errorarray as $error) { ?>

						<div class="mycontainer">
							<div class="alert alert-danger text-center"><?php echo $error; ?></div>
						</div>

					<?php }
					redirect("", 'dashbord.php', 'Dashboard Page',  30); ?>
					<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

	<?php		}

		 } else {


				$msg ="<div class='alert alert-danger text-center'>Sorry you can't open this page direct, Try again</div>";
				redirect($msg, 'dashbord.php', 'Dashboard Page'); ?>
				<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

<?php
} }

		elseif ($do === "add") {

			// Add members ?>
			<div class="container">

				<h2 class="myblue text-center my-5">Add New Members</h2>
				<form class="members" novalidate action="?do=insert" method="post" id="add" enctype="multipart/form-data">
					<div style="display: flex; justify-content:space-between">
						<div class="elements" style="flex-basis: 50%;">
							<div class="form-group row">
								<label class="col-md-3" for="username">Username:</label>
								<input type="text" class="form-control col-md-9" id="username" name="username" placeholder="Type Username here" autocomplete="off" required="required">
								<p class="col-md-9 ml-auto validate uservalidate0">Please fill out member username</p>
								<p class="col-md-9 ml-auto validate uservalidate1">Please type at least 3 letters in username</p>
							</div>
							<div class="form-group row" style="position: relative;">
								<label  class="col-md-3" for="password">Password:</label>
								<input type="password" class="form-control col-md-9" id="passwordreq" name="password" autocomplete="new-password" placeholder="Type Password here" required="required">
								<a class ='btn showpass showen eye'><i class='fa fa-eye fa-lg'></i></a>
								<a class ='btn showpass seye'><i class='fa fa-eye-slash fa-lg'></i></a>
								<p class="col-md-9 ml-auto validate passvalidate0">Please fill out member password</p>
								<p class="col-md-9 ml-auto validate passvalidate1">Password must contains numbers and letters only</p>
							</div>
							<div class="form-group row">
								<label  class="col-md-3" for="email">Email:</label>
								<input type="email" class="form-control col-md-9" id="email" name="email" placeholder="Type Email here" autocomplete="off" required="required">
								<p class="col-md-9 ml-auto validate emailvalidate0">Please fill out member email</p>
								<p class="col-md-9 ml-auto validate emailvalidate1">Email must contains [@ .] </p>
								<p class="col-md-9 ml-auto validate emailvalidate2">Email must contains numbers, letters and [@._-] only </p>
							</div>
							<div class="form-group row">
								<label  class="col-md-3" for="fullname">Full Name:</label>
								<input type="text" class="form-control col-md-9" id="fullname" name="fullname" placeholder="Type Full Name here" autocomplete="off" required="required">
								<p class="col-md-9 ml-auto validate fullvalidate0">Please fill out member full name</p>
							</div>
						</div>

						<div class="imageAdd" style="position: relative;">
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
					<div class="form-group">
						<input  class="save btn btn-primary"  type="submit" value="Save" />
					</div>


				</form>
			</div>

		<?php }
		elseif ($do === "addadmin") {

			// Add members ?>
			<div class="container">

				<h2 class="text-danger text-center my-5">Add New Admin</h2>

				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>

					You will add a new admin with this permission:<br>
					1) Create Update and Delete every thing in this website <br>
					2) Log in to Control Panel whatever he want <br>
					3) Add new members and admins <br>
					4) Activate new members<br>
					
				</div>
				<form class="members" novalidate action="?do=insert&status=admin" method="post" id="add" enctype="multipart/form-data">
					<div style="display: flex; justify-content:space-between">
						<div class="elements" style="flex-basis: 50%;">
							<div class="form-group row">
								<label class="col-md-3" for="username">Username:</label>
								<input type="text" class="form-control col-md-9" id="username" name="username" placeholder="Type Username here" autocomplete="off" required="required">
								<p class="col-md-9 ml-auto validate uservalidate0">Please fill out member username</p>
								<p class="col-md-9 ml-auto validate uservalidate1">Please type at least 3 letters in username</p>
							</div>
							<div class="form-group row" style="position: relative;">
								<label  class="col-md-3" for="password">Password:</label>
								<input type="password" class="form-control col-md-9" id="passwordreq" name="password" autocomplete="new-password" placeholder="Type Password here" required="required">
								<a class ='btn showpass showen eye'><i class='fa fa-eye fa-lg'></i></a>
								<a class ='btn showpass seye'><i class='fa fa-eye-slash fa-lg'></i></a>
								<p class="col-md-9 ml-auto validate passvalidate0">Please fill out member password</p>
								<p class="col-md-9 ml-auto validate passvalidate1">Password must contains numbers and letters only</p>
							</div>
							<div class="form-group row">
								<label  class="col-md-3" for="email">Email:</label>
								<input type="email" class="form-control col-md-9" id="email" name="email" placeholder="Type Email here" autocomplete="off" required="required">
								<p class="col-md-9 ml-auto validate emailvalidate0">Please fill out member email</p>
								<p class="col-md-9 ml-auto validate emailvalidate1">Email must contains [@ .] </p>
								<p class="col-md-9 ml-auto validate emailvalidate2">Email must contains numbers, letters and [@._-] only </p>
							</div>
							<div class="form-group row">
								<label  class="col-md-3" for="fullname">Full Name:</label>
								<input type="text" class="form-control col-md-9" id="fullname" name="fullname" placeholder="Type Full Name here" autocomplete="off" required="required">
								<p class="col-md-9 ml-auto validate fullvalidate0">Please fill out member full name</p>
							</div>
						</div>

						<div class="imageAdd" style="position: relative;">
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
					<div class="form-group">
						<input  class="save btn btn-primary"  type="submit" value="Save" />
					</div>


				</form>

			</div>

		<?php }
		elseif ($do === "insert") {

		//insert page
		echo "<h2 class='myblue text-center my-5'>Insert Members</h2>";

		if ($_SERVER['REQUEST_METHOD'] === "POST") {

			// we come from request method to insert page

			// fetch data from form by post request
			// print_r($_FILES);
			$user = $_POST['username'];
			$passcheck = $_POST['password'];
			$passDB = sha1($_POST['password']);
			$em = $_POST['email'];
			$name = $_POST['fullname'];


			// Validate in server side

			$errorarray = array();

			if (empty($user)) {
				array_push($errorarray, "You can't leave username empty, Please fill it");
			}

			if (strlen($user) < 3) {
				array_push($errorarray, "Username must be more than 3 letters");
			}
			if (empty($passcheck)) {
				array_push($errorarray, "You can't leave password empty, Please fill it");
			}
			if (empty($em)) {
				array_push($errorarray, "You can't leave email empty, Please fill it");
			}

			if (empty($name)) {
				array_push($errorarray, "You can't leave full name empty, Please fill it");
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
			if (empty($errorarray)) {
				// check if there same username in DB

				if (isindb("username", "users", $user, "userid", -1) > 0) {
					// username is in DB

						$msg = "<div class='alert alert-danger text-center'>Username $user is existed try other username</div>";
						redirect($msg, 'dashbord.php', 'Dashboard Page'); ?>
						<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

	<?php 		} else {

				// insert to DB depent of these data
				if ((isset($_GET['status'])) && ($_GET['status']=='admin')) {
					// admin
					$check = insert_user_data("users", "username", "'$user'", "password", "'$passDB'", "email", "'$em'", "fullname", "'$name'", "regdatetime", "now()", "regstatus", 1, "groupid", 1, "avatar", "'$fileName'");


				} else {
					// user
					$check = insert_user_data("users", "username", "'$user'", "password", "'$passDB'", "email", "'$em'", "fullname", "'$name'", "regdatetime", "now()", "regstatus", 1, "avatar", "'$fileName'");

				}

				// check if insert success

				if ($check > 0) {


						$msg ="<div class='alert alert-success text-center'>Insert Succeded,  $check row inserted</div>";
						redirect($msg, "members.php", "Members Page");?>
						<a href="members.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Members Page Now</a>

						

	<?php		 } else {

					 $msg ="<div class='alert alert-danger text-center'>Insert Faild,  $check row inserted</div>";
 					redirect($msg, "members.php", "Members Page"); ?>
					<a href="members.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Members Page Now</a>


	<?php		}

		 }
	} else {

				// Validation Error

				foreach ($errorarray as $error) { ?>

					<div class="mycontainer">
						<div class="alert alert-danger text-center"><?php echo $error; ?></div>
					</div>

				<?php }
					redirect("", 'dashbord.php', 'Dashboard Page',  30); ?>
					<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
	<?php		}
			// add button ?>
					<a href="?do=add" class="save btn btn-primary text-white"><i class="fa fa-user-plus"></i>  New Member</a>
		<?php } else {

			$msg ="<div class='alert alert-danger text-center'>Sorry you can't open this page direct, Try again</div>";
			redirect($msg, 'dashbord.php', 'Dashboard Page'); ?>
			<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>


 <?php } }
	elseif ($do === "delete") {
			// delete page

			// check if userid in get request and numeric

			$userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ?  $_GET['userid'] : 0;
			// build a query to fetch all data depend with that query

			$row = select_user_data("users", "userid", $userid);

			// if he is another admin we can not delete him

			if ((isadmin("username", "users", $row['username'], "groupid") > 0) && ($_SESSION['username'] != $row['username'])) {
				$msg = "<div class='alert alert-danger text-center'>Sorry , you don't have any permition to delete admins data</div>";
				redirect($msg, 'dashbord.php', 'Dashboard Page'); ?>
				<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

	<?php	} else {


			// check if userid in DB

			if (!empty($row)) { ?>
				<!-- Button trigger modal -->
				<input type="hidden" class="triggermodal" data-toggle="modal" data-target="#staticBackdrop">
				<!-- Modal -->
				<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				  <div class="modal-dialog modal-dialog-centered">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="staticBackdropLabel">Confirm Delete</h5>
					       	<a class="close" href="members.php" aria-label="Close">
					         <span aria-hidden="true">&times;</span>
			        		</a>
					    </div>
					    <div class="modal-body">
					       Are you really sure want to delete <?php if (isadmin("username", "users", $row['username'], "groupid") > 0) { echo "your";} else { echo $row['username'];} ?> membership ?
				     </div>
			      <div class="modal-footer">
				        <a  class="btn btn-secondary" href="members.php">Cancel</a>
				        <a  class="btn btn-danger" href="members.php?do=deleteaccess&userid=<?php echo $row['userid']; ?>&username=<?php echo $row['username']; ?>">Delete</a>
					  </div>
			    </div>
			  </div>
			</div>

		<?php }
		else {

			// There is no such id

			$msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
			redirect($msg, 'dashbord.php', 'Dashboard Page'); ?>
			<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
<?php		}

	}
}

	elseif ($do === "deleteaccess") {


			$id = $_GET['userid'];
			$user = $_GET['username'];
			$admin = isadmin("username", "users", $user, "groupid");
			$check = delete_row("users", "userid", $id, "AND username = '$user'");

			if ($check > 0) {

					if ($admin > 0) {
						$msg = "<div class='alert alert-success text-center'>Your membership has been deleted</div>";
						redirect($msg,"logout.php", "out");?>
						<a href="logout.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go Out Now</a>

			<?php	} else {

						$msg = "<div class='alert alert-success text-center'>$user membership has been deleted</div>";
						redirect($msg,"members.php", "Members Page"); ?>
						<a href="members.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Members Page Now</a>


		<?php	}
			}
		 else {

				$msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
				redirect($msg, 'dashbord.php', 'Dashboard Page'); ?>
				<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

	<?php	 } } elseif ($do === "activate") {
			 // activate page

			$userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ?  $_GET['userid'] : 0;

			// build a query to fetch all data depend with that query

			$row = select_user_data("users", "userid", $userid);

 			// check if userid in DB

 			if (!empty($row)) { ?>
 				<!-- Button trigger modal -->
 				<input type="hidden" class="triggermodal" data-toggle="modal" data-target="#staticBackdrop">
 				<!-- Modal -->
 				<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
 				  <div class="modal-dialog modal-dialog-centered">
 				    <div class="modal-content">
 				      <div class="modal-header">
 				        <h5 class="modal-title" id="staticBackdropLabel">Confirm Member</h5>
 					       	<a class="close" href="members.php" aria-label="Close">
 					         <span aria-hidden="true">&times;</span>
 			        		</a>
 					    </div>
 					    <div class="modal-body">
 					       Are you really sure want to activate <?php echo $row['username']; ?> membership ?
 				     </div>
 			      <div class="modal-footer">
 				        <a  class="btn btn-secondary" href="members.php">Cancel</a>
 				        <a  class="btn btn-info" href="members.php?do=activateaccess&userid=<?php echo $row['userid']; ?>&username=<?php echo $row['username']; ?>">Activate</a>
 					  </div>
 			    </div>
 			  </div>
 			</div>

 		<?php }
 		else {

 			// There is no such id

 			$msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
			 redirect($msg, 'dashbord.php', 'Dashboard Page'); ?>
			 <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
<?php	 }

 	}

 	elseif ($do === "activateaccess") {


 			$id = $_GET['userid'];
 			$user = $_GET['username'];

			$check = update_user_data("users", "userid = $id", "regstatus = 1");
 			if ($check > 0) {


 					$msg = "<div class='alert alert-success text-center'>$user membership has been activated</div>";
					redirect($msg,"members.php", "Members Page"); ?>
					<a href="members.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Members Page Now</a>


 <?php		}
 		 else {

 				$msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
				redirect($msg,"members.php", "Members Page"); ?>
				<a href="members.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Members Page Now</a>

<?php	 }
	 } else if ($do === "profile") {
		$userid = $_GET['userid'];

		// get user details
		$details = select_user_data('users', 'userid', $userid);
		$username = $details['username'];
		// get user comments
		$commentsUser = getCommentsUser($userid);
		// get latest 5 user comments
		$comments5 = getCommentsUser($userid,"", "LIMIT 5");
		// get user items offered
		// $items = get_user_items('items', $userid);
		// // get user items sold
		// $sells = get_user_items('sells', $userid);
		$items = get_user_items('all', $userid);

		// get latest 5 user items (new, like, old)
		$rowsitemsnewUser = get_latest("offered","'new'" , "", $userid);
		$rowsitemslikenewUser = get_latest("offered","'like_new'","", $userid);
		$rowsitemsoldUser = get_latest( "offered", "'old'","", $userid);

		$rowssellsnewUser = get_latest("selled","'new'" , "", $userid);
		$rowssellslikenewUser = get_latest("selled","'like_new'","", $userid);
		$rowssellsoldUser = get_latest( "selled", "'old'","", $userid);
		
		$admin = false;
		$your = false;
		if (isadmin('userid', 'users', $userid, 'groupid') > 0) { 
			$admin = true;
			if ($_SESSION['userid'] === $userid) {
				// this is your profile
				$your = true;
			}
		}

		
		if (!($admin && !$your)) { ?>
		<nav class="navbar navbar-expand-lg navbar-dark " style="background-color: rgba(87, 87, 97, .9); padding: 5px 40px;">
			<a  class="navbar-brand" href="#"><h4><?php echo $username?></h4></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse row" id="navbarSupportedContent" >
			<div class="row ml-auto" style="justify-content: space-between;"> 
			<?php if ($admin && $your) {?>
				<a  href='members.php?do=edit&userid=<?php echo $userid?>'class='btn mysuccess'> <i class='fa fa-edit'></i> Edit my profile  </a>
				<a  href='members.php?do=delete&userid=<?php echo $userid?>' class='btn mydanger '> <i class='fa fa-trash'></i> Delete my profile  </a>            
				<a  href='items.php?do=add&userid=<?php echo $userid; ?>' class='btn myinfo '> <i class='fa fa-plus'></i> offered new item from me  </a>

			<?php } else if (!$admin) {?>
				<a  href='members.php?do=edit&userid=<?php echo $userid?>'class='btn myprimary'> <i class='fa fa-edit'></i> Edit member <?php echo $username?> </a>
				<a  href='members.php?do=delete&userid=<?php echo $userid?>' class='btn mydanger '> <i class='fa fa-trash'></i> Delete member <?php echo $username?> </a>            
				<a  href='items.php?do=add&userid=<?php echo $userid; ?>' class='btn myinfo '> <i class='fa fa-plus'></i> offered new item from member <?php echo $username?> </a>
			<?php }?>
			</div>
			
			</div>
		</nav>
		<?php } ?>
		<div class="mybigcontainer" style="margin-top: 70px;">
			<div class="profileHeader" >
				<a href="members.php?do=profile&userid=<?php echo $userid?>" class='btn  table-control' style="padding:5px; width: 150px; height:150px; border-radius: 50%; border: 1px solid #333"  > 
					<img style="border-radius: 50%" width="100%" height="100%" src="../dataset/uploaded/uploaded_avatar/<?php echo $details['avatar']; ?>" onerror="this.src = 'layout/images/avatar.jpg'" />
				</a>
			</div>
			<div class="profileTitle">
				
					<h3 style="text-align: center;"><?php echo $details['fullname']?></h3>
					<div class="profileTitleInfo">
					<?php 
						if ($admin) { ?>
							<div class="mydangerBack not">
								Admin
							</div>
						<?php	} else { ?>
							<div class="mysuccessBack not">
								Member
							</div>
						<?php 
							if (ispending('userid', 'users', $userid, 'regstatus') > 0) {
							?>
								<div class="bg-secondary not">
									Still Pending
								</div>
							<?php } else { ?>
								<div class="bg-primary not">
									Approved
								</div>	
							<?php }

						}
					?>
					</div>
					<div class="profileDetails">
						<div>
						<span style="font-weight: bold;">UserName : </span> <?php echo $details['username']?>
						</div>
						<div>
						<span style="font-weight: bold;">Email : </span> <?php echo $details['email']?>
						</div>
					</div>
					<div class="row justify-content-between " style="padding:10px; margin-top:20px">
						<div class="col-md-3 row">
							<div id="slide3" class="slide col-md-12 chartParent"  style="padding: 0;">
								<div>
								<h5 class="text-center">Total  Items related to <?php echo $username; ?></h5>
								<p class="text-center" style="font-size:64px;"><i class="fa fa-lg fa-comment" ></i> <?php echo get_user_items("all", $userid, "count") ?></p>
								<button  class="stretched-link smoothScroll" data-scroll="UserItems"></button>
								</div>

								<span></span>
							</div>
							<div id="slide4" class="slide col-md-12 chartParent"  style="padding: 0;">
								<div>
								<h5 class="text-center">Total <?php echo $username; ?> Comments</h5>
								<p class="text-center" style="font-size:64px;"><i class="fa fa-lg fa-comment" ></i> <?php echo getCommentsUser($userid, "count"); ?></p>
								<button  class="stretched-link smoothScroll" data-scroll="UserComments"></button>
								</div>

								<span></span>
							</div>
						</div >

						<div class="row col-md-9">

							<div class="chartParent  col-md-8" style="border:3px solid #f0f0f0" >
								<p style="font-weight: bold;">All Items declared by <?php echo $username; ?>:</p>
								<div class="AllPriceParent">
								<div class="AllItemsPrice" data-toggle="tooltip" data-placement="right" 
									title="<p>New: $<?php echo sum_price("items", "'new'", "", $userid); ?></p> <p>Like New: $<?php echo sum_price("items", "'like_new'", "", $userid); ?></p> <p>Old: $<?php echo sum_price("items", "'old'", "", $userid); ?></p>">
									$<?php echo sum_price("items", "", "", $userid); ?>
								</div>
								</div>
							</div>
							<div class="chartParent  col-md-4" style="border:3px solid #f0f0f0" >
								<p style="font-weight: bold;">All Items pending by <?php echo $username; ?>:</p>
								<div class="AllPriceParent">
								<div class="AllItemsPrice" data-toggle="tooltip" data-placement="right" 
									title="<p>New: $<?php echo sum_price("pending", "'new'", "", $userid); ?></p> <p>Like New: $<?php echo sum_price("pending", "'like_new'", "", $userid); ?></p> <p>Old: $<?php echo sum_price("pending", "'old'", "", $userid); ?></p>">
									$<?php echo sum_price("pending", "", "", $userid); ?>
								</div>
								</div>
							</div>
							<div class="chartParent  col-md-4" style="border:3px solid #f0f0f0" >
								<p style="font-weight: bold;">All Items declared by <?php echo $username; ?> and still offered:</p>
								<div class="AllPriceParent">
								<div class="AllItemsPrice" data-toggle="tooltip" data-placement="right" 
									title="<p>New: $<?php echo sum_price("itemsoffered", "'new'", "", $userid); ?></p> <p>Like New: $<?php echo sum_price("itemsoffered", "'like_new'", "", $userid); ?></p> <p>Old: $<?php echo sum_price("itemsoffered", "'old'", "", $userid); ?></p>">
									$<?php echo sum_price("itemsoffered", "", "", $userid); ?>
								</div>
								</div>
							</div>
							<div class="chartParent  col-md-4" style="border:3px solid #f0f0f0" >
								<p style="font-weight: bold;">All Items declared by <?php echo $username; ?> and bought:</p>
								<div class="AllPriceParent">
								<div class="AllItemsPrice" data-toggle="tooltip" data-placement="right" 
									title="<p>New: $<?php echo sum_price("itemsbought", "'new'", "", $userid); ?></p> <p>Like New: $<?php echo sum_price("itemsbought", "'like_new'", "", $userid); ?></p> <p>Old: $<?php echo sum_price("itemsbought", "'old'", "", $userid); ?></p>">
									$<?php echo sum_price("itemsbought", "", "", $userid); ?>
								</div>
								</div>
							</div>

							<div class="chartParent  col-md-4" style="border-left:3px solid #f0f0f0" >
								<p style="font-weight: bold;">All Items bought by <?php echo $username; ?>:</p>
								<div class="AllPriceParent">
								<div class="AllPrice" data-toggle="tooltip" data-placement="right"
								title="<p>New: $<?php echo sum_price("sells", "'new'", "", $userid); ?></p> <p>Like New: $<?php echo sum_price("sells", "'like_new'", "", $userid); ?></p> <p>Old: $<?php echo sum_price("sells", "'old'", "", $userid); ?></p>">
									$<?php echo sum_price("sells", "", "", $userid); ?>
								</div>
								</div>
							</div>
						</div>

					</div>

				
			</div>
			<div class="myRating">
				<h4>Rating:</h4>
				<div class="row justify-content-between chartParent">
					<input id ="userid" type="hidden" value=' <?php echo $userid; ?>' />
					<div class="rateItemsUserLineChart">
						<p style="font-weight: bold;">The rate of Items Offered by <?php echo $username ?> over time</p>
						<canvas id="rateItemsUserLineChart" width="600" height="400"></canvas>
					</div>
					<div class="rateSellsUserLineChart">
						<p style="font-weight: bold;">The rate of Items bought by <?php echo $username ?> over time</p>
						<canvas id="rateSellsUserLineChart" width="600" height="400"></canvas>
					</div>								
				</div>
			</div>
			<div class="row justify-content-between chartParent">

				<input id ="newItemsCount" type="hidden" value=' <?php echo count_and_fetch_items("offered", "count", "'new'", "",  "", $userid); ?>' />
				<input id ="likeNewItemsCount" type="hidden" value=' <?php echo count_and_fetch_items("offered", "count", "'like_new'", "", "",  $userid); ?>' />
				<input id ="oldItemsCount" type="hidden" value=' <?php echo count_and_fetch_items("offered", "count", "'old'", "", "",  $userid); ?>' />
				<div class="statusItemsPieChart">
					<p style="font-weight: bold;">Divisions of items offered by <?php echo $username?></p>
					<canvas id="statusItemsPieChart" style="width: 600px; height:400px"></canvas>
				</div>

				<input id ="newSellsCount" type="hidden" value=' <?php echo count_and_fetch_items("sells", "count", "'new'", "", "",  $userid); ?>' />
				<input id ="likeNewSellsCount" type="hidden" value=' <?php echo count_and_fetch_items("sells", "count", "'like_new'", "", "", $userid); ?>' />
				<input id ="oldSellsCount" type="hidden" value=' <?php echo count_and_fetch_items("sells", "count", "'old'", "", "",  $userid); ?>' />
				<div class="statusSellsPieChart">
					<p style="font-weight: bold;">Divisions of items bought by <?php echo $username?></p>
					<canvas id="statusSellsPieChart" style="width: 600px; height:400px"></canvas>
				</div>

			</div>	
			<div class="row justify-content-between chartParent">
				<div class="top5CatItemsBarChartUser">
					<p style="font-weight: bold;">Top 5 categories offered by <?php echo $username?></p>
					<canvas id="top5CatItemsBarChartUser" style="width: 600px; height:400px"></canvas>
				</div>		
				<div class="top5CatSellsBarChartUser">
					<p style="font-weight: bold;">Top 5 categories bought by <?php echo $username?></p>
					<canvas id="top5CatSellsBarChartUser" style="width: 600px; height:400px"></canvas>
				</div>				
			</div>	
			<div class="row">
				<div class="col-md-4 latest chartParent">
					<div class="row justify-content-between m-3">
						<p style="font-weight: bold;">Latest 5 new items offered by <?php echo $username; ?></p>
						<button class="slidebutton" data-class="show"><i class="fa fa-minus fa-lg " ></i></button>
						<button class="slidebutton hidden" data-class="hide"><i class="fa fa-plus fa-lg " ></i></button>
					</div>
					<div class="mylist">
						<?php
						if (!empty($rowsitemsnewUser)) {
							foreach ($rowsitemsnewUser as $value) { ?>
							<a href="items.php?do=details&itemid=<?php echo $value['itemid']?>" class='elements list-group-item list-group-item-action'><?php echo $value['name'] ?></a>

							<?php if (ispending("itemid", "items", $value['itemid'] , "approve") > 0) { ?>
								<a href="items.php?do=approve&itemid=<?php echo $value['itemid']?>" class='icons'><i style="color:#17a2b8" class='fa fa-check fa-lg'></i></a>

							<?php } ?>
							<a href="items.php?do=delete&itemid=<?php echo $value['itemid']?>" class='icons'><i style="color:red"  class='fa fa-trash fa-lg'></i></a>
						<?php }
						}
					?>
					</div>
				</div>
				<div class="col-md-4 latest chartParent">
					<div class="row justify-content-between m-3">
						<p style="font-weight: bold;">Latest 5 like new items offered by <?php echo $username; ?></p>
						<button class="slidebutton" data-class="show"><i class="fa fa-minus fa-lg " ></i></button>
						<button class="slidebutton hidden" data-class="hide"><i class="fa fa-plus fa-lg " ></i></button>
					</div>
					<div class="mylist">
						<?php
						if (!empty($rowsitemslikenewUser)) {
							foreach ($rowsitemslikenewUser as $value) { ?>
							<a href="items.php?do=details&itemid=<?php echo $value['itemid']?>" class='elements list-group-item list-group-item-action'><?php echo $value['name'] ?></a>

							<?php if (ispending("itemid", "items", $value['itemid'] , "approve") > 0) { ?>
								<a href="items.php?do=approve&itemid=<?php echo $value['itemid']?>" class='icons'><i style="color:#17a2b8" class='fa fa-check fa-lg'></i></a>

							<?php } ?>
							<a href="items.php?do=delete&itemid=<?php echo $value['itemid']?>" class='icons'><i style="color:red"  class='fa fa-trash fa-lg'></i></a>
						<?php }
						}
					?>
					</div>
				</div>
				<div class="col-md-4 latest chartParent">
					<div class="row justify-content-between m-3">
						<p style="font-weight: bold;">Latest 5 old items offered by <?php echo $username; ?></p>
						<button class="slidebutton" data-class="show"><i class="fa fa-minus fa-lg " ></i></button>
						<button class="slidebutton hidden" data-class="hide"><i class="fa fa-plus fa-lg " ></i></button>
					</div>
					<div class="mylist">
						<?php
						if (!empty($rowsitemsoldUser)) {
							foreach ($rowsitemsoldUser as $value) { ?>
							<a href="items.php?do=details&itemid=<?php echo $value['itemid']?>" class='elements list-group-item list-group-item-action'><?php echo $value['name'] ?></a>

							<?php if (ispending("itemid", "items", $value['itemid'] , "approve") > 0) { ?>
								<a href="items.php?do=approve&itemid=<?php echo $value['itemid']?>" class='icons'><i style="color:#17a2b8" class='fa fa-check fa-lg'></i></a>

							<?php } ?>
							<a href="items.php?do=delete&itemid=<?php echo $value['itemid']?>" class='icons'><i style="color:red"  class='fa fa-trash fa-lg'></i></a>
						<?php }
						}
					?>
					</div>
				</div>
				<div class="col-md-4 latest chartParent">
					<div class="row justify-content-between m-3">
						<p style="font-weight: bold;">Latest 5 new items bought by <?php echo $username; ?></p>
						<button class="slidebutton" data-class="show"><i class="fa fa-minus fa-lg " ></i></button>
						<button class="slidebutton hidden" data-class="hide"><i class="fa fa-plus fa-lg " ></i></button>
					</div>
					<div class="mylist">
						<?php
						if (!empty($rowssellsnewUser)) {
							foreach ($rowssellsnewUser as $value) { ?>
							<a href="items.php?do=details&itemid=<?php echo $value['itemid']?>" class='elements list-group-item list-group-item-action'><?php echo $value['name'] ?></a>

							<?php if (ispending("itemid", "items", $value['itemid'] , "approve") > 0) { ?>
								<a href="items.php?do=approve&itemid=<?php echo $value['itemid']?>" class='icons'><i style="color:#17a2b8" class='fa fa-check fa-lg'></i></a>

							<?php } ?>
							<a href="items.php?do=delete&itemid=<?php echo $value['itemid']?>" class='icons'><i style="color:red"  class='fa fa-trash fa-lg'></i></a>
						<?php }
						}
					?>
					</div>
				</div>
				<div class="col-md-4 latest chartParent">
					<div class="row justify-content-between m-3">
						<p style="font-weight: bold;">Latest 5 like new items bought by <?php echo $username; ?></p>
						<button class="slidebutton" data-class="show"><i class="fa fa-minus fa-lg " ></i></button>
						<button class="slidebutton hidden" data-class="hide"><i class="fa fa-plus fa-lg " ></i></button>
					</div>
					<div class="mylist">
						<?php
						if (!empty($rowssellslikenewUser)) {
							foreach ($rowssellslikenewUser as $value) { ?>
							<a href="items.php?do=details&itemid=<?php echo $value['itemid']?>" class='elements list-group-item list-group-item-action'><?php echo $value['name'] ?></a>

							<?php if (ispending("itemid", "items", $value['itemid'] , "approve") > 0) { ?>
								<a href="items.php?do=approve&itemid=<?php echo $value['itemid']?>" class='icons'><i style="color:#17a2b8" class='fa fa-check fa-lg'></i></a>

							<?php } ?>
							<a href="items.php?do=delete&itemid=<?php echo $value['itemid']?>" class='icons'><i style="color:red"  class='fa fa-trash fa-lg'></i></a>
						<?php }
						}
					?>
					</div>
				</div>
				<div class="col-md-4 latest chartParent">
					<div class="row justify-content-between m-3">
						<p style="font-weight: bold;">Latest 5 old items bought by <?php echo $username; ?></p>
						<button class="slidebutton" data-class="show"><i class="fa fa-minus fa-lg " ></i></button>
						<button class="slidebutton hidden" data-class="hide"><i class="fa fa-plus fa-lg " ></i></button>
					</div>
					<div class="mylist">
						<?php
						if (!empty($rowssellsoldUser)) {
							foreach ($rowssellsoldUser as $value) { ?>
							<a href="items.php?do=details&itemid=<?php echo $value['itemid']?>" class='elements list-group-item list-group-item-action'><?php echo $value['name'] ?></a>

							<?php if (ispending("itemid", "items", $value['itemid'] , "approve") > 0) { ?>
								<a href="items.php?do=approve&itemid=<?php echo $value['itemid']?>" class='icons'><i style="color:#17a2b8" class='fa fa-check fa-lg'></i></a>

							<?php } ?>
							<a href="items.php?do=delete&itemid=<?php echo $value['itemid']?>" class='icons'><i style="color:red"  class='fa fa-trash fa-lg'></i></a>
						<?php }
						}
					?>
					</div>
				</div>
				<div class="col-md-12 latest chartParent">
					<div class="row justify-content-between m-3">
						<p style="font-weight: bold;">Latest 5 comments added by <?php echo $username;?></p>
						<button class="slidebutton" data-class="show"><i class="fa fa-minus fa-lg " ></i></button>
						<button class="slidebutton hidden" data-class="hide"><i class="fa fa-plus fa-lg " ></i></button>
					</div>
					<div class="mylist">
						<?php
						if (!empty($comments5)) {
							foreach ($comments5 as $value) { ?>
							<div class="border p-3 media mediacom  bg-light">
								<a href="members.php?do=profile&userid=<?php echo $value['userid']?>" class='btn  table-control' style="padding:5px;margin-right:5px; width: 100px; height:100px; border-radius: 50%; border: 1px solid #333"  > 
								<img style="border-radius: 50%" width="100%" height="100%" src="../dataset/uploaded/uploaded_avatar/<?php echo $value['avatar']; ?>" onerror="this.src = 'layout/images/avatar.jpg'" />
								</a>
								<div class="media-body">
								<h5 class="mt-0"><a class="" href="members.php?do=profile&userid=<?php echo $value['userid']?>"><?php echo $value['username']?></a> comment on <a class="" href="items.php?do=details&itemid=<?php echo $value['itemid']?>"><?php echo $value['name']?></a></h5>
								<p class="text-muted"><?php echo $value['comment'];?></p>
								</div>
								<div class="options">
								<a href="comments.php?do=delete&comid=<?php echo $value['comid']; ?>" class='btn btn-danger '>Delete <i class='fa fa-trash'></i></a>
								<?php if (ispending("comid", "comments", $value['comid'] , "status") > 0) { ?>
								<a href="comments.php?do=activate&comid=<?php echo $value['comid']; ?>" class='btn btn-info '>Activate <i class='fa fa-check'></i></a>
								<?php } ?>
								</div>
							</div>
						<?php } }
						?>
					</div>
				</div>
			</div>
			<div id="UserItems">
				<h2 class="text-center my-5"><?php echo $username?> Items</h2>
									
				<?php
				if (empty($items)) 
					// no items
				{ ?>
					
					<div class='alert alert-warning text-center'>There is no any item related to <?php echo $username ?>  </div>

			<?php } else { ?>
					<div class=navbar_works>
						<ul>
							<li class="selected filter" data-filter="all">All</li>
							<li class="filter" data-filter="declared">Declared by <?php echo $username?></li>
							<li class="filter" data-filter="declaredOffered">Declared by <?php echo $username?> and still offered</li>
							<li class="filter" data-filter="declaredSold">Declared by <?php echo $username?> and sold</li>
							<li class="filter" data-filter="declaredPending">Declared by <?php echo $username?> and pending</li>
							<li class="filter" data-filter="boughtpending">Pending by <?php echo $username?> </li>
							<li class="filter" data-filter="bought">Bought by <?php echo $username?></li>
						</ul>
					</div>
					<div  class="row chartParent" style="min-height: 600px;">
					<div class="noFilter alert-warning">
                        There is no any item in this filter
              		</div>
			<?php	foreach ($items as $row) { 
					$status = $row['status'];
					// get item comments
					$bought = false;
					$pending = false;
					$comments = getCommentsItem($row['itemid']);
					// get item buy details
					if (boughtStatus($row['itemid']) != 0) {
						$buyDetails = get_buy_details($row['itemid']);
						if (boughtStatus($row['itemid']) == 1) { 
						$bought = true;
						} else if (boughtStatus($row['itemid']) == 2) {
						$pending = true;
						}
					} else {
						$bought = false;
						$pending = false;
					}
					$declared = false;
					if ($row['userid_bind'] !== $userid) {
						$declared = true;
					}
					
					?>

					<div class="card col-md-4 <?php 
						if ($declared) {
							echo " declared ";
							if ($bought) {
								echo " declaredSold sold";
							} else if ($pending) {
								echo " declaredPending pending";
							} else {
								echo " declaredOffered offered";
							}
						} else {
							if ($bought) {
								echo " bought sold";
							} else if ($pending) {
								echo " boughtpending pending";
							} 
						}
					
					
					?> " >
					<div  style="min-height: 300px;">
						<div class="image">
						<div class="overlay">
							<p></p>
						</div>
							<img class="card-img-top" src="../dataset/uploaded/uploaded_items/<?php echo $row['image']; ?>" onerror="this.src = 'layout/images/preview.jpg'">
						</div>

					</div>
					<div class="card-body">
						<div class="userCatActions">
						<h5 class="card-title"><?php echo $row['name'] ?></h5>
						<div><span>Category : </span><a class="mya" href='categories.php?do=show&catid=<?php echo $row['catid_bind']; ?>&catname=<?php echo $row['catname'] ?>'> <?php echo $row['catname'] ?></a></div>
						</div>

						<div class="rating" data-rate-value=<?php echo $row['rating']; ?>> </div>

						<div class="userCatActions">
						<div><span>Declared By : </span><a class="mya" href='members.php?do=profile&userid=<?php echo $row['userid']; ?>'> <?php echo $row['username'] ?></a></div>
						<div class="text-muted"><?php echo $row['datetime'] ?></div>
						
						</div>
						<?php if ($bought || $pending) { ?>
						<div class="userCatActions">
						<div><span><?php echo ($bought) ? "Bought" : "Waited " ?> By : </span><a class="mya" href='members.php?do=profile&userid=<?php echo $buyDetails['userid_bind']; ?>'> <?php echo $buyDetails['username'] ?></a></div>
						<div class="text-muted"><?php echo $buyDetails['selldatetime'] ?></div>
						</div>            
					<?php } ?>          
						<br>
						<div class="itemActions">
						<a href="items.php?do=edit&itemid=<?php echo $row['itemid']; ?>" class='card-action btn mysuccess table-control'> <i class='fa fa-edit fa-lg'></i></a>
						<a href="items.php?do=delete&itemid=<?php echo $row['itemid']; ?>" class='card-action btn mydanger table-control'> <i class='fa fa-trash fa-lg'></i></a>
						<?php if ($row['approve'] == 0) {?>
							<a href="items.php?do=approve&itemid=<?php echo $row['itemid']; ?>" class='card-action btn myinfo table-control'>  <i class='fa fa-check fa-lg'></i></a>
						<?php  }?>
						<div style="margin-left:auto">
							<a class="btn btn-secondary" href="items.php?do=details&itemid=<?php echo $row['itemid'];?>">Details</a>
							<button class="pop-button btn btn-outline-secondary" id="<?php echo $row['itemid'];?>" data-class="comments"><?php echo getCommentsItem($row['itemid'], "", "count"); ?> <i class="fa fa-comment"></i></button>
						</div>
						</div>

						<div class="popup-parent">


							<div class="popup-child" data-popup="<?php echo $row['itemid'];?>" data-class="comments">
							<div style="height: 10%; width:100%">
								<div style="width:fit-content">
								<button class="pop-button-close"><i class='fa fa-times'></i></button>
								</div>
								
							</div>
							<div>
								<h3 class='text-center'>Comments on <?php echo $row['name']; ?> :</h3>
								<?php if (!empty($comments)) { ?>
								<!-- There is comments -->

								<div  id="forScrollCommentsCat"
									style="    height: 350px;
												overflow: auto;
												padding: 10px;
												border: 1px solid #AAA;
												background: #DDD">
								<?php foreach ($comments as $comment) { ?>
								<div class="border p-3 bg-light media mediacom mediacomnormallik">
									<a href="members.php?do=profile&userid=<?php echo $comment['userid']?>" class='btn  table-control' style="padding:5px; margin-right:5px; width: 100px; height:100px; border-radius: 50%; border: 1px solid #333"  > 
									<img style="border-radius: 50%" width="100%" height="100%" src="../dataset/uploaded/uploaded_avatar/<?php echo $comment['avatar']; ?>" onerror="this.src = 'layout/images/avatar.jpg'" />
									</a>
									<div class="media-body">
									<div style="display: flex; justify-content:space-between;">
										<h5 class="mt-0"><a  href="members.php?do=profile&userid=<?php echo $comment['userid']?>"><?php echo $comment['username']?></a></h5>
										<div class="text-muted"><?php echo $comment['datetime']; ?></div>
									</div>
									<div style="display: flex; justify-content:space-between;">
										<p class="text-muted"><?php echo $comment['comment'];?></p>
										<div>
										<a href="comments.php?do=delete&comid=<?php echo $comment['comid']; ?>" class='btn mydanger table-control'> <i class='fa fa-trash'></i></a>
										<?php if (ispending("comid", "comments", $comment['comid'] , "status") > 0) { ?>
										<a href="comments.php?do=activate&comid=<?php echo $comment['comid']; ?>" class='btn myinfo table-control'> <i class='fa fa-check'></i></a>
										<?php } ?>  
										</div>
									
									</div>
									</div>
								</div>
								<?php	} ?>
								</div>
								<?php } else {?>
								<!-- There is no comments -->
								<p class="text-muted"> There is no any comment yet ...</p>
								<?php } ?>
							</div>              
							</div>
						</div>

						
					</div>
					<p class="price">$<?php echo $row['price'];?></p>
					</div>

					
				<?php	}  }?>
				</div>

			<div id="UserComments" class="mybigcontainer table-responsive ">
				<h2 class="text-center my-5">Comments added by <?php echo $username;?></h2>
				<?php	if (!empty($commentsUser)) { ?>
				<table class="table table-bordered text-center table-main">
					<thead>
					<tr>
						<th scope="col">#ID</th>
						<th scope="col">Comment</th>
						<th scope="col">Comment Time</th>
						<th scope="col">Item</th>
						<th scope="col">User</th>
						<th scope="col">Control</th>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach ($commentsUser as $row) {
						echo "<tr>";
						echo "<td>" . $row['comid'] . "</td>";
						echo "<td>"  . $row['comment'] . "</td>";
						echo "<td>"  . $row['datetime'] . "</td>";
						echo "<td><a href='items.php?do=details&itemid=" . $row['itemid_bind'] ."'>" . $row['name'] . "</a></td>";
						echo "<td><a href='members.php?do=profile&userid=" . $row['userid_bind'] ."'>" . $row['username'] . "</a></td>";
						?>

							<td>
							<a href="comments.php?do=delete&comid=<?php echo $row['comid']; ?>" class='btn btn-danger table-control'>Delete <i class='fa fa-trash'></i></a>
							<?php if (ispending("comid", "comments", $row['comid'] , "status") > 0) { ?>
							<a href="comments.php?do=activate&comid=<?php echo $row['comid']; ?>" class='btn btn-info table-control'>Activate <i class='fa fa-check'></i></a>
							<?php } ?>
							</td>
						</tr>

					<?php } ?>
					</tbody>
				</table>

				<?php	}
				else {

					$msg = "<div class='alert alert-warning text-center'>There is no any comments added by $username yet</div>";
					echo($msg);
				
				} ?>
			</div>
		</div>
	<?php		
	 }
	else {

		// show Error alert [Error 404]


			$msg = "<div class='alert alert-danger text-center'>Sorry, We couldn't find this page Error 404, Find a solution <a href='https://www.ionos.com/digitalguide/websites/website-creation/what-does-the-404-not-found-error-mean/' target='_blank'>here</a></div>";
			redirect($msg, 'dashbord.php', 'Dashboard Page');?>
			<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>


 <?php } ?>
			</div>
		</div>
	</div>


<?php }
else {
// when open the script direct

	header('location: index.php');
	exit;
}
	include $temp . "footer.php";
	ob_end_flush();
?>
	</div>
</div>