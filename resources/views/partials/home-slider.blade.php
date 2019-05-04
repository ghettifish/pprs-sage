<div class="container-fluid">
    <div class="pprs-slider row">
        <?php if( have_rows('slides') ): ?>
            <?php while (have_rows('slides') ) : the_row();
                // $slide_content = get_sub_field('slide_content'); 
                $img_link = get_sub_field('background_image')['url'];
            ?>
            <div class="pprs-slider__slide" style="background: url(<?php echo $img_link;?>)  no-repeat; background-size: cover;">
                <div class="col-12 pprs-slider__content">
                    <?php the_sub_field('slide_content') ?>
                </div>
            </div>   
            <?php endwhile;?> 
        <?php endif;?> 

    </div><!-- End .row-->
</div> <!-- End .container-fluid -->


<?php 
// echo $img_link 
?>