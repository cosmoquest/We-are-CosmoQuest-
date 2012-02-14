<div id="main-blk"><div id="main-content-blk" class="wrapper">

	<?php if (!$admin){
		echo "You do not have permission to be here! Pick any of the buttons above to find your way somewhere better."; ?>
		</div></div>
		
		<?php
		@mysql_close($db);
		include($skin_root."CQ-footer.php");
		
		die();
	} ?>

	<H2 style="border-bottom: 1px solid #fff;">Welcome to We are CosmoQuest Admin Screen</H2>


	<?php
	// Check if task is specified
	if (!isset($_GET['task']) && !isset($_POST['task']) && $admin ) {
			main_menu();
			
	// If a task is specified, do it
	} else {
		if (isset($_GET['task'])) $task = htmlspecialchars(mysql_real_escape_string($_GET['task']));
		else                      $task = htmlspecialchars(mysql_real_escape_string($_POST['task']));
		
				
		switch ($task) {
			case "form_new_bio":
				include ($doc_root."/forms.php");
				form_bio(1, 1);
				break;
			case "submit_new_bio":
			  include ($doc_root."/forms.php");
				submit_bio($url_wer, $doc_root, 1, 1);
				break;
			case "form_mod_bio":
				form_mod_bio($url_wer);
				break;
			case "submit_mod_bio":
				submit_mod_bio($url_wer);
				break;
			case "form_edit_bio":
				include ($doc_root."/forms.php");
				form_bio(0, 1);
				break;
			case "submit_edit_bio":
				include ($doc_root."/forms.php");
				submit_bio($url_wer, $doc_root, 0, 1);
				break;
		default:
				echo "<h2>Error</H2><p>Task \"$task\" not found.</p>";
		}
		
	}
	
	?>
</div></div>


<?php

// Form to moderate bios -----------------------------------------------------------------------------------------------------------
function form_mod_bio($url) {
	$query = "SELECT * from bios order by id DESC";
	$result = mysql_query($query);
	?>
	<form action="index.php" method="POST">
		<input type="hidden" name="action" value="admin">
		<input type="hidden" name="task" value="submit_mod_bio">
		<input type="submit" name="Update">
	<?php
	echo "<table>";
	
	// Table headers
	?>
						 <tr><td><strong>Display</strong></td><td><strong>Featured</strong></td><td colspan=4><strong>User Information</strong></td></tr>
	<?php
	$i = 0;
	while ($user_db = mysql_fetch_array($result)) {
				echo "<input type='hidden' name='user[$i][username]' value='".$user_db['username']."'>";
				echo "<tr><td rowspan=3 valign='top' width='80px'>"; 
        
        if ($user_db['display']) echo "<input type='checkbox' name='user[$i][display]' checked  style='width: 30px'>";
				else                      echo "<input type='checkbox' name='user[$i][display]' style='width: 30px'>";
				echo "</td>";
				echo "<td rowspan=3 valign='top' width='80px'>"; 
        
        if ($user_db['featured']) echo "<input type='checkbox' name='user[$i][featured]' checked  style='width: 30px'>";
				else                      echo "<input type='checkbox' name='user[$i][featured]'  style='width: 30px'>";
				echo "</td>";
        
        echo "    <td rowspan='3'></td><td rowspan=3 valign='top' width='50px'><img src='$url/timthumb.php?src=".$user_db['picture']."&h=50&w=50&a=t' style='margin-right: 10px;'></td>
		          <td width='50px'>".$user_db['username']."</td>
                  <td width='150px'>".$user_db['firstname']." ".$user_db['lastname']."</td>
				  <td>";
							if ($user['website'] != -1) 
									echo "<a href='".$user['website']."'>
												<img src='images/social_icons/website_16.png' width='16px' height='16px'>
												</a>";
							if ($user['facebook'] != -1) 
									echo "<a href='http://www.facebook.com/".$user['facebook']."'>
												<img src='images/social_icons/facebook_16.png' width='16px' height='16px'>
												</a>"; 
							if ($user['facebook'] != -1) 
									echo "<a href='http://plus.google.com/".$user['google']."'>
												<img src='images/social_icons/google_plus_16.png' width='16px' height='16px'>
												</a>"; 
							if ($user['twitter'] != -1) 
									echo "<a href='http://twitter.com/".$user['twitter']."'>
												<img src='images/social_icons/twitter_16.png' width='16px' height='16px'>
												</a>";
		echo "         </td></tr>
							<tr><td colspan='3' >".$user_db['minibio']."</td></tr>
							<tr><td colspan='3' ><div style='height: 50px; overflow: auto;'>".$user_db['statement']."</div></td></tr>
							<tr><td colspan='8'>&nbsp;</td></tr>";
		$i++;
	}
	echo "</table><br><input type='submit' name='Update'></form>";
}

// Submit moderation form ------------------------------------------------------------------------------------------------
function submit_mod_bio() {
	
	$array = $_POST["user"];
	
	foreach($array as $value) {
				if ($value['display'] == "on") $display = 1; else $display = 0;
				if ($value['featured'] == "on") $featured = 1; else $featured = 0;
				$username = htmlspecialchars(mysql_real_escape_string($value['username']));
				$query= "UPDATE bios SET display = $display, featured=$featured WHERE username = '$username' ";
				mysql_query($query); echo mysql_error();
	}
	echo "Table updated";
	main_menu();
}

// Function Main Menu ----------------------------------------------------------------------------------------------------
function main_menu() {
	?>
	<p> What would you like to do?</p>
	<form name="admin" action="index.php" method="GET">
		<input type="hidden" name="action" value="admin">
		<input type="radio" name="task" value="form_new_bio" style="width: 30px"> Create a new bio<br/>
		<input type="radio" name="task" value="form_mod_bio" style="width: 30px"> Moderate bios<br/>
		<input type="radio" name="task" value="form_edit_bio" style="width: 30px"> Edit a particular user
		<select name='username'>
			<?php
					$query = "SELECT * FROM bios";
					$result = mysql_query($query); echo mysql_error();
					echo "<option></option>";
					while ($user = mysql_fetch_array($result)) {
							echo "<option value='".$user['username']."'>".$user['lastname'].", ".$user['firstname']."</option>";
					}
			?>
		</select><br/>
		<input type="submit" value="Go" style="float: left;">
	</form>
	<?php 
}

?>