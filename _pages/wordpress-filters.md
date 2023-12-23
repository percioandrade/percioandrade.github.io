---
layout: page
permalink: /wp-filter/
title:  WordPress Filters
excerpt: A collection of WordPress filters
---

## Filter codes for you WordPress

Coloque-o em functions.php ou crie um novo plugin para isso.

*   Changelog

- 1.0: Started
- 1.1: Codes updated to use fn() introduced on PHP 7.4
- 1.2: Converted to github pages

---

**<a name="shortcode_in_menu"></a>WordPress - Enable shortcode in menu**

	/* Updated to avoid unfiltered_html in menu */

	/**
	* Custom Walker class to handle shortcodes in navigation menu items.
	*/
	class Custom_Nav_Menu_Walker extends Walker_Nav_Menu {
		/**
		* Filter the menu item's content.
		*
		* @param string $item_output The menu item's starting HTML output.
		* @param object $item The current menu item.
		* @param int $depth Depth of menu item. Used for padding.
		* @param object $args An object of wp_nav_menu() arguments.
		* @return string Modified menu item's output.
		*/
		public function start_el(&$item_output, $item, $depth = 0, $args = null) {
			// Execute shortcodes only on the menu item's title (label).
			$item_output = do_shortcode($item->title);
			parent::start_el($item_output, $item, $depth, $args);
		}
	}

	// Hook the custom walker to 'wp_nav_menu'.
	add_filter('wp_nav_menu_args', function($args) {
		$args['walker'] = new Custom_Nav_Menu_Walker();
		return $args;
	});

---

**<a name="logout_url"></a>Enable logout url masked eg: /$VALUE=1**

	// Custom logout URL filter.
	add_filter('logout_url', fn($logout_url, $redirect) => (
		$redirect ? add_query_arg('redirect', esc_url_raw($redirect), wp_logout_url(home_url())) : wp_logout_url(home_url())
	), 10, 2);

	// Custom logout action on 'wp_loaded'.
	add_action('wp_loaded', fn() => custom_logout_action());

---

**<a name="custom_logout"></a>WordPress - Custom logout URL**

	/**
	* Customize the logout URL with additional query parameters.
	*
	* @param string $logout_url The default logout URL.
	* @param string $redirect The URL to redirect to after logout (optional).
	* @return string The modified logout URL.
	*/
	function custom_logout_url($logout_url, $redirect) {
		// Generate the logout URL with the 'NEW_VALUE' query parameter
		$logout_url = add_query_arg('NEW_VALUE', 1, wp_logout_url(home_url())); // example: bye

		// Add the 'redirect' query parameter if provided
		if (!empty($redirect)) {
			$logout_url = add_query_arg('redirect', esc_url_raw($redirect), $logout_url);
		}

		return esc_url($logout_url);
	}

	// Hook the function to the 'logout_url' filter with a priority of 10 and 2 accepted arguments.
	add_filter('logout_url', 'custom_logout_url', 10, 2);

---

**<a name="custom_logout_query"></a>WordPress - Custom logout action based on a query parameter**

	/**
	* Custom logout action based on a query parameter.
	*/
	function custom_logout_action() {
		// Check if the 'logout_param' query parameter is set
		$logout_param = filter_input(INPUT_GET, 'logout_param', FILTER_SANITIZE_STRING);
		if (isset($logout_param)) {
			// Perform user logout
			wp_logout();

			// Get the redirect URL from 'redirect' query parameter, or use home_url() as default
			$redirect = filter_input(INPUT_GET, 'redirect', FILTER_SANITIZE_URL);
			$loc = isset($redirect) ? $redirect : home_url();

			// Redirect the user with a 302 status code (temporary redirect)
			wp_redirect(esc_url($loc), 302);
			exit;
		}
	}

	// Hook the function to the 'template_redirect' action.
	add_action('template_redirect', 'custom_logout_action');

---

