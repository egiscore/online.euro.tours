<?php
 function draw_tr_yes_no($fieldname, $select_name, $value, $where, $LNG, $blank = true) { $html = "<tr>
                <td class='capt1 border config_what'>{$fieldname}</td>
                <td class='txt border config_value'>
                    <select name='{$select_name}' class='element'>"; $html .= $blank ? '<option value=""></option>' : ''; $html .= "<option value='1'"; $html .= ($value == 1) ? "selected" : ''; $html .= ">" . Get_Message_Lang($LNG, 'adm_config_yes') . "</option><option value='0'"; $html .= ($value == 0) ? "selected" : ''; $html .= ">" . Get_Message_Lang($LNG, 'adm_config_no') . "</option></select><br>"; echo $html . $where . "</td></tr>"; } 