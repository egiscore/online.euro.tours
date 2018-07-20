<?php
function checksession() { $SESSION = $GLOBALS['SESSION']; $http_site = $GLOBALS['http_site']; $LNG = $GLOBALS['LNG']; $db = Samo_Registry::get('db'); $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_Check_UserSession', [ 'SESSION' => $SESSION, 'SESSION_TIME' => SESSION_TIME, ] ); if (false !== ($row = $db->fetchOneRow($sql))) { if ($row['Inc'] < 0) { $_SESSION = []; if (PHP_SESSION_ACTIVE === session_status()) { session_regenerate_id(true); session_write_close(); } ?>
            <script language="JavaScript">
                function Quit() {
                    top.location = "<?php echo $http_site?>admin/index.php";
                    return (true);
                }
                if (window == window.top) {
                    Quit();
                }
            </script>
            <body>
            <h4><?= Get_Message_Lang($LNG, 'adm_old_page') ?>
                <h4>
                    <form method="POST" name="start" action="">
                        <input type=button value="<?= Get_Message_Lang($LNG, 'adm_close_system') ?>" name=QUIT
                               class=button onClick="Quit();">
                        <input type="hidden" name="RELOG" value="1">
                    </form>
            </body>
            <?php
 exit; } return $row; } return false; } function save_to_file($flname, $content) { if (false !== file_put_contents($flname, $content)) { $umask = umask(0); chmod($flname, 0666); umask($umask); } else { echo Get_Message_Lang($GLOBALS['LNG'], 'adm_file_open_error'); } } function createMenu() { $USER = $GLOBALS['USER']; $USER_IS_ADMIN = $GLOBALS['USER_IS_ADMIN']; $LNG = $GLOBALS['LNG']; $db = Samo_Registry::get('db'); $sql = OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_3_ADMIN_Get_Menu @User=%d, @Lang=%s, @Admin=%d"; $sql = $db->formatQuery($sql, array($USER, $LNG == 'rus' ? 'ru' : $LNG, $USER_IS_ADMIN)); if (false !== ($all_modules = $db->fetchAll($sql))) { foreach ($all_modules as $module) { if ($USER_IS_ADMIN || $module['Access']) { if ($module['Alias'] != 'show_state') { $module_file = ($module['Alias'] == 'sys_managers_rules') ? _ROOT . 'admin/editors/manager_rule.php' : _ROOT . 'admin/modules/' . $module['Path'] . '/create_tree_items2.php'; if (file_exists($module_file)) { $alias = $module['Alias']; $name = $module['Name']; $folder_site = _ROOT; include_once $module_file; } else { if (!in_array($module['Alias'], array('show_region', 'show_town', 'show_state', 'show_hotel'))) { $str = ("['" . $module['Name'] . "', '', 'admin_for_" . $module['Alias'] . "',],"); echo $str; } } } } } } } function create_item($module, $return = false) { $USER = $GLOBALS['USER']; $USER_IS_ADMIN = $GLOBALS['USER_IS_ADMIN']; $LNG = $GLOBALS['LNG']; $db = Samo_Registry::get('db'); $sql = OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.sp_executesql N'
    select
        [m].[name] as [ModuleName],
        [m].[lname] as [ModuleLName]
    from
        [dbo].[online_modules] [m]
    where
        [m].[alias] = @module
        and (
            exists(
                select * from [online_admin_rule] [ar] where [ar].[module] = [m].[alias] and [ar].[user] = @User
            )
            or
            @USER_IS_ADMIN = 1
        )
', N'@User INT, @module VARCHAR(64), @USER_IS_ADMIN int', %d, %s, %d"; $sql = $db->formatQuery($sql, array($USER, $module, $USER_IS_ADMIN)); if (false !== ($row = $db->fetchRow($sql))) { if ($LNG === 'rus') { $tmp = $row['ModuleName']; } else { $tmp = $row['ModuleLName']; } $str = ("['" . $tmp . "', '', 'admin_for_" . $module . "',],"); if ($return) { return $str; } else { echo $str; } } } function save_module_permition($module_alias) { $LNG = $GLOBALS['LNG']; $db = Samo_Registry::get('db'); $sql = OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'
    select
        [u].[code] as [UserInc],
        [u].[name] as [UserName],
        (case [u].[groupcode] when 10000 then 1 else 0 end) as [User_admin]
    from
        [users] [u]
'"; $res = $db->fetchAll($sql); foreach ($res as $row) { $inc = $row['UserInc']; $fld = "FULL_PERMITION" . $inc; if (isset($_POST[$fld])) { $permition = 1; } else { $fld = "ONLY_VIEW" . $inc; if (isset($_POST[$fld])) { $permition = 0; } else { $permition = -1; } } $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_Access_Add_Edit', [ 'User' => $inc, 'Module' => $module_alias, 'Access' => $permition, 'User_Is_Admin' => $row['User_admin'], ] ); $db->ExecQuery($sql); } admin_flash(Get_Message_Lang($LNG, 'adm_success_save')); echo admin_flash(); } function get_module_permission($module_alias) { $USER = $GLOBALS['USER']; $USER_IS_ADMIN = $GLOBALS['USER_IS_ADMIN']; $permission = 0; if ($USER_IS_ADMIN) { $permission = 1; } else { $db = Samo_Registry::get('db'); $sql = "EXEC " . OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.sp_executesql N'
            SELECT
                [access]
            FROM
                [dbo].[online_admin_rule]
            WHERE
                [module] = @Module
                and [user] = @User
            ', N'@User INT, @Module VARCHAR(64)', %d, %s
        "; $sql = $db->formatQuery($sql, array($USER, $module_alias)); if ($row = $db->fetchRow($sql)) { $permission = $row['access']; } } return $permission; } function style_css() { return '<link href="' . WWWROOT . 'admin/includes/site/css/style.css?rev=' . filemtime(_ROOT . 'admin/includes/site/css/style.css') . '" rel="stylesheet" type="text/css">'; } function get_fields($ENTITY) { $db = Samo_Registry::get('db'); $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_get_online_field', [ 'Entity' => $ENTITY, 'LangId' => Samo_Request::langid(), ] ); $return = $db->fetchAllWithKeyGroup( $sql, 'Group', function ($row) { $row['Title'] = htmlspecialchars($row['Title'], ENT_QUOTES, 'cp1251'); $row['HelpAlt'] = htmlspecialchars($row['HelpAlt'], ENT_QUOTES, 'cp1251'); return $row; } ); unset($return['System']); return $return; } function set_fields($ENTITY, $fields, $PROPS) { foreach ($_POST['field'] as $FIELD => $data) { foreach ($fields as $flds) { foreach ($flds as $field) { if ($FIELD == $field['Field']) { break 2; } } $field = null; } if (!$field) { continue; } $params = array( 'Entity' => $ENTITY, 'Field' => $FIELD, 'LangId' => Samo_Request::langid(), ); $changes = array(); $immutableWritable = ['HelpAlt', 'Editable']; foreach ($data as $prop => $value) { if (!array_key_exists($prop, $field)) { continue; } if ($field['Immutable'] && in_array($prop, $PROPS) && !in_array($prop, $immutableWritable)) { $params[$prop] = $field[$prop]; continue; } else { $params[$prop] = htmlspecialchars($value, ENT_NOQUOTES, 'cp1251'); } if ($field[$prop] != $value) { $changes[$prop] = $value; } } if (!count($changes)) { continue; } $db = Samo_Registry::get('db'); $sql = $db->formatExec(OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_set_online_field', $params); $db->query($sql); } } function admin_flash($msg = null) { if (!isset($_SESSION['samo_admin']['flash'])) { $_SESSION['samo_admin']['flash'] = []; } if ($msg) { $_SESSION['samo_admin']['flash'][] = $msg; } $return = ''; if (count($_SESSION['samo_admin']['flash'])) { $return = '
            <div id="flash">
                ' . implode('<br>', $_SESSION['samo_admin']['flash']) . '
            </div>
            <script>setTimeout(function(){document.getElementById("flash").style.display="none";},3000);</script>
        '; } if (!$msg) { $_SESSION['samo_admin']['flash'] = []; } return $return; } require_once _ROOT . 'admin/common/dbset/configuration.php';