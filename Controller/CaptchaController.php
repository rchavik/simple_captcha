<?php

class CaptchaController extends SimpleCaptchaAppController {

	public $uses = array();
	public $components = array(
		'SimpleCaptcha.Captcha',
		);

	public $User = null;

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('image', 'check'));
		if ($this->action == 'check') {
			if (!empty($this->Security)) {
				$this->Security->validatePost = false;
				$this->Security->csrfCheck = false;
			}
		}
	}

	public function image() {
		$this->autoRender = false;
		$width = 256;
		$height = 50;
		$numChars = 4;
		$this->Captcha->create($width, $height, $numChars);
	}

	public function check() {
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
