<?php
if (!defined('ROUTES_PATH')) { define('ROUTES_PATH', _ROOT . 'routes.php'); } include_once ROUTES_PATH; if (!isset($routes['cancel_claim'])) { die(Get_Message_Lang($LNG, 'adm_module_disabled')); } require _ROOT . 'admin/includes/tour-selector.php'; $showAllTours = !isset($_GET['showAllTours']) ? false : $_GET['showAllTours']; ?>
<body>
<?php get_help_button('onlinest:sistema_upravlenija:req_cancel') ?>
<?= style_css() ?>
<FORM name="start" action="" method="post">
    <input type="hidden" name="LNG" value="<?= $LNG ?>">
    <input type=hidden name="ADD" value="">
    <input type=hidden name="EDIT" value="">
    <input type=hidden name="SAVE" value="">
    <input type=hidden name="DELETE" value="">
    <input type=hidden name="UNLOCK" value="">
    <?php
 $templateDir = $folder_site . '/data/cancel_claim/'; $TOURINC = (isset($_GET['TOURINC']) && $tmp = intval($_GET['TOURINC'])) ? $tmp : 0; ?>
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
 if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['SAVE'])) { foreach (['CANCEL_DAYS' => 'intval'] AS $what => $escape) { $value = isset($_REQUEST[$what]) ? $_REQUEST[$what] : null; $value = call_user_func($escape, $value); if (!is_null($value)) { $res = $db->exec( OFFICE_SQLSERVER . "." . OFFICEDB . ".[dbo].[up_WEB_3_ADMIN_tour_config]", [ 'Section' => 'cancel_claim', 'What' => $what, 'Value' => $value, 'UserCode' => INTERNET_USER, ] ); } } $agreement_text = (isset($_POST['agreement_text'])) ? $_POST['agreement_text'] : ''; if (strlen(trim(strip_tags($agreement_text))) < 10) { $sql = sprintf( OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'
                    DELETE FROM [dbo].[online_tour_config]
                        WHERE [Inc] IN (
                            SELECT Inc FROM (
                                SELECT [Inc],
                                    ROW_NUMBER() OVER (PARTITION BY [What] ORDER BY [user_code] DESC) AS [Sort]
                                    FROM [dbo].[online_tour_config]
                                WHERE ([user_code] = @UserCode OR [user_code] IS NULL)
                                    AND (([tour] IS NULL AND @Tour IS NULL) OR ([tour] = @Tour))
                                    AND [Section] = ''cancel_claim''
                                    AND [What] = ''agreement''
                                ) [s]
                        WHERE [s].[Sort] = 1
                )
                ', N'@UserCode INT, @Tour INT', %s, %s", INTERNET_USER, $TOURINC ? $TOURINC : 'null' ); } else { $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Section' => 'cancel_claim', 'What' => 'agreement', 'Tour' => $TOURINC ? $TOURINC : null, 'Value' => $agreement_text, 'UserCode' => INTERNET_USER, ] ); } $res = $db->query($sql); admin_flash(Get_Message_Lang($LNG, 'adm_success_save')); } $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.[dbo].[up_web_3_admin_tour_config]', [ 'Section' => 'cancel_claim', 'UserCode' => INTERNET_USER, 'Tour' => $TOURINC ? $TOURINC : null, ] ); $cfg = $db->fetchAllWithKey($sql, 'What'); ?>
    <?= admin_flash() ?>
    <table class="config_table">
        <tr>
            <td class="capt border_dark config_what"><?= Get_Message_Lang($LNG, 'adm_config_what') ?></td>
            <td class="capt border_dark config_value"><?= Get_Message_Lang($LNG, 'adm_config_value') ?></td>
        </tr>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_cancel_claim_stop_days') ?></td>
            <td class="txt border config_value">
                <select id="CANCEL_DAYS" name="CANCEL_DAYS" class="element">
                    <?php
 for ($i = 0; $i <= 60; $i++) { ?>
                        <option
                            value="<?= $i ?>" <?= ($i == $cfg['CANCEL_DAYS']['Value']) ? 'selected' : '' ?>><?= $i ?></option>
                    <?php
 } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_agreement_text') ?></td>
            <td class="txt border config_value">
                <table style="font-size: 12px">
                    <tr>
                        <td>
                            <strong><?php echo Get_Message_Lang($LNG, 'tour'); ?></strong>
                            <br><label for="showAllTours"><?php echo Get_Message_Lang($LNG, 'BRON_SHOW_ALL_TOURS'); ?></label>
                            <input type="checkbox" id="showAllTours" value="1" <?php
 if ($showAllTours) { echo 'checked'; } ?>>
                        </td>
                        <td>
                            <?php
 $control = new TourSelector('AGREEMENT_TOUR', 'TOURINC'); $control->lang = $LNG; $control->selected = $TOURINC; $control->emptyVal = [ 'value' => 0, 'text' => '-----------' ]; $control->render(); ?>
                        </td>
                    </tr>
                </table>
                <?php
 require_once $folder_site . '/vendor/fckeditor/fckeditor.php'; $hEdit = new FCKeditor('agreement_text'); $hEdit->Width = '100%'; $hEdit->Height = '240'; $hEdit->ToolbarSet = 'Public'; $hEdit->Value = array_key_exists('agreement', $cfg) ? $cfg['agreement']['Value'] : ''; $hEdit->Create(); ?>
            </td>
        </tr>

    </table>
    <br clear="all">
    <input type=button value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>" name="BSAVE" class="button"
           onClick="Vars('','',1,'','')">
</form>
<script type="text/javascript" src="https://cdn.jsdelivr.net/selectr/latest/selectr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/selectr/latest/selectr.min.css">
<script>
    var selectorTour = document.getElementById('AGREEMENT_TOUR');
    var toggleTourListControl = document.getElementById('showAllTours');
    toggleTourListControl.setAttribute('onclick', 'toggleTourList(this)');
    var toggleTourList = function (control) {
        if (control.checked) {
            window.location.href = '?page=<?php echo $ALIAS; ?>&LNG=<?php echo $LNG; ?>&showAllTours=1&TOURINC=' + selector.getValue() + '#AGREEMENT_TOUR';
        } else {
            window.location.href = '?page=<?php echo $ALIAS; ?>&LNG=<?php echo $LNG; ?>&showAllTours=0&#AGREEMENT_TOUR';
        }
    }
    var selector = new Selectr(selectorTour, {
        width: 320,
        placeholder: '-----------'
    });
    selector.on('selectr.select', function (option) {
        var val = option.value;
        var showAll = toggleTourListControl.checked, showAllTours = 0;
        if (showAll) {
            showAllTours = 1;
        }
        window.location.href = '?page=<?php echo $ALIAS; ?>&LNG=<?php echo $LNG; ?>&showAllTours=' + showAllTours + '&TOURINC=' + val + '#AGREEMENT_TOUR'
    });
</script>
</body>
