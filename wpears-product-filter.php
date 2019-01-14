<?php
/**
 * Plugin Name: WPEARS Product Filter
 * Plugin URI: https://wpearsproductfilter.com
 * Description:<code><strong>You can manage your product by filtering them by it. <a href="" target="_blank">Find new awesome plugins by <strong> Nayan </strong></code></a>
 * Version: 1.0.0
 * Author: 8pears Solution Limited
 * Author URI: https://8pears.com
 * Text Domain: wpears
 * Domain Path: /languages/
 */

if( ! defined( 'ABSPATH' ) ) {
	exit;
} // exit if directly access

/* delete code start*/
// echo $_SERVER['SERVER_NAME'];
// echo $_SERVER['PHP_SELF'];
/* delete code end */

/* This try-catch commented code return error */


/* error making commented code end */

// load text domain to make plugin translatable
load_plugin_textdomain( 'wpears', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

// define some values
if ( ! defined( 'WPEARS_URL' ) ) { 
	define( 'WPEARS_URL', trailingslashit( plugins_url() . '/' . plugin_basename( dirname(__FILE__) ) ) );
}
if ( ! defined( 'WPEARS_PATH' ) ) { 
	define( 'WPEARS_PATH', trailingslashit( str_replace("\\","/", WP_PLUGIN_DIR . '/' . plugin_basename( dirname(__FILE__) ) ) ) ); 
}

if ( ! class_exists( 'wpears_product_filter' ) ) {
	class wpears_product_filter{

		function __construct() {

			add_action( 'wp_enqueue_scripts', array(&$this, 'enqueue_asset_files') );
			add_action( 'admin_init', array(&$this, 'wpears_plugin_startup') );
			add_action( 'plugins_loaded', array(&$this, 'wpears_plugin_startup') ,9999);
			add_action( 'wp_head',  array(&$this,'wpears_add_admin_ajax') );
    		add_action( 'pre_get_posts', array(&$this, 'filter_get_posts') );
    		add_action('woocommerce_before_shop_loop', array(&$this, 'beforeProductLoop'), 0);
    		add_action('woocommerce_after_shop_loop', array(&$this, 'afterProductLoop'), 200);
		}

		//add wrapper-start before product loop
		function beforeProductLoop() {
			echo '<div class="wpears_product_wrapper">';
		}


		//add wrapper-end after product loop
		function afterProductLoop() {
			echo '</div>';
		}

		//filter by tax query
		function filter_get_posts($q) {
			$pro_cat      = $_GET['product_category'];
			$pro_tag      = $_GET['product_tag'];
			$pro_term     = $_GET['product_term'];
			$orderby      = $_GET['orderby'];

		    $tax_query = (array) $q->get( 'tax_query' );

		    if( isset($pro_cat) && !isset($pro_term) && !isset($orderby) && !isset($pro_tag) ){
		    	$tax_query[] = array(
		               'taxonomy' => 'product_cat',
		               'field' => 'term_id',
		               'terms' => array( $pro_cat ), // Don't display products in the clothing category on the shop page.
		               'operator' => 'IN'
		        );

		    }elseif( isset($pro_term) && !isset($pro_cat) && !isset($orderby) && !isset($pro_tag) ) {
	    		$tax_query[] = array(
	    	           'taxonomy' => 'pa_color',
	    	           'field' => 'slug',
	    	           'terms' => array( $pro_term ), // Don't display products in the clothing category on the shop page.
	    	           'operator' => 'IN'
	    	    );
		    }elseif( isset($pro_cat) && isset($pro_term) && !isset($orderby) && !isset($pro_tag) ) {
	    		$tax_query[] = array( 
	    				'relation' => 'AND',
			            array(
			                'taxonomy'        => 'pa_color',
			                'field'           => 'slug',
			                'terms'           =>  array($pro_term),
			            ),array(
			                'taxonomy'        => 'product_cat',
			                'field'           => 'term_id',
			                'terms'           =>  array($pro_cat),
			            )
			        );
		    }elseif( isset($pro_tag) && !isset($pro_term) && !isset($orderby) && !isset($pro_cat) ) {
	    		$tax_query[] = array( 
			            array(
			                'taxonomy'        => 'product_tag',
			                'field'           => 'term_id',
			                'terms'           =>  array($pro_tag),
			            )
			        );
		    }elseif( isset($orderby) ) {
	    		if( $orderby == 'newest' ) {
					$q->set( 'orderby', 'date' );
    		        $q->set( 'order', 'DESC' );     
				}elseif( $orderby == 'most-popular' ) {
					$q->set( 'meta_key', '_wc_review_count' );
    		        $q->set( 'orderby', 'meta_value_num' );     
    		        $q->set( 'order', 'DESC' );
    		    }elseif( $orderby == 'most-purchased' ) {
					$q->set( 'meta_key', 'total_sales' );
    		        $q->set( 'orderby', 'meta_value_num' );
    		    }elseif( $orderby == 'pricelh' ) {
					$q->set( 'meta_key', '_price' );
    		        $q->set( 'orderby', 'meta_value_num' );     
    		        $q->set( 'order', 'asc' );
    		    }elseif( $orderby == 'pricehl' ) {
					$q->set( 'meta_key', '_price' );
    		        $q->set( 'orderby', 'meta_value_num' );     
    		        $q->set( 'order', 'desc' );
    		    }elseif( $orderby == 'avarrat' ) {
					$q->set( 'meta_key', '_wc_average_rating' );
    		        $q->set( 'orderby', 'meta_value_num' );     
    		        $q->set( 'order', 'desc' );
    		    }else {

    		    }
		    }else {

		    }

		    $q->set( 'tax_query', $tax_query );
		}
			
		// dependency plugin notice
		function wpears_install_dependency_plugin_notice() { ?>
			<div class="error">
				<p><?php _e('Wpears Product Filter plugin needs Woocommerce Plugin to work, Please install Woocommerce Plugin First','wpears'); ?></p>
			</div>
		<?php
		}

		// plugin startup function
		function wpears_plugin_startup() {
			if( ! function_exists( 'WC' ) ) {
				add_action( 'admin_notices','wpears_install_dependency_plugin_notice',15 );

			}else{
				require_once( WPEARS_PATH . 'includes/class.wpears-main.php' );
				include_once ( 'admin/wpears-admin-page.php' );
				include_once ( 'ajax-pages/ajax-attribute-filter.php' );
				include_once ( 'ajax-pages/ajax-category-filter.php' );
				include_once ( 'ajax-pages/ajax-price-filter.php' );
				include_once ( 'ajax-pages/ajax-product-sorting.php' );
				
			}
		}
		
		// enqueue assets
		function enqueue_asset_files(){
			if ( is_admin() ) {
				wp_enqueue_style( 'wpears_css', WPEARS_URL. 'assets/css/wpears-style.css', false, '1.0' );

	    	}
	    		wp_enqueue_style( 'wpears_nouislider_css', WPEARS_URL. 'assets/css/nouislider.min.css', false, '1.0' );
	    		wp_enqueue_style( 'wpears_style_css', WPEARS_URL. 'assets/css/wpears-style.css', false, '1.0' );
	        	wp_enqueue_script( 'wpears_nouislider_js', WPEARS_URL. 'assets/js/nouislider.min.js', array( 'jquery' ), '1.0', true );
	        	wp_enqueue_script( 'wpears_script', WPEARS_URL. 'assets/js/wpears-script.js', array( 'jquery' ), '1.0', true );
	        	//send server url via localize script
				wp_localize_script('wpears_script', 'url_str', array(
				    'page_url_str' => 'http://localhost/wootest/shop/',
				));
		}

		// define the wp_head callback 
		function wpears_add_admin_ajax() { 
			$wpears_ad_aj = "";
		    $wpears_ad_aj .= '<script type="text/javascript">';
			$wpears_ad_aj .=  'var ajax_url = "'.admin_url("admin-ajax.php").'";'; 
			$wpears_ad_aj .= '//calling ajax_url to perform ajax </script>';

			echo $wpears_ad_aj;
		} 

	}
}

new wpears_product_filter();




