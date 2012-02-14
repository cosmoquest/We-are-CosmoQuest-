<div id="main-blk"><div id="main-content-blk" class="wrapper">

<?php
// Start the top of the page -----------------------------------------------------------------------------------------------------------------------------------
?>
		<p style="text-align: center"><img src="./images/WeAreCosmoQuest-landing.png"></p>

<?php
// Featured ----------------------------------------------------------------------------------------------------------------------------------------------------
		$result = mysql_query("SELECT * FROM bios WHERE display = 1 AND featured = 1 ORDER BY RAND() LIMIT 7");
		echo mysql_error();
		$user   = mysql_fetch_array($result);
		echo mysql_error();
?>		
		<div style="margin: 0 125px">
				<div style="float: left; width: 330px; border: 1px solid #333;padding: 10px; margin: 0px 0 0 10px">
							<div style="float: left; height: 85px; width: 110px; margin-right: 10px">
								<h4><small> Featured</small></h4><br/>
								<?php
								while ($others = mysql_fetch_array($result) ) {
									echo "<a href='$url_wer/index.php?action=user&username=".$others['username']."'>
									      <img src='$url_wer/timthumb.php?src=".$others['picture']."&h=24&w=24&a=t' 
													   title='".$others['firstname']." ".$others['lastname']."'
									           style='margin-right: 2px; width: 24px; height: 24px; border: 1px solid #333;'></a>";
								}
								?>
							</div>
							<div style="float: left; background: #000 url('./images/RoledexCard.png') no-repeat top right; width: 200px; height: 100px; color: black;">
								<div style="background: black; width: 50px; height: 50px; margin: 10px 5px 0px 10px; float: left; border: 3px solid #731810;">
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
				</div>

<?php
// New ---------------------------------------------------------------------------------------------------------------------------------------------------------
		$result = mysql_query("SELECT * FROM bios WHERE display = 1 ORDER BY id DESC LIMIT 7");
		echo mysql_error();
		$user   = mysql_fetch_array($result);
		echo mysql_error();
?>		
				<div style="float: left; width: 330px; border: 1px solid #333;padding: 10px; margin: 0px 0 0 10px">
							<div style="float: left; height: 85px; width: 110px; margin-right: 10px">
								<h4><small> New Profiles</small></h4><br/>
								<?php
								while ($others = mysql_fetch_array($result) ) {
									echo "<a href='$url_wer/index.php?action=user&username=".$others['username']."'>
									      <img src='$url_wer/timthumb.php?src=".$others['picture']."&h=24&w=24&a=t' 
													   title='".$others['firstname']." ".$others['lastname']."'
									           style='margin-right: 2px; width: 24px; height: 24px; border: 1px solid #333;'></a>";
								}
								?>
							</div>
							<div style="float: left; background: #000 url('./images/RoledexCard.png') no-repeat top right; width: 200px; height: 100px; color: black;">
								<div style="background: black; width: 50px; height: 50px; margin: 10px 5px 0px 10px; float: left; border: 3px solid #731810;">
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
				</div>

				<!-- Exploration options -->
				<div id="explore" style="float: left; width: 330px; height: 105px; border: 1px solid #333;padding: 10px; margin: 10px 0 0 10px; ">
					<h4 style="width: 100%;">Explore</h4>
					<ul style="font-family: Verdana, Geneva, sans-serif; font-size: 12px;">
					
					<li><a href='<?php echo $url_wer; ?>/index.php?action=user&username=random'>Show a random person</a></li>
					<li><a href="<?php echo $url_wer; ?>/index.php?action=list_all">List everyone</a></li>
					
					<?php if ($logged_in) { ?>
							<li><a href="http://cosmoquest.org/weare/index.php?action=create_my_profile"> Create or edit my own entry! (moderated)</a></li>
					<?php } else { ?>
							<li><a href="<?php echo $login_url; ?>"> Login to create your own entry. (moderated)<br/>
									<em>Don't have an account? Registration is free!</em></a></li>
					<?php } ?>
					</ul>
				</div>
				
		</div>

</div></div>