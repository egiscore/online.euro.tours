<?php
require _ROOT.'admin/includes/tour-selector.php'; if (!isset($SECTION) || !isset($values)) { die('$SECTION and/or $values not set!'); } $showAllTours = !isset($_GET['showAllTours']) ? false : $_GET['showAllTours']; $TOWNFROM = (isset($_GET['TOWNFROMINC']) && ($townfrom = intval($_GET['TOWNFROMINC']))) ? $townfrom : -2147483647; $STATE = (isset($_GET['STATEINC']) && ($state = intval($_GET['STATEINC']))) ? $state : -2147483647; $TOUR = (isset($_GET['TOURINC']) && ($tour = intval($_GET['TOURINC']))) ? $tour : -2147483647; if ('GET' == $_SERVER['REQUEST_METHOD'] && $TOUR > 0 && ($TOWNFROM < 0 || $STATE < 0)) { $sql = sprintf( "EXEC " . OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.sp_executesql N'
        SELECT [inc] AS [TOURINC], [state] AS [STATEINC], [town] AS [TOWNFROMINC] FROM [dbo].[tour] WHERE [inc] = @TOUR AND ([town] > 0 OR [state] > 0)
        ', N'@TOUR int', %d", $TOUR ); if ($res = $db->fetchRow($sql)) { $res['page'] = $ALIAS; $res['LNG'] = $LNG; $res['showAllTours'] = $showAllTours; if ($res['STATEINC'] < 0 && $res['TOWNFROMINC'] < 0) { header('Location: ?' . http_build_query($res), true, 301); exit; } else { $TOWNFROM = $res['TOWNFROMINC']; $STATE = $res['STATEINC']; } } } if (isset($_GET['WHAT'])) { $what = trim($_GET['WHAT']); if (isset($_GET['DELETE']) && $_ACCESS) { $conditions = array( 'inc = ' . intval($_GET['PARAM']), ); $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'DELETE FROM [dbo].[online_tour_config] WHERE " . $db->escape(implode(' AND ', $conditions)) . "' "; $db->query($sql); } $conditions = array(); $conditions[] = '[otc].[Section]  = ' . $db->quote($SECTION); if ($TOUR != -2147483647) { $conditions[] = '[otc].[Tour] = ' . $TOUR; } else { $conditions[] = "([otc].[TownFrom] IS NOT NULL OR [otc].[State] IS NOT NULL)"; } if ($TOWNFROM > 0) { $conditions[] = '([otc].[TownFrom] = ' . $TOWNFROM . ')'; } if ($STATE > 0) { $conditions[] = '[otc].[State] = ' . $STATE; } if ($_GET['WHAT']) { $conditions[] = '[otc].What = ' . $db->quote($what); } $current = null; $callback = function($row) use ($what,$SECTION,$LNG,$values) { $cfg = $values[$what]; if ('note' == $cfg['type']) { $row['Value'] = '<div class="textarea">'.$row['Value'].'</div>'; } if ('checkbox' == $cfg['type']) { if ($row['Value'] == '1') { $row['Value'] = Get_Message_Lang($LNG, 'tour_config_yes'); } if ($row['Value'] == '0') { $row['Value'] = Get_Message_Lang($LNG, 'tour_config_no'); } } if ('select' == $cfg['type'] && isset($cfg['default_value_title']) && $row['Value'] == $cfg['default_value']) { $row['Value'] = $cfg['default_value_title']; } return $row; }; $get_settings = function($conditions) use ($db,$callback) { $conditions[] = '([otc].[user_code] = ' . INTERNET_USER . ' OR [otc].[user_code] IS NULL)'; $sql = 'SELECT
                [tr].[inc] AS [Tour],
                [tr].[lname] as [TourName],
                [t].[inc] as [TownFrom],
                [t].[lname] as [TownName],
                [s].[inc] as [State],
                [s].[lname] as [StateName],
                [otc].[value] as [Value],
                [otc].[inc] as [Inc]
            FROM
                (
                  SELECT
                  Inc,
                  What,
                  Tour,
                  State,
                  TownFrom,
                  Value,
                  ROW_NUMBER() OVER (PARTITION BY [What], [Tour], [State], [TownFrom] ORDER BY [user_code] DESC) AS [Sort]
                  FROM [dbo].[online_tour_config] [otc]
                    WHERE ' . implode(' AND ', $conditions) . '
                ) [otc]

                 LEFT JOIN [dbo].[tour] [tr] ON [otc].[tour] = [tr].[inc]
                 LEFT JOIN [dbo].[town] [t] ON [otc].[townfrom] = [t].[inc]
                 LEFT JOIN [dbo].[state] [s] ON [otc].[state] = [s].[inc]
            WHERE Sort = 1
            ORDER BY t.name, s.name, tr.name
            '; $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N" . $db->quote($sql); $current = null; return $db->fetchAll($sql,$callback); }; $settings = $get_settings($conditions); $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Section' => $SECTION, 'Tour' => $TOUR, 'State' => $STATE, 'TownFrom' => $TOWNFROM, 'What' => $what, 'UserCode' => INTERNET_USER, ] ); if ($info = $db->fetchRow($sql)) { $conditions = array('[otc].[inc] = '.$info['Inc']); $current = $get_settings($conditions); } $selected = null; $sql = sprintf( 'exec '.OFFICE_SQLSERVER.'.'.OFFICEDB.".dbo.sp_executesql N'
        declare @TourName varchar(255), @TownName varchar(255), @StateName varchar(255), @Value varchar(max)
          SET @TownFrom = NULLIF(@TownFrom,-2147483647)
          SET @State = NULLIF(@State,-2147483647)
          SET @Tour = NULLIF(@Tour,-2147483647)
        SELECT @TownName = town.lname FROM town WHERE town.inc = @TownFrom
        SELECT @StateName = state.lname FROM state WHERE state.inc = @State
        SELECT @TourName = tour.lname FROM tour WHERE tour.inc = @Tour
        SELECT @Value = Value FROM [dbo].[online_tour_config] WHERE [inc] = @inc
        SELECT @Tour AS [Tour], @TourName AS [TourName],
                @TownFrom as [TownFrom],
                @TownName as [TownName],
                @State as [State],
                @StateName as [StateName],
                @Value as [Value],
                Null as [Inc]
        ',
        N'@TownFrom int, @State Int, @Tour Int, @Inc int',
         %d, %d, %d, %d", $TOWNFROM, $STATE, $TOUR, $current[0]['Inc'] ); $selected = $db->fetchAll($sql,$callback); ob_start(); $sections = array(); if ($selected) { $sections['tour_config_selected'] = $selected; } if ($current && ($selected[0]['State'] != $current[0]['State'] || $selected[0]['TownFrom'] != $current[0]['TownFrom'] || $selected[0]['Tour'] != $current[0]['Tour']) ) { $sections['tour_config_current'] = $current; } if ($settings) { $sections['tour_config_other'] = $settings; } ?><h1><?=$values[$what]['title']?></h1>
<?php
foreach ($sections as $title => $items) { ?>
        <h4><?= Get_Message_Lang($LNG, $title) ?></h4>
        <table class="txt" id="tour_config">
            <thead>
            <tr>
                <td class="capt border_dark" style="width: 150px;"><?= Get_Message_Lang($LNG, 'townfrom') ?></td>
                <td class="capt border_dark" style="width: 150px;"><?= Get_Message_Lang($LNG, 'state') ?></td>
                <td class="capt border_dark" style="width: 150px;"><?= Get_Message_Lang($LNG, 'tour') ?></td>
                <td class="capt border_dark" style="width: 150px;"><?= Get_Message_Lang($LNG, 'tour_config_value') ?></td>
                <td class="capt border_dark" style="width: 60px;">&nbsp;</td>
                <?php
 if ($_ACCESS) { ?>
                    <td class="capt border_dark" style="width: 60px;">&nbsp;</td>
                <?php
 } ?>
            </tr>
            </thead>
            <tbody>
            <?php
 foreach ($items as $cfg) { ?>
                <tr>
                    <td><?= empty($cfg['TownName']) ? Get_Message_Lang($LNG, 'default') : $cfg['TownName'] ?></td>
                    <td><?= empty($cfg['StateName']) ? Get_Message_Lang($LNG, 'default') : $cfg['StateName'] ?></td>
                    <td><?= empty($cfg['TourName']) ? Get_Message_Lang($LNG, 'default') : $cfg['TourName'] ?></td>
                    <td><?= $cfg['Value'] ?></td>
                    <td>
                        <a href="?page=<?= $ALIAS?>&LNG=<?=$LNG?>&TOWNFROMINC=<?= $cfg['TownFrom'] ?>&STATEINC=<?= $cfg['State'] ?>&TOURINC=<?= $cfg['Tour'] ?>">
                            <?= Get_Message_Lang($LNG, ($_ACCESS) ? 'tour_config_change' : 'tour_config_view')?>
                        </a>
                    </td>
                    <?php
 if ($_ACCESS) { ?>
                    <td>
                        <?php
 if (($cfg['TownFrom'] > 0 || $cfg['State'] > 0 || $cfg['Tour'] > 0) && $cfg['Inc'] > 0) { ?>
                        <a role="drop" href="?page=<?= $ALIAS?>&LNG=<?=$LNG?>&PARAM=<?=$cfg['Inc']?>&TOWNFROMINC=<?=$TOWNFROM?>&STATEINC=<?=$STATE?>&TOURINC=<?=$TOUR?>&WHAT=<?=htmlspecialchars($what)?>&DELETE=1"><?=Get_Message_Lang($LNG, 'tour_config_delete')?></a>
                    <?php
 } ?>
                    </td>
                    <?php
 } ?>
                </tr>
            <?php
 } ?>
            </tbody>
        </table>
    <?php
} ?>
<script>
<?php
 return; } $sqlNameLang = ''; if ($LNG != 'rus') { $sqlNameLang = 'L'; } $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'SELECT distinct tn.Inc, tn.{$sqlNameLang}Name as LName FROM dbo.town tn, tour t where tn.inc = t.town and tn.inc > 0 ORDER BY LName    '"; $townfrom = $db->fetchAll( $sql, function($row) use ($TOWNFROM) { $row['selected'] = ($row['Inc'] == $TOWNFROM) ? ' selected ' : ''; return $row; } ); array_unshift($townfrom,array('Inc' => -2147483647, 'LName' => Get_Message_Lang($LNG, 'default'), 'selected' => ($TOWNFROM == -2147483647) ? ' selected ' : '')); $condition = ($TOWNFROM > 0) ? ' and t.town = '.$TOWNFROM : ''; $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'SELECT distinct s.Inc, s.{$sqlNameLang}Name as LName FROM dbo.state s, tour t where s.inc = t.state and s.inc > 0 " . $condition . " ORDER BY LName    '"; $state = $db->fetchAll( $sql, function($row) use ($STATE) { $row['selected'] = ($row['Inc'] == $STATE) ? ' selected ' : ''; return $row; } ); array_unshift($state,array('Inc' => -2147483647, 'LName' => Get_Message_Lang($LNG, 'default'), 'selected' => ($STATE == -2147483647) ? ' selected ' : '')); $conditions = array(); $conditions[] = 't.inc > 1'; if ($TOWNFROM > 0) { $conditions[] = 't.town = '.$TOWNFROM; } if ($STATE > 0) { $conditions[] = 't.state = '.$STATE; } $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'SELECT distinct t.Inc, t.LName as LName FROM dbo.tour t where " . implode(' AND ',$conditions) . " ORDER BY LName    '"; $tour = $db->fetchAll( $sql, function($row) use ($TOUR) { $row['selected'] = ($row['Inc'] == $TOUR) ? ' selected ' : ''; return $row; } ); array_unshift($tour,array('Inc' => -2147483647, 'LName' => Get_Message_Lang($LNG, 'default'), 'selected' => ($TOUR == -2147483647) ? ' selected ' : '')); $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Section' => $SECTION, 'State' => $STATE, 'TownFrom' => $TOWNFROM, 'Tour' => $TOUR, 'UserCode' => INTERNET_USER, ] ); $settings = $db->fetchAllWithKey($sql,'What'); $self_settings_exists = false; if (count($settings) > 0) { foreach ($settings as $what => $row) { if (isset($values[$what])) { if (!$self_settings_exists && $row['self']) { $self_settings_exists = true; } $values[$what] = array_merge($values[$what],$row); } } } if ($_SERVER['REQUEST_METHOD'] == 'POST') { if (isset($_POST['APPLY_ALL']) || isset($_POST['DEFAULT'])) { $conditions = array("[Section] = '$SECTION'"); if (isset($_POST['APPLY_ALL'])) { if ($TOWNFROM < 0 && $STATE < 0) { $conditions[] = "([TownFrom] IS NOT NULL OR [State] IS NOT NULL)"; } else { if ($STATE > 0) { $conditions[] = '[State] = '.$STATE; } if ($TOWNFROM > 0) { $conditions[] = '[TownFrom] = '.$TOWNFROM; } } } else { if ($TOUR > 0 ) { $conditions[] = '[Tour] = '.$TOUR; } else { if ($TOWNFROM > 0) { $conditions[] = '[TownFrom] = '.$TOWNFROM; } if ($STATE > 0) { $conditions[] = '[State] = '.$STATE; } } } if (isset($_POST[$SECTION]) && is_array($_POST[$SECTION])) { $conditions[] = "[What] IN ('".implode("','",array_intersect(array_keys($values),array_keys($_POST[$SECTION])))."')"; } $sql = 'exec '.OFFICE_SQLSERVER.'.'.OFFICEDB.".dbo.sp_executesql N'
            DELETE FROM [dbo].[online_tour_config] WHERE [Inc] IN (
                    SELECT Inc FROM (
                        SELECT [Inc],
                            ROW_NUMBER() OVER (PARTITION BY [What] ORDER BY [user_code] DESC) AS [Sort]
                            FROM [dbo].[online_tour_config]
                        WHERE ([user_code] = @UserCode OR [user_code] IS NULL) AND ".$db->escape(implode(' AND ',$conditions))."
                        ) [s]
                    WHERE [s].[Sort] = 1
                )
        ', N'@UserCode INT', " . INTERNET_USER; $db->query($sql); } if (isset($_POST['SAVE']) || isset($_POST['APPLY_ALL'])) { if (isset($_POST[$SECTION]) && is_array($_POST[$SECTION])) { foreach ($_POST[$SECTION] as $what => $value) { switch ($values[$what]['type']) { case 'note': $value = (empty($value)) ? null : trim($value); if (isset($_POST['AJAX'])) { $value = __recover_cp($value); } break; case 'select': case 'checkbox': $value = ($val = intval($value)) ? $val : 0; break; default: $value = null; break; } if (!isset($values[$what]['Value']) || $values[$what]['Value'] != $value || isset($_POST['APPLY_ALL'])) { $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Section' => $SECTION, 'State' => $STATE, 'TownFrom' => $TOWNFROM, 'Tour' => $TOUR, 'What' => $what, 'Value' => $value, 'UserCode' => INTERNET_USER, ] ); $row = $db->fetchRow($sql); $values[$what] = array_merge($values[$what],$row); } } $tools = new Samo_Tools(); $tools->clear_cache(); if (!isset($_POST['AJAX'])) { admin_flash(Get_Message_Lang($LNG, 'adm_success_save')); } else { ?>
                samo.jQuery.notify('<?= Get_Message_Lang($LNG, 'adm_success_save') ?>');
                <?php
 } } } if ('POST' == $_SERVER['REQUEST_METHOD']) { if (!isset($_POST['AJAX'])) { header('Location: ' . $_SERVER['REQUEST_URI'] . '?page=' . $ALIAS . '&LNG=' . $LNG, true, 301); } elseif (DEBUG) { echo Samo_Registry::get('response')->output(); } exit; } } ?>
