<footer class="footer">
    <div class="container">
      <div class="row">
        @if(is_active_sidebar('sidebar-footer-col1'))
            @php dynamic_sidebar( 'sidebar-footer-col1') @endphp
        @endif
        @if(is_active_sidebar('sidebar-footer-col2'))
            @php dynamic_sidebar( 'sidebar-footer-col2') @endphp
        @endif
        @if(is_active_sidebar('sidebar-footer-col3'))
          @php dynamic_sidebar( 'sidebar-footer-col3') @endphp
        @endif
      </div>
    </div>
      @if(is_active_sidebar('sidebar-footer-copyright'))
        @php dynamic_sidebar( 'sidebar-footer-copyright') @endphp
      @endif
</footer>