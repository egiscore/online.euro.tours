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
            return false;
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

    function fillStates() {
        fillSelect('STATEINC', states);
    }

    function fillRegions() {
        var state = document.getElementById('STATEINC').value;
        if (state == 0) {
            var options = regions;
        } else {
            var options = new Object;
            var _regions = states[state].regions;
            var length = _regions.length
            for (var i = 0; i < length; i++) {
                options[_regions[i]] = regions[_regions[i]];
            }
        }
        fillSelect('REGIONINC', options);
    }

    function fillTowns() {
        var region = document.getElementById('REGIONINC').value;
        var state = document.getElementById('STATEINC').value;
        if (region == 0) {
            if (state == 0) {
                var options = towns;
            } else {
                var options = new Object;
                var _towns = states[state].towns;
                var length = _towns.length
                for (var i = 0; i < length; i++) {
                    options[_towns[i]] = towns[_towns[i]];
                }
            }
        } else {
            var options = new Object;
            var _towns = regions[region].towns;
            var length = _towns.length
            for (var i = 0; i < length; i++) {
                options[_towns[i]] = towns[_towns[i]];
            }
        }
        fillSelect('TOWNINC', options);
    }

    function fillTours() {
        var state = document.getElementById('STATEINC').value;
        var region = document.getElementById('REGIONINC').value;
        var town = document.getElementById('TOWNINC').value;
        if ((town == 0) && (region == 0) && (state == 0)) {
            var options = tours;
        } else {
            var options = new Object;
            for (var i = 0; i < routes.length; i++) {
                if (((state == 0) || (state == routes[i].state))
                    && ((region == 0) || (region == routes[i].region))
                    && ((town == 0) || (town == routes[i].town))
                    && (typeof(tours[routes[i].tour]) != 'undefined')) {
                    options[routes[i].tour] = tours[routes[i].tour];
                }
            }
        }
        fillSelect('TOURINC', options);
    }

    function fillSelect(name, options) {
        var sel = document.getElementById(name);
        sel.options.length = 0;
        var opt = document.createElement("option");
        opt.value = 0,
            opt.text = 'All';
        sel.options[0] = opt;
        var i = 1;
        for (el in options) {
            var opt = document.createElement("option");
            opt.value = el,
                opt.text = options[el].lname;
            sel.options[i] = opt;
            if (defaults[name] == el) {
                sel.options[i].selected = 1;
                defaults[name] = 0;
            }
            i++;
        }
        sel.onchange();
    }

    function changeState() {
        fillRegions();
    }

    function changeRegion() {
        fillTowns();
    }

    function changeTown() {
        fillTours();
    }
    function changeTour() {
        // мсфем осярни !!!
    }


    var defaults = {
        STATEINC: <?=$STATEINC?>,
        REGIONINC: <?=$REGIONINC?>,
        TOWNINC: <?=$TOWNINC?>,
        TOURINC: <?=$TOURINC?>
    };
    var towns = {
        <?php
 $separator = ''; foreach ($towns as $town) { $r_t[$town['RegionInc']][] = $town['Inc']; $s_t[$town['StateInc']][] = $town['Inc']; echo "$separator$town[Inc] : {name: '$town[Name]', lname: '$town[LName]', state: '$town[StateInc]', region: '$town[RegionInc]'}"; $separator = ($separator == '') ? ',' . PHP_EOL : $separator; } ?>
    };
    var regions = {
        <?php
 $separator = ''; foreach ($regions as $region) { $s_r[$region['StateInc']][] = $region['Inc']; echo "$separator$region[Inc] : {name: '$region[Name]', lname: '$region[LName]', state: '$region[StateInc]', towns: [" . implode(',', $r_t[$region['Inc']]) . "]}"; $separator = ($separator == '') ? ',' . PHP_EOL : $separator; } ?>
    };
    var states = {
        <?php
 $separator = ''; foreach ($states as $state) { echo "$separator$state[Inc] : {name: '$state[Name]', lname: '$state[LName]', regions: [" . implode(',', $s_r[$state['Inc']]) . "], towns: [" . implode(',', $s_t[$state['Inc']]) . "]}"; $separator = ($separator == '') ? ',' . PHP_EOL : $separator; } ?>
    };
    var tours = {
        <?php
 $separator = ''; foreach ($tours as $tour) { echo "$separator$tour[inc] : {name: '$tour[name]', lname: '$tour[lname]'}"; $separator = ($separator == '') ? ',' . PHP_EOL : $separator; } ?>
    };
    var routes = [
        <?php
 $separator = ''; foreach ($routes as $route) { echo "$separator{tour: $route[TourInc], town: $route[TownInc], region: $route[RegionInc], state: $route[StateInc]}"; $separator = ($separator == '') ? ',' . PHP_EOL : $separator; } ?>
    ];
