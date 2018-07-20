<link href="./../../includes/css/style.css" rel="stylesheet" type="text/css">
<form method="POST">
<?php
 include_once '../../properties.php'; $login = PSBANK_Users(); $LOGIN = (isset($_POST['LOGIN'])) ? $_POST['LOGIN'] : false; $PSW = (isset($_POST['PSW'])) ? $_POST['PSW'] : false; if ((!$LOGIN) || (!$PSW) || !isset($login[$LOGIN]) || $login[$LOGIN] != $PSW) { if ($LOGIN && $PSW && (!isset($login[$LOGIN]) || $login[$LOGIN] != $PSW)) { echo '<b>Ошибка авторизации</b>'; } ?>
    <table align="center" width="20%" border=0 cellpadding=1 cellspacing=1>
        <tr>
            <td class="capt border_dark" colspan=2 align=center nowrap>Идентификация</td>
        </tr>
        <tr>
            <td colspan=2></td>
        </tr>
        <tr>
            <td colspan=2></td>
        </tr>
        <tr>
            <td align=right class="capt1 border_dark" nowrap>&nbsp;Логин:&nbsp;</td>
            <td align=center class="border_dark"><input name="LOGIN" type="text" class="element" size=15 maxlength=15>
            </td>
        </tr>
        <tr>
            <td align=right class="capt1 border_dark" nowrap>&nbsp;Пароль:&nbsp;</td>
            <td align=center class="border_dark"><input name="PSW" type="password" class="element" size=15 maxlength=15>
            </td>
        </tr>
        <tr>
            <td colspan=2></td>
        </tr>
        <tr>
            <td colspan=2></td>
        </tr>
        <tr>
            <td class="border_dark" colspan=2 align=center><input name="Submit" type="submit" class="button"
                                                                  value="Вход"></td>
        </tr>
    </table>
</form>
<?php
 exit(); } else { ?>
    <input type="hidden" name="LOGIN" value="<?= $LOGIN ?>"/>
    <input type="hidden" name="PSW" value="<?= $PSW ?>"/>
<?php
} ini_set('display_errors', 'Off'); error_reporting(E_ALL); include_once 'lib.php'; include_once _ROOT . 'includes/classes/class.samo_config.php'; Samo_Loader::register_autoload(); $db = connectdb(); $model = Samo_Loader::load_class('WSPAY_model'); $model = new $model($db); $INUMBER = (isset($_POST['INUMBER'])) ? $_POST['INUMBER'] : false; $CONFIRM = (isset($_POST['CONFIRM'])) ? $_POST['CONFIRM'] : false; ?>
Введите номер квитанции: <input class="element" type="text" name="INUMBER" value="<?= $INUMBER ?>"/>&nbsp;<input
    class="button" type="submit" value="Получить данные"><br/>
<?php
 try { if ($INUMBER) { if ($res = $model->__getInvoiceData($INUMBER)->fetchRow()) { if ($CONFIRM == 1) { $model->__confirmInvoiceByINumber($INUMBER, PSBANK_DEFAULT_OPERATION); $res = $model->__getInvoiceData($INUMBER)->fetchRow(); } ?>
            <table cellpadding="2" cellspacing="1" class="txt">
                <tr>
                    <td class="border_dark">Номер квитанции</td>
                    <td class="border_dark">&nbsp;<?= $res['INumber'] ?></td>
                </tr>
                <tr>
                    <td class="border_dark">Дата</td>
                    <td class="border_dark">&nbsp;<?= strftime('%Y-%m-%d', $res['IDate']) ?></td>
                </tr>
                <tr>
                    <td class="border_dark">Плательщик</td>
                    <td class="border_dark">&nbsp;<?= $res['Payer'] ?></td>
                </tr>
                <tr>
                    <td class="border_dark">Адрес</td>
                    <td class="border_dark">&nbsp;<?= $res['Address'] ?></td>
                </tr>
                <tr>
                    <td class="border_dark">Паспорт</td>
                    <td class="border_dark">&nbsp;серия: <?= $res['PaspSer'] ?> номер: <?= $res['PaspNumber'] ?></td>
                </tr>
                <tr>
                    <td class="border_dark">Выдан</td>
                    <td class="border_dark">&nbsp;<?= $res['PaspWhere'] ?></td>
                </tr>
                <tr>
                    <td class="border_dark">Сумма в рублях</td>
                    <td class="border_dark">&nbsp;<?= $res['RubSum'] ?></td>
                </tr>
            </table>
            <?php
 if ($res['ConfirmPay'] == 1) { ?>
                <b>Квитанция подтверждена <?= $res['ConfirmDateTime120'] ?>.</b>
            <?php
 } else { ?>
                <input type="hidden" name="CONFIRM" value="0">
                <input class="button" type="button" value="Подтвердить оплату"
                       onclick="document.forms[0].CONFIRM.value = 1;document.forms[0].submit();"/>
            <?php
 } } else { ?>
            <b>Квитанция не найдена.</b>
        <?php
 } } } catch (Exception $e) { echo $e->getMessage(); } ?>
</form>
