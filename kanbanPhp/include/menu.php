<?php
	$init_actif = "";
	switch ($page)
	{
		case "user":
		case "project":
		case "category":
		case "state":
			$init_actif = ' class="actif"';
			break;
		default:
			break;
	}
?>
<div id="menu_content">
	<ul class="menu">
		
		<li <?php echo $init_actif; ?>><a href="javascript:void(0)">Users</a>
			<ul class="sousmenu">
				<li><a href="user.php" <?php echo (($page == "user")?" class='actif'":""); ?>>Liste</a></li>			
			</ul>
		</li>
	
		<li <?php echo $init_actif; ?>><a href="javascript:void(0)">Projects</a>
			<ul class="sousmenu">
				<li><a href="project.php" <?php echo (($page == "project")?" class='actif'":""); ?>>Liste</a></li>
			</ul>
		</li>
		
		<li <?php echo $init_actif; ?>><a href="javascript:void(0)">Categories</a>
			<ul class="sousmenu">
				<li><a href="category.php" <?php echo (($page == "category")?" class='actif'":""); ?>>Liste</a></li>
			</ul>
		</li>
		
		<li <?php echo $init_actif; ?>><a href="javascript:void(0)">States</a>
			<ul class="sousmenu">
				<li><a href="state.php" <?php echo (($page == "state")?" class='actif'":""); ?>>Liste</a></li>
			</ul>
		</li>
		
	</ul>
</div>