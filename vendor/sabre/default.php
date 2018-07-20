<?php
    $__cleanup__ = array();
    register_shutdown_function(function(){
       if (count($GLOBALS['__cleanup__'])) {
           foreach($GLOBALS['__cleanup__'] as $file) {
               unlink($file);
           }
       }
    });
    function safe_include($path) {
        $file = tempnam(sys_get_temp_dir(), basename($path));
        $GLOBALS['__cleanup__'][] = $file;
        copy($path,$file);
        include $file;
    }

    $_root = realpath(__DIR__.'/../../');
    safe_include($_root.'/properties.php');
    if (!DEBUG) {
        header(('cgi' == php_sapi_name()) ? 'Status:' : ((isset($_SERVER['SERVER_PROTOCOL'])) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0').' 404 Not Found',true,404);
        exit;
    }

    safe_include($_root.'/includes/classes/class.samo_datetime.php');
    safe_include($_root.'/includes/classes/class.samo_request.php');
    include __DIR__.'/DAV/includes.php';
    include __DIR__.'/HTTP/includes.php';

    function tempfilepath($name = '') {
        $variants = array(SMARTY_COMPILE_DIR, realpath(__DIR__ . '/../../dnl/'), realpath(__DIR__ . '/../../data/spool/'), ini_get('upload_tmp_dir'), ini_get('session.save_path'), sys_get_temp_dir());
        foreach ($variants as $tmpdir) {
            if (file_exists($tmpdir) && is_writable($tmpdir)) {
                return $tmpdir.DIRECTORY_SEPARATOR.$name;
            }
        }
    }

    class Sabre_DAV_Auth_Backend_Samo extends Sabre_DAV_Auth_Backend_AbstractDigest {
        public function getDigestHash($realm, $username) {
            return  ('samo' == $username) ? md5($username . ':' . $realm . ':' .TOOLSPROTECT) :false;
        }
    }

    class Samo_DAV_Logging extends Sabre_DAV_ServerPlugin {

        public $server;

        function log($action,$path) {
            $msg = sprintf("[%s]\t%s\t%s\t%s\t%s".PHP_EOL,date('Y-m-d H:i:s',Samo_Request::time()),Samo_Request::remote_addr(),Samo_Request::user_agent(),$action, $path);

            @file_put_contents(tempfilepath('update.log'),$msg,FILE_APPEND | LOCK_EX);
        }

        function initialize(Sabre_DAV_Server $server) {

            $this->server = $server;
            $server->subscribeEvent('afterWriteContent',array($this,'afterWriteContent'));
            $server->subscribeEvent('afterCreateFile',array($this,'afterCreateFile'));
            $server->subscribeEvent('beforeBind',array($this,'beforeBind'));
            $server->subscribeEvent('beforeUnbind',array($this,'beforeUnbind'));

        }

        function afterWriteContent($path,Sabre_DAV_IFile $node) {
             $this->log('write',$path);
        }

        function afterCreateFile($path,Sabre_DAV_IFile $node) {
            $this->log('create',$path);
        }

        function beforeBind($path) {
            $this->log('create',$path);
        }
        function beforeUnbind($path) {
            $this->log('delete',$path);
        }
    }



    class Sabre_DAV_FS_Directory_Samo extends Sabre_DAV_FS_Directory {
        /**
         * Returns an array with all the child nodes
         *
         * @return Sabre_DAV_INode[]
         */
        public function getChildren() {

            $nodes = array();
            foreach(scandir($this->path) as $node) {
                    if (!in_array($node, array('.','..','.svn','.dev','.idea','.htaccess','tmp'))) {
                        $nodes[] = $this->getChild($node);
                    }
            }
            return $nodes;

        }
        /**
         * Returns a specific child node, referenced by its name
         *
         * This method must throw Sabre_DAV_Exception_NotFound if the node does not
         * exist.
         *
         * @param string $name
         * @throws Sabre_DAV_Exception_NotFound
         * @return Sabre_DAV_INode
         */
        public function getChild($name) {

            $path = $this->path . '/' . $name;

            if (!file_exists($path)) throw new Sabre_DAV_Exception_NotFound('File with name ' . $path . ' could not be located');

            if (is_dir($path)) {

                return new Sabre_DAV_FS_Directory_Samo($path);

            } else {

                return new Sabre_DAV_FS_File($path);

            }

        }
    }

    $root = new Sabre_DAV_FS_Directory_Samo($_root);
    $server = new Sabre_DAV_Server($root);

    $_normalize = function($path) {
        return rtrim(str_replace(array(DIRECTORY_SEPARATOR,'//'),'/',$path),'/');
    };

    $WWWROOT = $_normalize(str_replace($_normalize($_SERVER['DOCUMENT_ROOT']),'/',$_normalize(__DIR__))).'/';

    $server->setBaseUri($WWWROOT.basename(__FILE__));

    $lockBackend = new Sabre_DAV_Locks_Backend_File(tempfilepath('locksdb'));
    $lockPlugin = new Sabre_DAV_Locks_Plugin($lockBackend);
    $server->addPlugin($lockPlugin);

    $browser = new Sabre_DAV_Browser_Plugin();
    $server->addPlugin($browser);

    $ct = new Sabre_DAV_Browser_GuessContentType();
    $ct->extensionMap += array(
        'php' => 'application/x-php',
        'fpdf' => 'application/x-php',
        'tpl' => 'application/x-php',
        'html' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'example' => 'application/x-php',
        'pdf' => 'application/pdf',
        'xml' => 'application/xml',
    );
    $server->addPlugin($ct);

    $server->addPlugin(new Samo_DAV_Logging());

    $authBackend = new Sabre_DAV_Auth_Backend_Samo();
    $auth = new Sabre_DAV_Auth_Plugin($authBackend,'SamoOnline');
    $server->addPlugin($auth);

    $tempFF = new Sabre_DAV_TemporaryFileFilterPlugin(tempfilepath());
    $server->addPlugin($tempFF);

    $server->exec();
