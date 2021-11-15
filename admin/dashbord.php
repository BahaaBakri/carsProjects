<?php

// page when login admin succeded

	session_start();

	if (isset($_SESSION['username'])) {

		// when come from index.php and have registerd session
		include "ini.php";
		$pagetitle = "Control Panel";

		$rowsusers = get_latest("users");

		$rowsitemsnew = get_latest("allItems","'new'");
		$rowsitemslikenew = get_latest("allItems","'like_new'");
		$rowsitemsold = get_latest("allItems", "'old'");

		$rowscomments = getAllComments("LIMIT 5");


	} else {
		// when open the script direct
		header('location: index.php');
		exit;
	} ?>
		

			<div>
				<div style="width: 18%; height:100%; position:fixed; z-index:1000">
					<?php include "includes/temp/sidebar.php"?>
				</div>
				<div style="display: flex;">
					<div style="flex-basis: 18%;"></div>
					<div style="flex-basis: 82%; width:82%">
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
						<div class="mybigcontainer">
						<h2 class="text-center my-5">Dashboard</h2>
						<div class="statistics chartParent">
							<div id="slide1" class="slide">
								<div class="">
									<h5>Total Admins</h5>
									<p><i class="fa fa-user-secret"></i> <?php echo count_and_fetch("users", "admins", "count", "groupid"); ?></p>
									<a href="members.php?show=admins" class="stretched-link"></a>
								</div>

								<span></span>
							</div>
							<div id="slide2" class="slide">
								<div class="">
									<h5>Total Members</h5>
									<p><i class="fa fa-users"></i> <?php echo count_and_fetch("users", "users", "count", "groupid"); ?></p>
									<a href="members.php" class="stretched-link"></a>
								</div>

								<span></span>
							</div>
							<div id="slide3"class="slide">
								<div class="">
									<h5>Pending Members</h5>
									<p><i class="fa fa-clock"></i> <?php echo count_and_fetch("users", "pending", "count", "groupid", "regstatus"); ?></p>
									<a href="members.php?show=pending" class="stretched-link"></a>
								</div>

								<span></span>
							</div>
							<div id="slide4" class="slide">
								<div class="">
									<h5>Total Items</h5>
									<p><i class="fa fa-shopping-cart"></i> <?php echo count_and_fetch("items", "all", "count"); ?></p>
									<a href="items.php" class="stretched-link"></a>
								</div>

								<span></span>
							</div>
							<div id="slide5" class="slide">
								<div class="">
									<h5>Total Comments</h5>
									<p><i class="fa fa-comment"></i> <?php echo count_and_fetch("comments", "all", "count"); ?></p>
									<a href="comments.php" class="stretched-link"></a>
								</div>

								<span></span>
							</div>

						</div>
						<div class="row justify-content-between " style="padding:10px; height:200px">

							<div class="chartParent  col-md-12" style="border-right:3px solid #f0f0f0">
								<p style="font-weight: bold;">All Items:</p>
								<div class="AllPriceParent">
									<div class="AllPrice"  data-toggle="tooltip" data-placement="right"
									title="<p>New: $<?php echo sum_price("all", "'new'"); ?></p> <p>Like New: $<?php echo sum_price("all", "'like_new'"); ?></p> <p>Old: $<?php echo sum_price("all", "'old'"); ?></p>">
										 $<?php echo sum_price("all"); ?> 
									</div>
								</div>
							</div>
							<div class="chartParent  col-md-4" style="border:3px solid #f0f0f0" >
								<p style="font-weight: bold;">All Offered Items:</p>
								<div class="AllPriceParent">
									<div class="AllItemsPrice" data-toggle="tooltip" data-placement="bottom" 
										title="<p>New: $<?php echo sum_price("itemsoffered", "'new'"); ?></p> <p>Like New: $<?php echo sum_price("itemsoffered", "'like_new'"); ?></p> <p>Old: $<?php echo sum_price("itemsoffered", "'old'"); ?></p>">
										 $<?php echo sum_price("itemsoffered"); ?>
									</div>
								</div>
							</div>
							<div class="chartParent  col-md-4" style="border:3px solid #f0f0f0" >
								<p style="font-weight: bold;">All Pending Items:</p>
								<div class="AllPriceParent">
									<div class="AllPendingPrice" data-toggle="tooltip" data-placement="bottom" 
										title="<p>New: $<?php echo sum_price("pending", "'new'"); ?></p> <p>Like New: $<?php echo sum_price("pending", "'like_new'"); ?></p> <p>Old: $<?php echo sum_price("pending", "'old'"); ?></p>">
										 $<?php echo sum_price("pending"); ?>
									</div>
								</div>
							</div>
							<div class="chartParent  col-md-4" style="border:3px solid #f0f0f0" >
								<p style="font-weight: bold;">All Sold Items:</p>
								<div class="AllPriceParent">
									<div class="AllSellsPrice" data-toggle="tooltip" data-placement="right"
									title="<p>New: $<?php echo sum_price("sells", "'new'"); ?></p> <p>Like New: $<?php echo sum_price("sells", "'like_new'"); ?></p> <p>Old: $<?php echo sum_price("sells", "'old'"); ?></p>">
										$<?php echo sum_price("sells"); ?>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row justify-content-between chartParent">
							
							<div class="rateItemsLineChart">
								<p style="font-weight: bold;">The rate of Offered Items over time</p>
								<canvas id="rateItemsLineChart" style="width:600px; height:400px"></canvas>
							</div>
							
							<div class="rateSellsLineChart">
								<p style="font-weight: bold;">The rate of sold Items over time</p>
								<canvas id="rateSellsLineChart" style="width: 600px; height:400px"></canvas>
							</div>								
						</div>

						<div class="row justify-content-between chartParent">

							<input id ="newItemsCount" type="hidden" value=' <?php echo count_and_fetch_items("offered", "count", "'new'"); ?>' />
							<input id ="likeNewItemsCount" type="hidden" value=' <?php echo count_and_fetch_items("offered", "count", "'like_new'"); ?>' />
							<input id ="oldItemsCount" type="hidden" value=' <?php echo count_and_fetch_items("offered", "count", "'old'"); ?>' />
							<div class="statusItemsPieChart">
								<p style="font-weight: bold;">Divisions of the offered items</p>
								<canvas id="statusItemsPieChart" style="width: 600px; height:400px"></canvas>
							</div>

							<input id ="newSellsCount" type="hidden" value=' <?php echo count_and_fetch_items("sells", "count", "'new'"); ?>' />
							<input id ="likeNewSellsCount" type="hidden" value=' <?php echo count_and_fetch_items("sells", "count", "'like_new'"); ?>' />
							<input id ="oldSellsCount" type="hidden" value=' <?php echo count_and_fetch_items("sells", "count", "'old'"); ?>' />
							<div class="statusSellsPieChart">
								<p style="font-weight: bold;">Divisions of the bought items</p>
								<canvas id="statusSellsPieChart" style="width: 600px; height:400px"></canvas>
							</div>
				
						</div>
						<div class="row justify-content-between chartParent">
							<div class="top5UserItemsBarChart">
								<p style="font-weight: bold;">Top 5 users offered items</p>
								<canvas id="top5UserItemsBarChart" style="width: 600px; height:400px"></canvas>
							</div>		
							<div class="top5UserSellsBarChart">
								<p style="font-weight: bold;">Top 5 users bought items</p>
								<canvas id="top5UserSellsBarChart" style="width: 600px; height:400px"></canvas>
							</div>				
						</div>
						<div class="row justify-content-between chartParent">
							<div class="top5CatItemsBarChart">
								<p style="font-weight: bold;">Top 5 categories offered items</p>
								<canvas id="top5CatItemsBarChart" style="width: 600px; height:400px"></canvas>
							</div>		
							<div class="top5CatSellsBarChart">
								<p style="font-weight: bold;">Top 5 categories bought items</p>
								<canvas id="top5CatSellsBarChart" style="width: 600px; height:400px"></canvas>
							</div>				
						</div>

						<div class="row">
							<div class="col-md-6 latest chartParent">
								<div class="row justify-content-between m-3">
									<p style="font-weight: bold;">Latest 5 registerd users</p>
									<button class="slidebutton" data-class="show"><i class="fa fa-minus fa-lg " ></i></button>
									<button class="slidebutton hidden" data-class="hide"><i class="fa fa-plus fa-lg " ></i></button>
								</div>
								<div class="mylist">
									<?php
									if (!empty($rowsusers)) {
											foreach ($rowsusers as $value) {
												echo "<a href='members.php?do=profile&userid={$value['userid']}' class='elements list-group-item list-group-item-action'>" . $value['username'] . "</a>";

												if (ispending("username", "users", $value['username'] , "regstatus") > 0) {
													echo "<a href='members.php?do=activate&userid={$value['userid']}' class='icons'><i style='color:#17a2b8' class='fa fa-check fa-lg'></i></a>";

											}
												echo "<a href='members.php?do=delete&userid={$value['userid']}' class='icons'><i style='color:red' class='fa fa-trash fa-lg'></i></a>";
										}
									}
								?>
							</div>
							</div>

							<div class="col-md-6 latest chartParent">
								<div class="row justify-content-between m-3">
									<p style="font-weight: bold;">Latest 5 new items added </p>
									<button class="slidebutton" data-class="show"><i class="fa fa-minus fa-lg " ></i></button>
									<button class="slidebutton hidden" data-class="hide"><i class="fa fa-plus fa-lg " ></i></button>
								</div>
								<div class="mylist">
									<?php
									if (!empty($rowsitemsnew)) {
											foreach ($rowsitemsnew as $value) { ?>
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
							<div class="col-md-6 latest chartParent">
								<div class="row justify-content-between m-3">
									<p style="font-weight: bold;">Latest 5 like new items added </p>
									<button class="slidebutton" data-class="show"><i class="fa fa-minus fa-lg " ></i></button>
									<button class="slidebutton hidden" data-class="hide"><i class="fa fa-plus fa-lg " ></i></button>
								</div>
								<div class="mylist">
									<?php
									if (!empty($rowsitemslikenew)) {
											foreach ($rowsitemslikenew as $value) { ?>
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
							<div class="col-md-6 latest chartParent">
								<div class="row justify-content-between m-3">
									<p style="font-weight: bold;">Latest 5 old items added </p>
									<button class="slidebutton" data-class="show"><i class="fa fa-minus fa-lg " ></i></button>
									<button class="slidebutton hidden" data-class="hide"><i class="fa fa-plus fa-lg " ></i></button>
								</div>
								<div class="mylist">
									<?php
									if (!empty($rowsitemsold)) {
											foreach ($rowsitemsold as $value) { ?>
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
									<p style="font-weight: bold;">Latest 5 comments</p>
									<button class="slidebutton" data-class="show"><i class="fa fa-minus fa-lg " ></i></button>
									<button class="slidebutton hidden" data-class="hide"><i class="fa fa-plus fa-lg " ></i></button>
								</div>
								<div class="mylist">
									<?php
									if (!empty($rowscomments)) {
											foreach ($rowscomments as $value) { ?>
												<div class="border p-3 media mediacom  bg-light">
													<a href="members.php?do=profile&userid=<?php echo $value['userid']?>" class='btn  table-control' style="padding:5px;margin-right:5px; width: 100px; height:100px; border-radius: 50%; border: 1px solid #333"  > 
														<img style="border-radius: 50%" width="100%" height="100%" src="../dataset/uploaded/uploaded_avatar/<?php echo $value['avatar']?>" onerror="this.src = 'layout/images/avatar.jpg'" />
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
						</div>
					</div>
				<?php include $temp . "footer.php"; ?>
			</div>
		</div>
	</div>
