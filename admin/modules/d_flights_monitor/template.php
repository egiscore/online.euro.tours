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
        document.start.SHOW.value = 1;
        document.start.submit();
    }

    function changeStateFrom() {
        document.getElementById('TOWNFROMINC').value = 0;
        document.getElementById('TOWNTOINC').value = 0;
        document.start.submit();
    }
    function changeStateTo() {
        document.getElementById('TOWNTOINC').value = 0;
        document.start.submit();
    }
    function changeTown() {
        document.start.submit();
    }

</script>
<?= $str ?>
<div style="text-align: center;">Monitoring of flights reservations</div>
<br>
<table width="70%"" border="0" align="center">
<tr>
    <td class="txt capt border_dark" width="40%"> State from:
        <select name="STATEFROMINC" id="STATEFROMINC" class="element" onchange="changeStateFrom();">
            <?php
 foreach ($states_from as $state) { $selected = ($state['Inc'] == $STATEFROMINC) ? 'selected' : ''; echo '<option value="' . $state['Inc'] . '" ' . $selected . '>' . $state['LName'] . '</option>'; } ?>
        </select>
    </td>
    <td class="txt capt border_dark" colspan="2" width="60%"> State to:
        <select name="STATETOINC" id="STATETOINC" class="element" onchange="changeStateTo();">

            <?php
 foreach ($states_to as $state) { $selected = ($state['Inc'] == $STATETOINC) ? 'selected' : ''; echo '<option value="' . $state['Inc'] . '" ' . $selected . '>' . $state['LName'] . '</option>'; } ?>
        </select>
    </td>
</tr>
<tr>
    <td class="txt capt border_dark"> Town from:
        <select name="TOWNFROMINC" id="TOWNFROMINC" class="element" onchange="changeTown();">
            <?php
 foreach ($town_from as $town) { $selected = ($town['Inc'] == $TOWNFROMINC) ? 'selected' : ''; echo '<option value="' . $town['Inc'] . '" ' . $selected . '>' . $town['LName'] . '</option>'; } ?>
        </select>
    </td>
    <td class="txt capt border_dark">Town to:<select name="TOWNTOINC" id="TOWNTOINC" class="element"
                                                     onchange="changeTown();">
            <?php
 foreach ($town_to as $town) { $selected = ($town['Inc'] == $TOWNTOINC) ? 'selected' : ''; echo '<option value="' . $town['Inc'] . '" ' . $selected . '>' . $town['LName'] . '</option>'; } ?>
        </select>
    </td>
    <td class="txt capt border_dark">Partner:<select name="FIRMCODE" id="FIRMCODE" class="element">
            <?php
 foreach ($partners as $partner) { $selected = ($partner['Inc'] == $FIRMCODE) ? 'selected' : ''; echo '<option value="' . $partner['Inc'] . '" ' . $selected . '>' . $partner['LName'] . '</option>'; } ?>
        </select>
    </td>
</tr>
<tr>
    <td class="capt border_dark" align="left">&nbsp;Tour
        <select style="width: 200px" name="TOURINC" class="element">
            <option value=0>All</option>
            <?php
 $toursize = count($t_inc); if ($toursize > 0) { for ($i = 0; $i < $toursize; $i++) { echo '<option value="' . $t_inc[$i] . '"'; if ($t_inc[$i] == $TOURINC) { echo ' selected '; } echo '>' . $t_name[$i] . '</option>'; } } ?>
        </select>
    </td>
    <td class="capt border_dark" align="left">
        <table>
            <tr>
                <td class="capt">from</td>
                <td>
                    <script language="JavaScript"
                            type="text/javascript">CheckIn = calendar('CHECKIN1', '<?= $date1 ?>', '<?= $http_site ?>admin/files/img/calendar/', 1, 'CheckDate');</SCRIPT>
                </td>
            </tr>
        </table>
    </td>
    <td class="capt border_dark" align="center" rowspan="2">
        <input type="button" name="B_SHOW" value="Show" class="button" onclick="Check_and_Show();">
    </td>
