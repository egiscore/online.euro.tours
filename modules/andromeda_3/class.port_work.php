<?php
 class port_work { protected $xml = null; protected $dr = null; private $_inputUser = array(); private $_inputAgentInfo = false; private $_inputXML = false; private $_outputXML = false; protected $answerValue = false; protected $function = false; protected $params = false; private $_models = array(); protected $TOWNFROM = null; protected $STATE = null; public function __construct() { $this->_loadTownFromState(); return true; } public function __destruct() { $this->_saveTownFromState(); return true; } public function handle($_inputXML, $_inputAgentInfo, $_inputUser) { $this->_inputUser = $_inputUser; $this->_parseAgentInfo($_inputAgentInfo); if (!$dom = LoadXML($this->_unCompress($_inputXML))) { throw new SoapFault(0, 'Error while parsing the WorkRequest', 'Client', 'PHP'); } $documentElement = documentElement($dom); foreach (childNodes($documentElement) as $node) { switch (nodeName($node)) { case 'proc': $this->function = $this->_parseFunction(getContent($node)); break; case 'params': $this->params = $node; break; } } if (!$this->params) { $this->params = $documentElement; } $this->xml = NewDomDocument(); $this->dr = appendChild($this->xml, createElement($this->xml, "WorkResponse")); $this->dr->setAttribute('version', $this->version); if (method_exists($this, $this->function)) { set_time_limit(0); $res = $this->{$this->function}(); if (!is_string($res) && is_soap_fault($res)) { throw $res; } } else { throw new SoapFault(0, 'Function ' . $this->function . ' not found.', 'Client', 'PHP'); } return $this->_enCompress($res); } private function _loadTownFromState() { if (defined('ANDR_SESSION_NAME')) { if (isset($_SESSION)) { if (array_key_exists('TOWNFROM', $_SESSION)) { $this->TOWNFROM = intval($_SESSION['TOWNFROM']); } if (array_key_exists('STATE', $_SESSION)) { $this->STATE = intval($_SESSION['STATE']); } } } else { $this->TOWNFROM = null; $this->STATE = null; } return true; } private function _saveTownFromState() { if (defined('ANDR_SESSION_NAME')) { if (!is_null($this->TOWNFROM)) { if (isset($_SESSION)) { $_SESSION['TOWNFROM'] = intval($this->TOWNFROM); } } if (!is_null($this->STATE)) { if (isset($_SESSION)) { $_SESSION['STATE'] = intval($this->STATE); } } } return true; } private function _parseAgentInfo($agentInfo) { if (!isset($agentInfo->user)) { $agentInfo->user = null; } $this->_inputAgentInfo = $agentInfo; $answer = @$agentInfo->answer; if ($answer) { $this->answerValue = $answer; } return true; } private function _parseFunction($function) { $this->function = trim(str_replace('_FOR_AGENT', '', str_replace('GET_', 'get', $function))); Samo_Debug_Helper::proctitle('Andromeda::' . $this->function); return $this->function; } private function _enCompress($data) { if (is_object($data)) { $this->_outputXML = SaveXML($data); } else { $this->_outputXML = $data; } $encode = $this->_compressType(); switch ($encode) { case 'none': $return = $this->_outputXML; break; case 'gzip': $return = base64_encode(gzencode($this->_outputXML, 5)); break; case 'zlib': $xml_len = strlen($this->_outputXML); $mask = 255; $xml_length = chr($xml_len & $mask); for ($i = 0; $i < 3; $i++) { $xml_len = $xml_len >> 8; $xml_length = $xml_length . chr($xml_len & $mask); } $return = base64_encode($xml_length . gzcompress($this->_outputXML, 5)); break; case 'aes': default: $return = base64_encode($this->_crypt()->encrypt(gzencode($this->_outputXML, 5))); break; } return $return; } private function _unCompress($data) { $encode = $this->_compressType(); switch ($encode) { case 'none': $this->_inputXML = $data; break; case 'gzip': $this->_inputXML = gzinflate(substr(base64_decode($data), 10, -8)); break; case 'zlib': $this->_inputXML = gzuncompress(base64_decode($data)); break; case 'aes': default: $data = base64_decode($data); $data = $this->_crypt()->decrypt($data); $data = gzinflate(substr($data, 10, -8)); $this->_inputXML = $data; break; } return $this->_inputXML; } private function _crypt() { if (!isset($this->_crypt)) { $this->_crypt = new Samo_CryptAes(); $this->_crypt->setKey($this->_inputUser['ClientSecret']); } return $this->_crypt; } protected function _compressType() { return (isset($this->_inputAgentInfo) && isset($this->_inputAgentInfo->encode) && ($this->_inputAgentInfo->encode)) ? $this->_inputAgentInfo->encode : 'aes'; } protected function _loadModel($alias) { if (!isset($this->_models[$alias])) { $m = Samo_Loader::load_class(__loadModel($alias)); $user = $this->_inputUser; if (isset($this->_inputAgentInfo->user)) { $user['Alias'] = strval($this->_inputAgentInfo->user); } $m = new $m($this->TOWNFROM, $user, $this->STATE); $this->_models[$alias] = $m; $this->_stats($m); } return $this->_models[$alias]; } protected function _getDomNodeContentXPath($expression, $default = null, $type = 'int', $parentDomNode = false) { $required = (false === $default) ? true : false; if (!$parentDomNode) { $parentDomNode = $this->params; } $tmp_obj = $parentDomNode->ownerDocument->EvalXPath($expression, $parentDomNode); if (!is_array($tmp_obj)) { $return = $this->_type($tmp_obj, $type); } elseif (count($tmp_obj) == 0) { if ($required) { throw new Andr_Exception(102, array($expression)); } else { $return = $this->_type($default, $type); } } else { $implode = true; $count = 0; foreach ($tmp_obj as $obj) { $count++; if (nodeType($obj) == XML_TEXT_NODE) { $p_val = nodeValue($obj); } else { if ((countChildNodes($obj) > 1) || (hasAttributes($obj))) { $implode = false; $p_val = $obj; } else { $p_val = getContent($obj); } } $return[] = $this->_type($p_val, $type); } $return = ($implode) ? (($count == 1) ? array_shift($return) : implode(',', $return)) : $return; } return $return; } protected function _type($value, $type) { if (is_null($value)) { $return = $value; } else { switch ($type) { case 'int': $return = (int)$value; break; case 'float': $return = (float)$value; break; case 'string': $return = (string)$value; break; case 'guid': if (!preg_match("/\{([0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12})\}/i", $value, $matches)) { $return = null; } else { $return = $matches[1]; } break; case 'boolean': case 'bool': $value = strval($value); $return = (('1' == $value) || ('true' == $value)) ? true : false; break; case 'date': $return = getDate112($value); break; default: $return = $value; break; } } return $return; } protected function _throwException($msg) { throw new Exception($msg); } protected function _stats($model) { static $saved = false; if (!$saved) { $client = ip2long(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0'); $module = 'andromeda'; $action = $this->function; $model->calc_stats($client, $module, $action); $saved = true; } } protected function _convert_packet_type($value) { if (1 == $value) { $value = 2; } elseif (2 == $value) { $value = 1; } return $value; } } 