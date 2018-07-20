<?php
 $TOURTYPE = (isset($_GET['TOURTYPE']) && ($tourtype = intval($_GET['TOURTYPE']))) ? $tourtype : -2147483647; $TOWNFROM = ($TOURTYPE < 0 && isset($_GET['TOWNFROMINC']) && ($townfrom = intval($_GET['TOWNFROMINC']))) ? $townfrom : -2147483647; $STATE = ($TOURTYPE < 0 && isset($_GET['STATEINC']) && ($state = intval($_GET['STATEINC']))) ? $state : -2147483647; $TOUR = ($TOURTYPE < 0 && isset($_GET['TOURINC']) && ($tour = intval($_GET['TOURINC']))) ? $tour : -2147483647; require _ROOT . 'admin/includes/tour-selector.php'; $showAllTours = !isset($_GET['showAllTours']) ? false : $_GET['showAllTours']; if ('POST' == $_SERVER['REQUEST_METHOD']) { if (isset($_POST['DEFAULT']) && ($TOWNFROM > 0 || $STATE > 0 || $TOUR > 0 || $TOURTYPE > 0)) { if ($TOUR > 0) { $conditions[] = '[Tour] = ' . $TOUR; } else { if ($TOURTYPE > 0) { $conditions[] = '[TourType] = ' . $TOURTYPE; } else { if ($TOWNFROM > 0) { $conditions[] = '[TownFrom] = ' . $TOWNFROM; } if ($STATE > 0) { $conditions[] = '[State] = ' . $STATE; } } } $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'
            DELETE FROM [dbo].[online_people_settings] WHERE [Inc] IN (
                    SELECT Inc FROM (
                        SELECT [Inc],
                            ROW_NUMBER() OVER (PARTITION BY [Field] ORDER BY [user_code] DESC) AS [Sort]
                            FROM [dbo].[online_people_settings]
                        WHERE ([user_code] = @UserCode OR [user_code] IS NULL) AND " . $db->escape(implode(' AND ', $conditions)) . "
                        ) [s]
                    WHERE [s].[Sort] = 1
                )
        ', N'@UserCode INT', " . INTERNET_USER; $db->query($sql); } if (isset($_POST['SAVE']) || isset($_POST['APPLY_ALL'])) { foreach (['AUTOFILL_HUMAN', 'SYNC_NAME_LNAME'] as $name) { if (isset($_POST[$name])) { $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Section' => 'people', 'What' => $name, 'Value' => intval($_POST[$name]), 'UserCode' => INTERNET_USER, ] ); $db->query($sql); } } $conditions = []; if ($TOWNFROM > 0) { $conditions[] = '[TownFrom] = ' . $TOWNFROM; } if ($STATE > 0) { $conditions[] = '[State] = ' . $STATE; } foreach ($_POST['field'] as $field => $data) { $params = [ 'TourType' => $TOURTYPE, 'Tour' => $TOUR, 'State' => $STATE, 'TownFrom' => $TOWNFROM, 'UserCode' => INTERNET_USER, 'LangId' => Samo_Request::langid(), 'Author' => $_SESSION['samo_admin']['User'], 'Field' => $field, 'ApplyToAll' => isset($_POST['APPLY_ALL']) ? 1 : 0, ]; foreach ($data as $prop => $value) { if ('EditRestrictions' == $prop) { if (is_array($value)) { $bin = ''; foreach ($value as $bit => $value) { $bin .= strval($value); } $value = bindec(strrev($bin)); } } $params[$prop] = $value; } $sql = $db->formatExec('<OFFICEDB>.dbo.up_WEB_3_ADMIN_people_settings', $params); $inc = $db->fetchOne($sql); } if (!isset($_POST['AJAX'])) { admin_flash(Get_Message_Lang($LNG, 'adm_success_save')); } else { ?>
            samo.jQuery.notify('<?= Get_Message_Lang($LNG, 'adm_success_save') ?>');
            <?php
 if (DEBUG) { echo Samo_Registry::get('response')->output(); } exit; } } } if ('GET' == $_SERVER['REQUEST_METHOD'] && $TOUR > 0 && ($TOWNFROM < 0 || $STATE < 0)) { $sql = sprintf( "EXEC " . OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.sp_executesql N'
        SELECT [inc] AS [TOURINC], [state] AS [STATEINC], [town] AS [TOWNFROMINC] FROM [dbo].[tour] WHERE [inc] = @TOUR AND ([town] > 0 OR [state] > 0)
        ', N'@TOUR int', %d", $TOUR ); if ($res = $db->fetchRow($sql)) { $res['page'] = $ALIAS; $res['LNG'] = $LNG; $res['showAllTours'] = $showAllTours; if ($res['STATEINC'] < 0 && $res['TOWNFROMINC'] < 0) { header('Location: ?' . http_build_query($res), true, 301); exit; } else { $TOWNFROM = $res['TOWNFROMINC']; $STATE = $res['STATEINC']; } } } $titleField = $LNG == 'rus' ? 'Name' : 'LName'; $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'SELECT distinct tt.Inc, tt." . $titleField . " as title FROM dbo.tourtype tt where tt.inc > 0 ORDER BY title '"; $tourtypes = $db->fetchAll( $sql, function ($row) use ($TOURTYPE) { $row['selected'] = ($row['Inc'] == $TOURTYPE) ? ' selected ' : ''; return $row; } ); $tourtypes = $tourtypes ? $tourtypes : []; array_unshift($tourtypes, array('Inc' => -2147483647, 'title' => Get_Message_Lang($LNG, 'default'), 'selected' => ($TOURTYPE == -2147483647) ? ' selected ' : '')); $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'SELECT distinct tn.Inc, tn." . $titleField . " as title FROM dbo.town tn, tour t where tn.inc = t.town and tn.inc > 0 ORDER BY title '"; $townfrom = $db->fetchAll( $sql, function ($row) use ($TOWNFROM) { $row['selected'] = ($row['Inc'] == $TOWNFROM) ? ' selected ' : ''; return $row; } ); $townfrom = $townfrom ? $townfrom : []; array_unshift($townfrom, array('Inc' => -2147483647, 'title' => Get_Message_Lang($LNG, 'default'), 'selected' => ($TOWNFROM == -2147483647) ? ' selected ' : '')); $condition = ($TOWNFROM > 0) ? ' and t.town = ' . $TOWNFROM : ''; $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'SELECT distinct s.Inc, s." . $titleField . " as title FROM dbo.state s, tour t where s.inc = t.state and s.inc > 0 " . $condition . " ORDER BY title '"; $state = $db->fetchAll( $sql, function ($row) use ($STATE) { $row['selected'] = ($row['Inc'] == $STATE) ? ' selected ' : ''; return $row; } ); $state = $state ? $state : []; array_unshift($state, array('Inc' => -2147483647, 'title' => Get_Message_Lang($LNG, 'default'), 'selected' => ($STATE == -2147483647) ? ' selected ' : '')); $conditions = array(); $conditions[] = 't.inc > 1'; if ($TOURTYPE > 0) { $conditions[] = 't.tourtype = ' . $TOURTYPE; } if ($TOWNFROM > 0) { $conditions[] = 't.town = ' . $TOWNFROM; } if ($STATE > 0) { $conditions[] = 't.state = ' . $STATE; } $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'SELECT distinct t.Inc, t." . $titleField . " as title FROM dbo.tour t where " . implode(' AND ', $conditions) . " ORDER BY title '"; $tour = $db->fetchAll( $sql, function ($row) use ($TOUR) { $row['selected'] = ($row['Inc'] == $TOUR) ? ' selected ' : ''; return $row; } ); $tour = $tour ? $tour : []; array_unshift($tour, array('Inc' => -2147483647, 'title' => Get_Message_Lang($LNG, 'default'), 'selected' => ($TOUR == -2147483647) ? ' selected ' : '')); if ($TOUR > 0) { $sql = sprintf( "EXEC " . OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.sp_executesql N'
         DECLARE @gds_use TINYINT = 0   
            IF EXISTS (SELECT * FROM [sysobjects] WHERE [name] = ''gds_use'' AND [type] = ''U'')
                AND EXISTS (SELECT * FROM [dbo].[gds_use] WHERE [tour] = @Tour)
                    SET @gds_use = 1
            SELECT @gds_use AS [GdsUse]    
        ', N'@TOUR int', %d", $TOUR ); $gds_use = $db->fetchOne($sql); } else { $gds_use = false; } $sql = $db->formatExec( '<OFFICEDB>.dbo.up_WEB_3_ADMIN_people_settings', [ 'TourType' => $TOURTYPE, 'Tour' => $TOUR, 'State' => $STATE, 'TownFrom' => $TOWNFROM, 'UserCode' => INTERNET_USER, 'LangId' => Samo_Request::langid(), 'Author' => $_SESSION['samo_admin']['User'], ] ); $fields = array(); if (false !== ($res = $db->fetchAll($sql))) { foreach ($res as $row) { $fields[] = $row; } } $readConfig = function ($what, $use_geo = false) use ($db, $TOURTYPE, $TOUR, $STATE, $TOWNFROM) { $sql = $db->formatExec( OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.[up_WEB_3_ADMIN_tour_config]", [ 'Section' => 'people', 'What' => $what, 'UserCode' => INTERNET_USER, 'Tour' => $use_geo ? $TOUR : null, 'State' => $use_geo ? $STATE : null, 'TownFrom' => $use_geo ? $TOWNFROM : null, ] ); if ($value = $db->fetchRow($sql)) { $value = $value['Value']; } return $value; }; $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'select Inc as StateInc, Name as StateName from State  where inc > 0 order by StateName    '"; $states = $db->fetchAll($sql); get_help_button('onlinest:sistema_upravlenija:people'); echo style_css(); echo admin_flash(); ?>
<style>
    #tourist_settings td.title {
        width: 170px;
    }

    #tourist_settings tr.not-self input, #tourist_settings tr.not-self select {
        opacity: 0.5;
        filter: alpha(opacity=50);
    }

    #tourist_settings thead td.capt {
        padding: 2px;
    }

    a {
        text-decoration: underline;
    }

    #tourist_settings tr.changed {
        background-color: infobackground;
        color: darkred;
    }

    #tourist_settings tr.changed input, #tourist_settings tr.changed select {
        opacity: 1;
        filter: alpha(opacity=100);
    }

    #tourist_settings tr.changed span.link {
        white-space: nowrap;
        display: block;
    }

    .global_settings {
        width: 800px;
    }

    .global_settings.max-name-diff {
        margin-top: 20px;
    }

    td.select {
        width: 15%;
    }

    hr {
        margin: 20px 0;
    }
