<?php
try { ini_set("display_errors", 1); error_reporting(E_ALL); include '../properties.php'; include 'properties.php'; include '../routes.php'; if (!DEBUG) { exit; } session_start(); include _ROOT . '/includes/admin.php'; Samo_Registry::set('logger', null); class UpdateModel { protected $OFFICEDB = null; protected $db = null; protected $tasks = array(); protected $modules_required = array(); protected $auto = true; protected $file = null; public function __construct() { $this->post = $_POST; if ($this->post) { $this->post = $this->setPost($this->post); } $this->OFFICEDB = OFFICE_SQLSERVER . '.' . OFFICEDB; $this->db = db_connect(null, null); if (empty($this->title)) { $this->title = get_class($this); } } private function setPost($data) { if (is_array($data)) { foreach ($data as $key => $row) { $data[$key] = $this->setPost($row); } return $data; } else { return __recover_cp($data); } } private function getMigration($name) { $result = false; $sql = $this->db->formatQuery("EXEC " . $this->OFFICEDB . ".dbo.sp_executesql N'SELECT TOP 1 [cdate] FROM [dbo].[online_migration] WHERE [what] = @what', N'@what varchar(255)', %s", array($name)); if ($res = $this->db->query($sql)) { if ($row = $this->db->fetchRow($res)) { $result = $row['cdate']; } } return $result; } private function setMigration($name) { if ($this->getMigration($name) === false) { $sql = $this->db->formatQuery("EXEC " . $this->OFFICEDB . ".dbo.sp_executesql N'INSERT INTO [dbo].[online_migration] ([what]) VALUES (@what);', N'@what varchar(255)', %s", array($name)); $this->db->query($sql); return true; } return false; } private function tasks() { $dir = _ROOT . '/admin/update/'; if ($handle = opendir($dir)) { $files = array(); while (false !== ($entry = readdir($handle))) { if ($entry != "." && $entry != "..") { if (preg_match('~^([\d]*)[_]{0,1}([\d]*)[_]{0,1}([a-z_]+).php$~', $entry, $file)) { if ($this->getMigration($file[3]) === false) { $files[] = $file; } } } } closedir($handle); if (!empty($files)) { usort( $files, function ($a, $b) { $result = 0; foreach (array(1, 2) as $key) { if ($a[$key] == $b[$key]) { continue; } $result = ($a[$key] < $b[$key]) ? -1 : 1; break; } return $result; } ); foreach ($files as $file) { include_once _ROOT . '/admin/update/' . $file[0]; if (class_exists($file[3])) { $this->tasks[$file[3]] = new $file[3](); $this->tasks[$file[3]]->file = _ROOT . '/admin/update/' . $file[0]; } } } else { header("HTTP/1.0 404 Not Found"); header("Status: 404 Not Found"); die; } } } public function check_required($updater) { $routes = $GLOBALS['routes']; if (!empty($updater->modules_required)) { foreach ($updater->modules_required as $module) { if (!isset($routes[$module])) { return false; } } } return true; } public function init() { $this->tasks(); if (isset($_GET['make']) && isset($this->tasks[$_GET['make']])) { if (!$this->check_required($this->tasks[$_GET['make']])) { die('skipped'); } $result = 0; if ($this->tasks[$_GET['make']]->auto || !isset($_GET['complete'])) { $result = $this->tasks[$_GET['make']]->make(); } $complete = ($result === 0); if (method_exists($this->tasks[$_GET['make']], 'complete')) { $complete = $this->tasks[$_GET['make']]->complete($result); } $info = ''; if (method_exists($this->tasks[$_GET['make']], 'info')) { $info = $this->tasks[$_GET['make']]->info($result); } if ($complete) { $this->setMigration($_GET['make']); die('ok - ' . $info); } elseif (method_exists($this->tasks[$_GET['make']], 'template')) { die(); } else { die('wait - ' . sprintf('обработано файлов: %d', $result)); } } else { html_header(); foreach ($this->tasks as $key => $row) { echo '<div id="' . $key . '"><a href="?make=' . $key . '" class="' . ($row->auto ? 'auto' : '') . ($this->getMigration($key) === false ? '' : ' active') . '">' . $row->title . '</a></div>'; } html_footer(); } } } $method = null; $model = new UpdateModel(); $model->init(); } catch (Exception $e) { echo var_export($e, true); } function html_header() { ?><html>
    <head>
        <title>Обновление</title>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
        <script type="text/javascript" charset="windows-1251"
                src="<?php echo WWWROOT ?>public/js/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#result').css('margin-left', $('#container').width() + 20);
                var send = function () {
                    var object = $('#container a:not(.active)')[0];
                    if ($(object).length) {
                        $(object).before('<img src="<?php echo WWWROOT?>public/pict/preloader.gif" />');
                        var id = $(object).parent().attr('id');
                        var log = function (data) {
                            var date = new Date();
                            date = date.toTimeString().replace(/([\d]{1,2}:[\d]{1,2}:[\d]{1,2}).+/, '$1');
                            if (!$('#log').length) {
                                $('#result').show().append('<div id="log"></div>');
                            }
                            var obj = null;
                            if (/^ok - /.test(data)) {
                                data = data.replace(/^ok - /, '');
                                $('#result .' + id).remove();
                                $(object).addClass('active');
                                $(object).parent().find('img').remove();
                                $('#log').show();
                                obj = $('<div class="ok">[' + date + '] ' + $(object).text() + ' - готово' + (data ? (' [<a href="#">+</a>]<div class="message"><pre>' + data + '</pre></div>') : '') + '</div>');
                            } else {
                                if (/^wait - /.test(data)) {
                                    data = data.replace(/^wait - /, '');
                                    obj = $('<div>[' + date + '] ' + data + '</div>');
                                } else {
                                    obj = $('<div class="error">[' + date + '] error' + (data ? (' [<a href="#">+</a>]<div class="message"><pre>' + data + '</pre></div>') : '') + '</div>');
                                }
                            }
                            $(obj).find('a').click(function () {
                                if ($(this).hasClass('opened')) {
                                    $(this).removeClass('opened').html('+');
                                    $(obj).find('.message').hide();
                                } else {
                                    $(this).addClass('opened').html('-');
                                    $(obj).find('.message').show();
                                }
                            });
                            $('#log').prepend(obj);
                        }
                        if ($(object).hasClass('auto')) {
                            $.ajax({
                                url: $(object).attr('href'), success: function (data) {
                                    log(data);
                                    setTimeout(send, 5000);
                                }, error: function (xhr, ajaxOptions, thrownError) {
                                    log(thrownError);
                                    setTimeout(send, 10000);
                                }
                            });
                        } else {
                            var loading = function () {
                                $('#result .' + id).html('Загрузка...').show();
                            }
                            var success = function (data) {
                                $('#log').hide();
                                $('#result .' + id + ', #result .success').remove();
                                if (data == 'ok') {
                                    log(data);
                                    setTimeout(send, 2000);
                                } else {
                                    $('#result').append('<div class="' + id + '">' + data + '</div>').show();
                                    $('#result .' + id + ' form').submit(function () {
                                        $.post($(object).attr('href'), $('#result .' + id + ' form').serialize(), success);
                                        loading();
                                        return false;
                                    });
                                    $('#result').prepend('<button class="success" style="position: absolute; right: 15px;">Готово</button>');
                                    $('#result .success').click(function () {
                                        $.ajax({url: $(object).attr('href') + '&complete', success: success});
                                        return false;
                                    });
                                }
                            }
                            loading();
                            $.ajax({url: $(object).attr('href'), success: success});
                        }
                    }
                }
                setTimeout(send, 1000);
                $('#container a').click(function () {
                    return false;
                });
            });
        </script>
        <style type="text/css">
            a, a:hover {
                color: #ce0000;
            }

            a.active, a.active:hover {
                color: #21801c;
            }

            a.back {
                position: absolute;
                top: 10px;
                right: 10px;
            }

            #container {
                position: absolute;
                max-width: 30%;
            }

            #container div {
                margin: 0 0 8px 20px;
                line-height: 14px;
            }

            #container div img {
                position: absolute;
                margin: 2px 0px 0 -20px;
            }

            #result {
                background: #e6e6e6;
                padding: 5px;
                display: none;
            }

            .ok {
                color: #008000;
            }

            .error {
                color: red;
            }

            .error div.message, .ok div.message {
                display: none;
            }

            .error a, .ok a {
                color: blue;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
    <div id="container"><?php
} function html_footer() { ?>        </div>
    <div id="result"></div>
    </body>
    </html><?php
} 