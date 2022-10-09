<?php 

if (!is_user_logged_in()){
  wp_redirect(esc_url(site_url('/')));
  exit;
}

get_header();

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

    <div class="create-note">
      <h2 class="headline headline--medium">Create New Note</h2>
      <input class="new-note-title" type="text" name="" id="" placeholder="Title">
      <textarea class="new-note-body" name="" id="" cols="30" rows="10" placeholder="Your Note Here..."></textarea>
      <span class="submit-note">Create Note</span>
      <span class="note-limit-message">Note limit reached: Delete exisiting note to make room for new one.</span>
    </div>

    <ul class="min-list link-list" id="my-notes">

    <?php

    $userNotes = new WP_Query(array(
      'post_type' => 'notes',
      'posts_per_page' => -1,
      'author' => get_current_user_id()
    ));

    while ($userNotes->have_posts()){
      $userNotes->the_post(); ?>

      <li data-id="<?php the_ID(); ?>">
        <input readonly class="note-title-field" value="<?php echo esc_attr(get_the_title()); ?>" type="text" name="" id="">

        <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>

        <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>

        <textarea readonly class="note-body-field" name="" id="" cols="30" rows="10"><?php echo esc_textarea (wp_strip_all_tags(get_the_content())); ?></textarea>

        <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
      </li>

      <?php

    }

    ?>

    </ul>
      
    </div>

<?php  } get_footer(); ?>
