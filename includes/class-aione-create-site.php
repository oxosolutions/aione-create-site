<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://sgssandhu.com/
 * @since      1.0.0
 *
 * @package    Aione_Create_Site
 * @subpackage Aione_Create_Site/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Aione_Create_Site
 * @subpackage Aione_Create_Site/includes
 * @author     SGS Sandhu <sgs.sandhu@gmail.com>
 */
class Aione_Create_Site {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Aione_Create_Site_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'aione-create-site';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		
		add_shortcode( 'aione-create-site', array($this, 'aione_create_site_shortcode') );
		add_shortcode( 'aione-create-sitev2', array($this, 'aione_create_sitev2_shortcode') );
		
		add_shortcode( 'aione-blog-templates', array($this, 'aione_blog_templates_shortcode') ); 

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Aione_Create_Site_Loader. Orchestrates the hooks of the plugin.
	 * - Aione_Create_Site_i18n. Defines internationalization functionality.
	 * - Aione_Create_Site_Admin. Defines all hooks for the admin area.
	 * - Aione_Create_Site_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-aione-create-site-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-aione-create-site-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-aione-create-site-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-aione-create-site-public.php';

		/**
		 * The class responsible for creating CAPTCHA
		 * 
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'really-simple-captcha.php';

		$this->loader = new Aione_Create_Site_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Aione_Create_Site_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Aione_Create_Site_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Aione_Create_Site_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Aione_Create_Site_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Aione_Create_Site_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
	
	public function clean_input($string){
		$string=implode("",explode("\\",$string));
		return htmlentities(trim(strip_tags(stripslashes($string))), ENT_NOQUOTES, "UTF-8");
	}
	
	
	public function aione_create_site_shortcode (){
		$signup_url = home_url(); 
		if ( !is_user_logged_in() ) {
			header("Location: $signup_url/wp-login.php");
			exit;
		}
		$output = "";
		
		if (class_exists('Captcha'))  {
			
			$captcha_instance = new Captcha();
			$captcha_instance->cleanup($minutes = 30);
				
			$captcha_instance->chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';	
			$captcha_instance->bg = array( 255, 255, 255 );
			$captcha_instance->fg = array( 21, 141, 197 );
			$captcha_instance->img_size = array( 205, 40 );
			$captcha_instance->base = array( 20, 30 );
			$captcha_instance->font_size = 22;
			$captcha_instance->char_length = 6;
			$captcha_instance->font_char_width = 28;
			$upload_dir = wp_upload_dir();
			$captcha_instance->tmp_dir = $upload_dir['basedir'].'/captcha/';
			
		}
			
		if( isset($_POST['action']) && $_POST['action'] == 'create_site' ){
		
			$errors = array();
			
			if(strlen($_POST['create_website_form_site_url']) < 4){
				array_push($errors, array('element_id' => 'create_website_form_site_url', 'error' => 'Website URL must have at least 4 characters.'));
			}
			
			if (class_exists('Captcha'))  {
				$captcha_value= $_POST['captcha_value'];
				$prefix = $_POST['captcha_prefix'];
				$is_captcha_correct = $captcha_instance->check( $prefix, $captcha_value);
				
				if(!$is_captcha_correct){
					array_push($errors, array('element_id' => 'create_website_form_captcha_value', 'error' => 'Wrong captcha value'));
				}
			}
			
			$website_url = $this->clean_input($_POST['create_website_form_site_url']);
			
			if(SUBDOMAIN_INSTALL == 'true'){
				$domain = $website_url.'.'.DOMAIN_CURRENT_SITE;
				$path = PATH_CURRENT_SITE;
			} else {
				$domain = DOMAIN_CURRENT_SITE;
				$path = PATH_CURRENT_SITE.$website_url.'/';
			}
			//$domain = $website_url.'.darlic.com';
			//$path = '/'; 
			$title = $this->clean_input($_POST['create_website_form_site_title']);	
			
			if (function_exists('domain_exists')) {
				 if(domain_exists($domain, $path)){ 
					array_push($errors, array('element_id' => 'create_website_form_site_title', 'error' => 'the Website URL you requested is already Taken. Please Try another URL.'));
				 }
			}
			
			/* echo "<pre>";
			print_r($errors);
			echo "</pre>";  */
			if(empty($errors)){
			
				$blog_template = $_POST['blog_template'];
				
				$current_user = wp_get_current_user();
				$user_id = $current_user->ID;
				$site_id= 1;
				$meta = array(
					'blog_template' => $blog_template
				);
				
				//echo " === ".$blog_template;
				
				$site_created = wpmu_create_blog($domain, $path, $title, $user_id, $meta, $site_id); 

				
				if($site_created){
					$site_details = get_blog_details($site_created);
					$output .=  '<h2 class="success aligncenter">Your Website Created Successfully.</h2>';
					$output .=   '<h2 class="aligncenter">Website Name : '.$site_details->blogname.'</h2>';
					
					$output .=   '<a class="create_site_button create_website_form_submit left" href="'.$site_details->siteurl.'">View Website</a>';
					$output .=   '<a class="create_site_button create_website_form_submit right" href="'.$site_details->siteurl.'/wp-admin/">Admin Panel</a>';
					$output .=   '<div class="aione-clearfix margin-bottom15"></div>';
					
					$output .=   '<a class="create_site_button create_website_form_submit left" href="'.home_url().'/account/">My Account</a>';
					$output .=   '<a class="create_site_button create_website_form_submit right" href="'.home_url().'/u/'.$current_user->user_nicename.'/">My Profile</a>';
					$output .=   '<div class="aione-clearfix margin-bottom15"></div>';
					
					$output .=   '<h2 class="aligncenter">Create another website</h2>';

				} else {
					$output .=   '<ul class="errors">';
					$output .=   '<li class="error">Some error occurred while creating your website. Please contact support team.</li>';
					$output .=   '</ul>';
				}
			} else {
				$output .=   '<ul class="errors">';
				foreach ($errors as $error) {
					$output .=   '<li class="error">';
					$output .=   $error['error'];
					$output .=   '</li>';
				}
				$output .=   '</ul>';
			}
			$captcha_instance->remove($prefix);
		}
		
		
		$output .= '<form method="post" id="create_website_form" class="create-site-form aione-form form" action="">
			<ul>
			<li style=""> 
				';
		if(SUBDOMAIN_INSTALL != 'true'){
			$output .= '<label id="create_website_form_site_url_suffix" for="create_website_form_site_url">'.DOMAIN_CURRENT_SITE.'/</label>';
		}
		$output .= '
				<label class="create_website_form_label" for="create_website_form_site_url">Website URL<span class="gfield_required">*</span></label>
				<input name="create_website_form_site_url" id="create_website_form_site_url" placeholder="yourwebsite" type="text" value="'.$website_url.'" class="create_website_form_input large" tabindex="51">
			';
		if(SUBDOMAIN_INSTALL == 'true'){
			$output .= '<label id="create_website_form_site_url_suffix" for="create_website_form_site_url">.'.DOMAIN_CURRENT_SITE.'</label>';
		}
			
		$output .= '
			</li>
			<li>
				<label class="create_website_form_label" for="create_website_form_site_title">Website Title<span class="gfield_required">*</span></label>
				<input name="create_website_form_site_title" id="create_website_form_site_title" type="text" placeholder="Your Website Title" value="'.$title.'" class="create_website_form_input large" tabindex="52">
			</li>
			';
			
		if (class_exists('Captcha'))  {	
			$word = $captcha_instance->generate_random_word();
			$prefix = mt_rand();
			$image_name = $captcha_instance->generate_image( $prefix, $word );
			$captcha_image_url =  $upload_dir['baseurl'].'/captcha/'.$image_name;
			$blog_template = intval($_GET['template']);
				
			$output .= '<li>
					<label class="create_website_form_label" for="create_website_form_captcha_value">Captcha<span class="gfield_required">*</span></label>
					<div class="create_website_form_captcha_image">
					<img src="'.$captcha_image_url.'" />
					</div> 
					<input name="captcha_value" id="create_website_form_captcha_value" type="text" placeholder="Enter Captcha Here" value="" class="create_website_form_input large" tabindex="53">
					<input name="captcha_prefix" type="hidden" value="'.$prefix.'" >
					<div class="aione-clearfix"></div> 
				</li>
				';
		}
			
			if( $blog_template <= 0 ){
				$output .= '<li>
				<label class="create_website_form_label" for="create_website_form_select_template">Select Template</label>
				';
					$blog_templates_object = new blog_templates();
					$output .= $blog_templates_object->get_template_dropdown( 'blog_template', 1 , false , true );
				
				$output .= '
				</select>
				</li>
				';
			} 
			
			$output .= '<li>';
			if(isset($blog_template) && $blog_template > 0 ){
				$output .= '<input name="blog_template" type="hidden" value="'.$blog_template.'" >';
			}
			$output .= '
				<input name="action" type="hidden" value="create_site" >
				<input type="submit" id="create_website_form_submit" class="create_website_form_submit aione-button button-large button-round button-flat" value="Create Site" tabindex="54" onclick="">
			</li>
			</ul>
		</form>';
	
		
		
		return $output;
	}

	public function aione_create_sitev2_shortcode(){
		$signup_url = home_url();
		$output = "";

		if (class_exists('Captcha'))  {
			
			$captcha_instance = new Captcha();
			$captcha_instance->cleanup($minutes = 30);
				
			$captcha_instance->chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';	
			$captcha_instance->bg = array( 255, 255, 255 );
			$captcha_instance->fg = array( 21, 141, 197 );
			$captcha_instance->img_size = array( 205, 40 );
			$captcha_instance->base = array( 20, 30 );
			$captcha_instance->font_size = 22;
			$captcha_instance->char_length = 6;
			$captcha_instance->font_char_width = 28;
			$upload_dir = wp_upload_dir();
			$captcha_instance->tmp_dir = $upload_dir['basedir'].'/captcha/';
			
		}

		if( isset($_POST['action']) && $_POST['action'] == 'create_site' ){ 
			$errors = array();
			
			if(strlen($_POST['create_website_form_site_url']) < 4){
				array_push($errors, array('element_id' => 'create_website_form_site_url', 'error' => 'Website URL must have at least 4 characters.'));
			}

			if (class_exists('Captcha'))  {
				$captcha_value= $_POST['captcha_value'];
				$prefix = $_POST['captcha_prefix'];
				$is_captcha_correct = $captcha_instance->check( $prefix, $captcha_value);
				
				if(!$is_captcha_correct){
					array_push($errors, array('element_id' => 'create_website_form_captcha_value', 'error' => 'Wrong captcha value'));
				}
			}

			$website_url = $this->clean_input($_POST['create_website_form_site_url']);
			
			if(SUBDOMAIN_INSTALL == 'true'){
				$domain = $website_url.'.'.DOMAIN_CURRENT_SITE;
				$path = PATH_CURRENT_SITE;
			} else {
				$domain = DOMAIN_CURRENT_SITE;
				$path = PATH_CURRENT_SITE.$website_url.'/';
			}

			$title = $this->clean_input($_POST['create_website_form_site_title']);

			if (function_exists('domain_exists')) {
				 if(domain_exists($domain, $path)){ 
					array_push($errors, array('element_id' => 'create_website_form_site_title', 'error' => 'the Website URL you requested is already Taken. Please Try another URL.'));
				 }
			}

			if ( !is_user_logged_in() ) {
				$user_email = $_POST['create_website_form_site_email'];
				$user_password = $_POST['create_website_form_site_password'];
				// this is required for username checks
				if($user_email == '') {
					array_push($errors, array('element_id' => 'create_website_form_site_email', 'error' => 'Email address field can not be empty.'));
				} else {
					if(!is_email($user_email)) {
						array_push($errors, array('element_id' => 'create_website_form_site_email', 'error' => 'Email address you have entered is invalid. Enter a valid email address.'));
					}
					if(email_exists($user_email)) {
						array_push($errors, array('element_id' => 'create_website_form_site_email', 'error' => 'Email already registered.'));
					}
				}
				// this is required for password checks
				if($user_password == '') {
					array_push($errors, array('element_id' => 'create_website_form_site_password', 'error' => 'Password field can not be empty.'));
				} else {
					if(preg_match("/^.*(?=.{8,})(?=.*[0-9]).*$/", $user_password) === 0){
						array_push($errors, array('element_id' => 'create_website_form_site_password', 'error' => 'Password should have minimum 8 character and one number is compulsary.'));
						
					}
				}
			}

			if(empty($errors)){
				$site_id= 1;				

				if ( !is_user_logged_in() ){
					$user_role = get_option('default_role');

					$new_user_id = wp_insert_user(array(
							'user_login'		=> $user_email,
							'user_pass'	 		=> $user_password,
							'user_email'		=> $user_email,
							'user_registered'		=> date('Y-m-d H:i:s'),
							'role'			=> $user_role
						)
					);
					$site_created = wpmu_create_blog($domain, $path, $website_url, $new_user_id, $meta, $site_id); 
				} else {
					$current_user = wp_get_current_user();
					$user_id = $current_user->ID;
					$site_created = wpmu_create_blog($domain, $path, $website_url, $user_id, $meta, $site_id); 
				}

				if($site_created){
					$site_details = get_blog_details($site_created);
					$output .=  '<h2 class="success aligncenter">Your Website Created Successfully.</h2>';
					$output .=   '<h2 class="aligncenter">Website Name : '.$site_details->blogname.'</h2>';
					
					if(!is_user_logged_in()){
						$output .=   '<a class="create_site_button create_website_form_submit left" href="'.$site_details->siteurl.'">View Website</a>';
						$output .=   '<a class="create_site_button create_website_form_submit right" href="'.$site_details->siteurl.'/wp-login.php">Login</a>';

					} else {
						$output .=   '<a class="create_site_button create_website_form_submit left" href="'.$site_details->siteurl.'">View Website</a>';
						$output .=   '<a class="create_site_button create_website_form_submit right" href="'.$site_details->siteurl.'/wp-admin/">Admin Panel</a>';
						$output .=   '<div class="aione-clearfix margin-bottom15"></div>';
						
						$output .=   '<a class="create_site_button create_website_form_submit left" href="'.home_url().'/account/">My Account</a>';
						$output .=   '<a class="create_site_button create_website_form_submit right" href="'.home_url().'/u/'.$current_user->user_nicename.'/">My Profile</a>';
						$output .=   '<div class="aione-clearfix margin-bottom15"></div>';
					}
					$output .=   '<h2 class="aligncenter">Create another website</h2>';

				} else {
					$output .=   '<ul class="errors">';
					$output .=   '<li class="error">Some error occurred while creating your website. Please contact support team.</li>';
					$output .=   '</ul>';
				}
			} else {
				$output .=   '<ul class="errors">';
				foreach ($errors as $error) {
					$output .=   '<li class="error">';
					$output .=   $error['error'];
					$output .=   '</li>';
				}
				$output .=   '</ul>';
			}
		}

		$output .= '<form method="post" id="create_website_form" class="create-site-form aione-form form" action="">';

		if(SUBDOMAIN_INSTALL != 'true'){
			$output .= '<label id="create_website_form_site_url_suffix" for="create_website_form_site_url">'.DOMAIN_CURRENT_SITE.'/</label>';
		}
		$output .= '
				<label class="create_website_form_label" for="create_website_form_site_url">Website URL<span class="gfield_required">*</span></label>
				<input name="create_website_form_site_url" id="create_website_form_site_url" placeholder="yourwebsite" type="text" value="'.$website_url.'" class="create_website_form_input large" tabindex="51">
			';
		if(SUBDOMAIN_INSTALL == 'true'){
			$output .= '<label id="create_website_form_site_url_suffix" for="create_website_form_site_url">.'.DOMAIN_CURRENT_SITE.'</label>';
		}

		$output .= '
				<label class="create_website_form_label" for="create_website_form_site_title">Website Title<span class="gfield_required">*</span></label>
				<input name="create_website_form_site_title" id="create_website_form_site_title" type="text" placeholder="Your Website Title" value="'.$title.'" class="create_website_form_input large" tabindex="52">
		';
			
		if ( !is_user_logged_in() ){
			$output .= '
				<label class="create_website_form_label" for="create_website_form_site_email">Email<span class="gfield_required">*</span></label>
				<input name="create_website_form_site_email" id="create_website_form_site_email" placeholder="your email" type="text" value="'.$user_email.'" class="create_website_form_input large" tabindex="51">

				<label class="create_website_form_label" for="create_website_form_site_password">Password<span class="gfield_required">*</span></label>
				<input name="create_website_form_site_password" id="create_website_form_site_password" placeholder="your password" type="password" value="" class="create_website_form_input large" tabindex="51">
			';			
		}
		if (class_exists('Captcha'))  {	
			$word = $captcha_instance->generate_random_word();
			$prefix = mt_rand();
			$image_name = $captcha_instance->generate_image( $prefix, $word );
			$captcha_image_url =  $upload_dir['baseurl'].'/captcha/'.$image_name;
				
			$output .= '
					<label class="create_website_form_label" for="create_website_form_captcha_value">Captcha<span class="gfield_required">*</span></label>
					<div class="create_website_form_captcha_image">
					<img src="'.$captcha_image_url.'" />
					</div> 
					<input name="captcha_value" id="create_website_form_captcha_value" type="text" placeholder="Enter Captcha Here" value="" class="create_website_form_input large" tabindex="53">
					<input name="captcha_prefix" type="hidden" value="'.$prefix.'" >
					<div class="aione-clearfix"></div> 
				';
		}
		$output .= '
			<input name="action" type="hidden" value="create_site" >
			<input type="submit" id="create_website_form_submit" class="create_website_form_submit aione-button button-large button-round button-flat" value="Create Site" tabindex="54" onclick="">
		</form>';
	
		
		
		return $output;
	}
	
	public function aione_blog_templates_shortcode (){
		$settings = nbt_get_settings();
		$templates = $settings['templates'];
		$create_page_url = home_url("/create/");
		
		/*
		foreach($settings as $key => $value){
			echo "=========<br>";
			echo "<pre>";
			print_r($value);
			echo "</pre>";
		}
		*/

		
		$output = "";
		$output .= '<div class="aione-blog-templates">';
		
		foreach($templates as $key => $template){
			$demo_url = get_site_url($template['blog_id']);
			$create_site_url = $create_page_url."?template=".$template['ID'];
			$screenshot_url = $template['screenshot'];
			
			$template_title = $template['name'];
			$template_description = $template['description'];
			
			$output .= '<div class="aione-blog-template">';
				$output .= '<div class="aione-blog-template-image">';
					$output .= '<img src="'.$screenshot_url.'" alt=""/>';
				$output .= "</div>";
				
				$output .= '<div class="aione-blog-template-details">';
					$output .= '<div class="aione-blog-template-info">';
						$output .= '<h1 class="aione-blog-template-title">'.$template_title.'</h2>';
						$output .= '<p class="aione-blog-template-description">'.$template_description.'</p>';
					
					$output .= "</div>";
					
					$output .= '<div class="aione-blog-template-actions">';
						$output .= '<a class="aione-blog-template-action action-demo" href="'.$demo_url.'" target="_blank">Demo</a>';
						$output .= '<a class="aione-blog-template-action action-create" href="'.$create_site_url.'">Create Site</a>';
					$output .= "</div>";
				$output .= "</div>";

			$output .= "</div>";
		}
		
		$output .= "<style>
		
		
		</style>";
		$output .= "</div>";

		return $output;
	}

}
