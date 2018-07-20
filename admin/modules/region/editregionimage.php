<?php
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/properties.php'; include_once _ROOT . 'admin/properties.php'; include_once _ROOT . 'includes/admin.php'; _admin_auth_(); extract($_POST); extract($_FILES); $REGIONINC = (isset($_POST['REGIONINC']) && $tmp = intval($_POST['REGIONINC'])) ? $tmp : ((isset($_GET['REGIONINC']) && $tmp = intval($_GET['REGIONINC'])) ? $tmp : 0); $LNG = (isset($_GET['LNG'])) ? $_GET['LNG'] : 'rus'; foreach (array('messages_' . $LNG . '.php', 'message_rus.php') as $file) { $file = 'lang/' . $file; if (file_exists($file)) { include_once $file; } } include_once _ROOT . 'admin/includes/site/function.php'; $dirname = _ROOT . 'admin/includes/site/lang'; include _ROOT . 'admin/includes/site/load_messages.php'; $dirname = _ROOT . 'admin/includes/lang'; include _ROOT . 'admin/includes/site/load_messages.php'; include_once _ROOT . '/admin/includes/functions.php'; ?>
<HTML>
<HEAD>
    <TITLE><?= Get_Message_Lang($LNG, 'adm_region_pictures') ?></TITLE>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1251">
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <?= style_css() ?>
</HEAD>
<body>
<script language="JavaScript">
    function Init() {
        clearPreloadPage();
    }
    var pt = false;
    function Close() {
        window.opener.hotel_gif = hotel_gif_in_editimages;
        window.opener.InsertGif();
        window.close();
    }
    ;

    function retImage(cId) {
        var p = 1;

        if (imgurlinput.style.visibility == "visible")
            pt = document.selpic.imgurl.value;

        window.opener.insImage(cId, pt);
        window.close();
    }
    ;

    function SaveTxt() {
        document.txtform.img.value = document.selpic.imgs.value;
        document.txtform.submit();
    }

    function Save() {
        if (document.imgform.picture_big.value == '') {
            alert("<?= Get_Message_Lang($LNG, 'adm_region_big_picture'); ?>");
        } else {
            document.imgform.IMAGE_TEXT.value = document.txtform.IMAGE_TEXT.value;
            document.imgform.submit();
        }
    }

    function imagesChange() {
        Idx = document.forms["selpic"].elements["imgs"].selectedIndex;
        if (Idx != -1)
            pt = document.forms["selpic"].elements["imgs"].options[Idx].value;
        else
            pt = 1;
        if (pt != 1) {
            i = pt.indexOf("|");
            pt1 = pt.substring(0, i);
            pt2 = pt.substring(i + 1, 1000);
            document.forms["selpic"].prev.src = "../../../data/region/" + pt1;
            document.forms["selpic"].prev.style.visibility = "visible";
            document.txtform.IMAGE_TEXT.value = pt2;
        }
    }
