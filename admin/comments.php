<?php

	ob_start();
	session_start();

	if (isset($_SESSION['username'])) {

		// when come from index.php and have registerd session

		$pagetitle = "Comments";
		include "ini.php";
		$do = ""; ?>
	<div>
		<div style="width: 18%; height:100%; position:fixed; z-index:1000">
			<?php include "includes/temp/sidebar.php"?>
		</div>
		
		<div style="display: flex;">
			<div style="flex-basis: 18%;"></div>
			<div style="flex-basis: 82%; width:82%">
	<?php	if (isset($_GET["do"])) {
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

		if ($do === "mange") {

		 //Manger Page

		// build a query to fetch comments
		if (!empty($search)) {
			$statment = $con->prepare("SELECT comments.*, users.username as membername, items.name as itemname FROM comments INNER JOIN items ON comments.itemid_bind = items.itemid INNER JOIN users ON comments.userid_bind = users.userid WHERE comments.comment LIKE '%$search%' ORDER BY comid DESC");
		} else {
			$statment = $con->prepare("SELECT comments.*, users.username as membername, items.name as itemname FROM comments INNER JOIN items ON comments.itemid_bind = items.itemid INNER JOIN users ON comments.userid_bind = users.userid ORDER BY comid DESC");
		}
		$statment->execute();
		$rows = $statment->fetchAll();

		// We found this id in DB ?>
		<!-- Show mange form -->
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a hidden class="navbar-brand" href="#">Navbar</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<form class="form-inline my-2 my-lg-0">
					<input class="inputSearch searchComment form-control mr-sm-2" type="search" placeholder="Search Comment" aria-label="Search" value="<?php echo $search; ?>">
					<a class="btn btn-outline-primary my-2 my-sm-0" href="#" >Search</a>
				</form>
			</ul>

		</div>
		</nav>
		<?php	if (!empty($rows)) {

			 ?>


			<!-- Show mange table -->
			<div class="mybigcontainer table-responsive">
				<h2 class="text-center my-5">Comments</h2>

			<?php if (isset($_GET['search'])) { ?>
					<p  style="font-size: 32px; font-weight:bold">Search result about '<?php echo $search;?>' : </p>
				<?php }
				?>
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
						foreach ($rows as $row) {
							echo "<tr>";
								echo "<td>" . $row['comid'] . "</td>";
								echo "<td>"  . $row['comment'] . "</td>";
								echo "<td>"  . $row['datetime'] . "</td>";
								echo "<td><a href='items.php?do=details&itemid=" . $row['itemid_bind'] ."'>" . $row['itemname'] . "</a></td>";
								echo "<td><a href='members.php?do=profile&userid=" . $row['userid_bind'] ."'>" . $row['membername'] . "</a></td>";
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
				if (isset($_GET['search'])) {

					$msg = "<div class='alert alert-warning text-center'>There is no any result about comment '$search'</div>";
					redirect($msg, 'comments.php', 'Comments Page');?>
					<a href="comments.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Comments Page Now</a>
		<?php	} else {
					$msg = "<div class='alert alert-warning text-center'>There is no any comments yet</div>";
					redirect($msg, 'dashbord.php', 'Dashboard Page');?>
					<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
		<?php	}
			} ?>
		</div>
	<?php }

	elseif ($do === "delete") {
			// delete page

			// check if comid in get request and numeric

			$comid = (isset($_GET['comid']) && is_numeric($_GET['comid'])) ?  $_GET['comid'] : 0;
			// build a query to fetch all data depend with that query

			$row = select_user_data("comments", "comid", $comid);

			// data from users table

			$member = select_user_data("users", "userid", $row['userid_bind']);

			// data from items table

			$item = select_user_data("items", "itemid", $row['itemid_bind']);

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
					       	<a class="close" href="comments.php" aria-label="Close">
					         <span aria-hidden="true">&times;</span>
			        		</a>
					    </div>
					    <div class="modal-body">
					       Are you really sure want to delete <?php echo $member['username']; ?> comment on <?php echo $item['name'];?> item ?
				     </div>
			      <div class="modal-footer">
				        <a  class="btn btn-secondary" href="comments.php">Cancel</a>
				        <a  class="btn btn-danger" href="comments.php?do=deleteaccess&comid=<?php echo $row['comid']; ?>&username=<?php echo $member['username'];?>&itemname=<?php echo $item['name'];?>">Delete</a>
					  </div>
			    </div>
			  </div>
			</div>

		<?php }
		else {

			// There is no such id

			$msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
			redirect($msg, 'dashbord.php', 'Dashboard Page');?>
			<a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
	<?php }

	 }

	elseif ($do === "deleteaccess") {


			$id = $_GET['comid'];
			$user = $_GET['username'];
			$item = $_GET['itemname'];

			$check = delete_row("comments", "comid", $id);

			if ($check > 0) {

				$msg = "<div class='alert alert-success text-center'>user $user comment on $item item has been deleted</div>";
				redirect($msg, 'comments.php', 'Comments Page');?>
				<a href="comments.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Comments Page Now</a>
	<?php	}
		 else {

				$msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
                redirect($msg, 'dashbord.php', 'Dashboard Page');?>
                <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

	<?php } } elseif ($do === "activate") {
			 // activate page

			$comid = (isset($_GET['comid']) && is_numeric($_GET['comid'])) ?  $_GET['comid'] : 0;

			// build a query to fetch all data depend with that query

			$row = select_user_data("comments", "comid", $comid);

			// data from users table

			$member = select_user_data("users", "userid", $row['userid_bind']);

			// data from items table

			$item = select_user_data("items", "itemid", $row['itemid_bind']);

 			// check if userid in DB

 			if (!empty($row)) { ?>
 				<!-- Button trigger modal -->
 				<input type="hidden" class="triggermodal" data-toggle="modal" data-target="#staticBackdrop">
 				<!-- Modal -->
 				<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
 				  <div class="modal-dialog modal-dialog-centered">
 				    <div class="modal-content">
 				      <div class="modal-header">
 				        <h5 class="modal-title" id="staticBackdropLabel">Confirm comment</h5>
 					       	<a class="close" href="comments.php" aria-label="Close">
 					         <span aria-hidden="true">&times;</span>
 			        		</a>
 					    </div>
 					    <div class="modal-body">
 					       Are you really sure want to activate <?php echo $member['username']; ?> comment on <?php echo $item['name'];?> item ?
 				     </div>
 			      <div class="modal-footer">
 				        <a  class="btn btn-secondary" href="comments.php">Cancel</a>
 				        <a  class="btn btn-info" href="comments.php?do=activateaccess&comid=<?php echo $row['comid']; ?>&username=<?php echo $member['username']; ?>&itemname=<?php echo $item['name'];?>">Activate</a>
 					  </div>
 			    </div>
 			  </div>
 			</div>

 		<?php }
 		else {

 			// There is no such id

 			$msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
			 redirect($msg, 'dashbord.php', 'Dashboard Page');?>
			 <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
 	<?php }

 	}

 	elseif ($do === "activateaccess") {


 			$id = $_GET['comid'];
 			$user = $_GET['username'];
			$item = $_GET['itemname'];

			$check = update_user_data("comments", "comid = $id", "status = 1");
 			if ($check > 0) {


 					$msg = "<div class='alert alert-success text-center'>$user comment on $item item has been activated</div>";
					 redirect($msg, 'comments.php', 'Comments Page');?>
					 <a href="comments.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Comments Page Now</a>

 	<?php	}
 		 else {

 				$msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
				 redirect($msg, 'dashbord.php', 'Dashboard Page');?>
				 <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

 	<?php }
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
</div>