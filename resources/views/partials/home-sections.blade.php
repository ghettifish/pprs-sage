<?php if( have_rows('home_sections') ): ?>

<?php while (have_rows('home_sections') ) : the_row();
                $link = get_sub_field('section_button_link'); 
                $background_img =  get_sub_field('section_background');
                $title_img = get_sub_field('section_image');
                $section_cats = get_sub_field("section_category");
                $background_img_link = $background_img['url'];
                $title_img_link = $title_img['url']?>

<div class="row py-5 my-5" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('<?php echo $background_img_link ?>')  no-repeat; background-size: cover;">

  <div class="col-sm-12 col-md-4">
    <div class="feature__product">
      <?php if(isset($title_img_link)):?>
        <img class="feature__img" src="<?php echo $title_img_link ?>"/> 
      <?php endif ?>
      <div>
        <h3 class="feature__title">
          <?php the_sub_field('section_title'); ?>
        </h3>
        <p class="feature__definition">
          <?php the_sub_field('section_description'); ?>
        </p>
        <?php if($link): ?>
        <a class="feature__btn" href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>">
          <?php the_sub_field('section_button_text') ?></a>
        <?php endif;?>
    </div>

    </div>
  </div>

  <div class="col">
      <ul class="woocommerce__section">
        <?php
                  $args = array(
                    'post_type'             => 'product',
                    'post_status'           => 'publish',
                    'ignore_sticky_posts'   => 1,
                    'posts_per_page'        => '12',
                    'tax_query'             => array(
                        array(
                            'taxonomy'      => 'product_cat',
                            'field' => 'term_id', //This is optional, as it defaults to 'term_id'
                            'terms'         => $section_cats,
                            'operator'      => 'AND' // Possible values are 'IN', 'NOT IN', 'AND'.
                        ),
                        array(
                            'taxonomy'      => 'product_visibility',
                            'field'         => 'slug',
                            'terms'         => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
                            'operator'      => 'NOT IN'
                        )
                    )
                  );
              $loop = new WP_Query( $args );
              if ( $loop->have_posts() ) {
                  while ( $loop->have_posts() ) : $loop->the_post();
                      wc_get_template_part( 'content', 'product-tile' );
                  endwhile;
              } else {
                  echo __( '<p class="woocommerce__no-products">No products found</p>' );
              }
              wp_reset_postdata();
          ?>
      </ul>
  </div>



</div>

<?php endwhile; ?>
<?php else:
        endif;