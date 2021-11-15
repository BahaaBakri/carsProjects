<?php
ob_start();
	session_start();
  if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];
    $userStatment = "AND items.userid_bind != $uid";
  } else {
    $uid = "";
    $userStatment = "";
  }
  $catid = $_GET['catid'];
  $catname = $_GET['catname'];
	$pagetitle = $catname;
	include "ini.php";
	// show Items
      $search = "all";
      $pricestatus = "all";
      $rating = "all";
      $status = "all";

    if (isset($_GET['action'])) {
      $search = $_GET['search'];
      $pricestatus = $_GET['price'];
      $rating = $_GET['rating'];
      $status = $_GET['status'];


      $ratingStatment = ($rating == "all") ? "" : "AND rating = $rating";
      $statusStatment = ($status == "all") ? "": "AND status = '$status'";
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
      $searchStatment = "";
      $priceStatment = "";
    } 
    
      // Mange page code
      // GET items depond on filters and search
      $statment = $con->prepare("SELECT items.*, users.*, categories.name as catname FROM users RIGHT OUTER JOIN items ON users.userid = items.userid_bind LEFT OUTER JOIN categories ON categories.catid = items.catid_bind WHERE bought = 0 AND items.catid_bind = $catid $userStatment $ratingStatment $searchStatment  $statusStatment $priceStatment  ORDER BY itemid DESC");
      $statment->execute();
      $rows = $statment->fetchAll();
      ?>

			<!-- Show mange table -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light navChild">
      <a class="navbar-brand" href="#">Filter Items</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <form id="itemFilter" class="form-inline my-2 my-lg-0" method="GET" action="categories.php">
            <input type="hidden" name="action" value="filter">
            <input type="hidden" name="catid" value="<?php echo $catid?>">
            <input type="hidden" name="catname" value="<?php echo $catname?>">



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
              <a href="categories.php?catid=<?php echo $catid ?>&catname=<?php echo $catname ?>&action=filter&show=all&status=all&price=all&rating=all&search=<?php echo $search?>" class="clearFilter btn btn-outline-primary my-2 my-sm-0" >Clear Filter</a>
          </ul>


          <div class="form-inline my-2 my-lg-0">
            <input type="hidden" name="search" >
            <input class="inputSearch searchItem  form-control mr-sm-2" type="search" placeholder="Search Item" value="<?php echo ($search == "all") ? "" : $search; ?>">
            <button type="submit" class="btn btn-outline-primary mr-2 my-2 my-sm-0" >Search</button>
          </div>
          </form>
        </div>
      </nav>
      <div class="mybigcontainer table-responsive" style="margin-top: 70px;">

        <?php if (!empty($rows)) { ?>
        <h2 class="text-center my-5"><?php echo $catname;?> Items</h2>
    <?php  if (isset($_GET['search']) && $_GET['search'] !== "all") { ?>
					<p  style="font-size: 32px; font-weight:bold">Search result about '<?php echo $search;?>' : </p>
				<?php } ?>
        <div  class="row">
        <?php
        foreach ($rows as $row) { 
          // get item comments

          $comments = getCommentsItem($row['itemid']);

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
              <div><span>Category : </span><a class="mya" href='categories.php?catid=<?php echo $row['catid_bind']; ?>&catname=<?php echo $row['catname'] ?>'> <?php echo $row['catname'] ?></a></div>
            </div>

            <div class="rating" data-rate-value=<?php echo $row['rating']; ?>> </div>

            <div class="userCatActions">
              <div><span>Declared By : </span><a class="mya" href='members.php?catid=<?php echo $row['userid']?>'> <?php echo $row['username'] ?></a></div>
              <div class="text-muted"><?php echo $row['datetime'] ?></div>
            
            </div>
            <?php if ($bought || $pending) { ?>
            <div class="userCatActions">
              <div><span><?php echo ($bought) ? "Bought" : "Waited " ?> By : </span><a class="mya" href='profile.php?userid=<?php echo $buyDetails['userid']?>'> <?php echo $buyDetails['username'] ?></a></div>
              <div class="text-muted"><?php echo $buyDetails['selldatetime'] ?></div>
            </div>            
          <?php } ?>
            <br>
            <div class="itemActions">
		<?php	if (!$bought) { ?>
			<a href="items.php?do=buy&itemid=<?php echo $row['itemid']; ?>" class='btn btn-success'> Buy</a>
		<?php } ?>

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
                        <a href="profile.php?userid=<?php echo $comment['userid']?>" class='btn  table-control' style="padding:5px; margin-right:5px; width: 100px; height:100px; border-radius: 50%; border: 1px solid #333"  > 
                          <img style="border-radius: 50%" width="100%" height="100%"src="../dataset/uploaded/uploaded_avatar/<?php echo $comment['avatar']; ?>" onerror="this.src = 'layout/images/avatar.jpg'" />
                        </a>
                        <div class="media-body">
                          <div style="display: flex; justify-content:space-between;">
                            <h5 class="mt-0"><a  href="profile.php?userid=<?php echo $comment['userid']?>"><?php echo $comment['username']?></a></h5>
                            <div class="text-muted"><?php echo $comment['datetime']; ?></div>
                          </div>
                          <div style="display: flex; justify-content:space-between;">
                            <p class="text-muted"><?php echo $comment['comment'];?></p>
                        
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
      				if ((isset($_GET['search'])) && ($_GET['search'] === "all")) {
                  $msg = "<div class='alert alert-warning text-center'>There is no any items in this filter </div>";
                  redirect($msg, "categories.php?catid=$catid&catname=$catname", 'Clear filter');?>
                  <a href="categories.php?catid=<?php echo $catid ?>&catname=<?php echo $catname ?>" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Clear Filter Now</a>

      <?php    } else if ((isset($_GET['search'])) && ($_GET['search'] !== "all")) {
                  $msg = "<div class='alert alert-warning text-center'>There is no any result about item '$search'</div>";
                  redirect($msg, "categories.php?catid=$catid&catname=$catname", "$catname Page");?>
                  <a href="categories.php?catid=<?php echo $catid ?>&catname=<?php echo $catname ?>" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go To <?php echo $catname?> Page Now</a>

      <?php    } else if (!isset($_GET['search'])) {
                  $msg = "<div class='alert alert-warning text-center'>There is no any items in $catname category</div>";
                  redirect($msg, 'index.php', 'Home Page');?>
                  <a href="index.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Home Page Now</a>
      <?php  }

      }
      ?>
      <a href="?do=add" class="save btn btn-primary"><i class="fa fa-plus"></i> New Item</a>
    </div>
  	<?php

	include $temp . "footer.php";
	ob_end_flush();

?>
