<?php function banner_form($title, $form = null, $class = null, $tag = 'tag-true') {
	if($form === null){
		$form = '';
	}
?>
	<div class="banner-form <?php echo $class; ?>">
		<?php if($tag == 'tag-true') : ?>
			<div class="banner-form__tag">
				<?php echo get_field('banner_form_tag', 'option'); ?>
			</div>
		<?php endif; ?>
		<div class="banner-form__header">
			<?php echo $title; ?>
		</div>
		<div class="banner-form__content">
			<?php echo do_shortcode($form); ?>
		</div>
	</div>
<?php } ?>


<?php function vegetable_icon($class, $icon) { ?>
	<img src="<?php echo get_template_directory_uri(); ?>/static/build/img/<?php echo $icon; ?>" class="decor <?php echo $class ?>">
<?php } ?>