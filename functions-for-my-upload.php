/* 08-25-20 add access_denied($user_id) */

function access_denied($user_id) {
	if (empty($user_id)) {	
		echo "<head>";
		echo "<link rel='stylesheet' type='text/css' href='style.css'>";
		echo "</head>";
		echo "<h2>Security Validation</h2>";
		echo "<table name='denied' id='customers >";
			echo "<div class='row'>";		
				echo "<tr>"; 
					echo "<td>";
					 echo "<font color='red'><b>Access denied</b></font>";
					echo "</td>";
				echo "</tr>";	
			echo "</div>";
		echo "</table>";
		die;
	
	} else {	
		return;
	}
}

/* 08-25-20 get user's Covid-Waiver Information */

function user_waiver_file($user_id) {
	$upload_dir = wp_upload_dir();
	if ( isset( $user_id ) && (!empty( $upload_dir['basedir']))) {
		$user_dirname = $upload_dir['basedir'].'/'.$user_id;
	}	
	/* Get User's Dir in uploads & find existing file if there */	
	if (is_dir($user_dirname)) {     
		if ($dh = opendir($user_dirname)) {
			while (($file = readdir($dh)) !== false) {
				if ($file != "." && $file != "..") {
					break;
				}             
			} 
			closedir($dh);	// can close here
		}
		return array ($user_dirname, $file ) ;
	} else {
		return array ("", "" ) ;
	}
}
/* **************************************** */
