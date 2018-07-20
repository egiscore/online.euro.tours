<?php
 $dirname = $folder_site . 'admin/modules/region/lang'; include $folder_site . 'admin/includes/site/load_messages.php'; $_ACCESS_REGION = get_module_permission('show_region'); $install_town_module = false; $sql = $db->formatQuery($query['get_module_param'], array('show_town')); if (false !== ($res = $db->fetchAll($sql))) { $install_town_module = true; } $sql = 'exec ' . OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql N'
    select
        r.inc as RegionInc,
        r.name as RegionName,
        r.lname as RegionLName
    from dbo.region r
    where
        r.state = @state
    order by
        RegionName
', N'@state INT', %d"; $sql = $db->formatQuery($sql, array($stateinc)); if (false !== ($res = $db->fetchAll($sql))) { foreach ($res as $row) { $regioninc = $row['RegionInc']; if ($LNG == 'rus') { $name = $row['RegionName']; } else { $name = $row['RegionLName']; } echo "['" . htmlspecialchars($name, ENT_QUOTES, 'cp1251') . "', '?REGIONINC=" . $regioninc . "', 'admin_for_show_region',"; if ($install_town_module == true) { include $folder_site . '/admin/modules/town/cr_items.php'; } echo "],"; } } 