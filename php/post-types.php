<?php

/**
 * Post Types
 *
 * Creates a custom post type for
 * each element in the array.
 */

$custom_post_types = array(
   /*array(
      'name'   => 'house',
      'plural' => 'houses',
      'icon'   => 'dashicons-admin-home',
      'type'   => 'post',
      'tax'    => array(
         'name'   => 'house type',
         'plural' => 'house types',
      )
   )
   */
);

/*
| -------------------------------------------------------------------
|  Post Type setup
| -------------------------------------------------------------------
*/

function at_custom_post_types() {
   global $custom_post_types;

   foreach( $custom_post_types as $cpt ):

      // Defaults
      $default = array(
         'name'   => 'custom type',
         'plural' => 'custom types',
         'icon'   => 'dashicons-star-filled',
         'type'   => 'post',
         'tax'    => array()
      );

      // Merge defaults with supplied
      $cpt = array_intersect_key($cpt + $default, $default);
      if( $cpt['type'] == 'page'){
         $hierarchical = true;
      } else {
         $hierarchical = false;
      }

      // creating (registering) the custom type
      register_post_type( sanitize_title($cpt['name']),
         array('labels' => array(
            'name'                => __(ucwords($cpt['plural']), 'post type general name'), /* This is the Title of the Group */
            'singular_name'       => __(ucwords($cpt['name']), 'post type singular name'), /* This is the individual type */
            'add_new'             => __('Add New', 'custom post type item'), /* The add new menu item */
            'add_new_item'        => __('Add New '.ucwords($cpt['name'])), /* Add New Display Title */
            'edit'                => __('Edit'), /* Edit Dialog */
            'edit_item'           => __('Edit '.ucwords($cpt['plural'])), /* Edit Display Title */
            'new_item'            => __('New '.ucwords($cpt['name'])), /* New Display Title */
            'view_item'           => __('View '.ucwords($cpt['name'])), /* View Display Title */
            'search_items'        => __('Search '.ucwords($cpt['plural'])), /* Search Custom Type Title */
            'not_found'           => __('Nothing found in the Database.'), /* This displays if there are no entries yet */
            'not_found_in_trash'  => __('Nothing found in Trash'), /* This displays if there is nothing in the trash */
            'parent_item_colon'   => ''
         ), /* end of arrays */
         'description'         => __( ucwords($cpt['plural']).' for ' . get_bloginfo('name') ), /* Custom Type Description */
         'public'              => true,
         'publicly_queryable'  => true,
         'exclude_from_search' => false,
         'show_ui'             => true,
         'query_var'           => true,
         'menu_position'       => 8, /* this is what order you want it to appear in on the left hand side menu */
         'menu_icon'           => $cpt['icon'],
         'rewrite'             => true,
         'capability_type'     => $cpt['type'],
         'hierarchical'        => $hierarchical,
         /* the next one is important, it tells what's enabled in the post editor */
         'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky', 'page-attributes')
         ) /* end of options */
      ); /* end of register post type */


      if( ! empty($cpt['tax']) ){
         register_taxonomy(
            sanitize_title( $cpt['tax']['name'] ),
            sanitize_title( $cpt['name'] ),
            array(
               'hierarchical'      => false,
               'labels'            => array(
               'name'              => __( ucwords($cpt['tax']['name']) ),  // name of the custom taxonomy
               'singular_name'     => __( ucwords($cpt['tax']['name']) ),   // single taxonomy name
               'search_items'      => __( 'Search '.$cpt['tax']['name'] ), // search title for taxomony
               'all_items'         => __( 'All '.$cpt['tax']['name'] ),    // all title for taxonomies
               'parent_item'       => __( 'Parent '.$cpt['tax']['name'] ),  // parent title for taxonomy
               'parent_item_colon' => __( 'Parent '.$cpt['tax']['name'] ), // parent taxonomy title
               'edit_item'         => __( 'Edit '.$cpt['tax']['name'] ),    // edit custom taxonomy title
               'update_item'       => __( 'Update '.$cpt['tax']['name'] ),  // update title for taxonomy
               'add_new_item'      => __( 'Add New '.$cpt['tax']['name'] ), // add new title for taxonomy
               'new_item_name'     => __( 'New '.$cpt['tax']['name'] )      // name title for taxonomy
            ),
               'show_ui'     => true,
               'query_var'   => true,
               'rewrite'     => array('slug'=>$cpt['tax']['plural'])
            )
         );

      }

   endforeach;

}
// adding the function to the Wordpress init
if( !empty($custom_post_types) )
   add_action( 'init', 'at_custom_post_types');