<?=style_css()?>
<style>
    td.not-self input, td.not-self select { opacity: 0.5; filter: alpha(opacity=50);}
    td.label { width: 140px; text-align: right;}
    td.checkbox {text-align: left; padding-left: 30px;}
    thead td.capt {padding: 2px;}
    tbody td.capt1 {vertical-align: top; width: 220px;}
    a {text-decoration: underline;}
</style>
<?=admin_flash()?>
<div class="samo_container">
<table class="config_filter_table">
    <tr>
        <td class="txt config_filter_what">
            <?=Get_Message_Lang($LNG, 'townfrom')?>
        </td>
        <td class="txt config_filter_value">
            <select name="TOWNFROMINC" onchange="location.href='?page=<?=$ALIAS?>&LNG=<?=$LNG?>&showAllTours='+showAllTours+'&TOWNFROMINC=' + this.value">
                <?php
 foreach ($townfrom as $item) { echo '<option value="'.$item['Inc'].'" '.$item['selected'].'>'.$item['LName'].'</option>'; } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="txt config_filter_what">
            <?=Get_Message_Lang($LNG, 'state')?>
        </td>
        <td class="txt config_filter_value">
            <select name="STATEINC" onchange="location.href='?page=<?=$ALIAS?>&LNG=<?=$LNG?>&TOWNFROMINC=<?=$TOWNFROM?>&showAllTours=' + showAllTours + '&STATEINC=' + this.value">
                <?php
 foreach ($state as $item) { echo '<option value="'.$item['Inc'].'" '.$item['selected'].'>'.$item['LName'].'</option>'; } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td style="vertical-align:top" class="txt config_filter_what">
            <?=Get_Message_Lang($LNG, 'tour')?>
        </td>
        <td class="txt config_filter_value">
        <?php
 $selector = new TourSelector('TOURINC','TOURINC'); $selector->lang = $LNG; $selector->emptyVal = [ 'value' => -2147483647, 'text' => Get_Message_Lang($LNG,'default') ]; $selector->condition = $conditions; $selector->selected = $TOUR; $selector->render(); ?>
    <label for="showAllTours"><?php echo Get_Message_Lang($LNG, 'BRON_SHOW_ALL_TOURS'); ?></label>
    <input type="checkbox" id="showAllTours" value="1" <?php
 if ($showAllTours) { echo 'checked="checked"'; } ?>>
        </td>
    </tr>
