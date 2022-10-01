<?php
/*
Template Name: My File Upload          
script_name: my-file-upload.php          
parent_script_name: 
page_name: My File Upload
application_name: File Upload Utility
business_use: File Upload
author: Dave Van Abel
dev_site: gvaz.org
create_date: 2020-08-20
last_update_date: 2020-08-25
base_note: An App for file uploads
status: Initally complete pending some reviews, if needed. Good WpAppsForThat
license: GNU General Public License version 3 https://opensource.org/licenses/GPL-3.0
*/
/* 
 * ORIG SOURCE FILE: https://stackoverflow.com/questions/35542640/using-php-for-file-upload-in-wordpress
 * 08-27-20 Tested on WpAppsForThat.Com
 * 08-25-20 Moved two sets of info functions.php
*/

if ( ! defined( 'ABSPATH' ) ) {die( '-1' );}    // 1st line of php ensures script called from the website
get_header();   //Load the theme’s header
$user_id = get_current_user_id();
access_denied($user_id);	//Check if logged in user
$file = ""; // 09-30-22 undefined error
list($user_dirname, $file) = user_waiver_file($user_id);	// Get Waiver File Information

?> 
<head>
<link rel=”stylesheet” type=”text/css” href=”style.css”>
</head>
<h2>Upload File</h2> 
<table name="waiver" id="customers" >
	<form method="post" action="/index.php/my-file-upload-1/" enctype="multipart/form-data"> 
		<!-- multipart/form-data ensures that form data is going to be encoded as MIME data -->
		<div class="row">		          
			<tr> 
            	<td>
            		<b>On File</b>
            	</td>
            	<td>
                    <?php
                        if ($file) {                     
                            echo "<a href=\"/wp-content/uploads/$user_id/$file\">Your Covid-19 Wavier on file in the Wood Shop</a>";
                        } else {
                            echo "No file on record";
                        }
                    ?>
                </td> 			             
			</tr> 
			<tr> 
				<td colspan="2"><input type="file" name="photo" id="fileSelect"></td> 			     
			</tr>	
			<tr> 
            	<td>
            	<b>Submit</b>
            	</td>
            	<td>
		            <input type="hidden" name="user_dirname" value="<?php echo $user_dirname ?>">
                    <input type="hidden" name="current_file" value="<?php echo $file ?>">		            <input type="hidden" name="current_file" value="<?php echo $file ?>">       
                    <input type="submit" id="submit" name="action" value="submit">
            	</td> 			     
            </tr>	
		</div>
	</form>
</table> 
