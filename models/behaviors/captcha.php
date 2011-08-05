<?php

class CaptchaBehavior extends ModelBehavior {

	function setup(&$model, $config = array()) {
		$this->injectValidationRule(&$model);

		$this->settings[$model->alias] = Set::merge(array(
			'enabled' => true,
			), $config);

	}

	function injectValidationRule(&$model) {
		$model->validate['captcha_response_field'] = array(
			'validCaptcha' => array(
				'rule' => 'validCaptcha',
				'message' => 'Security code was incorrect',
				),
			);
	}

	function validCaptcha(&$model, $check) {
		if (property_exists($model, 'security_code')) {
			return $check['captcha_response_field'] == $model->security_code;
		}
		return false;
	}

}
