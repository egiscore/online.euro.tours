<?php
$dirname = $folder_site . '/admin/modules/town/lang'; include $folder_site . '/admin/includes/site/load_messages.php'; $_ACCESS_TOWN = get_module_permission('show_town'); if (1 == $_ACCESS_TOWN) { $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'
        select
            t.inc as TownInc,
            t.name as TownName,
            t.lname as TownLName
        from
            dbo.town t
        where
            t.region = @region
        order by TownName

    ', N'@region INT', %d"; $sql = $db->formatQuery($sql, array($regioninc)); if (false !== ($res = $db->fetchAll($sql))) { foreach ($res as $row) { if ($LNG == 'rus') { $name = $row['TownName']; } else { $name = $row['TownLName']; } echo "['" . htmlspecialchars($name, ENT_QUOTES, 'cp1251') . "', '?TOWNINC=" . $row['TownInc'] . "', 'admin_for_show_town',"; echo "],"; } } } 