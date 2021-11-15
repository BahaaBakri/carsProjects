<?php
  ob_start();
	session_start();
    if (isset($_SESSION['uid'])) { 
        $userid = $_SESSION['uid'];
        $pagetitle = "Account";
		include "ini.php";
        $do = "";
        if (isset($_GET["do"])) {
            $do = $_GET['do'];
        } else {
            $do = "";
        }
        if ($do === "edit") {
            // echo "Edit";
            $row = select_user_data("users", "userid", $userid);
            if (!empty($row)) { ?>
				<div class="container" style="margin-top: 70px;">

                    <h2 class="myblue text-center my-5">Edit My Account</h2>
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
 <?php  }  } else if ($do === "update") { ?>
			

			<h2 class='myblue text-center' style="margin-top: 80px;">Update Account</h2>

	<?php	if ($_SERVER['REQUEST_METHOD'] === "POST") {

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
						redirect($msg, 'index.php', 'Home Page'); ?>
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
                                redirect($msg, "profile.php?userid=$userid","Profile Page"); ?>
                                <a href="profile.php?userid=<?php echo $userid ?>" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Profile Page Now</a>
                <?php

						 } else {


								$msg = "<div class='alert alert-danger text-center'>Update Faild,  $check  row updateded</div>";
                                redirect($msg, "profile.php?userid=$userid","Profile Page"); ?>
                                <a href="profile.php?userid=<?php echo $userid ?>" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Profile Page Now</a>

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
				redirect($msg, 'index.php', 'Home Page'); ?>
				<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

<?php
} 
        }  else if ($do === "delete") {
            $row = select_user_data("users", "userid", $userid);
			if (!empty($row)) { ?>
				<!-- Button trigger modal -->
				<input type="hidden" class="triggermodal" data-toggle="modal" data-target="#staticBackdrop">
				<!-- Modal -->
				<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				  <div class="modal-dialog modal-dialog-centered">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="staticBackdropLabel">Confirm Delete</h5>
					       	<a class="close" href="profile.php?userid=<?php echo $userid ?>" aria-label="Close">
					         <span aria-hidden="true">&times;</span>
			        		</a>
					    </div>
					    <div class="modal-body">
					       Are you really sure want to delete your membership ?
				     </div>
			      <div class="modal-footer">
				        <a  class="btn btn-secondary" href="profile.php?userid=<?php echo $userid ?>">Cancel</a>
				        <a  class="btn btn-danger" href="members.php?do=deleteaccess&userid=<?php echo $userid ?>">Delete</a>
					  </div>
			    </div>
			  </div>
			</div>

		<?php }
        } else if ($do === "deleteaccess") {
			$id = $_GET['userid'];
			$check = delete_row("users", "userid", $id);

			if ($check > 0) {

					
						$msg = "<div class='alert alert-success text-center'>Your membership has been deleted</div>";
						redirect($msg,"logout.php", "out");?>
						<a href="logout.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go Out Now</a>
		
	<?php	}
		 else {

				$msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
				redirect($msg, 'index.php', 'Home Page'); ?>
				<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

	<?php	 }            
        }

        
        
        } else { ?>
            <div style="margin-top: 60px;">
            <div class='alert alert-warning text-center'>Log in or sign up first</div>
            <div class="row" style="justify-content: space-between; width:25%; margin:auto">
                <a href="loginsignup.php?do=login"class="btn btn-primary my-2 my-sm-0 text-white">Login <i class="fa fa-user-circle fa-lg"></i></a>
                <a href="loginsignup.php?do=signup"class="btn btn-success my-2 my-sm-0 text-white">Sign up <i class="fa fa-user-circle fa-lg"></i></a>
                <a href="javascript:history.back()" class=" btn btn-secondary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page </a>
        
            </div>
            </div>

<?php   }
        include $temp . "footer.php";
        ob_end_flush();
?>
    