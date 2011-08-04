<?php

class CaptchaHelper extends AppHelper {

	var $helpers = array(
		'Html',
		'Js',
		);

	function beforeRender() {
		$params = $this->params;
		if (isset($params['isAjax']) && $params['isAjax'] === true) {
			return;
		}
		if (isset($params['admin']) && $params['admin'] === true) {
			return;
		}

		if (Configure::read('SimpleCaptcha.assets.autoLoad') !== false) {
			$this->Html->script('/simple_captcha/js/simple_captcha', false, array('once' => true, 'inline' => false));
			$this->Html->script('/simple_captcha/js/jquery.validate.min', false, array('once' => true, 'inline' => false));

			// setup events
			$script =<<<EOF
$('#captcha-container a.newimage').live('click', SimpleCaptcha.getNewImage);
SimpleCaptcha.addCaptchaValidation();
EOF;
			$this->Js->buffer($script);
		}
	}

}
