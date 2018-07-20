<?php
if (!defined('ROUTES_PATH')) { define('ROUTES_PATH', _ROOT . 'routes.php'); } include_once ROUTES_PATH; if (!isset($routes['bron_person'])) { die(Get_Message_Lang($LNG, 'adm_module_disabled')); } ?>
<body>
<script src="<?= $http_site ?>public/js/pack.main.js"></script>
<?php get_help_button('onlinest:sistema_upravlenija:bron_person') ?>
<?= style_css() ?>
<?php
 $SAVE = $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['SAVE']) ? 1 : 0; $RESTORE = $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['RESTORE']) ? 1 : 0; $ENTITY = 'phys_byer'; $PROPS = array('HelpAlt', 'Visible', 'Required', 'Editable'); $CONTENT = null; $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Section' => 'bron_person', 'UserCode' => INTERNET_USER, ] ); $cfg = $db->fetchAllWithKey($sql, 'What'); if (isset($SAVE) and ($SAVE == 1)) { if ($_ACCESS) { $proc = OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config'; if (isset($_POST['bron_person']['status7'])) { $new_value = intval($_POST['bron_person']['status7']); if ($new_value != $cfg['status7']['Value']) { $params = [ 'Section' => 'bron_person', 'What' => 'status7', 'UserCode' => INTERNET_USER, 'Value' => $new_value, ]; $sql = $db->formatExec($proc, $params); $db->query($sql); $cfg['status7']['Value'] = $new_value; } } if (isset($_POST['bron_person']['pay_redirect'])) { $new_value = intval($_POST['bron_person']['pay_redirect']); $old_value = isset($cfg['pay_redirect']['Value']) ? $cfg['pay_redirect']['Value'] : -1; if ($new_value != $old_value) { $params = [ 'Section' => 'bron_person', 'What' => 'pay_redirect', 'UserCode' => INTERNET_USER, 'Value' => $new_value, ]; $sql = $db->formatExec($proc, $params); $db->query($sql); $cfg['pay_redirect']['Value'] = $new_value; } } if (isset($_POST['bron_person']['AGREE_PROCESSING_PERSONAL_DATA'])) { $new_value = trim($_POST['bron_person']['AGREE_PROCESSING_PERSONAL_DATA']); if ($new_value != $cfg['AGREE_PROCESSING_PERSONAL_DATA']['Value']) { $params = [ 'Section' => 'bron_person', 'What' => 'AGREE_PROCESSING_PERSONAL_DATA', 'UserCode' => INTERNET_USER, 'Value' => $new_value, ]; $sql = $db->formatExec($proc, $params); $db->query($sql); $cfg['AGREE_PROCESSING_PERSONAL_DATA']['Value'] = $new_value; } } if (isset($_POST['field'])) { $fields = get_fields($ENTITY); set_fields($ENTITY, $fields, $PROPS); } admin_flash(Get_Message_Lang($LNG, 'adm_success_save')); } else { admin_flash(Get_Message_Lang($LNG, 'adm_only_view')); } } ?>
<?= admin_flash() ?>
<FORM name="start" action="" method="post">
    <table class="config_table">
        <tr>
            <td class="capt border_dark config_what"><?= Get_Message_Lang($LNG, 'adm_config_what') ?></td>
            <td class="capt border_dark config_value"><?= Get_Message_Lang($LNG, 'adm_config_value') ?></td>
        </tr>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_bron_person_claim_status7') ?></td>
            <td class="txt border config_value">
                <select name="bron_person[status7]" class="element">
                    <option
                            value="0" <?= $cfg['status7']['Value'] ? '' : 'selected="selected"' ?> ><?= Get_Message_Lang($LNG, 'adm_config_no') ?></option>
                    <option
                            value="1" <?= $cfg['status7']['Value'] ? 'selected="selected"' : '' ?> ><?= Get_Message_Lang($LNG, 'adm_config_yes') ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_bron_person_redirect_to_payment') ?></td>
            <td class="txt border config_value">
                <?php
 $pay_redirect = isset($cfg['pay_redirect']['Value']) ? $cfg['pay_redirect']['Value'] : 0; ?>
                <select name="bron_person[pay_redirect]" class="element">
                    <option
                            value="0" <?= $pay_redirect == 0 ? 'selected="selected"' : '' ?> ><?= Get_Message_Lang($LNG, 'adm_config_no') ?></option>
                    <option
                            value="1" <?= $pay_redirect == 1 ? 'selected="selected"' : '' ?> ><?= Get_Message_Lang($LNG, 'adm_config_yes') ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_bron_person_agree_processing_personal_data') ?></td>
            <td class="txt border config_value">
                <?php
 require_once $folder_site . '/vendor/fckeditor/fckeditor.php'; $hEdit = new FCKeditor('bron_person[AGREE_PROCESSING_PERSONAL_DATA]'); $hEdit->Width = '100%'; $hEdit->Height = '240'; $hEdit->ToolbarSet = 'Simple'; $hEdit->Value = $cfg['AGREE_PROCESSING_PERSONAL_DATA']['Value']; $hEdit->Create(); ?>
            </td>
        </tr>
    </table>
    <br clear="all">
    <input type="submit" value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>" name="SAVE" class="button">
</form>
<?php
$fields = get_fields($ENTITY); $groups = ($fields) ? array_keys($fields) : array(); if (count($fields) > 0) { ?>
    <form name="start" action="?" method="post">
        <input type="hidden" name="page" value="<?= $ALIAS ?>">
        <input type="hidden" name="LNG" value="<?= $LNG ?>">
        <?php
 include _ROOT . 'admin/includes/online-field.php'; ?>
        <br clear="all">
        <input type="submit" value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>" name="SAVE" class="button">
    </form>
    <?php
} ?>
</body>