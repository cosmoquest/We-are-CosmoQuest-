<!DOCTYPE html>
<html lang="en">
<head>
	<title>We are CosmoQuest</title>
	<meta name="author" content="Pamela L Gay">
	<link rel="stylesheet" type="text/css" href="style-Red.css" />
	<link rel="stylesheet" type="text/css" href="style.css" />
	<link rel="stylesheet" type="text/css" href="http://cosmoquest.org/csb/public/css/aux.css" />
	<script src="http://cosmoquest.org/csb/public/javascript/jquery-1.6.4.min.js"></script>
	<script src="http://cosmoquest.org/csb/public/javascript/navigation.js"></script>
</head>

<body>
	
<?php
// Get the config values & check login. Specfic to VB --------------------------------------------------------------------------
  include_once("./admin/config.php");
	include($skin_root."CQ-topbar-with-login.php");
	
/**************************************************************************************************************
* The file content below is used to check logins if you are using VBulletin
**************************************************************************************************************/

		// Only run this using VBulletin --------------------------------------------------------------------------
		if ($admin != -1) {
			   // Read in Configuration file and check login --------------------------------------------------------
				 $currentDirectory = getcwd();
				 chdir($vb_root);
				 require_once('global.php');
				 chdir ($currentDirectory);    

				 // Grab the vbulletin object made when we included forum/global.php
				 global $vbulletin;

				 // Check if user is logged in (if userid is 0, the user isn't logged in)
		 	   if ($vbulletin->userinfo['userid']!=0) { 
				      $logged_in = 1; 

						  // Check if Admin
						  $str =  $vbulletin->userinfo['membergroupids'];
						  $array = explode_trim($str); 
				 		  if (in_array($vb_hangout_grp, $array)) {
							     $admin = 1;
						  } else { 
                   $admin = 0;
						  }
				 } else {
							$admin = 0;
				 }
		}

// Check if the database in configured ------------------------------------------------------------------------------------------
	// connect to mysql
	$db = mysql_connect($db_host, $db_user, $db_password);
	if (!$db) {
	        die('Could not connect to mysql. Please make sure it exists & username/password are correct.' . mysql_error());
	}

	// check that database exists
	mysql_select_db($db_name, $db) or die("Database does note exist");

	// check that table exists
	if(!(mysql_query("SELECT * FROM bios")))
	{
	    echo "Must run installer"; 
			if($admin) {
	    		@include("install.php");
	    		die();
			}
	}
	
// Everything is setup, so load the page and begin ------------------------------------------------------------------------------
	?>	
	
	<div id="header"><div id="header-content" class="wrapper">
		<a href="<?php echo $url_wer; ?>"><img src="./images/header.png"></a>
		<div id="site-status">
        	<div id="tweet">
               		<p class='label'>Follow us<br>on Twitter</p>
              		<p><div id="twitter_update_list">
              			 </div></p>
              		<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"> </script>
              		<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/cosmoquestX.json?callback=twitterCallback2&count=1"> </script>
      		</div>
    </div>
		
	</div></div>
	
	<div id="bar"><div id="menus" class="wrapper">
		<?php
		// if they are an admin, post the admin link -------------------------------------------------------------------------------------------------------------------
		if ($admin) {
			?> 
			<form name="admin" action="index.php" method="GET" style="float: right;">
				<input type="hidden" name="action" value="admin">
				<a href="javascript: void(0);" onclick="document.admin.submit();" style="color: white;">administer site</a>
			</form>
			<?php
		}	?>
		
	</div></div>
	
	<?php
	
// Check if they are doing something, and if not, show homepage -----------------------------------------------------------------
	if (!isset($_GET['action']) && !isset($_POST['action'])) {
		include("./home.php");
	
	
// If they are doing something, find out what -----------------------------------------------------------------------------------
	} else {
		
        if (isset($_GET['action'])) $action = htmlspecialchars(mysql_real_escape_string($_GET['action']));
				else                        $action = htmlspecialchars(mysql_real_escape_string($_POST['action']));
        
        //check for admin functions first
				$did_something = 0;
        if ($admin) {
            switch ($action) {
				case "admin":
					include("./admin/admin.php");
					$did_something = 1;
					break;
				case "installer":
					include("./install.php");
					$did_something = 1;
					break;
            }
        }
				// If they didn't do something as an admin, continue
				
        if (!$did_something) {
				switch ($action) {
					case "admin":
						include("./admin/admin.php");
						break;
					case "user":
						include("./user.php");
						break;
					case "list_all":
						include("./list_all.php");
						break;
					case "create_my_profile":
						?> <div id="main-blk"><div id="main-content-blk" class="wrapper"> <?php
						if ($logged_in){
								include("./forms.php");
								form_bio(1);
						} else echo "You must be <a href='$login_url' style='color:#fff; text-decoration: underline;' target='_BLANK'>logged in</a> to create a profile. (Just reload this page once you're logged in.)";
						?></div></div><?php
						break;
					case "submit_create_my_profile":
					  ?> <div id="main-blk"><div id="main-content-blk" class="wrapper"> <?php
						if ($logged_in){
								include("./forms.php");
								submit_bio($url_wer, $doc_root, 1);
						} else echo "You must be <a href='$login_url' style='color:#fff; text-decoration: underline;' target='_BLANK'>logged in</a> to create a profile. (<em>If you got here because your login timed out while you were writing you're profile, here is how you don't lose your work: 1) right click on the login link and open it in a new tab or window. 2) Login 3) Refresh this page and agree to resubmit the form</em>).";
						?></div></div><?php
						break;
					break;
					case "submit_edit_my_profile":
						?> <div id="main-blk"><div id="main-content-blk" class="wrapper"> <?php
						if ($logged_in){
								include("./forms.php");
								submit_bio($url_wer, $doc_root, 0);
						} else echo "You must be <a href='$login_url' style='color:#fff; text-decoration: underline;'  target='_BLANK'>logged in</a> to create a profile. (<em>If you got here because your login timed out while you were writing you're profile, here is how you don't lose your work: 1) right click on the login link and open it in a new tab or window. 2) Login 3) Refresh this page and agree to resubmit the form</em>).";
						?></div></div><?php
						break;
				default:
						echo "<h2>Error</H2><p>Action \"$action\" not found.</p>";
				}
		}
        
	}
?>	

<?php
  @mysql_close($db);
	include($skin_root."CQ-footer.php");
?>

</body>
</html>
	
<?php	
	function explode_trim($str, $delimiter = ',') { 
	    if ( is_string($delimiter) ) { 
	        $str = trim(preg_replace('|\\s*(?:' . preg_quote($delimiter) . ')\\s*|', $delimiter, $str)); 
	        return explode($delimiter, $str); 
	    } 
	    return $str; 
	}
?>	

