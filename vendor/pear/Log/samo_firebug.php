<?php

class Log_samo_firebug extends Log {
    private $_buffer = array();
    private $_lineFormat = '%4$s';
    private $enabled = false;
    private $banner = '';
    protected $_timeFormat = '%b %d %H:%M:%S';
    public $_methods = array(
                        PEAR_LOG_EMERG   => 'error',
                        PEAR_LOG_ALERT   => 'error',
                        PEAR_LOG_CRIT    => 'error',
                        PEAR_LOG_ERR     => 'error',
                        PEAR_LOG_WARNING => 'warn',
                        PEAR_LOG_NOTICE  => 'info',
                        PEAR_LOG_INFO    => 'info',
                        PEAR_LOG_DEBUG   => 'debug'
                    );
    public function __construct($name = '', $ident = 'SAMO', $conf = array(), $level = PEAR_LOG_DEBUG) {
        $this->_id = md5(microtime() . rand());
        $this->_ident = $ident;
        $this->_mask = Log::MAX($level);
        if (defined('APPMODE') && in_array(APPMODE,array('dev','test'))) {
            if ((APPMODE == 'test' && Samo_Request::is_developer()) || APPMODE == 'dev') {
                $this->enabled = true;
                $logMode = APPMODE == 'dev' ? 'warn' : 'log';
                $this->banner .= sprintf("console.%s('%s')",$logMode,'DEBUG MODE ENABLED!').";";
                if (APPMODE == 'dev' && Samo_Request::is_developer() && !defined('CUSTOM')) {
                    $this->banner .= sprintf("console.%s('%s')",'error','Change APPMODE to "test"').";";
                }
                if (defined('CUSTOM')) {
                    $msg = 'Enabled custom: '.CUSTOM;
                    if (defined('CUSTOM_DB') && CUSTOM_DB) {
                        $msg .= ", used customer\'s SQLServers";
                    }
                    $this->banner .= sprintf("console.%s('%s')",$logMode,$msg).";";
                }
                if (defined('LANG') || !defined('LANGS')) {
                    $this->banner .= sprintf("console.%s('%s')",'error','Replace constant LANG with LANGS').";";
                }
                foreach (['data/hotelparam', 'data/spool', 'dnl', 'data/partner', 'data/hotel', 'data/search_tour'] as $dir) {
                    if (!file_exists(_ROOT . $dir)) {
                        $this->banner .= sprintf("console.%s('%s')",'error','Directory "' . $dir . '" is not exists').";";
                    } elseif (!is_writable(_ROOT . $dir)) {
                        $this->banner .= sprintf("console.%s('%s')",'error','Directory "' . $dir . '" is not writable').";";
                    }
                }
            }
        }        
        if (!empty($conf['lineFormat'])) {
            $this->_lineFormat = str_replace(
                array_keys($this->_formatMap),
                array_values($this->_formatMap),
                $conf['lineFormat']
            );
        }
    }
    public function open() {
        $this->_opened = true;
        return true;
    }
    public function close() {
        $this->flush();
        $this->_opened = false;
        return true;
    }
    public function flush() {
        $result = $this->output();
        Samo_Registry::get('response')->as_js($result);
    }
    public function output() {
        $result = '';
        $action = array();
        $action[] = (isset($_GET['page'])) ? $_GET['page'] : 'unknown';
        $action[] = (isset($_GET['samo_action'])) ? $_GET['samo_action'] : 'default';
        if (in_array($action[1],array('embed','default')) && $this->banner) {
            $result = 'if (window.console) {'.$this->banner.'}';
            $this->banner = '';
        }
        if (count($this->_buffer)) {
            if ('embed' == $action[1] && isset($_GET['embed_action'])) {
                $action[] = $_GET['embed_action'];
            }
            if ('proxy_action' == $action[1] && isset($_GET['proxy_action'])) {
                $action[] = $_GET['proxy_action'];
            }
            $result .= "if (window.console) { console.group('" . implode('::', $action)."');";
            foreach ($this->_buffer as $line) {
                $result .= "  $line\n";
            }
            $result .= "console.groupEnd(); }";
        }
        $this->_buffer = array();
        return $result;
    }
    public function dump($obj) {
        $this->_buffer[] = sprintf('console.dir(%s);', Samo_Registry::get('view')->json_encode($obj));
    }
    public function pretty_dump($obj,$name = null) {
        $obj = (array)$obj;
        $format = is_numeric(current(array_keys($obj))) ? '%s' : '[%s]';
        if ($name) {
            $this->_buffer[] = sprintf('console.groupCollapsed(%s);', Samo_Registry::get('view')->json_encode($name));
        }
        $this->_buffer[] = sprintf('console.table('.$format.');', Samo_Registry::get('view')->json_encode($obj));
        if ($name) {
            $this->_buffer[] = sprintf('console.groupEnd();');
        }
    }
    public function log($message, $priority = null) {
        /* If a priority hasn't been specified, use the default value. */
        if (!$this->enabled) {
            return false;
        }
        if ($priority === null) {
            $priority = $this->_priority;
        }

        if (!$this->_isMasked($priority)) {
            return false;
        }
        $message = $this->_extractMessage($message);
        $method  = $this->_methods[$priority];
        
        /* normalize line breaks */
        $message = str_replace("\r\n", "\n", $message);
        
        /* escape line breaks */
        $message = str_replace("\n", "\\n\\\n", $message);
        
        /* escape quotes */
        $message = str_replace('\"', '"', $message);
        $message = str_replace('"', '\\"', $message);

        /* Build the string containing the complete log line. */
        $line = $this->_format(
            $this->_lineFormat,
            strftime($this->_timeFormat),
            $priority,
            $message
        );

        $this->_buffer[] = sprintf('console.%s("%s");', $method, $line);       
        /* Notify observers about this log message. */
        $this->_announce(array('priority' => $priority, 'message' => $message));

        return true;
    }

}