</script>
<?= $str ?>
<table width="60%" border="0" align="center">
    <tr>
        <td class="txt" align="center" colspan="3">Daily report</td>
    </tr>
    <tr>
        <td height="5 px"></td>
    </tr>
    <tr>
        <td width="33%" class="capt border_dark" align="left">
            State <select id="STATEINC" name="STATEINC" class="element" onchange="changeState();"></select>
        </td>
        <td width="33%" class="capt border_dark" align="left">
            Region <select id="REGIONINC" name="REGIONINC" class="element" onchange="changeRegion();"></select>
        </td>
        <td width="34%" class="capt border_dark" align="left">
            Town <select id="TOWNINC" name="TOWNINC" class="element" onchange="changeTown();"></select>
        </td>
    </tr>
    <tr>
        <td class="capt border_dark" align="left" colspan="2">
            Tour <select id="TOURINC" name="TOURINC" class="element" onchange="changeTour();" style="width: 100%"></select>
        </td>
        <td width="15%" class="capt border_dark" align="center">
            <input type="button" name="B_SHOW_2" value="Refresh" class="button" onclick="Check_and_Show();">
        </td>
    </tr>
    <tr>
        <td width="15%" class="capt border_dark" align="left" rowspan="2">&nbsp; Reservation dates&nbsp;
        </td>
        <td class="capt border_dark" align="left"> &nbsp;from
        </td>
        <td class="capt border_dark" align="center">
            <script language="JavaScript"
                    type="text/javascript">CheckIn = calendar('CHECKIN1', '<?= $date1 ?>', '<?= $http_site ?>admin/files/img/calendar/', 1, 'CheckDate');</SCRIPT>
        </td>

    </tr>
    <tr>
        <td class="capt border_dark" align="left">&nbsp; till
        </td>
        <td class="capt border_dark" align="center">
            <script language="JavaScript"
                    type="text/javascript">CheckIn2 = calendar("CHECKIN2", "<?= $date2 ?>", "<?= $http_site ?>admin/files/img/calendar/", 1, 'CheckDate');</SCRIPT>
        </td>

    </tr>
