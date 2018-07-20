<table cellpadding=1 cellspacing=1 id="online_field_table">
    <thead>
    <tr>
        <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_field') ?></td>
        <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_field_note') ?></td>
        <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_field_visible') ?></td>
        <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_field_required') ?></td>
        <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_field_editable') ?></td>
        <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_field_sort') ?></td>
        <td class="capt border_dark"><?= Get_Message_Lang($LNG, 'adm_field_category') ?></td>
    </tr>
    </thead>
    <tbody>
    <?php
 $count = 1; foreach ($fields as $group => $flds) { echo '
        <tr >
            <td colspan="7" class="capt1 border_dark">' . $group . '
            </td>
        </tr>'; foreach ($flds as $field) { echo '<tr>'; echo '
                <td class="txt border" >
                    <input type="text" maxlength="255" id="' . $field['Field'] . '_NAME" name="field[' . $field['Field'] . '][Title]" value="' . $field['Title'] . '">
                </td>
            '; echo '
                <td class="txt border" >
                    <textarea type="text" maxlength="255" id="' . $field['Field'] . '_HELP" name="field[' . $field['Field'] . '][HelpAlt]" rows="2">' . $field['HelpAlt'] . '</textarea>
                </td>
            '; foreach ($PROPS as $prop) { if ($prop !== "HelpAlt") { echo '
                        <td class="txt border">
                            <input type="hidden"                                              name="field[' . $field['Field'] . '][' . $prop . ']" value="' . (($field['Immutable'] && ( $ENTITY == 'partpass' || $prop != 'Editable' ) && $field[$prop]) ? '1' : '0') . '">
                            <input type="checkbox" id="' . $field['Field'] . '_' . $prop . '" name="field[' . $field['Field'] . '][' . $prop . ']" value="1" ' . ($field[$prop] ? 'checked' : '') . ' ' . ($field['Immutable'] && ( $ENTITY == 'partpass' || $prop != 'Editable' ) ? 'disabled="disabled"' : '') . '>
                        </td>
                    '; } } echo '
                <td class="txt border" ">
                    <input align="top" class="updown" type="image" src="' . $http_site . 'public/pict/uparrow.png" value="up">
                    <input align="top" class="updown" type="image" src="' . $http_site . 'public/pict/downarrow.png" value="down">
                    <input class="position" type="input" maxlength="2" size="2" id="' . $field['Field'] . '_SORT" name="field[' . $field['Field'] . '][Sort]" value="' . $count . '">
                </td>
            '; echo '
                <td class="txt border">
                    <select id="' . $field['Field'] . '_GROUP" name="field[' . $field['Field'] . '][Group]" value="' . $field['Group'] . '">
            '; foreach ($groups as $_group) { echo '<option value="' . $_group . '" ' . (($field['Group'] == $_group) ? 'selected' : '') . '>' . $_group . '</option>'; } echo '
                    </select>
                </td>
            '; echo '</tr>'; $count++; } } ?>
    </tbody>
</table>
<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {
            $('.updown').click(function (e) {
                e.preventDefault();
                var updown = this.value;
                if (updown == 'up' && $(this).parents('tr').find('select').val() == $(this).parents('tr').prev().find('select').val()) {
                    var val_1 = $(this).nextAll('.position').val();
                    var val_2 = $(this).parents('tr').prev().find('.position').val();
                    $(this).nextAll('.position').val(val_2)
                    $(this).parents('tr').prev().find('.position').val(val_1);
                    $(this).parents('tr').insertBefore($(this).parents('tr').prev());
                }
                if ((updown == 'down') && $(this).parents('tr').find('select').val() == $(this).parents('tr').next().find('select').val()) {
                    var val_1 = $(this).nextAll('.position').val();
                    var val_2 = $(this).parents('tr').next().find('.position').val();
                    $(this).nextAll('.position').val(val_2)
                    $(this).parents('tr').next().find('.position').val(val_1);
                    $(this).parents('tr').next().insertBefore($(this).parents('tr'));
                }
            });
            $('.position').blur(function (e) {
                e.preventDefault();
                if (parseInt($(this).val()) >= parseInt($(this).parents('tr').next().find('.position').val())) {
                    while (parseInt($(this).val()) >= parseInt($(this).parents('tr').next().find('.position').val())) {
                        var obj = $(this).parents('tr').next().find('.position');
                        obj.val(parseInt(obj.val()) - 1);
                        $(this).parents('tr').next().insertBefore($(this).parents('tr'));
                    }
                } else {
                    while (parseInt($(this).val()) <= parseInt($(this).parents('tr').prev().find('.position').val())) {
                        var obj = $(this).parents('tr').prev().find('.position');
                        obj.val(parseInt(obj.val()) + 1);
                        $(this).parents('tr').insertBefore($(this).parents('tr').prev());
                    }
                }
            });
            $('select').change(function (e) {
                e.preventDefault();
                var val = $(this).val();
                $(this).parents('tr').insertBefore($("select [value='" + val + "']:selected").parents('tr').eq(-2));
                if (parseInt($(this).parents('tr').find('.position').val()) >= parseInt($(this).parents('tr').next().find('.position').val())) {
                    while (parseInt($(this).parents('tr').find('.position').val()) >= parseInt($(this).parents('tr').next().find('.position').val())) {
                        $(this).parents('tr').next().insertBefore($(this).parents('tr'));
                    }
                    var obj = $(this).parents('tr').prev();

                } else if (parseInt($(this).parents('tr').find('.position').val()) < parseInt($(this).parents('tr').next().find('.position').val())) {
                    while (parseInt($(this).parents('tr').find('.position').val()) < parseInt($(this).parents('tr').prev().find('.position').val())) {
                        $(this).parents('tr').insertBefore($(this).parents('tr').prev());
                    }
                    var obj = $(this).parents('tr').prev();

                }
                while (obj.find('.position').val() == obj.next().find('.position').val()) {
                    obj.next().find('.position').val(parseInt(obj.next().find('.position').val()) + 1);
                    obj = obj.next();
                }

            });
        });
    })(samo.jQuery);

    window.onload = function () {
        document.getElementById('online_field_table').onclick = function (e) {
            e = (e) ? e : ((window.event) ? window.event : null);
            if (e) {
                var target = (e.target) ? e.target : e.srcElement;
                var is_required = target.id.indexOf('Required') > 0
                var is_visible = target.id.indexOf('Visible') > 0;
                if (is_required || is_visible) {
                    var visible = document.getElementById(target.id.replace('Required', 'Visible'));
                    var required = document.getElementById(target.id.replace('Visible', 'Required'));
                    if (is_visible) {
                        var editable = document.getElementById(target.id.replace('Visible', 'Editable'));
                    } else {
                        var editable = document.getElementById(target.id.replace('Required', 'Editable'));
                    }
                    if (is_visible && !visible.checked) {
                        required.checked = false;
                        editable.checked = false;
                    }
                    if (is_required && !visible.checked) {
                        visible.checked = true;
                    }
                }
            }
        }
    }
</script>
