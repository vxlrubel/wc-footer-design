<?php
/*
Plugin Name: WC Footer Design
Description: Upgrade your website's footer with 'WC Footer Design,' a powerful WordPress plugin. Create sleek, modern footers like e-commerce apps, easily customize layout, colors, and content for a professional touch.
Version: 1.0
Author: Rubel Mahmud
Author URi: https://www.linkedin.com/in/vxlrubel
*/


// directly access deniyed

defined('ABSPATH') OR exit('No direct script access allowed');


// include all the files in this directory
require_once dirname(__FILE__) . '/inc/autoload.php';

if( ! class_exists( 'WC_Footer_Design' ) ){
    class WC_Footer_Design{
        // singletone instance of WC_Footer_Design
        private static $instance;

        // initiate the method
        public function __construct(){

            // enqueue scripts in the front-end panel
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_script_n_style' ] );
            
            // admin enqueue scripts
            add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_style' ] );

            // load the footer design
            add_action( 'wp_footer', [ $this, 'load_footer_design' ] );

            // register menu
            add_action( 'init', [ $this, 'register_app_menu'] );

            // admin menu
            add_action( 'admin_menu', [ $this, 'wc_admin_menu' ] );

            // create donation link
            add_filter( 'plugin_action_links', [ $this, 'settings_page' ], 10, 2 );

            // plugin documentation
            add_filter('plugin_row_meta', [ $this, 'documentation' ], 10, 2);
            
        }


        /**
         * register scripts and style
         *
         * @return void
         */
        public function enqueue_script_n_style(){

            $font_awesome = 1;

            if( $font_awesome == 1 ){
                wp_enqueue_style( 'font-awesome', 'https://use.fontawesome.com/releases/v6.4.2/css/all.css' );
            }

            // enqueue style
            wp_enqueue_style( 'wfd-style', plugins_url( 'assets/css/main.css', __FILE__ ) );

            // enqueue script
            wp_enqueue_script( 'wfd-script', plugins_url( 'assets/js/custom.js', __FILE__ ), ['jquery'], '1.0', true );
        }

        public function admin_enqueue_style(){
            $fontawesome = 'https://use.fontawesome.com/releases/v6.4.2/css/all.css';

            // enqueue font awesome
            wp_enqueue_style( 'font-awesome', $fontawesome );

            // enqueue custom admin style
            wp_enqueue_style( 'wfd-admin-style', plugins_url( 'assets/css/admin-main.css', __FILE__ ) );
        }

        /**
         * design template
         *
         * @return void
         */
        public function load_footer_design(){
            require_once dirname(__FILE__) . '/inc/footer-design.php';
        }

        /**
         * register nav menu
         *
         * @return void
         */
        public function register_app_menu(){
            $locations = [
                'app_menu' => 'App Menu'
            ];

            register_nav_menus( $locations );
        }

        /**
         * create a admin menu if woocommerce is enabled
         *
         * @return void
         */
        public function wc_admin_menu(){
            add_submenu_page(
                'woocommerce',                  // parent slug
                'WC Footer Design',             // page title
                'WC Footer Design',             // menu title
                'edit_posts',                   //capability
                'wc-footer-design',             // menu slug
                [ $this, '_cb_footer_design'],  // callback
                110                             // position
            );
        }
        /**
         * admin menu page design
         *
         * @return void
         */
        public function _cb_footer_design(){
            require_once dirname(__FILE__) . '/inc/wc-admin-page.php';
        }

        /**
         * pludin settings page
         *
         * @param [type] $links
         * @param [type] $file
         * @return void
         */
        public function settings_page( $links, $file ){

            if (plugin_basename(__FILE__) === $file) {
                $url = admin_url('nav-menus.php');
                $settings = "<a href=\"{$url}\">Settings</a>";
                array_unshift( $links, $settings );
            }
            return $links;
        }

        /**
         * documentation page
         *
         * @param [type] $meta
         * @param [type] $file
         * @return void
         */
        public function documentation( $meta, $file ){
            if (plugin_basename(__FILE__) === $file) {
                $doc_link = admin_url( 'admin.php' ) . '?page=wc-footer-design';
                $documentation = "<a href=\"{$doc_link}\">Documentation</a>";
                $meta[] = $documentation;
            }
        
            return $meta;
        }

        /**
         * initialize the singleton instance
         *
         * @return void
         */
        public static function init(){
            if ( is_null( self::$instance ) ){
                self::$instance = new self();
            }
            return self::$instance;
        }
    }
}

if( ! function_exists( 'wc_footer_design' ) ){
    function wc_footer_design(){
        return WC_Footer_Design::init();
    }

    wc_footer_design();
}