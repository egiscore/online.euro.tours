<style>
    table {border: solid 1px #eee; border-collapse: collapse; width: 100%;}
    table td, table th {border: solid 1px #eee; padding: 2px;}
    table th {background-color: #eee;}
    tr.even td {
        background-color: #eee;
    }
    button {display: block; margin: 5px; width: 250px;}
</style>
<script type="text/javascript">
    function doit(action) {
        var form = document.forms[0];
        form.elements.action.value = action;
        form.submit();
    }
</script>
<?= style_css() ?>
<?php get_help_button('onlinest:sistema_upravlenija:service')?>
<form method="POST" action="?">
    <input type="hidden" name="page" value="<?= $ALIAS ?>">
    <input type="hidden" name="LNG" value="<?= $LNG ?>">
    <input type="hidden" name="action" value="repl_queue">
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) { session_write_close(); switch ($_POST['action']) { case 'repl_queue': repl_queue($LNG); break; case 'servers_cache': if ($_ACCESS) { servers_cache($LNG); } break; case 'smarty_cache': if ($_ACCESS) { smarty_cache($LNG); } break; case 'droptemptab': if ($_ACCESS) { droptemptab($LNG); } break; case 'download_images': if ($_ACCESS) { $isDownloaded = download_images($LNG); if (!$isDownloaded) { echo '
                        <script>
                            setTimeout(function() { doit("download_images"); }, 500);
                        </script>
                        '; } else { admin_flash(Get_Message_Lang($LNG, 'adm_system_downloaded_images')); } } break; } } class Cli_Admin_Tools { private $tools = null; public function __construct(Samo_Tools $tools) { $this->tools = $tools; } public function __call($method,$args) { if (method_exists($this->tools,$method)) { return $this->tools->multiply($method, $args); } throw new RuntimeException('Unknown method ' . $method); } } function tools() { include_once _ROOT.'includes/classes/class.samo_config.php'; Samo_Loader::register_autoload(); $tools = Samo_Loader::load_object('Samo_Tools'); return new Cli_Admin_Tools($tools); } function repl_queue($LNG) { $tools = tools(); if ($queue = $tools->repl_queue_length()) { foreach ($queue as $server => $row) { if (strpos($server, '_ANDR') !== false || strpos($server, '_ESYS')) { unset($queue[$server]); } } $tmp = reset($queue); $last_check = $tmp['CheckTime']; if (count($queue)) { printf("<b style='color: red; font-size: 18px;'>%s: %s</b><br>", Get_Message_Lang($LNG, 'adm_system_queue_checktime'), $last_check); printf('<table><thead><tr><th>%s</th><th>%s</th><th>%s</th><th>%s</th></tr></thead>', Get_Message_Lang($LNG, 'adm_system_queue_server'), Get_Message_Lang($LNG, 'adm_system_queue_length'), Get_Message_Lang($LNG, 'adm_system_queue_time'), Get_Message_Lang($LNG, 'adm_system_queue_worktime')); $i = 0; foreach ($queue as $server => $row) { $class = ($i++ % 2) ? 'even' : 'odd'; printf("<tr class='%s'><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $class, $server, number_format($row['Length'], 0, '.', ' '), $row['LastChangeTime'], $row['LastTimeWork']); } echo '</table>'; } else { admin_flash(Get_Message_Lang($LNG, 'adm_system_replication_is_empty')); } } else { admin_flash(Get_Message_Lang($LNG, 'adm_system_replication_is_empty')); } echo admin_flash(); } function servers_cache($LNG) { tools_exec(array('create_servers_cache', 'clear_cache'), Get_Message_Lang($LNG, 'adm_system_servers_cache_refreshed')); } function droptemptab($LNG) { tools_exec(array('droptemptab', 'clear_cache'), Get_Message_Lang($LNG, 'adm_system_temptab_refreshed')); } function smarty_cache($LNG) { tools_exec(array('clear_smarty_cache', 'clear_cache'), Get_Message_Lang($LNG, 'adm_system_smarty_cache_cleared')); } function download_images($LNG) { $result = tools_exec('download_images', Get_Message_Lang($LNG, 'adm_system_downloading_images')); return $result['download_images']; } function tools_exec($method, $result) { $tools = tools(); try { $methods = !is_array($method) ? array($method) : $method; $results = []; foreach ($methods as $method) { $results[$method] = call_user_func(array($tools, $method)); } } catch (Exception $e) { $result = $e->getMessage(); } admin_flash($result); return $results; } ?>
<?= admin_flash() ?>
<?php
if ($_ACCESS) { ?>
    <button name="servers_cache" onclick="doit(this.name)"><?= Get_Message_Lang($LNG, 'adm_system_updatestate')?></button>
    <?php
 if (OFFICE_SQLSERVER) {?>
        <button name="repl_queue" onclick="doit(this.name)"><?= Get_Message_Lang($LNG, 'adm_system_replication')?></button>
    <?php
 }?>
    <button name="droptemptab" onclick="doit(this.name)"><?= Get_Message_Lang($LNG, 'adm_system_droptemptab')?></button>
    <button name="smarty_cache" onclick="doit(this.name)"><?= Get_Message_Lang($LNG, 'adm_system_clear_smarty_cache')?></button>
    <button name="download_images" onclick="doit(this.name)"><?= Get_Message_Lang($LNG, 'adm_system_download_images')?></button>

<?php
} 