</tr>
<tr>
    <td class="capt border_dark" align="left">&nbsp;Class
        <select style="width: 100px" name="CLASS" class="element">
            <?php
 foreach ($classs as $class) { echo '<option value="' . $class['Inc'] . '"'; if ($class['Inc'] == $CLASS) { echo ' selected '; } echo '>' . htmlspecialchars($class['Name'], ENT_QUOTES, 'cp1251') . '</option>'; } ?>
        </select>
    </td>
    <td class="capt border_dark" align="left">
        <table>
            <tr>
                <td class="capt">till</td>
                <td>
                    <script language="JavaScript"
                            type="text/javascript">CheckIn2 = calendar('CHECKIN2', '<?= $date2; ?>', '<?= $http_site ?>admin/files/img/calendar/', 1, 'CheckDate');</SCRIPT>
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
<?php
if (isset($r_date)) { ?>
<table width="80%" border="0" align="center">
    <tr>
        <td class="capt border_dark" align="center"> Date</td>
        <td class="capt border_dark" align="center"> Day of week</td>
        <td class="capt border_dark" align="center"> Flight</td>
        <td class="capt border_dark" align="center"> Departure</td>
        <td class="capt border_dark" align="center"> Arrival</td>
        <td class="capt border_dark" align="center"> Block</td>
        <td class="capt border_dark" align="center"> Used</td>
        <td class="capt border_dark" align="center"> Rest</td>
        <td class="capt border_dark" align="center">&nbsp;%&nbsp;</td>
        <td class="capt border_dark" align="center"> Flight</td>
        <td class="capt border_dark" align="center"> Departure</td>
        <td class="capt border_dark" align="center"> Arrival</td>
        <td class="capt border_dark" align="center"> Block</td>
        <td class="capt border_dark" align="center"> Used</td>
        <td class="capt border_dark" align="center"> Rest</td>
        <td class="capt border_dark" align="center">&nbsp;%&nbsp;</td>
    </tr>
    <tr>
    <?php
 $prob = '&nbsp;'; $datesize = count($r_date); if ($datesize > 0) { for ($i = 0; $i < $datesize; $i++) { $r_used[$i] = $r_block[$i] + $r_reserve[$i]; $r_used_back[$i] = $r_blockback[$i] + $r_reserveback[$i]; $r_reserveback_p[$i] = $r_reserveback[$i] * (-1); $r_reserve_p[$i] = $r_reserve[$i] * (-1); $r_ssrctime2[$i] = substr($r_ssrctime[$i], 0, 5); $r_strgtime[$i] = substr($r_strgtime[$i], 0, 5); ?>
        <td class="border_dark txt" align="center"><?= $r_date[$i] ?></td>
        <td class="border_dark txt" align="center"><?= $r_date[$i]->format('D'); ?></td>
            <?php
 if ($r_freight_name[$i] == '' or ($r_freight_name[$i] == '' and $r_reserve[$i] == '0')) { ?>
            <td class="border_dark txt" align="center" colspan="7"><?= $prob ?></td>
            <?php
 } else { ?>
            <td class="border_dark txt" align="center"><?= $r_freight_name[$i] ?></td>
            <td class="border_dark txt"
                align="center"><?= htmlspecialchars($result[$i]['ssrctownlname'] . ' ' . substr($result[$i]['ssrctime'], 0, 5), ENT_QUOTES, 'cp1251'); ?></td>
            <td class="border_dark txt"
                align="center"><?= htmlspecialchars($result[$i]['strgtownlname'] . ' ' . substr($result[$i]['strgtime'], 0, 5), ENT_QUOTES, 'cp1251'); ?></td>
            <td class="border_dark txt" align="center"><?= $r_block[$i] ?></td>
            <td class="border_dark txt" align="center"><?= $r_reserve_p[$i] ?></td>
            <td class="border_dark txt" align="center"><?= $r_used[$i] ?></td>
            <td class="border_dark txt" align="center"><?= $r_percent[$i] ?></td>
            <?php
 } if ($r_freight_back[$i] == '') { ?>
            <td class="border_dark txt" align="center" colspan="7"><?= $prob ?></td>
            <?php
 } else { ?>
            <td class="border_dark txt" align="center"><?= $r_freight_back[$i] ?></td>
            <td class="border_dark txt"
                align="center"><?= htmlspecialchars($result[$i]['tsrctownlname'] . ' ' . substr($result[$i]['tsrctime'], 0, 5), ENT_QUOTES, 'cp1251'); ?></td>
            <td class="border_dark txt"
                align="center"><?= htmlspecialchars($result[$i]['ttrgtownlname'] . ' ' . substr($result[$i]['ttrgtime'], 0, 5), ENT_QUOTES, 'cp1251'); ?></td>
            <td class="border_dark txt" align="center"><?= $r_blockback[$i] ?></td>
            <td class="border_dark txt" align="center"><?= $r_reserveback_p[$i] ?></td>
            <td class="border_dark txt" align="center"><?= $r_used_back[$i] ?></td>
            <td class="border_dark txt" align="center"><?= $r_percentback[$i] ?>&nbsp;</td>
            <?php
 } ?>
    </tr>
        <?php
 } } else { echo '<tr><td class="txt" colspan=15 align=center>Data not found</td></tr>'; } } ?>
</table>
</form>
