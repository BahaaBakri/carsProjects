<?php 

// Get Gategories
if (isset($_SESSION['username'])) {
    $user = $_SESSION['username'];
    $userid = $_SESSION['userid'];
    $categories = count_and_fetch("categories", "all", "fetch", "", "", "ORDER BY ordering DESC");
    $row = select_user_data("users", "userid", "$userid", "fetch", "", "", "");

}

if(isset($_GET['search']) ) {
    if (strpos($_SERVER["REQUEST_URI"],'items.php') != false) {
        // echo "items";
        $searchItem = $_GET['search'];
        $searchUser = '';
        $searchComment = '';
    } else if (strpos($_SERVER["REQUEST_URI"],'members.php') != false) {
        // echo "members";
        $searchUser = $_GET['search']; 
        $searchItem = ''; 
        $searchComment = '';      
    } else if (strpos($_SERVER["REQUEST_URI"],'comments.php') != false) {
        $searchComment = $_GET['search']; 
        $searchItem = ''; 
        $searchUser = '';
    }
} else {
    $searchItem = '';
    $searchUser = '';
    $searchComment = ''; 
}
?>
			<!-- Left menu -->
			<div class="left">
                <h4 style="color: #222; padding-top:10px"> <a href="dashbord.php">Control Panel</a></h4>
                <div class="account-info">
                    <a href="#" class='btn  table-control' style="padding:5px; width: 100px; height:100px; border-radius: 50%; border: 1px solid #333"  > 
                        <img style="border-radius: 50%" width="100%" height="100%" src="../dataset/uploaded/uploaded_avatar/<?php echo $row['avatar']; ?>" onerror="this.src = 'layout/images/avatar.jpg'" />
                    </a>
                    <h5><?php echo $user;?></h5>
                </div>
                <div id="forScroll">
                <div class="pages ">

                    <ul>
                        <li >
                            <span class="slidebutton" data-class="show" data-index="0"><i class=" fas fa-angle-right fa-lg myblue" ></i></span>
                            <span class="slidebutton " data-class="hide" data-index="0"><i class="fas fa-angle-down fa-lg myblue" ></i></span>
                            <a  href="categories.php"><?php echo lang("cat") ?></a>
                            <?php if (!empty($categories)) {?>
                            <ul>
                                <li><a  href="categories.php">All categories</a></li>
                                <?php foreach($categories as $category) {?>
                                    <li><a  href="categories.php?do=show&catid=<?php echo $category['catid']?>&catname=<?php echo $category['name']?>"><i class="fa fa-car fa-lg mr-2"></i><?php echo $category['name'];?></a></li>
                                <?php }?>
                                
                                <li><a  href="categories.php?do=add"><i class="fa fa-plus fa-lg mr-2"></i>Add New Category</a></li>

                            </ul>
                            <?php } ?>
                        </li>
                        <li>
                            <span class="slidebutton" data-class="show" data-index="1"><i class=" fas fa-angle-right fa-lg myblue" ></i></span>
                            <span class="slidebutton " data-class="hide" data-index="1"><i class="fas fa-angle-down fa-lg myblue" ></i></span>
                            <a  href="items.php">Items</a>
                            <ul>
                                    <li>
                                        <input type="hidden" name="search" >
                                        <input style="width: 73%; display: inline-block;" class="inputSearch searchItem  form-control mr-sm-2" type="search" value="<?php echo ($searchItem == "all") ? "" : $searchItem; ?>" placeholder="Search Item" aria-label="Search" >
                                        <button style="margin-bottom: 5px;" class="btn btn-primary " ><i class="fa fa-search"></i></button>

                                    </li>
                                    <li><a  href="items.php">All Items</a></li>
                                    <li><a  href="items.php?action=filter&show=0&status=all&price=all&rating=all&search=all">Offered Items</a></li>
                                    <li><a  href="items.php?action=filter&show=1&status=all&price=all&rating=all&search=all">Sold Items</a></li>
                                    <li><a  href="items.php?action=filter&status=new&price=all&rating=all&show=all&search=all">New Items</a></li>
                                    <li><a  href="items.php?action=filter&status=like_new&price=all&rating=all&show=all&search=all">Like New Items</a></li>
                                    <li><a  href="items.php?action=filter&status=old&price=all&rating=all&show=all&search=all">Old Items</a></li>
                                    <li><a  href="items.php?action=filter&status=all&price=high&rating=all&show=all&search=all">High Price</a></li>
                                    <li><a  href="items.php?action=filter&status=all&price=medium&rating=all&show=all&search=all">Meduim Price</a></li>
                                    <li><a  href="items.php?action=filter&status=all&price=low&rating=all&show=all&search=all">Low Price</a></li>
                                    <li><a  href="items.php?action=filter&status=all&price=all&rating=1&show=all&search=all">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star "></span>
                                    <span class="fa fa-star "></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </a></li>
                                <li><a  href="items.php?action=filter&status=all&price=all&rating=2&show=all&search=all">
                                <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked "></span>
                                    <span class="fa fa-star "></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>

                                </a></li>
                                <li><a  href="items.php?action=filter&status=all&price=all&rating=3&show=all&search=all">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    
                                </a></li>
                                <li><a  href="items.php?action=filter&status=all&price=all&rating=4&show=all&search=all">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                
                                </a></li>
                                <li><a  href="items.php?action=filter&status=all&price=all&rating=5&show=all&search=all">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                
                                </a></li>
                                <li><a  href="items.php?do=add"><i class="fa fa-plus fa-lg mr-2"></i>Add New Item</a></li>

                            </ul>
                        </li>
                        <li>
                            <span class="slidebutton" data-class="show" data-index="2"><i class=" fas fa-angle-right fa-lg myblue" ></i></span>
                            <span class="slidebutton " data-class="hide" data-index="2"><i class="fas fa-angle-down fa-lg myblue" ></i></span>
                            <a  href="members.php">Members</a>
                            <ul>
                                <li>
                                    <input style="width: 73%; display: inline-block;" class="inputSearch searchUser form-control mr-sm-2" type="search" value="<?php echo $searchUser; ?>" placeholder="Search User" aria-label="Search" >
                                    <a style="margin-bottom: 5px;" class="btn btn-primary" href="#" ><i class="fa fa-search"></i></a>

                                </li>
                                <li><a  href="members.php">All Members</a></li>
                                <li><a  href="members.php?show=admins">Total Admins</a></li>
                                <li><a  href="members.php?show=pending">Pending Members</a></li>
                                <li><a  href="members.php?top5Users=offered">Most Active Users in offering</a></li>
                                <li><a  href="members.php?top5Users=bought">Most Active Users in buying</a></li>
                                <li><a  href="members.php?do=add"><i class="fa fa-plus fa-lg mr-2"></i>Add New User</a></li>
                                <li><a  href="members.php?do=addadmin"><i class="fa fa-plus fa-lg mr-2"></i>Add New Admin</a></li>

                            </ul>
                        </li>
                        <li>
                            <span class="slidebutton" data-class="show" data-index="3"><i class=" fas fa-angle-right fa-lg myblue" ></i></span>
                            <span class="slidebutton " data-class="hide" data-index="3"><i class="fas fa-angle-down fa-lg myblue" ></i></span>
                            <a  href="comments.php"><?php echo lang("com") ?></a>
                            <ul>
                                <li>
                                    <input style="width: 73%; display: inline-block;" class="inputSearch searchComment form-control mr-sm-2" type="search" value="<?php echo $searchComment; ?>" placeholder="Search Comment" aria-label="Search" >
                                    <a style="margin-bottom: 5px;" class="btn btn-primary" href="#" ><i class="fa fa-search"></i></a>

                                </li>
                                <li><a  href="comments.php">All Comments</a></li>
                            </ul>
                        </li>
                        <li>
                            <span class="slidebutton" data-class="show" data-index="4"><i class=" fas fa-angle-right fa-lg myblue" ></i></span>
                            <span class="slidebutton " data-class="hide" data-index="4"><i class="fas fa-angle-down fa-lg myblue" ></i></span>
                            <a href="#">My Account</a>
                            <ul>
                                <li><a href="members.php?do=edit&userid=<?php echo $_SESSION["userid"]?>"><i class="fa fa-user-circle fa-lg mr-2"></i><?php echo lang("pro") ?></a></li>

                                <li><a  href="#"><i class="fa fa-cog fa-lg mr-2"></i><?php echo lang("set") ?></a></li>

                                <li><a  href="logout.php"><i class="fa fa-exclamation-circle mr-2"></i><?php echo lang("out") ?></a></li>

                                <li><a  href="members.php?do=delete&userid=<?php echo $_SESSION["userid"]?>"><i class="fa fa-trash mr-2"></i><?php echo lang("del") ?></a></li>
                            </ul>
                        </li>

                    </ul>
                    </div>

                </div>
            </div>


