<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
    <TITLE>Monitoring of flight situation</TITLE>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1251">
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
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
</HEAD>
<body>
<FORM name="start" action="" method="post">
    <?= $str ?>
    <table width="40%"
    " border="0" align="center">
    <tr>
        <td class="txt" align="center" colspan="4">Monitoring of flight situation</td>
    </tr>
    <tr>
        <td height="5 px"></td>
    </tr>
    <tr>
        <td class="capt border_dark" align="left" rowspan="2"> Tour
            <select style="width: 200px" name="TOURINC" class="element">
                <?php
 $toursize = count($t_inc); if ($toursize > 0) { for ($i = 0; $i < $toursize; $i++) { echo '<option value="' . $t_inc[$i] . '"'; if ($t_inc[$i] == $TOURINC) { echo ' selected '; } echo '>' . $t_name[$i] . '</option>'; } } ?>
            </select>
        </td>
        <td class="capt border_dark" align="left">&nbsp;from&nbsp;</td>
        <td class="capt border_dark">
            <script language="JavaScript"
                    type="text/javascript">CheckIn = calendar('CHECKIN1', '<?= $date1 ?>', '<?= $http_site ?>admin/files/img/calendar/', 1, 'CheckDate');</SCRIPT>
        </td>
        <td class="capt border_dark" align="center" rowspan="2">
            <input type="button" name="B_SHOW" value="Refresh" class="button" onclick="Check_and_Show();">
        </td>
    </tr>
    <tr>
        <td class="capt border_dark" align="left">&nbsp;till&nbsp;</td>
        <td class="capt border_dark" align="left">
            <script language="JavaScript"
                    type="text/javascript">CheckIn2 = calendar("CHECKIN2", "<?= $date2 ?>", "<?= $http_site ?>admin/files/img/calendar/", 1, 'CheckDate');</SCRIPT>
        </td>
    </tr>
    </table>

    <?php
 if (count($fs) > 0) { echo '<h3 align="center">' . $fs[0]['p$lname'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $fs[0]['cl$lname'] . '</h3>'; } ?>
    <table width="80%" border="0" align="center">
        <tr>
            <td class="capt border_dark" align="center"> Date</td>
            <td class="capt border_dark" align="center"> Block</td>
            <td class="capt border_dark" align="center"> Used</td>
            <td class="capt border_dark" align="center"> Rest</td>
            <td class="capt border_dark" align="center"> %</td>
            <td class="capt border_dark" align="center"> 3</td>
            <td class="capt border_dark" align="center"> 4</td>
            <td class="capt border_dark" align="center"> 5</td>
            <td class="capt border_dark" align="center"> 6</td>
            <td class="capt border_dark" align="center"> 7</td>
            <td class="capt border_dark" align="center"> 8</td>
            <td class="capt border_dark" align="center"> 9</td>
            <td class="capt border_dark" align="center"> 10</td>
            <td class="capt border_dark" align="center"> 11</td>
            <td class="capt border_dark" align="center"> 12</td>
            <td class="capt border_dark" align="center"> 13</td>
            <td class="capt border_dark" align="center"> 14</td>
            <td class="capt border_dark" align="center" rowspan="<?php echo count($fs) + 2 ?>">&nbsp;&nbsp;</td>
            <td class="capt border_dark" align="center"> Back seats</td>
        </tr>
        <tr>
            <?php
 $prob = '&nbsp;'; $fssize = count($fs); if ($fssize > 0) { for ($i = 0; $i < $fssize; $i++) { ?>
        <tr>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['ddate112'] ?>&nbsp;</td>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['block'] ?>&nbsp;</td>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['sold'] ?>&nbsp;</td>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['remain'] ?>&nbsp;</td>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['perc'] ?>&nbsp;</td>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['r3'] ?>&nbsp;</td>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['r4'] ?>&nbsp;</td>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['r5'] ?>&nbsp;</td>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['r6'] ?>&nbsp;</td>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['r7'] ?>&nbsp;</td>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['r8'] ?>&nbsp;</td>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['r9'] ?>&nbsp;</td>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['r10'] ?>&nbsp;</td>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['r11'] ?>&nbsp;</td>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['r12'] ?>&nbsp;</td>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['r13'] ?>&nbsp;</td>
            <td class="border_dark">&nbsp;<?php echo $fs[$i]['r14'] ?>&nbsp;</td>

            <td class="border_dark">&nbsp;<?php echo $fs[$i]['backseats'] ?>&nbsp;</td>
        </tr>
                <?php
 } } else { echo '<tr><td class="txt" colspan=15 align=center>Data not found</td></tr>'; } ?>

    </table>
</form>
</body>
</HTML>