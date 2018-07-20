<script type="text/javascript" src="<?= $http_site ?>admin/includes/site/j_script/samo_calendar.js"></script>
<script type="text/javascript" src="<?= $http_site ?>admin/includes/site/j_script/date.js"></script>
<script>
    function CheckDate(el) {
        d = ChDate(el.value) ? ChDate(el.value) : (null);
        d = ValidBetween(d, '', '');
        el.value = ff('dd/mm/yyyy', d)
    }

    function Check_and_Show() {
        var fld = document.start.CHECKIN1;
        if (fld.value == '') {
            alert('Date "from" not choose');
            fld.focus();
            fld.select();
            return (false);
        }
        var ar = fld.value.split('/');
        var date1 = new Date(ar[2], ar[1] - 1, ar[0]);
        fld = document.start.CHECKIN2;
        if (fld.value == '') {
            alert('Date "till" not choose');
            fld.focus();
            fld.select();
            return (false);
        }
        ar = fld.value.split('/');
        var date2 = new Date(ar[2], ar[1] - 1, ar[0]);
        if (date1 > date2) {
            alert('Date "from" must be larger date "till"');
            fld.focus();
            fld.select();
            return (false);
        }
        document.start.submit();
    }
</script>
<?= $str ?>
<table width="40%"" border="0" align="center">
<tr>
    <td class="txt" align="center" colspan="4"> Available hotels by accomodations
    </td>
</tr>
<tr>
    <td height="5 px">
    </td>
</tr>
<?php
if (count($a_inc_h) > 0) { ?>
    <tr>
        <td width="25%" class="capt border_dark" align="left" rowspan="2">
            Tour
            <select name="TOURINC" class="element" style="width: 100%">
                <?php
 $tourcount = count($a_inc_h); for ($i = 0; $i < $tourcount; $i++) { echo '<option value="' . $a_inc_h[$i] . '"'; if ($a_inc_h[$i] == $TOURINC) { echo ' selected '; } echo '>' . $a_name_h[$i] . '</option>'; } ?>
            </select>
        </td>
        <td class="capt border_dark" align="left">&nbsp;from&nbsp;</td>
        <td class="capt border_dark">
            <script language="JavaScript"
                    type="text/javascript">CheckIn = calendar('CHECKIN1', '<?= $date1 ?>', '<?= $http_site ?>admin/files/img/calendar/', 1, 'CheckDate');</SCRIPT>
        </td>
        <td class="capt border_dark" align="center" rowspan="2">
            <input type="button" name="B_SHOW" value="Refresh" class="button"
                   onclick="Check_and_Show();">
        </td>
    </tr>
    <tr>
        <td class="capt border_dark" align="left">&nbsp;till&nbsp;
        </td>
        <td class="capt border_dark" align="left">
            <script language="JavaScript"
                    type="text/javascript">CheckIn2 = calendar("CHECKIN2", "<?= $date2 ?>", "<?= $http_site ?>admin/files/img/calendar/", 1, 'CheckDate');</SCRIPT>
        </td>
    </tr>
    <?php
} else { ?>
    <tr>
        <td colspan="4" class="txt border_dark">Для пользователя не настроены права доступа к заявкам<br>(САМО-Тур->Настройки->Администрирование->Доступ
            к заявкам)
        </td>
    </tr>
    <?php
} $nodata = ''; if (!$result) { $nodata = 'Data not found'; ?>
    <tr>
        <td class="txt" align="center" colspan="4"> <?= $nodata ?>
        </td>
    </tr>
    <?php
} else { ?>
</table>
<table border="0" align="center">
    <tr>
        <td class="capt border_dark" valign="middle" align="center">&nbsp;&nbsp;Hotel&nbsp;&nbsp; </td>
        <td class="capt border_dark" valign="middle" align="center">&nbsp;&nbsp;Room&nbsp;&nbsp;</td>
        <?php
 $afsize = count($af); for ($i = 0; $i < $afsize; $i++) { ?>
            <td class="capt border_dark txt" valign="middle" align="center">&nbsp;
                <?php
 echo substr($af[$i], 6, 2) . "/" . substr($af[$i], 4, 2); ?>
                &nbsp;
            </td>
            <?php
 } ?>
    </tr>
    <?php
 $h = ''; $r = ''; foreach ($result as $row) { $afsize = count($af); if (($h != $row['hotel']) or ($r != $row['broom'])) { if ($h != '') { for ($i = 0; $i < $afsize; $i++) { echo '<td class="txt border_dark">' . '&nbsp;' . @$total[$af[$i]] . '/' . @$usedover[$af[$i]] . '&nbsp;</td>'; } echo "</tr>"; } $h = $row['hotel']; $r = $row['broom']; ?>
    <tr>
        <td class="border_dark txt" nowrap>&nbsp;<?= $row['HotelName'] ?>&nbsp;</td>
        <td class="border_dark txt" nowrap>&nbsp;<?= $row['RoomName'] ?>&nbsp;</td>
            <?php
 $total = array(); $usedover = array(); } if ($row['soft'] == 2) { for ($i = 0; $i < $afsize; $i++) { $f = 'f' . $af[$i]; $total[$af[$i]] = $row[$f]; } } else { if ($row['soft'] == 6) { for ($i = 0; $i < $afsize; $i++) { $f = 'f' . $af[$i]; $usedover[$af[$i]] = $row[$f]; } } } } for ($i = 0; $i < $afsize; $i++) { echo '<td class="txt border_dark">' . '&nbsp;' . @$total[$af[$i]] . "/" . @$usedover[$af[$i]] . "&nbsp;</td>"; } echo "</tr>"; } ?>
</table>
