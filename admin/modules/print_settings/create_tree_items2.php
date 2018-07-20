<?php
$sql = OFFICE_SQLSERVER . "." . OFFICEDB . ".dbo.sp_executesql N'
        select count(*) as legacy
        from
            [doccategory] [dc],
            [settings].[printform] [spf]
                left outer join [tour] [t] ON [spf].[tour] = [t].[inc]
                left outer join [state] [s] ON [spf].[state] = [s].[inc]
                left outer join [contracttype] [c] ON [spf].[contracttype] = [c].[inc]
        where
            [dc].[inc] = [spf].[doccategory]
            AND [spf].[legacy_form_name] like ''%.tpl''
    '"; $result = $db->fetchOne($sql); if ($result) { create_item('print_settings'); } 