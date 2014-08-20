<?php
/*
Plugin Name: WP Hard Options
Plugin URI: https://timnash.co.uk/wordpress-hard-coded-options/
Description: Checks Hard Coded WP Options
Version: 0.4
Author: Tim Nash
Author URI: https://timnash.co.uk
License: GPL2
*/ 
class WP_Hard_Options{

	public static $instance;
	
	/**
	 * Construct
	 *
	 * @since 0.1
	 * @param null
	 * @return null
	 *
	 **/
	function __construct() {
		self::$instance = $this;
		//Allows you to specify alternate prefix in wp-config.php or elsewhere
		if(!defined( WP_OPTIONS_PREFIX )){
			define( WP_OPTIONS_PREFIX, 'WP_OPTIONS' );
		}
		$options = $this->get_constants();
		if(!empty($options) && is_array($options)){
			foreach( $options as $option => $value ){
				$name = end(explode( WP_OPTIONS_PREFIX.'_', $option));
				$method_name = strtolower( $name );
				if( $method_name != WP_OPTIONS_PREFIX ){
					$filter_name = 'pre_option_'.$method_name;
					//Add filer pre_option_xxxx using call to catch xxxx and return constant
					add_filter( $filter_name, array($this, $method_name ) );
				}
			}
		}
	}

	/**
	 * Get Constants
	 * Cycle through all constants, return those with the wp_options prefix
	 *
	 * @since 0.1
	 * @param null (since 0.4)
	 * @return false | array($dump)
	 *
	 **/
	function get_constants () {
    	foreach ( get_defined_constants() as $key => $value ) {
        	if (substr( $key,0, strlen( WP_OPTIONS_PREFIX ) ) == WP_OPTIONS_PREFIX ) {
        		$dump[$key] = $value; 
        	}
    		if(empty( $dump )) { 
    			return false; 
    		}
    		else { 
    			//Use if you want to return a second prefix for example
    			return apply_filters('wp_hard_options',$dump); 
    		}
    	}
	}

	/**
	 * Magic Method Madness
	 * Create method and any arguments return defined constant content
	 *
	 * @since 0.1
	 * @param string($method), mixed($arg)
	 * @return false | string($option)
	 * @todo probably should unserialise an object...
	 *
	 **/
	function __call( $method, $arg = false ){
		$option = strtoupper(WP_OPTIONS_PREFIX.'_'. $method);
		if( defined( $option )){
			return constant( $option );
		}
		return false;
	}
}

new WP_Hard_Options;
