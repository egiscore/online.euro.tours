<?php
$sql = OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.sp_executesql N'
    select
        [m].[inc],
        case when @lng = ''rus'' then [m].[Name] else [m].[LName] end as [Name],
        [m].[Alias],
        [m].[Path],
        case [m].[path] when ''../editors/'' then 0 ELSE 1 END as [sort]
    from
        [dbo].[online_modules] [m]
', N'@lng VARCHAR(64)', %s"; $sql = $db->formatQuery($sql, array($LNG, $USER, $USER_IS_ADMIN)); $result = ''; if (false !== ($res = $db->fetchAll($sql))) { foreach ($res as $row) { $tmp = explode('_', $row['Alias'], 2); $ral = array_shift($tmp); if ($ral == 'regional') { continue; } $result .= "['" . $row['Name'] . "', '', 'set_rule_for_" . $row['Alias'] . "'],"; } } if ($result) { echo("['" . $name . "', '', 'empty',"); echo($result); if (isset($regional_reports)) { foreach ($regional_reports as $ral => $region) { $name = ($LNG == 'rus') ? $region['name'] : $region['lname']; echo("\r\n['$name', '', 'managers_rules'"); foreach ($region['reports'] as $key => $report) { $name = ($LNG == 'rus') ? $modules[$report]['name'] : $modules[$report]['lname']; if (file_exists($folder_site . '/admin/modules/regional_' . $modules[$report]['folder'] . '/rule.php')) { echo(",\r\n['" . Get_Message_Lang($LNG, 'adm_tree_child') . " " . $name . "', '', 'set_rule_for_regional_" . $report . "?region=" . $ral . "']"); } } echo("],\r\n"); } } echo("],"); } ?>