</table>
<form method="POST" action="?page=<?=$ALIAS?>&LNG=<?=$LNG?>&TOWNFROMINC=<?=$TOWNFROM?>&STATEINC=<?=$STATE?>&TOURINC=<?=$TOUR?>" id="settings-form">
    <table class="txt" id="tour_config">
        <thead>
        <tr>
            <td class="capt border_dark"><?=Get_Message_Lang($LNG, 'tour_config_what')?></td>
            <td class="capt border_dark" style="width: 300px"><?=Get_Message_Lang($LNG, 'tour_config_value')?></td>
            <td class="capt border_dark" style="width: 120px"><?=Get_Message_Lang($LNG, 'tour_config_other_value')?></td>
        </tr>
        </thead>
        <?php
 foreach ($values as $what => $data) { if (!isset($data['self'])) { $data['self'] = true; $data['Value'] = $data['other'] = false; } ?>
            <tr>
                <td class="capt1 border">
                    <?php
 if ($TOUR > 0 && isset($data['link']) && $data['link']) { ?>
                        <a href="<?=$data['link']?>" title="<?=isset($data['link_title']) ? $data['link_title'] : $data['title'] ?>"><?=$data['title']?></a>
                    <?php
 } else { ?>
                        <?=$data['title']?>
                    <?php
 } ?>
                </td>
                <?php
 if ('checkbox' == $data['type']) { ?>
                    <td class="border checkbox <?=!$data['self'] ? 'not-self' : ''?>"><input type="hidden" name="<?=$SECTION?>[<?=$what?>]" value="0"><input type="checkbox" name="<?=$SECTION?>[<?=$what?>]" <?= ($data['Value'] > 0) ? 'checked' : ''?> value="<?=($data['Value'] > 0) ? $data['Value'] : 1?>"></td>
                <?php
 } elseif ('select' == $data['type']) { ?>
                    <td class="border checkbox <?=!$data['self'] ? 'not-self' : ''?>"><input type="hidden" name="<?=$SECTION?>[<?=$what?>]" value="-1">
                        <select name="<?=$SECTION?>[<?=$what?>]">
                            <?php
 if (isset($data['default_value'])) { ?>
                            <option value="<?=$data['default_value']?>"><?=$data['default_value_title']?></option>
                            <?php
 } $possible_values = (is_callable($data['possible_values'])) ? call_user_func($data['possible_values']) : $data['possible_values']; foreach ($possible_values as $variant) { ?>
                                <option value="<?=$variant?>" <?=($variant == $data['Value']) ? ' selected' : ''?> ><?=$variant?></option>
                            <?php
 } ?>
                        </select>
                    </td>
                <?php
 } elseif ('note' == $data['type']) { ?>
                    <td class="border">
                        <?php
 require_once $folder_site.'/vendor/fckeditor/fckeditor.php'; $hEdit = new FCKeditor(sprintf("%s[%s]",$SECTION,$what)); $hEdit->Width = '500'; $hEdit->Height = '240'; $hEdit->ToolbarSet = 'Public'; $hEdit->Value = (isset($data['Value'])) ? $data['Value'] : ''; $hEdit->Create(); ?>

                    </td>
                <?php
 } else { ?>  <td>
                <?php
 echo var_export($data, true); ?>
                    </td>
                <?php
 } ?>
                    <td class="border">
                        <?php
 if ($data['other'] || !$data['self']) { ?>
                            <a role="modal" href="?page=<?= $ALIAS?>&LNG=<?=$LNG?>&PARAM=<?=$data['Inc']?>&TOWNFROMINC=<?=$TOWNFROM?>&STATEINC=<?=$STATE?>&TOURINC=<?=$TOUR?>&WHAT=<?=$what?>"><?=Get_Message_Lang($LNG, 'tour_config_details')?></A>
                        <?php
 } ?>
                        &nbsp;
                    </td>
            </tr>
        <?php
 } ?>

    </table>
    <?php
 if (isset($ADDITIONAL)) { echo $ADDITIONAL; $recOnPageText = Get_Message_Lang($LNG, 'adm_config_rec_on_page_default'); echo "$recOnPageText" . ":&nbsp;"; $value = isset($config['REC_ON_PAGE']) ? $config['REC_ON_PAGE'] : -1; ?>
        <select name="REC_ON_PAGE" class="element">
        <?php
 for ($i = 10; $i <= 100; $i += 10) { ?>
        <option value="<?= $i ?>" <?= ($i == $value) ? "selected" : '' ?>><?= $i ?></option>
        <?php
 } ?>
        </select>
        <br><?php
 } if ($_ACCESS) { ?>
    <br clear="all">
    <input type="submit" value="<?= Get_Message_Lang($LNG, 'save')?>" name="SAVE" class="button">
    <?php
 if ($TOUR < 0 && false) { ?>
        <input type="submit" value="<?= Get_Message_Lang($LNG, 'tour_config_set_for_all')?>" name="APPLY_ALL" class="button" onclick="return confirm('<?=Get_Message_Lang($LNG,'tour_config_reset_confirmation')?>')">
    <?php
 } ?>
    <?php
 if ($self_settings_exists && ($TOUR > 0 || $TOWNFROM > 0 || $STATE > 0)) { ?>
        <input type="submit" value="<?= Get_Message_Lang($LNG, 'tour_config_reset')?>" name="DEFAULT" class="button" onclick="return confirm('<?=Get_Message_Lang($LNG,'tour_config_reset_confirmation')?>')">
    <?php
 } ?>
    <?php
 } else { ?>
        <div class="warning"><?= Get_Message_Lang($LNG, 'adm_only_view')?></div>
    <?php
 } ?>
