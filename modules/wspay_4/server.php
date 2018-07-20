<?php
 ini_set('display_errors', 0); error_reporting(0); include_once '../../properties.php'; include_once _ROOT . 'includes/classes/class.samo_config.php'; Samo_Loader::register_autoload(); define('WSPAY_WSDL_URL', 'online.samo.ru_xml_wspay.wsdl'); if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') { ini_set("soap.wsdl_cache_dir", SMARTY_COMPILE_DIR); ini_set("soap.wsdl_cache_enabled", "1"); $server = new SoapServer(WSPAY_WSDL_URL); $logger = Samo_Loader::load_object('WSPAY_Logger'); $logger->init(); try { include_once 'lib.php'; $db = connectdb(); $model = Samo_Loader::load_object('WSPAY_model', $db); $service = Samo_Loader::load_object('WSPAY_service', $model, $logger); $server->setObject($service); ob_start(); $server->handle(); $response = ob_get_contents(); ob_end_clean(); $logger->commit($response); echo $response; } catch (Exception $e) { $code = $e->getCode(); $message = $e->getMessage(); $trace = (DEBUG) ? PHP_EOL . $e->getTraceAsString() . PHP_EOL : null; switch (get_class($e)) { case 'WSPAY_exception': break; case 'DatabaseServer_Exception': $code = 1; break; default: $code = 0; $message = 'Unknown error'; break; } $logger->error($message, $code); $message = strConv($message); header('SoapFault: ' . $message); $response = sprintf( '<?xml version="1.0" encoding="UTF-8"?>
            <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
                <SOAP-ENV:Body>
                    <SOAP-ENV:Fault>
                        <faultcode>%d</faultcode>
                        <faultstring>%s</faultstring>
                        <faultactor></faultactor>
                        <detail>%s</detail>
                    </SOAP-ENV:Fault>
                </SOAP-ENV:Body>
            </SOAP-ENV:Envelope>', $code, $message, $trace ); $logger->commit($response); $server->fault($code, $message, null, $trace); } } else { $location = Samo_Request::scheme() . '://' . Samo_Request::host() . WWWROOT . 'modules/wspay_4/server.php?' . $_SERVER['QUERY_STRING']; $wsdl = file_get_contents(WSPAY_WSDL_URL); $wsdl = preg_replace('~(<soap:address location=")([^"]*)("\/>)~', '$1' . htmlspecialchars($location) . '$3', $wsdl); header('Content-Type: text/xml'); echo $wsdl; } 