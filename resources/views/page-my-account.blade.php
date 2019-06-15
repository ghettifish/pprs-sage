@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @if(is_user_logged_in())
      @include('partials.page-header')
    @endif
    @include('partials.content-page')
  @endwhile
@endsection
