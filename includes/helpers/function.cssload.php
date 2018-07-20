<?php
 function smarty_function_cssload($params, & $smarty) { $HOST = (defined('ASSETS_HOST')) ? ASSETS_HOST : Samo_Request::host(); $currentWwwroot = $smarty->getTemplateVars('WWWROOT'); $WWWROOT = ($smarty->getTemplateVars('INTERNAL_FULL_PATHS') && strpos($currentWwwroot, 'http') !== 0) ? Samo_Request::scheme() . '://' . $HOST . $currentWwwroot : $currentWwwroot; $smarty->loadPlugin('smarty_shared_fileversion'); if (!isset($params['file']) || !strlen($params['file'])) { throw new Exception('cssload: param "file" not set'); } $base = (isset($params['base']) && file_exists(_ROOT . $params['base']) && is_dir(_ROOT . $params['base'])) ? $params['base'] : '/public/css/'; $base = ($_base = trim($base, '/ ')) && !empty($_base) ? $_base . '/' : ''; $module_version = (isset($params['module_version'])) ? $params['module_version'] . '_' : (($smarty->moduleVersion) ? $smarty->moduleVersion . '_' : ''); $files = explode(',', $params['file']); $result = ''; $required = (isset($params['required'])) ? (bool)$params['required'] : true; foreach ($files as $file) { $file = trim($file, '/ '); if ($module_version) { $module_name = str_replace('.css', '', $file); $file = $module_name . '/' . $module_version . $module_name . '.css'; if (!file_exists(_ROOT . $base . $file)) { $file = $module_name . '.css'; } } $realFile = _ROOT . $base . $file; if (file_exists($realFile) && is_file($realFile)) { $versionedFile = $file . smarty_fileversion($realFile); $path = $WWWROOT . $base . $versionedFile; $result .= '<link rel="stylesheet" type="text/css" href="' . $path . '"/>' . PHP_EOL; } elseif ($required) { throw new Exception('cssload: file ' . $file . ' not exists'); } } return $result; } 