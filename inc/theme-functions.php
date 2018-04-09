<?php function banner_form($title, $form = null) {
	if($form === null){
		$form = '';
	}
?>
	<div class="banner-form">
		<div class="banner-form__tag">
			<p>Скидка -20%</p>
			<p>на 1-й заказ!</p>
		</div>
		<div class="banner-form__header">
			<p><?php echo $title; ?></p>
		</div>
		<div class="banner-form__content">
			<?php echo do_shortcode($form); ?>
		</div>
	</div>
<?php } ?>