<?php
/*
Plugin Name: Wp Wiki Userprofile
Plugin URI: http://wordpress.org/extend/plugins/wp-wiki-userprofile/
Description: This plugin is used to grab Wikipedia user contribution to wordpress blog.
Version: 1.2
Author: Gowri Sankar Ramasamy.
Author URI: http://code-cocktail.in/author/gowrisankar/
Donate link: http://code-cocktail.in/donate-me/
License: GPL2
Text Domain: wp-wiki-userprofile
*/

/*  
	Copyright 2014  Gowri Sankar Ramasamy  (email : gchokeen@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// loads language files

function wikiprofile_init() {
	
load_plugin_textdomain('wp-wiki-userprofile', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action('plugins_loaded', 'wikiprofile_init');

// admin menu section

add_action( 'admin_menu', 'wikiprofile_menu' );

function wikiprofile_menu() {
 $hook_suffix = add_options_page(__('Wiki Userprofile','wp-wiki-userprofile'),__('Wiki Userprofile','wp-wiki-userprofile'), 'manage_options', 'wiki-profile', 'wiki_profile_options' );

add_action( 'load-' . $hook_suffix , 'wiki_profile_load_function' );

}


// admin wiki userprofile settings page

function wiki_profile_options() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
	
	if(isset($_POST['wiki-profile-submit'])){
	
		update_option('codecocktail_wiki_username',$_POST['codecocktail_wiki_username']);
		update_option('codecocktail_wiki_user_param',$_POST['codecocktail_wiki_user_param']);
			
	}
	
		
		
	echo '
		<div class="wrap">
		<form method="post" action="" name="wiki-profile-form">
	
	  <div class="icon32" id="icon-options-general"><br>
	  </div>
	  <h2>'.__('Wiki Userprofile Settings','wp-wiki-userprofile').'</h2>
	  <table class="form-table">
		<tbody>
		  <tr>
			<td width="30%" valign="top"><strong>'.__('Wikipedia UserName:','wp-wiki-userprofile').'</strong></td>
			<td valign="top">
			<input type="text" name="codecocktail_wiki_username" value="'.get_option("codecocktail_wiki_username").'" size="60"/>
			</td>
		  </tr>
		  <tr>
			<td width="30%" valign="top"><strong>'.__('Parameters:','wp-wiki-userprofile').'</strong></td>
			<td valign="top">
			<input type="text" name="codecocktail_wiki_user_param" value="'.get_option("codecocktail_wiki_user_param").'" size="80"/>
			</td>
		  </tr>
		</tbody>
	  </table>
	  <h3>&nbsp;</h3>
	  <p class="submit">
		<input type="submit" value="Save Changes" class="button-primary" name="wiki-profile-submit">
	  </p>
	
	</form>
	<div class="shortcode-doc">
	<strong>'.__("Example Shortcode Usage:","wp-wiki-userprofile").'</strong>
	<ul>
		<li>[wikiuser]</li>
		<li>[wikiuser  param="editcount"]</li>
		<li>[wikiuser username="xxx" param="editcount"]</li>
	</ul>
	</div>
	<div class="feedback-doc">
	<strong>'.__("Feedback","wp-wiki-userprofile").'</strong>
	 <p>Feel free to contact me <a href="mailto:gchokeen@gmail.com?subject=Wp Wiki Userprofile">gchokeen@gmail.com</a>. I like to hear 
	 <a href="mailto:gchokeen@gmail.com?subject=Wp Wiki Userprofile Feedback">'.__("Future request","wp-wiki-userprofile").'</a>, 
	 <a href="mailto:gchokeen@gmail.com?subject=Wp Wiki Userprofile Suggestion">'.__("Suggestion","wp-wiki-userprofile").'</a>,
	 <a href="mailto:gchokeen@gmail.com?subject=Wp Wiki Userprofile Bug Report">'.__("Bug Report","wp-wiki-userprofile").'</a> 
	 or 
	 <a href="mailto:gchokeen@gmail.com?subject=Wp Wiki Userprofile Future request">'.__("Future request","wp-wiki-userprofile").'</a> 
	 from you.</p>
	</div>
	</div>
	
		
		';
		
	
}


// To notify admin about Wiki Userprofile configuration is not setuped  

if(get_option("codecocktail_wiki_username") == ""){
	add_action( 'admin_notices', 'wiki_profile_admin_notices');
}
else{
	remove_action( 'admin_notices', 'wiki_profile_admin_notices' );
}

function wiki_profile_load_function() {
	// Current page is options page for our plugin, so do not display notice
	// (remove hook responsible for this)
	remove_action( 'admin_notices', 'wiki_profile_admin_notices' );
}

function wiki_profile_admin_notices() {
	echo "<div id='notice' class='updated fade'><p>". __( 'Wiki Userprofile is not configured yet. Please configure it <a href="'.admin_url( 'options-general.php?page=wiki-profile').'">here</a> .','wp-wiki-userprofile' )."</p></div>\n";
}

//Install Wiki Userprofile  

register_activation_hook( __FILE__, 'wiki_profile_activate' );

function wiki_profile_activate(){

update_option('codecocktail_wiki_username','');
update_option('codecocktail_wiki_user_param','groups|editcount|registration|emailable|editcount|gender');
	
}

//Uninstall Wiki Userprofile 

register_deactivation_hook( __FILE__, 'wiki_profile_deactivate' );

function wiki_profile_deactivate(){
	delete_option('codecocktail_wiki_username');
	delete_option('codecocktail_wiki_user_param');
	
}


function getwiki($url="", $referer="", $userAgent="") {
	     do_action('getwiki');
	
        if($url==""||$referer==""||$userAgent=="") { return false;};
        $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
        $headers[] = 'Connection: Keep-Alive';
        $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
        $user_agent = $userAgent;
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($process, CURLOPT_HEADER, 0);
        curl_setopt($process, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($process, CURLOPT_REFERER, $referer);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        $return = curl_exec($process);
        curl_close($process);
        return $return;
		
	  
}

function get_wiki_response($wiki_username = "",$wiki_user_param=""){
	do_action('get_wiki_response');

$codecocktail_wiki_username = ($wiki_username=="" ? get_option("codecocktail_wiki_username"):$wiki_username);
$codecocktail_wiki_user_param = ($wiki_user_param=="" ? get_option("codecocktail_wiki_user_param"):$wiki_user_param);
	
			
	 $wiki_API_URL ="http://en.wikipedia.org/w/api.php?format=json&action=query&list=users&ususers=".$codecocktail_wiki_username."&usprop=".$codecocktail_wiki_user_param."";
	
	$response =  getwiki($wiki_API_URL, 'http://en.wikipedia.org/', 'Mozilla/5.0 (compatible; YourCoolBot/1.0; +http://yoursite.com/botinfo)');
	
	return json_decode($response,true);
}



function get_wiki_warning($array){
	do_action('get_wiki_warning');
	
	if($array['warnings']){
	 return $array['warnings']['users'];
	}
	else{
		return false;
	}
} 


/**
 * array_tree function will help to convert php array data into <ul>,<li> Html format.
 */