**<a name="remove_amp"></a>WordPress - Remove amp validation**

	add_filter(
		'amp_validation_error_sanitized',
		fn($sanitized, $error) => ($error['node_name'] === 'script' && strpos($error['text'], 'WFAJAXWatcherVars') !== false) ?? $sanitized,
		10,
		2
	);

---

**<a name="current_user_attachment"></a>WordPress - Show only current user's attachments in the media library via AJAX**

	/**
	* Show only current user's attachments in the media library via AJAX.
	*
	* @param array $query The original query arguments.
	* @return array Modified query arguments.
	*/
	function wpsnippet_show_current_user_attachments($query) {
		$user_id = get_current_user_id();
		if ($user_id && !current_user_can('activate_plugins') && !current_user_can('edit_others_posts')) {
			$query['author'] = $user_id;
		}
		return $query;
	}

	// Hook the function to the 'ajax_query_attachments_args' filter.
	add_filter('ajax_query_attachments_args', 'wpsnippet_show_current_user_attachments');

---

**<a name="remove_version_parameter"></a>WordPress - Remove version parameter from CSS and JS file URLs**

	/**
	* Remove version parameter from CSS and JS file URLs.
	*
	* @param string $src The URL of the file.
	* @return string The modified URL without the version parameter.
	*/
	function my_remove_wp_ver_css_js($src) {
		if (strpos($src, 'ver=')) {
			$src = preg_replace('/\?ver=[^&]+/', '', $src);
		}
		return $src;
	}

	// Hook the function to both 'style_loader_src' and 'script_loader_src' filters with a priority of 9999.
	add_filter('style_loader_src', 'my_remove_wp_ver_css_js', 9999);
	add_filter('script_loader_src', 'my_remove_wp_ver_css_js', 9999);

---

**<a name="remove_wpversion"></a>WordPress - Remove WP version**

	add_filter('the_generator', fn() => '');

---

**<a name="remove_admin_bar"></a>WordPress - Remove admin bar**

	add_filter('show_admin_bar', fn() => false);

---

**<a name="disable_gutemberg"></a>WordPress - Disable Gutemberg**

	add_filter('use_block_editor_for_post', fn() => false);

---

**<a name="clean_wordPress"></a>WordPress - Clean WordPress**

	final class RemoveTrashWP {
		public function __construct() {
			// Admin Bar
			add_action('admin_bar_menu', [$this, 'removeAdminBarItems'], 999);

			// Admin Dashboard
			add_action('wp_dashboard_setup', [$this, 'cleanAdminDashboard']);

			// Admin Head
			add_action('wp_loaded', [$this, 'cleanAdminHead']);

			// Body Class
			add_filter('body_class', [$this, 'addSlugToBodyClass']);

			// Contextual Help
			add_filter('contextual_help', [$this, 'removeContextualHelp'], 999, 3);

			// Widgets
			add_action('widgets_init', [$this, 'removeDefaultWidgets']);

			// Headers
			add_filter('wp_headers', [$this, 'removePingbackHeader']);
			add_filter('wp_headers', [$this, 'removeJsonApi']);

			// Login URL
			add_action('login_headerurl', [$this, 'modifyLoginHeaderURL']);

			// Miscellaneous
			add_filter('admin_footer_text', '__return_null');
			add_filter('emoji_svg_url', '__return_false');
			add_filter('enable_post_by_email_configuration', '__return_false', 999);
			add_filter('feed_links_show_comments_feed', '__return_false');
			add_filter('get_image_tag_class', [$this, 'addImageAlignClass'], 10, 4);
			add_filter('jpeg_quality', [$this, 'setJpegQuality']);
			add_filter('the_generator', '__return_empty_string');

			// Welcome Panel
			remove_action('welcome_panel', 'wp_welcome_panel');
		}

		// Methods for each action/filter (Add comments to describe each one)...
		
		// Admin Bar
		public function removeAdminBarItems() {
			// Code to remove items from admin bar...
		}

		// Admin Dashboard
		public function cleanAdminDashboard() {
			// Code to clean up the admin dashboard...
		}

		// Admin Head
		public function cleanAdminHead() {
			// Code to clean up the admin head...
		}

		// Other methods...
	}

