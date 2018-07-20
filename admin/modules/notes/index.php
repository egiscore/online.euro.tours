<?=style_css()?>
<?php get_help_button('onlinest:sistema_upravlenija:note')?>
<?php
 $MODULE = (isset($_GET['MODULE']) && !empty($_GET['MODULE'])) ? $_GET['MODULE'] : ''; if ($MODULE && ($_SERVER['REQUEST_METHOD'] == 'POST')) { $CONTENT = isset($_POST['NOTE']) ? trim($_POST['NOTE']) : ''; $CONTENT = fckeditor_recover_tpl($CONTENT); if (strlen(strip_tags($CONTENT, '<img><iframe><script>')) > 10) { if (Samo_Loader::load_object('Samo_View')->syntax_check($CONTENT, $ERROR)) { $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Section' => 'notes', 'What' => $MODULE, 'Value' => $CONTENT, 'UserCode' => INTERNET_USER, ] ); $db->query($sql); admin_flash(Get_Message_Lang($LNG, 'adm_success_save')); } else { $VALUE = $CONTENT; admin_flash(Get_Message_Lang($LNG, 'adm_failed_save_note')); } } else { $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'
            DELETE FROM [dbo].[online_tour_config] WHERE [Inc] IN (
                    SELECT Inc FROM (
                        SELECT [Inc],
                            ROW_NUMBER() OVER (PARTITION BY [What] ORDER BY [user_code] DESC) AS [Sort]
                            FROM [dbo].[online_tour_config]
                        WHERE ([user_code] = @UserCode OR [user_code] IS NULL) AND [Section] = ''notes'' AND What = @What
                        ) [s]
                    WHERE [s].[Sort] = 1
                )
        ', N'@UserCode INT, @What varchar(255)', " . INTERNET_USER . ", " . $db->quote($MODULE); $db->query($sql); admin_flash(Get_Message_Lang($LNG, 'adm_success_delete')); } } if ($MODULE && !isset($VALUE)) { $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Section' => 'notes', 'What' => $MODULE, 'UserCode' => INTERNET_USER, ] ); if ($row = $db->fetchRow($sql)) { $VALUE = $row['Value']; } } ?>
<?= admin_flash() ?>
<?= isset($ERROR) ? '<b class="error">' . $ERROR . '</b><br><br>' : '' ?>
<form method="GET">
    <input type="hidden" name="page" value="<?= $ALIAS ?>">
    <input type="hidden" name="LNG" value="<?= $LNG ?>">
    <table class="config_filter_table">
        <tr>
            <td class="txt config_filter_what">
                <?= Get_Message_Lang($LNG, 'adm_notes_page')?>
            </td>
            <td class="txt config_filter_value">
                <select name="MODULE" onchange="submit();">
                    <option>&mdash;&mdash;&mdash;</option>
                    <?php
 $modules = []; $hide_public = [ 'fast_search', 'fast_search_person', 'check_confirm', 'currency', ]; $show_hidden = [ 'cl_refer_person', 'messages', 'messages_person', 'bron', 'bron_person', 'search_tour_person', 'search_hotel', 'search_hotel_person', 'all_prices', 'profile', 'pay_variant', 'report', ]; foreach ($routes as $key => $route) { if (!isset($route['public']) || $route['public']) { if (in_array($key, $hide_public)) { continue; } } else { if (!in_array($key, $show_hidden)) { continue; } } $modules[$key] = $route; } $modules['menu'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_module_menu')]; $modules['edocs'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_module_edocs')]; $modules['pay_variant'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_module_pay_variant')]; $modules['frplacement'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_bron_frplacement')]; $modules['register_agency_success'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_register_agency_success')]; $modules['bron_info_tour'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_bron_info_tour')]; $modules['bron_info_hotel'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_bron_info_hotel')]; $modules['bron_info_freight'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_bron_info_freight')]; $modules['bron_info_insure'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_bron_info_insure')]; $modules['bron_info_service'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_bron_info_service')]; $modules['bron_info_tourist'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_bron_info_tourist')]; if (isset($modules['bron_person'])) { $modules['bron_person_result'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_module_bron_person_result')]; } if (isset($modules['messages_person'])) { $modules['messages_person'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_module_messages_person')]; } if (isset($modules['cl_refer'])) { $modules['cl_refer_cost_part'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_module_cl_refer_cost_part')]; $modules['cl_refer_cost_fill'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_module_cl_refer_cost_fill')]; } if (isset($modules['cl_refer_person'])) { $modules['cl_refer_person_payment_error'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_module_cl_refer_person_payment_error')]; $modules['cl_refer_person_payment_wait'] = ['title' => Get_Message_Lang($LNG, 'adm_notes_module_cl_refer_person_payment_wait')]; } uasort( $modules, function ($a, $b) { return strcmp($a['title'], $b['title']); } ); foreach ($modules as $key => $module) { $selected = ($key == $MODULE) ? 'selected="selected"' : ''; echo '<option value="' . $key. '" ' . $selected . '>' . $module['title'] . '</option>'; } ?>
                </select>
            </td>
        </tr>
    </table>
    <noscript><input type="submit" name="<?=Get_Message_Lang($LNG, 'select')?>"></noscript>
</form>
<?php
if ($MODULE) { ?>
    <form method="POST" action="?MODULE=<?= $MODULE ?>">
        <input type="hidden" name="page" value="<?=$ALIAS?>">
        <input type="hidden" name="LNG" value="<?= $LNG ?>">
        <?php
 require_once $folder_site.'/vendor/fckeditor/fckeditor.php'; $hEdit = new FCKeditor('NOTE'); $hEdit->Width = '100%'; $hEdit->Height = '480'; $hEdit->ToolbarSet = 'Public'; $hEdit->Value = isset($VALUE) ? $VALUE : ''; $hEdit->Create(); ?>
        <br clear="all">
        <input class="button" type="submit" value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>" >
    </form>
    <?php
} 