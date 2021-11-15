<?php

	ob_start();
	session_start();

	if (isset($_SESSION['username'])) {

		// when come from index.php and have registerd session

		$pagetitle = "Categories";
		include "ini.php";
		$do = ""; ?>
    <div>
      <div style="width: 18%; height:100%; position:fixed; z-index:1000">
        <?php include "includes/temp/sidebar.php"?>
      </div>
      
      <div style="display: flex;">
        <div style="flex-basis: 18%;"></div>
        <div style="flex-basis: 82%; width:82%">
<?php		if (isset($_GET["do"])) {
			$do = $_GET['do'];
		} else {
			$do = "mange";
		}

		if ($do === "mange") {
      // Mange page code
      $rows = count_and_fetch("categories", "all", "fetch", "", "", "ORDER BY ordering");
      ?>

            <!--nav class="navbar navbar-expand-lg navbar-light bg-light">
              <a class="navbar-brand" href="#">Navbar</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                  </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                  <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
              </div>
            </nav-->
            <div class="mybigcontainer" id="Category">
              <?php if ($rows > 0) { ?>
              <h2 class="text-center my-5">Categories</h2>
              <div  class="row">
              <?php
              foreach ($rows as $row) { ?>
              <div class="card col-md-4" >
                <div class="card-body">
                  <div style="display: flex; justify-content:space-between">
                    <h5 class="card-title"><?php echo $row['name'] ?></h5>
                  </div>
                  <div>
                    <a href="categories.php?do=show&catid=<?php echo $row['catid']?>&catname=<?php echo $row['name']?>" class="btn btn-primary">Open Details</a>
                    <a style="z-index: 20" href='categories.php?do=edit&catid=<?php echo $row['catid']?>'class='btn btn-success '> <i class='fa fa-edit'></i></a>
                    <a style="z-index: 20" href='categories.php?do=delete&catid=<?php echo $row['catid']?>' class='btn btn-danger '> <i class='fa fa-trash'></i></a>
                  </div>
                </div>
              </div>
            <?php	} ?>
            </div>


            <?php } else {
              $msg = "<div class='alert alert-warning text-center'>There is no any members yet</div>";
              redirect($msg, 'dashbord.php', 'Dashboard Page');?>
              <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
      <?php  } ?>

            <a href="?do=add" class="save btn btn-primary"><i class="fa fa-plus"></i> New Category</a>
          </div>
	<?php }

    elseif ($do === "add") {
      // Add page code
      // Add categories ?>
			<div class="container">

				<h2 class="myblue text-center my-5">Add New Categories</h2>
				<form class="categories" novalidate action="?do=insert" method="post" id="add">
					<div class="form-group row">
						<label class="col-md-3" for="name">Name:</label>
						<input type="text" class="form-control col-md-9" id="name" name="name" placeholder="Type category name here" required="required">
						<p class="col-md-9 ml-auto validate uservalidate0">Please fill out category name</p>
						<p class="col-md-9 ml-auto validate uservalidate1">Please type at least 3 letters in category name</p>
					</div>
					<div class="form-group row">
						<label  class="col-md-3" for="description">Description:</label>
						<textarea  class="form-control col-md-9" id="description" name="description" rows="10" placeholder="Type category description here"></textarea>
					</div>
					<div class="form-group row">
						<label  class="col-md-3" for="ordering">Ordering:</label>
						<input type="number" class="form-control col-md-9" id="ordering" name="ordering" placeholder="Type ordering number here" >
					</div>
					
          <div class="form-group">
						<input class="save btn btn-primary"  type="submit"  value="Save">
					</div>
				</form>
			</div>

    <?php } elseif ($do === "insert") {
      // Insert page code

  		echo "<h2 class='myblue text-center my-5'>Insert Members</h2>";

  		if ($_SERVER['REQUEST_METHOD'] === "POST") {

  			// we come from request method to insert page

  			// fetch data from form by post request

  			$name = $_POST['name'];
  			$desc = $_POST['description'];
  			$ordering = ($_POST['ordering']);
  			

  			// Validate in server side

  		if (empty($name)) {

          $msg = "<div class='alert alert-danger text-center'>Name of category is required</div>";
          redirect($msg, 'dashbord.php', 'Dashboard Page');?>
          <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

<?php  } else {
        // check if there same catname in DB

        if (isindb("name", "categories", $name, "catid", -1) > 0) {
          // name is in DB

            $msg = "<div class='alert alert-danger text-center'>name $name is existed try other category name</div>";
            redirect($msg, 'dashbord.php', 'Dashboard Page');?>
            <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

 <?php  } else {

        // insert to DB depent of these data

        $check = insert_user_data("categories", "name", "'$name'", "description", "'$desc'", "ordering", "'$ordering'");


        // check if insert success

        if ($check > 0) {


            $msg ="<div class='alert alert-success text-center'>Insert Succeded,  $check row inserted</div>";
            redirect($msg, 'categories.php', 'Categories Page');?>
            <a href="categories.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Categories Page Now</a>

    <?php } else {

           $msg ="<div class='alert alert-danger text-center'>Insert Faild,  $check row inserted</div>";
           redirect($msg, 'categories.php', 'Categories Page');?>
           <a href="categories.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Categories Page Now</a>

   <?php

         }
       }
     }
      // add button ?>
          <a href="?do=add" class="save btn btn-primary"><i class="fa fa-plus"></i>  New Member</a>

  	<?php } else {

  			$msg ="<div class='alert alert-danger text-center'>Sorry you can't open this page direct, Try again</div>";
        redirect($msg, 'dashbord.php', 'Dashboard Page');?>
        <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>


<?php } }
     elseif ($do === "edit") {
      // Edit page code
      // Edit Page

      // check if userid in get request and numeric

      $catid = (isset($_GET['catid']) && is_numeric($_GET['catid'])) ?  $_GET['catid'] : 0;
      // build a query to fetch all data depend with that query

      $row = select_user_data("categories", "catid", $catid);

      // add checked or not
      /*
      $checkvisiblity1 = $checkvisiblity0 = $checkallowcom1 = $checkallowcom0 = $checkallowads1 = $checkallowads0 = "";
      $checked = "checked";
      if ($row['visiblity'] == 1) {
        $checkvisiblity1 = $checked;
      } else {
        $checkvisiblity0 = $checked;
      }

      if ($row['allow_comments'] == 1) {
        $checkallowcom1 = $checked;
      } else {
        $checkallowcom0 = $checked;
      }

      if ($row['allow_ads'] == 1) {
        $checkallowads1 = $checked;
      } else {
        $checkallowads0 = $checked;
      }
*/
      // check if userid in DB

      if (!empty($row)) {

        // We found this id in DB

        // Show Edit form ?>

        <div class="container">

          <h2 class="myblue text-center my-5">Edit categories</h2>
          <form class="categories" novalidate action="?do=update" method="post" id="edit">
            <input type="hidden" name="catid" value="<?php echo $row['catid']; ?>">
  					<div class="form-group row">
  						<label class="col-md-3" for="name">Name:</label>
  						<input type="text" class="form-control col-md-9" id="name" name="name" value = "<?php echo $row['name']; ?>" required="required">
  						<p class="col-md-9 ml-auto validate uservalidate0">Please fill out category name</p>
  						<p class="col-md-9 ml-auto validate uservalidate1">Please type at least 3 letters in category name</p>
  					</div>
  					<div class="form-group row">
  						<label  class="col-md-3" for="description">Description:</label>
  						<textarea class="form-control col-md-9" rows="10" id="description" name="description" ><?php echo $row['description']; ?></textarea>
  					</div>
  					<div class="form-group row">
  						<label  class="col-md-3" for="ordering">Ordering:</label>
  						<input type="number" class="form-control col-md-9" id="ordering" name="ordering" value="<?php echo $row['ordering']; ?>" >
  					</div>
  					<!--div class="form-group row">
  						<label  class="col-md-5" >Visiblity:</label>
              <div class="form-check  col-md-4">
                <input class="form-check-input" type="radio" name="visiblity" id="visiblity1" value="1" >
                <label class="form-check-label" for="visiblity1">True</label>
              </div>
              <div class="form-check col-md-auto">
                <input class="form-check-input" type="radio" name="visiblity" id="visiblity0" value="0" >
                <label class="form-check-label" for="visiblity0">False</label>
              </div>
            </div>

            <div class="form-group row">
  						<label  class="col-md-5" >Allow Comments:</label>
              <div class="form-check  col-md-4">
                <input class="form-check-input" type="radio" name="allow_comments" id="allow_comments1" value="1" >
                <label class="form-check-label" for="allow_comments1">True</label>
              </div>
              <div class="form-check col-md-auto">
                <input class="form-check-input" type="radio" name="allow_comments" id="allow_comments0" value="0" >
                <label class="form-check-label" for="allow_comments0">False</label>
              </div>
            </div>

            <div class="form-group row">
  						<label  class="col-md-5" >Allow advertisings:</label>
              <div class="form-check  col-md-4">
                <input class="form-check-input" type="radio" name="allow_ads" id="allow_ads1" value="1" >
                <label class="form-check-label" for="allow_ads1">True</label>
              </div>
              <div class="form-check col-md-auto">
                <input class="form-check-input" type="radio" name="allow_ads" id="allow_ads0" value="0" >
                <label class="form-check-label" for="allow_ads0">False</label>
              </div>
            </div-->
            <div class="form-group">
  						<input class="save btn btn-primary"  type="submit"  value="Save">
  					</div>
  				</form>
        </div>

      <?php }  else {

  			// show Error alert [Error to find id]


  				$msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
          redirect($msg, 'dashbord.php', 'Dashboard Page');?>
          <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
 <?php   }
    } elseif ($do === "update") {
      // Update page code

      // Update Page

      echo "<h2 class='myblue text-center my-5'>Update Categories</h2>";

      if ($_SERVER['REQUEST_METHOD'] === "POST") {

        // we come from request method to update page

        // fetch data from form by post request

        $id = $_POST['catid'];
        $name = $_POST['name'];
        $desc = addslashes($_POST['description']);
        $ordering = $_POST['ordering'];
  

        // Validate in server side

        if (empty($name)) {
          $msg = "<div class='alert alert-danger text-center'>Name of category is required</div>";
          redirect($msg, 'dashbord.php', 'Dashboard Page');?>
          <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
<?php  } else {

          // check if name in DB

          if (isindb("name", "categories", $name, "catid", $id) > 0) {

            // username is exisits in DB

            $msg = "<div class='alert alert-danger text-center'>Name $name is existed try other name</div>";
            redirect($msg, 'dashbord.php', 'Dashboard Page');?>
            <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

   <?php  } else {

            // update DB depent of these data

            $check = update_user_data("categories",
                                      "catid = '$id'",
                                      "name = '$name'",
                                      "description = '$desc'",
                                      "ordering= '$ordering'"
                                        );

            // check if update success

            if ($check > 0) {


                $msg = "<div class='alert alert-success text-center'>Update Succeded, $check row updateded</div>";
                redirect($msg, 'categories.php', 'Categories Page');?>
                <a href="categories.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Categories Page Now</a>
    
        <?php

             } else {


                $msg = "<div class='alert alert-danger text-center'>Update Faild,  $check row updateded</div>";
                redirect($msg, 'categories.php', 'Categories Page');?>
                <a href="categories.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Categories Page Now</a>
    
        <?php
             }


          }

        }
      }
      else {


        $msg ="<div class='alert alert-danger text-center'>Sorry you can't open this page direct, Try again</div>";
        redirect($msg, 'dashbord.php', 'Dashboard Page');?>
        <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

<?php }
    } elseif ($do === "delete") {

      // Delete page code

			// check if userid in get request and numeric

			$catid = (isset($_GET['catid']) && is_numeric($_GET['catid'])) ?  $_GET['catid'] : 0;
			// build a query to fetch all data depend with that query

			$row = select_user_data("categories", "catid", $catid);

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
									<a class="close" href="categories.php" aria-label="Close">
									 <span aria-hidden="true">&times;</span>
									</a>
							</div>
							<div class="modal-body">
								 Are you really sure want to delete <?php echo $row['name']; ?> category?
						 </div>
						<div class="modal-footer">
								<a  class="btn btn-secondary" href="categories.php">Cancel</a>
								<a  class="btn btn-danger" href="categories.php?do=deleteaccess&catid=<?php echo $row['catid']; ?>&name=<?php echo $row['name']; ?>">Delete</a>
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

    } elseif ($do === "deleteaccess") {
      // deleteaccess page code.
			$id = $_GET['catid'];
			$name = $_GET['name'];
			$check = delete_row("categories", "catid", $id, "AND name = '$name'");

			if ($check > 0) {


					$msg = "<div class='alert alert-success text-center'>$name category has been deleted</div>";
          redirect($msg, 'categories.php', 'Categories Page');?>
          <a href="categories.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Categories Page Now</a>

  <?php


			}
		 else {

				$msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
        redirect($msg, 'dashbord.php', 'Dashboard Page');?>
        <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

<?php }
    } else if ($do == "show") {
      // Logic
      // get items in this cat

      $catid = $_GET['catid'];
      $catname = $_GET['catname'];
      $items = get_cat_items($catid);
      $cat = select_user_data("categories", "catid", $catid );

      ?>
      <nav class="navbar navbar-expand-lg navbar-dark " style="background-color: rgba(87, 87, 97, .9); padding: 5px 40px;">
      <a  class="navbar-brand" href="#"><h4><?php echo $catname?></h4></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse row" id="navbarSupportedContent" >
          <div class="row ml-auto" style="justify-content: space-between;">
            <a  href='categories.php?do=edit&catid=<?php echo $catid?>'class='btn myprimary'> <i class='fa fa-edit'></i> Edit <?php echo $catname?> category</a>
            <a  href='categories.php?do=delete&catid=<?php echo $catid?>' class='btn mydanger '> <i class='fa fa-trash'></i> Delete <?php echo $catname?> category</a>            
            <a  href='items.php?do=add&catid=<?php echo $catid; ?>' class='btn myinfo '> <i class='fa fa-plus'></i> Add new item to <?php echo $catname?> category</a> 
          </div>
        
        </div>
      </nav>
      <div class="mybigcontainer table-responsive" style="margin-bottom: 10px;">

        <?php if (!empty($items)) { ?>
        <!-- <h2 class="text-center my-5"><?php echo $catname?></h2> -->



        <div class="row justify-content-between " style="padding:10px; margin-top:20px">
        <div class="col-md-3 row">
          <div id="slide4" class="slide col-md-12 chartParent" style="padding: 0;">
            <div>
              <h5 class="text-center">Total <?php echo $catname; ?> Items</h5>
              <p class="text-center" style="font-size:64px;"><i class="fa fa-lg fa-shopping-cart"></i> <?php echo get_cat_items($catid, "count"); ?></p>
              <button  class="stretched-link smoothScroll" data-scroll="catItems"></button>
            </div>

            <span></span>
          </div>
          <div id="slide5" class="slide col-md-12 chartParent"  style="padding: 0;">
            <div>
              <h5 class="text-center">Total <?php echo $catname; ?> Comments</h5>
              <p class="text-center" style="font-size:64px;"><i class="fa fa-lg fa-comment" ></i> <?php echo getCommentsCat($catid, "count"); ?></p>
              <button  class="stretched-link smoothScroll" data-scroll="catComments"></button>
            </div>

            <span></span>
          </div>
        </div >
        <div class="row col-md-9">
        <div class="chartParent  col-md-12" style="border-right:3px solid #f0f0f0">
            <p style="font-weight: bold;">All <?php echo $catname; ?> Items:</p>
            <div class="AllPriceParent">
              <div class="AllPrice"  data-toggle="tooltip" data-placement="right"
              title="<p>New: $<?php echo sum_price("all", "'new'", $catid); ?></p> <p>Like New: $<?php echo sum_price("all", "'like_new'", $catid); ?></p> <p>Old: $<?php echo sum_price("all", "'old'", $catid); ?></p>">
                $<?php echo sum_price("all", "", $catid); ?> 
              </div>
            </div>
          </div>
          <div class="chartParent  col-md-4" style="border:3px solid #f0f0f0" >
            <p style="font-weight: bold;">All <?php echo $catname; ?> Offered Items:</p>
            <div class="AllPriceParent">
              <div class="AllItemsPrice" data-toggle="tooltip" data-placement="right" 
                title="<p>New: $<?php echo sum_price("itemsoffered", "'new'", $catid); ?></p> <p>Like New: $<?php echo sum_price("itemsoffered", "'like_new'", $catid); ?></p> <p>Old: $<?php echo sum_price("itemsoffered", "'old'", $catid); ?></p>">
                $<?php echo sum_price("itemsoffered", "", $catid); ?>
              </div>
            </div>
          </div>
          <div class="chartParent  col-md-4" style="border-left:3px solid #f0f0f0" >
            <p style="font-weight: bold;">All <?php echo $catname; ?> Pending Items:</p>
            <div class="AllPriceParent">
              <div class="AllPendingPrice" data-toggle="tooltip" data-placement="right" 
                title="<p>New: $<?php echo sum_price("pending", "'new'", $catid); ?></p> <p>Like New: $<?php echo sum_price("pending", "'like_new'", $catid); ?></p> <p>Old: $<?php echo sum_price("pending", "'old'", $catid); ?></p>">
                $<?php echo sum_price("pending", "", $catid); ?>
              </div>
            </div>
          </div>
          <div class="chartParent  col-md-4" style="border-left:3px solid #f0f0f0" >
            <p style="font-weight: bold;">All <?php echo $catname; ?> Sold Items:</p>
            <div class="AllPriceParent">
              <div class="AllSellsPrice" data-toggle="tooltip" data-placement="right" 
                title="<p>New: $<?php echo sum_price("sells", "'new'", $catid); ?></p> <p>Like New: $<?php echo sum_price("sells", "'like_new'", $catid); ?></p> <p>Old: $<?php echo sum_price("sells", "'old'", $catid); ?></p>">
                $<?php echo sum_price("sells", "", $catid); ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="description">
          <h4>Description:</h4>
          <p style="max-height:300px; overflow:auto" class="niceText"><?php echo $cat['description']; ?></p>
      </div>
        
      <div class="myRating">
        <h4>Rating:</h4>
        <div class="row justify-content-between chartParent">
          <input id ="catid" type="hidden" value=' <?php echo $catid; ?>' />
          <div class="rateItemsCatLineChart">
            <p style="font-weight: bold;">The rate of <?php echo $catname ?> Offered  Items over time</p>
            <canvas id="rateItemsCatLineChart" width="600" height="400"></canvas>
          </div>
          <div class="rateSellsCatLineChart">
            <p style="font-weight: bold;">The rate of <?php echo $catname ?> sold Items over time</p>
            <canvas id="rateSellsCatLineChart" width="600" height="400"></canvas>
          </div>								
        </div>
      </div>
      <div class="row justify-content-between chartParent">

        <input id ="newItemsCount" type="hidden" value=' <?php echo count_and_fetch_items("offered", "count", "'new'", "",  $catid); ?>' />
        <input id ="likeNewItemsCount" type="hidden" value=' <?php echo count_and_fetch_items("offered", "count", "'like_new'", "",  $catid); ?>' />
        <input id ="oldItemsCount" type="hidden" value=' <?php echo count_and_fetch_items("offered", "count", "'old'", "",  $catid); ?>' />
        <div class="statusItemsPieChart">
          <p style="font-weight: bold;">Divisions of <?php echo $catname?> offered items</p>
          <canvas id="statusItemsPieChart" style="width: 600px; height:400px"></canvas>
        </div>

        <input id ="newSellsCount" type="hidden" value=' <?php echo count_and_fetch_items("sells", "count", "'new'", "",  $catid); ?>' />
        <input id ="likeNewSellsCount" type="hidden" value=' <?php echo count_and_fetch_items("sells", "count", "'like_new'", "", $catid); ?>' />
        <input id ="oldSellsCount" type="hidden" value=' <?php echo count_and_fetch_items("sells", "count", "'old'", "",  $catid); ?>' />
        <div class="statusSellsPieChart">
          <p style="font-weight: bold;">Divisions of <?php echo $catname?> bought items</p>
          <canvas id="statusSellsPieChart" style="width: 600px; height:400px"></canvas>
        </div>

      </div>
      <div class="row justify-content-between chartParent">
        <div class="top5UserItemsBarChartCat">
          <p style="font-weight: bold;">Top 5 users offered <?php echo $catname; ?> items</p>
          <canvas id="top5UserItemsBarChartCat" style="width: 600px; height:400px"></canvas>
        </div>		
        <div class="top5UserSellsBarChartCat">
          <p style="font-weight: bold;">Top 5 users bought <?php echo $catname; ?> items</p>
          <canvas id="top5UserSellsBarChartCat" style="width: 600px; height:400px"></canvas>
        </div>				
      </div>
      <div class="row">
        <?php 
          $rowsitemsnewCat = get_latest("allItems","'new'" , $catid);
          $rowsitemslikenewCat = get_latest("allItems","'like_new'",$catid);
          $rowsitemsoldCat = get_latest( "allItems", "'old'",$catid);
          $rowscommentsCat5 = getCommentsCat($catid, "", "LIMIT 5");
          $rowscommentsCat = getCommentsCat($catid);
        ?>
        <div class="col-md-4 latest chartParent">
          <div class="row justify-content-between m-3">
            <p style="font-weight: bold;">Latest 5 new items added to <?php echo $catname; ?></p>
            <button class="slidebutton" data-class="show"><i class="fa fa-minus fa-lg " ></i></button>
            <button class="slidebutton hidden" data-class="hide"><i class="fa fa-plus fa-lg " ></i></button>
          </div>
          <div class="mylist">
            <?php
            if (!empty($rowsitemsnewCat)) {
                foreach ($rowsitemsnewCat as $value) { ?>
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
            <p style="font-weight: bold;">Latest 5 like new items added to <?php echo $catname; ?></p>
            <button class="slidebutton" data-class="show"><i class="fa fa-minus fa-lg " ></i></button>
            <button class="slidebutton hidden" data-class="hide"><i class="fa fa-plus fa-lg " ></i></button>
          </div>
          <div class="mylist">
            <?php
            if (!empty($rowsitemslikenewCat)) {
                foreach ($rowsitemslikenewCat as $value) { ?>
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
            <p style="font-weight: bold;">Latest 5 old items added to <?php echo $catname; ?></p>
            <button class="slidebutton" data-class="show"><i class="fa fa-minus fa-lg " ></i></button>
            <button class="slidebutton hidden" data-class="hide"><i class="fa fa-plus fa-lg " ></i></button>
          </div>
          <div class="mylist">
            <?php
            if (!empty($rowsitemsoldCat)) {
                foreach ($rowsitemsoldCat as $value) { ?>
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
            <p style="font-weight: bold;">Latest 5 comments in <?php echo $catname;?></p>
            <button class="slidebutton" data-class="show"><i class="fa fa-minus fa-lg " ></i></button>
            <button class="slidebutton hidden" data-class="hide"><i class="fa fa-plus fa-lg " ></i></button>
          </div>
          <div class="mylist">
            <?php
            if (!empty($rowscommentsCat5)) {
                foreach ($rowscommentsCat5 as $value) { ?>
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
      <div id="catItems">
        <h2 class="text-center my-5"><?php echo $catname?> Items</h2>

        <div class=navbar_works>
          <ul>
            <li class="selected filter" data-filter="all">All</li>
            <li class="filter" data-filter="offered">Offered</li>
            <li class="filter" data-filter="sold">Sold</li>
            <li class="filter" data-filter="pending">Pending</li>
            <li class="filter" data-filter="new">New</li>
            <li class="filter" data-filter="like_new">Like New</li>
            <li class="filter" data-filter="old">Old</li>
          </ul>
        </div>
        <div class="row chartParent" style="min-height: 600px;">
              <div class="noFilter alert-warning">
                        There is no any item in this filter
              </div>
  <?php  foreach ($items as $row) { 
          // get item comments ?>
        <!--div id="filterParent"-->

        <?php
          $status = $row['status'];

          $comments = getCommentsItem($row['itemid']);
          // get item buy details
          $bought = false;
          $pending = false;
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
          // filter cat items
          ?>

        <div class="card col-md-4 <?php if ($bought) echo "sold "; else if ($pending) echo "pending "; else echo "offered ";
                                        if ($status == 'new') echo "new";  else if ($status == 'old') echo "old"; else echo "like_new";  ?> " >
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

        
    <?php	} ?>
    </div>
    <?php }	else {
      				if (isset($_GET['search'])) {

                $msg = "<div class='alert alert-warning text-center'>There is no any result about item '$search' in $catname category </div>";
                redirect($msg, 'categories.php', 'Categories Page');?>
                <a href="categories.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Categories Page Now</a>
    
        <?php
              } else {
                $msg = "<div class='alert alert-warning text-center'>There is no any items in $catname category  </div>";
                redirect($msg, 'categories.php', 'Categories Page');?>
                <a href="categories.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Categories Page Now</a>
    
        <?php
              }

      }
?>
      </div>
      <div id="catComments" class="mybigcontainer table-responsive ">
      <h2 class="text-center my-5">Comments on <?php echo $catname;?></h2>
      <?php	if (!empty($rowscommentsCat)) { 
          if (isset($_GET['search'])) { ?>
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
          foreach ($rowscommentsCat as $row) {
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
      if (isset($_GET['search'])) {

        $msg = "<div class='alert alert-warning text-center'>There is no any result about comment '$search' on $catname</div>";
        echo($msg);
      } else {
        $msg = "<div class='alert alert-warning text-center'>There is no any comments on $catname yet</div>";
        echo($msg);
      }
      } ?>
      </div>
    </div>

    
<?php  }  else {

    		// show Error alert [Error 404]

    			$msg = "<div class='alert alert-danger text-center'>Sorry, We couldn't find this page Error 404, Find a solution <a href='https://www.ionos.com/digitalguide/websites/website-creation/what-does-the-404-not-found-error-mean/' target='_blank'>here</a></div>";
          redirect($msg, 'dashbord.php', 'Dashboard Page');?>
          <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

<?php } ?>
        </div>
      </div>
    </div>    
    
<?php    }
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