</table>
<table width="40%" align="center">
    <tr>
        <td height="5px">
        </td>
    </tr>

    <?php
 $hotel_name = ''; $h_day = ''; $SUBTOTALROOMS = 0; $SUBTOTALPAX = 0; $TOTALROOMS = 0; $TOTALPAX = 0; $BIGTOTALROOMS = 0; $BIGTOTALPAX = 0; $TOTALROOMS = 0; $TOTALPAX = 0; $dhotelsize = count($d_hotel_inc); if ($dhotelsize > 0) { for ($i = 0; $i < $dhotelsize; $i++) { if ($i == 0) { ?>
                <tr>
                    <td class="capt txt border_dark" align="left" colspan="4"><?= $d_hotel_name[$i]; $hotel_name = $d_hotel_name[$i]; ?>
                    </td>
                </tr>
                <tr>
                    <td class="capt1 border_dark" align="center">CHECK-IN
                    </td>
                    <td class="capt1 border_dark" align="center">CHECK-OUT
                    </td>
                    <td class="capt1 border_dark" align="center">ROOM
                    </td>
                    <td class="capt1 border_dark" align="center">PAX
                    </td>
                </tr>
                <tr>
                    <td class="border_dark txt" align="center"> <?= $d_dbeg[$i] ?>
                    </td>
                    <td class="border_dark txt" align="center"> <?= $d_end[$i] ?>
                    </td>
                    <td class="border_dark txt" align="center"><?= $d_room[$i]; $SUBTOTALROOMS = $SUBTOTALROOMS + $d_room[$i]; $TOTALROOMS = $TOTALROOMS + $SUBTOTALROOMS; $BIGTOTALROOMS = $BIGTOTALROOMS + $d_room[$i]; ?>
                    </td>
                    <td class="border_dark txt" align="center"><?= $d_pax[$i]; $SUBTOTALPAX = $SUBTOTALPAX + $d_pax[$i]; $TOTALPAX = $TOTALPAX + $SUBTOTALPAX; $BIGTOTALPAX = $BIGTOTALPAX + $d_pax[$i]; ?>
                    </td>
                </tr>
                <?php
 $hotel_name = $d_hotel_name[$i]; $h_day = $d_dbeg[$i]; } elseif ($hotel_name == $d_hotel_name[$i]) { if ($d_dbeg[$i] == $h_day) { ?>
                    <tr>
                        <td class="border_dark txt" align="center"> <?= $d_dbeg[$i] ?>
                        </td>
                        <td class="border_dark txt" align="center"> <?= $d_end[$i] ?>
                        </td>
                        <td class="border_dark txt" align="center"><?= $d_room[$i]; $SUBTOTALROOMS = $SUBTOTALROOMS + $d_room[$i]; $TOTALROOMS = $TOTALROOMS + $d_room[$i]; $BIGTOTALROOMS = $BIGTOTALROOMS + $d_room[$i]; ?>
                        </td>
                        <td class="border_dark txt" align="center"><?= $d_pax[$i]; $SUBTOTALPAX = $SUBTOTALPAX + $d_pax[$i]; $TOTALPAX = $TOTALPAX + $d_pax[$i]; $BIGTOTALPAX = $BIGTOTALPAX + $d_pax[$i]; ?>
                        </td>
                    </tr>
                    <?php
 } elseif ($d_dbeg[$i] != $h_day) { ?>
                    <tr>
                        <td class="border_dark txt" align="right" colspan="2">SUBTOTAL
                        </td>
                        <td class="border_dark txt" align="center"> <?= $SUBTOTALROOMS; $SUBTOTALROOMS = 0; ?>
                        </td>
                        <td class="border_dark txt" align="center"> <?= $SUBTOTALPAX; $SUBTOTALPAX = 0; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="border_dark txt" align="center"> <?= $d_dbeg[$i] ?>
                        </td>
                        <td class="border_dark txt" align="center"> <?= $d_end[$i] ?>
                        </td>
                        <td class="border_dark txt" align="center"><?= $d_room[$i]; $SUBTOTALROOMS = $SUBTOTALROOMS + $d_room[$i]; $TOTALROOMS = $TOTALROOMS + $SUBTOTALROOMS; $BIGTOTALROOMS = $BIGTOTALROOMS + $d_room[$i]; ?>
                        </td>
                        <td class="border_dark txt" align="center"><?= $d_pax[$i]; $SUBTOTALPAX = $SUBTOTALPAX + $d_pax[$i]; $TOTALPAX = $TOTALPAX + $SUBTOTALPAX; $BIGTOTALPAX = $BIGTOTALPAX + $d_pax[$i]; ?>
                        </td>
                    </tr>

                    <?php
 } $hotel_name = $d_hotel_name[$i]; $h_day = $d_dbeg[$i]; } elseif ($hotel_name != $d_hotel_name[$i]) { ?>
                <tr>
                    <td class="border_dark txt" align="right" colspan="2">SUBTOTAL
                    </td>
                    <td class="border_dark txt" align="center"> <?= $SUBTOTALROOMS; $SUBTOTALROOMS = 0; ?>
                    </td>
                    <td class="border_dark txt" align="center"> <?= $SUBTOTALPAX; $SUBTOTALPAX = 0; ?>
                    </td>
                </tr>
                <tr>
                    <td class="border_dark txt" align="right" colspan="2">TOTAL
                    </td>
                    <td class="border_dark txt" align="center"> <?= $TOTALROOMS; ?>
                    </td>
                    <td class="border_dark txt" align="center"> <?= $TOTALPAX; $TOTALPAX = 0; $TOTALROOMS = 0; ?>
                    </td>
                </tr>
                <tr>
                    <td class="capt txt border_dark" align="left" colspan="4"><?= $d_hotel_name[$i] ?>
                    </td>
                </tr>
                <tr>
                    <td class="capt1 border_dark" align="center">CHECK-IN
                    </td>
                    <td class="capt1 border_dark" align="center">CHECK-OUT
                    </td>
                    <td class="capt1 border_dark" align="center">ROOM
                    </td>
                    <td class="capt1 border_dark" align="center">PAX
                    </td>
                </tr>
                <tr>
                    <td class="border_dark txt" align="center"> <?= $d_dbeg[$i] ?>
                    </td>
                    <td class="border_dark txt" align="center"> <?= $d_end[$i] ?>
                    </td>
                    <td class="border_dark txt" align="center"><?= $d_room[$i]; $SUBTOTALROOMS = $SUBTOTALROOMS + $d_room[$i]; $TOTALROOMS = $TOTALROOMS + $SUBTOTALROOMS; $BIGTOTALROOMS = $BIGTOTALROOMS + $d_room[$i] ?>
                    </td>
                    <td class="border_dark txt" align="center"><?= $d_pax[$i]; $SUBTOTALPAX = $SUBTOTALPAX + $d_pax[$i]; $BIGTOTALPAX = $BIGTOTALPAX + $d_pax[$i]; $TOTALPAX = $TOTALPAX + $SUBTOTALPAX; ?>
                    </td>
                </tr>
                <?php
 $hotel_name = $d_hotel_name[$i]; $h_day = $d_dbeg[$i]; } } ?>
        <tr>
            <td class="border_dark txt" align="right" colspan="2">SUBTOTAL
            </td>
            <td class="border_dark txt" align="center"> <?= $SUBTOTALROOMS; $SUBTOTALROOMS = 0; ?>
            </td>
            <td class="border_dark txt" align="center"> <?= $SUBTOTALPAX; $SUBTOTALPAX = 0; ?>
            </td>
        </tr>
        <tr>
            <td class="border_dark txt" align="right" colspan="2">TOTAL
            </td>
            <td class="border_dark txt" align="center"><?= $TOTALROOMS ?>
            </td>
            <td class="border_dark txt" align="center"><?= $TOTALPAX; ?>
            </td>
        </tr>
        <tr>
            <td class="capt border_dark txt" align="right" colspan="2">TOTAL ALL HOTELS
            </td>
            <td class="capt border_dark txt" align="center"> <?= $BIGTOTALROOMS ?>
            </td>
            <td class="capt border_dark txt" align="center"> <?= $BIGTOTALPAX ?>
            </td>
        </tr>

        <?php
 } if (count($d_t_pax) > 0) { $hotel_name_t = ''; $h_day_t = ''; $TOTALPAX_T = 0 ?>
        <tr>
            <td class="capt txt border_dark" align="left" colspan="4">ONLY TICKETS
            </td>
        </tr>

        <?php
 $BIGTOTALPAX_T = 0; $dpaxsize = count($d_t_pax); for ($i = 0; $i < $dpaxsize; $i++) { if ($i == 0) { $SUBTOTALPAX_T = 0; ?>
                <tr>
                    <td class="border_dark txt" align="center"> <?= $d_t_dbeg[$i] ?>
                    </td>
                    <td class="border_dark txt" align="center"> <?= $d_t_end[$i] ?>
                    </td>
                    <td class="border_dark txt" align="center">&nbsp;
                    </td>
                    <td class="border_dark txt" align="center"><?= $d_t_pax[$i]; $SUBTOTALPAX_T = $SUBTOTALPAX_T + $d_t_pax[$i]; $TOTALPAX_T = $TOTALPAX_T + $SUBTOTALPAX_T; ?>
                    </td>
                </tr>

                <?php
 $h_day_t = $d_t_dbeg[$i]; } elseif ($h_day_t == $d_t_dbeg[$i]) { $h_day_t = $d_t_dbeg[$i]; ?>
                <tr>
                    <td class="border_dark txt" align="center"> <?= $d_t_dbeg[$i] ?>
                    </td>
                    <td class="border_dark txt" align="center"> <?= $d_t_end[$i] ?>
                    </td>
                    <td class="border_dark txt" align="center">&nbsp;
                    </td>
                    <td class="border_dark txt" align="center"><?= $d_t_pax[$i]; $SUBTOTALPAX_T = $SUBTOTALPAX_T + $d_t_pax[$i]; $TOTALPAX_T = $TOTALPAX_T + $SUBTOTALPAX_T; ?>
                    </td>
                </tr>
                <?php
 } elseif ($h_day_t != $d_t_dbeg[$i]) { $h_day_t = $d_t_dbeg[$i]; ?>
                <tr>
                    <td class="border_dark txt" align="right" colspan="2">SUBTOTAL
                    </td>
                    <td class="border_dark txt" align="center">&nbsp;
                    </td>
                    <td class="border_dark txt" align="center"><?= $SUBTOTALPAX_T; $SUBTOTALPAX_T = 0; ?>
                    </td>

                </tr>
                <tr>
                    <td class="border_dark txt" align="center"> <?= $d_t_dbeg[$i] ?>
                    </td>
                    <td class="border_dark txt" align="center"> <?= $d_t_end[$i] ?>
                    </td>
                    <td class="border_dark txt" align="center">&nbsp;
                    </td>
                    <td class="border_dark txt" align="center"><?= $d_t_pax[$i]; $SUBTOTALPAX_T = $SUBTOTALPAX_T + $d_t_pax[$i]; $TOTALPAX_T = $TOTALPAX_T + $SUBTOTALPAX_T; ?>
                    </td>
                </tr>

                <?php
 } } ?>
        <tr>
            <td class="border_dark txt" align="right" colspan="2">SUBTOTAL
            </td>
            <td class="border_dark txt" align="center">&nbsp;
            </td>
            <td class="border_dark txt" align="center"><?= $SUBTOTALPAX_T; $SUBTOTALPAX_T = 0; ?>
            </td>

        </tr>
        <tr>
            <td class="capt border_dark txt" align="right" colspan="2">TOTAL</td>
            <td class="capt border_dark txt" align="center"> &nbsp;
            </td>
            <td class="capt border_dark txt" align="center"> <?= $TOTALPAX_T ?>
            </td>

        </tr>

        <?php
 } else { if ((count($d_hotel_inc) == 0) or (count($d_hotel_inc) < 0)) { ?>
            <tr>
                <td class="txt" align="center" colspan="4">Data not found</td>
            </tr>

            <?php
 } } ?>

</table>
</form>
<script>
    fillStates();
</script>
</body>
</html>
