<?php

class CaptchaController extends SimpleCaptchaAppController {

	var $uses = array();
	var $components = array(
		'SimpleCaptcha.Captcha',
		);

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('image', 'check'));
		if ($this->action == 'check') {
			if (!empty($this->Security)) {
				$this->Security->validatePost = false;
				$this->Security->csrfCheck = false;
			}
		}
	}

	function image() {
		$this->autoRender = false;
		$width = 256;
		$height = 50;
		$numChars = 4;
		$this->Captcha->create($width, $height, $numChars);
	}

	function check() {
		$this->viewClass = 'Json';
		$code = $this->Session->read('security_code');
		$result = false;
		$field = Configure::read('SimpleCaptcha.fields.captcha_response_field');
		list($model, $field) = explode('.', $field);
		if (!empty($this->data[$model][$field])) {
			$result = $code == $this->data[$model][$field];
		}
		$this->set(compact('result'));
		$this->set('_serialize', 'result');
	}

}
