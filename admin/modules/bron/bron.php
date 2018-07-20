<?php
if (!defined('ROUTES_PATH')) { define('ROUTES_PATH', _ROOT . 'routes.php'); } include_once ROUTES_PATH; if (!isset($routes['bron'])) { die(Get_Message_Lang($LNG, 'adm_module_disabled')); } require_once _ROOT . 'admin/common/view/fn.php'; require_once _ROOT . 'admin/common/dbset/bron.php'; require _ROOT . 'admin/includes/tour-selector.php'; $what = get_online_tour_config(); ?>
<body>
<?php get_help_button('onlinest:sistema_upravlenija:saving') ?>
<?= style_css() ?>
<FORM name="start" action="" method="post">
    <input type="hidden" name="LNG" value="<?= $LNG ?>">
    <input type=hidden name="ADD" value="">
    <input type=hidden name="EDIT" value="">
    <input type=hidden name="SAVE" value="">
    <input type=hidden name="DELETE" value="">
    <input type=hidden name="UNLOCK" value="">
    <?php
 $SAVE = (isset($_POST['SAVE']) && ($_POST['SAVE'] == 1)) ? true : false; $TOURINC_AGRE = (isset($_GET['TOURINC_AGRE']) && $tmp = intval($_GET['TOURINC_AGRE'])) ? $tmp : 0; $showAllTours = !isset($_GET['showAllTours']) ? false : $_GET['showAllTours']; $CONTENT = null; $permition = get_module_permission($alias_rule_module); $templateDir = $folder_site . '/data/bron/'; $success = true; ?>
    <script>
        function Vars(add, edit, save, del, unlock) {
            <?php
 if ($permition == 0) { ?>
            alert("Вам разрешен только просмотр. Only view.");
            <?php
 } elseif ($permition == 1) { ?>
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
    <?= admin_flash() ?>
    <?php
 $default_param = array( 'section' => 'bron', 'name' => null, 'default' => 0, 'escape' => function ($val) { return intval($val); }, ); $settings = array( 'OWNER', 'CHECK_AGREEMENT_DATE', 'SHOW_COST_SERVICE_REQUIRED', 'FREIGHT_CROSS_CLASSES', 'SEAT_YOUNGEST_INFANT_WITH_ADULT', 'CONFIG_CHILDREN_PLACE_INAVIA', 'ENABLE_PRICE_CALENDAR', 'CONTACTS', 'REKLAMA', ); $settings = array_map( function ($param) use ($default_param) { if (is_scalar($param)) { $param = array('name' => $param); } return array_merge($default_param, $param); }, $settings ); $settings = array_combine( array_map( function ($param) { return $param['name']; }, $settings ), $settings ); $settings['ENABLE_PRICE_CALENDAR']['default'] = 1; $have_many_owners = false; $sql = OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_bron_owners'; $res = $db->query($sql); if ($res && $db->numRows($res) > 1) { $have_many_owners = true; } $readConfig = function ($param) use ($db) { $sql = $db->formatExec( OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.[up_WEB_3_ADMIN_tour_config]", [ 'Section' => $param['section'], 'What' => $param['name'], 'UserCode' => INTERNET_USER, 'Tour' => array_key_exists('tour', $param) ? $param['tour'] : null, ] ); if ($value = $db->fetchRow($sql)) { $value = isset($param['escape']) && is_callable($param['escape']) ? $param['escape']($value['Value']) : $value['Value']; } else { $value = array_key_exists('default', $param) ? $param['default'] : null; } return $value; }; $saveConfig = function ($param) use ($db) { $value = isset($_REQUEST[$param['name']]) ? $_REQUEST[$param['name']] : $param['default']; $value = isset($param['escape']) && is_callable($param['escape']) ? $param['escape']($value) : $value; if (!is_null($value)) { $res = $db->exec( OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.[up_WEB_3_ADMIN_tour_config]", [ 'Section' => $param['section'], 'What' => $param['name'], 'Value' => $value, 'UserCode' => INTERNET_USER, ] ); } }; if ($SAVE) { foreach ($settings as $param) { $saveConfig($param); } $CALCULATED_CLAIM_TEXT = (isset($_POST['CALCULATED_CLAIM_TEXT'])) ? $_POST['CALCULATED_CLAIM_TEXT'] : ''; if (strlen(trim(strip_tags($CALCULATED_CLAIM_TEXT))) < 10) { $sql = $db->formatQuery( 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'
                    DELETE FROM dbo.online_tour_config
                        WHERE [inc] IN (
                            SELECT TOP 1 [inc] FROM dbo.online_tour_config
                            WHERE
                                [section] = ''bron''
                                AND [what] = ''CALCULATED_CLAIM_TEXT''
                                AND ((@UserCode IS NOT NULL AND @UserCode = [user_code]) OR [user_code] IS NULL)
                            ORDER BY [user_code] DESC
                        )
                ',
                N'@UserCode INT', %s", [INTERNET_USER] ); } else { $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Tour' => null, 'Section' => 'bron', 'What' => 'CALCULATED_CLAIM_TEXT', 'Value' => $CALCULATED_CLAIM_TEXT, 'UserCode' => INTERNET_USER, ] ); } $res = $db->query($sql); clear_cache('config' . '_' . 'bron' . '_' . null . '_' . null . '_' . null); $agreement_text = (isset($_POST['agreement_text'])) ? $_POST['agreement_text'] : ''; if (strlen(trim(strip_tags($agreement_text))) < 10) { $sql = sprintf( OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'
                    DELETE FROM [dbo].[online_tour_config]
                        WHERE [Inc] IN (
                            SELECT Inc FROM (
                                SELECT [Inc],
                                    ROW_NUMBER() OVER (PARTITION BY [What] ORDER BY [user_code] DESC) AS [Sort]
                                    FROM [dbo].[online_tour_config]
                                WHERE ([user_code] = @UserCode OR [user_code] IS NULL)
                                    AND (([tour] IS NULL AND @Tour IS NULL) OR ([tour] = @Tour))
                                    AND [Section] = ''bron''
                                    AND [What] = ''agreement''
                                ) [s]
                        WHERE [s].[Sort] = 1
                )
                ', N'@UserCode INT, @Tour INT', %s, %s", INTERNET_USER, $TOURINC_AGRE ? $TOURINC_AGRE : 'null' ); } else { $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Section' => 'bron', 'What' => 'agreement', 'Tour' => $TOURINC_AGRE ? $TOURINC_AGRE : null, 'Value' => $agreement_text, 'UserCode' => INTERNET_USER, ] ); } $res = $db->query($sql); if ($SAVE) { $settings = array( 'RESERVE_TODAY', 'INTERNET_PARTNER', 'FREIGHT_STOPTIME' ); foreach ($settings as $name) { if (isset($_REQUEST[$name])) { if ($name == 'INTERNET_PARTNER' && empty($_REQUEST[$name])) { $_REQUEST[$name] = -1; } $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Section' => 'online_config', 'What' => $name, 'Value' => $_REQUEST[$name], 'UserCode' => ($name == 'INTERNET_USER') ? null : INTERNET_USER, ] ); $db->query($sql); } } } clear_cache('config' . '_' . 'online_config' . '_' . null . '_' . null . '_' . null); clear_cache('config' . '_' . 'bron' . '_' . null . '_' . null . '_' . $TOURINC_AGRE ? $TOURINC_AGRE : null); if ($success) { admin_flash(Get_Message_Lang($LNG, 'adm_success_save')); header('Location: ' . $_SERVER['REQUEST_URI'] . '?page=' . $ALIAS . '&LNG=' . $LNG, true, 301); } } ?>
    <table class="config_table">
        <tr>
            <td class="capt border_dark config_what"><?= Get_Message_Lang($LNG, 'adm_config_what') ?></td>
            <td class="capt border_dark config_value"><?= Get_Message_Lang($LNG, 'adm_config_value') ?></td>
        </tr>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_bron_owner') ?></td>
            <td class="txt border config_value">
                <select name="OWNER" class="element">
                    <?php
 $value = $readConfig($settings['OWNER']); ?>
                    <option value="0" <?= (0 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_bron_insignificant_agreement') ?></option>
                    <option value="1" <?= (1 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_bron_required_agreement') ?></option>
                    <?php
 if ($have_many_owners) { ?>
                        <option value="2" <?= (2 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_bron_owner_select') ?></option>
                        <?php
 } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_bron_check_agreement_date') ?></td>
            <td class="txt border config_value">
                <select name="CHECK_AGREEMENT_DATE" class="element">
                    <?php
 $value = $readConfig($settings['CHECK_AGREEMENT_DATE']); ?>
                    <option value="0" <?= (0 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_no') ?></option>
                    <option value="1" <?= (1 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_yes') ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_config_children_place_inavia') ?></td>
            <td class="txt border config_value">
                <select name="CONFIG_CHILDREN_PLACE_INAVIA" class="element">
                    <?php
 $value = $readConfig($settings['CONFIG_CHILDREN_PLACE_INAVIA']); ?>
                    <option value="0" <?= (0 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_no') ?></option>
                    <option value="1" <?= (1 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_yes') ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_bron_show_cost_service_required') ?></td>
            <td class="txt border config_value">
                <select name="SHOW_COST_SERVICE_REQUIRED" class="element">
                    <?php
 $value = $readConfig($settings['SHOW_COST_SERVICE_REQUIRED']); ?>
                    <option value="0" <?= (0 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_no') ?></option>
                    <option value="1" <?= (1 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_yes') ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_bron_freight_cross_classes') ?></td>
            <td class="txt border config_value">
                <select name="FREIGHT_CROSS_CLASSES" class="element">
                    <?php
 $value = $readConfig($settings['FREIGHT_CROSS_CLASSES']); ?>
                    <option value="0" <?= (0 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_no') ?></option>
                    <option value="1" <?= (1 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_yes') ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_bron_seat_youngest_infant_with_adult') ?></td>
            <td class="txt border config_value">
                <select name="SEAT_YOUNGEST_INFANT_WITH_ADULT" class="element">
                    <?php
 $value = $readConfig($settings['SEAT_YOUNGEST_INFANT_WITH_ADULT']); ?>
                    <option value="0" <?= (0 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_no') ?></option>
                    <option value="1" <?= (1 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_yes') ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_bron_enable_price_calendar') ?></td>
            <td class="txt border config_value">
                <select name="ENABLE_PRICE_CALENDAR" class="element">
                    <?php
 $value = $readConfig($settings['ENABLE_PRICE_CALENDAR']); ?>
                    <option value="0" <?= (0 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_no') ?></option>
                    <option value="1" <?= (1 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_yes') ?></option>
                </select>
            </td>
        </tr>
        <?php
 $value = isset($what['RESERVE_TODAY']) ? $what['RESERVE_TODAY'] : 0; draw_tr_yes_no(Get_Message_Lang($LNG, 'adm_config_today_bron'), 'RESERVE_TODAY', $value, '', $LNG); $sql = "EXEC " . OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.sp_executesql N'SELECT [t].[lname] as [TourLName], [t].[Inc] as [TourInc] FROM [dbo].[tour] [t] WHERE [t].[inc] > 2 ORDER BY [TourLName]'"; $tour_list = $db->fetchAll($sql); $value = isset($what['INTERNET_PARTNER']) ? $what['INTERNET_PARTNER'] : -1; ?>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_config_internet_partner_commission') ?></td>
            <td class="txt border config_value">
                <select name="INTERNET_PARTNER" class="element">
                    <option value="">---</option>
                    <?php
 $partners = get_partners($db); foreach ($partners as $partner) { ?>
                        <option
                                value="<?= $partner['PartnerInc'] ?>" <?= ($partner['PartnerInc'] == $value) ? "selected" : '' ?>><?= $partner['PartnerName'] ?></option>
                        <?php
 } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_config_freight_stoptime') ?></td>
            <td class="txt border config_value">
                <select name="FREIGHT_STOPTIME" class="element">
                    <option
                            value="" <?= (!(isset($what['FREIGHT_STOPTIME']) && intval($what['FREIGHT_STOPTIME']) && $what['FREIGHT_STOPTIME'] > 0 && $what['FREIGHT_STOPTIME'] < 25)) ? "selected" : '' ?>>
                        ---
                    </option>
                    <?php
 for ($i = 1; $i < 25; $i++) { ?>
                        <option
                                value="<?= $i ?>" <?= (isset($what['FREIGHT_STOPTIME']) && intval($what['FREIGHT_STOPTIME']) && $what['FREIGHT_STOPTIME'] > 0 && $what['FREIGHT_STOPTIME'] < 25 && $what['FREIGHT_STOPTIME'] == $i) ? "selected" : '' ?>><?= $i ?></option>
                        <?php
 } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_config_contacts_bron') ?></td>
            <td class="txt border config_value">
                <select name="CONTACTS" class="element">
                    <?php
 $value = $readConfig($settings['CONTACTS']); ?>
                    <option value="0" <?= (0 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_bron_contracts_no') ?></option>
                    <option value="1" <?= (1 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_bron_contracts_yes') ?></option>
                    <option value="2" <?= (2 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_bron_contracts_required') ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_config_reklama_bron') ?></td>
            <td class="txt border config_value">
                <select name="REKLAMA" class="element">
                    <?php
 $value = $readConfig($settings['REKLAMA']); ?>
                    <option value="0" <?= (0 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_bron_reklama_no') ?></option>
                    <option value="1" <?= (1 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_bron_reklama_yes') ?></option>
                    <option value="2" <?= (2 == $value) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_bron_reklama_required') ?></option>
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
                            <br><label
                                    for="showAllTours"><?php echo Get_Message_Lang($LNG, 'BRON_SHOW_ALL_TOURS'); ?></label>
                            <input type="checkbox" id="showAllTours" value="1" <?php
 if ($showAllTours) { echo 'checked'; } ?>>
                        </td>
                        <td>
                            <?php
 $control = new TourSelector('TOURINC_AGRE', 'TOURINC_AGRE'); $control->lang = $LNG; $control->selected = $TOURINC_AGRE; $control->emptyVal = [ 'value' => 0, 'text' => '-----------' ]; $control->render(); ?>
                        </td>
                    </tr>
                </table>
                <?php
 $value = $readConfig(['section' => 'bron', 'name' => 'agreement', 'tour' => $TOURINC_AGRE ? $TOURINC_AGRE : null]); $hEdit = new FCKeditor('agreement_text'); $hEdit->Width = '100%'; $hEdit->Height = '240'; $hEdit->ToolbarSet = 'Public'; $hEdit->Value = $value; $hEdit->Create(); ?>
            </td>
        </tr>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_bron_calculated_claim_text') ?></td>
            <td class="txt border config_value">
                <?php
 $value = $readConfig(['section' => 'bron', 'name' => 'CALCULATED_CLAIM_TEXT', 'tour' => null]); $hEdit = new FCKeditor('CALCULATED_CLAIM_TEXT'); $hEdit->Width = '100%'; $hEdit->Height = '240'; $hEdit->ToolbarSet = 'Public'; $hEdit->Value = $value; $hEdit->Create(); ?>
            </td>
        </tr>
    </table>
    <br clear="all">
    <input type=button value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>" name="BSAVE" class="button"
           onClick="Vars('', '', 1, '', '')">
</form>
<script type="text/javascript" src="https://cdn.jsdelivr.net/selectr/latest/selectr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/selectr/latest/selectr.min.css">
<script>
    var selectorTour = document.getElementById('TOURINC_AGRE');
    var toggleTourListControl = document.getElementById('showAllTours');
    toggleTourListControl.setAttribute('onclick', 'toggleTourList(this)');
    var toggleTourList = function (control) {
        if (control.checked) {
            window.location.href = '?page=<?php echo $ALIAS; ?>&LNG=<?php echo $LNG; ?>&showAllTours=1&TOURINC_AGRE=' + selector.getValue() + '#TOURINC_AGRE';
        } else {
            window.location.href = '?page=<?php echo $ALIAS; ?>&LNG=<?php echo $LNG; ?>&showAllTours=0&#TOURINC_AGRE';
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
        window.location.href = '?page=<?php echo $ALIAS; ?>&LNG=<?php echo $LNG; ?>&showAllTours=' + showAllTours + '&TOURINC_AGRE=' + val + '#TOURINC_AGRE'
    });
</script>
</body>
