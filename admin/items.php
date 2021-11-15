<?php

use function PHPSTORM_META\type;

ob_start();
	session_start();
	if (isset($_SESSION['username'])) {

		// when come from index.php and have registerd session
    //print_r($_SESSION['userid']);
    $pagetitle = "Items";
		include "ini.php";
		$do = "";

   


    ?>
    <div>
    <div style="width: 18%; height:100%; position:fixed; z-index:1000">
      <?php include "includes/temp/sidebar.php"?>
    </div>

    <!-- Show mange form -->
    <div style="display: flex;">
      <div style="flex-basis: 18%;"></div>
      <div style="flex-basis: 82%; width:82%">
    <?php
      $search = "all";
      $pricestatus = "all";
      $rating = "all";
      $status = "all";
      $show = "all";

    if (isset($_GET['action'])) {
      $search = $_GET['search'];
      $pricestatus = $_GET['price'];
      $rating = $_GET['rating'];
      $status = $_GET['status'];
      $show = $_GET['show'];


      $ratingStatment = ($rating == "all") ? "" : "AND rating = $rating";
      $statusStatment = ($status == "all") ? "": "AND status = '$status'";
      $showStatment = ($show== "all") ? "" :"AND bought = $show";
      $searchStatment = ($search== "all") ? "" :"AND items.name LIKE '%$search%'";
      if ($pricestatus == 'low') {
        $priceStatment = 'AND price < 2000';
      } else if ($pricestatus == 'medium') {
        $priceStatment = 'AND price BETWEEN 2000 AND 5000';
      } else if ($pricestatus == 'high') {
        $priceStatment = 'AND price > 5000';
      } else if ($pricestatus == 'all')  {
        $priceStatment = '';
      }
    } else {
      $ratingStatment = "";
      $statusStatment = "";
      $showStatment = "";
      $searchStatment = "";
      $priceStatment = "";
    }
		if (isset($_GET["do"])) {
			$do = $_GET['do'];
		} else {
			$do = "mange";
		}

		if ($do === "mange") { 
      // Mange page code
      // GET items depond on filters and search
      $statment = $con->prepare("SELECT items.*, users.*, categories.name as catname FROM users RIGHT OUTER JOIN items ON users.userid = items.userid_bind LEFT OUTER JOIN categories ON categories.catid = items.catid_bind WHERE 5>2 $ratingStatment $searchStatment $showStatment $statusStatment $priceStatment  ORDER BY itemid DESC");
      $statment->execute();
      $rows = $statment->fetchAll();
      ?>

			<!-- Show mange table -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Filter Items</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <form id="itemFilter" class="form-inline my-2 my-lg-0" method="GET" action="items.php">
            <input type="hidden" name="action" value="filter">

            <label for="show">Show:</label>
              <select class="form-control mx-2" id="#show" name="show">
                <option value="all" <?php if($show==='all') {echo "selected"; } ?> >All</option>
                <option value="0" <?php if($show==='0') {echo "selected"; } ?>>Offered Items</option>
                <option value="1" <?php if($show==='1') {echo "selected"; } ?>>Sold Items</option>
                <option value="2" <?php if($show==='2') {echo "selected"; } ?>>Pending Items</option>

              </select>

            <label for="status">Status:</label>
              <select class="form-control mx-2" id="#status" name="status">
                <option value="all" <?php if($status==='all') {echo "selected"; } ?> >All</option>
                <option value="new" <?php if($status==='new') {echo "selected"; } ?>>New</option>
                <option value="like_new" <?php if($status==='like_new') {echo "selected"; } ?>>Like New</option>
                <option value="old" <?php if($status==='old') {echo "selected"; } ?>>Old</option>
              </select>

              <label for="price">Price:</label>
              <select class="form-control mx-2" id="#price" name="price">
                <option value="all" <?php if($pricestatus==='all') {echo "selected"; } ?>>All</option>
                <option value="low" <?php if($pricestatus==='low') {echo "selected"; } ?>>< $2000</option>
                <option value="medium" <?php if($pricestatus==='medium') {echo "selected"; } ?>> > $2000 and < $5000</option>
                <option value="high" <?php if($pricestatus==='high') {echo "selected"; } ?>>> $5000</option>
              </select>

              <label for="rating">Rating:</label>
              <select class="form-control mx-2" id="#rating" name="rating">
                <option value="all" <?php if($rating==='all') {echo "selected"; } ?>>All</option>
                <option value="1" <?php if($rating=='1') {echo "selected"; } ?>>*</option>
                <option value="2" <?php if($rating=='2') {echo "selected"; } ?>>**</option>
                <option value="3" <?php if($rating=='3') {echo "selected"; } ?>>***</option>
                <option value="4" <?php if($rating=='4') {echo "selected"; } ?>>****</option>
                <option value="5" <?php if($rating=='5') {echo "selected"; } ?>>*****</option>
              </select>
              <button type="submit" class="btn btn-outline-primary mr-2 my-2 my-sm-0" >Filter</button>
              <a href="items.php?action=filter&show=all&status=all&price=all&rating=all&search=<?php echo $search?>" class="clearFilter btn btn-outline-primary my-2 my-sm-0" >Clear Filter</a>
          </ul>


          <div class="form-inline my-2 my-lg-0">
            <input type="hidden" name="search" >
            <input class="inputSearch searchItem  form-control mr-sm-2" type="search" placeholder="Search Item" value="<?php echo ($search == "all") ? "" : $search; ?>">
            <button type="submit" class="btn btn-outline-primary mr-2 my-2 my-sm-0" >Search</button>
          </div>
          </form>
        </div>
      </nav>
      <div class="mybigcontainer table-responsive">

        <?php if (!empty($rows)) { ?>
        <h2 class="text-center my-5">Items</h2>
    <?php  if (isset($_GET['search']) && $_GET['search'] !== "all") { ?>
					<p  style="font-size: 32px; font-weight:bold">Search result about '<?php echo $search;?>' : </p>
				<?php } ?>
        <div  class="row">
        <?php
        foreach ($rows as $row) { 
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

          //print_r($comments);
          ?>

        <div class="card col-md-4 <?php if ($bought) echo "sold"; else if ($pending) echo "pending"; else echo "offered" ?> " >
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
              <div><span>Declared By : </span><a class="mya" href='members.php?do=profile&userid=<?php echo $row['userid']?>'> <?php echo $row['username'] ?></a></div>
              <div class="text-muted"><?php echo $row['datetime'] ?></div>
            
            </div>
          <?php if ($bought || $pending) { ?>
            <div class="userCatActions">
              <div><span><?php echo ($bought) ? "Bought" : "Waited " ?> By : </span><a class="mya" href='members.php?do=profile&userid=<?php echo $buyDetails['userid']?>'> <?php echo $buyDetails['username'] ?></a></div>
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

                    <div  id="forScrollComments"
                          style="    height: 350px;
                                      overflow: auto;
                                      padding: 10px;
                                      border: 1px solid #AAA;
                                      background: #DDD">
                      <?php foreach ($comments as $comment) { ?>
                      <div class="border p-3 bg-light media mediacom mediacomnormallik">
                        <a href="members.php?do=profile&userid=<?php echo $comment['userid']?>" class='btn  table-control' style="padding:5px; margin-right:5px; width: 100px; height:100px; border-radius: 50%; border: 1px solid #333"  > 
                          <img style="border-radius: 50%" width="100%" height="100%"src="../dataset/uploaded/uploaded_avatar/<?php echo $comment['avatar']; ?>" onerror="this.src = 'layout/images/avatar.jpg'" />
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

                $msg = "<div class='alert alert-warning text-center'>There is no any result about item '$search'</div>";
                redirect($msg, 'items.php', 'Items Page');?>
                <a href="items.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Items Page Now</a>
      <?php    } else {
                $msg = "<div class='alert alert-warning text-center'>There is no any items </div>";
                redirect($msg, 'dashbord.php', 'Dashboard Page');?>
                <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
      <?php    }

      }
      ?>
      <a href="?do=add" class="save btn btn-primary"><i class="fa fa-plus"></i> New Item</a>
    </div>
  	<?php
    }  elseif ($do === "add") {
      // Add page code ?>
      <div class="mybigcontainer">
        
        <h2 class="myblue text-center my-5">Add New Item</h2>
        <div class="row">

          <div class="col-md-8">
            <form class="items  row" novalidate action="?do=insert" enctype="multipart/form-data" method="post" id="add">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-md-4" for="name">Name:</label>
                  <input type="text" class="form-control col-md-8" id="name" name="name" placeholder="Type item name here" required="required">
                  <p class="col-md-8 ml-auto validate reqvalidate">- Please fill out item name</p>
                  <p class="col-md-8 ml-auto validate namevalidate">- Please type at least 3 letters in item name</p>
                </div>
                <div class="form-group row">
                  <label  class="col-md-4" for="description">Description:</label>
                  <input type="text" class="form-control col-md-8" id="description" name="description" placeholder="Type item description here" required="required">
                  <p class="col-md-8 ml-auto validate reqvalidate">- Please fill out description</p>
                  <p class="col-md-8 ml-auto validate descvalidate">- Please type at least 20 letters in item name</p>
                </div>
                <div class="form-group row">
                  
                  <label  class="col-md-4" for="price">Price:</label>

                  <span class="col-md-1" style="line-height: 2;">$</span>
                  
                  <input type="text" class="form-control col-md-7" id="price" name="price" placeholder="Type price of item here" required="required">
                  <p class="col-md-8 ml-auto validate reqvalidate">- Please fill out the price</p>

                </div>

                <div class="form-group row">
                  <label  class="col-md-4" for="country">Country:</label>
                  <input type="text" class="form-control col-md-8" id="country" name="country" placeholder="Type country of made here" required="required">
                  <p class="col-md-8 ml-auto validate reqvalidate">- Please fill out country made</p>
                </div>
                <div class="form-group row">
                  <label  for="quality" class="col-md-4" >Quality:</label>

                  <select id="quality" name="quality" class="col-md-8 form-control" >
                    <option selected value=""></option>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                  </select>
                  <p class="col-md-8 ml-auto validate reqselectvalidate">- Please select the quality of item</p>
                </div>
                <div class="form-group row">
                  <label  for="status" class="col-md-4" >Status:</label>

                  <select id="status" name="status" class="col-md-8 form-control" required = "required">
                    <option selected value=""></option>
                    <option value="new">New</option>
                    <option value="like_new">Like new</option>
                    <option value="old">Old</option>
                  </select>
                  <p class="col-md-8 ml-auto validate reqselectvalidate">- Please select the status of item</p>
                </div>
                <div class="form-group row">
                  <label  for="rating" class="col-md-4" >Rating:</label>

                  <select id="rating" name="rating" class="col-md-8 form-control" required = "required">
                    <option selected value=""></option>
                    <option value="1">*</option>
                    <option value="2">* * </option>
                    <option value="3">* * * </option>
                    <option value="4">* * * * </option>
                    <option value="5">* * * * *</option>
                  </select>
                  <p class="col-md-8 ml-auto validate reqselectvalidate">- Please select the rating of item</p>


                </div>

                <div class="form-group row">
                  <label  for="member" class="col-md-4" >Member:</label>

                  <select id="member" name="member" class="col-md-8 form-control" required = "required">
                    <option selected value=''></option>
                    <?php

                    $members = count_and_fetch("users");
                    foreach ($members as $member) { ?>
                      <option value="'<?php echo $member['userid']?>'"
                        <?php if(isset($_GET['userid']) && $_GET['userid'] == $member['userid'] ) { echo "selected";} ?>>
                        <?php echo $member['username'];?>
                      
                      </option>
                  <?php }

                    ?>
                  </select>
                  <p class="col-md-8 ml-auto validate reqselectvalidate">- Please select the owner of item</p>
                </div>
                <div class="form-group row">
                  <label  for="cat" class="col-md-4" >Category:</label>

                  <select id="cat" name="cat" class="col-md-8 form-control" required = "required">
                    <option selected value=""></option>
                    <?php
                    $cats = count_and_fetch("categories");
                    foreach ($cats as $cat) { ?>
                      <option 
                        value="'<?php echo $cat['catid'] ?>'"
                        <?php if(isset($_GET['catid']) && $_GET['catid'] == $cat['catid'] ) { echo "selected";} ?>>
                        <?php echo $cat['name'] ?>
                      </option>
              <?php  }

                    ?>
                  </select>
                  <p class="col-md-8 ml-auto validate reqselectvalidate">- Please select the category of item</p>
                </div>
              </div>
              <div class="col-md-1"></div>
              <div class="col-md-4">
                <div class="imageAdd" style="position: relative;">
                    <img class="blah blahItem" width="100%" height="100%" src="layout/images/preview.jpg" alt="your Item" >
                    <label for="upload" class="blahbutton" style="cursor: pointer; background-color:#fff; padding:5px">
                      <span class="edit"><i class="fa fa-edit fa-lg"></i></span>
                      <span class="add"><i class="fa fa-plus fa-lg"></i></span>
                      <input type="file" id="upload" class="imgInp" name="image" accept="image/gif, image/jpeg, image/png" hidden required = "required">
                    </label>
                    <p class="validate reqvalidate">- Please Upload item image</p>
                  </div>
              </div>
              

              <div style="margin-left: 10px;" class="col-md-1"></div>
              
              
              <div style="margin:50px auto;" class="form-group">
                <input class="save btn btn-primary"  type="submit"  value="Save">
              </div>
            </form>

          </div>
          <div class="col-md-4">
                <h5 class="text-center">Predict Car Price</h5>
                <p class="text-muted">Let AI predict item price by fill out these information</p>
                <form class="predict">
                  <div class="form-group row">
                    <label  for="year" class="col-md-4" >Year Model:</label>

                    <select id="year" name="year" class="col-md-8 form-control" required="required">
                      <option selected value=""></option>
                      <option value="2021">2021 </option>
                      <option value="2020">2020</option>
                      <option value="2019">2019</option>
                      <option value="2018">2018</option>
                      <option value="2017">2017 </option>
                      <option value="2016">2016 </option>
                      <option value="2015">2015</option>
                      <option value="2014">2014</option>
                      <option value="2013">2013</option>
                      <option value="2012">2012 </option>
                      <option value="2011">2011 </option>
                      <option value="2010">2010</option>
                      <option value="2009">2009</option>
                      <option value="2008">2008</option>
                      <option value="2007">2007 </option>
                      <option value="2006">2006 </option>
                      <option value="2005">2005</option>
                    </select>
                    <p class="col-md-8 ml-auto validate reqselectvalidate">- Please select year model of item</p>


                  </div>
                  <div class="form-group row">
                    <label  class="col-md-4" for="Kilometers">Kilometers Driven:</label>
                    <input type="number" class="form-control col-md-8" id="Kilometers" name="Kilometers" placeholder="Type  Kilometers Driven here" required='required']>
                    <p class="col-md-8 ml-auto validate reqvalidate">- Please fill out Kilometers Driven made</p>
                  </div>
                  <div class="form-group row">
                    <label  for="fuel" class="col-md-4" > Fuel Type:</label>

                    <select id="fuel" name="fuel" class="col-md-8 form-control" required="required">
                      <option selected value=""></option>
                      <option value="0">CNG </option>
                      <option value="1">Diesel</option>
                      <option value="2">Electric</option>
                      <option value="3">LPG</option>
                      <option value="4">Petrol</option>

                    </select>
                    <p class="col-md-8 ml-auto validate reqselectvalidate">- Please select Fuel Type of item</p>


                  </div>
                  <div class="form-group row">
                    <label  for="transmission" class="col-md-4" >Transmission Type:</label>

                    <select id="transmission" name="transmission" class="col-md-8 form-control" required="required">
                      <option selected value=""></option>
                      <option value="0">Automatic</option>
                      <option value="1">Manual</option>
                    </select>
                    <p class="col-md-8 ml-auto validate reqselectvalidate">- Please select Transmission Type of item</p>


                  </div>
                  <div class="form-group row">
                    <label  for="owner" class="col-md-4" > Owner Type:</label>

                    <select id="owner" name="owner" class="col-md-8 form-control" required="required">
                      <option selected value=""></option>
                      <option value="0">First </option>
                      <option value="2">Second</option>
                      <option value="3">Third</option>
                      <option value="1">Fourth and above</option>
                    </select>
                    <p class="col-md-8 ml-auto validate reqselectvalidate">- Please select Owner Type of item</p>


                  </div>
                  <div class="form-group row">
                    <label  class="col-md-4" for="cc">Engine "cc":</label>
                    <input type="number" class="form-control col-md-8" id="cc" name="cc" placeholder="Type Engine 'cc' here" required='required']>
                    <p class="col-md-8 ml-auto validate reqvalidate">- Please fill out Engine "cc"</p>
                  </div>
                  <div class="form-group row">
                    <label  class="col-md-4" for="power">Power "bhp":</label>
                    <input type="number" class="form-control col-md-8" id="power" name="power" placeholder="Type Power 'bhp' here" required='required']>
                    <p class="col-md-8 ml-auto validate reqvalidate">- Please fill out Power "bhp"</p>
                  </div>
                  <div class="form-group row">
                    <label  class="col-md-4" for="seats">Seat Num:</label>
                    <input type="number" class="form-control col-md-8" id="seats" name="seats" placeholder="Type seats number here" required='required']>
                    <p class="col-md-8 ml-auto validate reqvalidate">- Please fill out seats number</p>
                  </div>
                  <div style="margin:50px auto; display:flex" class="form-group">
                    <input id="predict" class="save btn btn-secondary"  type="submit"  value="Predict">
                    <div class="animate_loading2">
                      <span></span>
                      <span></span>
                      <span></span>
                      <span></span>
                      <span></span>
                    </div>
                  </div>                
                </form>

          </div>
        </div>



      </div>


    <?php
    } elseif ($do === "insert") {
      // Insert page code

      echo "<h2 class='myblue text-center my-5'>Insert Item</h2>";

  		if ($_SERVER['REQUEST_METHOD'] === "POST") {

  			// we come from request method to insert page

  			// fetch data from form by post request

  			$name = $_POST['name'];
  			$desc = addslashes($_POST['description']);
  			$price = ($_POST['price']);
  			$country = $_POST['country'];
  			$quality = $_POST['quality'];
        $status = $_POST['status'];
        $rating = $_POST['rating'];
        $member = $_POST['member'];
        $cat = $_POST['cat'];

        if ($rating == "") {
          $rating = 'NULL';
        }

  			// Validate in server side
        $errorarray = array();

        if (empty($name)) {
          array_push($errorarray, "You can't leave name empty, Please fill it");
        }

        if (strlen($name) < 3) {
          array_push($errorarray, "Name must be more than 3 letters");
        }
        if (empty($desc)) {
          array_push($errorarray, "You can't leave description empty, Please fill it");
        }
        if (strlen($desc) < 20) {
          array_push($errorarray, "Description must be more than 20 letters");
        }
        if (empty($price)) {
          array_push($errorarray, "You can't leave price empty, Please fill it");
        }

        if (empty($country)) {
          array_push($errorarray, "You can't leave country empty, Please fill it");
        }
        if ($quality == "") {
          array_push($errorarray, "You can't leave quality empty, Please fill it");
        }
        if ($status == "") {
          array_push($errorarray, "You can't leave status empty, Please fill it");
        }
        if ($member == "") {
          array_push($errorarray, "You can't leave owner of item empty, Please fill it");
        }
        if ($cat == "") {
          array_push($errorarray, "You can't leave category of item empty, Please fill it");
        }
        // Upload image
        if(!empty($_FILES["image"]["name"])) { 
            // Get file info 
            $fileName = $_FILES['image']['name'];
            $fileBaseName = basename($_FILES["image"]["name"]); 
            $target_dir = "../dataset/uploaded/uploaded_items/";
            $target_file = $target_dir . $fileBaseName;
            $fileType = pathinfo($fileBaseName, PATHINFO_EXTENSION); 
            
            // Allow certain file formats 
            $allowTypes = array('jpg','png','jpeg','gif'); 
            if(in_array($fileType, $allowTypes)){ 
              move_uploaded_file($_FILES['image']['tmp_name'],$target_dir.$fileName);
            } else{ 
              array_push($errorarray, "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.");
            } 
        } else{ 
          array_push($errorarray, "Please select an image file to upload.");
        } 
        if (empty($errorarray)) {


          // insert to DB depent of these data

          $check = insert_user_data("items", "name", "'$name'", "description", "'$desc'", "price", "'$price'", "country", "'$country'","image","'$fileName'", "quality", "'$quality'", "status", "'$status'", "rating", "$rating", "userid_bind", "$member", "catid_bind", "$cat", "datetime", "now()");


          // check if insert success

          if ($check > 0) {


              $msg ="<div class='alert alert-success text-center'>Insert Succeded,  $check row inserted</div>";
              redirect($msg, 'items.php', 'Items Page');?>
              <a href="items.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Items Page Now</a>

    <?php  } else {

             $msg ="<div class='alert alert-danger text-center'>Insert Faild,  $check row inserted</div>";
             redirect($msg, 'items.php', 'Items Page');?>
             <a href="items.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Items Page Now</a>
    <?php
           }
         } else {

            // Validation Error

            foreach ($errorarray as $error) { ?>

              <div class="mycontainer">
                <div class="alert alert-danger text-center"><?php echo $error; ?></div>
              </div>

            <?php }
             redirect("", 'dashbord.php', 'Dashboard Page', 30);?>
            <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

  <?php  }
        // add button ?>
            <a href="?do=add" class="savemember btn myblueback text-white"><i class="fa fa-plus"></i>  New Member</a>
      <?php } else {

        $msg ="<div class='alert alert-danger text-center'>Sorry you can't open this page direct, Try again</div>";
        redirect($msg, 'dashbord.php', 'Dashboard Page');?>
        <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>


<?php }



    } elseif ($do === "edit") {
      // Edit page code

      // check if userid in get request and numeric

      $itemid = (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ?  $_GET['itemid'] : 0;
      // build a query to fetch all data depend with that query

      $row = select_user_data("items", "itemid", $itemid);


        // check if userid in DB

        if (!empty($row)) {

          // We found this id in DB

          // Show Edit form ?>

          <div class="mybigcontainer">

            <h2 class="myblue text-center my-5">Edit Items</h2>
            <form class="items row" novalidate action="?do=update" enctype="multipart/form-data" method="post" id="edit">
              <div class="col-md-3">
                  <input type="hidden" name="itemid" value="<?php echo $row['itemid']; ?>">
                  <div class="form-group row">
                    <label class="col-md-4" for="name">Name:</label>
                    <input type="text" class="form-control col-md-8" id="name" name="name" required="required" value="<?php echo $row['name'];?>">
                    <p class="col-md-8 ml-auto validate reqvalidate">- Please fill out item name</p>
                    <p class="col-md-8 ml-auto validate namevalidate">- Please type at least 3 letters in item name</p>
                  </div>
                  <div class="form-group row">
                    <label  class="col-md-4" for="description">Description:</label>
                    <input type="text" class="form-control col-md-8" id="description" name="description" value="<?php echo $row['description'];?>" required="required">
                    <p class="col-md-8 ml-auto validate reqvalidate">- Please fill out description</p>
                    <p class="col-md-8 ml-auto validate descvalidate">- Please type at least 20 letters in item name</p>
                  </div>
                  <div class="form-group row">
                    <label  class="col-md-4" for="price">Price:</label>
                    <input type="text" class="form-control col-md-8" id="price" name="price" value="<?php echo $row['price'];?>" required="required">
                    <p class="col-md-8 ml-auto validate reqvalidate">- Please fill out the price</p>

                  </div>
              
                  

                  <div class="form-group row">
                    <label  class="col-md-4" for="country">Country:</label>
                    <input type="text" class="form-control col-md-8" id="country" name="country" value="<?php echo $row['country'];?>" required="required">
                    <p class="col-md-8 ml-auto validate reqvalidate">- Please fill out country made</p>
                  </div>
              </div>
              <div class="col-md-1"></div>
              <div class="col-md-3">
                  <div class="form-group row">
                    <label  for="quality" class="col-md-4" >Quality:</label>

                    <select id="quality" name="quality" class="col-md-8 form-control" required = "required">
                      <option value="high" <?php if ($row['quality'] == "high") {echo "selected";}?> >High</option>
                      <option value="medium" <?php if ($row['quality'] == "medium") {echo "selected";}?> >Medium</option>
                      <option value="low" <?php if ($row['quality'] == "low") {echo "selected";}?> >Low</option>
                    </select>
                    <p class="col-md-8 ml-auto validate reqselectvalidate">- Please select the quality of item</p>
                  </div>
                  <div class="form-group row">
                    <label  for="status" class="col-md-4" >Status:</label>

                    <select id="status" name="status" class="col-md-8 form-control" required = "required">
                      <option value="new" <?php if ($row['status'] == "new") { echo "selected";}?> >New</option>
                      <option value="like_new" <?php if ($row['status'] == "like new") { echo "selected";}?> >Like new</option>
                      <option value="old" <?php if ($row['status'] == "old") { echo "selected";}?> >Old</option>
                    </select>
                    <p class="col-md-8 ml-auto validate reqselectvalidate">- Please select the status of item</p>
                  </div>
                  <div class="form-group row">
                    <label  for="rating" class="col-md-4" >Rating:</label>

                    <select id="rating" name="rating" class="col-md-8 form-control">
                      <option value="" <?php if ($row['rating'] == "") {echo "selected";}?> ></option>
                      <option value="1" <?php if ($row['rating'] == "1") {echo "selected";}?> >*</option>
                      <option value="2" <?php if ($row['rating'] == "2") {echo "selected";}?> >* * </option>
                      <option value="3" <?php if ($row['rating'] == "3") {echo "selected";}?> >* * * </option>
                      <option value="4" <?php if ($row['rating'] == "4") {echo "selected";}?> >* * * * </option>
                      <option value="5" <?php if ($row['rating'] == "5") {echo "selected";}?> >* * * * *</option>
                    </select>

                  </div>

                  <div class="form-group row">
                    <label  for="member" class="col-md-4" >Member:</label>

                    <select id="member" name="member" class="col-md-8 form-control">
                      <option selected value=''></option>
                      <?php

                      $members = count_and_fetch("users");
                      foreach ($members as $member) {
                        echo "<option value='" . $member['userid'] . "'";
                        if ($row['userid_bind'] == $member['userid']) {
                          echo "selected";
                        }
                        echo ">" . $member['username'] . "</option>";
                      }

                      ?>
                    </select>

                  </div>
                  <div class="form-group row">
                    <label  for="cat" class="col-md-4" >Category:</label>

                    <select id="cat" name="cat" class="col-md-8 form-control">
                      <option selected value=""></option>
                      <?php
                      $cats = count_and_fetch("categories");
                      foreach ($cats as $cat) {
                        echo "<option value='" . $cat['catid'] . "'";
                        if ($row['catid_bind'] == $cat['catid']) {
                          echo "selected";
                        }
                          echo ">" . $cat['name'] . "</option>";
                      }

                      ?>
                    </select>

                  </div>
              </div>
              <div class="col-md-1"></div>
              <div class="col-md-3">
                <div class="imageEdit" style="position: relative;">
                  <img class="blah blahItem" width="100%" height="100%" src="../dataset/uploaded/uploaded_items/<?php echo $row['image']; ?>" onerror="this.src = 'layout/images/preview.jpg'; document.getElementById('deleteLabel').style.display = 'none'" >
                  <label for="upload" class="blahbutton" style="cursor: pointer; background-color:#fff; padding:5px">
                    <span class="edit"><i class="fa fa-edit fa-lg"></i></span>
                    <input type="file" id="upload" class="imgInp" name="image" accept="image/gif, image/jpeg, image/png" hidden required = "required">
                  </label>
                  <p class="validate reqvalidate">- Please Upload item image</p>
                </div>
              </div>
              <div style="margin-left: 10px;" class="col-md-1"></div>
              <div style="margin:50px auto;" class="form-group">
                <input class="save btn btn-primary"  type="submit"  value="Save">
              </div>
            </form>
          </div>

        <?php } else {

          // show Error alert [Error to find id]


            $msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
            redirect($msg, 'dashbord.php', 'Dashboard Page');?>
            <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
    <?php  }
    } elseif ($do === "update") {
      // Update page code
      echo "<h2 class='myblue text-center my-5'>Update Items</h2>";

      if ($_SERVER['REQUEST_METHOD'] === "POST") {

        // we come from request method to update page

        // fetch data from form by post request

        $id = $_POST["itemid"];
        $name = $_POST['name'];
  			$desc = $_POST['description'];
  			$price = ($_POST['price']);
  			$country = $_POST['country'];
  			$quality = $_POST['quality'];
        $status = $_POST['status'];
        $rating = $_POST['rating'];
        $member = $_POST['member'];
        $cat = $_POST['cat'];

        // echo $imgContent;
        /*echo $rating . "<br>";
        echo $member . "<br>";
        echo $cat . "<br>";*/
        if ($rating == "") {
          $rating = 'NULL';
        }
        if ($member == "") {
          $member = 'NULL';
        }
        if ($cat == "") {
          $cat = 'NULL';
        }
  			// Validate in server side
        $errorarray = array();

        if (empty($name)) {
          array_push($errorarray, "You can't leave name empty, Please fill it");
        }

        if (strlen($name) < 3) {
          array_push($errorarray, "Name must be more than 3 letters");
        }
        if (empty($desc)) {
          array_push($errorarray, "You can't leave description empty, Please fill it");
        }
        if (strlen($desc) < 20) {
          array_push($errorarray, "Description must be more than 20 letters");
        }
        if (empty($price)) {
          array_push($errorarray, "You can't leave price empty, Please fill it");
        }

        if (empty($country)) {
          array_push($errorarray, "You can't leave country empty, Please fill it");
        }
        // Upload image
        if(!empty($_FILES["image"]["name"])) { 
          // Get file info 
					$fileName = $_FILES['image']['name'];
					$fileBaseName = basename($_FILES["image"]["name"]); 
					$target_dir = "../dataset/uploaded/uploaded_items/";
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
        array_push($errorarray, "Please select an image file to upload.");
      }
        if (empty($errorarray)) {

          // update DB depent of these data
            $check = update_user_data("items",
            "itemid = $id",
            "name = '$name'",
            "description = '$desc'",
            "price = '$price'",
            "country = '$country'",
            "status = '$status'",
            "rating = $rating",
            "quality = '$quality'",
            "userid_bind = $member",
            "image = '$fileName'",
            "catid_bind = $cat");

          // check if insert success

          if ($check > 0) {


              $msg ="<div class='alert alert-success text-center'>Update Succeded,  $check row updated</div>";
              redirect($msg, 'items.php', 'Items Page');?>
              <a href="items.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Items Page Now</a>

    <?php   } else {

             $msg ="<div class='alert alert-danger text-center'>Update Faild,  $check row updated</div>";
             redirect($msg, 'items.php', 'Items Page');?>
             <a href="items.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Items Page Now</a>

    <?php   }
         } else {

            // Validation Error

            foreach ($errorarray as $error) { ?>

              <div class="mycontainer">
                <div class="alert alert-danger text-center"><?php echo $error; ?></div>
              </div>

            <?php }
        redirect($msg, 'dashbord.php', 'Dashboard Page');?>
        <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
  <?php  }
     } else {
        $msg ="<div class='alert alert-danger text-center'>Sorry you can't open this page direct, Try again</div>";
        redirect($msg, 'dashbord.php', 'Dashboard Page');?>
        <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>


<?php }


    } elseif ($do === "delete") {

      // Delete page code

      // check if itemid in get request and numeric

      $itemid = (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ?  $_GET['itemid'] : 0;
      // build a query to fetch all data depend with that query

      $row = select_user_data("items", "itemid", $itemid);

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
                  <a class="close" href="items.php" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                  </a>
              </div>
              <div class="modal-body">
                 Are you really sure want to delete <?php  echo $row['name']; ?> item ?
             </div>
            <div class="modal-footer">
                <a  class="btn btn-secondary" href="items.php">Cancel</a>
                <a  class="btn btn-danger" href="items.php?do=deleteaccess&itemid=<?php echo $row['itemid']; ?>&name=<?php echo $row['name']; ?>">Delete</a>
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
      $id = $_GET['itemid'];
      $name = $_GET['name'];
      $check = delete_row("items", "itemid", $id, "AND name = '$name'");

      if ($check > 0) {

        $msg = "<div class='alert alert-success text-center'>$name item has been deleted</div>";
        redirect($msg, 'items.php', 'Items Page');?>
        <a href="items.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Items Page Now</a>

<?php    }
     else {

        $msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
        redirect($msg, 'items.php', 'Items Page');?>
        <a href="items.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Items Page Now</a>

<?php }
   } elseif ($do === "approve") {

      $itemid = (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ?  $_GET['itemid'] : 0;

      // build a query to fetch all data depend with that query

      $row = select_user_data("items", "itemid", $itemid);

      // check if userid in DB

      if (!empty($row)) { ?>
        <!-- Button trigger modal -->
        <input type="hidden" class="triggermodal" data-toggle="modal" data-target="#staticBackdrop">
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Confirm Item</h5>
                  <a class="close" href="items.php" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                  </a>
              </div>
              <div class="modal-body">
                 Are you really sure want to approve <?php echo $row['name']; ?> item ?
             </div>
            <div class="modal-footer">
                <a  class="btn btn-secondary" href="items.php">Cancel</a>
                <a  class="btn btn-info" href="items.php?do=approveaccess&itemid=<?php echo $row['itemid']; ?>&name=<?php echo $row['name']; ?>">Approve</a>
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

  elseif ($do === "approveaccess") {


      $id = $_GET['itemid'];
      $item = $_GET['name'];

      $check = update_user_data("items", "itemid = $id", "approve = 1");
      if ($check > 0) {


          $msg = "<div class='alert alert-success text-center'>$item item has been approved</div>";
          redirect($msg, 'items.php', 'Items Page');?>
          <a href="items.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Items Page Now</a>


<?php  }
     else {

        $msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
        redirect($msg, 'dashbord.php', 'Dashboard Page');?>
        <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

<?php }
   } elseif($do ==  "buy") {
      $userid = $_GET['userid'];
      $itemid = $_GET['itemid'];

      $row = select_user_data("items", "itemid", $itemid);

      // check if userid in DB

      if (!empty($row)) { ?>
        <!-- Button trigger modal -->
        <input type="hidden" class="triggermodal" data-toggle="modal" data-target="#staticBackdrop">
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Confirm Item</h5>
                  <a class="close" href="items.php" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </a>
              </div>
              <div class="modal-body">
                  Are you really sure want to buy <?php echo $row['name']; ?> item ?
              </div>
            <div class="modal-footer">
                <a  class="btn btn-secondary" href="items.php">Cancel</a>
                <a  class="btn btn-info" href="items.php?do=buyaccess&itemid=<?php echo $row['itemid']; ?>&name=<?php echo $row['name']; ?>&userid=<?php echo $userid;?>">Buy</a>
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
<?php  }

   
   } 
   else if ($do === "buyaccess") {
    $itemid = $_GET['itemid'];
    $userid = $_GET['userid'];
    $itemname = $_GET['name'];
    if (isset($itemid)) {
      // Update items Table & Insert Data inside buy Table
      $check1 = update_user_data("items", "itemid = $itemid", "bought = 1");
      $check2 = insert_user_data('sells', 'name', "'$itemname'", "selldatetime", "now()", "itemid_bind", $itemid, "userid_bind", $userid);

      // echo $check1;
      if (($check1 > 0) || ($check2 > 0)) {
          // Buy Ok
          $msg ="<div class='alert alert-success text-center'>Buy Succeded,  $check2 row inserted</div>";
          redirect($msg, 'items.php', 'Items Page');?>
          <a href="items.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Items Page Now</a>
  <?php  } else {
          // Buy failed
          $msg ="<div class='alert alert-danger text-center'>Buy Faild,  $check2 row inserted</div>";
          redirect($msg, 'items.php', 'Items Page');?>
          <a href="items.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Items Page Now</a>
  <?php  }
      } else {
          // There is no such id
          $msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
          redirect($msg, 'dashbord.php', 'Dashboard Page');?>
          <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
<?php  }
    } else if ($do === "details") {
      $itemid = $_GET['itemid'];
      $row = get_item_details($itemid);
      $comments = getCommentsItem($itemid);
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
?>
    <div class="mybigcontainer">
      <div class="row itemDetails" style="justify-content:space-around;">
        <div class="col-md-6 details">
          <h2><?php echo $row['name']?></h2>


          <div class="row notices">
          <?php if ($bought) { ?>
            <div class="mysuccessBack not">It is bought</div>
          <?php } else if ($pending)  {?>
          <div class="bg-warning not">It is pending</div>
          <?php } else  {?>
            <div class="bg-primary not">It is still offered</div>
          <?php } ?>

          <?php if ($row['approve'] == 0) {?>
            <div class="mydangerBack not">Not approved</div>
          <?php } else  {?>
            <div class="mysuccessBack not ">Approved</div>
          <?php } ?>
            <div style="margin-left: auto;">
              <div class="itemActions">
                  <a href="items.php?do=edit&itemid=<?php echo $row['itemid']; ?>" class='card-action btn mysuccess table-control'> <i class='fa fa-edit fa-lg'></i></a>
                  <a href="items.php?do=delete&itemid=<?php echo $row['itemid']; ?>" class='card-action btn mydanger table-control'> <i class='fa fa-trash fa-lg'></i></a>
                  <?php if ($row['approve'] == 0) {?>
                      <a href="items.php?do=approve&itemid=<?php echo $row['itemid']; ?>" class='card-action btn myinfo table-control'>  <i class='fa fa-check fa-lg'></i></a>
                  <?php  }?>
              </div>  
            </div>

          </div>
          <div class="rating" data-rate-value=<?php echo $row['rating']; ?>> </div>
          <hr class="myhr">
          <div style="color:orange; font-weight:bold">$ <?php echo $row['price']?></div>
          <hr class="myhr">
          <div><span>Category : </span><a class="mya" href='categories.php?do=show&catid=<?php echo $row['catid_bind']; ?>&catname=<?php echo $row['catname'] ?>'> <?php echo $row['catname'] ?></a></div>
          <hr class="myhr">
          <div class="userCatActions">
            <div>Description : </div>
            <div class="text-muted"><?php echo $row['description'] ?></div>
          </div>
          <hr class="myhr">
          <div class="userCatActions">
            <div><span>Declared By : </span><a class="mya" href='members.php?do=profile&userid=<?php echo $row['userid_bind']; ?>'> <?php echo $row['username'] ?></a></div>
            <div class="text-muted"><?php echo $row['datetime'] ?></div>

          </div>
          <hr class="myhr">
          <?php if ($bought || $pending) { ?>
          <div class="userCatActions">
            <div><span><?php echo ($bought) ? "Bought" : "Waited " ?> By : </span><a class="mya" href='members.php?do=profile&userid=<?php echo $buyDetails['userid_bind']; ?>'> <?php echo $buyDetails['username'] ?></a></div>
            <div class="text-muted"><?php echo $buyDetails['selldatetime'] ?></div>
          </div>
          <hr class="myhr">           
          <?php } ?>
          <div class="userCatActions">
            <div>Status : </div>
            <div class="text-muted"><?php echo $row['status'] ?></div>

          </div>
          <hr class="myhr">
          <div class="userCatActions">
            <div>Country Made : </div>
            <div class="text-muted"><?php echo $row['country'] ?></div>

          </div>
          <hr class="myhr">
          <div class="userCatActions">
            <div>Quality : </div>
            <div class="text-muted"><?php echo $row['quality'] ?></div>

          </div>
          <hr class="myhr">



        </div>
        <div class="col-md-6" style="margin-top: auto;">
          <div class="image">
            <img width="100%" height="100%"  src="../dataset/uploaded/uploaded_items/<?php echo $row['image']; ?>" onerror="this.src = 'layout/images/preview.jpg'">
          </div>
        </div>
      </div>
      <div style="margin-top: 20px;">
          <h2>Comments: </h2>
            <?php
            if (!empty($comments)) {
                foreach ($comments as $value) { ?>
                  <div class="border p-3 media mediacom  bg-light">
                    <a href="members.php?do=profile&userid=<?php echo $value['userid']?>" class='btn  table-control' style="padding:5px;margin-right:5px; width: 100px; height:100px; border-radius: 50%; border: 1px solid #333"  > 
                      <img style="border-radius: 50%" width="100%" height="100%" src="../dataset/uploaded/uploaded_avatar/<?php echo $value['avatar']; ?>" onerror="this.src = 'layout/images/avatar.jpg'" />
                    </a>
                    <div class="media-body">
                      <h5 class="mt-0"><a class="" href="members.php?do=profile&userid=<?php echo $value['userid']?>"><?php echo $value['username']?></a></h5>
                      <p class="text-muted"><?php echo $value['comment'];?></p>
                    </div>
                    <div class="options">
                      <a href="comments.php?do=delete&comid=<?php echo $value['comid']; ?>" class='btn mydanger '> <i class='fa fa-lg fa-trash'></i></a>
                      <?php if (ispending("comid", "comments", $value['comid'] , "status") > 0) { ?>
                      <a href="comments.php?do=activate&comid=<?php echo $value['comid']; ?>" class='btn myinfo '> <i class='fa fa-lg fa-check'></i></a>
                    <?php } ?>
                    </div>
                  </div>
              <?php } } else { ?>
                <p class="text-muted"> There is no any comment yet ...</p>
          <?php  }
            ?>
        </div>
    </div>

<?php  }
   else {

    		// show Error alert [Error 404]

  			$msg = "<div class='alert alert-danger text-center'>Sorry, We couldn't find this page Error 404, Find a solution <a href='https://www.ionos.com/digitalguide/websites/website-creation/what-does-the-404-not-found-error-mean/' target='_blank'>here</a></div>";
        redirect($msg, 'dashbord.php', 'Dashboard Page');?>
        <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

<?php }
    ?>
        </div>
      </div>
    </div>
    <?php
    }
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
