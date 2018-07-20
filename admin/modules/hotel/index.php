<?php get_help_button('onlinest:sistema_upravlenija:hotel_catalog')?>
<?php
 $fields = array( 'description' => array(Get_Message_Lang($LNG, 'hotel_param_description'), '10;350;395;560'), 'meal' => array(Get_Message_Lang($LNG, 'hotel_param_meal'), '8;215;395;230'), 'note' => array(Get_Message_Lang($LNG, 'hotel_param_note'), '10;566;395;610'), 'location' => array(Get_Message_Lang($LNG, 'hotel_param_location'), '8;230;395;245'), 'transfer' => array(Get_Message_Lang($LNG, 'hotel_param_transfer'), '8;245;395;325') ); $params = array(); $attr = array('field' => array()); $res = $db->exec(OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_hotel_param', array(), true); if ($db->numRows($res)) { $icons = array(); while ($row = $db->fetchRow($res)) { foreach (array_keys($attr) as $t) { if (isset($row[$t]) && $row[$t]) { if ($t == 'field') { $attr[$t][$row['inc']] = $row['field']; } } } $params[] = $row; } } $params_room = [ 'Section' => 'hotels', 'What' => 'SHOW_ROOMS_IN_HOTEL', ]; if (isset($_POST['SAVE'])) { if (isset($_POST['SHOW_ROOMS_IN_HOTEL'])) { $params_room['Value'] = $_POST['SHOW_ROOMS_IN_HOTEL']; } } $sql_room = $db->formatExec('<OFFICEDB>.dbo.up_WEB_3_ADMIN_tour_config', $params_room); $res_room = $db->fetchRow($sql_room); $SHOW_ROOMS_IN_HOTEL = ($res_room) ? $res_room['Value'] : ''; if (isset($_POST['SAVE'])) { foreach (array_keys($attr) as $t) { if (!empty($_POST[$t])) { if (array_flip($_POST[$t]) != $attr[$t]) { $ids = array(); foreach ($_POST[$t] as $key => $row) { if (is_numeric($row)) { $ids[] = intval($row); $db->exec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_hotel_param', array( 'What' => $row, 'Value' => $t == 'sort' ? ($key + 1) : ($t == 'field' ? ($key) : '1'), 'Section' => $t ) ); } } $db->exec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_hotel_param', array( 'What' => $t, 'Section' => $t, 'Clear' => implode(',', $ids) ) ); } } else { $db->exec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.up_WEB_3_ADMIN_hotel_param', array( 'Section' => $t, 'Clear' => 'all' ) ); } } admin_flash(Get_Message_Lang($LNG, 'adm_success_save')); header('Location: ' . $_SERVER['REQUEST_URI'] . '?page=' . $ALIAS . '&LNG=' . $LNG, true, 301); } else { if (isset($_SESSION['hotel_param'])) { echo '<div style="margin-bottom: 10px;">' . $_SESSION['hotel_param'] . '</div>'; unset($_SESSION['hotel_param']); } ?>
<?=style_css()?>
<style>
    table.txt td {
        padding: 3px;
    }
</style>
<?= admin_flash() ?>

<form method="POST" id="my-form">
    <input type="hidden" name="page" value="<?=$ALIAS?>">
    <input type="hidden" name="LNG" value="<?=$LNG?>">
    <?= Get_Message_Lang($LNG, 'hotel_show_rooms') ?>
    <select name="SHOW_ROOMS_IN_HOTEL" style="margin-bottom: 10px;">
        <option
                value="0" <?= ($SHOW_ROOMS_IN_HOTEL ? '' : 'selected="selected"') ?>><?= Get_Message_Lang($LNG, 'adm_config_no') ?></option>
        <option
                value="1" <?= ($SHOW_ROOMS_IN_HOTEL ? 'selected="selected"' : '') ?>><?= Get_Message_Lang($LNG, 'adm_config_yes') ?></option>
    </select>
    <input type="hidden" name="LNG" value="<?= $LNG ?>" >
    <table id="hotel_param" class="txt">
        <thead>
            <tr>
                <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'hotel_param_field') ?></td>
                <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'hotel_param_field_samotour') ?></td>
            </tr>
        </thead>
        <tbody>
        <?php
 foreach ($fields as $key => $row) { ?>
            <tr data-size="<?= $row[1] ?>" >
                <td class="title">
                    <?= $row[0] ?>
                </td>
                <td>
                    <select class="element" name="field[<?= $key ?>]" >
                        <option value="">---</option>
                        <?php
 foreach ($params as $_row) { ?>
                            <option value="<?= $_row['inc'] ?>" <?= (isset($_row['field']) && ($key == $_row['field'])) ? 'selected="selected"' : '' ?>>
                                <?= $_row['name'] ?>
                            </option>
                        <?php
 } ?>
                    </select>
                </td>
            </tr>
        <?php
 } ?>
        </tbody>
    </table>
    <br clear="all">
    <input type="submit" name="SAVE" class="button" value="<?= Get_Message_Lang($LNG, 'adm_save_botton') ?>"/>
</form>
<div id="template-preview">
    <img src="<?= WWWROOT ?>admin/files/img/hotels.jpg"/>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(window).load(function(){
            $.each($('#hotel_param thead td, #hotel_param tbody td select'), function(i, v) {
		$(v).width($(v).width());
	    });
	    var options = [];
	    $.each($("#hotel_param select[name^='field']"), function(i, v) {
		$(v).attr('data-value', $(v).val());
	    });
	    $.each($("#hotel_param select[name^='field']:first option"), function(i, v) {
		if ($(v).val()!='') {
		    options[$(v).val()+'_v'] = $(v).html();
		}
	    });
	    $("#hotel_param select[name^='field']").change(function() {
		$(this).attr('data-value', $(this).val());
		$.each($("#hotel_param select[name^='field']"), function(i, v) {
		    var val = $(v).val();
		    $(v).attr('data-value', val).empty().append('<option value="">---</option>');
		    for (var index in options) {
			var value = options[index];
			var index = parseInt(index);
			if (!$("#hotel_param select[data-value='"+index+"']").length || val == index) {
			    $(v).append('<option value="'+index+'">'+value+'</option>');
			}
		    };
		    $(v).val(val).attr('disabled', $(v).find('option').length<=1);
		});
	    });
	    $("#template-preview").show();
	    var prevWidth = $("#template-preview img").width();
	    var prevHeight = $("#template-preview img").height();
	    $("#template-preview").hide();
	    $("#hotel_param tbody tr td").mouseenter(function() {
		var margin = 0;
		var width = $(document).width()-$('#hotel_param').outerWidth(true)-20
		if (width > prevWidth) {
		    margin = width - prevWidth;
		    width = prevWidth;
		}
		var k = width/prevWidth;
		var size = $(this).parents('tr:first').data('size').split(';');
		$("#template-preview").removeClass('hide').css({ top: 0, right: 0 }).show().find('img').css({ width: width, marginRight: margin });
		$("#template-preview").append('<div class="my_border" />');
		$("#template-preview .my_border").css({ top: size[1]*k, left: size[0]*k, width: (size[2]-size[0])*k, height: (size[3]-size[1])*k });
		return false;
	    });
	    $("#hotel_param tbody tr td").mouseleave(function() {
		$("#template-preview").addClass('hide');
		setTimeout(function(){
		    if ($("#template-preview").hasClass('hide')) {
			$("#template-preview").hide();
		    }
		}, 500);
		$("#template-preview .my_border").remove();
		return false;
	    });
	    $("#hotel_param select[name^='field']:first").change();
        });
    });
</script>
<?php
 } 