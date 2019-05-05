<div 
class="pprs-slider row" 
id="pprs-slider"
>
    <?php if( have_rows('slides') ): ?>
        <?php while (have_rows('slides') ) : the_row();
            // $slide_content = get_sub_field('slide_content'); 
            $img_link = get_sub_field('background_image')['url'];
        ?>
        <div 
            class="pprs-slider__slide" 
            style="
                background:
                linear-gradient(
                    {!!the_sub_field('gradient_top')!!},
                    {!!the_sub_field('gradient_bottom')!!}
                    ), 
                    url({!!$img_link!!})  no-repeat; 
                background-size: cover;
            "
        >
            <div class="col-12 pprs-slider__content text-center">
                <p class="pprs-slider__sub-text">{!!the_sub_field('sub_text')!!}</p>
                <p class="pprs-slider__main-text">{!!the_sub_field('main_text')!!}</p>
               <a href="{!!the_sub_field('cta-url')!!}" class="pprs-slider__btn">
                {!!the_sub_field('cta-text')!!}
                </a>
            </div>
        </div>   
        <?php endwhile;?> 
    <?php endif;?> 

</div><!-- End .row-->



<?php 
// echo $img_link 
?>