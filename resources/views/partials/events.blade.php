<div class="event-container">
    <?php
    $args = array(
        'post_type' => 'events',
        'post_status' => 'publish',
        'posts_per_page' => '10'
      );
      $events_loop = new WP_Query( $args );
        if ( $events_loop->have_posts() ) :?>
        <div class="event-wrapper">
                <h3 class="text-light">Upcoming events</h3>
            <?php while ( $events_loop->have_posts() ) : $events_loop->the_post();
            // Set variables
            $title = get_the_title();
            $event_address = get_field('event_address');  
            $event_date = get_field('event_date'); 
            $event_link = get_field('event_link');
            // Output
            ?>
            <div class="event">
                <h3 class="event__title"><?php echo $title; ?> | <span class="event__date"><?php echo $event_date; ?></span></h3>
                <p class="event__address"><?php echo $event_address; ?></p>
                <a href="<?php echo $event_link; ?>" target="blank" class="event__button">Add to Calendar</a>
            </div>
            <?php endwhile; ?>
        </div>
    <?php
    
        wp_reset_postdata();
        endif;
    ?>
    </div>