</style>
<div class="samo_container">
    <form method="POST" id="people-settings-form">
        <input type="hidden" name="LNG" value="<?= $LNG ?>">
        <input type="hidden" name="page" value="<?= $ALIAS ?>">
        <table class="config_table global_settings">
            <tr>
                <td class="capt border_dark config_what"><?= Get_Message_Lang($LNG, 'adm_people_sync_name_lname') ?></td>
                <td class="txt border config_value">
                    <select name="SYNC_NAME_LNAME" class="element">
                        <?php
 $sync_name_lname = $readConfig('SYNC_NAME_LNAME'); ?>
                        <option value="0" <?= (0 == $sync_name_lname) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_no') ?></option>
                        <option value="1" <?= (1 == $sync_name_lname) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_yes') ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_people_autofill_human') ?></td>
                <td class="txt border">
                    <select name="AUTOFILL_HUMAN" class="element">
                        <?php
 $autofill_human = $readConfig('AUTOFILL_HUMAN'); ?>
                        <option value="0" <?= (0 == $autofill_human) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_no') ?></option>
                        <option value="1" <?= (1 == $autofill_human) ? 'selected' : '' ?>><?= Get_Message_Lang($LNG, 'adm_config_yes') ?></option>
                    </select>
                </td>
            </tr>

        </table>

        <hr>
        <table class="config_filter_table">
            <tr>
                <td class="txt config_filter_what">
                    <?= Get_Site_Message_Lang($LNG, 'TOUR_SEARCH_TOURTYPE') ?>
                </td>
                <td class="txt config_filter_value">
                    <select name="TOURTYPE"
                            onchange="location.href='?page=<?= $ALIAS ?>&LNG=<?= $LNG ?>&showAllTours=<?= $showAllTours ?>&TOURTYPE=' + this.value">
                        <?php
 foreach ($tourtypes as $item) { echo '<option value="' . $item['Inc'] . '" ' . $item['selected'] . '>' . $item['title'] . '</option>'; } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="txt config_filter_what">
                    <?= Get_Site_Message_Lang($LNG, 'TOUR_SEARCH_TOWNFROM') ?>
                </td>
                <td class="txt config_filter_value">
                    <select name="TOWNFROMINC"
                            onchange="location.href='?page=<?= $ALIAS ?>&LNG=<?= $LNG ?>&showAllTours=<?= $showAllTours ?>&TOWNFROMINC=' + this.value">
                        <?php
 foreach ($townfrom as $item) { echo '<option value="' . $item['Inc'] . '" ' . $item['selected'] . '>' . $item['title'] . '</option>'; } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="txt config_filter_what">
                    <?= Get_Site_Message_Lang($LNG, 'TOUR_SEARCH_STATE') ?>
                </td>
                <td class="txt config_filter_value">
                    <select name="STATEINC"
                            onchange="location.href='?page=<?= $ALIAS ?>&LNG=<?= $LNG ?>&TOWNFROMINC=<?= $TOWNFROM ?>&showAllTours=<?= $showAllTours ?>&STATEINC=' + this.value">
                        <?php
 foreach ($state as $item) { echo '<option value="' . $item['Inc'] . '" ' . $item['selected'] . '>' . $item['title'] . '</option>'; } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="vertical-align:top" class="txt config_filter_what">
                    <?= Get_Site_Message_Lang($LNG, 'TOUR_SEARCH_TOURNAME') ?>
                </td>
                <td class="txt config_filter_value">
                    <?php
 $selector = new TourSelector('TOURINC', 'TOURINC'); $selector->lang = $LNG; $selector->emptyVal = [ 'value' => -2147483647, 'text' => Get_Message_Lang($LNG, 'default') ]; $selector->condition = $conditions; $selector->selected = $TOUR; $selector->render(); ?>
                    <label for="showAllTours"><?php echo Get_Message_Lang($LNG, 'BRON_SHOW_ALL_TOURS'); ?></label>
                    <input type="checkbox" id="showAllTours" value="1" <?php
 if ($showAllTours) { echo 'checked="checked"'; } ?>>
                </td>
            </tr>
        </table>

        <table cellpadding=1 cellspacing=1 id="tourist_settings">
            <thead>
            <tr>
                <td class="capt border_dark title"<?= isset($routes['edit_tourist']) ? ' rowspan="2"' : '' ?>><?= Get_Message_Lang($LNG, 'adm_people_field') ?></td>
                <td class="capt border_dark"<?= isset($routes['edit_tourist']) ? ' rowspan="2"' : '' ?>><?= Get_Message_Lang($LNG, 'adm_people_field_visible') ?></td>
                <td class="capt border_dark"<?= isset($routes['edit_tourist']) ? ' rowspan="2"' : '' ?>><?= Get_Message_Lang($LNG, 'adm_people_field_required') ?></td>
                <?php
 if (isset($routes['edit_tourist']) && !$gds_use) { ?>
                    <th colspan="6"
                        class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_people_edit_caption') ?></th>
                    <?php
 } ?>
            </tr>
            <?php
 if (isset($routes['edit_tourist']) && !$gds_use) { ?>
                <tr>
                    <td class="capt border_dark select"><?= Get_Message_Lang($LNG, 'adm_people_field_editable') ?></td>
                    <td class="capt border_dark select"><?= Get_Message_Lang($LNG, 'adm_people_field_editable_empty') ?></td>
                    <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_people_field_editable_check_unread') ?></td>
                    <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_people_field_editable_spo_rqde') ?></td>
                    <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_people_field_editable_locked') ?></td>
                    <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_people_field_editable_printdoc') ?></td>
                </tr>
                <?php
 } ?>
            </thead>
            <tbody>
            <?php
 $self_settings_exists = false; $props = array('Visible', 'Required'); if (isset($routes['edit_tourist']) && !$gds_use) { $props[] = 'Editable'; $props[] = 'EditableEmpty'; $props[] = 'EditCheckUnread'; } foreach ($fields as $field) { if ($field['Name'] == 'HUMAN' && $autofill_human) { continue; } if (!$self_settings_exists && $field['self']) { $self_settings_exists = true; } echo '<tr' . ($field['self'] ? '' : ' class="not-self"') . '><td class="txt border">' . $field['Title'] . '</td>'; foreach ($props as $prop) { if (!in_array($prop, ['Editable', 'EditableEmpty'])) { echo '<td class="txt border">
                                    <input type="hidden" name="field[' . $field['FieldInc'] . '][' . $prop . ']" value="' . ($field['Immutable'] && $field[$prop] ? '1' : '0' ) . ' ">
                                    <input type="checkbox" id="' . $field['Name'] . '_' . $prop . '" name="field[' . $field['FieldInc'] . '][' . $prop . ']" value="' . ($field['Immutable'] ? $field[$prop] : '1' ) . '" ' . (($field[$prop]) ? 'checked' : '') . (($field['Immutable']) ? ' disabled' : '') . '></td>'; } else { ?>
                        <td class="txt border">
                            <select name="field[<?= $field['FieldInc'] ?>][<?= $prop ?>]">
                                <option value="1000" <?= 1000 == $field[$prop] ? ' selected="selected"' : '' ?>><?= Get_Message_Lang($LNG, 'adm_people_always_disable') ?></option>
                                <option value="0" <?= 0 == $field[$prop] ? ' selected="selected"' : '' ?>><?= Get_Message_Lang($LNG, 'adm_people_always_enable') ?></option>
                                <?php
 $possible_values = range(1, 29); foreach ($possible_values as $variant) { ?>
                                    <option value="<?= $variant ?>" <?= ($variant == $field[$prop]) ? ' selected' : '' ?> ><?= sprintf(Get_Message_Lang($LNG, 'adm_people_disable_days_before'), $variant) ?></option>
                                    <?php
 } ?>
                            </select>
                        </td>
                        <?php
 } } if (isset($routes['edit_tourist']) && !$gds_use) { $val = intval($field['EditRestrictions']); foreach ([0, 1, 2] as $bit) { $old_val = (($val & (1 << $bit)) != 0) ? 1 : 0; echo '<td class="txt border">
                                    <input type="hidden" name="field[' . $field['FieldInc'] . '][EditRestrictions][' . $bit . ']" value="0">
                                    <input type="checkbox" name="field[' . $field['FieldInc'] . '][EditRestrictions][' . $bit . ']" value="1" ' . (($old_val) ? 'checked' : '') . '></td>'; } } echo '</tr>'; } ?>
            </tbody>
        </table>
        <?php
 if ($_ACCESS) { ?>


            <br clear="all">
            <input type="submit" value="<?= Get_Message_Lang($LNG, 'save') ?>" name="SAVE" class="button">
            <?php
 if ($TOUR < 0 && $TOURTYPE < 0) { ?>
                <input type="submit" value="<?= Get_Message_Lang($LNG, 'tour_config_set_for_all') ?>" name="APPLY_ALL"
                       class="button"
                       onclick="return confirm('<?= Get_Message_Lang($LNG, 'tour_config_reset_confirmation') ?>')">
                <?php
 } ?>
            <?php
 if ($self_settings_exists && ($TOUR > 0 || $TOWNFROM > 0 || $STATE > 0)) { ?>
                <input type="submit" value="<?= Get_Message_Lang($LNG, 'tour_config_reset') ?>" name="DEFAULT"
                       class="button"
                       onclick="return confirm('<?= Get_Message_Lang($LNG, 'tour_config_reset_confirmation') ?>')">
                <?php
 } ?>
            <?php
 } else { ?>
            <div class="warning"><?= Get_Message_Lang($LNG, 'adm_only_view') ?></div>
            <?php
 } ?>
    </form>
</div>
<script type="text/javascript" src="<?= $http_site ?>public/js/pack.main.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/selectr/latest/selectr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/selectr/latest/selectr.min.css">
<script type="text/javascript">
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
        placeholder: '<?php echo Get_Message_Lang($LNG, 'default');?>'
    });
    selector.on('selectr.select', function (option) {
        var val = option.value;
        window.location.href = '?page=<?=$ALIAS?>&LNG=<?=$LNG?>&TOWNFROMINC=<?=$TOWNFROM?>&STATEINC=<?=$STATE?>&TOURINC=' + val + '&showAllTours=' + showAllTours
    });
    (function ($) {
        $(document).ready(function () {
            $("#tourist_settings input, #tourist_settings select").bind('change', function () {
                var $tr = $(this).parents('tr:first'), $self = $(this);
                var changed = 0;
                if ($self.is('select[name*="Editable"]')) {
                    $tr.find('select[name*="EditableEmpty"]').val($self.val());
                }

                $tr.find('input').each(function () {
                    if (this.checked != this.defaultChecked) {
                        changed++;
                    }
                }).end().find('select').each(function () {
                    var $self = $(this), $selected = $self.find('option').filter(function () {
                        return this.defaultSelected;
                    });
                    if ($self.val() != $selected.val()) {
                        changed++;
                    }

                });
                var $td = $tr.find('td:first'), $span = $td.find('span.link');
                if (changed) {
                    $tr.addClass('changed');
                    var $td = $tr.find('td:first'), $span = $td.find('span.link');
                    if ($span.length == 0) {
                        var $append = '<span class="link apply-all"><?= Get_Message_Lang($LNG, ($TOUR > 0 || $TOURTYPE > 0) ? 'save' : 'tour_config_set_for_all') ?></span>';
                        $td.append($append);
                    }
                } else {
                    $tr.removeClass('changed');
                    if ($span.length > 0) {
                        $span.remove();
                    }
                }
            });
            $('#tourist_settings').delegate('span.link', 'click', function () {
                if (confirm('<?=Get_Message_Lang($LNG, 'tour_config_reset_confirmation')?>')) {
                    var $params = {}, $link = $(this), $tr = $link.parents('tr:first');
                    var $checkboxes = $tr.find(':checkbox');
                    if ($checkboxes.length > 0) {
                        $checkboxes.each(function () {
                            var $checkbox = $(this);
                            $params[$checkbox.attr('name')] = $checkbox.is(':checked') ? $checkbox.val() : '0';
                        });
                    }
                    var $variants = $tr.find('select');
                    if ($variants.length > 0) {
                        $variants.each(function () {
                            var $variant = $(this);
                            $params[$variant.attr('name')] = $variant.val();
                        });
                    }
                    <?php
 if ($TOUR < 0 && $TOURTYPE < 0) { ?>
                    $params['APPLY_ALL'] = 'Y';
                    <?php
 } ?>
                    $params['AJAX'] = 'Y';
                    $params['SAVE'] = '1';
                    $params['LNG'] = '<?= $LNG ?>';
                    $.post($('#people-settings-form').attr('action'), $.param($params), function () {
                        $link.remove();
                        $tr.find('input').each(function () {
                            this.defaultChecked = this.checked;
                        }).end();
                        setTimeout(function () {
                            $tr.removeClass('changed').removeClass('not-self');
                        }, 2000);
                    }, 'script');
                }
            });
        });
    })(samo.jQuery);
</script>