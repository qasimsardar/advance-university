<?php

require get_theme_file_path('/inc/search-route.php');
require get_theme_file_path('/inc/like-route.php');

function university_custom_rest(){
    register_rest_field('post', 'authorName', array(
        'get_callback' => function(){return get_the_author();}
    ));

    register_rest_field('notes', 'userNoteCount', array(
        'get_callback' => function(){return count_user_posts(get_current_user_id(), 'notes');}
    ));
}


add_action('rest_api_init', 'university_custom_rest');


function page_banner($args = NULL){

    if (!$args['title']){
        $args['title'] = get_the_title();
    }
    
    if (!$args['subtitle']){
        $args['subtitle'] = get_field('page_subtitle');
    }

    if(!$args['banner_image']){
        if(get_field('banner_image') AND !is_archive() AND !is_home()){
            $args['banner_image'] = get_field('banner_image')['sizes']['pageBanner'];
        }
        else{
            $args['banner_image'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }

    ?>

    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['banner_image'] ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args['subtitle']; ?></p>
        </div>
      </div>
    </div>

<?php
}

function university_files(){
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyBC2Mq7KzJeEBtjxcmecOjENPBJIReFLNc', NULL, '1.0', true);

    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('our-main-styles-vendor', get_theme_file_uri('/build/index.css'));
    wp_enqueue_style('our-main-styles', get_theme_file_uri('/build/style-index.css'));

    wp_localize_script('main-university-js', 'universityData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ));
}

add_action('wp_enqueue_scripts', 'university_files');


function university_features(){
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPotrait', 240, 325, true);
    add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'university_features');


function university_adjust_queries($query){
    $today = date('Ymd');

    if (!is_admin() AND is_post_type_archive('programs') AND $query->is_main_query()){
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }

    if (!is_admin() AND is_post_type_archive('campuses') AND $query->is_main_query()){
        $query->set('posts_per_page', -1);
    }

    if (!is_admin() AND is_post_type_archive('events') AND $query->is_main_query()){
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
              'key' => 'event_date',
              'compare' => '>=',
              'value' => $today,
              'type' => 'numeric',
            ),
          ));

    }


}

add_action('pre_get_posts', 'university_adjust_queries');



function universityMapKey($api){
    $api['key'] = 'AIzaSyBC2Mq7KzJeEBtjxcmecOjENPBJIReFLNc';
    return $api;
}


add_filter('acf/fields/google_map/api', 'universityMapKey');


//Redirect subs to homepage

add_action('admin_init', 'redirectSubsToFrontend');

function redirectSubsToFrontend(){
    $ourCurrentUser = wp_get_current_user();
    if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber'){
        wp_redirect(site_url('/'));
        exit;
    }
}

//Hide admin bar for Subscribers

add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar(){
    show_admin_bar(false);
}


// Customize Login Screen
add_filter('login_headerurl', 'outHeaderUrl');

function outHeaderUrl(){
    return esc_url(site_url('/'));
}


add_action('login_enqueue_scripts', 'ourLoginCss');

function ourLoginCss(){

    wp_enqueue_style('our-main-styles-vendor', get_theme_file_uri('/build/index.css'));
    wp_enqueue_style('our-main-styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');

}

add_filter('login_headertitle', 'ourLoginTitle');

function ourLoginTitle(){
    return get_bloginfo('name');
}

//Force note posts to be private
// 2 tells us that we are working with two arguments
// 10 is the priority number for the hook (lower the number the earlier it will run)
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

function makeNotePrivate($data, $postarr){

    if ($data['post_type'] == 'notes'){

        if (count_user_posts(get_current_user_id(), 'notes') > 4 AND !$postarr['ID']){
            die("You have reached your note limit.");
        }

        $data['post_content'] = sanitize_textarea_field($data['post_content']);
        $data['post_title'] = sanitize_text_field($data['post_title']);
    }

    if($data['post_type'] == 'notes' AND $data['post_status'] != 'trash'){
        $data['post_status'] = "private";
    }

    return $data;
}

// remove "Private: " from titles
// Use a regex to allow 'Private: ' in title if user manually entered it.
function remove_private_prefix($title) {
    if (get_post_status() == 'private') {
      $regTitle = preg_replace('/^Private: /', '', $title);
      return $regTitle;
    } else {
      return $title;
    }
  }
  add_filter('the_title', 'remove_private_prefix');


