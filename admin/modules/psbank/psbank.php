<?php
if (!defined('ROUTES_PATH')) { define('ROUTES_PATH', _ROOT . 'routes.php'); } include_once ROUTES_PATH; if (!isset($routes['wspay'])) { die(Get_Message_Lang($LNG, 'adm_module_disabled')); } require _ROOT . 'admin/includes/tour-selector.php'; $showAllTours = !isset($_GET['showAllTours']) ? false : $_GET['showAllTours']; ?>
<body>
<?php get_help_button('onlinest:sistema_upravlenija:wspay') ?>
<?= style_css() ?>
<style type="text/css">
    td.td_hidden input {
        opacity: 0.5;
        filter: alpha(opacity=50);
    }

    td.label {
        width: 140px;
        text-align: right;
    }

    td.checkbox {
        text-align: center;
    }

    thead td.capt {
        padding: 2px;
    }

    a {
        text-decoration: underline;
    }

    select {
        max-width: 320px;
        display: block;
    }
</style>
<FORM name="start" action="" method="post">
    <input type="hidden" name="LNG" value="<?= $LNG ?>">
    <input type=hidden name="ADD" value="">
    <input type=hidden name="EDIT" value="">
    <input type=hidden name="SAVE" value="">
    <input type=hidden name="DELETE" value="">
    <input type=hidden name="UNLOCK" value="">
    <?php
 extract($_POST); $ADD = $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ADD']) && $_POST['ADD'] == 1 ? 1 : 0; $EDIT = $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['EDIT']) && $_POST['EDIT'] == 1 ? 1 : 0; $DELETE = $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['DELETE']) && $_POST['DELETE'] == 1 ? 1 : 0; $TOWNFROMINC = (isset($_REQUEST['TOWNFROMINC']) && intval($_REQUEST['TOWNFROMINC'])) ? intval($_REQUEST['TOWNFROMINC']) : 0; $TOURINC = (isset($_REQUEST['TOURINC']) && intval($_REQUEST['TOURINC'])) ? intval($_REQUEST['TOURINC']) : -2147483647; $OWNERINC = (isset($_REQUEST['OWNERINC']) && intval($_REQUEST['OWNERINC'])) ? intval($_REQUEST['OWNERINC']) : -2147483647; ?>
    <input type=hidden name=INUMBER id=INUMBER value="">
</form>
<script>
    function Vars(add, edit, save, del, unlock) {
        <?php
 if ($_ACCESS == 0) { ?>
        alert("Вам разрешен только просмотр. Only view.");
        <?php
 } elseif ($_ACCESS == 1) { ?>
        document.start.ADD.value = add;
        document.start.EDIT.value = edit;
        document.start.SAVE.value = save;
        document.start.DELETE.value = del;
        document.start.UNLOCK.value = unlock;
        document.start.submit();
        <?php
 } ?>
    }
    function DelButtonClick(inumber) {
        if (confirm('<?=Get_Message_Lang($LNG, 'adm_bank_del_pay')?>' + inumber + "?")) {
            document.start.INUMBER.value = inumber;
            Vars('', '', '', 1, '');
        }
    }
</script>