</form>
<script type="text/javascript" src="<?= $http_site ?>public/js/pack.main.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/selectr/latest/selectr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/selectr/latest/selectr.min.css">
<script type="text/javascript">
    (function($) {
        $(document).ready(function(){
            var $interval = setInterval(function(){
                if (typeof FCKeditorAPI != 'undefined') {
                   for ( var name in FCKeditorAPI.Instances) {
                       var oEditor = FCKeditorAPI.Instances[ name ] ;
                       var $oEditor = $(oEditor.LinkedField);
                       if (!$oEditor.data('defaultValue')) {
                           $oEditor.data('defaultValue',$oEditor.val());
                       }
                       oEditor.UpdateLinkedField();
                       if (oEditor.LinkedField.value != $oEditor.data('defaultValue') && !$oEditor.data('hasChanged')) {
                           $oEditor.data('hasChanged',1);
                           $(oEditor.LinkedField).triggerHandler('change');
                       }
                   }
                }
               }
            ,500);
            $("#tour_config input, #tour_config select").bind('change',function() {
                $(this).parent().removeClass('not-self');
                <?php
 if ($TOUR < 0 ) { ?>
                    var $td = $(this).parents('td:first'), $span = $td.find('span.link');
                    if ($span.length > 0) {
                        $span.remove();
                    } else {
                        var $append = '<span class="link apply-all"><?= Get_Message_Lang($LNG, 'tour_config_set_for_all')?></span>';
                        $td.append($append);
                    }
                <?php
 } ?>
            });
            $('#tour_config').delegate('span.link','click',function() {
                    if (confirm('<?=Get_Message_Lang($LNG,'tour_config_reset_confirmation')?>')) {
                        var $params = {},$link = $(this);
                        var $checkbox = $(this).parent().find(':checkbox');
                        if ($checkbox.length > 0) {
                            $params[$checkbox.attr('name')] = $checkbox.is(':checked') ? '1' : '0';
                        }
                        var $select = $(this).parent().find('select');
                        if ($select.length > 0) {
                            $params[$select.attr('name')] = $select.val();
                        }
                        var $hidden = $(this).parent().find('[name*="[note]"]');
                        if ($hidden.length > 0) {
                            $params[$hidden.attr('name')] = $hidden.val();
                        }
                        $params['APPLY_ALL'] = 'Y';
                        $params['AJAX'] = 'Y';
                        $params['page'] = '<?= $ALIAS ?>';
                        $params['LNG'] = '<?= $LNG ?>';
                        $.post($('#settings-form').attr('action'), $.param($params), function () {
                            $link.remove();
                            if (typeof FCKeditorAPI != 'undefined') {
                                for (var name in FCKeditorAPI.Instances) {
                                    var oEditor = FCKeditorAPI.Instances[ name ];
                                    var $oEditor = $(oEditor.LinkedField);
                                    if ($oEditor.data('hasChanged')) {
                                        $oEditor.removeData();
                                    }
                                }
                            }
                        }, 'script');
                    }
            });
            $('a[role="modal"]').bind('click',function (e) {
                e.preventDefault();
                e.stopPropagation();
                if ($('#modalHiddenContent').length == 0) {
                    $('body').append('<div id="modalHiddenContent"></div>');
                }
                $('#modalHiddenContent').html("<p style='margin:auto'>Loading...</p>").load(this.href + '&AJAX=1',function() {
                    $.modal(this.innerHTML,{title: '<?= Get_Message_Lang($LNG,'tour_config_details')?>',width: 800, height: 800});
                });
            });
            $('body').delegate('a[role="drop"]','click',function (e) {
                e.preventDefault();
                e.stopPropagation();
                $('#basicModalContent').load(this.href + '&AJAX=1');
            });
        });
    })(samo.jQuery);
    var selectorTour = document.getElementById('TOURINC');
    var toggleTourListControl = document.getElementById('showAllTours');
    toggleTourListControl.setAttribute('onclick', 'toggleTourList(this)');
    var showAllTours = 0;
    if (toggleTourListControl.checked) {
        showAllTours = 1
    }
    var toggleTourList = function (control) {
        if (control.checked) {
            window.location.href = '?page=<?=$ALIAS?>&LNG=<?=$LNG?>&TOWNFROMINC=<?=$TOWNFROM?>&STATEINC=<?=$STATE?>&TOURINC=' + selector.getValue() + '&showAllTours=1';
        } else {
            window.location.href = '?page=<?=$ALIAS?>&LNG=<?=$LNG?>&TOWNFROMINC=<?=$TOWNFROM?>&STATEINC=<?=$STATE?>&showAllTours=0';
        }
    }
    var selector = new Selectr(selectorTour, {
        placeholder: '<?php echo Get_Message_Lang($LNG,'default');?>'
    });
    selector.on('selectr.select', function (option) {
        var val = option.value;
        window.location.href = '?page=<?=$ALIAS?>&LNG=<?=$LNG?>&TOWNFROMINC=<?=$TOWNFROM?>&STATEINC=<?=$STATE?>&TOURINC=' + val + '&showAllTours=' + showAllTours
    });
</script>
</div>