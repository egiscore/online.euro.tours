<?php
get_help_button('onlinest:sistema_upravlenija:print_doc'); if (!isset($_GET['EDIT_TEMPLATE'])) { $sql = OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.sp_executesql N'
        select distinct
            case when ''" . $LNG . "'' = ''rus'' then [dc].[Name] else [dc].[LName] end as [DoccategoryName],
            case when ''" . $LNG . "'' = ''rus'' then [t].[Name] else [t].[LName] end as [TourName],
            case when ''" . $LNG . "'' = ''rus'' then [s].[Name] else [s].[LName] end as [StateName],
            case when ''" . $LNG . "'' = ''rus'' then [c].[Name] else [c].[LName] end as [ContractTypeName],
            [spf].[legacy_form_name],
            [spf].[inc],
            [spf].[doccategory]
        from
            [doccategory] [dc],
            [settings].[printform] [spf]
                left outer join [tour] [t] ON [spf].[tour] = [t].[inc]
                left outer join [state] [s] ON [spf].[state] = [s].[inc]
                left outer join [contracttype] [c] ON [spf].[contracttype] = [c].[inc]
        where
            [dc].[inc] = [spf].[doccategory]
            AND [spf].[legacy_form_name] like ''%.tpl''
    '"; if (false !== ($templates = $db->fetchAll($sql))) { $current = (isset($_GET['tpl']) && !empty($_GET['tpl'])) ? $_GET['tpl'] : ''; ?>
        <?= style_css() ?>
        <form method="GET" id="EDIT_TEMPLATE">
            <input type="hidden" name="page" value="<?=$ALIAS?>">
            <input type="hidden" name="LNG" id="LNG" value="<?= $LNG ?>">
            <input type="hidden" name="tpl" id="tpl" value="">
        </form>
        <table width="100%" class="txt" id="print_settings_tpl">
            <tr>
                <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'tpl_category') ?></td>
                <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'tpl_state') ?></td>
                <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'tpl_tour') ?></td>
                <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'tpl_contract_type') ?></td>
                <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'tpl_name') ?></td>
                <td class="capt border_dark"></td>
            </tr>
            <?php
 foreach ($templates as $tpl) { echo '<tr>'; echo '<td class="border">&nbsp;' . $tpl['DoccategoryName'] . '</td>'; echo '<td class="border">&nbsp;' . $tpl['StateName'] . '</td>'; echo '<td class="border">&nbsp;' . $tpl['TourName'] . '</td>'; echo '<td class="border">&nbsp;' . $tpl['ContractTypeName'] . '</td>'; echo '<td class="border">&nbsp;' . $tpl['legacy_form_name'] . '</td>'; $show_btn = false; if ($tpl['inc'] != $current || $_SERVER['REQUEST_METHOD'] == 'POST') { $show_btn = true; } if ($show_btn) { echo '<td class="border">&nbsp;' . '<button class="button edit_template" data-inc="' . $tpl['inc'] . '">' . Get_Message_Lang($LNG, 'adm_edit_botton') . '</button>' . '</td>'; } else { echo '<td class="border">&nbsp;</td>'; } echo '</tr>'; if ($tpl['inc'] == $current) { $value = ''; $file = ''; $clear_tpl = null; foreach ($templates as $tpl2) { if ($tpl2['inc'] == $current) { $folder = array( 1 => 'invoice', 3 => 'insurance', 4 => 'voucher', 5 => 'agreement', 6 => 'claim_act', 7 => 'aviaticket_cost', 8 => 'aviaticket', 9 => 'anketa', 10 => 'booklet', 11 => 'confirmation', 16 => 'warrant', 17 => 'agreement_person', ); $clear_tpl = $folder[$tpl2['doccategory']]; $file = _ROOT . 'data/' . $folder[$tpl2['doccategory']] . '/' . $tpl2['legacy_form_name']; } } if (!file_exists($file)) { admin_flash(Get_Message_Lang($LNG, 'file_not_found')); } else { if ($_SERVER['REQUEST_METHOD'] == 'POST') { $CONTENT = isset($_POST['content']) ? trim($_POST['content']) : ''; $CONTENT = fckeditor_recover_tpl($CONTENT); if (strlen(strip_tags($CONTENT)) > 10) { if (Samo_Loader::load_object('Samo_View')->syntax_check($CONTENT, $error)) { if (@file_put_contents($file, $CONTENT)) { $old = umask(0); if (@chmod($file, 0666)) { clear_module_templates($clear_tpl); } umask($old); } else { $error = Get_Message_Lang($LNG, 'file_save_error'); } } if ($error) { admin_flash($error); } else { admin_flash(Get_Message_Lang($LNG, 'file_save_success')); } } else { $CONTENT = ''; } $value = $CONTENT; } else { $value = file_get_contents($file); echo '<tr>'; echo '<td class="border" colspan="6">'; ?>
                            <form method="POST" action="?tpl=<?= $current ?>">
                                <input type="hidden" name="page" value="<?=$ALIAS?>">
                                <input type="hidden" name="LNG" id="LNG" value="<?= $LNG ?>">
                                <input type="hidden" name="AJAX" id="AJAX" value="">
                                <?php
 require_once $folder_site . '/vendor/fckeditor/fckeditor.php'; $hEdit = new FCKeditor('content'); $hEdit->Width = '100%'; $hEdit->Height = '480'; $hEdit->ToolbarSet = 'Simple'; $hEdit->Value = $value; $hEdit->Create(); ?>
                                <input type="submit" class="button" value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>">
                            </form>
                            <?php
 echo '</td>'; echo '</tr>'; } } } } ?>
        </table>
        <?= admin_flash() ?>
    <?php
 } ?>
    <script type="text/javascript" src="<?= $http_site ?>public/js/pack.main.js"></script>
    <script type="text/javascript">
        (function ($) {
            $(document).ready(function () {
                $('#print_settings_tpl button.edit_template').bind('click', function (e) {
                    var tpl = $(this).data('inc');
                    $('#tpl').val(tpl);
                    $('#EDIT_TEMPLATE').submit();
                    return false;
                });
            });
        })(samo.jQuery);
    </script>
<?php
} 