---

**<a name="enable_webp"></a>WordPress - Enable WEBP in Media**

	add_filter('mime_types', fn($mimes) => [
		'webp' => 'image/webp',
	] + $mimes );

---

**<a name="check_webp"></a>WordPress - Check if a WebP image is displayable**

	/**
	* Check if a WebP image is displayable.
	*
	* @param bool $result The default result of whether the image is displayable.
	* @param string $path The path to the image file.
	* @return bool The updated result of whether the image is displayable.
	*/
	function webp_is_displayable($result, $path) {
		if ($result === false) {
			$info = getimagesize($path);
			$displayable_image_types = array(IMAGETYPE_WEBP);
			$result = ( $info !== false && in_array($info[2], $displayable_image_types) );
		}
		return $result;
	}

	// Hook the function to the 'file_is_displayable_image' filter with a priority of 10 and 2 accepted arguments.
	add_filter('file_is_displayable_image', 'webp_is_displayable', 10, 2);

---

**<a name="remove_category"></a>WordPress - Remove the "/category/" segment from non-single post type URLs**

	/**
	* Remove the "/category/" segment from non-single post type URLs.
	*
	* @param string $string The URL to be modified.
	* @param string $type The post type.
	* @return string Modified URL.
	*/
	function remove_category_from_url($string, $type) {
		if ($type !== 'single' && $type === 'category' && strpos($string, 'category') !== false) {
			$url_without_category = str_replace('/category/', '/', $string);
			return trailingslashit($url_without_category);
		}
		return $string;
	}

	// Hook the function to the 'user_trailingslashit' filter with a priority of 100 and 2 accepted arguments.
	add_filter('user_trailingslashit', 'remove_category_from_url', 100, 2);

---

**<a name="login_mail"></a>WordPress - Force login with mail only**

	function email_login_authenticate( $user, $username, $password ) {
		if ( is_email( $username ) ) {
			$user = get_user_by( 'email', $username );
			if ( $user ) {
				$username = $user->user_login;
			}
		}

		return wp_authenticate_username_password( null, $username, $password );
	}
	add_filter( 'authenticate', 'email_login_authenticate', 20, 3 );

	function email_login_username_label( $translated_text, $text, $domain ) {
		if ( $text === 'Username' ) {
			$translated_text = 'Email'; // Change 'Username' to 'Email' in the login form.
		}
		return $translated_text;
	}
	add_filter( 'gettext', 'email_login_username_label', 20, 3 );

---

**<a name="customize_adminbar"></a>WordPress - Customize the WordPress admin bar for non-administrator users**

	/**
	* Customize the WordPress admin bar for non-administrator users.
	*
	* @param WP_Admin_Bar $admin_bar The WordPress admin bar object.
	* @return WP_Admin_Bar Modified WordPress admin bar object.
	*/
	function customize_admin_bar_for_non_admins($admin_bar) {
		// Check if the current user is not an administrator
		if (!current_user_can('administrator')) {
			$redirect = site_url();

			// Remove unwanted admin bar menus
			$admin_bar->remove_menu('wp-logo');
			$admin_bar->remove_node('new-content');
			$admin_bar->remove_menu('edit');
			$admin_bar->remove_menu('updates');
			$admin_bar->remove_menu('search');
			$admin_bar->remove_menu('comments');
			$admin_bar->remove_node('site-name');
			$admin_bar->remove_node('my-account');

			// Add appropriate login/logout link based on user login status
			$login_logout_title = is_user_logged_in() ? 'Sair para Home' : 'Faça Login';
			$login_logout_id = is_user_logged_in() ? 'logout' : 'login';
			$login_logout_class = is_user_logged_in() ? 'link-logout' : 'link-login';
			$login_logout_href = is_user_logged_in() ? wp_logout_url($redirect) : wp_login_url($redirect);

			$admin_bar->add_menu(array(
				'id' => $login_logout_id,
				'parent' => 'top-secondary',
				'title' => $login_logout_title,
				'href' => $login_logout_href,
				'meta' => array('class' => $login_logout_class),
			));
		}

		return $admin_bar;
	}

	// Hook the function to the 'admin_bar_menu' action with a priority of 999999
	add_action('admin_bar_menu', 'customize_admin_bar_for_non_admins', 999999);

