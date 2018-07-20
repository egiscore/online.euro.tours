<?php get_help_button('onlinest:sistema_upravlenija:payment_methods') ?>
<?= style_css() ?>
<?php
if (isset($_POST['delete'])) { $current = $_GET['module']; $installed = isset($routes[$current]); if (!$installed) { $sql = sprintf( OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'
                    SET NOCOUNT ON
                    DELETE FROM [dbo].[online_tour_config]
                        WHERE [Inc] IN (
                            SELECT Inc FROM (
                                SELECT [Inc],
                                    ROW_NUMBER() OVER (PARTITION BY [What] ORDER BY [user_code] DESC) AS [Sort]
                                    FROM [dbo].[online_tour_config]
                                WHERE ([user_code] = @UserCode OR [user_code] IS NULL)
                                    AND [tour] IS NULL AND [State] IS NULL AND [TownFrom] IS NULL
                                    AND [Section] = ''pay_variant''
                                    AND [What] = @pay_variant
                                ) [s]
                            WHERE [s].[Sort] = 1
                        )
                    DELETE FROM [dbo].[online_tour_config] WHERE [section] = @pay_variant
                ', N'@UserCode INT, @pay_variant varchar(255)', %d, %s", INTERNET_USER, $db->quote($current) ); } else { $sql = $db->formatExec( OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_3_ADMIN_tour_config", [ 'Section' => 'pay_variant', 'What' => $current, 'Value' => 0, 'UserCode' => INTERNET_USER, ] ); } $db->query($sql); admin_flash(Get_Message_Lang($LNG, 'adm_success_delete')); header('Location: ' . $_SERVER['REQUEST_URI'] . '?page=' . $ALIAS . '&LNG=' . $LNG, true, 301); exit; } $save = isset($_POST['save']); $DESCRIPTION = null; if ($save) { $add = !isset($_GET['module']); if ($add) { $title = $_POST['title']; $current = trim( substr( preg_replace( '/[^a-z]/', '_', str_replace( [ 'а', 'б', 'в', 'г', 'д', 'е', 'Є', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', '€', ], [ 'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sh', '', 'y', '', 'e', 'iu', 'ia', ], mb_strtolower($title) ) ), 0, 32 ), '_' ); if (empty($current)) { $current = 'pv_' . $_SERVER['REQUEST_TIME']; }; } else { $current = $_GET['module']; } if (isset($_POST['OWNER_ANY'])) { $owners = -2147483647; } else { $post_owners = (isset($_POST['owners']) ? $_POST['owners'] : array()); $owners = (count($post_owners) > 0) ? implode(',', $post_owners) : 0; } $sql = $db->formatExec( OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_3_ADMIN_tour_config", [ 'Section' => 'pay_variant', 'What' => $current, 'Value' => $owners, 'UserCode' => INTERNET_USER, ] ); $db->query($sql); $errors = false; foreach (array('title', 'description', 'link', 'link_title', 'max_summ', 'can_pay_agency', 'can_pay_person') as $prop) { $value = (isset($_POST[$prop]) ? $_POST[$prop] : ''); if (!empty($value)) { if ($prop == 'description') { $DESCRIPTION = $value; if (!Samo_Loader::load_object('Samo_View')->syntax_check($value, $error)) { $errors = $error; continue; } } $sql = $db->formatExec( OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_3_ADMIN_tour_config", [ 'Section' => $current, 'What' => $prop, 'Value' => $value, 'UserCode' => INTERNET_USER, ] ); } else { $sql = sprintf( OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'
                    SET NOCOUNT ON
                    DELETE FROM [dbo].[online_tour_config]
                        WHERE [Inc] IN (
                            SELECT Inc FROM (
                                SELECT [Inc],
                                    ROW_NUMBER() OVER (PARTITION BY [What] ORDER BY [user_code] DESC) AS [Sort]
                                    FROM [dbo].[online_tour_config]
                                WHERE ([user_code] = @UserCode OR [user_code] IS NULL)
                                    AND [tour] IS NULL AND [State] IS NULL AND [TownFrom] IS NULL
                                    AND [Section] = @pay_variant
                                    AND [What] = @prop
                                ) [s]
                            WHERE [s].[Sort] = 1
                        )
                ', N'@UserCode INT, @pay_variant varchar(255), @prop varchar(255)', %d, %s, %s", INTERNET_USER, $db->quote($current), $db->quote($prop) ); $db->query($sql); } $db->query($sql); } if ($add) { $sql = $db->formatExec( OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_3_ADMIN_tour_config", [ 'Section' => $current, 'What' => 'sort', 'Value' => 100, 'UserCode' => INTERNET_USER, ] ); $db->query($sql); } if ($errors) { admin_flash($errors); } else { if ($add) { admin_flash(Get_Message_Lang($LNG, 'adm_success_add')); } else { admin_flash(Get_Message_Lang($LNG, 'adm_success_save')); } header('Location: ' . Samo_Url::route('admin', $_GET), true, 301); exit; } } else { if (isset($_POST['save_new_sort'])) { foreach ($_POST['module'] as $variant => $data) { $sql = $db->formatExec( OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_3_ADMIN_tour_config", [ 'Section' => $variant, 'What' => 'sort', 'Value' => $data['sort'], 'UserCode' => INTERNET_USER, ] ); $db->query($sql); } admin_flash(Get_Message_Lang($LNG, 'adm_success_save')); header('Location: ' . $_SERVER['REQUEST_URI'] . '?page=' . $ALIAS . '&LNG=' . $LNG, true, 301); exit; } if (isset($_POST['new_module'])) { show_pay_variant_information(); exit; } } if (isset($_POST['cancel'])) { unset($_GET['module']); } echo admin_flash(); if (isset($_GET['module'])) { return show_pay_variant_information($_GET['module']); } $variants = array(); $sql = $db->formatExec( OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_3_ADMIN_tour_config", [ 'Section' => 'pay_variant', 'UserCode' => INTERNET_USER, ] ); $res = $db->query($sql); if ($db->numRows($res) > 0) { while ($row = $db->fetchRow($res)) { $variant = $row['What']; $installed = isset($routes[$variant]); if (!$installed) { if (in_array($variant, ['deposit', 'rfzbank'])) { continue; } try { $model = \Samo_Loader::load_object(ucfirst($variant) . '_Model'); if (method_exists($model, 'pay_variant')) { continue; } } catch (Samo_Exception $e) { $e; } } if ($row['Value'] == -2147483647) { $owner_list = 'Ћюбой'; } elseif ($row['Value'] == 0) { $owner_list = '---'; } elseif ($row['Value'] > 0) { $owner_list = ''; $sql = $db->formatExec( OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_3_ADMIN_pay_variant_owner_list", [ 'Owners' => $row['Value'], ] ); if (false !== ($owners = $db->fetchAll($sql))) { foreach ($owners as $row) { $owner_list = $owner_list . (('' != $owner_list) ? '<br>' : '') . $row['LName']; } } } $variants[$variant] = array('title' => (isset($routes[$variant]) && isset($routes[$variant]['title'])) ? $routes[$variant]['title'] : $variant, 'sort' => 0, 'standart' => $installed, 'owners' => $owner_list); $props = $db->exec(OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_3_ADMIN_tour_config", array('Section' => $variant, 'UserCode' => INTERNET_USER), true); if ($db->numRows($props) > 0) { while ($prop = $db->fetchRow($props)) { $variants[$variant][$prop['What']] = $prop['Value']; } } } } uasort( $variants, function ($a, $b) { return $a['sort'] < $b['sort'] ? -1 : 1; } ); ?>
    <style>
        table.txt td {
            padding: 3px;
        }

        tr.nonstandart td {
            background-color: #eee;
        }

        td.title {
            cursor: pointer;
        }
    </style>
    <form method="POST">
        <input type="hidden" name="page" value="<?=$ALIAS?>">
        <input type="hidden" name="LNG" value="<?= $LNG ?>">
        <table id="pay_variants" class="txt">
            <thead>
            <tr>
                <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_pay_variants_name') ?></td>
                <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_pay_variants_owner_list') ?></td>
                <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_pay_variants_sort') ?></td>
                <td class="capt border_dark">&nbsp;</td>
            </tr>
            </thead>
            <tbody>
            <?php
 foreach ($variants as $variant => $data) { $standart = isset($data['standart']) && $data['standart']; ?>
                <tr <?= $standart ? '' : ' class="nonstandart"' ?>>
                    <td class="border">
                        <?= !empty($data['title']) ? $data['title'] : '&lt;' . Get_Message_Lang($LNG, 'adm_pay_variants_empty') . '&gt;' ?>
                    </td>
                    <td class="border">
                        <?= !empty($data['owners']) ? $data['owners'] : '&lt;' . Get_Message_Lang($LNG, 'adm_pay_variants_empty') . '&gt;' ?>
                    </td>
                    <td class="border">
                        <input class="element" type="text" size="2" name="module[<?= $variant ?>][sort]" value="<?= $data['sort'] ?>"/>
                    </td>
                    <td class="border">
                        <a href="?page=<?=$ALIAS?>&LNG=<?=$LNG?>&module=<?= $variant ?>"><?= Get_Message_Lang($LNG, 'adm_edit_botton') ?></a>
                    </td>
                </tr>
                <?php
 } ?>
            </tbody>
        </table>
        <br clear="all">
        <input type="submit" name="save_new_sort" class="button"
               value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>""/>
        <input type="submit" name="new_module" class="button" value="<?= Get_Message_Lang($LNG, 'adm_add_botton') ?>"/>
    </form>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            var fixHelperModified = function (e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone().css({cursor: 'pointer'});
                $helper.children().each(function (index) {
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            };
            $(window).load(function () {
                $("#pay_variants tbody").sortable({
                    helper: fixHelperModified,
                    update: function (event, ui) {
                        $(event.target).find('tr').each(function (i) {
                            $(this).find('[name*="[sort]"]').val(i);
                        });
                    }
                }).disableSelection();
            });
        });


    </script>
<?php
function show_pay_variant_information($variant = '') { $db = $GLOBALS['db']; $LNG = $GLOBALS['LNG']; $ALIAS = $GLOBALS['ALIAS']; $folder_site = $GLOBALS['folder_site']; $http_site = $GLOBALS['http_site']; $DESCRIPTION = $GLOBALS['DESCRIPTION']; $routes = $GLOBALS['routes']; $data = array( 'title' => '' , 'link' => '' , 'link_title' => '' , 'description' => '' , 'any_owners' => 1 , 'owners' => array() , 'can_pay_agency' => 1 , 'can_pay_person' => 0 ); $add = true; if ('' != $variant) { $installed = isset($routes[$variant]); $add = false; $sql = $db->formatExec( OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_3_ADMIN_tour_config", [ 'Section' => $variant, 'UserCode' => INTERNET_USER, ] ); $result = $db->fetchAllWithKey($sql, 'What'); if ($result) { $data['title'] = (array_key_exists('title', $result)) ? $result['title']['Value'] : ''; $data['link'] = (array_key_exists('link', $result)) ? $result['link']['Value'] : ''; $data['link_title'] = (array_key_exists('link_title', $result)) ? $result['link_title']['Value'] : ''; $data['description'] = (empty($DESCRIPTION)) ? ((array_key_exists('description', $result)) ? $result['description']['Value'] : '') : $DESCRIPTION; if ($variant == 'psbank') { $data['max_summ'] = (array_key_exists('max_summ', $result)) ? $result['max_summ']['Value'] : ''; } $sql = $db->formatExec( OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_3_ADMIN_tour_config", [ 'Section' => 'pay_variant', 'What' => $variant, 'UserCode' => INTERNET_USER, ] ); $ownerCfg = $db->fetchRow($sql); $data['any_owners'] = '-2147483647' == $ownerCfg['Value'] ? 1 : 0; $data['can_pay_agency'] = (array_key_exists('can_pay_agency', $result)) ? $result['can_pay_agency']['Value'] : 0; $data['can_pay_person'] = (array_key_exists('can_pay_person', $result)) ? $result['can_pay_person']['Value'] : 0; } } else { $installed = false; } $sql = $db->formatExec( OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_4_ADMIN_pay_variant_owner", [ 'Variant' => $variant, 'UserCode' => INTERNET_USER, ] ); $data['owners'] = $db->fetchAll($sql); ?>
    <form id="VARIANT_FORM" name="VARIANT_FORM" method="POST" onSubmit="return checkedForm(btn)">
        <input type="hidden" name="page" value="<?=$ALIAS?>">
        <input type="hidden" name="LNG" value="<?= $LNG ?>">
        <table class="config_table">
            <tr>
                <td class="capt border_dark config_what"><?= Get_Message_Lang($LNG, 'adm_config_what') ?></td>
                <td class="capt border_dark config_value"><?= Get_Message_Lang($LNG, 'adm_config_value') ?></td>
            </tr>
            <tr>
                <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_pay_variants_name') ?></td>
                <td class="txt border config_value">
                    <input class="element100" type="text" id="title" name="title" value="<?php echo $data['title'] ?>" />
                </td>
            </tr>
            <?php
 if (!$installed) { ?>
            <tr>
                <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_pay_variants_link') ?></td>
                <td class="txt border config_value">
                    <input class="element100" type="text" id="link" name="link" value="<?php echo $data['link'] ?>" />
                </td>
            </tr>
            <tr>
                <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_pay_variants_link_title') ?></td>
                <td class="txt border config_value">
                    <input class="element100" type="text" id="link_title" name="link_title" value="<?php echo $data['link_title'] ?>" />
                </td>
            </tr>
            <?php
 } if ($variant == 'psbank') { ?>
                <tr>
                    <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_pay_variants_max_summ') ?></td>
                    <td class="txt border config_value">
                        <input class="element100" type="text" id="max_summ" name="max_summ" value="<?= $data['max_summ'] ?>" />
                    </td>
                </tr>
            <?php
 } ?>
            <tr>
                <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_pay_variants_owner_list') ?></td>
                <td class="txt border config_value">
                    <div class="element config_checkboxlist owner_list">
                        <label>
                            <input type="checkbox" class="owner_any" name="OWNER_ANY" value="1" <?= ($data['any_owners']) ? 'checked' : '' ?>><?= Get_Message_Lang($LNG, 'adm_pay_variants_any') ?>
                        </label>
                        <hr>
                        <?php
 foreach ($data['owners'] as $owner) { ?>
                            <label>
                                <input type="checkbox" class="owner" name="owners[<?= $owner['Inc'] ?>]" value="<?= $owner['Inc'] ?>" <?= ($owner['Enable']) ? 'checked' : '' ?>><?= $owner['LName'] ?>
                            </label>
                            <br>
                            <?php
 } ?>
                    </div>
                </td>
            </tr>
            
                <tr>
                    <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_pay_variants_access_title') ?></td>
                    <td class="txt border config_value">
                        <div class="element config_checkboxlist pay_list">
                            <label>
                                <input type="checkbox" class="can_pay_agency" name="can_pay_agency" value="1" <?= ($data['can_pay_agency']) ? 'checked' : '' ?>><?= Get_Message_Lang($LNG, 'adm_pay_variants_access_agency') ?>
                            </label>
                            <?php
 if ($variant != 'bonus_manager' && $variant != 'deposit') { ?>
                                <br>
                                <label>
                                    <input type="checkbox" class="can_pay_person" name="can_pay_person" value="1" <?= ($data['can_pay_person']) ? 'checked' : '' ?>><?= Get_Message_Lang($LNG, 'adm_pay_variants_access_person') ?>
                                </label>
                            <?php
 } ?>
                        </div>
                    </td>
                </tr>
            
            <tr>
                <td class="capt1 border config_what"><?= Get_Message_Lang($LNG, 'adm_pay_variants_text') ?></td>
                <td class="txt border config_value">
                    <?php
 require_once $folder_site . '/vendor/fckeditor/fckeditor.php'; $hEdit = new FCKeditor('description'); $hEdit->Width = '100%'; $hEdit->Height = '240'; $hEdit->ToolbarSet = 'Public'; $hEdit->Value = $data['description']; $hEdit->Create(); ?>
                </td>
            </tr>
        </table>
        <br clear="all"/>
        <input type="submit" name="save" class="button"
               value="<?= Get_Message_Lang($LNG, 'adm_' . ($add ? 'add' : 'save') . '_botton') ?>"
               onclick="btn='save'"/>
        <input type="submit" name="cancel" class="button"
               value="<?= Get_Message_Lang($LNG, 'adm_back_button') ?>" onclick="btn='cancel'"/>
        <?php
 if (!$add) { ?>
                <input type="submit" name="delete" class="button" value="<?= Get_Message_Lang($LNG, 'adm_delete_botton') ?>" onclick="btn='delete'; if (!confirm('<?= Get_Message_Lang($LNG, 'adm_confirm_delete') ?>')) return false;" style="margin-left: 100px;"/>
        <?php
 } ?>
    </form>
    <script src="<?= $http_site ?>public/js/pack.main.js"></script>
    <script type="text/javascript">
        var btn;
        (function ($) {
            $(document).ready(function () {
                $('.owner_list').on('click', 'input', function (e) {
                    var $self = $(this);
                    if ($self.prop('checked')) {
                        if ($self.hasClass('owner')) {
                            $('.owner_list').find('.owner_any').prop('checked', false);
                        }
                        if ($self.hasClass('owner_any')) {
                            $('.owner_list').find('.owner').prop('checked', false);
                        }
                    }
                });
            });
        })(samo.jQuery);
        function checkedForm(btn) {
            if (btn == 'save' && document.VARIANT_FORM.title.value == '') {
                alert("<?= Get_Message_Lang($LNG, 'adm_editing_empty_title') ?>");
                return false;
            }
            return true;
        }
    </script>
<?php
} 