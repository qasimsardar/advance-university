<?php get_header();

page_banner(array(
  'title' => 'All Events',
  'subtitle' => 'See the following events'
));

?>

<div class="container container--narrow page-section">

  <?php 


    while(have_posts()){
      the_post();

      get_template_part('template-parts/content-events');

     }

    echo paginate_links();
  ?>

<hr class="section-break">
  <p>Looking for a recap of Past Events <a href="<?php echo site_url('/past-events') ?>">Check out our past events archive</a></p>

</div>

<?php   get_footer(); ?>