<?php
$SAVE = ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['SAVE']) && $_POST['SAVE'] == 1); if ($SAVE) { $settings = array( 'FIRMCODE', 'INTERNET_USER', 'USER_TO_MESSAGE', 'RESERVE_TODAY', 'STATE_DEFAULT', 'INTERNET_PARTNER', 'ORDER_BY_NAME', 'TOWN_ORDER_BY_NAME', 'STATE_ORDER_BY_NAME', 'FREIGHT_STOPTIME', 'EDIT_ANKETA_BEFORE_FULLTAKENDOC', 'MAP_KEY' ); foreach ($settings as $name) { if (isset($_REQUEST[$name])) { if ($name == 'INTERNET_PARTNER' && empty($_REQUEST[$name])) { $_REQUEST[$name] = -1; } $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Section' => 'online_config', 'What' => $name, 'Value' => $_REQUEST[$name], 'UserCode' => ($name == 'INTERNET_USER') ? null : INTERNET_USER, ] ); $db->query($sql); } } clear_cache('config' . '_' . 'online_config' . '_' . null . '_' . null . '_' . null); admin_flash(Get_Message_Lang($LNG, 'adm_success_save')); header('Location: ' . $_SERVER['REQUEST_URI'] . '?page=' . $ALIAS . '&LNG=' . $LNG, true, 301); exit; } require_once _ROOT . 'admin/common/view/fn.php'; ?>
<body>
<?php get_help_button('onlinest:sistema_upravlenija:config') ?>
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
    <input type=hidden name=REFR value="">
    <?= admin_flash() ?>

    <script language="JavaScript">
        function Check() {
            if (document.start.FIRMCODE && document.start.FIRMCODE.value == '') {
                document.start.FIRMCODE.focus();
                alert("<?= Get_Message_Lang($LNG, 'adm_config_no_owner') ?>");
                return;
            }
            if (document.start.INTERNET_USER && document.start.INTERNET_USER.value == '') {
                document.start.INTERNET_USER.focus();
                alert("<?= Get_Message_Lang($LNG, 'adm_config_no_internet_user') ?>");
                return;
            }
            if (document.start.STATE_DEFAULT && document.start.STATE_DEFAULT.value == '') {
                document.start.STATE_DEFAULT.focus();
                alert("<?= Get_Message_Lang($LNG, 'adm_config_no_state_default') ?>");
                return;
            }
            if (document.start.REC_ON_PAGE && document.start.REC_ON_PAGE.value == '') {
                document.start.REC_ON_PAGE.focus();
                alert("<?= Get_Message_Lang($LNG, 'adm_config_no_price_on_page') ?>");
                return;
            }
            Vars('', '', 1, '', '');
        }
        function RefreshRoom() {
            document.start.REFR.value = 1;
            Vars('', '', '', '', '');
        }
    </script>

    <table class="config_table">
        <tr>
            <td class="capt border_dark config_what"><?= Get_Message_Lang($LNG, 'adm_config_what') ?></td>
            <td class="capt border_dark config_value"><?= Get_Message_Lang($LNG, 'adm_config_value') ?></td>
        </tr>
        <?php
 $what = []; $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'select Inc as StateInc, Name as StateName from State  where inc > 0 order by StateName    '"; $states = $db->fetchAll($sql); $what = get_online_tour_config(); $value = (isset($what['INTERNET_USER'])) ? $what['INTERNET_USER'] : -1; $sql = OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.UP_ONLINE_GET_INTERNET_MANAGER'; $users = $db->fetchAllWithKey($sql, 'Code'); ?>
        <tr>
            <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_config_internet_manager') ?></td>
            <td class="txt border config_value">
                <?php
 if (defined('INTERNET_USER_UNDEFINED')) { ?>
                    <select name="INTERNET_USER" class="element">
                        <option value=""></option>
                        <?php
 foreach ($users as $user) { ?>
                            <option value="<?= $user['Code'] ?>" <?= ($user['Code'] == $value) ? "selected" : '' ?>><?= $user['Name'] ?></option>
                            <?php
 } ?>
                    </select>
                    <?php
 } else { ?>
                    <span style="background-color: lightgray; border: 1px solid gray; line-height: 26px; padding: 2px;"><?= $users[INTERNET_USER]['Name'] ?></span>
                    <?php
 } ?>
                <br>
                <?= Get_Message_Lang($LNG, 'adm_config_used_author_internal_messages') ?>
            </td>
        </tr>
        <?php
 if (INTERNET_USER !== false) { $value = (isset($what['STATE_DEFAULT'])) ? $what['STATE_DEFAULT'] : -1; ?>
            <tr>
                <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_config_state_default') ?></td>
                <td class="txt border config_value">
                    <select name="STATE_DEFAULT" class="element">
                        <option value="">----</option>
                        <?php
 foreach ($states as $state) { ?>
                            <option
                                    value="<?= $state['StateInc'] ?>" <?= ($state['StateInc'] == $value) ? "selected" : '' ?>><?= $state['StateName'] ?></option>
                            <?php
 } ?>
                    </select>
                    <br>
                    <?= Get_Message_Lang($LNG, 'adm_config_used_in_param_search') ?>
                </td>
            </tr>

            <?php
 $value = (isset($what['FIRMCODE'])) ? $what['FIRMCODE'] : -1; ?>
            <tr>
                <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_config_default_owner') ?></td>
                <td class="txt border config_value">
                    <select name="FIRMCODE" class="element">
                        <option value=""></option>
                        <?php
 $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'select Inc as PartnerInc, Name as PartnerName from Partner where inc > 0 and parttype = 1 order by PartnerName'"; $partners = $db->fetchAll($sql); foreach ($partners as $partner) { ?>
                            <option
                                    value="<?= $partner['PartnerInc'] ?>" <?= ($partner['PartnerInc'] == $value) ? "selected" : '' ?>><?= $partner['PartnerName'] ?></option>
                            <?php
 } ?>
                    </select>
                    <br>
                    <?= Get_Message_Lang($LNG, 'adm_config_used_in_calc_place') ?>
                </td>
            </tr>
            <?php
 $value = (isset($what['USER_TO_MESSAGE'])) ? $what['USER_TO_MESSAGE'] : -1; ?>
            <tr>
                <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_config_online_manager') ?></td>
                <td class="txt border config_value">
                    <select name="USER_TO_MESSAGE" class="element">
                        <option value=""></option>
                        <?php
 $sql = OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.UP_ONLINE_GET_MESSAGE_MANAGER'; $qres2 = $db->fetchAll($sql); foreach ($qres2 as $row2) { ?>
                            <option value="<?= $row2['Code'] ?>" <?= ($row2['Code'] == $value) ? "selected" : '' ?>>
                                <?= ($row2['Code'] >= 10000) ? Get_Message_Lang($LNG, 'adm_config_online_group') : '' ?>
                                <?= $row2['Name'] ?>
                            </option>
                            <?php
 } ?>
                    </select>
                    <br>
                    <?= Get_Message_Lang($LNG, 'adm_config_online_manager_note') ?>
                </td>
            </tr>
            <?php
 $value = isset($what['ORDER_BY_NAME']) ? $what['ORDER_BY_NAME'] : 0; draw_tr_yes_no($fieldname = Get_Message_Lang($LNG, 'adm_config_order_by_name'), $select_name = 'ORDER_BY_NAME', $value, $where = Get_Message_Lang($LNG, 'adm_config_used_in_online_modules'), $LNG); $value = isset($what['TOWN_ORDER_BY_NAME']) ? $what['TOWN_ORDER_BY_NAME'] : 0; draw_tr_yes_no($fieldname = Get_Message_Lang($LNG, 'adm_config_town_rus'), $select_name = 'TOWN_ORDER_BY_NAME', $value, $where = Get_Message_Lang($LNG, 'adm_config_comment'), $LNG); $value = isset($what['STATE_ORDER_BY_NAME']) ? $what['STATE_ORDER_BY_NAME'] : 0; draw_tr_yes_no($fieldname = Get_Message_Lang($LNG, 'adm_config_state_rus'), $select_name = 'STATE_ORDER_BY_NAME', $value, $where = Get_Message_Lang($LNG, 'adm_config_comment'), $LNG); ?>
            <?php
 $value = isset($what['EDIT_ANKETA_BEFORE_FULLTAKENDOC']) ? $what['EDIT_ANKETA_BEFORE_FULLTAKENDOC'] : 0; draw_tr_yes_no($fieldname = Get_Message_Lang($LNG, 'adm_config_edit_anketa_before_fulltakendoc'), $select_name = 'EDIT_ANKETA_BEFORE_FULLTAKENDOC', $value, '', $LNG); $value = isset($what['MAP_KEY']) ? $what['MAP_KEY'] : ''; ?>
            <tr>
                <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_config_edit_google_map_key') ?></td>
                <td class="txt border config_value">
                        <input type="text" id="MAP_KEY" name="MAP_KEY" value="<?php echo $value ?>" style="width: 50%;"/>
                </td>
            </tr>
        <?php
 } ?>
    </table>
    <br clear="all">
    <input type=button value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>" name="BSAVE" class="button"
           onClick="Check();">
</form>
</body>