function array_tree($array,$args = array(),$level=0){

$default = array(
                 'container_class'=>'container-class',
                 'container_id'=>'container-id',
				 'exclude'=>array()
				 );
				 
$data = array_merge($default,$args);

	if(is_array($array)){	
	
	$output = '';
	$output .= '<ul'.($level==0?" class='$data[container_class]'":" class='sub-level-$level'").($level==0?" id='$data[container_id]'":'').'>';
	
	foreach($array as $key=>$value){
	
		if(is_array($value)){
			
		$output .='<li>'.(!is_numeric($key)?'<label>'.ucfirst($key).'</label>: ':'');
		$output .=array_tree($value,$data,$level++);
		$output .='</li>';
		}
		else{
			if(!in_array(strtolower($key),$data['exclude'])){
			
			$output .= '<li>'.(!is_numeric($key)?'<label>'.ucfirst($key).'</label>: ':'').ucfirst($value).'</li>';
			}
			}	
		}
	$output .= '</ul>';	
	
	return $output;
	}
	else{
		return $array;
	}

	
}




function get_wiki_display($wiki_username = "",$wiki_user_param=""){
	
	$array = get_wiki_response($wiki_username,$wiki_user_param);
	
	 $wiki_reposnse = $array['query']['users'];
	
	return array_tree($wiki_reposnse,array('exclude'=>array('userid')));
}


/**
 * Adds Wiki_Profile_Widget widget.
 */
class Wiki_Profile_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'wiki_profile_widget', // Base ID
			'Wiki Userprofile Widget', // Name
			array( 'description' => __( 'Wiki Userprofile Widget', 'wp-wiki-userprofile' ), ) // Args
		);
	}



	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
        	echo get_wiki_display();	

		    echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'wp-wiki-userprofile' );
		}
		?>
		<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

} // class Wiki_Profile_Widget


// register Wiki_Profile_Widget widget
add_action( 'widgets_init', create_function( '', 'register_widget( "wiki_profile_widget" );' ) );


/**
 * short code support added.
 *
 * @version 1.1
 *
 * @param username,param.
 */

function wikiuser_shortcode($atts) {

$codecocktail_wiki_username = 	get_option("codecocktail_wiki_username");
$codecocktail_wiki_user_param = 	get_option("codecocktail_wiki_user_param");	
	
     extract(shortcode_atts(array(
	      'username' => $codecocktail_wiki_username,
	      'param' => $codecocktail_wiki_user_param,
     ), $atts));
	 
     return get_wiki_display($username,$param);
}
add_shortcode('wikiuser', 'wikiuser_shortcode');