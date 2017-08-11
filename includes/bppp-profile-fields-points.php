<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


function bppp_register_profile_fields_points() {
    //get all the fields
    if ( !$fields = wp_cache_get( 'xprofile_fields', bppp()->prefix ) ) {
            $fields = bppp_retrieve_profile_fields();
            wp_cache_set( 'xprofile_fields', $fields, bppp()->prefix );
    }

    // remove first field coz we don't want to count base field (Name)
    array_shift( $fields );
    
	$points = bp_get_option( 'bppp-points-shares', '' );

    foreach( ( array ) $fields as $field ) {

		$field_value = bp_get_profile_field_data( array( 
			'field'		=> $field->id, 	
			'name'		=> $field->name,
			'user_id'	=> bp_displayed_user_id()
		) );
      
    
		if ( !isset( $points['field-'.$field->id] ) ) {
			$point = 0;
		} else {
			$point = $points['field-'.$field->id];
		}

      // output field ID on settings page
		bppp_register_progression_point(
			'field-'.$field->id, 
			$field->name, 
			'bppp_get_user_progression_for_field',
			$point,
			array( 'field-id'=>$field->id ) );         
		}
}

/**
* Define fields property
* @since 1.0.1
*/

function bppp_retrieve_profile_fields() {

    if ( !$groups = wp_cache_get( 'xprofile_groups_inc_empty', bppp()->prefix ) ) {
            $groups = BP_XProfile_Group::get( array( 'fetch_fields' => true ) );
            wp_cache_set( 'xprofile_groups_inc_empty', $groups, bppp()->prefix );
    }
    foreach( ( array ) $groups as $group ) {
        
		// define fields property
		if( isset( $group->fields ) ) {

			foreach( ( array ) $group->fields as $key=>$field ) {

					$fields[] = $field;
				}
			}

		}
    return $fields;
}


function bppp_get_user_progression_for_field() {    
    //get current point item
    $point_item		= bppp()->query->point;
    $field_id		= $point_item['args']['field-id'];

    if(!$field_id) return false;
    
    //get field value
    $value = bp_get_profile_field_data( array(
		'field'		=> $field_id,
		'user_id'	=> bp_displayed_user_id() 
	) );

    return (bool)$value; //return TRUE (100% of potential points)
}
//register profile fields points
add_action( 'bppp_register_progression_points', 'bppp_register_profile_fields_points', 9 );