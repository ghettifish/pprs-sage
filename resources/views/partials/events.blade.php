@php
    $args = array(
        'post_type' => 'events',
        'post_status' => 'publish',
        'posts_per_page' => '10'
    );
    $events_loop = new WP_Query( $args );
@endphp
<div class="event-container row justify-content-center">
    @if ( $events_loop->have_posts() )
        <div class="event-wrapper col-md-8 col-s-12">
                <h3 class="text-light">Upcoming events</h3>
            @while ( $events_loop->have_posts() ) @php($events_loop->the_post())
            <div class="event">
                <h3 class="event__title">{!! get_the_title() !!} | <span class="event__date">{!! get_field('event_date') !!}</span></h3>
                <p class="event__address">{!! get_field('event_address') !!}</p>
                <a href="{!!get_field('event_link')!!}" target="blank" class="event__button">Add to Calendar</a>
            </div>
            @endwhile
        </div>
    @php(wp_reset_postdata())
    @endif
</div>