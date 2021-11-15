<?php

use function PHPSTORM_META\type;

  ob_start();
	session_start();


		// when come from index.php 
    //print_r($_SESSION['userid']);
    $pagetitle = "Items";
		include "ini.php";
    $uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : "";
		$do = "";
    if (isset($_GET["do"])) {
			$do = $_GET['do'];
		} else {
			$do = "";
		}

   


   if ($do === "add") { 
      // Add page code 
      if (isset($_SESSION['uid'])) { ?>
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
                    <input type="number" class="form-control col-md-8" id="Kilometers" name="Kilometers" placeholder="Type  Kilometers Driven here" required='required'>
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
                    <input type="number" class="form-control col-md-8" id="cc" name="cc" placeholder="Type Engine 'cc' here" required='required'>
                    <p class="col-md-8 ml-auto validate reqvalidate">- Please fill out Engine "cc"</p>
                  </div>
                  <div class="form-group row">
                    <label  class="col-md-4" for="power">Power "bhp":</label>
                    <input type="number" class="form-control col-md-8" id="power" name="power" placeholder="Type Power 'bhp' here" required='required'>
                    <p class="col-md-8 ml-auto validate reqvalidate">- Please fill out Power "bhp"</p>
                  </div>
                  <div class="form-group row">
                    <label  class="col-md-4" for="seats">Seat Num:</label>
                    <input type="number" class="form-control col-md-8" id="seats" name="seats" placeholder="Type seats number here" required='required'>
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


<?php } else { ?>
           <div style="margin-top: 60px;">
           <div class='alert alert-warning text-center'>Log in or sign up first</div>
           <div class="row" style="justify-content: space-between; width:25%; margin:auto">
               <a href="loginsignup.php?do=login"class="btn btn-primary my-2 my-sm-0 text-white">Login <i class="fa fa-user-circle fa-lg"></i></a>
               <a href="loginsignup.php?do=signup"class="btn btn-success my-2 my-sm-0 text-white">Sign up <i class="fa fa-user-circle fa-lg"></i></a>
               <a href="javascript:history.back()" class=" btn btn-secondary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page </a>
     
           </div>
          </div>
<?php  }
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

          $check = insert_user_data("items", "name", "'$name'", "description", "'$desc'", "price", "'$price'", "country", "'$country'","image","'$fileName'", "quality", "'$quality'", "status", "'$status'", "rating", "$rating", "userid_bind", $_SESSION['uid'], "catid_bind", "$cat", "datetime", "now()");


          // check if insert success

          if ($check > 0) {


              $msg ="<div class='alert alert-success text-center'>Insert Succeded,  $check row inserted</div>";
              redirect($msg, "profile.php?userid=" . $_SESSION['uid'], 'Your Profile');?>
              <a href="profile.php?userid=<?php echo $_SESSION['uid']?>" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Profile Page Now</a>

    <?php  } else {

             $msg ="<div class='alert alert-danger text-center'>Insert Faild,  $check row inserted</div>";
             redirect($msg, 'index.php', 'Home Page');?>
            <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
    <?php
           }
         } else {

            // Validation Error

            foreach ($errorarray as $error) { ?>

              <div class="mycontainer">
                <div class="alert alert-danger text-center"><?php echo $error; ?></div>
              </div>

            <?php }
             redirect("", 'index.php', 'Home Page');?>
            <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>

  <?php  }
        // add button ?>
            <a href="?do=add" class="savemember btn myblueback text-white"><i class="fa fa-plus"></i>  New Member</a>
      <?php } else {

        $msg ="<div class='alert alert-danger text-center'>Sorry you can't open this page direct, Try again</div>";
        redirect("", 'index.php', 'Home Page');?>
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
     if (isset($_SESSION['uid'])) {
      $itemid = $_GET['itemid'];

      $row = select_user_data("items", "itemid", $itemid);

      // check if itmid in DB

      if (!empty($row)) { ?>
        <!-- Button trigger modal -->
        <input type="hidden" class="triggermodal" data-toggle="modal" data-target="#staticBackdrop">
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Confirm Buy</h5>
                  <a class="close" href="index.php" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </a>
              </div>
              <div class="modal-body">
                  Are you really sure want to buy <?php echo $row['name']; ?> item ?
              </div>
            <div class="modal-footer">
                <a  class="btn btn-secondary" href="index.php">Cancel</a>
                <a  class="btn btn-info" href="items.php?do=buyaccess&itemid=<?php echo $row['itemid']; ?>&name=<?php echo $row['name']; ?>">Buy</a>
            </div>
          </div>
        </div>
      </div>

    <?php }
    
    else {

      // There is no such id

      $msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
      redirect($msg, 'index.php', 'Home Page');?>
      <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
<?php  }
     }  else {
     // you do not have session ?>
     <div style="margin-top: 60px;">
      <div class='alert alert-warning text-center'>Log in or sign up first</div>
      <div class="row" style="justify-content: space-between; width:25%; margin:auto">
          <a href="loginsignup.php?do=login"class="btn btn-primary my-2 my-sm-0 text-white">Login <i class="fa fa-user-circle fa-lg"></i></a>
          <a href="loginsignup.php?do=signup"class="btn btn-success my-2 my-sm-0 text-white">Sign up <i class="fa fa-user-circle fa-lg"></i></a>
          <a href="javascript:history.back()" class=" btn btn-secondary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page </a>

      </div>
     </div>

<?php  }
   } 
   elseif($do ==  "sell") {
    
     $itemid = $_GET['itemid'];
     $userid = $_GET['userid'];
     $status = $_GET['status'];
     $rowitem = select_user_data("items", "itemid", $itemid);
     $rowuser = select_user_data("users", "userid", $userid);


     // check if itmid in DB

     if ((!empty($rowitem)) && (!empty($rowuser))) { ?>
       <!-- Button trigger modal -->
       <input type="hidden" class="triggermodal" data-toggle="modal" data-target="#staticBackdrop">
       <!-- Modal -->
       <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="staticBackdropLabel">Confirm Sell</h5>
                 <a class="close" href="index.php" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </a>
             </div>
          <?php if ($status === "approve") {?>
              <div class="modal-body">
                  Are you sure want to approve <?php echo $rowuser['username']; ?> request about buying your item <?php echo $rowitem['name']; ?> ?
              </div>
              <div class="modal-footer">
                  <a  class="btn btn-secondary" href="index.php">Cancel</a>
                  <a  class="btn btn-success" href="items.php?do=sellaccess&itemid=<?php echo $rowitem['itemid']; ?>&name=<?php echo $rowitem['name']; ?>&userid=<?php echo $rowuser['userid']; ?>&username=<?php echo $rowuser['username']; ?>">Sell</a>
              </div>
          <?php } else if ($status === "reject") { ?>
              <div class="modal-body">
                  Are you sure want to reject <?php echo $rowuser['username']; ?> request about buying your item <?php echo $rowitem['name']; ?> item ?
              </div>
              <div class="modal-footer">
                  <a  class="btn btn-secondary" href="index.php">Cancel</a>
                  <a  class="btn btn-danger" href="items.php?do=rejectaccess&itemid=<?php echo $rowitem['itemid']; ?>&name=<?php echo $rowitem['name']; ?>&userid=<?php echo $rowuser['userid']; ?>&username=<?php echo $rowuser['username']; ?>">Reject</a>
              </div>
          <?php } ?>
         </div>
       </div>
     </div>

   <?php }
   
   else {

     // There is no such id

     $msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
     redirect($msg, 'index.php', 'Home Page');?>
     <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
<?php  }  
 
  } 
   else if ($do === "buyaccess") {
    if ($_SERVER['REQUEST_METHOD'] === "GET") {
      $uid = $_SESSION['uid'];
      $itemid = $_GET['itemid'];
      $userid = get_item_user($itemid);
      $itemname = $_GET['name'];
      if (isset($itemid)) {
        // Update items Table & Insert Data inside buy Table
        $check1 = update_user_data("items", "itemid = $itemid", "bought = 2");
        $check2 = insert_user_data('sells', 'name', "'$itemname'", "selldatetime", "now()", "itemid_bind", $itemid, "userid_bind", $uid);

        // echo $check1;
        if (($check1 > 0) && ($check2 > 0)) {
            // Buy Ok
            // add notification
            $not =  insert_user_data("notification", "notstatus", "'buyrequest'","notdatetime", "now()", "itemid_bind", "$itemid", "userid_bind", "$uid", "userid_not", "$userid");
            $msg ="<div class='alert alert-success text-center'>Your request to buy $itemname is prepared, wait the approve</div>";
            redirect($msg, 'index.php', 'Home Page');?>
            <a href="index.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Home Page Now</a>
    <?php  } else {
            // Buy failed
            $msg ="<div class='alert alert-danger text-center'>Some thing wrong, your request to buy $itemname fails</div>";
            redirect($msg, 'index.php', 'Home Page');?>
            <a href="index.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Home Page Now</a>
    <?php  }
        } else {
            // There is no such id
            $msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
            redirect($msg, 'index.php', 'Home Page');?>
            <a href="index.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Home Page Now</a>
  <?php  }

} else {
    $msg ="<div class='alert alert-danger text-center'>Sorry you can't open this page direct, Try again</div>";
    redirect($msg, 'index.php', 'Home Page'); ?>
    <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
<?php }
    } else if ($do === "sellaccess") {
      if ($_SERVER['REQUEST_METHOD'] === "GET") {
        $uid = $_SESSION['uid'];
        $itemid = $_GET['itemid'];
        $userid = $_GET['userid'];
        $itemname = $_GET['name'];
        $username = $_GET['username'];
        if ((isset($itemid)) && (isset($userid))) {
          // Update items Table & Insert Data inside buy Table
          $check1 = update_user_data("items", "itemid = $itemid", "bought = 1");
          $check2 = update_user_data("sells", "itemid_bind = $itemid", "approve = 1", "selldatetime = now()");
  
          // echo $check1;
          // echo $check2;
          if (($check1 > 0) && ($check2 > 0)) {
              // Buy Ok
              // add notification
              $not =  insert_user_data("notification", "notstatus", "'buysuccess'","notdatetime", "now()", "itemid_bind", "$itemid", "userid_bind", "$uid", "userid_not", "$userid");
              $notToDelete =  delete_row("notification", "notstatus", "'buyrequest'", "AND itemid_bind = $itemid AND userid_bind = $userid AND userid_not = $uid");

              $msg ="<div class='alert alert-success text-center'>$username bought your item $itemname successfuly</div>";
              redirect($msg, 'index.php', 'Home Page');?>
              <a href="index.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Home Page Now</a>
      <?php  } else {
              // Buy failed
              $msg ="<div class='alert alert-danger text-center'>Some thing wrong, the process for approve buying your item $itemname fails</div>";
              redirect($msg, 'index.php', 'Home Page');?>
              <a href="index.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Home Page Now</a>
      <?php  }
          } else {
              // There is no such id
              $msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
              redirect($msg, 'index.php', 'Home Page');?>
              <a href="index.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Home Page Now</a>
    <?php  }
  
  } else {
      $msg ="<div class='alert alert-danger text-center'>Sorry you can't open this page direct, Try again</div>";
      redirect($msg, 'index.php', 'Home Page'); ?>
      <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
  <?php }
    } else if ($do === "rejectaccess") {
      if ($_SERVER['REQUEST_METHOD'] === "GET") {
        $uid = $_SESSION['uid'];
        $itemid = $_GET['itemid'];
        $userid = $_GET['userid'];
        $itemname = $_GET['name'];
        $username = $_GET['username'];
        if ((isset($itemid)) && (isset($userid))) {
          // Update items Table & Insert Data inside buy Table
          $check1 = update_user_data("items", "itemid = $itemid", "bought = 0");
          $check2 = delete_row("sells", "itemid_bind", $itemid , "AND userid_bind = $userid" );
  
          // echo $check1;
          if (($check1 > 0) && ($check2 > 0)) {
              // Reject Buy Ok
              // add notification
              $not =  insert_user_data("notification", "notstatus", "'buyfails'", "notdatetime", "now()", "itemid_bind", "$itemid", "userid_bind", "$uid", "userid_not", "$userid");
              $notToDelete =  delete_row("notification", "notstatus", "'buyrequest'", "AND itemid_bind = $itemid AND userid_bind = $userid AND userid_not = $uid");
              $msg ="<div class='alert alert-success text-center'>You are reject $username request for buying your item $itemname successfuly</div>";
              redirect($msg, 'index.php', 'Home Page');?>
              <a href="index.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Home Page Now</a>
      <?php  } else {
              // Buy failed
              $msg ="<div class='alert alert-danger text-center'>Some thing wrong, the process for reject buying your item $itemname fails</div>";
              redirect($msg, 'index.php', 'Home Page');?>
              <a href="index.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Home Page Now</a>
      <?php  }
          } else {
              // There is no such id
              $msg = "<div class='alert alert-danger text-center'>There is no such id, Try again</div>";
              redirect($msg, 'index.php', 'Home Page');?>
              <a href="index.php" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Home Page Now</a>
    <?php  }
  
  } else {
      $msg ="<div class='alert alert-danger text-center'>Sorry you can't open this page direct, Try again</div>";
      redirect($msg, 'index.php', 'Home Page'); ?>
      <a href="javascript:history.back()" class="save btn btn-primary text-white"><i class="fa fa-reply fa-lg"></i> Go to Previous Page Now</a>
  <?php }      
    } else if ($do === "details") {
      $itemid = $_GET['itemid'];
      $row = get_item_details($itemid);
      $comments = getCommentsItem($itemid);
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
    <div class="mybigcontainer" style="margin-top: 75px;">
      <div class="row itemDetails" style="justify-content:space-around;">
        <div class="col-md-6 details">
          <h2><?php echo $row['name']?></h2>


          <div class="row notices">
          <?php if ($bought) { ?>
            <div class="mysuccessBack not">It is bought by me</div>
          <?php } else  {?>
            <div class="bg-primary not">It is still offered</div>
          <?php } ?>


            <div style="margin-left: auto;">
              <div class="itemActions">
                <?php if ($row['userid_bind'] == $uid) { ?>
                  <a href="items.php?do=edit&itemid=<?php echo $row['itemid']; ?>" class='card-action btn mysuccess table-control'> <i class='fa fa-edit fa-lg'></i></a>
                  <a href="items.php?do=delete&itemid=<?php echo $row['itemid']; ?>" class='card-action btn mydanger table-control'> <i class='fa fa-trash fa-lg'></i></a>
                <?php } else { ?>
                  <a href="items.php?do=buy&itemid=<?php echo $row['itemid']; ?>" class='btn btn-success'> Buy</a>
                  <?php } ?>
              </div>  
            </div>

          </div>
          <div class="rating" data-rate-value=<?php echo $row['rating']; ?>> </div>
          <hr class="myhr">
          <div style="color:orange; font-weight:bold">$ <?php echo $row['price']?></div>
          <hr class="myhr">
          <div><span>Category : </span><a class="mya" href='categories.php?catid=<?php echo $row['catid_bind']; ?>&catname=<?php echo $row['catname'] ?>'> <?php echo $row['catname'] ?></a></div>
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
                      <p id = "<?php echo $value['comid']?>" class="thisComment text-muted"><?php echo $value['comment'];?></p>
                    </div>
                    <?php if (isset($_SESSION['uid']) && $_SESSION['uid'] == $value['userid']) {?>
                    <div class="options">
                      <button id = "<?php echo $value['comid']?>" class="editComment btn mysuccess"> <i class='fa fa-lg fa-edit'></i></button>
                      <button id = "<?php echo $value['comid']?>" class="deleteComment btn mydanger"> <i class='fa fa-lg fa-trash'></i></button>

                    </div>
                    <?php } ?>
                  </div>
              <?php } } else { ?>
                <p class="text-muted"> There is no any comment yet ...</p>
          <?php  } ?>
                <div style="display: flex; justify-content:space-between; width:100%">
                <input id="commentitemid" type="hidden" value= "<?php echo $itemid?>">
                  <input id="comment" class="form-control" style=" width:90%" type="text" placeholder="Type Comment">
                  <button  class ="addComment btn btn-primary">
                    Send
                  </button>
                  <button  class ="updateComment btn btn-primary">
                    Update
                  </button>
                  <button  class ="exitEditComment btn btn-danger">
                    <i class='fa fa-lg fa-times'></i>
                  </button>
                </div>

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

    	include $temp . "footer.php";
      ob_end_flush();
    ?>
    </div>
  </div>
