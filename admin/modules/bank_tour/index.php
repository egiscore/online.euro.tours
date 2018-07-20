<?php
if (!defined('ROUTES_PATH')) { define('ROUTES_PATH', _ROOT . 'routes.php'); } include_once ROUTES_PATH; if (!isset($routes['wspay'])) { die(Get_Message_Lang($LNG, 'adm_module_disabled')); } ?>
<body>
<?php get_help_button('onlinest:sistema_upravlenija:wspay') ?>
<?= style_css() ?>
<style>
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
    function DelButtonClick(inumber) {
        if (confirm('<?= Get_Message_Lang($LNG, 'adm_bank_del_pay') ?> ' + inumber + "?")) {
            document.start.INUMBER.value = inumber;
            Vars('', '', '', 1, '');
        }
    }
</script>

<?php
if (isset($DELETE) && $DELETE == 1) { include_once _ROOT . 'includes/classes/class.samo_config.php'; Samo_Loader::register_autoload(); $db->exec(OFFICE_SQLSERVER . '.' . BANKDB . '.dbo.up_WEB_3_Admin_bank_tour_Delete_Invoice', array('INUMBER' => $INUMBER)); $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.[up_WEB_3_ADMIN_tour_config]', [ 'Section' => 'online_config', 'What' => 'BUH_EMAIL', 'UserCode' => INTERNET_USER, ] ); $row = $db->fetchRow($sql); $email = ($row['Value']) ? $row['Value'] : FIRM_ADMIN_EMAIL; if (strlen(trim($email))) { $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_mail_text', [ 'subject' => Get_Message_Lang($LNG, 'adm_bank_mail_title'), 'to' => $email, 'body' => Get_Message_Lang($LNG, 'adm_bank_mail_text1') . $INUMBER . Get_Message_Lang($LNG, 'adm_bank_mail_text2') . $USER_NAME, 'html' => 0, ] ); $db->query($sql); } admin_flash(Get_Message_Lang($LNG, 'adm_success_delete')); } ?>
<?= admin_flash() ?>
<?= Get_Message_Lang($LNG, 'adm_bank_view_invoice') ?>
<br><br>

<FORM name="kvitok_by_claim" action="" method="post">
    <?= Get_Message_Lang($LNG, 'adm_bank_number_claim') ?> <input type="TEXT" name="CLAIM">
    <input type=submit value="<?= Get_Message_Lang($LNG, 'adm_bank_show') ?>" name="B_K_CLAIM" class=button>
</form>
<?php
$CLAIM = (isset($_POST['CLAIM']) && intval($_POST['CLAIM'])) ? intval($_POST['CLAIM']) : 0; if ($CLAIM > 0) { echo (Get_Message_Lang($LNG, 'adm_bank_list_invoice_by_claim')) . $CLAIM . '<br>'; $qres = $db->exec(OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_Admin_bank_tour_invoices', array('CLAIM' => $CLAIM), true); if ($db->numRows($qres) > 0) { ?>
        <table width="100%" align="left" cellpadding=1 cellspacing=1>
            <tr>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_num_insure') ?>&nbsp;</td>
                <td class="capt border_dark" align="center" nowrap>
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_date_time_create') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_FIO_payer') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">&nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_sum') ?>
                    &nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_currency') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">&nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_sum') ?>
                    &nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_currency') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">&nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_rate') ?>
                    &nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_bank_confirmation') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_uploaded_in_samo') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_payment_code') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_delete_botton') ?>&nbsp;</td>
            </tr>
            <?php
 while ($row = $db->fetchRow($qres)) { $permition = 1; if ($row['ConfirmPay'] == 1 || $row['LoadToSamoDateTime']->not_null()) { $permition = 0; } ?>
                <tr>
                    <td class="txt border">&nbsp;<?php echo $row['INumber'] . '<br>' . $row['OwnerName'] ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['IDateTime']->format('datetime') ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['Payer'] ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['CurSum'] ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['Currency'] ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['RubSum'] ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['RubCurrency'] ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['Rate'] ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['ConfirmDateTime']->format('datetime') ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['LoadToSamoDateTime']->format('datetime') ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['PaymentInSamo'] ?></td>
                    <td class="txt border">
                        <?php
 if ($permition == 1) { ?>
                            <input type=button value="<?= Get_Message_Lang($LNG, 'adm_delete_botton') ?>"
                                   name="DEL" class=button onClick="DelButtonClick('<?= $row['INumber'] ?>')"/>
                        <?php
 } else { ?>
                            &nbsp;
                        <?php
 } ?>
                    </td>
                </tr>
                <?php
 } ?>
        </table>
        <br clear="all">
        <?php
 } else { echo '<br>' . Get_Message_Lang($LNG, 'adm_bank_no_invoice'); } } ?>
<br clear="all">  <!-- ---------------------------------------------------------------- -->
<script>
    function KbNumber() {
        document.kvitok_by_number.submit();
    }
</script>
<FORM name="kvitok_by_number" action="" method="post">
    <?= Get_Message_Lang($LNG, 'adm_bank_number_invoice') ?> <input type="TEXT" name="NUMBER">
    <input type=button value="<?= Get_Message_Lang($LNG, 'adm_bank_show') ?>" name="B_K_NUMBER" class=button
           onClick="KbNumber()">
