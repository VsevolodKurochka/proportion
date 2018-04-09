<?php function banner_form($title, $form = null) {
	if($form === null){
		$form = '';
	}
?>
	<div class="banner-form">
		<div class="banner-form__tag">
			<?php echo get_field('banner_form_tag', 'option'); ?>
		</div>
		<div class="banner-form__header">
			<?php echo $title; ?>
		</div>
		<div class="banner-form__content">
			<?php echo do_shortcode($form); ?>
		</div>
	</div>
<?php } ?>