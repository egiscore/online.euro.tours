<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<body>
<?= style_css() ?>
<form name="start" action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="LNG" id="LNG" value="<?= $LNG ?>">
    <input type="hidden" name="page" value="<?= $ALIAS ?>">
    <input type="hidden" name="ADD" id="ADD" value="">
    <input type="hidden" name="EDIT" id="EDIT" value="">
    <input type="hidden" name="SAVE" id="SAVE" value="">
    <input type="hidden" name="DELETE" id="DELETE" value="">
    <input type="hidden" name="UNLOCK" id="UNLOCK" value="">
    <?php
 extract($_POST); extract($_FILES); $TOWNINC = (isset($_POST['TOWNINC']) && $tmp = intval($_POST['TOWNINC'])) ? $tmp : ((isset($_GET['TOWNINC']) && $tmp = intval($_GET['TOWNINC'])) ? $tmp : 0); ?>
    <script>
        function Vars(add, edit, save, del, unlock) {
<?php
if ($_ACCESS == 0) { echo 'alert("Вам разрешен только просмотр. Only view.");'; } else if ($_ACCESS == 1) { ?>
            document.start.ADD.value = add;
            document.start.EDIT.value = edit;
            document.start.SAVE.value = save;
            document.start.DELETE.value = del;
            document.start.UNLOCK.value = unlock;
            document.start.submit();
<?php
} ?>

        }
    </script>


    <input type="hidden" name="TOWNINC" value="<?= $TOWNINC ?>">
    <input type="hidden" name="TEST" value="">
    <input type="hidden" name="CONTENT_HTML" value="">
    <?php
 if (isset($SAVE) and ($SAVE == 1)) { echo Get_Message_Lang($LNG, 'adm_editing') . "<br>"; if (!isset($TOWN_ENABLE)) { $TOWN_ENABLE = 0; } else { $TOWN_ENABLE = 1; } $sql = $db->formatQuery("EXEC " . OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_3_ADMIN_tour_config @Section = 'town_enable', @what = %d, @value = %d", array($TOWNINC, $TOWN_ENABLE)); $res = $db->ExecQuery($sql); $fld = "FLAG_GIF"; if (isset($_FILES[$fld]) && $_FILES[$fld]['size'] > 0) { move_uploaded_file($_FILES["FLAG_GIF"]['tmp_name'], $folder_site . '/data/town/flag_' . $TOWNINC . '.gif'); } $TT = trim($TOWN_ABOUT); if (!empty($TT)) { $sql = $db->formatQuery("EXEC " . OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.up_WEB_3_ADMIN_tour_config @Section = 'town_%d', @what = 'about', @value = %s", array($TOWNINC, $TT)); } else { $sql = $db->formatQuery(OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'DELETE FROM online_tour_config WHERE section = ''town_%d'' AND what = ''about'' '", array($TOWNINC)); } $db->ExecQuery($sql); $tmp = $folder_site . '/data/town/flag_' . $TOWNINC . '.gif'; if (isset($_POST['DEL_FLAG']) && $_POST['DEL_FLAG'] == 1 && file_exists($tmp)) { unlink($tmp); } echo Get_Message_Lang($LNG, 'adm_successfully') . "<br><br>"; } elseif (isset($EDIT) and ($EDIT == 1)) { ?>
        <script language="JavaScript">
            function Check_extention(str, ext) {
                if (str.substr(str.length - 3, 3) != ext) {
                    alert("<?= Get_Message_Lang($LNG, 'extension_incorrect') ?> " + ext + ".");
                    return false;
                }
            }
            function Confirm() {
                if ((document.start.FLAG_GIF.value != '') && (Check_extention(document.start.FLAG_GIF.value, 'gif') == false))
                    return;
                Vars('', '', 1, '', 1);
            }
            function Nosave() {

                Vars('', '', '', '', 1);
            }
        </script>
        <?= Get_Message_Lang($LNG, 'adm_town_edit_town_caption'); ?><br>
        <BR>
    <?php
 show_town_information($TOWNINC); ?>
        <BR clear="all">
        <br>
        <input type="button" value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>" name="SAVETOWN" class="button" onClick="Confirm()">
        <input type="button" value="<?= Get_Message_Lang($LNG, 'adm_not_save_botton') ?>" name="NOSAVE" class="button" onClick="Nosave()">
    <?php
 } if ((!isset($EDIT)) or ($EDIT != 1)) { ?>
        <input type="button" value="<?= Get_Message_Lang($LNG, 'adm_edit_botton') ?>" name="EDIT<?= $TOWNINC ?>" class="button" onClick="Vars('',1,'','','');">
        <br><br>
        <?= Get_Message_Lang($LNG, 'adm_town_view') ?>
        <br>
        <br>
        <iframe id="SHOW_HOTEL" name="SHOW_TOWN" style="width:100%; height:90%"
                src="<?= $http_site ?>default.php?page=hotels&samo_action=town&TOWNTO=<?= $TOWNINC ?>"></iframe>
    <?php
 } function show_town_information($id) { $db = Samo_Registry::get('db'); $LNG = $GLOBALS['LNG']; $folder_site = $GLOBALS['folder_site']; $http_site = $GLOBALS['http_site']; $sql = $db->formatQuery( OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.sp_executesql N'
        select top 1
            s.Inc as StateInc,
            s.name as StateName,
            s.Lname as StateLName,
            r.inc as RegionInc,
            r.Name as RegionName,
            r.lname as RegionLName,
            ft.inc as TownInc,
            ft.Name as TownName,
            ft.lname as TownLName,
            isnull([otct].[value], 0) as Enable
        from
            dbo.[town] ft left outer join v_online_config AS [otct] ON [otct].[section] = ''town_enable'' and [otct].[What] = ft.inc,
            dbo.region r,
            dbo.state s
        where
            ft.inc = @val
            and ft.state = s.inc
            and ft.region = r.inc
        ', N'@val INT', %d", array($id) ); if (false === ($row = $db->fetchRow($sql))) { echo Get_Message_Lang($LNG, 'adm_record_not_found'); exit; } if ($row['Enable'] == 1) { $enable = 'checked'; } else { $enable = ''; } ?>
        <?= Get_Message_Lang($LNG, 'adm_town_show_enable') ?>&nbsp;<input type="checkbox"
                                                                                name="TOWN_ENABLE" <?= $enable ?>
                                                                                value="1">
        <br>
        <?= Get_Message_Lang($LNG, 'adm_town_flag') ?>
        <?php
 $src = (file_exists($folder_site . 'data/town/flag_' . $id . '.gif')) ? $http_site . 'data/town/flag_' . $id . '.gif' : ''; ?>
        <img src="<?= $src ?>" alt="" align="absmiddle">
        <input type="file" class="element" name="FLAG_GIF" size="22"><input type="checkbox" value="1" name="DEL_FLAG"><?= Get_Message_Lang($LNG, 'adm_delete_botton') ?>
        <br>
        <br>
        <?= Get_Message_Lang($LNG, 'adm_town_about_town') ?>
        <br>
        <div class="border_dark">
            <?php
 $sql = $db->formatQuery(OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.sp_executesql N'SELECT [value] AS [Value] FROM online_tour_config WHERE section = ''town_%d'' AND what = ''about''' ", array($id)); $value = ($row = $db->fetchOne($sql)) ? $row : ''; require_once $folder_site . '/vendor/fckeditor/fckeditor.php'; $hEdit = new FCKeditor('TOWN_ABOUT'); $hEdit->Width = '100%'; $hEdit->Height = '200'; $hEdit->ToolbarSet = 'SamoSoft'; $hEdit->Value = $value; $hEdit->Create(); ?>
        </div>
    <?php
 $hotel_gif = "<script>\r\n"; $hotel_gif .= 'var hotel_gif = new Array('; $fl = 0; for ($i = 1; $i <= 20; $i++) { if ($i < 10) { $ii = '0' . $i; } else { $ii = $i; } if (file_exists($folder_site . 'data/town/' . $id . '_gif' . $ii . '.gif') and file_exists($folder_site . 'data/town/' . $id . '_jpg' . $ii . '.jpg')) { $fl = 1; $hotel_gif .= '"' . $http_site . 'data/town/' . $id . '_gif' . $ii . '.gif",'; $hotel_gif .= '"' . $http_site . 'data/town/' . $id . '_jpg' . $ii . '.jpg",'; $str = ''; if (file_exists($folder_site . 'data/town/' . $id . '_txt' . $ii . '.php')) { $str = file_get_contents($folder_site . 'data/town/' . $id . '_txt' . $ii . '.php'); } $hotel_gif .= '"' . $str . '",'; } } if ($fl == 1) { $hotel_gif = substr($hotel_gif, 0, strlen($hotel_gif) - 1); } $hotel_gif .= ");\r\n"; $hotel_gif .= "var hotel_gif_increment = 3;\r\n"; $hotel_gif .= "\r\n</script>"; echo $hotel_gif; ?>
        <script>
            function imgOn(imgName) {
                if (document.images) {
                    i = imgName.indexOf("|");
                    pt1 = imgName.substring(0, i);
                    pt2 = imgName.substring(i + 1, 1000);
                    document.img1.src = pt1;
                    imagealt.innerHTML = (pt2 == '') ? '&nbsp;' : pt2;
                }
            }

            function InsertGif() {
                str = '<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=520>';
                if (hotel_gif.length > 0) {
                    var num = 0;
                    for (var i = 0; i < hotel_gif.length; i += hotel_gif_increment) {
                        if (i == 0) {
                            str = str + '<TR ALIGN=CENTER VALIGN=TOP WIDTH=520 HEIGHT=65>';
                            str = str + '<TD ROWSPAN="' + (Math.ceil(hotel_gif.length / hotel_gif_increment / 3) + 1) + '" ALIGN=right VALIGN=TOP style="width: 520; height: 390">';
                            str = str + '<img src="' + hotel_gif[i + 1] + '" name="img1" idname="img1"  style="max-width: 520; max-height: 390">';
                            str = str + '</td>';
                        } else {
                            num++;
                        }
                        if ((num % 3 == 0) && num > 0) {
                            str = str + '</TR><TR>';
                        }
                        str = str + '<td' + (i + hotel_gif_increment == hotel_gif.length && (num + 1) % 3 != 0 ? (' colspan="' + (hotel_gif_increment - (num + 1) % 3 + 1) + '"') : '') + '><img src="' + hotel_gif[i] + '" BORDER=0 WIDTH=65 HEIGHT=65 onmouseover="imgOn(\'' + hotel_gif[i + 1] + '|' + hotel_gif[i + 2] + '\')"></td>';
                    }
                }
                str = str + '</TR><TR><TD colspan="3" style="vertical-align: top;' + (hotel_gif.length > 0 ? ' padding: 10px;' : '') + '"><input type=button value="<?= Get_Message_Lang($LNG, 'adm_town_pictures') ?>" id="btn-EDIT" name="EDIT" class="button" onClick="Images(<?= $id ?>);"></TD></TR>';
                str = str + '</table>';
                document.getElementById('h_images').innerHTML = str;
                return;
            }
            function Images(hotel) {
                pic = window.open('', 'pictires', 'resizable=yes,height=450,width=620,status=yes,toolbar=no,menubar=no,location=no');
                document.start.target = 'pictires';
                document.start.action = "<?= $http_site ?>admin/modules/town/edittownimage.php?LNG=<?=$LNG?>&TOWNINC=<?= $GLOBALS['TOWNINC'] ?>";
                document.start.submit();
                document.start.action = '';
                document.start.target = '';
                pic.focus();
            }
        </script>
        <br>
        <table cellpadding=1 cellspacing=1 border="0">
            <tr>
                <td name="h_images" id="h_images">
                </td>
        </table>
        <script>
            InsertGif();
        </script>
    <?php
 } ?>
</form>
</body>
