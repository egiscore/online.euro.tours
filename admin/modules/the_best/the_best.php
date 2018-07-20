<?php
$sqlserver = OFFICE_SQLSERVER; $sqldb = OFFICEDB; if (OFFICE_SQLSERVER != '') { $sqlserver = ''; $sqldb = 'ONLINEWEB'; } $TOWNFROMINC = (isset($_REQUEST['TOWNFROMINC'])) ? intval($_REQUEST['TOWNFROMINC']) : TOWNFROMINC; $STATEINC = (isset($_REQUEST['STATEINC'])) ? intval($_REQUEST['STATEINC']) : 0; if (isset($_POST) && isset($_POST['save_new_sort'])) { $SHOW_THEBEST = (isset($_POST['SHOW_THEBEST']) && $tmp = intval($_POST['SHOW_THEBEST'])) ? $tmp : 0; $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Section' => 'online_config', 'What' => 'SHOW_THEBEST', 'Value' => $SHOW_THEBEST, 'UserCode' => INTERNET_USER, ] ); $db->query($sql); $action = 'list'; foreach ($_POST['module'] as $variant => $data) { $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Section' => 'the_best', 'What' => $variant, 'Value' => $data['value'], 'UserCode' => INTERNET_USER, ] ); $db->query($sql); $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Section' => 'the_best', 'What' => $variant . '_SORT', 'Value' => $data['sort'], 'UserCode' => INTERNET_USER, ] ); $db->query($sql); } admin_flash(Get_Message_Lang($LNG, 'adm_success_save')); } else { $action = (isset($_GET['action'])) ? $_GET['action'] : 'list'; } switch ($action) { case 'step1': filter_new_step1(); break; case 'step2': filter_new_step2(); break; case 'step3': filter_new_step3(); break; case 'step4': filter_new_step4(); break; case 'create': filter_create(); admin_flash(Get_Message_Lang($LNG, 'adm_success_add')); echo sprintf('window.location.href = "?page=%s&LNG=%d&TOWNFROMINC=%d&STATEINC=%d";', $ALIAS, $LNG, $TOWNFROMINC, $STATEINC); break; case 'list': if (isset($_POST['delete'])) { filter_delete(); admin_flash(Get_Message_Lang($LNG, 'adm_success_delete')); header(sprintf('Location: ?page=%s&LNG=%d&TOWNFROMINC=%d&STATEINC=%d', $ALIAS, $LNG, $TOWNFROMINC, $STATEINC)); exit; } filters_list(); break; } function filter_delete() { $db = $GLOBALS['db']; $tmp = array_keys($_POST['delete']); $inc = array_shift($tmp); $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'  DELETE FROM  online_best_filter WHERE inc = " . intval($inc) . "'"; $db->query($sql); } function filter_create() { $db = $GLOBALS['db']; $checkfrstatus = (isset($_POST['FRPLACE']) && $_POST['FRPLACE'] == 1) ? 1 : 0; if ($_POST['CHECKIN_BEG'] == 0 || $_POST['CHECKIN_END'] == 0) { $checkin_beg = $checkin_end = 'null'; } else { $checkin_beg = sprintf("''%d''", $_POST['CHECKIN_BEG']); $checkin_end = sprintf("''%d''", $_POST['CHECKIN_END']); } $htplace = ($tmp = intval($_POST['HTPLACEINC'])) ? $tmp : 'null'; $room = ($tmp = intval($_POST['ROOMINC'])) ? $tmp : 'null'; if ($_POST['TOWNS'] != 0) { $townlist = array(); $tmp = explode(',', $_POST['TOWNS']); foreach ($tmp as $town) { if ($h = intval($town)) { $townlist[] = $h; } } $townlist = "''" . implode(',', $townlist) . "''"; } else { $townlist = 'null'; } if ($_POST['STARS'] != 0) { $groupstarlist = array(); $tmp = explode(',', $_POST['STARS']); foreach ($tmp as $star) { if ($h = intval($star)) { $groupstarlist[] = $h; } } $groupstarlist = "''" . implode(',', $groupstarlist) . "''"; } else { $groupstarlist = 'null'; } if ($_POST['VIPTYPES'] != 0) { $viptypelist = array(); $tmp = explode(',', $_POST['VIPTYPES']); foreach ($tmp as $viptype) { if ($h = intval($viptype)) { $viptypelist[] = $h; } } $viptypelist = "''" . implode(',', $viptypelist) . "''"; } else { $viptypelist = 'null'; } if ($_POST['HOTELS'] != 0) { $hotellist = array(); $tmp = explode(',', $_POST['HOTELS']); foreach ($tmp as $hotel) { if ($h = intval($hotel)) { $hotellist[] = $h; } } $hotellist = "''" . implode(',', $hotellist) . "''"; } else { $hotellist = 'null'; } $sortorder = 0; $description = str_replace("'", "''''", filter_decription()); $packet_type = intval($_POST['PACKET']); $tour = intval($_POST['TOURINC']); if ($tour == 0) { $tour = 'null'; } $program = isset($_POST['PROGRAMINC']) ? intval($_POST['PROGRAMINC']) : 0; if ($program == 0) { $program = 'null'; } if ($_POST['MEALS'] != 0) { $groupmeallist = array(); $tmp = explode(',', $_POST['MEALS']); foreach ($tmp as $meal) { if ($h = intval($meal)) { $groupmeallist[] = $h; } } $groupmeallist = "''" . implode(',', $groupmeallist) . "''"; } else { $groupmeallist = 'null'; } if (isset($_POST['MINDAYSBEFORE']) && intval($_POST['MINDAYSBEFORE']) > 0) { $mindaysbefore = intval($_POST['MINDAYSBEFORE']); } else { $mindaysbefore = 'null'; } if (isset($_POST['MAXDAYSBEFORE']) && intval($_POST['MAXDAYSBEFORE']) > 0) { $maxdaysbefore = intval($_POST['MAXDAYSBEFORE']); } else { $maxdaysbefore = 'null'; } $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'
        SET NOCOUNT ON;
        INSERT INTO online_best_filter (
            [TownFrom],[State],[nights_from], [nights_till], [CheckinBeg],[CheckinEnd],[CheckFrStatus],[Adult],
            [Child],[Room],[HtPlace],[HotelList],[Limit],[SortOrder], [Town], [GroupStar], [VipType], [description],
            [packet_type], [GroupMeal], [Tour], [mindaysbeforetour],[maxdaysbeforetour], [ptype], [user_code])
        VALUES (
            " . intval($_POST['TOWNFROMINC']) . "," . intval($_POST['STATEINC']) . "," . intval($_POST['NIGHTS_FROM']) . "," . intval($_POST['NIGHTS_TILL']) . ",
            " . $checkin_beg . "," . $checkin_end . "," . $checkfrstatus . "," . intval($_POST['ADULT']) . "," . intval($_POST['CHILD']) . ",
            " . $room . "," . $htplace . "," . $hotellist . "," . intval($_POST['LIMIT']) . "," . $sortorder . ", " . $townlist . ", " . $groupstarlist . ", " . $viptypelist . ", ''" . $description . "'',
            " . $packet_type . "," . $groupmeallist . ", " . $tour . ", " . $mindaysbefore . "," . $maxdaysbefore . ", " . $program . ", " . INTERNET_USER . "
        );
        SELECT SCOPE_IDENTITY() AS [FilterInc] '"; $row = $db->fetchRow($sql); $filterInc = $row['FilterInc']; $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_job_the_best @BestFilter = ' . $filterInc . ', @Debug = 0'; $db->query($sql); } function format_date($date) { preg_match('~(\d{4})(\d{2})(\d{2})~', $date, $matches); return $matches[3] . '.' . $matches[2] . '.' . $matches[1]; } function filter_decription() { $db = $GLOBALS['db']; $sqlserver = $GLOBALS['sqlserver']; $sqldb = $GLOBALS['sqldb']; $LNG = $GLOBALS['LNG']; include _ROOT . 'includes/helpers/modifier.inflect.php'; $town = $db->fetchOne('SELECT LName FROM ' . $sqlserver . '.' . $sqldb . '.dbo.Town WHERE inc = ' . intval($_POST['TOWNFROMINC'])); $state = $db->fetchOne('SELECT LName FROM ' . $sqlserver . '.' . $sqldb . '.dbo.State WHERE inc = ' . intval($_POST['STATEINC'])); $tour = '##adm_the_best_description_all_tours##'; $meals = ''; $program = ''; if (intval($_POST['TOURINC']) > 0) { $tour = ' ##adm_the_best_description_one_tour## "' . $db->fetchOne('SELECT LName FROM ' . $sqlserver . '.' . $sqldb . '.dbo.Tour WHERE inc = ' . intval($_POST['TOURINC'])) . '"'; } if (isset($_POST['PROGRAMINC']) && intval($_POST['PROGRAMINC']) > 0) { $program = '##adm_the_best_description_program## "' . $db->fetchOne('SELECT LName FROM ' . $sqlserver . '.' . $sqldb . '.dbo.ptype WHERE inc = ' . intval($_POST['PROGRAMINC'])) . '"'; } $nights_from = intval($_POST['NIGHTS_FROM']); $nights_till = intval($_POST['NIGHTS_TILL']); $packet_type = intval($_POST['PACKET']); if ($packet_type == 1) { $packet_type = '##adm_the_best_description_only_freight##'; } elseif ($packet_type == 2) { $packet_type = '##adm_the_best_description_only_accomodation##'; } else { $packet_type = '##adm_the_best_description_full_package##'; } if ($_POST['CHECKIN_BEG'] == 0 || $_POST['CHECKIN_END'] == 0) { $dates = '##adm_the_best_description_next_flight##'; } else { if ($_POST['CHECKIN_BEG'] != $_POST['CHECKIN_END']) { $dates = ' ##adm_the_best_description_flight_from## ' . format_date($_POST['CHECKIN_BEG']) . ' ##adm_the_best_description_flight_till## ' . format_date($_POST['CHECKIN_END']); } else { $dates = '##adm_the_best_description_to_flight## ' . format_date($_POST['CHECKIN_BEG']); } } if ((isset($_POST['FRPLACE']) && $_POST['FRPLACE'] == 1)) { $dates .= ' ##adm_the_best_description_with_seats## '; } $razm = ''; if ($tmp = intval($_POST['ADULT'])) { $razm .= $tmp . ' AD '; } if ($tmp = intval($_POST['CHILD'])) { $razm .= '+' . $tmp . ' CHD'; } if ($tmp = intval($_POST['ROOMINC'])) { $razm .= '(Room - ' . $db->fetchOne('SELECT LName FROM ' . $sqlserver . '.' . $sqldb . '.dbo.room WHERE inc = ' . $tmp) . ')'; } if ($tmp = intval($_POST['HTPLACEINC'])) { $razm .= '(htplace - ' . $db->fetchOne('SELECT LName FROM ' . $sqlserver . '.' . $sqldb . '.dbo.htplace WHERE inc = ' . $tmp) . ')'; } if ($_POST['HOTELS'] != 0) { $_hotels = array(); $tmp = explode(',', $_POST['HOTELS']); $i = 0; foreach ($tmp as $hotel) { $i++; $_hotels[] = $db->fetchOne('SELECT LName FROM ' . $sqlserver . '.' . $sqldb . '.dbo.Hotel WHERE inc = ' . intval($hotel)); if ($i >= 20) { break; } } $hotels = implode(',', $_hotels); if (count($tmp) > 20) { $hotels .= '... (##adm_the_best_description_hotel_total## ' . smarty_modifier_inflect(count($tmp), '##adm_the_best_description_hotel_one##', '##adm_the_best_description_hotel_three##', '##adm_the_best_description_hotel_five##') . ')'; } } else { $hotels = '##adm_the_best_description_hotel_any## ('; if ($_POST['TOWNS'] != 0) { $_tmp = array(); $tmp = explode(',', $_POST['TOWNS']); $i = 0; foreach ($tmp as $one) { $i++; $_tmp[] = $db->fetchOne('SELECT LName FROM ' . $sqlserver . '.' . $sqldb . '.dbo.Town WHERE inc = ' . intval($one)); if ($i >= 20) { break; } } $hotels .= implode(',', $_tmp); if (count($tmp) > 20) { $hotels .= '... (##adm_the_best_description_town_total## ' . smarty_modifier_inflect(count($tmp), '##adm_the_best_description_town_one##', '##adm_the_best_description_town_three##', '##adm_the_best_description_town_five##') . ')'; } $hotels .= ';'; } if ($_POST['STARS'] != 0) { $hotels .= ' '; $_tmp = array(); $tmp = explode(',', $_POST['STARS']); $i = 0; foreach ($tmp as $one) { $i++; $_tmp[] = $db->fetchOne('SELECT Name FROM ' . $sqlserver . '.' . $sqldb . '.dbo.[stargroup] WHERE inc = ' . intval($one)); if ($i >= 20) { break; } } $hotels .= implode(',', $_tmp); if (count($tmp) > 20) { $hotels .= '... (##adm_the_best_description_star_total## ' . smarty_modifier_inflect(count($tmp), '##adm_the_best_description_star_one##', '##adm_the_best_description_star_three##', '##adm_the_best_description_star_five##') . ')'; } $hotels .= ';'; } if ($_POST['VIPTYPES'] != 0) { $hotels .= ' '; $_tmp = array(); $tmp = explode(',', $_POST['VIPTYPES']); $i = 0; foreach ($tmp as $one) { $i++; $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'  SELECT [Name] FROM [Attribute].[Hotel] WHERE [inc] = " . intval($one) . "'"; $_tmp[] = $db->fetchOne($sql); if ($i >= 20) { break; } } $hotels .= implode(',', $_tmp); if (count($tmp) > 20) { $hotels .= '... (##adm_the_best_description_viptype_total## ' . smarty_modifier_inflect(count($tmp), '##adm_the_best_description_viptype_one##', '##adm_the_best_description_viptype_three##', '##adm_the_best_description_viptype_five##') . ')'; } $hotels .= ';'; } $hotels .= ')'; if ($_POST['MEALS'] != 0) { $_tmp = array(); $tmp = explode(',', $_POST['MEALS']); $i = 0; foreach ($tmp as $one) { $i++; $_tmp[] = $db->fetchOne('SELECT Name FROM ' . $sqlserver . '.' . $sqldb . '.dbo.mealgroup WHERE inc = ' . intval($one)); } $meals = ' ##adm_the_best_description_with_meal## ' . implode(',', $_tmp); } } $limit = intval($_POST['LIMIT']); if ($nights_from == $nights_till) { $nights = smarty_modifier_inflect($nights_from, '##adm_the_best_description_night_one##', '##adm_the_best_description_night_three##', '##adm_the_best_description_night_five##'); } else { $nights = '##adm_the_best_description_nights_from## ' . $nights_from . ' ##adm_the_best_description_nights_till## ' . $nights_till . ' ##adm_the_best_description_nights##'; } $result = ' ##adm_the_best_description_for## ' . $tour . ' ' . $program . ' ' . $packet_type . ' ##adm_the_best_description_from## ' . $town . ' ##adm_the_best_description_to## ' . $state . ' ##adm_the_best_description_with_duration## ' . $nights . ', ' . $dates . ' ##adm_the_best_description_with_accomodation## ' . $razm . ' ##adm_the_best_description_in_hotels## ' . $hotels . ' ' . $meals . ' ##adm_the_best_description_search## ' . $limit . ' ##adm_the_best_description_lowest_price_offers##'; return $result; } function filters_list() { $db = $GLOBALS['db']; $ALIAS = $GLOBALS['ALIAS']; $LNG = $GLOBALS['LNG']; $http_site = $GLOBALS['http_site']; $TOWNSFROM = array(); include TOWNSFROM_CACHE; $townfroms = array(); $statesto = array(); $TOWNFROMINC = (isset($_GET['TOWNFROMINC'])) ? intval($_GET['TOWNFROMINC']) : TOWNFROMINC; $STATEINC = (isset($_GET['STATEINC'])) ? intval($_GET['STATEINC']) : 0; $townfrom_exists = false; foreach ($TOWNSFROM AS $direction) { if ($direction['townFrom'] == $TOWNFROMINC) { $townfrom_exists = true; break; } } if (!$townfrom_exists) { $first_direction = reset($TOWNSFROM); $TOWNFROMINC = $first_direction['townFrom']; } foreach ($TOWNSFROM AS $direction) { if (!isset($townfroms[$direction['townFrom']])) { $townfroms[$direction['townFrom']] = array('title' => $direction['townName'], 'selected' => $direction['townFrom'] == $TOWNFROMINC); } if (!isset($statesto[$direction['state']]) && $direction['townFrom'] == $TOWNFROMINC) { if (!$STATEINC) { $STATEINC = $direction['state']; } $statesto[$direction['state']] = array('title' => $direction['stateName'], 'selected' => $direction['state'] == $STATEINC); } } $criteria = array(); if ($TOWNFROMINC) { $criteria[] = 'bf.TownFrom = ' . $TOWNFROMINC; } if ($STATEINC) { $criteria[] = 'bf.State = ' . $STATEINC; } $filters = array(); $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'
        SELECT bf.inc AS Inc, bf.description,
            tf.lname AS TownFrom,
            bf.TownFrom AS TownFromInc,
            s.lname AS State,
            bf.State AS StateInc,
            nights_from,
            nights_till,
            bf.CheckinBeg,
            bf.CheckinEnd,
            bf.mindaysbeforetour,
            bf.maxdaysbeforetour,
            CASE CheckFrStatus WHEN 1 THEN ''" . Get_Message_Lang($LNG, 'adm_the_best_with_frblock') . "'' ELSE '''' END AS CheckFrStatus,
            CASE bf.Adult WHEN 0 THEN ''&mdash;'' ELSE CONVERT(varchar,bf.Adult) END AS Adult,
            CASE bf.Child WHEN 0 THEN ''&mdash;'' ELSE CONVERT(varchar,bf.Child) END AS Child,
            r.lname AS Room, ht.name AS  HtPlace,
            convert(text,bf.HotelList) AS HotelList,
            bf.Limit AS Limit, bf.Town AS TownList,
            convert(text,bf.GroupStar) AS GroupStarList,
            convert(text,bf.VipType) AS VipTypeList,
            CASE packet_type WHEN 0 THEN ''" . Get_Message_Lang($LNG, 'adm_the_best_full_package') . "'' WHEN 1 THEN ''" . Get_Message_Lang($LNG, 'adm_the_best_only_flight') . "'' WHEN 2 THEN ''" . Get_Message_Lang($LNG, 'adm_the_best_only_accomodation') . "'' END AS packet_type,
            convert(text,bf.GroupMeal) AS GroupMealList,
            t.lname AS Tour,
            ptype.LName AS Program,
            [Rec].[Found]
        FROM [dbo].[online_best_filter] AS bf
         INNER JOIN town tf ON bf.TownFrom = tf.inc
         LEFT JOIN tour t ON bf.Tour = t.inc
         LEFT JOIN state s ON bf.State = s.inc
         LEFT JOIN room r ON bf.room = r.inc
         LEFT JOIN htplace ht ON bf.htplace = ht.inc
         LEFT JOIN ptype ON bf.ptype = ptype.inc
         CROSS APPLY (
            SELECT COUNT(*) AS [Found] FROM dbo.online_best tb WHERE tb.filter = bf.inc
         ) AS [Rec]
         WHERE " . implode(' AND ', $criteria) . "
         ORDER BY SortOrder,Inc DESC'
     "; $theBestControl = true; $SHOW_THEBEST = intval(Get_Config_Value('SHOW_THEBEST')); if (!$SHOW_THEBEST) { $countSQL = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'
         SELECT COUNT(inc) FROM [dbo].[online_best_filter]'
         "; $countResult = $db->fetchOne($countSQL); if (!$countResult) { $theBestControl = false; } } if (false !== ($res = $db->fetchAll($sql))) { $hotels = array(); $viptypes = array(); $towns = array(); $stars = array(); $meals = array(); foreach ($res as $row) { $row['CheckinBeg'] = Samo_Datetime::parse($row['CheckinBeg']); $row['CheckinEnd'] = Samo_Datetime::parse($row['CheckinEnd']); if ($row['CheckinBeg']->not_null() || $row['CheckinEnd']->not_null()) { if ($row['CheckinBeg']->not_null() && $row['CheckinEnd']->not_null() && $row['CheckinBeg']->ne($row['CheckinEnd'])) { $row['Checkin'] = $row['CheckinBeg'] . '&mdash;' . $row['CheckinEnd']; } elseif ($row['CheckinBeg']->not_null() && $row['CheckinEnd']->not_null() && $row['CheckinBeg']->eq($row['CheckinEnd'])) { $row['Checkin'] = $row['CheckinBeg']; } elseif ($row['CheckinBeg']->not_null() && $row['CheckinEnd']->is_null()) { $row['Checkin'] = $row['CheckinBeg']; } elseif ($row['CheckinEnd']->not_null() && $row['CheckinBeg']->is_null()) { $row['Checkin'] = $row['CheckinEnd']; } } else { $row['Checkin'] = null; } if ($row['mindaysbeforetour'] > 0 || $row['maxdaysbeforetour'] > 0) { $row['Checkin'] .= '<br> ' . ' '; if ($row['mindaysbeforetour'] > 0) { $row['Checkin'] .= Get_Message_Lang($LNG, 'adm_the_best_days1') . ' ' . $row['mindaysbeforetour']; } if ($row['maxdaysbeforetour'] > 0) { $row['Checkin'] .= ($row['mindaysbeforetour'] > 0 ? ' ' : '') . Get_Message_Lang($LNG, 'adm_the_best_days2') . ' ' . $row['maxdaysbeforetour']; } $row['Checkin'] .= ' ' . Get_Message_Lang($LNG, 'adm_the_best_days'); } if ($row['HotelList']) { $row['HotelList'] = explode(',', $row['HotelList']); $hotels = array_merge($hotels, $row['HotelList']); } if ($row['VipTypeList']) { $row['VipTypeList'] = explode(',', $row['VipTypeList']); $viptypes = array_merge($viptypes, $row['VipTypeList']); } if ($row['TownList']) { $row['TownList'] = explode(',', $row['TownList']); $towns = array_merge($towns, $row['TownList']); } if ($row['GroupStarList']) { $row['GroupStarList'] = explode(',', $row['GroupStarList']); $stars = array_merge($stars, $row['GroupStarList']); } if ($row['GroupMealList']) { $row['GroupMealList'] = explode(',', $row['GroupMealList']); $meals = array_merge($meals, $row['GroupMealList']); } $s_filter = htmlspecialchars($row['description'], ENT_QUOTES, 'cp1251'); foreach ($GLOBALS['language'][$LNG] as $key => $value) { $s_filter = str_replace('##' . $key . '##', $value, $s_filter); } $row['description'] = $s_filter; $filters[] = $row; } if (count($hotels)) { $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'SELECT Inc,LName FROM dbo.hotel WHERE INC IN (" . implode(',', array_unique($hotels)) . ")' "; if (false !== ($res = $db->fetchAll($sql))) { $hotels = array(); foreach ($res as $row) { $hotels[$row['Inc']] = $row['LName']; } } } if (count($towns)) { $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'SELECT Inc,LName FROM dbo.town WHERE INC IN (" . implode(',', array_unique($towns)) . ")' "; if (false !== ($res = $db->fetchAll($sql))) { $towns = array(); foreach ($res as $row) { $towns[$row['Inc']] = $row['LName']; } } } if (count($viptypes)) { $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'SELECT Inc, Name AS LName FROM [Attribute].[Hotel] WHERE [inc] IN (" . implode(',', array_unique($viptypes)) . ")' "; if (false !== ($res = $db->fetchAll($sql))) { $viptypes = array(); foreach ($res as $row) { $viptypes[$row['Inc']] = $row['LName']; } } } if (count($stars)) { $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'SELECT Inc,Name AS LName FROM dbo.stargroup WHERE INC IN (" . implode(',', array_unique($stars)) . ")' "; if (false !== ($res = $db->fetchAll($sql))) { $stars = array(); foreach ($res as $row) { $stars[$row['Inc']] = $row['LName']; } } } if (count($meals)) { $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'SELECT Inc,Name AS LName FROM dbo.online_group_meal WHERE INC IN (" . implode(',', array_unique($meals)) . ")' "; if (false !== ($res = $db->fetchAll($sql))) { $meals = array(); foreach ($res as $row) { $meals[$row['Inc']] = $row['LName']; } } } $listnames = function ($list, $incs) { $return = array(); if (is_array($incs)) { foreach ($incs as $inc) { if (isset($list[$inc])) { $return[] = $list[$inc]; } } return implode(', ', $return) . '<br>'; } return '&mdash;&nbsp;'; }; foreach ($filters as $key => $filter) { $filters[$key]['HotelList'] = $listnames($hotels, $filter['HotelList']); $filters[$key]['VipTypeList'] = $listnames($viptypes, $filter['VipTypeList']); $filters[$key]['TownList'] = $listnames($towns, $filter['TownList']); $filters[$key]['GroupStarList'] = $listnames($stars, $filter['GroupStarList']); $filters[$key]['GroupMealList'] = $listnames($meals, $filter['GroupMealList']); } } style(); $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Section' => 'the_best', 'UserCode' => INTERNET_USER, ] ); $res = $db->fetchAllWithKey($sql, 'What'); $any_equal = array('0' => Get_Message_Lang($LNG, 'adm_the_best_rank_does_not_matter'), '1' => Get_Message_Lang($LNG, 'adm_the_best_rank_exact')); $cnt30 = array(); for ($i = -1; $i <= 30; $i++) { $cnt30[$i] = $i; } $cnt100 = array(); for ($i = -1; $i <= 100; $i++) { $cnt100[$i] = $i; } $variants = array(); $variants[] = array('alias' => 'THE_BEST_RANK_TOUR', 'title' => Get_Message_Lang($LNG, 'adm_the_best_rank_tour_name'), 'value' => $res['THE_BEST_RANK_TOUR']['Value'], 'sort' => $res['THE_BEST_RANK_TOUR_SORT']['Value'], 'var' => $any_equal); $variants[] = array('alias' => 'THE_BEST_RANK_HOTEL_TOWN', 'title' => Get_Message_Lang($LNG, 'adm_the_best_rank_hotel_town_name'), 'value' => $res['THE_BEST_RANK_HOTEL_TOWN']['Value'], 'sort' => $res['THE_BEST_RANK_HOTEL_TOWN_SORT']['Value'], 'var' => $any_equal); $variants[] = array('alias' => 'THE_BEST_RANK_CHECKIN', 'title' => Get_Message_Lang($LNG, 'adm_the_best_rank_checkin_name'), 'value' => $res['THE_BEST_RANK_CHECKIN']['Value'], 'sort' => $res['THE_BEST_RANK_CHECKIN_SORT']['Value'], 'var' => $cnt30); $variants[] = array('alias' => 'THE_BEST_RANK_NIGHTS', 'title' => Get_Message_Lang($LNG, 'adm_the_best_rank_nights_name'), 'value' => $res['THE_BEST_RANK_NIGHTS']['Value'], 'sort' => $res['THE_BEST_RANK_NIGHTS_SORT']['Value'], 'var' => $cnt30); $variants[] = array('alias' => 'THE_BEST_RANK_PRICE', 'title' => Get_Message_Lang($LNG, 'adm_the_best_rank_price_name'), 'value' => $res['THE_BEST_RANK_PRICE']['Value'], 'sort' => $res['THE_BEST_RANK_PRICE_SORT']['Value'], 'var' => $cnt100); usort( $variants, function ($a, $b) { return (int)$a['sort'] > (int)$b['sort']; } ); ?>
    <?= style_css() ?>
    <?= admin_flash() ?>
    <script src="<?= WWWROOT ?>public/js/pack.main.js?_<?= filemtime(_ROOT . 'public/js/pack.main.js') ?>"></script>
    <div class="samo_container">
        <form method="POST">
            <input type="hidden" name="page" value="<?= $ALIAS ?>">
            <input type="hidden" name="LNG" id="LNG" value="<?= $LNG ?>">
            <?php if ($theBestControl) { ?>
            <div>
                <?= Get_Message_Lang($LNG, 'adm_the_best_show_thebest') ?>
                <select name="SHOW_THEBEST" style="width: 64px;">
                    <option value="0" <?= $SHOW_THEBEST ? '' : 'selected="selected"' ?>><?= Get_Message_Lang($LNG, 'adm_config_no') ?></option>
                    <option value="1" <?= $SHOW_THEBEST ? 'selected="selected"' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_yes') ?></option>
                </select>
            </div>
            <?php } ?>
            <br clear="all">
            <table id="the_best_rank" class="std res" style="width: 60%;">
                <thead>
                <tr>
                    <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_the_best_rank_name') ?></td>
                    <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_the_best_rank_value') ?></td>
                    <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_the_best_rank_sort') ?></td>
                </tr>
                </thead>
                <tbody>
                <?php
 foreach ($variants as $key => $data) { $variant = $data['alias']; ?>
                    <tr>
                        <td class="border title">
                            <?= !empty($data['title']) ? $data['title'] : '&lt;' . '---' . '&gt;' ?>
                        </td>
                        <td class="border" style="white-space: nowrap;">
                            <?= (in_array($variant, array('THE_BEST_RANK_CHECKIN', 'THE_BEST_RANK_NIGHTS', 'THE_BEST_RANK_PRICE'))) ? '+/-' : '' ?>
                            <select id="<?= $variant; ?>"
                                    name="module[<?= $variant ?>][value]" <?= (in_array($variant, array('THE_BEST_RANK_CHECKIN', 'THE_BEST_RANK_NIGHTS', 'THE_BEST_RANK_PRICE'))) ? 'style="width: 64px"' : '' ?>>
                                <?php
 foreach ($data['var'] as $var_value => $var_title) { if (in_array($variant, array('THE_BEST_RANK_CHECKIN', 'THE_BEST_RANK_NIGHTS', 'THE_BEST_RANK_PRICE')) && $var_value < 0) { $var_title = '---'; } echo '<option value="' . $var_value . '" ' . ($data['value'] == $var_value ? 'selected' : '') . '>' . $var_title . '</option>'; } ?>
                            </select>
                            <?php
 if ($variant == 'THE_BEST_RANK_CHECKIN') { echo Get_Message_Lang($LNG, 'adm_the_best_rank_checkin_days'); } elseif ($variant == 'THE_BEST_RANK_PRICE') { echo '%'; } ?>
                        </td>
                        <td class="border">
                            <input align="top" class="updown" type="image"
                                   src="<?= $http_site; ?>public/pict/uparrow.png" value="up">
                            <input align="top" class="updown" type="image"
                                   src="<?= $http_site; ?>public/pict/downarrow.png" value="down">
                            <input class="position" type="input" maxlength="2" size="2" id="<?= $variant ?>_SORT"
                                   name="module[<?= $variant ?>][sort]" value="<?= $data['sort'] ?>">

                        </td>
                    </tr>
                    <?php
 } ?>
                </tbody>
            </table>
            <br clear="all">
            <input type="submit" class="save_new_sort" name="save_new_sort"
                   value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>""/>
        </form>
        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
                    $('.updown').click(function (e) {
                        e.preventDefault();
                        var updown = this.value;
                        if (updown == 'up' && $(this).parents('tr').prev().find('.position').val()) {
                            var val_1 = $(this).nextAll('.position').val();
                            var val_2 = $(this).parents('tr').prev().find('.position').val();
                            $(this).nextAll('.position').val(val_2)
                            $(this).parents('tr').prev().find('.position').val(val_1);
                            $(this).parents('tr').insertBefore($(this).parents('tr').prev());
                        }
                        if (updown == 'down' && $(this).parents('tr').next().find('.position').val()) {
                            var val_1 = $(this).nextAll('.position').val();
                            var val_2 = $(this).parents('tr').next().find('.position').val();
                            $(this).nextAll('.position').val(val_2)
                            $(this).parents('tr').next().find('.position').val(val_1);
                            $(this).parents('tr').next().insertBefore($(this).parents('tr'));
                        }
                    });
                    $('.position').blur(function (e) {
                        e.preventDefault();
                        if (parseInt($(this).val()) >= parseInt($(this).parents('tr').next().find('.position').val())) {
                            while (parseInt($(this).val()) >= parseInt($(this).parents('tr').next().find('.position').val())) {
                                var obj = $(this).parents('tr').next().find('.position');
                                obj.val(parseInt(obj.val()) - 1);
                                $(this).parents('tr').next().insertBefore($(this).parents('tr'));
                            }
                        } else {
                            while (parseInt($(this).val()) <= parseInt($(this).parents('tr').prev().find('.position').val())) {
                                var obj = $(this).parents('tr').prev().find('.position');
                                obj.val(parseInt(obj.val()) + 1);
                                $(this).parents('tr').insertBefore($(this).parents('tr').prev());
                            }
                        }
                    });
                });
            })(samo.jQuery);
        </script>
        <br clear="all">

        <div><?= Get_Message_Lang($LNG, 'adm_the_best_filter_list'); ?></div>
        <br clear="all">
        <table class="std container panel" style="width: 97%;">
            <tr>
                <td class="n2">
                    <form method="GET" action="?">
                        <input type="hidden" name="page" value="<?= $ALIAS ?>">
                        <input type="hidden" name="LNG" value="<?= $LNG ?>">
                        <input type="hidden" name="action" value="list">
                        <table>
                            <tr>
                                <td class="txt"><?= Get_Message_Lang($LNG, 'adm_townfrom'); ?></td>
                                <td style="width: 30%;"><select name="TOWNFROMINC" onchange="submit()">
                                        <?php
 foreach ($townfroms as $inc => $data) { $selected = ($data['selected']) ? 'selected' : ''; echo '<option value="' . $inc . '" ' . $selected . '>' . $data['title'] . '</option>'; } ?>
                                    </select></td>
                                <td class="txt"><?= Get_Message_Lang($LNG, 'adm_state'); ?></td>
                                <td style="width: 30%;"><select name="STATEINC" onchange="submit()">
                                        <?php
 foreach ($statesto as $inc => $data) { $selected = ($data['selected']) ? 'selected' : ''; echo '<option value="' . $inc . '" ' . $selected . '>' . $data['title'] . '</option>'; } ?>
                                    </select></td>
                            </tr>
                        </table>
                    </form>
                </td>
                <td style="width: 25%; text-align: right;" class="n2">
                    <form>
                        <input type="hidden" name="action" value="step1">
                        <input type="hidden" name="LNG" value="<?= $LNG ?>">
                        <input type="hidden" name="page" value="<?= $ALIAS ?>">
                        <input type="hidden" name="TOWNFROMINC" value="<?= $TOWNFROMINC ?>">
                        <input type="hidden" name="STATEINC" value="<?= $STATEINC ?>">
                        <input type="submit" value="<?= Get_Message_Lang($LNG, 'adm_the_best_new_filter'); ?>" id="new">
                    </form>
                </td>
            </tr>
        </table>
        <?php
 if (count($filters)) { ?>
            <br>
            <form method="POST" action="?page=<?= $ALIAS ?>&LNG=<?= $LNG ?>&action=list">
                <input type="hidden" name="TOWNFROMINC" value="<?= $TOWNFROMINC ?>">
                <input type="hidden" name="STATEINC" value="<?= $STATEINC ?>">
                <table class="std res">
                    <thead>
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2"><?= Get_Message_Lang($LNG, 'adm_the_best_direction'); ?></th>
                        <th rowspan="2"><?= Get_Message_Lang($LNG, 'adm_the_best_checkin'); ?></th>
                        <th rowspan="2"><?= Get_Message_Lang($LNG, 'adm_the_best_nights'); ?></th>
                        <th rowspan="2"><?= Get_Message_Lang($LNG, 'adm_tour'); ?>
                            <br><?= Get_Message_Lang($LNG, 'adm_the_best_tourtype'); ?>
                            <br><?= Get_Message_Lang($LNG, 'adm_the_best_program'); ?></th>
                        <th rowspan="2"><?= Get_Message_Lang($LNG, 'adm_the_best_mrmrs_chd'); ?></th>
                        <th rowspan="2"><?= Get_Message_Lang($LNG, 'adm_the_best_room'); ?>
                            <br><?= Get_Message_Lang($LNG, 'adm_the_best_htplace'); ?>
                            <br><?= Get_Message_Lang($LNG, 'adm_the_best_meal'); ?></th>
                        <th colspan="4"><?= Get_Message_Lang($LNG, 'adm_the_best_hotel'); ?></th>
                        <th rowspan="2"><?= Get_Message_Lang($LNG, 'adm_the_best_limit_found'); ?></th>
                        <th rowspan="2"><?= Get_Message_Lang($LNG, 'adm_the_best_actions'); ?></th>
                    </tr>
                    <tr>
                        <th><?= Get_Message_Lang($LNG, 'adm_the_best_town'); ?></th>
                        <th><?= Get_Message_Lang($LNG, 'adm_the_best_star'); ?></th>
                        <th><?= Get_Message_Lang($LNG, 'adm_the_best_type'); ?></th>
                        <th><?= Get_Message_Lang($LNG, 'adm_the_best_hotel_list'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
 $i = 0; foreach ($filters as $filter) { $i++; ?>
                        <tr <?= ($i % 2 == 0) ? 'class="silver"' : '' ?>>
                            <td>
                                <a target="_blank"
                                   href="<?= WWWROOT . 'default.php?page=the_best&TOWNFROMINC=' . $filter['TownFromInc'] . '&STATEINC=' . $filter['StateInc'] . '&FILTER=' . $filter['Inc'] ?>"
                                   title="<?= $filter['description'] ?>"><?= $filter['Inc'] ?></a>
                            </td>
                            <td><?= $filter['TownFrom'] ?> - <?= $filter['State'] ?></td>
                            <td><?= $filter['Checkin'] ?></td>
                            <td>
                                <?php
 if ($filter['nights_from'] == $filter['nights_till']) { echo $filter['nights_from']; } else { echo Get_Message_Lang($LNG, 'adm_the_best_description_nights_from') . '&nbsp;' . $filter['nights_from'] . '&nbsp;' . Get_Message_Lang($LNG, 'adm_the_best_description_nights_till') . '&nbsp;' . $filter['nights_till']; } ?>
                            </td>
                            <td><?= $filter['Tour'] ?><br><?= $filter['packet_type'] ?>
                                &nbsp;<?= $filter['CheckFrStatus'] ?><br><?= $filter['Program'] ?></td>
                            <td><?= $filter['Adult'] ?><br><?= $filter['Child'] ?></td>
                            <td><?= $filter['Room'] ?><br><?= $filter['HtPlace'] ?><br><?= $filter['GroupMealList'] ?>
                            </td>
                            <td><?= $filter['TownList'] ?></td>
                            <td><?= $filter['GroupStarList'] ?></td>
                            <td><?= $filter['VipTypeList'] ?></td>
                            <td><?= $filter['HotelList'] ?></td>
                            <td><?= $filter['Limit'] ?> /
                                <span <?= (!$filter['Found']) ? 'class="warning"' : '' ?>><?= $filter['Found'] ?></span>
                            </td>
                            <td>
                                <input type="submit" name="delete[<?= $filter['Inc'] ?>]"
                                       value="<?= Get_Message_Lang($LNG, 'adm_delete_botton'); ?>"
                                       onclick="return confirm('<?= Get_Message_Lang($LNG, 'adm_confirm_delete'); ?>');">
                            </td>
                        </tr>
                        <?php
 } ?>
                    </tbody>
                </table>
            </form>
            <?php
 } else { echo Get_Message_Lang($LNG, 'adm_the_best_filter_notfound'); } ?>
    </div>
    <?php
} function filter_new_step4() { try { $orig_GET = $_GET; $_GET = array('TOWNFROMINC' => $_POST['TOWNFROMINC'], 'STATEINC' => $_POST['STATEINC'], 'TOURINC' => $_POST['TOURINC']); invokeSearchModuleAction('admin_action', $_GET); $_GET = $orig_GET; $vars = Samo_Registry::get('view')->get_template_vars(); $towns = checklistbox($vars['TOWNS']); $stars = checklistbox($vars['STARS']); $hotels = hotellist($vars['HOTELS']); $meals = checklistbox($vars['MEALS']); $hoteltypes = checklistbox($vars['HOTELTYPES']); } catch (Exception $e) { $hotels = $towns = $stars = $meals = $hoteltypes = 'Internal Server Error' . $e->getMessage(); } ?>
    samo.jQuery('#step3_container select').prop('disabled',true);
    samo.jQuery("#step4_container").css('display','block');
    samo.jQuery('#HOTELS').html('<?= $hotels ?>');
    samo.jQuery('#TOWNTO').html('<?= $towns ?>');
    samo.jQuery('#STARS').html('<?= $stars ?>');
    samo.jQuery('#MEALS').html('<?= $meals ?>');
    samo.jQuery('#VIPTYPE').html('<?= $hoteltypes ?>');
    samo.jQuery('#step4').remove();
    <?php
} function filter_new_step3() { ?>
    if (samo.jQuery("#CHECKIN_BEG").getDate() > samo.jQuery("#CHECKIN_END").getDate()) {
    samo.jQuery("#CHECKIN_END").css('background-color','pink');
    } else {
    samo.jQuery(".date").css('background-color','#EBEBE4');
    samo.jQuery('#step2_container select, #step2_container input').prop('disabled',true);
    samo.jQuery("#step3_container").css('display','block');
    samo.jQuery('#step3').remove();
    }
    <?php
} function filter_new_step2() { ?>
    samo.jQuery("#step1_container select, #step1_container input").prop("disabled",true);
    samo.jQuery("#step2_container").css('display','block');
    samo.jQuery('#step2').remove();
    <?php
} function invokeSearchModuleAction($action, $env) { invokeModuleAction(Samo::TOWNFROMHOTELINC == $env['TOWNFROMINC'] ? 'search_hotel' : 'search_tour', $action, $env); } function filter_new_step1() { $sqlserver = $GLOBALS['sqlserver']; $sqldb = $GLOBALS['sqldb']; $LNG = $GLOBALS['LNG']; $ALIAS = $GLOBALS['ALIAS']; try { invokeSearchModuleAction('admin_action', $_GET); $vars = Samo_Registry::get('view')->get_template_vars(); $TOWNFROMINC = $_GET['TOWNFROMINC']; $STATEINC = $_GET['STATEINC']; $db = Samo_Registry::get('db'); $blank = array(array('id' => 0, 'altname' => '-----', 'name' => '-----', 'selected' => 0)); $room = array_merge($blank, $db->fetchAll('SELECT Inc AS id,LName AS name ,Name AS altname,0 AS selected  FROM ' . $sqlserver . '.' . $sqldb . '.dbo.room WHERE Inc > 0 ORDER BY LName')); $htplace = array_merge($blank, $db->fetchAll('SELECT Inc AS id,LName AS name ,Name AS altname,0 AS selected  FROM ' . $sqlserver . '.' . $sqldb . '.dbo.htplace WHERE Inc > 0 ORDER BY LName')); } catch (Samo_Exception $e) { echo $e->getMessage(); } style(); ?>
    <a href="?page=<?= $ALIAS ?>&LNG=<?= $LNG ?>&action=list&TOWNFROMINC=<?= $TOWNFROMINC ?>&STATEINC=<?= $STATEINC ?>"><?= Get_Message_Lang($LNG, 'adm_the_best_back_to_list'); ?></a>
    <div class="samo_container">
        <div id="step1_container">
            <table class="std panel">
                <tr>
                    <td><?= Get_Message_Lang($LNG, 'adm_townfrom'); ?> </td>
                    <td>
                        <select id="TOWNFROMINC" name="TOWNFROMINC"><?= options($vars['TOWNFROMINC'], true) ?></select>
                    </td>
                    <td><?= Get_Message_Lang($LNG, 'adm_state'); ?> </td>
                    <td colspan=2>
                        <select id="STATEINC" name="STATEINC"><?= options($vars['STATEINC'], true) ?></select>
                    </td>
                </tr>
                <tr>
                    <td><?= Get_Message_Lang($LNG, 'adm_tour'); ?> </td>
                    <td><select id="TOURINC" name="TOURINC"><?= options($vars['TOURINC']) ?></select></td>
                    <td><?= Get_Message_Lang($LNG, 'adm_the_best_nights'); ?> </td>
                    <td colspan=2><?= Get_Message_Lang($LNG, 'adm_the_best_description_nights_from'); ?>
                        <select id="NIGHTS_FROM" name="NIGHTS_FROM">
                            <?php
 foreach (range(1, 70) as $night) { echo '<option value="' . $night . '" ' . (($vars['NIGHTS_FROM'] == $night) ? 'selected' : '') . '>' . $night . '</option>'; } ?>
                        </select>
                        <?= Get_Message_Lang($LNG, 'adm_the_best_description_nights_till'); ?>
                        <select id="NIGHTS_TILL" name="NIGHTS_TILL">
                            <?php
 foreach (range(1, 70) as $night) { echo '<option value="' . $night . '" ' . (($vars['NIGHTS_TILL'] == $night) ? 'selected' : '') . '>' . $night . '</option>'; } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <?php
 if (isset($vars['PROGRAMINC']) && !empty($vars['PROGRAMINC'])) { ?>
                        <td><?= Get_Message_Lang($LNG, 'adm_the_best_program_type'); ?></td>
                        <td><select id="PROGRAMINC" name="PROGRAMINC"><?= options($vars['PROGRAMINC']) ?></select></td>
                        <?php
 } else { ?>
                        <td colspan="2">&nbsp;</td>
                        <?php
 } ?>
                    <td>
                        <label id="subfilter0" <?= (!$vars['PACKET'][Search_Api::PACKET_FULL]['available']) ? 'class="hidden"' : '' ?>><input
                                    type="radio" name="PACKET" value="0"
                                <?= ($vars['PACKET'][Search_Api::PACKET_FULL]['selected']) ? 'checked="checked"' : '' ?>
                                    autocomplete="off"
                                    id="FULLPACKET"><?= Get_Message_Lang($LNG, 'adm_the_best_full_packet'); ?></label>
                    </td>
                    <td>
                        <label id="subfilter1" <?= (!$vars['PACKET'][Search_Api::PACKET_ONLY_FREIGHTS]['available']) ? 'class="hidden"' : '' ?>><input
                                    type="radio" name="PACKET"
                                    value="1" <?= ($vars['PACKET'][Search_Api::PACKET_ONLY_FREIGHTS]['selected']) ? 'checked="checked"' : '' ?>
                                    id="NOHOTELS"
                                    autocomplete="off"><?= Get_Message_Lang($LNG, 'adm_the_best_only_flights'); ?>
                        </label>
                    </td>
                    <td>
                        <label id="subfilter2" <?= (!$vars['PACKET'][Search_Api::PACKET_ONLY_HOTELS]['available']) ? 'class="hidden"' : '' ?>><input
                                    type="radio" name="PACKET"
                                    value="2" <?= ($vars['PACKET'][Search_Api::PACKET_ONLY_HOTELS]['selected']) ? 'checked="checked"' : '' ?>
                                    autocomplete="off"><?= Get_Message_Lang($LNG, 'adm_the_best_only_accommodation'); ?>
                        </label></td>
                </tr>
            </table>
            <input type="submit" id="step2" value="<?= Get_Message_Lang($LNG, 'adm_the_best_next'); ?>">
        </div>
        <div id="step2_container">
            <table class="std panel">
                <tr>
                    <td style="padding-left: 56px;"><?= Get_Message_Lang($LNG, 'adm_the_best_depart_day_from'); ?>
                        <input type="text" class="frm-input date CHECKIN_BEG" id="CHECKIN_BEG"></td>
                    <td><?= Get_Message_Lang($LNG, 'adm_the_best_days_before'); ?> <select class="daysbefore"
                                                                                           id="MINDAYSBEFORE">
                            <option value="-1">&mdash;</option>
                            <?php
 foreach (range(1, 100) as $day) { echo '<option value="' . $day . '">' . $day . '</option>'; } ?></select> <?= Get_Message_Lang($LNG, 'adm_the_best_days'); ?>
                        <?= Get_Message_Lang($LNG, 'adm_the_best_days_not_more'); ?> <select class="daysbefore"
                                                                                             id="MAXDAYSBEFORE">
                            <option value="-1">&mdash;</option>
                            <?php
 foreach (range(1, 100) as $day) { echo '<option value="' . $day . '">' . $day . '</option>'; } ?></select> <?= Get_Message_Lang($LNG, 'adm_the_best_days'); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 56px;">
                        <?= Get_Message_Lang($LNG, 'adm_the_best_depart_day_till'); ?> <input type="text"
                                                                                              class="frm-input date CHECKIN_END"
                                                                                              id="CHECKIN_END">
                    </td>
                    <td>
                        <?php
 $only_hotel = true; foreach ($vars['TOWNFROMINC'] as $item) { if (Samo::TOWNFROMHOTELINC != $item['id']) { $only_hotel = false; break; } } if (!$only_hotel) { ?>
                            <label>
                                <input type="checkbox" id="FRPLACE"
                                       checked="checked"> <?= Get_Message_Lang($LNG, 'adm_the_best_seats_available'); ?>
                            </label>
                            <?php
 } ?>
                    </td>
                </tr>
            </table>
            <input type="submit" id="step3" value="<?= Get_Message_Lang($LNG, 'adm_the_best_next'); ?>">
        </div>
        <div id="step3_container">
            <table class="std panel">
                <tr>
                    <td width="50"><?= Get_Message_Lang($LNG, 'adm_the_best_adults'); ?> </td>
                    <td width="70">
                        <select id="ADULT">
                            <?php
 foreach (range(1, 9) as $man) { echo '<option value="' . $man . '" ' . (($vars['ADULT'] == $man) ? 'selected' : '') . '>' . $man . '</option>'; } ?>
                        </select></td>
                    <td width="50"><?= Get_Message_Lang($LNG, 'adm_the_best_children'); ?> </td>
                    <td width="70">
                        <select id="CHILD">
                            <?php
 foreach (range(0, 3) as $man) { echo '<option value="' . $man . '" ' . (($vars['CHILD'] == $man) ? 'selected' : '') . '>' . $man . '</option>'; } ?>
                        </select>
                    </td>
                    <td width="50"><?= Get_Message_Lang($LNG, 'adm_the_best_room'); ?> </td>
                    <td width="300"><select id="ROOMINC"><?= options($room) ?></select></td>
                    <td width="80"><?= Get_Message_Lang($LNG, 'adm_the_best_htplace'); ?> </td>
                    <td width="460"><select id="HTPLACEINC"><?= options($htplace) ?></select></td>
                </tr>
            </table>
            <input id="step4" type="submit" value="<?= Get_Message_Lang($LNG, 'adm_the_best_next'); ?>">
        </div>
        <div id="step4_container">
            <table class="std panel">
                <tr>
                    <td><label><input type="checkbox" id="TOWNTO_ANY"
                                      checked="checked"> <?= Get_Message_Lang($LNG, 'adm_the_best_any_town'); ?></label>
                    </td>
                    <td><label><input type="checkbox" id="STARS_ANY"
                                      checked="checked"> <?= Get_Message_Lang($LNG, 'adm_the_best_any_cat'); ?></label>
                    </td>
                    <td><label><input type="checkbox" id="VIPTYPE_ANY"
                                      checked="checked"> <?= Get_Message_Lang($LNG, 'adm_the_best_any_type'); ?></label>
                    </td>
                    <td><label><input type="checkbox" id="HOTELS_ANY"
                                      checked="checked"> <?= Get_Message_Lang($LNG, 'adm_the_best_any_hotel'); ?>
                        </label></td>
                    <td><label><input type="checkbox" id="MEALS_ANY"
                                      checked="checked"> <?= Get_Message_Lang($LNG, 'adm_the_best_any_meal'); ?></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="TOWNTO" class="checklistbox"></div>
                    </td>
                    <td>
                        <div id="STARS" class="checklistbox"></div>
                    </td>
                    <td>
                        <div id="VIPTYPE" class="checklistbox"></div>
                    </td>
                    <td>
                        <div id="HOTELS" class="checklistbox"></div>
                    </td>
                    <td>
                        <div id="MEALS" class="checklistbox"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5"><?= Get_Message_Lang($LNG, 'adm_the_best_max_found'); ?> <select
                                id="LIMIT">
                            <?php
 $limits = array_merge(range(1, 10), range(25, 100, 25)); foreach ($limits as $limit) { echo '<option value="' . $limit . '" ' . (($limit == 10) ? 'selected' : '') . '>' . $limit . '</option>'; } ?></select></td>
                </tr>
            </table>
            <input id="create" value="<?= Get_Message_Lang($LNG, 'adm_the_best_create_filter'); ?>" type="submit">
        </div>
    </div>
    <script type="text/javascript">
        <?php
 $format = (defined('DEFAULT_DATE_FORMAT')) ? DEFAULT_DATE_FORMAT : '%d.%m.%Y'; $jsDateFormat = str_replace(array('%d', '%m', '%y', '%Y'), array('dd', 'mm', 'yyyy', 'yyyy'), $format); $jsDateMask = str_replace(array('dd', 'mm', 'yyyy'), array('39', '19', '2099'), $jsDateFormat); ?>
        if (typeof samo === "undefined") {
            samo = {};
        }
        samo.dateFormat = '<?= $jsDateFormat ?>';
        samo.dateMask = '<?= $jsDateMask ?>';
        samo.admin_page = '<?= $ALIAS ?>';
        samo.admin_lng = '<?= $LNG ?>';
    </script>
    <script src="<?= WWWROOT ?>public/js/pack.main.js?_<?= filemtime(_ROOT . 'public/js/pack.main.js') ?>"></script>
    <script
            src="<?= WWWROOT ?>public/js/<?= $LNG ?>.js?_<?= filemtime(_ROOT . 'public/js/' . $LNG . '.js') ?>"></script>
    <script src="<?= WWWROOT ?>admin/files/the_best.js?_<?= filemtime(_ROOT . 'admin/files/the_best.js') ?>"></script>
    <?php
} function options($items, $readonly = false) { $result = array(); foreach ($items as $item) { $selected = (isset($item['selected']) && $item['selected']) ? 'selected="selected"' : ''; if ($readonly && !$selected) { continue; } $result[] = '<option value="' . $item['id'] . '" ' . $selected . '>' . $item['name'] . '</option>'; } return implode('', $result); } function checklistbox($elements) { $result = array(); if ($elements) { foreach ($elements as $option) { $result[] = '<label><input type="checkbox" value="' . $option['id'] . '" />' . htmlspecialchars($option['name'], ENT_QUOTES, 'cp1251') . '</label>'; } } return implode('', $result); } function hotellist($hotels) { $result = array(); foreach ($hotels as $hotel) { $result[] = '<label><input type="checkbox" data-group-star="' . $hotel['starGroupList'] . '" data-viptype="' . $hotel['typeList'] . '" data-town="' . $hotel['townKey'] . '" value="' . $hotel['id'] . '" />' . str_replace("'", '"', $hotel['name']) . '</label>'; } return implode('', $result); } function style() { ?>
    <link rel="stylesheet"
          href="<?= WWWROOT ?>public/css/common.css?_<?= filemtime(_ROOT . 'public/css/common.css') ?>"/>
    <style>
        #STATEINC {
            width: 250px;
        }

        #NIGHTS_FROM, #NIGHTS_TILL, .daysbefore {
            width: 50px !important;
        }

        #step2_container, #step3_container, #step4_container {
            display: none;
        }

        .checklistbox {
            overflow: -moz-scrollbars-vertical !important;
            overflow: auto;
            border-top: 1px solid #c0c0c0;
            border-left: 1px solid #c0c0c0;
            border-right: 1px solid #e4e4e4;
            border-bottom: 1px solid #e4e4e4;
            background-color: #ffffff;
            padding: 4px;
            height: 11em;
            overflow-y: scroll;
            overflow-x: hidden;
            text-align: left;
        }

        .checklistbox label input {
            margin-right: 5px;
        }

        .checklistbox label {
            font-size: 1em;
            white-space: nowrap;
            overflow: hidden;
            display: block;
            padding: 1px;
        }

        .cb_container {
            width: 300px;
            float: left;
            margin-right: 20px;
            text-align: left;
        }

        #STARS, #VIPTYPE {
            width: 120px;
        }

        #HOTELS {
            width: 260px;
        }

        #step1_container table, #step2_container table, #step3_container table, #step4_container table {
            width: 800px;
        }

        #LIMIT {
            width: 50px;
        }

        .samo_container input {
            margin-right: 35px;
        }

        span.warning {
            font-weight: bold;
            color: #ff0000;
        }

        .updown, .save_new_sort {
            margin: 0px !important;
        }

    </style>
    <?php
} 