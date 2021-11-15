<nav class="navbar navbar-expand-lg navbar-dark">
	<div class="container">
	  <a class="navbar-brand" href="dashbord.php"><?php echo lang("hom") ?></a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarapp" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarapp" >
		<ul class="navbar-nav">
		  <li class="nav-item">
			<a class="nav-link" href="categories.php"><?php echo lang("cat") ?></a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="items.php"><?php echo lang("ite") ?></a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="members.php"><?php echo lang("mem") ?></a>
		  </li>
			<li class="nav-item">
			<a class="nav-link" href="comments.php"><?php echo lang("com") ?></a>
		  </li>
		</ul>
		
		<ul class="navbar-nav ml-auto">
		  <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  <?php
				$apperusername = ucwords($_SESSION["username"]);
		  		echo $apperusername;

				?>
			</a>
			<div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
				<a class="dropdown-item" href="members.php?do=edit&userid=<?php echo $_SESSION["userid"]?>"><?php echo lang("pro") ?><i class="fa fa-user-circle fa-lg ml-2"></i></a>

				 <a class="dropdown-item" href="#"><?php echo lang("set") ?><i class="fa fa-cog fa-lg ml-2"></i></a>

				 <a class="dropdown-item" href="logout.php"><?php echo lang("out") ?><i class="fa fa-exclamation-circle ml-2"></i></a>

				 <a class="dropdown-item" href="members.php?do=delete&userid=<?php echo $_SESSION["userid"]?>"><?php echo lang("del") ?><i class="fa fa-trash ml-2"></i></a>
			</div>
		  </li>
		</ul>

	  </div>
	</div>
</nav>


