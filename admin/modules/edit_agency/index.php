<?php get_help_button('onlinest:sistema_upravlenija:edit_partner') ?>
<script src="<?= $http_site ?>public/js/pack.main.js"></script>
<?= style_css() ?>
<FORM name="start" action="" method="post">
    <input type="hidden" name="LNG" value="<?= $LNG ?>">
    <input type=hidden name="ADD" value="">
    <input type=hidden name="EDIT" value="">
    <input type=hidden name="SAVE" value="">
    <input type=hidden name="DELETE" value="">
    <input type=hidden name="UNLOCK" value="">
    <?php
 if (!defined('ROUTES_PATH')) { define('ROUTES_PATH', _ROOT . 'routes.php'); } include_once ROUTES_PATH; if (!isset($routes['edit_agency'])) { die(Get_Message_Lang($LNG, 'adm_module_disabled')); } ?>
    <script>
        function Vars(add, edit, save, del, unlock) {
            document.start.ADD.value = add;
            document.start.EDIT.value = edit;
            document.start.SAVE.value = save;
            document.start.DELETE.value = del;
            document.start.UNLOCK.value = unlock;
            document.start.submit();
        }
        function Confirm() {
            Vars('', '', 1, '', 1);
        }
    </script>
    <?php
 $SAVE = 0; if (isset($_POST['SAVE']) or isset($_GET['SAVE'])) { $SAVE = isset($_POST['SAVE']) ? $_POST['SAVE'] : $_GET['SAVE']; } $SAVE = intval($SAVE); $params = [ 'Section' => 'edit_agency', 'What' => 'ENABLE_REQUEST_CHANGES', 'UserCode' => INTERNET_USER, ]; if ($SAVE == 1) { if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ENABLE_REQUEST_CHANGES'])) { $params['Value'] = $_POST['ENABLE_REQUEST_CHANGES']; } } $sql = $db->formatExec('<OFFICEDB>.dbo.up_WEB_3_ADMIN_tour_config', $params); $res = $db->fetchRow($sql); $ENABLE_REQUEST_CHANGES = ($res) ? $res['Value'] : ''; $ENTITY = 'partner'; $PROPS = array('HelpAlt', 'Visible', 'Required', 'Editable'); if ($SAVE == 1) { $fields = get_fields($ENTITY); set_fields($ENTITY, $fields, $PROPS); } $fields = get_fields($ENTITY); $groups = ($fields) ? array_keys($fields) : array(); if ($SAVE == 1) { admin_flash(Get_Message_Lang($LNG, 'adm_success_save')); } ?>
    <?= admin_flash() ?>
    <?= Get_Message_Lang($LNG, 'adm_edit_agency_request_changes') ?>
    <select name="ENABLE_REQUEST_CHANGES" style="margin-bottom: 10px;">
        <option
            value="0" <?= ($ENABLE_REQUEST_CHANGES ? '' : 'selected="selected"') ?>><?= Get_Message_Lang($LNG, 'adm_config_no') ?></option>
        <option
            value="1" <?= ($ENABLE_REQUEST_CHANGES ? 'selected="selected"' : '') ?>><?= Get_Message_Lang($LNG, 'adm_config_yes') ?></option>
    </select>
    <?php
 if (count($fields) > 0) { include _ROOT . 'admin/includes/online-field.php'; ?>
        <input type=button value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>" name=SAVE_BTN class=button
               onClick="Confirm();">
        <?php
 } ?>
</form>