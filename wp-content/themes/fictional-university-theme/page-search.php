<?php get_header();
    while(have_posts()){
        the_post();
?>



<div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title(); ?></h1>
        <div class="page-banner__intro">
          <p>Learn how the school of your dreams got started.</p>
        </div>
      </div>
    </div>

    <div class="container container--narrow page-section">

      <?php

        $theParentId = WP_get_post_parent_id(get_the_ID());

        if($theParentId != 0){ ?>

          
          <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
              <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParentId); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParentId); ?></a> <span class="metabox__main"><?php the_title(); ?></span>
            </p>
          </div>

      <?php  }
 
      $testArray = get_pages(array(
        'child_of' => get_the_ID()
      ));
      if ($theParentId or $testArray){
      ?>

      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParentId); ?>"><?php echo get_the_title($theParentId); ?></a></h2>
        <ul class="min-list">
          <?php

          if ($theParentId){
            $findChildrenOf = $theParentId;
          } else{
            $findChildrenOf = get_the_ID();
          }

          wp_list_pages(array(
            'title_li' => NULL,
            'child_of' => $findChildrenOf,
            'sort_column' => 'menu_order'
          ));

          ?>
        </ul>
      </div>

      <?php }?>

      <div class="generic-content">
        <form class="search-form" method="get" action="<?php echo esc_url(site_url('/')); ?>">
            <label class="headline headline--medium" for="s">Perform a new search.</label>
            <div class="search-form-row">
                <input placeholder="What are you looking for?" class="s" id="s" type="search" name="s">
                <input class="search-submit" type="submit">
            </div>
        </form>
      </div>
    </div>

<?php  } get_footer(); ?>