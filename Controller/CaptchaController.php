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
		$this->autoRender = false;
		$this->layout = 'ajax';
		$code = $this->Session->read('security_code');
		$result = false;
		if (!empty($this->data['User']['captcha_response_field'])) {
			$result = $code == $this->data['User']['captcha_response_field'];
		}
		Configure::write('debug', 0);
		header('Content-Type: application/json');
		echo $result ? 'true' : 'false';
	}

}
