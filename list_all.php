<div id="main-blk"><div id="main-content-blk" class="wrapper">
	
<?php

// Check if users exists ------------------------------------------------------------------------------------------------------------------------------------
	  $query    = "SELECT * FROM bios ORDER BY lastname";
		$result   = mysql_query($query);


// User found and all is well ----------------------------------------------------------------------------------------------------------------------------------
		if ($user = mysql_fetch_array($result) ) {
				
				// Sidebar -------------------------------------------------------------------------------------------------------
				?>
				
				<div style="float: right; width: 220px; margin-top: 10px;">
					
					  <!-- Links Area -->
						<div id="explore" style="width: 200px; border: 1px solid #333;padding: 10px;">
							<h4 style="width: 100%;">Explore</h4>
							<ul style="font-family: Verdana, Geneva, sans-serif; font-size: 12px;">
							<li><a href='<?php echo $url_wer; ?>/index.php?action=user&username=random'>Show a random person</a></li>
							<li><a href="<?php echo $url_wer; ?>/index.php?action=list_all" style="color: white;">List everyone</a></li>
							<li><del>Create my own entry! (moderated)</del> Coming Soon</li>
							</ul>
						</div>

						
				</div>
				<?php
				// Main Body ---------------------------------------------------------------------------------------------------
				?>
				
				<div style="float: left; width: 700px; margin-top: 10px;"> <!-- This is the div of the cards -->
				
				<div style="float: left; background: #000 url('./images/RoledexCard.png') no-repeat top right; width: 200px; height: 100px; color: black; margin: 0 10px 10px 0;">
					<div style="background: black; width: 50px; height: 50px; margin: 10px 5px 0px 10px; float: left; border: 3px solid #731810; float: left;">
						<?php
						  echo "<a href='$url_wer/index.php?action=user&username=".$user['username']."'>";
							echo "<img src='$url_wer/timthumb.php?src=".$user['picture']."&h=50&w=50&a=t'></a>";
						?>
					</div>
					<?php
					echo "<div><p>".$user['firstname']."<br/>".$user['lastname']."<br/>
					           <small>".$user['job']."<br/>".$user['homecountry']."</small></p></div>";
					
					?>
				</div>
				
				<?php
				while ($user = mysql_fetch_array($result) ) { ?>
						<div style="float: left; background: #000 url('./images/RoledexCard.png') no-repeat top right; width: 200px; height: 100px; color: black; margin: 0 10px 10px 0;">
							<div style="background: black; width: 50px; height: 50px; margin: 10px 5px 0px 10px; float: left; border: 3px solid #731810; float: left;">
								<?php
								  echo "<a href='$url_wer/index.php?action=user&username=".$user['username']."'>";
									echo "<img src='$url_wer/timthumb.php?src=".$user['picture']."&h=50&w=50&a=t'></a>";
								?>
							</div>
							<?php
							echo "<div><p>".$user['firstname']."<br/>".$user['lastname']."<br/>
							           <small>".$user['job']."<br/>".$user['homecountry']."</small></p></div>";

							?>
						</div>
				<?php } ?>	
				</div>
				<?php
				
// User not found ----------------------------------------------------------------------------------------------------------------------------------------------
		} else {
			echo "<h2>No Users Available</h2>"; 
			die();
		}
	
	?>
	
</div></div>