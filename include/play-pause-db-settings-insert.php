<?php 
	if ( ! defined('ABSPATH') ) {
		die();
	}
	
	class ss_play_pause_Class
	{
		private $ss_table_Fields=array("id", "ss_play_button_status", "ss_float_status", "iframe_status");
		//private $ss_play_button_Fields=array("id", "ss_play_button_status", "ss_float_status");	
		function add_ss_status($tblname,$htinfo){			
			$id=0;
			$ss_Fields="";
			$vals="";

			foreach($this->ss_table_Fields as $key)
			{
				if($field=="")
				{
					$field="`".$key."`";
					$vals="'".$htinfo[$key]."'"; /*First value come with if fiels and other will come else by , like values('id, ss_play_button_status, ss_float_status)*/
				}
				else
				{
					$field=$field.",`".$key."`";
					$vals=$vals.",'".$htinfo[$key]."'";
				}
			}
			global $wpdb;
			$table_name = $wpdb->prefix . "Play_pause_video";

			$sSQL = "INSERT INTO ".$table_name." ($field) values (".sanitize_text_field($vals).")"; // Input values sanitized
			$res = $wpdb->query($sSQL);
			if($res > 0){
				echo "</br><div class='updated' id='success message'><p><strong>Settings Saved</strong>.</p></div>";
			}
		}
	}
	$objHT = new ss_play_pause_Class();
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verify_request']) && $_POST['verify_request'] == 'post_request'){
		$objHT->add_ss_status($table_name = $wpdb->prefix . "Play_pause_video",$_POST); // Save setting, add_rdct = 1
	}
	
global $wpdb;
$table_name = $wpdb->prefix . "Play_pause_video";
$button_status = $wpdb->get_var("SELECT ss_play_button_status FROM $table_name group by id DESC");
$float_html_status = $wpdb->get_var("SELECT ss_float_status FROM $table_name group by id DESC");
$float_iframe_status = $wpdb->get_var("SELECT iframe_status FROM $table_name group by id DESC");


/*var_dump($last_link);*/

?>
	<div class="icon32" id="icon-edit"><br/></div>
	<!-- <h2>Redirection</h2> -->
<div id="col-left" class="ht-tp-div">
	</br></br>
	<div class="col-wrap postbox widgetopts-sidebar-widget" style="border-color: #bbf310; border-width: 2px;">
		<!-- <h2>Setting</h2> -->
		<div>
			<div class="form-wrap inside">
				<h3>Setting</h3>
				<form class="validate" action="admin.php?page=floating_video_settings" method="post" id="ss_ht_form">
					<ul>
					<li class="form-field">
						<label class="" for="tag-slug">Play Pause Button for HTML Video tag</label>
						<select class="postform" name="ss_play_button_status">
							<option value="1" <?php if($button_status == 1) {echo 'selected';}?>>Enable</option>
							<option value="0" <?php if($button_status == 0) {echo 'selected';}?>>Disable</option>
						</select>
					</li>
					<li class="form-field">
						<label class="ht-lbl" for="tag-status">Floating HTML Video tag</label>
						<select class="postform" name="ss_float_status">
							<option value="1" <?php if($float_html_status == 1) {echo 'selected';}?>>Enable</option>
							<option value="0" <?php if($float_html_status == 0) {echo 'selected';}?>>Disable</option>
						</select>
					</li>
					<li class="form-field">
						<label class="ht-lbl" for="iframe-status">Floating Iframe (Youtube & Vimeo only) </label>
						<select class="postform" name="iframe_status">
							<option value="1" <?php if($float_iframe_status == 1) {echo 'selected';}?>>Enable</option>
							<option value="0" <?php if($float_iframe_status == 0) {echo 'selected';}?>>Disable</option>
						</select>
					</li>
					
					</ul>
					<p class="submit">
						<input type="hidden" name="verify_request" value="post_request" />
						<input type="submit" value="Save" class="button act_updt" id="submit" name="submit" title="Click Here"/>						
					</p>
				</form>
			</div>
		</div>
	</div>
</div>