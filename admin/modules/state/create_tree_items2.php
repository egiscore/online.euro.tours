<?php
$install_region_module = false; $sql = $db->formatQuery($query['get_module_param'], array('show_region')); if (false !== ($res = $db->fetchAll($sql))) { $install_region_module = true; } $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'
    select distinct
        s.inc as StateInc,
        s.name as StateName,
        s.lname as StateLName
    from
        [state] [s],
        [tour] [t]
    where
        [s].[inc] > 0
        and [s].[inc] = [t].[state]
        and (
            exists(
                select * from [online_admin_rule] [ar] where [ar].[module] = ''show_state'' and [ar].[user] = " . $USER . "
            )
            or
            " . $USER_IS_ADMIN . " = 1
        )
    order by
        " . ($LNG == 'rus' ? 'StateName' : 'StateLName') . "
'"; if (false !== ($res = $db->fetchAll($sql))) { echo "['" . Get_Message_Lang($LNG, 'adm_catalog') . "', '', 'empty',"; foreach ($res as $row) { $stateinc = $row['StateInc']; if ($LNG == 'rus') { $name = $row['StateName']; } else { $name = $row['StateLName']; } echo "['" . htmlspecialchars($name, ENT_QUOTES, 'cp1251') . "', '?STATEINC=" . $stateinc . "', 'admin_for_show_state',"; if ($install_region_module == true) { include $folder_site . 'admin/modules/region/cr_items.php'; } echo "],"; } echo "],"; } 