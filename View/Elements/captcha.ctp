<?php

$captchaUrl = array(
	'plugin' => 'simple_captcha',
	'controller' => 'captcha',
	'action' => 'image',
	);

?>
<div id='captcha-container' class='input captcha'>
	<label><?php echo __d('eventq', 'Security Code'); ?></label>
	<?php

	echo $this->Html->image($this->Html->url($captchaUrl, true), array(
		'id' => 'captcha-image',
		'class' => 'captcha',
		));

	?>
	<div class="hint">
	<?php
	$txt1 = __d('simple_captcha', 'Image not readable?');
	$txt2 = $this->Html->link(__d('simple_captcha', 'Get a new image'), 'javascript:;', array('class' => 'newimage'));
	echo sprintf('%s %s', $txt1, $txt2);
	?>
	</div>

	<?php

	echo $this->Form->input('captcha_response_field', array(
		'id' => 'captcha_response_field',
		'label' => __d('eventq', 'Put security code here'),
		'autocomplete' => 'off',
		));

	?>
</div>
