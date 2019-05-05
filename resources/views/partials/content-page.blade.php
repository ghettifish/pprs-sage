<div class="row">
    <div class="col-12">
        <div class="pprs-content">
            @php the_content() @endphp
        </div>
    </div>
</div>
{!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
