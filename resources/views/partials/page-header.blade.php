@php
$image_url = get_the_post_thumbnail_url(get_the_ID());
$style = "background:#544c5f;";
if( $image_url != null ) {
  $style = "background:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),url('$image_url')no-repeat; background-size: cover;";
}
@endphp
<div class="row">
    <div class="col-12 d-flex justify-content-center align-items-center page-header" 
    style={!! $style !!}
    >
        <h1 class="page-header__title">{{the_title()}}</h1>
    </div>
</div>