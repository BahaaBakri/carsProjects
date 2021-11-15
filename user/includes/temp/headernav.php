<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo gettitle(); ?></title>
        <meta name="description" content="An interactive getting started guide for Brackets.">
    		<!-- fontawesome -->
        <link rel="stylesheet" href ="<?php echo $css; ?>all.min.css">
    		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    		<!-- bootstrap -->
    		<link rel="stylesheet" href ="<?php echo $css; ?>bootstrap.min.css">
    		<link rel="stylesheet" href ="<?php echo $css; ?>mybootstrap.css">
    		<!-- myfile.css -->
    		<link rel="stylesheet" href ="<?php echo $css; ?>carsuser.css">
        <link rel="stylesheet" href ="../admin/layout/css/carsadmin.css">
    </head>
    <body>
      
        <?php
          if(isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $row = select_user_data("users", "userid", $_SESSION['uid'], "fetch", "", "", "");
            if (checkuserstatus($user) == 0) { ?>
              <div class='alert alert-warning mywarning text-center'>
                Your account need to activate by admin
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
      <?php  }
          }

         ?>
    <div class="container">
      </div>
      <nav  class="navbar navbar-expand-lg navbar-dark" style="width: 100%; position:fixed; z-index:10000">
      	<div class="container">
      	  <a class="navbar-brand" href="index.php"><?php echo lang("hom") ?></a>
      	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarapp" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      		<span class="navbar-toggler-icon"></span>
      	  </button>

      	  <div class="collapse navbar-collapse" id="navbarapp">
        		<ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php                 
                  $cats = getcat();
                  foreach ($cats as $cat) {
                    $uppername = ucfirst($cat['name']);

                      echo "<a class='dropdown-item' href='categories.php?catid=" . $cat['catid'] . "&catname=" . str_replace(" ", "_", $uppername) . "'>" . $uppername . "</a>";

                  }

                ?>
                </div>
              </li>
              <li class="nav-item">
                <a href="items.php?do=add"class="nav-link my-2 my-sm-0 ">Offered Item <i class="fa fa-plus fa-lg"></i></a>
              </li>
            </ul>

        		
            <?php
            // if user in session when open page direct
            if (isset($_SESSION['user'])) { ?>
              <ul class="navbar-nav">
                <li class="nav-item dropdown mr-auto">
                <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php
                  $apperusername = ucwords($_SESSION["user"]);
                    echo $apperusername;

                  ?>
                </a>
                <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                  
                    <div class="account-info" style=" text-align: center;
                            margin: 0;
                            color: #333;">
                      <a href="profile.php?userid=<?php echo $_SESSION['uid']?>" class='btn  table-control' style="padding:5px; width: 100px; height:100px; border-radius: 50%; border: 1px solid #333"  > 
                          <img style="border-radius: 50%" width="100%" height="100%" src="../dataset/uploaded/uploaded_avatar/<?php echo $row['avatar']; ?>" onerror="this.src = 'layout/images/avatar.jpg'" />
                      </a>
                      <h5><?php echo $user;?></h5>
                    </div>
                  


                   <a class="dropdown-item" href="members.php?do=edit">Edit my profile <i class="fa fa-edit ml-2"></i></a>
                   <a class="dropdown-item" href="logout.php"><?php echo lang("out") ?><i class="fa fa-exclamation-circle ml-2"></i></a>
                   <a class="dropdown-item" href="#"><?php echo lang("set") ?><i class="fa fa-cog fa-lg ml-2"></i></a>

                   <a class="dropdown-item" href="members.php?do=delete"><?php echo lang("del") ?><i class="fa fa-trash ml-2"></i></a>
                </div>
                </li>

                <li class="nav-item dropdown mr-auto">
                <a class="nav-link notificationButton " href="#" id="navbarDropdown" style="position: relative;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-bell fa-lg"></i>
            <?php  if (getNumberOfNotification($_SESSION['uid']) !== 0) { ?>
                  <span class="numberNotification"><?php echo getNumberOfNotification($_SESSION['uid'])?></span>
            <?php } ?>
                </a>
                <div id="ajaxNotification" class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">

                </div>
                </li>
              </ul>
        <?php  } else { ?>
            <ul class="navbar-nav ml-auto">
              <li><a href="loginsignup.php?do=login"class="btn btn-primary my-2 my-sm-0 text-white">Login <i class="fa fa-user-circle fa-lg"></i></a></li>
              <li><a href="loginsignup.php?do=signup"class="btn btn-success my-2 my-sm-0 text-white">Sign up <i class="fa fa-user-circle fa-lg"></i></a></li>
            </ul>
          <?php } ?>
          </div>
      	</div>
      </nav>