</script>
<?php
$url = WWWROOT . "data/region"; if (isset($img) and isset($IMAGE_TEXT)) { $npic = substr($img, strlen($REGIONINC) + 4, 2); if (file_exists(_ROOT . 'data/region/' . $REGIONINC . '_txt' . $npic . '.php')) { unlink(_ROOT . 'data/region/' . $REGIONINC . '_txt' . $npic . '.php'); } save_to_file(_ROOT . 'data/region/' . $REGIONINC . '_txt' . $npic . '.php', $IMAGE_TEXT); } if (isset($_FILES["picture_big"])) { for ($i = 1; $i <= 50; $i++) { $npic = str_pad($i, 2, '0', STR_PAD_LEFT); if (!file_exists(_ROOT . 'data/region/' . $REGIONINC . '_gif' . $npic . '.gif')) { break; } } if ($big = move_uploaded_file($_FILES["picture_big"]['tmp_name'], _ROOT . 'data/region/' . $REGIONINC . '_jpg' . $npic . '.jpg')) { chmod(_ROOT . 'data/region/' . $REGIONINC . '_jpg' . $npic . '.jpg', 0644); if (!empty($_FILES["picture"]) && move_uploaded_file($_FILES["picture"]['tmp_name'], _ROOT . 'data/region/' . $REGIONINC . '_gif' . $npic . '.gif')) { chmod(_ROOT . '/data/region/' . $REGIONINC . '_gif' . $npic . '.gif', 0644); } else { include_once _ROOT . 'vendor/thumbnail/class.thumbnail.php'; $thumbnail = new Thumbnail(); $thumbnail->output(_ROOT . 'data/region/' . $REGIONINC . '_jpg' . $npic . '.jpg', _ROOT . 'data/region/' . $REGIONINC . '_gif' . $npic . '.gif', array('width' => 100, 'height' => 75)); } } if (file_exists(_ROOT . 'data/region/' . $REGIONINC . '_txt' . $npic . '.php')) { unlink(_ROOT . 'data/region/' . $REGIONINC . '_txt' . $npic . '.php'); } save_to_file(_ROOT . 'data/region/' . $REGIONINC . '_txt' . $npic . '.php', $IMAGE_TEXT); } if (isset($_POST['imgs'])) { $npic = substr($imgs, strlen($REGIONINC) + 4, 2); @unlink(_ROOT . 'data/region/' . $REGIONINC . '_gif' . $npic . '.gif'); @unlink(_ROOT . 'data/region/' . $REGIONINC . '_jpg' . $npic . '.jpg'); @unlink(_ROOT . 'data/region/' . $REGIONINC . '_txt' . $npic . '.php'); } $d = dir(_ROOT . 'data/region'); $formdata = array(); $urlfound = false; while ($entry = $d->read()) { if (preg_match("~^[\d]+_(gif|jpg)~", $entry) and (substr($entry, 0, strlen($REGIONINC)) == $REGIONINC)) { $str = strrchr(WWWROOT . 'data/region/' . $entry, '/'); array_push($formdata, substr($str, 1)); } } $d->close(); $hotel_gif = "<script>\r\n"; $hotel_gif .= 'var hotel_gif_in_editimages = new Array('; $fl = 0; for ($i = 1; $i <= 20; $i++) { if ($i < 10) { $ii = '0' . $i; } else { $ii = $i; } if (file_exists(_ROOT . 'data/region/' . $REGIONINC . '_gif' . $ii . '.gif') and file_exists(_ROOT . 'data/region/' . $REGIONINC . '_jpg' . $ii . '.jpg')) { $fl = 1; $hotel_gif .= '"' . WWWROOT . 'data/region/' . $REGIONINC . '_gif' . $ii . '.gif",'; $hotel_gif .= '"' . WWWROOT . 'data/region/' . $REGIONINC . '_jpg' . $ii . '.jpg",'; $str = ''; if (file_exists(_ROOT . 'data/region/' . $REGIONINC . '_txt' . $ii . '.php')) { $str = file_get_contents(_ROOT . 'data/region/' . $REGIONINC . '_txt' . $ii . '.php'); } $hotel_gif .= '"' . $str . '",'; } } if ($fl == 1) { $hotel_gif = substr($hotel_gif, 0, strlen($hotel_gif) - 1); } $hotel_gif .= ");\r\n"; $hotel_gif .= "var hotel_gif_increment = 3;\r\n"; $hotel_gif .= "\r\n</script>"; echo $hotel_gif; ?>

