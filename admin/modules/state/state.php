<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<body>
<?= style_css() ?>
<FORM name="start" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="LNG" value="<?= $LNG ?>">
<input type=hidden name="ADD" value="">
<input type=hidden name="EDIT" value="">
<input type=hidden name="SAVE" value="">
<input type=hidden name="DELETE" value="">
<input type=hidden name="UNLOCK" value="">
<?php get_help_button('onlinest:sistema_upravlenija:state_reg_city')?>
<?php
extract($_POST); extract($_FILES); $STATEINC = (isset($_POST['STATEINC']) && $tmp = intval($_POST['STATEINC'])) ? $tmp : ((isset($_GET['STATEINC']) && $tmp = intval($_GET['STATEINC'])) ? $tmp : 0); ?>
<script>
    function Vars(add, edit, save, del, unlock) {
        <?php
 if ($_ACCESS == 0) { echo 'alert("Вам разрешен только просмотр. Only view.");'; } elseif ($_ACCESS == 1) { ?>
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
<input type="hidden" name="STATEINC" value="<?= $STATEINC ?>">
<input type="hidden" name="TEST" value="">
<input type="hidden" name="CONTENT_HTML" value="">
<?php
if (isset($SAVE) and ($SAVE == 1)) { echo Get_Message_Lang($LNG, 'adm_editing') . "<br>"; if (!isset($STATE_ENABLE)) { $STATE_ENABLE = 0; } else { $STATE_ENABLE = 1; } $sql = $db->formatQuery("EXEC ".OFFICE_SQLSERVER.".".OFFICEDB.".dbo.up_WEB_3_ADMIN_tour_config @Section = 'state_enable', @what = %d, @value = %d", array($STATEINC, $STATE_ENABLE)); $res = $db->ExecQuery($sql); $fld = "FLAG_GIF"; if (isset($_FILES[$fld]) && $_FILES[$fld]['size'] > 0) { move_uploaded_file($_FILES["FLAG_GIF"]['tmp_name'], $folder_site . '/data/state/flag_' . $STATEINC . '.gif'); chmod($folder_site . '/data/state/flag_' . $STATEINC . '.gif', 0777); } $TT = trim($STATE_ABOUT); if (!empty($TT)) { $sql = $db->formatQuery("EXEC ".OFFICE_SQLSERVER.".".OFFICEDB.".dbo.up_WEB_3_ADMIN_tour_config @State = %d, @Section = 'state', @what = 'about', @value = %s", array($STATEINC, $TT)); } else { $sql = $db->formatQuery(OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'DELETE FROM online_tour_config WHERE section = ''state'' AND what = ''about'' AND state = @val', N'@val INT', %d", array($STATEINC)); } $db->ExecQuery($sql); $tmp = $folder_site . '/data/state/flag_' . $STATEINC . '.gif'; if (isset($_POST['DEL_FLAG']) && $_POST['DEL_FLAG'] == 1 && file_exists($tmp)) { unlink($tmp); } echo Get_Message_Lang($LNG, 'adm_successfully') . "<br><br>"; } elseif (isset($EDIT) and ($EDIT == 1)) { ?>
    <script language="JavaScript">
        function Check_extention(str, ext) {
            if (str.substr(str.length - 3, 3) != ext) {
                alert("<?= Get_Message_Lang($LNG, 'extension_incorrect') ?> " + ext + ".");
                return(false);
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
    <?= Get_Message_Lang($LNG, 'adm_state_edit_state_caption') ?><br>
    <BR>
    <?php
 show_state_information($STATEINC); ?>
    <BR clear="all">
    <br>
    <input type="button" value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>" name="SAVESTATE" class="button" onClick="Confirm()">
    <input type="button" value="<?= Get_Message_Lang($LNG, 'adm_not_save_botton') ?>" name="NOSAVE" class="button" onClick="Nosave()">
<?php
} if ((!isset($EDIT)) or ($EDIT != 1)) { ?>
    <input type="button" value="<?= Get_Message_Lang($LNG, 'adm_edit_botton') ?>" name="EDIT<?= $STATEINC ?> class="button" onClick="Vars('',1,'','','');"><br><br>
    <?= Get_Message_Lang($LNG, 'adm_state_view') ?><br>
    <br>
    <iframe id="SHOW_HOTEL" name="SHOW_STATE" style="width:100%; height:90%" src="<?= $http_site ?>default.php?page=hotels&samo_action=state&STATEINC=<?= $STATEINC ?>"></iframe>
<?php
} function show_state_information($id) { $db = Samo_Registry::get('db'); $LNG = $GLOBALS['LNG']; $folder_site = $GLOBALS['folder_site']; $http_site = $GLOBALS['http_site']; $sql = $db->formatQuery( OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.sp_executesql N'
        select top 1
            fs.Inc as StateInc,
            fs.name as StateName,
            fs.Lname as StateLName,
            isnull([otcs].[value], 0) as Enable
        from
            dbo.state fs left outer join v_online_config AS [otcs] ON [otcs].[section] = ''state_enable'' and [otcs].[What] = fs.inc
        where
            fs.inc = @val
        ', N'@val INT', %d", array($id) ); if (false === ($row = $db->fetchRow($sql))) { echo Get_Message_Lang($LNG, 'adm_record_not_found'); exit; } if ($row['Enable'] == 1) { $enable = 'checked'; } else { $enable = ''; } ?>
    <?= Get_Message_Lang($LNG, 'adm_state_show_enable') ?>&nbsp;<input type="checkbox" name="STATE_ENABLE" <?= $enable ?> value="1">
    <br>
    <?= Get_Message_Lang($LNG, 'adm_state_flag') ?>
    <?php
 $src = (file_exists($folder_site . 'data/state/flag_' . $id . '.gif')) ? $http_site . 'data/state/flag_' . $id . '.gif' : ''; ?>
    <img src="<?= $src ?>" alt="" align="absmiddle">
    <input type="file" class="element" name="FLAG_GIF" size="22"><input type="checkbox" value="1" name="DEL_FLAG"><?= Get_Message_Lang($LNG, 'adm_delete_botton') ?>
    <br>
    <br>
    <br>
    <?= Get_Message_Lang($LNG, 'adm_state_about_state') ?>
    <br>
    <div class="border_dark">
        <?php
 $sql = $db->formatQuery(OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.sp_executesql N'SELECT [value] AS [Value] FROM online_tour_config WHERE section = ''state'' AND what = ''about'' AND [state] = @val', N'@val INT', %d", array($id)); $value = ($row = $db->fetchOne($sql)) ? $row : ''; require_once $folder_site . 'vendor/fckeditor/fckeditor.php'; $hEdit = new FCKeditor('STATE_ABOUT'); $hEdit->Width = '100%'; $hEdit->Height = '200'; $hEdit->ToolbarSet = 'SamoSoft'; $hEdit->Value = $value; $hEdit->Create(); ?>
    </div>
<?php
$hotel_gif = "<script>\r\n"; $hotel_gif .= 'var hotel_gif = new Array('; $fl = 0; for ($i = 1; $i <= 20; $i++) { if ($i < 10) { $ii = '0' . $i; } else { $ii = $i; } if (file_exists($folder_site . 'data/state/' . $id . '_gif' . $ii . '.gif') and file_exists($folder_site . 'data/state/' . $id . '_jpg' . $ii . '.jpg')) { $fl = 1; $hotel_gif .= '"' . $http_site . 'data/state/' . $id . '_gif' . $ii . '.gif",'; $hotel_gif .= '"' . $http_site . 'data/state/' . $id . '_jpg' . $ii . '.jpg",'; $str = ''; if (file_exists($folder_site . 'data/state/' . $id . '_txt' . $ii . '.php')) { $str = file_get_contents($folder_site . 'data/state/' . $id . '_txt' . $ii . '.php'); } $hotel_gif .= '"' . $str . '",'; } } if ($fl == 1) { $hotel_gif = substr($hotel_gif, 0, strlen($hotel_gif) - 1); } $hotel_gif .= ");\r\n"; $hotel_gif .= "var hotel_gif_increment = 3;\r\n"; $hotel_gif .= "\r\n</script>"; echo $hotel_gif; ?>
    <script>
        function Images(hotel) {
            pic = window.open('', 'pictires', 'resizable=yes,height=450,width=620,status=yes,toolbar=no,menubar=no,location=no');
            document.start.target = 'pictires';
            document.start.action = "<?= $http_site ?>admin/modules/state/editstateimage.php?LNG=<?=$LNG?>&STATEINC=<?= $GLOBALS['STATEINC'] ?>";
            document.start.submit();
            document.start.action = '';
            document.start.target = '';
            pic.focus();
        }

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
            str = str + '</TR><TR><TD colspan="3" style="vertical-align: top;' + (hotel_gif.length > 0 ? ' padding: 10px;' : '') + '"><input type=button value="<?= Get_Message_Lang($LNG, 'adm_state_pictures') ?>" id="btn-EDIT" name=EDIT class=button onClick="Images(<?= $id ?>);"></TD></TR>';
            str = str + '</table>';
            document.getElementById('h_images').innerHTML = str;
            return;
        }
    </script>
    <br>
    <table cellpadding=1 cellspacing=1 border="0">
        <tr>
            <td name="h_images" id="h_images">
            </td>
        </tr>
    </table>
    <script>
        InsertGif();
    </script>
<?php
} ?>
</form>
</body>
