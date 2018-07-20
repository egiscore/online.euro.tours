<?php
function smarty_function_note($params, & $smarty) { $what = Samo_Utils::ifs($params['page'], Samo_Request::get('target'), Samo_Request::get('page'), 'menu'); $section = (isset($params['section'])) ? $params['section'] : 'notes'; $townFrom = Samo_Utils::ifs($params['townfrom'], Samo_Request::intval('TOWNFROMINC')); $state = Samo_Utils::ifs($params['state'], Samo_Request::intval('STATEINC')); $tour = Samo_Utils::ifs($params['tour'], Samo_Request::intval('TOURINC')); $include = isset($params['include']) && $params['include']; $assign = isset($params['assign']) && !empty($params['assign']) ? $params['assign'] : false; $ttl = isset($params['ttl']) && !empty($params['ttl']) ? intval($params['ttl']) : 600; $registry = Samo_Registry::instance(); $cache = isset($registry['cache']) ? $registry['cache'] : new Samo_Cache(); $is_admin = Samo_Request::is_admin(); $params = [ 'Section' => $section, 'What' => $what, 'TownFrom' => $townFrom, 'State' => $state, 'Tour' => $tour, 'UserCode' => (defined('INTERNET_USER')) ? INTERNET_USER : (array_key_exists('INTERNET_USER', $registry) ? $registry['INTERNET_USER'] : null), ]; $cache_key = 'notes_' . implode('_', $params); if ($is_admin || false === ($tpl = $cache->get($cache_key))) { if (!isset($registry['db']) || $registry['db'] instanceof Database_Stub) { return null; } if (isset($registry['db'])) { $db = $registry['db']; $dbname = ($is_admin) ? '<OFFICEDB>' : '<ONLINEDB>'; if (null === $params['UserCode']) { $params['UserCode'] = $db->fetchOne('<ONLINEDB>.dbo.up_WEB_3_default_usercode'); } $sql = $db->formatExec($dbname . '.dbo.up_WEB_3_tour_config', $params); if (false !== ($tpl = $db->fetchOne($sql))) { $cache->set($cache_key, $tpl, $ttl); } } } $result = ($tpl) ? $smarty->fetch('string:' . $tpl) : ''; if (!$include) { $result = '<div class="note">' . $result . '</div>'; } if ($assign) { $smarty->assign($assign, $result); $result = null; } return $result; } 