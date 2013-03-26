<?php
/**
 * @Download Manager
 * @version 1.0
 */
/*
Plugin Name: Download Manager
Plugin URI: http://www.3jon.com
Description: This is just a simple Download Manager plugin.
Author: Shamsul Islam Nirob
Version: 1.0
Author URI: http://www.3jon.com
*/



if ( is_admin() ){
	global $wpdb;
	mysql_select_db($database_name);
}

function dm3jon_list($atts,$content	=	null){
			extract( shortcode_atts( array('album_name' => '', ), $atts ) );
			$con = '';
			foreach((array)$album_name as $valbum){
			global $dm3jon_album;
			$dm3jon_album = $valbum;

			$dm3jon_query_show_album = mysql_query( "SELECT * from downloadmanager WHERE album_name='$dm3jon_album'" );
			
			while($dm3jon_query_list = mysql_fetch_array($dm3jon_query_show_album)) {
			
				$dm3jon_show_v1 = $dm3jon_query_list['album_name'];
				$dm3jon_show_v2 = $dm3jon_query_list['song_name'];
				$dm3jon_show_v3 = $dm3jon_query_list['singer_name'];
				$dm3jon_show_v4 = $dm3jon_query_list['category_name'];
				$dm3jon_show_v5 = $dm3jon_query_list['download_link'];
				
?>
				<ul class="fontul">
					<li style="float:left;"><?php echo $dm3jon_show_v1; ?></li> 
					<li style="margin-left:20px; float:left;"><? echo $dm3jon_show_v2; ?></li>
					<li style="margin-left:20px; float:left;"><? echo $dm3jon_show_v3; ?></li>
					<li style="margin-left:20px; float:left;"><? echo $dm3jon_show_v4; ?></li>
					</br>
					<li style="font-family: Arial; font-size: 12px; background: #b6502a; border: 1px solid #b6502a; margin-bottom: 90px; padding: 6px 15px 6px 15px; width: 70px; cursor: pointer; outline: 0; margin-top: 7px; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px;"><a style="color: #fff!important;text-shadow: 1px 1px 1px #222222;" href="<? echo $dm3jon_show_v5; ?>">Download</a></li></br></ul><style>.fontul{background-color:inherit;} .fontul li{list-style:none;}</style>
					
					<? }
	}
			return do_shortcode($con);
}


