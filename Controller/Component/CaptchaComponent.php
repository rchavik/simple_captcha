<?php
/**
	* Component for Generating Captcha	*
	* PHP versions 5.1.4
	* @filesource
	* @author     Arvind K. 
	* @link       http://www.devarticles.in/
	* @copyright  Copyright © 2008 www.devarticles.in
	* @version 0.0.1 
	*   - Initial release
	*/
class CaptchaComponent extends Component
{

	public $font = null;

	public $components = array(
		'Session',
		);

	function startup( &$controller ) {
		$this->Controller = $controller;
		if (!empty($controller->data['User']['captcha_response_field'])) {
			$controller->User->security_code = $this->Session->read('security_code');
		}
	}

	function generateCode($characters) {
		/* list all possible characters, similar looking characters and vowels have been removed */
		$possible = '2345678bcdfhjkmnpqrstvwxyz';
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
	}

	function create($width='120',$height='40',$characters='6') {

		if ($this->font == null) {
			$this->font = App::pluginPath($this->Controller->plugin) . DS . 'webroot' . DS . 'monofont.ttf';
		}

		$code = $this->generateCode($characters);
		/* font size will be 75% of the image height */
		$font_size = $height * 0.70;
		$image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');
		/* set the colours */
		$background_color = imagecolorallocate($image, 220, 220, 220);
		$text_color = imagecolorallocate($image, 10, 30, 80);
		$noise_color = imagecolorallocate($image, 150, 180, 220);
		/* generate random dots in background */
		for( $i=0; $i<($width*$height)/3; $i++ ) {
			imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
		}
		/* generate random lines in background */
		for( $i=0; $i<($width*$height)/150; $i++ ) {
			imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
		}
		/* create textbox and add text */
		$textbox = imagettfbbox($font_size, 0, $this->font, $code) or die('Error in imagettfbbox function');
		$x = ($width - $textbox[4])/2;
		$y = ($height - $textbox[5])/2;
		$y -= 5;
		$slope = rand(3, 8);
		$slope = rand(0,1) == 1 ? $slope : -$slope;
		imagettftext($image, $font_size, $slope, $x, $y, $text_color, $this->font , $code) or die('Error in imagettftext function');
		/* output captcha image to browser */
		header('Content-Type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
		
		$this->Controller->Session->write('security_code',$code);
	}

	function getVerCode()	{
		return $this->Controller->Session->read('security_code');
	}
}