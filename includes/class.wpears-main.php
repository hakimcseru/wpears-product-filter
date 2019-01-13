<?php

if( ! class_exists( 'wpears_Main' ) ){

	class wpears_Main{
		public $wp_version = "";
		public $widget_option = "";

		function __construct(){
			$this->widget_option = $this->widget_include();
			add_action( 'admin_menu', array(&$this, 'wpears_add_menu') );
		}

		function wpears_add_menu(){
			add_menu_page( __('Wpears','wpears'), __('Wpears','wpears'), 'manage_options', 'wpears-admin-page', 'main_page', WPEARS_URL.'assets/img/wpears-logo.png',"100" );
		}

		function widget_include(){
			include_once('wpears-widget-page.php' );
			include_once('wpears-category-widget-page.php' );
			include_once('wpears-price-widget-page.php' );
			include_once('wpears-sorting-page.php' );
			include_once('wpears-size-widget-page.php' );
			include_once('wpears-color-widget-page.php' );
			new wpears_widget();
			new wpears_category_widget();
			new wpears_price_widget();
			new wpears_sorting_widget();
			new wpears_size_widget();
			new wpears_color_widget();
		}
	}

}

new wpears_Main();