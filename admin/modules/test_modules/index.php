<?php get_help_button('onlinest:sistema_upravlenija:test') ?>
<?php
 if (!defined('ROUTES_PATH')) { define('ROUTES_PATH',_ROOT.'routes.php'); } include_once ROUTES_PATH; $test_modules = array(); if (!defined('FRIENDLY_URLS')) { define('FRIENDLY_URLS', isset($_SERVER['FRIENDLY_URLS']) && $_SERVER['FRIENDLY_URLS'] == 1); } $flag = false; foreach ($routes as $module => $info) { if (isset($info['test'])) { $flag = true; echo '<li><a href="'.get_link($info,$module).'" target="_blank">'.$info['title']. '</a></li>'; } } if(!$flag){ echo (Get_Message_Lang($LNG, 'adm_test_modules_no_modules')); } function get_link($info,$module) { if (isset($info['uses']) && in_array('cl_refer',$info['uses'])) { $module = 'cl_refer'; } if (!isset($info['url'])) { $info['url'] = (FRIENDLY_URLS) ? WWWROOT . $module : WWWROOT. 'default.php?page='. $module; } return $info['url']; } ?>