---

**<a name="protects_login"></a>WordPress - Protects the WordPress login page from brute force attacks and various login attempts**

	// Block direct access to the plugin file
	defined('ABSPATH') or die('No script kiddies please!');

	// Hook into the login form to add login protection
	add_action('login_init', 'custom_login_security');

	function custom_login_security() {
		// Set the maximum number of login attempts allowed
		$max_attempts = 5;

		// Set the duration (in seconds) to lock out login attempts
		$lockout_duration = 600; // 10 minutes

		// Get the user's IP address
		$user_ip = $_SERVER['REMOTE_ADDR'];

		// Check if the user has exceeded the maximum number of login attempts
		$login_attempts = get_transient('custom_login_attempts_' . $user_ip);

		if ($login_attempts >= $max_attempts) {
			// User has exceeded the maximum login attempts, block further attempts
			header('HTTP/1.1 403 Forbidden');
			die('Too many login attempts. Please try again later.');
		}
	}

	// Hook into the authentication process to count login attempts
	add_filter('wp_authenticate_user', 'custom_track_login_attempts', 10, 2);

	function custom_track_login_attempts($user, $username) {
		// Get the user's IP address
		$user_ip = $_SERVER['REMOTE_ADDR'];

		// Get the current login attempts count
		$login_attempts = get_transient('custom_login_attempts_' . $user_ip);

		// Increase the login attempts count
		$login_attempts = ($login_attempts) ? $login_attempts + 1 : 1;

		// Save the new login attempts count with a lockout duration
		set_transient('custom_login_attempts_' . $user_ip, $login_attempts, $lockout_duration);

		return $user;
	}

---

**<a name="wordpress_customerror"></a>WordPress - Change error message on login**

	function error_msgs() {
		$custom_error_msgs = [
			'<strong>YOU</strong> SHALL NOT PASS!',
			'<strong>HEY!</strong> GET OUT OF HERE!',
		];

		// Return a random error message from the array or use a default message if the array is empty
		return !empty($custom_error_msgs) ? $custom_error_msgs[array_rand($custom_error_msgs)] : 'Invalid credentials. Please try again.';
	}

	add_filter('login_errors', 'error_msgs');

---

**<a name="wordpress_disablerestapi"></a>WordPress - Disable RestAPI**

	add_filter('rest_authentication_errors', function ($access) {
		return new WP_Error('rest_api_disabled', __('The REST API is disabled on this site.'), array('status' => 403));
	});

---


**<a name="elementor_googlefont"></a>Elementor - Remove Google Fonts in Elementor**

	add_filter('elementor/frontend/print_google_fonts', fn() => false);

---

**<a name="rankmath_customurl"></a>Rankmath - Custom URL on sitemap**

	add_filter('rank_math/sitemap/xml_img_src', function($src, $post) {
		return set_url_scheme($src, 'https');
	}, 10, 2);

---

**<a name="remove_credit"></a>Rankmath - Remove sitemap credit**

	add_filter('rank_math/sitemap/remove_credit', fn() => true);

---

**<a name="woocommerce_changelinks"></a>Woocommerce - Change menu links**

	add_filter('woocommerce_account_menu_items', fn($menu_links) => [
		'rastrear-pedido' => 'Rastrear Pedido',
	] + $menu_links);

---

**<a name="woocommerce_changefrontproduct"></a>Woocommerce - Change front product number variations**

	add_filter('woocommerce_ajax_variation_threshold', fn() => 100);
