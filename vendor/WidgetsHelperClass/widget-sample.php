<?php
/**
* Plugin Name: Sample Widget
* Plugin URI: http://www.mattvarone.com
* Description: A widget example using WPH_Widget Class.
* Version: 0.1
* Author: Matt Varone
* Author URI: http://twitter.com/sksmatt
* License: GPLv2
*
* This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

// Require WPH_Widget Class
include_once( plugin_dir_path( __FILE__ ).'wph-widget-class.php' );

// Check if the custom class exists
if ( ! class_exists( 'MV_My_Recent_Posts_Widget' ) ) 
{
	// Create custom widget class extending WPH_Widget
	class MV_My_Recent_Posts_Widget extends WPH_Widget
	{
	
		function __construct()
		{
		
			// Configure widget array
			$args = array( 
				// Widget Backend label
				'label' => 'My Recent Posts', 
				// Widget Backend Description								
				'description' => 'My Recent Posts Widget Description', 		
			 );
		
			// Configure the widget fields
			// Example for: Title ( text ) and Amount of posts to show ( select box )
		
			// fields array
			$args['fields'] = array( 							
			
				// Title field
				array( 		
				// field name/label									
				'name' => 'Title', 		
				// field description					
				'desc' => 'Enter the widget title.', 
				// field id		
				'id' => 'title', 
				// field type ( text, checkbox, textarea, select, select-group )								
				'type'=>'text', 	
				// class, rows, cols								
				'class' => 'widefat', 	
				// default value						
				'std' => 'Recent Posts', 
				
				/*
					Set the field validation type/s
					///////////////////////////////
					
					'alpha_dash'			
					Returns FALSE if the value contains anything other than alpha-numeric characters, underscores or dashes.
					
					'alpha'				
					Returns FALSE if the value contains anything other than alphabetical characters.
					
					'alpha_numeric'		
					Returns FALSE if the value contains anything other than alpha-numeric characters.
					
					'numeric'				
					Returns FALSE if the value contains anything other than numeric characters.
					
					'boolean'				
					Returns FALSE if the value contains anything other than a boolean value ( true or false ).
					
					----------
					
					You can define custom validation methods. Make sure to return a boolean ( TRUE/FALSE ).
					Example:
					
					'validate' => 'my_custom_validation', 
					
					Will call for: $this->my_custom_validation( $value_to_validate );					
					
				*/
				
				'validate' => 'alpha_dash', 
				
				/*
				
					Filter data before entering the DB
					//////////////////////////////////
					
					strip_tags ( default )
					wp_strip_all_tags
					esc_attr
					esc_url
					esc_textarea
					
				*/
				
				'filter' => 'strip_tags|esc_attr'	
				 ), 
			
				// Amount Field
				array( 
				'name' => 'Amount', 							
				'desc' => 'Select how many posts to show.', 
				'id' => 'amount', 							
				'type'=>'select', 				
				// selectbox fields			
				'fields' => array( 								
						array( 
							// option name
							'name'  => '1 Post', 
							// option value			
							'value' => '1' 						
						 ), 
						array( 
							'name'  => '2 Posts', 			
							'value' => '2' 					
						 ), 
						array( 
							'name'  => '3 Posts', 
							'value' => '3'	
						 )
					
						// add more options
				 ), 
				'validate' => 'my_custom_validation', 
				'filter' => 'strip_tags|esc_attr', 
				 ), 
				
				// Output type checkbox
				array( 
				'name' => 'Output as list', 							
				'desc' => 'Wraps posts with the <li> tag.', 
				'id' => 'list', 							
				'type'=>'checkbox', 				
				// checked by default: 
				'std' => 1, // 0 or 1
				'filter' => 'strip_tags|esc_attr', 
				 ), 
			
				// add more fields
			
			 ); // fields array

			// create widget
			$this->create_widget( $args );
		}
		
		// Custom validation for this widget 
		
		function my_custom_validation( $value )
		{
			if ( strlen( $value ) > 1 )
				return false;
			else
				return true;
		}
		
		// Output function

		function widget( $args, $instance )
		{
	
			// And here do whatever you want
	
			$out  = $args['before_title'];
			$out .= $instance['title'];
			$out .= $args['after_title'];
				
			// here you would get the most recent posts based on the selected amount: $instance['amount'] 
			// Then return those posts on the $out variable ready for the output
			
			$out .= '<p>Hey There! </p>';

			echo $out;
		}
	
	} // class

	// Register widget
	if ( ! function_exists( 'mv_my_register_widget' ) )
	{
		function mv_my_register_widget()
		{
			register_widget( 'MV_My_Recent_Posts_Widget' );
		}
		
		add_action( 'widgets_init', 'mv_my_register_widget', 1 );
	}
}