<?php
 $townfrom = array(); $townfrom[] = array('Inc' => 0, 'Name' => Get_Message_Lang($LNG, 'default'), 'LName' => Get_Message_Lang($LNG, 'default'), 'selected' => ($TOWNFROMINC == 0) ? ' selected ' : ''); $qres = $db->exec(OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_bank_tour_town_list', array(), true); if ($db->numRows($qres) > 0) { $townfrom[] = array('Inc' => -2147483647, 'Name' => 'Другой', 'LName' => 'Other'); while ($row = $db->fetchRow($qres)) { $townfrom[] = $row; } } $tour = array(); $tour[] = array('Inc' => -2147483647, 'Name' => Get_Message_Lang($LNG, 'default'), 'LName' => Get_Message_Lang($LNG, 'default'), 'selected' => ($TOURINC == -2147483647) ? ' selected ' : ''); $qres = $db->exec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_bank_tour_tour_list', array( 'TOWNFROMINC' => $TOWNFROMINC ), true ); if ($db->numRows($qres) > 0) { while ($row = $db->fetchRow($qres)) { $tour[] = $row; } } $bank = array(); $qres = $db->exec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_bank_tour_townfrom_state', array( 'TownFrom' => $TOWNFROMINC, 'Tour' => $TOURINC ), true ); $self_settings_exists = false; if ($db->numRows($qres) > 0) { while ($row = $db->fetchRow($qres)) { $row['self'] = true; if ($TOURINC > 0) { $row['self'] = ($row['Tour'] == $TOURINC); } else { if ($TOWNFROMINC > 0) { $row['self'] = ($row['TownFrom'] == $TOWNFROMINC); } } if (!$self_settings_exists && $row['self']) { $self_settings_exists = true; } $bank[$row['Inc']] = $row; } } $owner = array(); $owner[] = array('Inc' => -2147483647, 'Name' => Get_Message_Lang($LNG, 'default'), 'LName' => Get_Message_Lang($LNG, 'default'), 'selected' => ($OWNERINC == -2147483647) ? ' selected ' : ''); $qres = $db->exec(OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_bank_tour_partners', array(), true); if ($db->numRows($qres) > 0) { while ($row = $db->fetchRow($qres)) { $owner[] = $row; } } $bank_owner = array(); $qres = $db->exec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_bank_tour_owner', array( 'Owner' => $OWNERINC ), true ); $self_settings_exists2 = false; if ($db->numRows($qres) > 0) { while ($row = $db->fetchRow($qres)) { $row['self'] = true; if ($OWNERINC > 0) { $row['self'] = ($row['Owner'] == $OWNERINC); } if (!$self_settings_exists2 && $row['self']) { $self_settings_exists2 = true; } $bank_owner[$row['Inc']] = $row; } } $selectrConditions = $TOWNFROMINC ? ["town = {$TOWNFROMINC}"] : false; if ($_SERVER['REQUEST_METHOD'] == 'POST') { if (isset($_POST['APPLY_ALL']) || isset($_POST['DEFAULT'])) { $conditions = array(); if (isset($_POST['APPLY_ALL'])) { $conditions['Tour'] = -1; if ($TOWNFROMINC != 0) { $conditions['TownFrom'] = $TOWNFROMINC; } } else { if ($TOURINC > 0) { $conditions['Tour'] = $TOURINC; } else { if ($TOWNFROMINC != 0) { $conditions['TownFrom'] = $TOWNFROMINC; } } } $db->exec(OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_Admin_bank_tour_delete_bank_tour', $conditions); $selectrConditions = $conditions; } if (isset($_POST['SAVE']) || isset($_POST['APPLY_ALL'])) { if (isset($_POST['bank']) && is_array($_POST['bank'])) { foreach ($_POST['bank'] as $bankinc => $enable) { $enable = ($enable = intval($enable)) ? $enable : 0; if ($bank[$bankinc]['checked'] != $enable) { $res = $db->exec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_bank_tour_townfrom_state', array( 'TownFrom' => $TOWNFROMINC, 'Tour' => $TOURINC, 'Bank' => $bankinc, 'checked' => $enable ), true ); $row = $db->fetchRow($res); $bank[$bankinc] = array_merge($bank[$bankinc], $row); } } } } if (isset($_POST['APPLY_ALL2']) || isset($_POST['DEFAULT2'])) { $conditions = array(); if (isset($_POST['APPLY_ALL2'])) { $conditions['Owner'] = -1; } elseif ($OWNERINC > 0) { $conditions['Owner'] = $OWNERINC; } $db->exec(OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_Admin_bank_tour_delete_bank_owner', $conditions); } if (isset($_POST['SAVE2']) || isset($_POST['APPLY_ALL2'])) { if (isset($_POST['bank_owner']) && is_array($_POST['bank_owner'])) { foreach ($_POST['bank_owner'] as $bankinc => $enable) { $enable = ($enable = intval($enable)) ? $enable : 0; if ($bank_owner[$bankinc]['checked'] != $enable) { $res = $db->exec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_bank_tour_owner', array( 'Owner' => $OWNERINC, 'Bank' => $bankinc, 'checked' => $enable ), true ); $row = $db->fetchRow($res); $bank_owner[$bankinc] = array_merge($bank_owner[$bankinc], $row); } } } } if (array_intersect_key($_POST, array_fill_keys(['APPLY_ALL', 'DEFAULT', 'SAVE', 'APPLY_ALL2', 'DEFAULT2', 'SAVE2'], true))) { admin_flash(Get_Message_Lang($LNG, 'adm_success_save')); } if (!isset($_POST['NUMBER']) && !isset($_POST['CLAIM']) && !isset($_POST['DATE'])) { header('Location: ' . $_SERVER['REQUEST_URI'] . '?page=' . $ALIAS . '&LNG=' . $LNG, true, 301); exit; } } ?>
<?= admin_flash() ?>
<?= Get_Message_Lang($LNG, 'adm_bank_tour_bank') ?>
<br>
<table class="txt" width="100%">
    <tr>
        <td valign="top" width="50%">
            <table class="config_filter_table">
                <tr>
                    <td class="txt config_filter_what"><?= Get_Message_Lang($LNG, 'townfrom') ?></td>
                    <td class="txt config_filter_value">
                        <select name="TOWNFROMINC"
                                onchange="location.href='?page=<?= $ALIAS ?>&LNG=<?= $LNG ?>&TOWNFROMINC=' + this.value">
                            <?php
 foreach ($townfrom as $key => $val) { ?>
                                <option value="<?= $val['Inc'] ?>" <?= ($TOWNFROMINC == $val['Inc']) ? 'selected' : '' ?>><?= $val['LName'] ?></option>
                                <?php
 } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:top" class="txt config_filter_what"><?= Get_Message_Lang($LNG, 'tour') ?></td>
                    <td class="txt config_filter_value">
                        <?php
 $selector = new TourSelector('TOURINC', 'TOURINC'); $selector->lang = $LNG; $selector->emptyVal = [ 'value' => -2147483647, 'text' => Get_Message_Lang($LNG, 'default') ]; $selector->condition = $selectrConditions; $selector->selected = $TOURINC; $selector->render(); ?>
                        <label for="showAllTours"><?php echo Get_Message_Lang($LNG, 'BRON_SHOW_ALL_TOURS'); ?></label>
                        <input type="checkbox" id="showAllTours" value="1" <?php
 if ($showAllTours) { echo 'checked="checked"'; } ?>>
                    </td>
                </tr>
            </table>
        </td>
        <td valign="bottom" width="50%">
            <table class="config_filter_table">
                <tr>
                    <td class="txt config_filter_what"><?= Get_Message_Lang($LNG, 'adm_bank_owner') ?></td>
                    <td class="txt config_filter_value">
                        <select name="OWNERINC"
                                onchange="location.href='?page=<?= $ALIAS ?>&LNG=<?= $LNG ?>&OWNERINC=' + this.value">
                            <?php
 foreach ($owner as $key => $val) { ?>
                                <option value="<?= $val['Inc'] ?>" <?= ($OWNERINC == $val['Inc']) ? 'selected' : '' ?>><?= $val['LName'] ?></option>
                                <?php
 } ?>
                        </select>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td valign="top">
            <form method="POST"
                  action="?page=<?= $ALIAS ?>&LNG=<?= $LNG ?>&TOWNFROMINC=<?= $TOWNFROMINC ?>&TOURINC=<?= $TOURINC ?>">
                <table class="txt bank">
                    <thead>
                    <tr>
                        <td class="capt border_dark">&nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_name') ?>&nbsp;</td>
                        <td class="capt border_dark">&nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_access') ?>&nbsp;</td>
                    </tr>
                    </thead>
                    <?php
 foreach ($bank as $row) { ?>
                        <tr>
                            <td class="capt1 border"><?= $row['Name'] ?></td>
                            <td class="border checkbox <?= !$row['self'] ? 'td_hidden' : '' ?>"><input type="hidden"
                                                                                                       name="bank[<?= $row['Inc'] ?>]"
                                                                                                       value="0"><input
                                        type="checkbox"
                                        name="bank[<?= $row['Inc'] ?>]" <?= ($row['checked']) ? 'checked' : '' ?>
                                        value="<?= ($row['checked']) ? $row['checked'] : 1 ?>"></td>
                        </tr>
                        <?php
 } ?>
                </table>
                <br>
                <input type="submit" value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>" name="SAVE"
                       class="button">
                <?php
 if ($TOURINC < 0) { ?>
                    <input type="submit" value="<?= Get_Message_Lang($LNG, 'adm_bank_tour_set_for_all') ?>"
                           name="APPLY_ALL" class="button"
                           onclick="return confirm('<?= Get_Message_Lang($LNG, 'adm_bank_delete_settings') ?>')">
                    <?php
 } ?>
                <?php
 if ($self_settings_exists && ($TOURINC > 0 || $TOWNFROMINC != 0)) { ?>
                    <input type="submit" value="<?= Get_Message_Lang($LNG, 'adm_bank_reset_settings') ?>" name="DEFAULT"
                           class="button"
                           onclick="return confirm('<?= Get_Message_Lang($LNG, 'adm_bank_delete_settings') ?>')">
                    <?php
 } ?>
            </form>
        </td>
        <td valign="top">
            <form method="POST" action="?page=<?= $ALIAS ?>&LNG=<?= $LNG ?>&OWNERINC=<?= $OWNERINC ?>">
                <table class="txt bank">
                    <thead>
                    <tr>
                        <td class="capt border_dark">&nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_name') ?>&nbsp;</td>
                        <td class="capt border_dark">&nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_access') ?>&nbsp;</td>
                    </tr>
                    </thead>
                    <?php
 foreach ($bank_owner as $row) { ?>
                        <tr>
                            <td class="capt1 border"><?= $row['Name'] ?></td>
                            <td class="border checkbox <?= !$row['self'] ? 'td_hidden' : '' ?>"><input type="hidden"
                                                                                                       name="bank_owner[<?= $row['Inc'] ?>]"
                                                                                                       value="0"><input
                                        type="checkbox"
                                        name="bank_owner[<?= $row['Inc'] ?>]" <?= ($row['checked']) ? 'checked' : ''; ?>
                                        value="<?= ($row['checked']) ? $row['checked'] : 1 ?>"></td>
                        </tr>
                        <?php
 } ?>
                </table>
                <br>
                <input type="submit" value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>" name="SAVE2"
                       class="button">
                <?php
 if ($OWNERINC < 0) { ?>
                    <input type="submit" value="<?= Get_Message_Lang($LNG, 'adm_bank_tour_set_for_owners') ?>"
                           name="APPLY_ALL2" class="button"
                           onclick="return confirm('<?= Get_Message_Lang($LNG, 'adm_bank_delete_owners') ?>')">
                    <?php
 } ?>
                <?php
 if ($self_settings_exists2 && $OWNERINC > 0) { ?>
                    <input type="submit" value="<?= Get_Message_Lang($LNG, 'adm_bank_reset_settings') ?>"
                           name="DEFAULT2" class="button"
                           onclick="return confirm('<?= Get_Message_Lang($LNG, 'adm_bank_delete_owners') ?>')">
                    <?php
 } ?>
            </form>
        </td>
    </tr>
</table>
<br clear="all">
<script src="<?= $http_site ?>public/js/pack.main.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/selectr/latest/selectr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/selectr/latest/selectr.min.css">
<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {
            $('.bank').delegate('input', 'click', function (e) {
                var $td = $(this).parent();
                if ($td.is('.td_hidden') || $td.is('.shown')) {
                    $(this).parents('td:first').toggleClass('td_hidden', 'shown');
                }
            });
        });
    })(samo.jQuery);
    var selectorTour = document.getElementById('TOURINC');
    var toggleTourListControl = document.getElementById('showAllTours');
    toggleTourListControl.setAttribute('onclick', 'toggleTourList(this)');
    var showAllTours = 0;
    if (toggleTourListControl.checked) {
        showAllTours = 1
    }
    var toggleTourList = function (control) {
        if (control.checked) {
            window.location.href = '?page=<?=$ALIAS?>&LNG=<?=$LNG?>&TOWNFROMINC=<?=$TOWNFROMINC?>&TOURINC=' + selector.getValue() + '&showAllTours=1';
        } else {
            window.location.href = '?page=<?=$ALIAS?>&LNG=<?=$LNG?>&TOWNFROMINC=<?=$TOWNFROMINC?>&showAllTours=0';
        }
    }
    var selector = new Selectr(selectorTour, {
        placeholder: '<?php echo Get_Message_Lang($LNG, 'default');?>'
    });
    selector.on('selectr.select', function (option) {
        var val = option.value;
        window.location.href = '?page=<?=$ALIAS?>&LNG=<?=$LNG?>&TOWNFROMINC=<?=$TOWNFROMINC?>&TOURINC=' + val + '&showAllTours=' + showAllTours
    });
</script>
</body>
