<?php
//---------- Form to submit a new user --------------------------------------------------------------------------------------
function form_bio($new, $admin_request = 0) {
		GLOBAL $username;
	
		// Set up the needed div
		echo "<div class='explainer'>";
	
		// If they aren't an admin, they can only edit their own details, and they need instructions
		if (!$admin_request) {
				$bioname = $username;
				$get_bio = mysql_query("SELECT * FROM bios WHERE username = '$bioname'"); echo mysql_error();
				if ($bio = mysql_fetch_array($get_bio) ) $new = 0;
				?>
				<p style='font-style: normal; color: #fff; font-size: 14px;'><strong>Thanks for being part of this project!</strong> Before 
					you get started, we just wanted to say please be honest in sharing with us why astronomy, planetary science and/or space 
					exploration matter to you. There is no right answer - there's just your answer. That said, because this site is open to 
					everyone we ask that you use kid-safe language and pictures. We will moderating spam and potentially offensive content, 
					and while we read your entry we reserve the right to correct your spelling and capitalization. If we think anything else 
					needs changing, we'll contact you. When you click submit, you are agreeing to these terms. (We just want you to shine!)
				</p><br/><?php
			
		// If they are an admin, get the bio related to their login. If it exists, automatically set it up for editting
		} else {
				if (!$new) {
						$bioname = htmlspecialchars(mysql_real_escape_string($_GET['username']));

						$get_bio = mysql_query("SELECT * FROM bios WHERE username = '$bioname'"); echo mysql_error();
						$bio = mysql_fetch_array($get_bio);
				}
		}	
	
		// Set up the form ---------------------------------------------------------------------------------------------------------------
		?>
		<p>Please enter information for the submission. Required items are marked with an asterisk (*).</p>
		<form name="new_bio" action="index.php" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="action" value="admin">
				
				<?php // Make sure that the correct form gets used to update or insert the data
				// Update an existing bio
				if (!$new) { ?>
						<input type="hidden" name="task" value="submit_edit_bio">		
				<?php // Insert a new bio
				} else { ?>
						<input type="hidden" name="task" value="submit_new_bio">
				<?php } ?>
		
				<!-- Setup the sidebar for the essay ......................................................................................-->
				<div style="float: right">
						Personal Statement:*<br/>
						<textarea name="statement" rows=36 style="width: 550px;"><?php 
								if (!$new) { if ($bio['statement'] != -1) echo $bio['statement']; } ?></textarea><br/>	
						<input type="submit" value="submit" style="float:right; margin-top:30px; background: #365897;">
						
						<!-- Setup essay instructions .........................................................................................-->
						<div style="width:310px;">
								<p style="font-size: 13px;">The personal statement is your chance to explain why astronomy, planetary science, and/or 
									space exploration matter to you. We each have our reasons to look up, to explore the universe, and to share what we 
									know with others. What are your reasons? (300-500 words, please)
								</p>
						</div> <!-- End instructions -->		
				</div> <!-- End Sidebar -->
			
			  <!-- Setup the main form of data ............................................................................................-->
			  <table>
				
						<!-- Username -->
					  <tr><td class="text-right">Username*: </span></td>
						<?php if (!$admin_request) {?>
								<td><strong><?php echo $bioname; ?></strong></td>
								<input type="hidden" name="username" value="<?php echo $username; ?>">
						<?php } else { ?>
								<td>
								<input type="text" name="username" <?php if (!$new) { if ($bio['username'] != -1) echo "value='".$bio['username']."'"; } ?> ></td>
						<?php } ?>
						</tr>
						
						<!-- First and Last names -->
						<tr><td class="text-right">Firstname*:</span></td>
					  		<td><input type="text" name="firstname" <?php if (!$new) { if ($bio['firstname'] != -1) echo "value='".$bio['firstname']."'"; } ?> ></td>
					
			  		<tr><td class="text-right">Lastname: </td>
						    <td><input type="text" name="lastname" <?php if (!$new) { if ($bio['lastname'] != -1) echo "value='".$bio['lastname']."'"; } ?> ></td>
						</tr>
						<tr><td colspan=2 style="height: 20px;"><p style="font-size: 13px;">If you don't want to use your real name, please use your login name<br/> for your first name.</p></tr>			
			
						<!-- Profile picture -->
						<tr><td class="text-right">Profile Picture*: </td>
								<?php // If it already exists show a thumbnail
								if (!$new) { ?>
										<td><input type="file" name="file" id="file" style="width: 200px;" />
												<img src="<?php echo $bio['picture']; ?>" height="30px" width="30px" style="float:right; margin-top: 6px;"></td>
								<?php } else { ?>		
							  		<td><input type="file" name="file" id="file" /></td>
								<?php } ?>
						</tr>
						<tr><td colspan=2 style="height: 20px;"><p style="font-size: 13px;">Upload a file that is 300px &times; 300px</p></tr>
				
						<!-- Get degree information -->
			  		<tr><td class="text-right">Degree: </td>
								<td class="text-right"> 
											<select name="degree">
													<option > </option>
										
													<?php 
													$get_degrees = mysql_query("SELECT * FROM degree");
													while ($degree = mysql_fetch_array($get_degrees)) {											
												  		if (!$new) { 	
																			if (strncmp($degree['id'], $bio['degree'], 3) )
																					echo '<option value="'.$degree["abbrev"].'">'.$degree["abbrev"].'</option>';
																			else
																					echo '<option value="'.$degree["abbrev"].' selected">'.$degree["abbrev"].'</option>';
															} else {
																			echo '<option value="'.$degree["abbrev"].'">'.$degree["abbrev"].'</option>';
															}
													}
													?>
											</select>
											in <input type="text" name="field" style="width: 130px;" <?php if (!$new) { if ($bio['field'] != -1) echo "value='".$bio['field']."'"; } ?> ></td>
						</tr>
		
						<!-- Get university attended -->					
						<tr><td class="text-right">Alma mata:</td>
							  <td><input type="text" name="university" <?php if (!$new) { if ($bio['university'] != -1) echo "value='".$bio['university']."'"; } ?> ></td></tr>
				
						<!-- Get Hometown -->
					  <tr><td class="text-right">Hometown: </td>
						    <td><input type="text" name="hometown" <?php if (!$new) { if ($bio['hometown'] != -1) echo "value='".$bio['hometown']."'"; } ?> ></td></tr> 
			
					  <tr><td class="text-right">Home Country*:</td>
						    <td> 	
									<select name="homecountry_id">
							        <?php
							        $get_nations = mysql_query("SELECT id, printable_name FROM country");
											while ($nation = mysql_fetch_array($get_nations)) {
												      if (!$new) {
															  			if ($nation['id'] != $bio['homecountry_id'])
																					echo "<option value='".$nation['id']."'>".$nation['printable_name']."</option>";
																			else
																					echo "<option value='".$nation['id']."' selected>".$nation['printable_name']."</option>";
															} else {
															  			if ($nation['id'] != 223)
																					echo "<option value='".$nation['id']."'>".$nation['printable_name']."</option>";
																			else
																					echo "<option value='".$nation['id']."' selected>".$nation['printable_name']."</option>";
															}
											}
							        ?>
									</select></td>
						</tr>
						<tr><td colspan=2 style="height: 20px;"><p style="font-size: 13px;">This meant to be where you were a child, not where you live now.</p></tr>
						
						<!-- Get Job -->
						<tr><td class="text-right">Job*:</span></td>
							  <td><input type="text" name="job" <?php if (!$new) { if ($bio['job'] != -1) echo "value='".$bio['job']."'"; } ?> ></td></tr>
						<tr><td colspan=2 style="height: 20px;"><p style="font-size: 13px;">We're highlighting the diversity of jobs people engaged in astronomy <br/>
								have (William Herchel, discoverer of Uranus, was a musician!).</p></tr>
				
						<!-- Get workplace -->
						<tr><td class="text-right">Workplace:</td>
							  <td><input type="text" name="workplace" <?php if (!$new) { if ($bio['workplace'] != -1) echo "value='".$bio['workplace']."'"; } ?> ></td></tr>
						
						<!-- Get minibio -->
			      <tr><td class="text-right">minibio:*</td>
							  <td><input type="text" name="minibio" <?php if (!$new) { if ($bio['minibio'] != -1) echo "value='".$bio['minibio']."'"; } ?> ></td></tr>		
						<tr><td colspan=2 style="height: 20px;"><p style="font-size: 13px;">This should be 120 characters that can be tweeted later.</p></tr>
						
						<!-- Get Twitter -->						
						<tr><td class="text-right">Twitter username: </td>
							  <td class="text-right">@ <input type="text" name="twitter" style="width: 210px;" <?php if (!$new) { if ($bio['twitter'] != -1) echo "value='".$bio['twitter']."'"; } ?> ></td></tr>
						<!-- Get Google+ -->		
					  <tr><td colspan=2 class="text-right"> https://plus.google.com/<input type="text" name="google" style="width: 150px;" <?php if (!$new) { if ($bio['google'] != -1) echo "value='".$bio['google']."'"; } ?> >/posts</td></tr>
							<tr><td colspan=2 style="height: 20px;"><p style="font-size: 13px;">Please provide your google plus ID (optional). We'll circle you!</p></tr>

						<!-- Get Facebook -->
						<tr><td colspan=2 class="text-right">https://www.facebook.com/<input type="text" name="facebook" style="width: 150px;" <?php if (!$new) { if ($bio['facebook'] != -1) echo "value='".$bio['facebook']."'"; } ?> ></td></tr>
									<tr><td colspan=2 style="height: 20px;"><p style="font-size: 13px;">You can use a page or profile. (optional).</p></tr>
										
						<!-- Get Website -->
						<tr><td class="text-right">Website: </td>
							  <td><input type="text" name="website" <?php if (!$new) { if ($bio['website'] != -1) echo "value='".$bio['website']."'"; } ?> ></td></tr>
		
			</table>

		</form>
		</div>	
		<?php
}

