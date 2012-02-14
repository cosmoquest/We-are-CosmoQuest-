<?php
?>
<h2>No frills installer</h2>


<p> Check if uploads directory has the correct permissions...
<?php

if (is_writable($doc_root."/uploads/")) {
    echo "DONE.</p>";
} else {
    echo "</p>
          <p style='text-align: right'>ERROR: Please make the directory \"$doc_root/uploads/\" writable for the webserver.</p>";
		//die();
}
?>

<p> Create database table...
<?php

include("./weare.sql.php");

if ($check == "") {
	echo "DONE.</p>";
	echo "<H2>The site is now setup. Reload this page to being using it.</h2>";
	echo "<p><em>P.S. It's recommended you delete or rename install.php from your server</em></p>";
  include($skin_root."CQ-footer.php");
} else {
	echo "</p>
        <p style='text-align: right'>ERROR: $check</p>";
			die();
}

?>