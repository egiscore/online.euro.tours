<?php
 function get_online_tour_config($db = false) { if (!$db) { $db = Samo_Registry::get('db'); } $sql = sprintf( OFFICE_SQLSERVER . '.' . OFFICEDB . ".dbo.sp_executesql
    N'
        SELECT
            [What]
            ,[Value]
        FROM
            (
                SELECT
                    [otc].[What]
                    ,[otc].[Value]
                    ,ROW_NUMBER() OVER (PARTITION BY [otc].[What] ORDER BY [otc].[user_code] DESC) AS [Sort]
                    ,[otc].[Inc]
					, user_code
                FROM
                    [dbo].[online_tour_config] [otc]
                WHERE
                    [otc].[Tour] IS NULL AND [otc].[State] IS NULL AND [otc].[TownFrom] IS NULL
                    AND [otc].[Section] = @Section
                    AND ((@UserCode IS NOT NULL AND [otc].[user_code] = @UserCode) OR [otc].[user_code] IS NULL)
            ) [s]
        WHERE
            [s].[Sort] = 1
    ', N'@UserCode INT, @Section VARCHAR(64)', %d, '%s'", (isset($_REQUEST['INTERNET_USER']) ? $_REQUEST['INTERNET_USER'] : INTERNET_USER), 'online_config' ); $qres = $db->fetchAll($sql); $dataset = []; foreach ($qres as $row) { $dataset[$row['What']] = $row['Value']; } return $dataset; } 