<form name="selpic" action="" method="post">
    <input type="hidden" name="page" value="<?=$ALIAS?>">
    <input type="hidden" name="LNG" id="LNG" value="<?= $LNG ?>">
    <input type="hidden" name="REGIONINC" value="<?= $REGIONINC ?>">
    <table border=0 cellpadding=1 cellspacing=1 width="100%">
        <TR>
            <TD class="capt1 border_dark" valign="top" NOWRAP style="width: 150px;">
                <select name='imgs' size=14 style="width:100%" onChange="imagesChange();">
                    <?php
 if ($formdata) { sort($formdata); $size = count($formdata); for ($i = 0; $i < $size; $i++) { $npic = substr($formdata[$i], strlen($REGIONINC) + 4, 2); if (file_exists(_ROOT . 'data/region/' . $REGIONINC . '_txt' . $npic . '.php')) { $str = file_get_contents(_ROOT . 'data/region/' . $REGIONINC . '_txt' . $npic . '.php'); } else { $str = ''; } ?>
                            <option value="<?= $formdata[$i] . '|' . $str?>">
                                <?= $formdata[$i];?>
                            </option>
                        <?php
 } } ?>
                </select>
                <br>
                <TABLE border=0 cellspacing=1 cellpadding=1>
                    <tr>
                        <td>
                            <script>
                                function DelFile() {
                                    document.selpic.submit();
                                }
                            </script>
                            <input type="button" class="button"
                                   value="<?= Get_Message_Lang($LNG, 'adm_delete_botton') ?>"
                                   title="<?= Get_Message_Lang($LNG, 'adm_region_delete_file') ?>"
                                   onClick="DelFile();">
                        </td>
                        <td>
                            <INPUT type="button" class="button" value="<?= Get_Message_Lang($LNG, 'adm_region_close')?>" onclick="Close();">
                        </td>
                    <tr>
                </table>
            </TD>
            <td class="capt1 border_dark" valign="top">
                <TABLE border=0 cellspacing=1 cellpadding=1 width="100%">
                    <TR>
                        <TD valign="top" class="capt1 border_dark" height="231">
                            <IMG border="1" id="prev" style="visibility: hidden; max-height: 227px; max-width: 363px;">
                        </TD>
                    </tr>
                    <tr>
                        <TD id="ImgInfo" class="capt1 border_dark" valign="top" width="100%">
                        </TD>
                    </TR>
</form>
<tr>
    <td class="capt border_dark" style="padding: 3px;">
        <form name="txtform" method="post" action="">
            <input type="hidden" name="page" value="<?=$ALIAS?>">
            <input type="hidden" name="LNG" id="LNG" value="<?= $LNG ?>">
            <input type="hidden" name="img" value="">
            <input type="hidden" name="REGIONINC" value="<?= $REGIONINC ?>">
            &nbsp;<?= Get_Message_Lang($LNG, 'adm_region_picture_text') ?><br>
            &nbsp;<input type="text" name="IMAGE_TEXT" size="35" maxlength="2000" value="">
            &nbsp;<input type="button" name="CHANGETEXT" class="button" value="<?= Get_Message_Lang($LNG, 'adm_region_change'); ?>" onClick="SaveTxt();">
        </form>
    </td>
</tr>
</TABLE>
</td>
</TR>
<tr>
    <td class="capt1 border_dark" colspan=2 valign=center>
        <form name="imgform" method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="page" value="<?=$ALIAS?>">
            <input type="hidden" name="LNG" id="LNG" value="<?= $LNG ?>">
            <input type="hidden" name="REGIONINC" value="<?= $REGIONINC ?>">
            <input type="hidden" name="IMAGE_TEXT" value="">
            <table border=0>
                <tr>
                    <td class=txt>
                        <div
                            style="margin-bottom: 3px; font-size: 75%;"><?= Get_Message_Lang($LNG, 'adm_region_little_gif') ?></div>
                        <input type="file" class=element name="picture">&nbsp;
                    </td>
                    <td class=txt>
                        <div
                            style="margin-bottom: 3px; font-size: 75%;"><?= Get_Message_Lang($LNG, 'adm_region_big_jpeg') ?></div>
                        <input type="file" class=element name="picture_big">&nbsp;
                    </td>
                    <td class=txt rowspan="2" style="vertical-align: bottom; padding-left: 35px;">
                        <input type="button" name="Button" class="button" value="<?= Get_Message_Lang($LNG, 'adm_region_download')?>" onClick="Save();">
                    </td>
                </tr>
            </table>
        </form>
    </td>
</tr>
</table>
<script>
    imagesChange();
</script>
</body>
</html>