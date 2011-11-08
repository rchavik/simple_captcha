<?php

Configure::load('SimpleCaptcha.simple_captcha');

Croogo::hookBehavior('User', 'SimpleCaptcha.Captcha');
Croogo::hookHelper('Users', 'SimpleCaptcha.Captcha');
Croogo::hookComponent('*', 'SimpleCaptcha.Captcha');
