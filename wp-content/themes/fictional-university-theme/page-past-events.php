<?php get_header(); 

page_banner(array(
  'title' => 'Past Events',
  'subtitle' => 'See the following events',
));

?>

<div class="container container--narrow page-section">

<?php
            $today = date('Ymd');
            $pastEvents = new WP_Query(array(
              'post_type' => 'events',
              'post_status' => 'publish',
              'meta_key' => 'event_date',
              'orderby' => 'meta_value_num',
              'order' => 'ASC',
              'meta_query' => array(
                array(
                  'key' => 'event_date',
                  'compare' => '<',
                  'value' => $today,
                  'type' => 'numeric',
                ),
              ),
            ));

            while($pastEvents->have_posts()){
              $pastEvents->the_post();
              get_template_part('template-parts/content-events');
            }
          ?>

</div>

<?php   get_footer(); ?>