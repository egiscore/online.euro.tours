<?php
$login_samotour_user = false; $exists_admin_site_users = false; $sql = OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'
    set nocount on
    SELECT * FROM dbo.[sysobjects] WHERE [name] = ''online_users''
'"; if ($row = $db->fetchRow($sql)) { $exists_admin_site_users = true; } if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['u_passw'])) { $u_login = $_REQUEST['u_login']; $u_passw = $_POST['u_passw']; if (!empty($u_login) && !empty($u_passw)) { $crc_psw = $u_passw; $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_LoginManager', [ 'Login' => $u_login, 'Crc_psw' => '0x' . $crc_psw, ] ); if (false === ($row = $db->fetchRow($sql))) { echo Get_Message_Lang($LNG, 'adm_manager_not_found'); } else { $well_known_psw = array( 'd827cfb4bc3b30f2116cac43fd360c5715e03543', '5cee68d5847dff97099c4b1c295bb858a6bcd169', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '8cb2237d0679ca88db6464eac60da96345513964', '8c997ee9947e634ebeea9de74018078120674171', ); if (in_array($crc_psw, $well_known_psw)) { echo sprintf(Get_Message_Lang($LNG, 'adm_light_password'), $u_login); } else { $USER = $row['Code']; $USER_IS_ADMIN = $row['user_is_admin']; if (PHP_SESSION_ACTIVE === session_status()) { session_regenerate_id(true); } $SES = session_id(); $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_Create_UserSession', [ 'User' => $USER, 'Ses' => $SES, 'Session_time' => SESSION_TIME, ] ); $result = $db->fetchOne($sql); if ($result > 0) { $_SESSION['samo_admin'] = array( 'Inc' => $result, 'User' => $USER, 'LNG' => $LNG ); session_write_close(); header('Location: ' . Samo_Url::route('admin'), true, 301); exit; } unset($USER, $USER_IS_ADMIN); echo Get_Message_Lang($LNG, 'adm_can_not_create_session'); } } } } else { if (isset($_SESSION['samo_admin']) && isset($USER) && ($USER > 0)) { $login_samotour_user = true; } } if (!$exists_admin_site_users && $login_samotour_user && 'home' == $ALIAS) { $ver = include _ROOT . 'includes/version.php'; ?>
    <script>
        document.title = 'Online для ПК САМО-Тур. Система управления.';
        window.samo_admin = {
            rev: <?= $ver['rev'] ?>,
            path: '<?= $ver['path'] ?>'
        };
    </script>
    <frameset rows="48,*" border="1">
        <frame name="menu" src="<?= $http_site; ?>admin/index.php?page=top_frame&LNG=<?= $LNG ?>" marginwidth="0" marginheight="0" scrolling="no"
               frameborder="0" style="padding: 0px;">
        <frameset cols="200,*" frameborder="yes" border="1">
            <frame name="tree" src="<?= $http_site; ?>admin/index.php?page=left_frame&LNG=<?= $LNG ?>" marginwidth="2"
                   marginheight="2" scrolling="auto" frameborder="1">
            <frame name="content" src="<?= $http_site; ?>admin/index.php?page=center_frame&LNG=<?= $LNG ?>" marginwidth="15"
                   marginheight="15" scrolling="auto" frameborder="0">
        </frameset>
    </frameset>
    <noframes></noframes>
<?php
} elseif ($exists_admin_site_users && isset($USER_IS_ADMIN) && $USER_IS_ADMIN) { $convert_ok = isset($_POST['CONVERT']) ? (bool)$_POST['CONVERT'] : false; $SAMOUSERS = isset($_POST['SAMOUSERS']) ? $_POST['SAMOUSERS'] : false; if ($convert_ok && is_array($SAMOUSERS)) { $sql_1 = OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'
            set nocount on
            begin tran
                declare @tmp_oar table([inc] int, [user] int)
        "; $sql_2 = ''; foreach ($SAMOUSERS as $admin_user => $samo_user) { $samo_user = (int)$samo_user; if ($samo_user > 0) { $sql_2 .= "
                    insert @tmp_oar([inc], [user]) select [inc], ".$samo_user." from [dbo].[online_admin_rule] where [user] = ".$admin_user."
                "; } else { $sql_2 .= "
                    delete from [dbo].[online_admin_rule] where [user] = ".$admin_user."
                "; } } $sql_3 = "
                update [online_admin_rule] set [user] = [ttt].[user] from [online_admin_rule] [oar], @tmp_oar [ttt] where [oar].[inc] = [ttt].[inc]

                IF EXISTS(SELECT * FROM [sysobjects] WHERE [name] = ''online_users'' AND [type] = ''U'')
                BEGIN
                    exec sp_rename ''online_users'', ''_ToBeDropped_online_users''
                END
            commit
        '"; $sql = $sql_1.$sql_2.$sql_3; if ($db->query($sql)) { ?>
            <FORM name="start" action="" method="post">
                <input type="hidden" name="LNG" value="<?= $LNG ?>">
                <div style="text-align: center">
                    <br>
                    <br>
                    <strong>Конвертация прошла успешно.</strong><br>Convertation completed successfully.
                    <br>
                    <br>
                    <strong>Теперь для входа в систему администрирования используйте логин и пароль пользователя САМО-Тура.</strong><br>For login use Samo-Tour user parameters.
                    <br>
                    <br>
                    <input type=submit value="Продолжить / Next" id="BTN_CONVERT_USER_FINISH" class=button>
                </div>
            </FORM>
<?php
 } else { echo 'Во время конвертации произошла ошибка / Convertation error.'; } } else { ?>
        <?= style_css() ?>
        <script>
            function CheckUserConvert() {
                var $ = samo.jQuery;
                var is_ok = true;
                $('select.samouser').each(function () {
                    var value = $(this).val();
                    if (value == 0) {
                        is_ok = false;
                    }
                });
                if (is_ok) {
                    return true;
                } else {
                    alert('Не все пользователи назначены. Select user.');
                }
                return false;
            }
            function GoConvertUser() {
                if (CheckUserConvert()) {
                    document.start.submit();
                    return true;
                }
                return false;
            }
        </script>
<?php
 echo Get_Message_Lang($LNG, 'can_convert_users_to_samotour'); ?>
        <FORM name="start" action="" method="post">
            <input type="hidden" name="LNG" value="<?= $LNG ?>">
            <input type="hidden" name="CONVERT" value="1">
            <?php
 $sql = OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'SELECT [Inc], [Name] FROM [dbo].[online_users] ORDER BY [Name] '"; if (false !== ($admin_users = $db->fetchAll($sql))) { $sql = OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'SELECT * FROM [dbo].[uf_web_3_admin_users](NULL) ORDER BY [Name] '"; if (false !== ($samotour_users = $db->fetchAll($sql))) { $samouser_options = '<option value="0" selected>Выберите пользователя / Select user</option>'; $samouser_options .= '<option value="-1">Не конвертировать / Not convert</option>'; foreach ($samotour_users as $samotour_user) { $samouser_options .= '<option value="' . $samotour_user['Code'] . '">' . $samotour_user['Name'] . '</option>'; } echo '
                        <table cellpadding="1" cellspacing="1">
                            <tr>
                                <td class="capt border_dark">Пользователь админки<br>User SAMO-ADMIN</td>
                                <td class="capt border_dark">Пользователь САМО-Тура<br>User SamoTour</td>
                            </tr>
                    '; foreach ($admin_users as $admin_user) { echo '
                            <tr>
                                <td class="txt border">' . $admin_user['Name'] . '</td>
                                <td class="txt border">
                                    <select class="samouser" name="SAMOUSERS[' . $admin_user['Inc'] . ']" data-oldvalue="0">' . $samouser_options . '</select>
                                </td>
                            </tr>
                        '; } echo '</table>'; } } ?>
            <br>
            <input type=button value="Конвертировать / Start convertation" id="BTN_CONVERT_USER" class=button
                   onClick="GoConvertUser();">
        </FORM>
        <script src="<?= $http_site ?>public/js/pack.main.js" charset="windows-1251"></script>
        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
                    $('select.samouser').change(function (e) {
                        e.preventDefault();
                        var oldvalue = $(this).data('oldvalue');
                        $('select.samouser option[value=' + oldvalue + ']').each(function () {
                            $(this).prop('disabled', false);
                        });
                        var value = $(this).val();
                        var parent = this;
                        if (value > 0) {
                            $('select.samouser option[value=' + value + ']').each(function () {
                                var t1 = $(this).parent().attr('name');
                                var t2 = $(parent).attr('name');
                                if (t1 != t2) {
                                    $(this).prop('disabled', true);
                                }
                            });
                        }
                        $(this).data('oldvalue', value);
                    });
                });
            })(samo.jQuery);

        </script>
