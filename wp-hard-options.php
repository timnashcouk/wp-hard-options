<?php
/*
Plugin Name: WP Hard Options
Description: Checks Hard Coded WP Options
Version: 0.3
Author: Tim Nash
Author URI: https://timnash.co.uk
*/ 
class WP_Hard_Options{

	public static $instance;
	
	function __construct() {
		self::$instance = $this;
		if(!defined( WP_OPTIONS_PREFIX )){
			define( WP_OPTIONS_PREFIX, 'WP_OPTIONS' );
		}

		$options = $this->get_constants( WP_OPTIONS_PREFIX );
		if(!empty($options) && is_array($options)){
			foreach( $options as $option => $value ){
				$name = end(explode( WP_OPTIONS_PREFIX.'_', $option));
				$method_name = strtolower( $name );
				if( $method_name != 'prefix' ){
					$filter_name = 'pre_option_'.$method_name;
					add_filter( $filter_name, array($this, $method_name ) );
				}
			}
		}
	}

	function get_constants ( $prefix ) {
    	foreach ( get_defined_constants() as $key => $value ) {
        	if (substr( $key,0, strlen( $prefix ) )==$prefix) {
        		$dump[$key] = $value; 
        	}
    		if(empty( $dump )) { 
    			return false; 
    		}
    		else { 
    			return $dump; 
    		}
    	}
	}

	function __call( $method, $arg = false ){
		$method = strtoupper(WP_OPTIONS_PREFIX.'_'. $method);
		if( defined( $method )){
			return constant( $method );
		}
		return false;
	}
}

new WP_Hard_Options;
