<footer class="content-info">
  <div class="container">
    @php dynamic_sidebar('sidebar-footer') @endphp
  </div>
</footer>


<?php if(is_active_sidebar('footerfull')): ?>
	<div class="container">
		<?php dynamic_sidebar( 'footerfull');?>
	</div>
<?php endif;?>