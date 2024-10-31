<?php
/**
 * @package MyPress
 * @author Christian Serron
 * @version 1.0
 */
/*
Plugin Name: MyPress
Plugin URI: http://wordpress.org/#
Description: Customize your WordPress administration area with your logos and your color scheme. You can also set alignment preferences and sidebar position.
Author: Christian Serron
Version: 1.0
Author URI: http://twitter.com/cserron
*/
//------ Plugin's constants ------------
define(MYPRESS_PREFIX, 'mypress_');		//prefix to insert values inside database
define(MYPRESS_URL,plugins_url().'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) ); 	//The plugin's path
define(DONATION_BUTTON, true);	// I'm doing this for love buddy!, you have the power to set or not as FALSE this constant ;-)


//------ INIT ----------------------
add_action('init','mypress_init');
function mypress_init(){ 
	wp_enqueue_script('farbtastic');	
	wp_enqueue_style('farbtastic');
	
	wp_enqueue_script('thickbox'); 
	wp_enqueue_style('thickbox');
	
	wp_enqueue_style('mypress-style',MYPRESS_URL."/style.css");
	
	add_action('admin_head', 'mypress_adminStyle');
}

//--------- Include style to your backend ---------------
function mypress_adminStyle()
{
	echo '<STYLE>';
	require_once("css.inc.php");
	echo '</STYLE>';
}

//--------- Custom login form ---------------------------
function mypress_loginForm()
{
	echo '<link rel="stylesheet" href="'.MYPRESS_URL.'style.css" type="text/css" media="screen" />';
}

add_action('login_head', 'mypress_adminStyle');


//---- Save settings inside DB -----
if ( !empty($_POST[ "color1" ]) && !empty($_POST["submit"]) ) 
	{update_option( MYPRESS_PREFIX . "color1", $_POST[ "color1" ] );}

if ( !empty($_POST[ "color2" ]) && !empty($_POST["submit"]) ) 
	{update_option( MYPRESS_PREFIX . "color2", $_POST[ "color2" ] );}

if ( !empty($_POST[ "color3" ]) && !empty($_POST["submit"]) ) 
	{update_option( MYPRESS_PREFIX . "color3", $_POST[ "color3" ] );}

if ( !empty($_POST[ "color4" ]) && !empty($_POST["submit"]) ) 
	{update_option( MYPRESS_PREFIX . "color4", $_POST[ "color4" ] );}

if ( !empty($_POST[ "color5" ]) && !empty($_POST["submit"]) ) 
	{update_option( MYPRESS_PREFIX . "color5", $_POST[ "color5" ] );}

if ( !empty($_POST[ "color6" ]) && !empty($_POST["submit"]) ) 
	{update_option( MYPRESS_PREFIX . "color6", $_POST[ "color6" ] );}
	
if ( !empty($_POST[ "color7" ]) && !empty($_POST["submit"]) ) 
	{update_option( MYPRESS_PREFIX . "color7", $_POST[ "color7" ] );}
	
if ( !empty($_POST[ "color8" ]) && !empty($_POST["submit"]) ) 
	{update_option( MYPRESS_PREFIX . "color8", $_POST[ "color8" ] );}
	
if ( !empty($_POST[ "logo-url" ]) && !empty($_POST["submit"]) ) 
	{update_option( MYPRESS_PREFIX . "logo-url", $_POST[ "logo-url" ] );}	

if ( !empty($_POST[ "login-url" ]) && !empty($_POST["submit"]) ) 
	{update_option( MYPRESS_PREFIX . "login-url", $_POST[ "login-url" ] );}	

if ( !empty($_POST[ "sidebar-position" ]) && !empty($_POST["submit"]) ) 
	{update_option( MYPRESS_PREFIX . "sidebar-position", $_POST[ "sidebar-position" ] );}	

if ( !empty($_POST[ "right-to-left" ]) && !empty($_POST["submit"]) ) 
	{update_option( MYPRESS_PREFIX . "right-to-left", $_POST[ "right-to-left" ] );}	
else
	{update_option( MYPRESS_PREFIX . "right-to-left", 0 );}
	
//----------------- Back-End Interface ----------------------------------------

//Add menu to admin
if (is_admin()){
	add_action('admin_menu', 'mypress_adminMenu');
}

function mypress_adminMenu(){
	add_options_page('MyPress Settings','MyPress','manage_options', 'my-unique-identifier', 'mypress_settingsPage');
}



function mypress_settingsPage()
{
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
			
?>

<script type="text/javascript">
 jQuery(document).ready(function() {
	 
    var f = jQuery.farbtastic('#picker');
    var p = jQuery('#picker').css('opacity', 0.25);
    var selected;
    jQuery('.colorwell')
      .each(function () { f.linkTo(this); jQuery(this).css('opacity', 0.75); })
      .focus(function() {
        if (selected) {
          jQuery(selected).css('opacity', 0.75).removeClass('colorwell-selected');
        }
        f.linkTo(this);
        p.css('opacity', 1);
        jQuery(selected = this).css('opacity', 1).addClass('colorwell-selected');
      });
	  
	 //uploader
	 jQuery('#upload_image_button').click(function() {
		 formfield = jQuery('#upload_image').attr('name');
		 tb_show('','media-upload.php?type=image&TB_iframe=true');
		
		 return false;
		});
		
	// send url back to plugin editor

	window.send_to_editor = function(html) {
	 imgurl = jQuery('img',html).attr('src');
	 tb_remove();
	 alert("Image URL: "+imgurl);
	}
	
	

 });
</script>

<div class="wrap">
	<div id="dialog" style="display: none;" ><p>ddddd</p></div>
	  
	<code>No matter how customize our admin panel is, it wouldn't be possible without WordPress. You should keep the footer information to increase awareness about WordPress.</code>
	<form action="" method="post">
		
		<!-- Color scheme -->
		<div id="color-section">
			<div class="icon32" id="colors"><br></div><h2>Color Scheme</h2>
			<div id="picker" style="float: right;"></div>
			<div class="palette"><label for="color3">Admin Background:</label><input type="text" id="color7" name="color7" class="colorwell" value="<?php echo get_option(MYPRESS_PREFIX . "color7","#f9f9f9");?>" /></div>
			<div class="palette"><label for="color3">Header and Footer Background:</label><input type="text" id="color5" name="color5" class="colorwell" value="<?php echo get_option(MYPRESS_PREFIX . "color5","#464646");?>" /></div>
			<div class="palette"><label for="color1">Header and Footer Texts:</label><input type="text" id="color1" name="color1" class="colorwell" value="<?php echo get_option(MYPRESS_PREFIX . "color1","#ffffff");?>" /></div>
			<div class="palette"><label for="color3">Links:</label><input type="text" id="color4" name="color4" class="colorwell" value="<?php echo get_option(MYPRESS_PREFIX . "color4","#21759B");?>" /></div>
			<div class="palette"><label for="color3">Login Background:</label><input type="text" id="color8" name="color8" class="colorwell" value="<?php echo get_option(MYPRESS_PREFIX . "color8","#f9f9f9");?>" /></div>
			<div class="palette"><label for="color3">Navigation & Contextual areas:</label><input type="text" id="color3" name="color3" class="colorwell" value="<?php echo get_option(MYPRESS_PREFIX . "color3","#f9f9f9");?>" /></div>
			<div class="palette"><label for="color2">Sidebar top-menus:</label><input type="text" id="color2" name="color2" class="colorwell" value="<?php echo get_option(MYPRESS_PREFIX . "color2","#f1f1f1");?>" /></div>
			<div class="palette"><label for="color3">Widget selector titles:</label><input type="text" id="color6" name="color6" class="colorwell" value="<?php echo get_option(MYPRESS_PREFIX . "color6","#e3e3e3");?>" /></div>					
		</div>
		
		<!-- Login form -->
		<br />
		
		<!-- Images -->
		<div id="images-section">	
			<div class="icon32" id="images"><br></div><h2>Images</h2>
			<small><a href="" id="upload_image_button" class="thickbox hide-if-no-js">(Upload your image or get one from the library)</a></small>
			<div class="img-url"><label for="color3">Backend logo URL:</label><input id="upload_image" type="text" size="45" name="logo-url" value="<?php echo get_option(MYPRESS_PREFIX . "logo-url");?>" />
			
			<div><small>* Remember it should be 32x32</small></div>
			
			<div class="img-url"><label for="color3">Login logo URL:</label><input id="upload_login_image" type="text" size="45" name="login-url" value="<?php echo get_option(MYPRESS_PREFIX . "login-url");?>" />

		</div>
		
		<div id="alignment-section">	
			<div class="icon32" id="alignment"><br></div><h2>Alignment</h2>
			
			<div class="img-url"><label for="color3">Sidebar Position:</label>
				<select name="sidebar-position" >
					<option value="left" <?php if(get_option(MYPRESS_PREFIX . "sidebar-position")=="left") echo "selected";?>>Left</option>
					<option value="right" <?php if(get_option(MYPRESS_PREFIX . "sidebar-position")=="right") echo "selected";?>>Right</option>
				</select>
			</div>
			<div class="img-url"><label for="color3">'Right-to-left' Mode:</label><input type="checkbox" name="right-to-left" value="1" <?php if(get_option(MYPRESS_PREFIX . "right-to-left")=="1") echo "checked";?>/><small>(For languages like Hebrew)</small></div>
		</div>
	  <br /><br />
	  
	  
	  <input type="submit" name="submit" value="Save Changes"/>
	
	
	</form>

	<hr/>
	
	<?php if(DONATION_BUTTON){ ?>
	<div id="donation">
		<b style="float:left;">If you enjoyed this plugin, I would appreciate a cup of coffee :-)</b>
		
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_donations">
		<input type="hidden" name="business" value="christianserron@gmail.com">
		<input type="hidden" name="lc" value="UY">
		<input type="hidden" name="item_name" value="Christian Serron">
		<input type="hidden" name="item_number" value="Mypress Donation">
		<input type="hidden" name="no_note" value="0">
		<input type="hidden" name="currency_code" value="USD">
		<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_SM.gif:NonHostedGuest">
		<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypal.com/es_XC/i/scr/pixel.gif" width="1" height="1">
		</form>
		
	</div>
	<?php }?>
</div>
			
<?php } ?>