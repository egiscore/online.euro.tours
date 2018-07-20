<?php
if (!defined('ROUTES_PATH')) { define('ROUTES_PATH', _ROOT . 'routes.php'); } include_once ROUTES_PATH; if (!isset($routes['d_freight_situation'])) { die(Get_Message_Lang($LNG, 'adm_module_disabled')); } ?>
<?php get_help_button('onlinest:sistema_upravlenija:monitor_flight') ?>
    <body>
<?= style_css() ?>
<FORM name="start" action="" method="post">
    <input type="hidden" name="LNG" value="<?= $LNG ?>">
    <input type=hidden name="ADD" value="">
    <input type=hidden name="EDIT" value="">
    <input type=hidden name="SAVE" value="">
    <input type=hidden name="DELETE" value="">
    <input type=hidden name="UNLOCK" value="">
    <script>
        function Vars(add, edit, save, del, unlock) {
            <?php
 if ($_ACCESS == 0) { echo 'alert("Вам разрешен только просмотр. Only view.");'; } elseif ($_ACCESS == 1) { ?>
            document.start.ADD.value = add;
            document.start.EDIT.value = edit;
            document.start.SAVE.value = save;
            document.start.DELETE.value = del;
            document.start.UNLOCK.value = unlock;
            document.start.submit();
            <?php
 } ?>
        }
    </script>
<?php
include_once $folder_site . "admin/includes/site/function.php"; if (!isset($CHECKIN1) or ($CHECKIN1 == '')) { $date1 = date('d/m/Y'); } else { $date1 = $CHECKIN1; } if (!isset($CHECKIN2) or ($CHECKIN2 == '')) { $date2 = mktime(0, 0, 0, date('m'), date('d') + 14, date('Y')); $date2 = date('d/m/Y', $date2); } else { $date2 = $CHECKIN2; } $CHECKIN1 = $date1; if (isset($_POST['CHECKIN1']) or isset($_GET['CHECKIN1'])) { $CHECKIN1 = isset($_POST['CHECKIN1']) ? $_POST['CHECKIN1'] : $_GET['CHECKIN1']; } Check_Date($CHECKIN1); $CHECKIN2 = $date2; if (isset($_POST['CHECKIN2']) or isset($_GET['CHECKIN2'])) { $CHECKIN2 = isset($_POST['CHECKIN2']) ? $_POST['CHECKIN2'] : $_GET['CHECKIN2']; } Check_Date($CHECKIN2); $TOURINC = 0; if (isset($_POST['TOURINC']) or isset($_GET['TOURINC'])) { $TOURINC = isset($_POST['TOURINC']) ? $_POST['TOURINC'] : $_GET['TOURINC']; } Is_Digital($TOURINC); set_time_limit(0); $str = ''; $partner_not_found = 0; $PARTNER = -2; $PARTTYPE = 0; if (!isset($TOURINC) or ($TOURINC == '')) { $TOURINC = -1; } $t_inc = array(); $t_name = array(); $t_lname = array(); $sql = $db->formatExec( '<OFFICEDB>.[dbo].[up_WEB_3_ADMIN_d_xxx_all_tour]', [ 'USER' => $USER, 'dataset' => 1, ] ); if ($res = $db->fetchAll($sql)) { foreach ($res as $row) { if ($TOURINC < 0) { $TOURINC = $row['inc']; } $t_inc[] = htmlspecialchars($row['inc'], ENT_QUOTES, 'cp1251'); $t_name[] = htmlspecialchars($row['name'], ENT_QUOTES, 'cp1251'); $t_lname[] = htmlspecialchars($row['lname'], ENT_QUOTES, 'cp1251'); } } else { echo 'Не настроены туры'; exit(); } if (!isset($CHECKIN1) or ($CHECKIN1 == '')) { $date1 = date('d/m/Y'); } else { $date1 = $CHECKIN1; } if (!isset($CHECKIN2) or ($CHECKIN2 == '')) { $date2 = mktime(0, 0, 0, date('m'), date('d') + 14, date('Y')); $date2 = date('d/m/Y', $date2); } else { $date2 = $CHECKIN2; } if ($TOURINC > 0 and $date1 <> '' and $date2 <> '') { $d1 = substr($date1, 6, 4) . substr($date1, 3, 2) . substr($date1, 0, 2); $d2 = substr($date2, 6, 4) . substr($date2, 3, 2) . substr($date2, 0, 2); $fs = array(); $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_flight_situation', [ 'DateBeg' => $d1, 'DateEnd' => $d2, 'Tour' => $TOURINC, 'Class' => 0, 'Partner' => 0, ] ); if ($res = $db->fetchAll($sql)) { foreach ($res as $row) { $fs[] = $row; } } } $file_template = 'template.php'; include $file_template; 