</form>
<?php
$NUMBER = isset($_POST['NUMBER']) ? trim($_POST['NUMBER']) : ''; if ($NUMBER != '') { echo (Get_Message_Lang($LNG, 'adm_bank_info_invoice')) . $NUMBER . '<br>'; $qres = $db->exec(OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_Admin_bank_tour_invoices', array('NUMBER' => $NUMBER), true); if ($db->numRows($qres) > 0) { ?>
        <table width="100%" align="left" cellpadding=1 cellspacing=1>
            <tr>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_num_insure') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_claim_number') ?>&nbsp;</td>
                <td class="capt border_dark" align="center" nowrap>
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_date_time_create') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_FIO_payer') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">&nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_sum') ?>
                    &nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_currency') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">&nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_sum') ?>
                    &nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_currency') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_bank_confirmation') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_uploaded_in_samo') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_payment_code') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_delete_botton') ?>&nbsp;</td>
            </tr>
            <?php
 while ($row = $db->fetchRow($qres)) { $permition = 1; if ($row['ConfirmPay'] == 1 || $row['LoadToSamoDateTime']->not_null()) { $permition = 0; } ?>
                <tr>
                    <td class="txt border">&nbsp;<?php echo $row['INumber'] . '<br>' . $row['OwnerName'] ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['claim'] ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['IDateTime']->format('datetime') ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['Payer'] ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['CurSum'] ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['Currency'] ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['RubSum'] ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['RubCurrency'] ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['ConfirmDateTime']->format('datetime') ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['LoadToSamoDateTime']->format('datetime') ?></td>
                    <td class="txt border">&nbsp;<?php echo $row['PaymentInSamo'] ?></td>
                    <td class="txt border">
                        <?php
 if ($permition == 1) { ?>
                            <input type=button value="<?= Get_Message_Lang($LNG, 'adm_delete_botton') ?>"
                                   name="DEL" class=button onClick="DelButtonClick('<?= $row['INumber'] ?>')"/>
                        <?php
 } else { ?>
                            &nbsp;
                        <?php
 } ?>
                    </td>
                </tr>
                <?php
 } ?>
        </table>
        <br clear="all">
        <?php
 } else { echo '<br>' . Get_Message_Lang($LNG, 'adm_bank_no_invoice'); } } ?>
<br clear="all">  <!-- ---------------------------------------------------------------- -->
<script>
    function KbDate() {
        document.kvitok_by_date.submit();
    }
</script>
<FORM name="kvitok_by_date" action="" method="post">
    <?= Get_Message_Lang($LNG, 'adm_bank_date_create') ?> <input type="TEXT"
                                                                 name="DATE"><?= Get_Message_Lang($LNG, 'adm_bank_dd_mm_yyyy') ?>
    <input type=button value="<?= Get_Message_Lang($LNG, 'adm_bank_show') ?>" name="B_K_DATE" class=button
           onClick="KbDate()">
</form>
<?php
$DATE = isset($_POST['DATE']) ? trim($_POST['DATE']) : ''; if ($DATE != '') { $DATE = strtotime($DATE); echo (Get_Message_Lang($LNG, 'adm_bank_info_invoice_by_date')) . date('d.m.Y', $DATE) . '<br>'; $qres = $db->exec(OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_Admin_bank_tour_invoices', array('DATE' => date('Ymd', $DATE)), true); if ($db->numRows($qres) > 0) { ?>
        <table width="100%" align="left" cellpadding=1 cellspacing=1>
            <tr>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_num_insure') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_claim_number') ?>&nbsp;</td>
                <td class="capt border_dark" align="center" nowrap>
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_date_time_create') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_FIO_payer') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">&nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_sum') ?>
                    &nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_currency') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">&nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_sum') ?>
                    &nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_currency') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_bank_confirmation') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_uploaded_in_samo') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_bank_payment_code') ?>&nbsp;</td>
                <td class="capt border_dark" align="center">
                    &nbsp;<?= Get_Message_Lang($LNG, 'adm_delete_botton') ?>&nbsp;</td>
            </tr>
            <?php
 while ($row = $db->fetchRow($qres)) { $permition = 1; if ($row['ConfirmPay'] == 1 || $row['LoadToSamoDateTime']->not_null()) { $permition = 0; } ?>
                <tr>
                    <td class="txt border">&nbsp;<?= $row['INumber'] . '<br>' . $row['OwnerName'] ?></td>
                    <td class="txt border">&nbsp;<?= $row['claim'] ?></td>
                    <td class="txt border">&nbsp;<?= $row['IDateTime']->format('datetime') ?></td>
                    <td class="txt border">&nbsp;<?= $row['Payer'] ?></td>
                    <td class="txt border">&nbsp;<?= $row['CurSum'] ?></td>
                    <td class="txt border">&nbsp;<?= $row['Currency'] ?></td>
                    <td class="txt border">&nbsp;<?= $row['RubSum'] ?></td>
                    <td class="txt border">&nbsp;<?= $row['RubCurrency'] ?></td>
                    <td class="txt border">&nbsp;<?= $row['ConfirmDateTime']->format('datetime') ?></td>
                    <td class="txt border">&nbsp;<?= $row['LoadToSamoDateTime']->format('datetime') ?></td>
                    <td class="txt border">&nbsp;<?= $row['PaymentInSamo'] ?></td>
                    <td class="txt border">
                    <?php
 if ($permition == 1) { ?>
                        <input type="button" value="<?= Get_Message_Lang($LNG, 'adm_delete_botton') ?>" name="DEL" class=button onClick="DelButtonClick('<?= $row['INumber'] ?>')"/>
                    <?php
 } else { ?>
                        &nbsp;
                    <?php
 } ?>
                    </td>
                </tr>
                <?php
 } ?>
        </table>
        <?php
 } else { echo '<br>' . Get_Message_Lang($LNG, 'adm_bank_no_invoice'); } } ?>
</body>
