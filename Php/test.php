<?php 
require '/path/to/php-webdriver/__init__.php'; 
$webdriver = new WebDriver(); 
$session = $webdriver->session('opera', array()); 
$session->open("http://example.com"); 
$button = $session->element('id', 'my_button_id'); $button->click(); 
$session->close();
