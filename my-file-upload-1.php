<?php
/*
Template Name: My File Upload 1
script_name: my-file-upload-1.php          
parent_script_name: my-file-upload.php
page_name: My File Upload 1
application_name: File Upload Utility
business_use: File Upload
author: Dave Van Abel
dev_site: gvaz.org
create_date: 2020-08-21
last_update_date: 202-08-27
base_note: An App for file uploads
status: Initally complete pending some reviews if needed. Good WpAppsForThat
license: GNU General Public License version 3
*/
if ( ! defined( 'ABSPATH' ) ) {die( '-1' );}    // 1st line of php ensures script called from the website
get_header();   //Load the theme’s header
global $current_file;
global $user_dirname;
global $err_msg;
$current_file = NULL;

/* Standard POST */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "submit") {
		// defined fields
		$fields = array(
		'user_dirname',
        'current_file'
	);
	foreach ($fields as $field) {
		//echo "Field = $field, value = $_POST[$field]<br>";
		if (isset($_POST[$field])) $posted[$field] = stripslashes(trim($_POST[$field])); else $posted[$field] = '';
	}
	if ($posted['current_file'] != null ) 		{$current_file 		=  $_POST['current_file'];}
	if ($posted['user_dirname'] != null ) 		{$user_dirname 		=  $_POST['user_dirname'];}
    
    /* $_FILES Data */

    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) { 
        $file_name     = $_FILES["photo"]["name"]; 
        $file_type     = $_FILES["photo"]["type"]; 
        $file_size     = $_FILES["photo"]["size"]; 
        $file_tmp_name = $_FILES["photo"]["tmp_name"]; 
        $file_error    = $_FILES["photo"]["error"]; 
        
		/* File Size Testing */
        
		if ($file_size == 0) {
             $file_error = 1;
             $err_msg = "File size empty"; 
        } elseif ($file_size > 400000) {        
             $file_error = 1;
             $err_msg = "File size greater than 400000 bytes"; 
        }
        
        /* Wrong type of file */

		if ($file_error != 1) {
			if (strpos($file_type, 'pdf') !== false) {
				goto FT_DONE;
			}
			if (strpos($file_type, 'png') !== false) {
				goto FT_DONE;
			} 
			if (strpos($file_type, 'jpg') !== false) {
				goto FT_DONE;
			} 
			if (strpos($file_type, 'jpeg') !== false) {
				goto FT_DONE;
			} 		
			else {
				$file_error = 1;
			}
			FT_DONE:
			if ($file_error == 1) {
				 $err_msg = "Invalid file type. Can only be: pdf, png, jpg or jpeg"; 
			}
		}			
                
		/* PROCESS VALID RECORD */
		
		if ($file_error != 1) {
			
			/* UNLINK FILE */
			
			if (!empty($current_file)) {
				$path = "$user_dirname/$current_file";
				if (unlink($path)) {
					//echo "Existing filename: $current_file deleted!<br>";
				}
				else {
					//echo "File not deleted, it could be over-written or a 2nd file now.<br>";
				}
			}
		
			/* Create a user’s directory */
			
			if (!empty($file_size)) {
				$user_id = get_current_user_id();
				$upload_dir   = wp_upload_dir();
				
				if ( isset( $current_user->user_login ) && ! empty( $upload_dir['basedir'] ) ) {
					$user_dirname = $upload_dir['basedir'].'/'.$user_id;
					if ( ! file_exists( $user_dirname ) ) {
						wp_mkdir_p( $user_dirname );
					}
				}
				
				/* Upload & Save - Just overwrite existing */       
				
				$target_file = $user_dirname . '/' . ($_FILES["photo"]["name"]);
				move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
		
				/* Add wp_usermeta for upload */
					
				$metas = array( 
					'covid_waiver' => '1'
				);			
				foreach($metas as $key => $value) {
					update_user_meta( $user_id, $key, $value );
				}
					
			}
		}		// end of valid delete and save
    } else {
        $file_error = 1;
        $err_msg = "No upload file selected";
    }
}

?>
<head>
<link rel=”stylesheet” type=”text/css” href=”style.css”>
</head>
<h3>Member File Upload</h3>
<table name="waiver" id="customers" >
	<div class="row">		
		<tr> 
            <td>
            	<?php 
            		if ($file_error != 1) {
            			echo "Complete ";
            		}
            		else {
             			echo "<font color='red'> Failed</font>";
            		}
            	?>
            </td>
            <td>
            	<?php 
            		if ($file_error != 1) {
            			echo "Complete ";
            			echo $_FILES["photo"]["name"]; 
            		}
            		else {
             			echo "<font color='red'>$err_msg. Try again.</font>";
            		}
            	?>
            </td> 			     
		</tr>	
    </div>
</table> 
<h4><a href="/index.php/my-file-upload/">Return to My File Upload</a></h4>
