<body>
<?php get_help_button('onlinest:sistema_upravlenija:flight_settings') ?>
<?= style_css() ?>
<form name="start" action="" method="post">
    <input type="hidden" name="page" value="<?=$ALIAS?>">
    <input type="hidden" name="LNG" value="<?= $LNG ?>">
    <input type="hidden" name="SAVE" value="0">
    <?php
 $SAVE = (isset($_POST['SAVE']) && ($_POST['SAVE'] == 1)) ? true : false; $FREIGHT = (isset($_REQUEST['FREIGHT']) && ($freight = intval($_REQUEST['FREIGHT']))) ? $freight : null; if ($SAVE) { $fss = isset($_POST['FSS']) ? $_POST['FSS'] : array(); foreach ($fss as $OnlineClass => $fs) { if (!is_int($OnlineClass)) { continue; } $db->exec( OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_5_ADMIN_freight_settings_Edit", array( 'Freight' => $FREIGHT, 'OnlineClass' => intval($OnlineClass), 'Class' => is_numeric($fs['Class']) ? intval($fs['Class']) : null, 'Min' => is_numeric($fs['Min']) ? intval($fs['Min']) : null, 'Max' => is_numeric($fs['Max']) ? intval($fs['Max']) : null, ) ); } admin_flash(Get_Message_Lang($LNG, 'adm_success_save')); echo admin_flash(); } $FreightList = $db->fetchAllWithKey("EXEC " . OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_3_ADMIN_freight_settings_Freight_List", 'Inc'); $ClassList = $db->fetchAllWithKey( "
        EXEC " . OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.sp_executesql N'
            SELECT [inc] AS [Inc], [name] AS [Name] FROM [dbo].[class] WHERE [inc] > 0 ORDER BY [Name]
        '
    ", 'Inc' ); $sql = $db->formatQuery("EXEC " . OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_4_ADMIN_freight_settings_List @Freight = %s", array($FREIGHT)); $fss = $db->fetchAll($sql); $options = function ($options, $value, $default = '---') { $res = ''; $res .= '<option value="NULL">' . $default . '</option>'; $options = (is_array($options)) ? $options : array(); foreach ($options as $key => $option) { $selected = ($key === $value) ? 'selected' : ''; $name = is_array($option) ? $option['Name'] : $option; $res .= "<option value='$key' $selected>$name</option>"; } return $res; }; $int_options = function ($value, $default_text) use ($options) { return $options(range(0, 500), $value, $default_text); }; $default_value = Get_Message_Lang($LNG, ($FREIGHT) ? 'adm_freight_settings_default_option' : 'adm_freight_settings_not_set'); ?>
    <script type="text/javascript">
        function Vars(save) {
            <?php
 if ($_ACCESS == 0) { ?>
            alert("Вам разрешен только просмотр. Only view.");
            <?php
 } else { if ($_ACCESS == 1) { ?>
            var is_ok = true;
                    <?php
 if (!$FREIGHT) { ?>
            var delete_class = [];
            samo.jQuery('#settings tbody tr').each(function () {
                var $ = samo.jQuery, $tr = $(this), $selects = $tr.find('select');
                var $class = $selects.filter('.online_class');
                if ('NULL' == $class.val()) {
                    var empty = true;
                    $selects.each(function () {
                        if ('NULL' != $(this).val()) {
                            empty = false;
                            return;
                        }
                    });
                    if (empty) {
                        var added = false;
                        $selects.each(function () {
                            $(this).find('option').each(function () {
                                if (!added && this.defaultSelected && this.value != 'NULL') {
                                    added = true;
                                    delete_class.push($tr.find('td:first').text());
                                    return;
                                }
                            });
                        });
                    }
                } else {
                    $selects.slice(1).each(function () {
                        var $select = $(this);
                        if ('NULL' == $select.val()) {
                            $tr.addClass('warning');
                            is_ok = false;
                            return;
                        } else {
                            $tr.removeClass('warning');
                            return;
                        }
                    });
                }
            });
            if (delete_class.length) {
                is_ok = confirm("<?=Get_Message_Lang($LNG, 'adm_freight_settings_remove_class_confirm')?>" + " " + delete_class.join(", ") + "?");
            }
                    <?php
 } ?>
            if (is_ok) {
                document.start.SAVE.value = save;
                document.start.submit();
            }
                    <?php
 if (!$FREIGHT) { ?>
            else if (!delete_class.length) {
                alert("<?=Get_Message_Lang($LNG, 'adm_freight_settings_no_class_default')?>");
            }
                    <?php
 } ?>
            <?php
 } } ?>
        }
    </script>
    <table class="config_filter_table">
        <tr>
            <td class="txt config_filter_what">
                <?= Get_Message_Lang($LNG, 'adm_freight_settings_freight') ?>
            </td>
            <td class="txt config_filter_value">
                <select name="FREIGHT" id="FREIGHT" onchange="location.href='?page=<?=$ALIAS?>&LNG=<?=$LNG?>&FREIGHT=' + this.value">
                    <?= $options($FreightList, $FREIGHT, Get_Message_Lang($LNG, 'adm_freight_any')) ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
 if ($fss) { ?>
        <br clear="all">
        <table class="config_table" id="settings" style="max-width: 800px;">
            <thead>
            <tr>
                <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_freight_settings_class_name') ?></td>
                <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_freight_settings_class') ?></td>
                <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_freight_settings_min') ?></td>
                <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_freight_settings_max') ?></td>
            </tr>
            </thead>
            <tbody>
            <?php
 foreach ($fss as $fs) { ?>
                <tr>
                    <td class="txt">
                        <?= Get_Message_Lang($LNG, 'adm_freight_settings_onlineclass_' . $fs['OnlineClass']) ?>
                    </td>
                    <?php
 if ($fs['ReadOnly']) { ?>
                        <td colspan="5"
                            class="txt notice"><?= Get_Message_Lang($LNG, 'adm_freight_settings_no_default') ?></td>
                    <?php
 } else { ?>
                        <td class="txt">
                            <select name="FSS[<?= $fs['OnlineClass'] ?>][Class]"
                                    class="element online_class"><?= $options($ClassList, $fs['Class'], $default_value) ?></select>
                        </td>
                        <td class="txt">
                            <select name="FSS[<?= $fs['OnlineClass'] ?>][Min]"
                                    class="element"><?= $int_options($fs['Min'], $default_value) ?></select>
                        </td>
                        <td class="txt">
                            <select name="FSS[<?= $fs['OnlineClass'] ?>][Max]"
                                    class="element"><?= $int_options($fs['Max'], $default_value) ?></select>
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
    <br clear="all">
    <input type=button value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>" name="BSAVE" class="button"
           onClick="Vars(1)">
</form>
<script src="<?= $http_site ?>public/js/pack.main.js" charset="windows-1251"></script>
</body>