<?php
 } } else { ?>
    <html>
        <head>
            <title>Online для ПК САМО-Тур. Система управления.</title>
            <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
            <?=style_css()?>
            <script src="../public/js/sha1.js"></script>
            <script>
                if (top.location != self.location) {
                    top.location = '<?=$http_site;?>admin/index.php';
                }
                function Go() {
                    var hash = CryptoJS.SHA1(document.start.u_passw2.value);
                    document.start.u_passw.value = hash;
                    document.start.u_passw2.value = '';
                    document.start.submit();
                }
            </script>
        </head>
        <body>
<?php
if ($exists_admin_site_users) { echo Get_Message_Lang($LNG, 'can_convert_users_to_samotour'); } ?>
            <FORM name="start" action="" method="post">
                <input type=hidden name="u_passw" value="">
                <center><br>
                    <img border="0" src="../public/pict/samo.png" alt="САМО-Софт / SAMO-Soft"><br><br>
                    <table border="0" cellspacing=1 cellpadding=1>
                        <tr>
                            <td colspan="2" class="capt border_dark">&nbsp;Аутентификация / Authentication&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="txt" align="left">
                                &nbsp;Логин / Login :&nbsp;
                            </td>
                            <td class="txt" align="right">
                                &nbsp;
                                <input type="text" name="u_login" value="" class="element" size="20"
                                       style="background-image: url('../public/pict/user_gray.png'); background-repeat: no-repeat; padding-left: 18px">
                            </td>
                        </tr>
                        <tr>
                            <td class="txt" align="left">
                                &nbsp;Пароль / Password :&nbsp;
                            </td>
                            <td class="txt" align="right">
                                &nbsp;
                                <input type="password" name="u_passw2" value="" class="element" size="20"
                                       style="background-image: url('../public/pict/key.png'); background-repeat: no-repeat; padding-left: 18px;">
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="txt capt1 border" colspan="2">
                                <label>
                                    <input type="radio" name="LNG" value="rus" <?= ('rus' == $LNG) ? 'checked' : '' ?>>
                                    <img src="../public/pict/flags/ru.gif">
                                    Русский
                                </label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <label>
                                    <input type="radio" name="LNG" value="eng" <?= ('eng' == $LNG) ? 'checked' : '' ?>>
                                    <img src="../public/pict/flags/us.gif">
                                    English
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="txt">&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2" class="txt">
                                &nbsp;
                                <input type="submit" name="Submit" value="Войти / Enter" class="button" onClick="Go();">
                                &nbsp;
                            </td>
                        </tr>
                    </table>
                </center>
            </form>
<?php
if (defined('DEBUG') && DEBUG) { ?>
                <div class="debug-warning"
                     style="margin: 50px auto;width: 240px;padding:  10px; border: solid 2px red; background-color: pink; color: brown">
                    WARNING! DEBUG MODE ENABLED!
                    <?php
 if (defined('CUSTOM')) { ?>
                        <br>Enabled custom: <b><?= CUSTOM ?></b>
                        <?php
 if (defined('CUSTOM_DB') && CUSTOM_DB) { ?>
                            <br>Used customer's SQLServer
                        <?php
 } ?>
                    <?php
 } ?>
                </div>
<?php
} ?>
        </body>
    </html>
<?php
} 