function dm3jon_admin_options_page(){
		if ( is_admin() ){
			global $wpdb;
			}
			
	if( $_POST['a_name'] == null OR $_POST['s_name'] == null OR $_POST['si_name'] == null OR $_POST['c_name'] == null OR $_POST['d_link'] == null )
		{ ?> </br> <?php echo 'Please fill all fields.'; }
		else
			{ 
				$aname1		=	$_POST['a_name'];
				$sname1		=	$_POST['s_name'];
				$siname1	=	$_POST['si_name'];
				$cname1		=	$_POST['c_name'];
				$dlink1		=	$_POST['d_link'];
		
				$aname	=	sanitize_text_field( $aname1 );
				$sname	=	sanitize_text_field( $sname1 );
				$siname	=	sanitize_text_field( $siname1 );
				$cname	=	sanitize_text_field( $cname1 );
				$dlink	=	sanitize_text_field( $dlink1 );

		
	if ( is_admin() ){
			$dm3jon_query_verify_1 = "SELECT * FROM downloadmanager WHERE category_name = '$cname'";
			$dm3jon_query_verify_2 = "SELECT * FROM downloadmanager WHERE song_name = '$sname'";
			$dm3jon_result_verify_1 = $wpdb->query($dm3jon_query_verify_1);
			$dm3jon_result_verify_2 = $wpdb->query($dm3jon_query_verify_2);
		if ($dm3jon_result_verify_1 == 0 && $dm3jon_result_verify_2 == 0) 
			{
				$dm3jon_query_insert = "INSERT INTO downloadmanager (dm_id, album_name, song_name, singer_name, category_name, download_link) VALUES ('', '$aname', '$sname', '$siname', '$cname', '$dlink')";

				$wpdb->query($dm3jon_query_insert);
				?>
				
				<span style="color:red; margin-top:20px;"></br><?php echo 'Successfully save'; ?></span><?php 
			}
		else
?>				<span style="color:red;"></br><?php echo 'Data already exist'; ?></span>
<?php 
		}
	}
?>

	<form  method="POST">
		<table>
			<tr><td>Album Name :</td><td><input type="text" name="a_name" id="dmanage" style="width:302px; margin-bottom:4px; height:28px;" /></td></tr>
			<tr><td>Title :</td><td><input type="text" name="s_name" id="dmanage" style="width:302px; height:28px; margin-bottom:4px;" /></td></tr>
			<tr><td>Author Name :</td><td><input type="text" name="si_name" id="dmanage" style="width:302px; height:28px; margin-bottom:4px;" /></td></tr>
			<tr><td>Category Name :</td><td><input type="text" name="c_name" id="dmanage" style="width:302px; height:28px; margin-bottom:4px;" /></td></tr>
			<tr><td>Download Link :</td><td><input type="text" name="d_link" id="dmanage" style="width:302px; height:28px; margin-bottom:4px;" /></td></tr>
			<tr><td><button onclick="dm3jon_admin_options_page()" style="width:80px; height:35px; margin-right:5px; background-color:#F0F0F0; margin-left:85px; margin-top:5px; float:left;">SAVE</button></td><td></td></tr>
		</table>

			<span style="color:red;">*</span>Please use the following fields to input your data that you want to show or you want to save in database.</br>to use this in fornt-end use shortcode like this format  <span style="color:red;">[Download_Manager, album_name="album name"] </br>where album name = your album name which you want to show in fornt-end.</span>
	</form>
	
</br></br>

		<table>
			<tr><td><span style="color:green;">Category already inputed:</span>
				<ul class="bottomtableul"><?
					$dm3jon_query_show_category = mysql_query("SELECT category_name from downloadmanager");
					while($dm3jon_query_save_category = mysql_fetch_array($dm3jon_query_show_category)) {
					$dm3jon_category = $dm3jon_query_save_category['category_name'];
					?><li><?php echo $dm3jon_category;?></li>
				<?php
				}
				?>
				</ul>
				
<style>bottomtableul{height:300px; width:960px;}.bottomtableul li{}</style>

				</td>
			</tr>
		</table>
<?php 
}

function dm3jon_admin_menu() {
		add_options_page('Plugin Admin Options', 'Download Manager', 'manage_options','download_manager', 'dm3jon_admin_options_page');
		}
		
		add_action('admin_menu', 'dm3jon_admin_menu');
		add_shortcode("Download_Manager","dm3jon_list");

function dm3jon_database_install(){
	if ( is_admin() ){
		global $wpdb; //call $wpdb to the give us the access to the DB
		$sql = "CREATE TABLE IF NOT EXISTS `downloadmanager` (
				`dm_id` int(100) NOT NULL AUTO_INCREMENT,
				`album_name` varchar(256) NOT NULL,
				`song_name` varchar(256) NOT NULL,
				`singer_name` varchar(256) NOT NULL,
				`category_name` varchar(256) NOT NULL,
				`download_link` varchar(256) NOT NULL,
				PRIMARY KEY (`dm_id`)
				)";
  
		$wpdb->query($sql); //the query function lets us execute most MySQL querys
		}
	}
	
function dm3jon_on_deactivate() {
	if ( is_admin() ){
		global $wpdb; //call $wpdb to the give us the access to the DB
		$sql = "DROP TABLE `downloadmanager`";
		$wpdb->query($sql);
		}
}

register_activation_hook(__FILE__,'dm3jon_database_install');
register_deactivation_hook(__FILE__, 'dm3jon_on_deactivate');

?>