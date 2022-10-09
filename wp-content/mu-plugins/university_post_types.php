<?php

function university_post_types(){
    // Event Post Type
    register_post_type('events',
        array(
            'capability_type' => 'events',
            'map_meta_cap' => true,
            'supports' => array('title', 'editor', 'excerpt'),
            'labels' => array(
                'name' => 'Events',
                'add_new_item' => 'Add New Event',
                'edit_item' => 'Edit Event',
                'all_items' => 'All Events',
                'singular_name' => 'Event',
            ),
            'show_in_rest' => true,
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-calendar'
        )
    );

    // Program Post Type
    register_post_type('programs',
        array(
            'supports' => array('title', 'excerpt'),
            'labels' => array(
                'name' => 'Programs',
                'add_new_item' => 'Add New Program',
                'edit_item' => 'Edit Program',
                'all_items' => 'All Program',
                'singular_name' => 'Program',
            ),
            'show_in_rest' => true,
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-awards'
        )
    );

    // Professor Post Type
    register_post_type('professors',
        array(
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
            'labels' => array(
                'name' => 'Professors',
                'add_new_item' => 'Add New Professor',
                'edit_item' => 'Edit Professor',
                'all_items' => 'All Professor',
                'singular_name' => 'Professor',
            ),
            'show_in_rest' => true,
            'public' => true,
            'menu_icon' => 'dashicons-welcome-learn-more'
        )
    );


    // Campus Post Type
    register_post_type('campuses',
        array(
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
            'labels' => array(
                'name' => 'Campuses',
                'add_new_item' => 'Add New Campus',
                'edit_item' => 'Edit Campus',
                'all_items' => 'All Campuses',
                'singular_name' => 'Campus',
            ),
            'show_in_rest' => true,
            'has_archive' => true,
            'public' => true,
            'menu_icon' => 'dashicons-location'
        )
    );

    // Notes Post Type
    register_post_type('Notes',
        array(
            'capability_type' => 'notes',
            'map_meta_cap' => true,
            'supports' => array('title', 'editor', 'excerpt'),
            'labels' => array(
                'name' => 'Notes',
                'add_new_item' => 'Add New Note',
                'edit_item' => 'Edit Note',
                'all_items' => 'All Notes',
                'singular_name' => 'Note',
            ),
            'show_in_rest' => true,
            'has_archive' => true,
            'public' => false,
            'show_ui' => true,
            'menu_icon' => 'dashicons-welcome-write-blog'
        )
    );

    // Like Post Type
    register_post_type('likes',
        array(
            'supports' => array('title'),
            'labels' => array(
                'name' => 'Likes',
                'add_new_item' => 'Add New Like',
                'edit_item' => 'Edit Like',
                'all_items' => 'All Likes',
                'singular_name' => 'Like',
            ),
            'public' => false,
            'show_ui' => true,
            'menu_icon' => 'dashicons-heart'
        )
    );
}

add_action('init', 'university_post_types');



