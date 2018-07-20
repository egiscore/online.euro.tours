<?php
 use Phalcon\Exception as Ex; use Phalcon\Http\Request; use Monolog\Logger; class Core { public static function decodeCP1251ToUtf8(&$content) { $content = iconv('CP1251', 'UTF-8', $content); } public static function decodeUtf8ToCP1251(&$content) { $content = iconv('UTF-8', 'CP1251', $content); } public static function getHash($data = null, $hashType = 'md5') { return self::$hashType($data); } public static function getCONST($name) { return defined($name) ? constant($name) != '' ? constant($name) : null : null; } public static function isNull($var) { return $var === null; } public static function notNull($var) { return $var !== null; } private static function md5($data) { return md5($data); } private static function md5_file($path) { if ($path && $path !== null && file_exists($path)) { return md5_file($path); } } public static function replaceDbIp(&$ip, $hostname) { $separator = extension_loaded('sqlsrv') ? ',' : ':'; return str_replace( [',', ':', '<hostname>'], [$separator, $separator, $hostname], $ip ); } public static function resetOpcache($file = null) { if (null !== $file) { clearstatcache($file); } if (function_exists('apc_clear_cache') && !extension_loaded('apcu')) { if (null !== $file) { @apc_delete_file($file); } else { apc_clear_cache('opcode'); } } if (function_exists('opcache_reset')) { if (null !== $file) { opcache_invalidate($file, true); } else { opcache_reset(); } } if (function_exists('xcache_clear_cache')) { xcache_clear_cache(XC_TYPE_PHP); } if (function_exists('wincache_refresh_if_changed')) { if (null !== $file) { wincache_refresh_if_changed([$file]); } else { wincache_refresh_if_changed(); } } if (function_exists('eaccelerator_clear')) { eaccelerator_clear(); } if (function_exists('accelerator_reset')) { accelerator_reset(); } } public static function getObject($className, ...$args) { if (class_exists($className) || interface_exists($className)) { if (count($args)) { $reflector = new ReflectionClass($className); $obj = $reflector->newInstanceArgs($args); } else { $obj = new $className; } return $obj; } throw new Ex("Class {$className} not exist!"); } public static function removeFiles($dir, $mask, $fileMTime = null) { $timeOut = 25; $pwd = getcwd(); if (file_exists($dir) && chdir($dir)) { $request = new Request(); $start = $request->getServer('REQUEST_TIME'); $i = 0; $path = "{$dir}/{$mask}"; $flags = FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS; $iterator = new GlobIterator($path, $flags); foreach ($iterator as $fileInfo) { if ($fileInfo->isFile() && (null === $fileMTime || $fileInfo->getMTime() < $fileMTime)) { @unlink($fileInfo->getPathname()); } $i++; if ($i % 100 === 0 && $timeOut <= time() - $start) { break; } } chdir($pwd); } else { throw new Ex("Directory {$dir} not exist", Logger::PHP_HANDLE); } } public static function getServersCache() { include TOWNSFROM_CACHE; array_walk_recursive( $TOWNSFROM, function (&$value, $key) { self::decodeCP1251ToUtf8($value); } ); return $TOWNSFROM; } } 