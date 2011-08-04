var SimpleCaptcha = function() {
	var basePath = '/';
	var url = 'captcha';

	var getNewImage = function(ev) {
		var t = new Date();
		var $img = $('#captcha-image');
		var url = basePath + 'simple_captcha/captcha/image/ts:' + t.valueOf();
		$img.animate({opacity: 0 }, 'normal', 'linear', function() {
			$img
				.attr('src', url)
				.delay(800)
				.animate({opacity: 1}, 'normal')
				;
		});
	}

	var _loadPlugin = function() {
		if (typeof $.validator !== 'function') {
			var scriptTag = document.createElement('script');
			scriptTag.src = basePath + 'simple_captcha/js/jquery.validate.min.js';
			$('head').append(scriptTag);
		}
	}

	var addCaptchaValidation = function() {
		if (typeof $.validator !== 'function') {
			_loadPlugin();
		}
		var validCaptcha;
		var $form = $('form:has(".captcha")');
		var rules = {
			'data[User][captcha_response_field]': {
				required: true,
				remote: {
					url: SimpleCaptcha.basePath+ 'simple_captcha/captcha/check',
					type: 'post'
				}
			}
		};

		var messages = {
			'data[User][captcha_response_field]': {
				remote: 'Security code mismatch'
			}
		}

		var options = {
			rules: rules,
			messages: messages,
			focusInvalid: true,
			onkeyup: false
		};
		$.extend(true, $form.validate().settings, options);
	}

	return {
		basePath: basePath,
		getNewImage: getNewImage,
		addCaptchaValidation: addCaptchaValidation,
		init: function() { return this; }
	}
}().init(this);
