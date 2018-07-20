<?php
if (!defined('ROUTES_PATH')) { define('ROUTES_PATH', _ROOT . 'routes.php'); } include_once ROUTES_PATH; if (!isset($routes['registration'])) { die(Get_Message_Lang($LNG, 'adm_module_disabled')); } ?>
<body>
<script src="<?= $http_site ?>public/js/pack.main.js"></script>
<?= style_css() ?>
<?php get_help_button('onlinest:sistema_upravlenija:login_pass') ?>

<FORM name="start" action="" method="post">
    <input type="hidden" name="LNG" value="<?= $LNG ?>">
    <input type=hidden name="ADD" value="">
    <input type=hidden name="EDIT" value="">
    <input type=hidden name="SAVE" value="">
    <input type=hidden name="DELETE" value="">
    <input type=hidden name="UNLOCK" value="">
    <?php
 extract($_POST); $SAVE = $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['SAVE']) && $_POST['SAVE'] == 1 ? 1 : 0; ?>
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
 $ENTITY = 'partpass'; $PROPS = array('HelpAlt', 'Visible', 'Required', 'Editable'); if (isset($SAVE) and ($SAVE == 1)) { $fields = get_fields($ENTITY); set_fields($ENTITY, $fields, $PROPS); admin_flash(Get_Message_Lang($LNG, 'adm_success_save')); } ?>
    <?= admin_flash() ?>
    <?php
 $fields = get_fields($ENTITY); $groups = ($fields) ? array_keys($fields) : array(); if (count($fields) > 0) { include _ROOT . 'admin/includes/online-field.php'; } ?>
    <input type=button value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>" name="BSAVE" class="button"
           onClick="Vars('','',1,'','')">
</form>
</body>
