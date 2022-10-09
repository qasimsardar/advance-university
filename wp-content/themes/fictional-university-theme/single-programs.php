<?php get_header();
    while(have_posts()){
        the_post();
        page_banner();
?>

    <div class="container container--narrow page-section">

        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
              <a class="metabox__blog-home-link" href="<?php echo site_url('/programs'); ?>"><i class="fa fa-home" aria-hidden="true"></i>All Programs</a> <span class="metabox__main"><?php the_title(); ?></span>
            </p>
        </div>

      <div class="generic-content">
        <p><?php the_field('main_body_content'); ?></p>
      </div>

          <?php

            $relatedProfessors = new WP_Query(array(
              'posts_per_page' => -1,
              'post_type' => 'professors',
              'post_status' => 'publish',
              'orderby' => 'title',
              'order' => 'ASC',
              'meta_query' => array(
                array(
                  'key' => 'related_programs',
                  'compare' => 'LIKE',
                  'value' => '"' . get_the_id() . '"',
                )
              ),
            ));

            if ($relatedProfessors->have_posts()){
              echo '<hr class="section-break">';
              echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professor(s)</h2>';

              echo "<ul class='professor-cards'>";
              while($relatedProfessors->have_posts()){
                $relatedProfessors->the_post(); ?>
                <li class="professor-card__list-item">
                  <a class="professor-card" href="<?php the_permalink() ?>">
                  <img class="professor-card__img" src="<?php the_post_thumbnail_url('professorLandscape') ?>" alt="">
                  <span class="professor-card__name"><?php the_title() ?></span>
                  </a>
                </li>
              <?php
              }
              echo "</ul>";
            }

            wp_reset_postdata();

            $today = date('Ymd');
            $homepageEvents = new WP_Query(array(
              'posts_per_page' => -1,
              'post_type' => 'events',
              'post_status' => 'publish',
              'meta_key' => 'event_date',
              'orderby' => 'meta_value_num',
              'order' => 'ASC',
              'meta_query' => array(
                array(
                  'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'numeric',
                ),
                array(
                  'key' => 'related_programs',
                  'compare' => 'LIKE',
                  'value' => '"' . get_the_id() . '"',
                )
              ),
            ));

            if ($homepageEvents->have_posts()){
              echo '<hr class="section-break">';
              echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Event(s)</h2>';

              while($homepageEvents->have_posts()){
                $homepageEvents->the_post();
                get_template_part('template-parts/content-events');
              }
            }
            wp_reset_postdata();

            $relatedCampus = get_field('related_campus');

            if ($relatedCampus){
              echo '<hr class="section-break">';
              echo '<h2 class="headline headline--medium">'. get_the_title() . ' is available at following Campus(es)</h2>';
              echo "<ul class='link-list min-list'>";
              foreach($relatedCampus as $campus){ ?>
                <li><a href="<?php echo get_the_permalink($campus); ?>"><?php echo get_the_title($campus); ?></a></li>
              
              <?php }
              echo "<ul>";
            }

          ?>

    </div>

<?php  } get_footer(); ?>