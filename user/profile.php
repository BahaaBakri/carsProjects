<?php
  ob_start();
	session_start();


		// when come from index.php 
    //print_r($_SESSION['userid']);
    $pagetitle = "Profile";
		include "ini.php";
    $uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : "";
		$do = "";
    if (isset($_GET["do"])) {
			$do = $_GET['do'];
		} else {
			$do = "";
		}
  $userid = $_GET['userid'];

  // get user details
  $details = select_user_data('users', 'userid', $userid);
  $username = $details['username'];
  // get user comments
  $commentsUser = getCommentsUser($userid);
  // get latest 5 user comments
  $comments5 = getCommentsUser($userid,"", "LIMIT 5");
  // // get user items offered
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
  
  $your = false;
  $admin = true;

  if ($uid === $userid) {
    // this is your profile
    $your = true;
  }
  

  
  if ($your) { ?>
  <nav class="navbar navbar-expand-lg navbar-dark navChild" style="background-color: rgba(87, 87, 97, .9); padding-left:30px; padding-right:30px">
    <a  class="navbar-brand" href="#"><h4><?php echo $username?></h4></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse row" id="navbarSupportedContent" >
    <div class="row ml-auto" style="justify-content: space-between;"> 
    
      <a  href="members.php?do=edit" class='btn myprimary '> <i class='fa fa-edit'></i> Edit my profile  </a>
      <a  href="members.php?do=delete" class='btn mydanger '> <i class='fa fa-trash'></i> Delete my profile  </a>            
      <a  href='items.php?do=add' class='btn myinfo '> <i class='fa fa-plus'></i> offered new item from me  </a>

    
    </div>
    
    </div>
  </nav>
  <?php } ?>
  <div class="mybigcontainer" style="margin-top: 120px;">
    <div class="profileHeader" >
      <a href="profile.php&userid=<?php echo $userid?>" class='btn  table-control' style="padding:5px; width: 150px; height:150px; border-radius: 50%; border: 1px solid #333"  > 
        <img style="border-radius: 50%" width="100%" height="100%" src="../dataset/uploaded/uploaded_avatar/<?php echo $details['avatar']; ?>" onerror="this.src = 'layout/images/avatar.jpg'" />
      </a>
    </div>
    <div class="profileTitle">
      
        <h3 style="text-align: center;"><?php echo $details['fullname']?></h3>
        <div class="profileTitleInfo">
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
        <?php if ($your) { ?>

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
              <a href="comments.php?do=edit&comid=<?php echo $value['comid']; ?>" class='btn btn-success '>Edit <i class='fa fa-edit'></i></a>
              <a href="comments.php?do=delete&comid=<?php echo $value['comid']; ?>" class='btn btn-danger '>Delete <i class='fa fa-trash'></i></a>
              </div>
            </div>
          <?php } }
          ?>
        </div>
      </div>
    </div>
    <?php } ?>
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
                        There is no any items in this filter
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
		<?php	if (!$bought && !$pending) { ?>
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
                  <a href="comments.php?do=edit&comid=<?php echo $comment['comid']; ?>" class='btn mysuccess table-control'> <i class='fa fa-edit'></i></a>
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
          <?php if ($your) { ?>
          <th scope="col">Control</th>
          <?php } ?>
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
          if ($your) {?>

            <td>
            <a href="comments.php?do=edit&comid=<?php echo $row['comid']; ?>" class='btn btn-success table-control'>Edit <i class='fa fa-edit'></i></a>
            <a href="comments.php?do=delete&comid=<?php echo $row['comid']; ?>" class='btn btn-danger table-control'>Delete <i class='fa fa-trash'></i></a>
            </td>
          <?php } ?>
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
  </div>
<?php	

    include $temp . "footer.php";
    ob_end_flush();

?>