//---------- Submit a new user into database ------------------------------------------------------------------------------------
function submit_bio($url, $path, $new, $admin_request = 0) {	
	
		$flag = 1;
	
		// Setup which form values are (1) and aren't (0) mandatory
		// For New Profiles
		$arr = array(
				"username"  => 1,
		    "firstname" => 1,
		    "lastname"  => 0,
				"degree"    => 0,
				"field"			=> 0,
				"university"=> 0,
				"hometown"  => 0,
				"homecountry_id" => 1,
				"job"				=> 1,
				"workplace" => 0,
				"minibio"   => 1,
				"google"	  => 0,
				"twitter"   => 0,
				"facebook"  => 0,
				"website"   => 0,
		    "statement" => 1
		);

		// Create an array with all the posted values
		foreach ($arr as $key => $value) {
			  if (strcmp("",$_POST[$key])) {
					$inputs[$key] = htmlspecialchars(mysql_real_escape_string($_POST[$key]));
			  } else { // if a key is empty, check if it's required, and throw an error if it is
						if($value) { 
							 echo "You didn't provide the required information about your $key<br>";
							 $flag = 0;
						} else { // if it's not required, set it to -1
							 $inputs[$key] = -1; 
						}					
			  }		  
		}
	
		if (!$flag) {
				echo "(You may also be missing your profile pict, but we haven't checked)</br></br>";
				echo "<h2>Use the back button to add in the missing required data</h2>";
		} else {
			  echo "<p>";
				$get_homecountry = mysql_query("SELECT printable_name FROM country WHERE id = ".$inputs['homecountry_id']);
				$temp = mysql_fetch_array($get_homecountry);
				$inputs['homecountry'] = $temp['printable_name'];
		
				// Take care of the picture ----------------------------------------------------------------------------------------------------
				// Mandatory if this is a new file
			  if ($new) {
			
						// if there are errors, kick them out
					  if ($_FILES["file"]["error"] > 0) {
						  if ($_FILES["file"]["error"] == 4) echo "ERROR: Profile picture not attached. Go back.";
							else if ($_FILES["file"]["error"] == 1) echo "ERROR: The uploaded file is too large. Please find something 300x300 pixels in size.";
						  else echo "An error has occurred uploading the file";
						  die();
					
						// if there aren't errors kick them out
						} else {
							$target = "$path/uploads/";
							$goto   = $target . basename($inputs['username'].$_FILES["file"]["name"]);
							$inputs['picture'] = mysql_real_escape_string($url."/uploads/". basename($inputs['username'].$_FILES["file"]["name"]));
						}
					
				// Photo optional - warn them if something went amiss 
		  	} else {
						if ($_FILES["file"]["error"] > 0) {					
								if ($_FILES["file"]["error"] == 1) {
										echo "ERROR: The uploaded file is too large. Please find something 300x300 pixels in size.</br>";
								} else if ( $_FILES["file"]["error"] != 4 ) {
										echo "An error has occurred uploading the file. Your old profile image will keep being used. (error code ".$_FILES["file"]["error"].")<br/>";
								} 
						} else {
							$target = "$path/uploads/";
							$goto   = $target . basename($inputs['username'].$_FILES["file"]["name"]);
							$inputs['picture'] = mysql_real_escape_string($url."/uploads/". basename($inputs['username'].$_FILES["file"]["name"]));
						}
				}
		
		
				// Insert or Update the database as appropriate --------------------------------------------------------------------------------
				// If new, insert into database
				if ($new) {
						$query = "INSERT into bios (";
						$start = 1;
						foreach ($inputs as $key => $value) {
								if (!$start) $query .= ", $key";
								else         {$query .= "$key"; $start = 0;}
						}
						$query .= ") values (";
						$start = 1;
						foreach ($inputs as $key => $value) {
								if (!$start) $query .= ", '$value'";
								else         {$query .= "'$value'"; $start = 0;}
						}		
						$query .= ")";
						mysql_query($query); 
						if (mysql_error() == "") echo "Data inserted! ";
						else echo mysql_error();
					
				// If not new, update database		
				} else {
						$query = "UPDATE bios SET ";
						$start = 1;

						foreach ($inputs as $key => $value) {
								if (!$start) $query .= ", $key = '$value' ";
								else         { $query .= "$key = '$value'"; $start = 0; }
						}

						$query .= "WHERE username = '".$inputs['username']."'";

						mysql_query($query); echo mysql_error();
						if (mysql_error() == "") echo "Data inserted! ";
						else echo mysql_error();
				}
			
				// Move the file and set everything up. Let the user know if it worked ---------------------------------------------------------	
				if (move_uploaded_file($_FILES['file']['tmp_name'], $goto)) {
				    echo "The file ".  basename( $_FILES['file']['name'])." has been uploaded. ";
			  } else if ($_FILES["file"]["error"] == 4 && $new == 0) {
						echo "(<em>Since you didn't upload a new profile picture, the old one is still in use.</em>) ";
				} else {
						echo "There was a problem with setting up the profile picture.";
						die(); 
				}

				// Offer them a chance to see the profile the setup ----------------------------------------------------------------------------
			  $username = $inputs['username'];
			  echo "</p><H2>See <a href='$url/index.php?action=user&username=$username' style='color: white; border-bottom: 1px solid white;'>the profile here</a></H2><p>Please remember, all submitted and edited profiles must be reviewed before they go live.";
		
		
		}
}
?>