<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;
?>


<div class="row">
	<div class="pprs-archive__header" <?php echo $background ?> >
		<h1 class="pprs-archive__title">
			<?php echo $title?>
		</h1>
        <nav class="pprs-archive__breadcrumb">
            <?php echo $breadcrumb ?>
        </nav>
	</div>
</div>
<div class="row">
	<div class="col-md-2 pprs-product__sidebar">
            <?php
            	dynamic_sidebar( 'archiveside' );

			
			?>
    </div>
    
	<div class="col-md-10 pprs-archive__products">
    
        <?php 
            $loop = new WP_Query( $args );
        ?>
        

        <?php
            $count = $loop->post_count;
            $plural = $count > 1 || $count < 1 ? "s" : "";
            $count_word = $count === 0 ? "No" : $count;
            $html = $count_word . " product" . $plural . " found in " . $breadcrumb;
        ?>
        <div class="row pprs-archive__page-title">
            <h2>
                <?php echo $html ?>
            </h2>
        </div>
        <?php
            if( $loop->have_posts() ):
        ?>
        <div class="row pprs-archive__products-wrapper">


            <?php
                while ( $loop->have_posts() ) : $loop->the_post();
                do_action( 'woocommerce_shop_loop' );
                get_template_part( 'woocommerce/content','product-tile' );
                endwhile;
            ?>
            
            <?php
                endif;
                wp_reset_query();
            ?>

        </div>
        <div class="row pprs-archive__pagination">
            <?php do_action( 'woocommerce_after_shop_loop' ); ?>
        </div>
    

            <?php
            /**
            * Hook: woocommerce_after_shop_loop.
            * @hooked woocommerce_pagination - 10
            */
            ?>


            <?php
            /**
            * Hook: woocommerce_after_main_content.
            *
            * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
            */
            do_action( 'woocommerce_after_main_content' );
            ?>


            <?php /**
            * Hook: woocommerce_sidebar.
            *
            * @hooked woocommerce_get_sidebar - 10
            */
            do_action( 'woocommerce_sidebar' );

            get_footer( 'shop' );

            ?>
    </div><!--Closing .col-md-10-->

</div> <!--Closing .row-->