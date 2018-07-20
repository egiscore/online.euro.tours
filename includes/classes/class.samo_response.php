<?php
 class Samo_Response { private $format = 'html'; private $output = ''; private $headers = array(); private $js_buffer = ''; public $charset = 'windows-1251'; private $_headers_sent = false; protected $_content_types = array(); protected $buffer_response = false; protected $buffer = ''; public function __construct() { if (Samo_Request::requested_with() == 'XMLHttpRequest' || Samo_Request::http_accept('text/javascript') || Samo_Request::get('is_js') == 1 || Samo_Request::intval('agency') || Samo_Request::get('samo_action') == 'embed') { $this->respond_to('js'); } $this->headers('P3P', 'CP="NOI DSP COR NID ADMa OPTa OUR NOR"'); } public function headers($params = null, $value = null, $status = null) { if (null !== $params) { if (is_array($params)) { foreach ($params as $param => $value) { $status = is_array($value) ? $value['status'] : null; $value = is_array($value) ? $value['value'] : $value; $this->headers($param, $value, $status); } } else { if (null !== $value && false !== $value) { $this->headers[$params] = ['value' => $value, 'status' => $status]; } else { if (array_key_exists($params, $this->headers)) { unset($this->headers[$params]); } } } } } private function content_type($format) { $content_types = array( 'html' => 'text/html; charset=' . $this->charset, 'js' => 'text/javascript; charset=' . $this->charset, 'js-api' => 'text/javascript; charset=' . $this->charset, 'json' => 'application/json; charset=' . $this->charset, 'xml' => 'text/xml; charset=' . $this->charset, 'text' => 'text/plain; charset=' . $this->charset, 'iframe-js' => 'text/plain; charset=' . $this->charset, 'gif' => 'image/gif', ); if (!array_key_exists($format, $content_types)) { $format = 'html'; } return $content_types[$format]; } public function redirect_to($url) { if ('js' == $this->format) { $this->output('location.href="' . $url . '";'); } else { $this->headers('Location', $url, 301); $this->headers_sent(true); } $this->finish(); } public function refresh() { if ('js' == $this->format) { $this->output('window.location.reload();'); } else { $uri = str_replace('samo_action=LOGOUT', '', Samo_Request::uri()); $this->headers('Location', $uri, 301); $this->headers_sent(true); } $this->finish(); } public function respond_to($format = null) { if (null !== $format) { $this->format = $format; if ($this->format != 'html') { ini_set('html_errors', 0); } } return $this->format; } public function respond_to_js() { return in_array($this->format, ['js', 'iframe-js', 'json', 'js-api']); } public function output($output = null) { if (null !== $output) { $this->output = $output; } $respond = $this->respond_to(); if (!in_array($respond, ['xml', 'gif'])) { if (!in_array($respond, ['json', 'js-api'])) { $registry = Samo_Registry::instance(); if (isset($registry['logger'])) { $logger = $registry['logger']; $logger->flush(); } } if (!empty($this->js_buffer)) { if (!in_array($respond, ['json', 'js-api'])) { $this->js_buffer = '(function(){if (typeof samo === "undefined") { samo = {}; }' . $this->js_buffer . '})();'; } if ($this->respond_to_js()) { $this->output .= $this->js_buffer; } else { $script_tag = '<script charset="' . $this->charset . '" type="text/javascript">' . $this->js_buffer . '</script>'; if (strpos($this->output, '<!--@@AS_JS@@-->') !== false) { $this->output = strtr($this->output, array('<!--@@AS_JS@@-->' => $script_tag)); } else { $this->output .= $script_tag; } } $this->js_buffer = ''; } } if (!$this->headers_sent() && !$this->buffer_response) { $etag_private = array(); foreach (array('pSTATEINC', 'pTOWNFROMINC', 'pCURRENCY') as $field) { $etag_private[] = (isset($_COOKIE[$field])) ? intval($_COOKIE[$field]) : 0; } $etag = md5($this->output . implode(',', $etag_private)); $this->headers('ETag', $etag); if (Samo_Request::if_match() == $etag) { $this->not_modified(); } if (!isset($this->headers['Content-type'])) { $this->headers('Content-type', $this->content_type($this->format)); } $this->headers_sent(true); } if ($this->buffer_response) { $this->buffer = $this->output; } else { echo $this->output; flush(); } $this->output = ''; return $this->buffer; } public function flush($content = null) { $this->output($content); $this->finish(); } public function _buffer($content = null) { if (null !== $content) { $this->output = $content; } else { $this->buffer_response = true; $content = $this->output(); $this->buffer_response = false; } return $content; } public function as_text($richtext) { $this->output .= strip_tags($richtext); } public function as_xml($src) { $this->format = 'xml'; $this->charset = 'UTF-8'; $this->output = $src; } public function as_html($html) { if (!$this->respond_to_js()) { $this->output .= $html; } } public function as_js($js, $prepend = false) { if (strlen($js)) { $delimeter = in_array($this->respond_to(), ['json', 'js-api']) ? '' : ';'; $js = str_replace("\'", "\\'", $js) . $delimeter; if ($prepend) { $this->js_buffer = $js . $this->js_buffer; } else { $this->js_buffer .= $js; } } } public function headers_sent($trigger = null) { if (null !== $trigger) { if (!$this->_headers_sent) { foreach ($this->headers as $key => $value) { header($key . ': ' . $value['value'], null !== $value['status'], $value['status']); unset($this->headers[$key]); } } $this->_headers_sent = true; } return $this->_headers_sent; } public function save_pref($name, $value, $cookie_path = WWWROOT) { if (!$this->headers_sent()) { return setcookie($name, $value, COOKIE_EXPIRE, $cookie_path, COOKIE_DOMAIN, false, true); } return false; } public function download($file, $content_type = 'application/octet-stream', $name = null) { if (ob_get_level()) { while (@ob_end_clean()) { null; } } $name = (null === $name) ? basename($file) : $name; $this->headers( [ 'Content-type' => $content_type, 'Content-transfer-encoding' => '8bit', 'Content-Disposition' => 'attachment; filename="' . $name . '"', 'Pragma' => 'cache', 'Expire' => 0, 'Cache-Control' => 'private', 'Connection' => 'close', ] ); $this->headers_sent(true); readfile($file); $this->finish(); } public function unauthorized($output = 'Unauthorized') { header(Samo_Request::sapi_status() . ' 401 Unauthorized', true, 401); $this->output($output); $this->finish(); } public function not_found() { header(Samo_Request::sapi_status() . ' 404 Not Found', true, 404); $this->output('page not found'); $this->finish(); } public function not_modified() { header(Samo_Request::sapi_status() . ' 304 Not Modified', true, 304); $this->finish(); } public function modified_at($time) { $this->headers('Last-Modified', gmdate('D, d M Y H:i:s', $time) . ' GMT'); } public function finish() { if (!defined('SAMO_REQUEST_DONT_FINISH')) { if (function_exists('fastcgi_finish_request')) { fastcgi_finish_request(); } else { flush(); } exit; } } } 