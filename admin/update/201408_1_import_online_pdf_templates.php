<?php
 class Import_Online_Pdf_Templates extends UpdateModel { var $title = 'Импорт старых шаблонов и настроек в Settings.PrintForm'; function make() { $dirs = array( 'agreement' => 'data/agreement', 'aviaticket_cost' => 'data/aviaticket_cost', 'booklet' => 'data/booklet', 'confirmation' => 'data/confirmation', 'invoice' => 'data/invoice', ); $files = array(); foreach ($dirs as $module => $dir) { foreach (glob(_ROOT . $dir . '/*') as $file) { $file = pathinfo($file); if (!isset($file['extension']) || !in_array($file['extension'], array('tpl', 'fpdf'))) { continue; } $key = array(); $key[] = $file['module'] = $module; $parts = explode('_', $file['filename']); switch ($module) { case 'agreement': $key[] = $file['partner'] = (isset($parts[1]) && intval($parts[1])) ? intval($parts[1]) : null; $key[] = $file['x1'] = intval($parts[0]) ? intval($parts[0]) : null; break; case 'aviaticket_cost': $key[] = $file['partner'] = intval($parts[0]) ? intval($parts[0]) : null; break; case 'booklet': $key[] = $file['x1'] = ('state' == $parts[0] && isset($parts[1]) && intval($parts[1])) ? intval($parts[1]) : null; $key[] = $file['tour'] = intval($parts[0]) ? intval($parts[0]) : null; break; case 'confirmation': $key[] = $file['tour'] = intval($parts[0]) ? intval($parts[0]) : null; break; case 'invoice': $key[] = $file['x1'] = intval($parts[0]) ? intval($parts[0]) : null; break; } $file['key'] = $key = implode('~', $key); if (('tpl' == $file['extension']) && isset($files[$key])) { continue; } $files[$key] = $file; } } $sql = ''; $sql .= "
    set nocount on

    declare @def int, @lim int
    set @def = -2147483647
    set @lim = 74

    declare @log table ([info] varchar(max))

    declare @tpl table (
        module varchar(255),
        partner int not null,
        tour int not null,
        x1 int not null,
        tpl varchar(255),
        doccategory int null
        primary key (
            module, partner, tour, x1
        )
    )

    insert into @tpl (module, partner, tour, x1, tpl)
    select
        tpl.module,
        (case when tpl.module in ('agreement','aviaticket','insurance','voucher') then isnull(tpl.partner,@def) else @def end),
        isnull(tpl.tour,@def),
        isnull(convert(int,tpl.x1),@def),
        (case when CHARINDEX('samo://', tpl.tpl) = 1 then tpl.tpl else tpl.tpl + '.fpdf' end)
    from
        online_pdf_templates tpl
            left outer join tour tr on tr.inc = tpl.tour
    where
        (isnull(tpl.tour, @def) = @def or tr.inc is not null)
        and
        (tpl.x1 is null or isnumeric(tpl.x1) = 1)
        and
        tpl.tpl != '-2147483647'

    INSERT INTO @log SELECT 'source ' + convert(varchar,@@ROWCOUNT) + ' records'
"; if (count($files)) { $sql_parts = array(); foreach ($files as $key => $file) { $this->info('found file ' . $file['basename'] . ' [' . $file['module'] . ']'); $sql_parts[] = $this->db->formatQuery("SELECT %s AS [m], %d AS [p], %d AS [t], %s AS [x], %s AS [tpl]", array( $file['module'], (isset($file['partner']) && $file['partner']) ? $file['partner'] : -2147483647, (isset($file['tour']) && $file['tour']) ? $file['tour'] : -2147483647, (isset($file['x1']) && $file['x1']) ? $file['x1'] : -2147483647, $file['basename'], )); } $sql_parts = implode(PHP_EOL . 'UNION' . PHP_EOL, $sql_parts); $sql .= "
    INSERT INTO @tpl ([module], [partner], [tour], [x1], [tpl])
    SELECT * FROM (
" . $sql_parts . "
    ) [s]
    WHERE NOT EXISTS(
        SELECT * FROM @tpl WHERE [module] = [s].[m] AND [partner] = [s].[p] AND [tour] = [s].[t] AND [x1] = [s].[x]
    )

    INSERT INTO @log SELECT 'add ' + convert(varchar,@@ROWCOUNT) + ' records from files'
"; } $sql .= "
    --select * from @tpl

    DELETE FROM @tpl
    FROM @tpl [t]
    WHERE [t].[partner] != @def AND NOT EXISTS(SELECT * FROM [dbo].[partner] [s] WHERE [s].[inc] = [t].[partner])

    INSERT INTO @log SELECT 'delete ' + CONVERT(VARCHAR,@@ROWCOUNT) + ' records because of bad partner'

    DELETE FROM @tpl
    FROM @tpl [t]
    WHERE [t].[module] = 'booklet' AND [t].[x1] != @def AND NOT EXISTS(SELECT * FROM [dbo].[state] [s] WHERE [s].[inc] = [t].[x1])

    INSERT INTO @log SELECT 'delete ' + CONVERT(VARCHAR,@@ROWCOUNT) + ' records because of bad state'

    DELETE FROM @tpl
    FROM @tpl [t]
    WHERE [t].[tour] != @def AND NOT EXISTS(SELECT * FROM [dbo].[tour] [s] WHERE [s].[inc] = [t].[tour])

    INSERT INTO @log SELECT 'delete ' + CONVERT(VARCHAR,@@ROWCOUNT) + ' records because of bad tour'

    DELETE FROM @tpl
    FROM @tpl [t]
    WHERE [t].[module] = 'insurance' AND [t].[x1] != @def AND NOT EXISTS(SELECT * FROM [dbo].[inszone] [s] WHERE [s].[inc] = [t].[x1])

    INSERT INTO @log SELECT 'delete ' + CONVERT(VARCHAR,@@ROWCOUNT) + ' records because of bad inszone'

    DELETE FROM @tpl
    FROM @tpl [t]
    WHERE [t].[module] = 'invoice' AND [t].[x1] != @def AND NOT EXISTS(SELECT * FROM [dbo].[contracttype] [s] WHERE [s].[inc] = [t].[x1])

    INSERT INTO @log SELECT 'delete ' + CONVERT(VARCHAR,@@ROWCOUNT) + ' records because of bad contracttype'

    DELETE FROM @tpl
    FROM @tpl [t]
    WHERE
        CHARINDEX('samo://', [t].[tpl]) = 1
        AND NOT EXISTS(SELECT * FROM [PrintForm].[Items] [s] WHERE [s].[inc] = CONVERT(INT,SUBSTRING([t].[tpl], 8, 1000)))

    INSERT INTO @log SELECT 'delete ' + CONVERT(VARCHAR,@@ROWCOUNT) + ' records because of bad PrintForm'

    --select * from @tpl

    INSERT INTO @log SELECT 'collapse [x1]'

    insert into @tpl (module, partner, tour, x1, tpl)
    select distinct module, partner, tour, @def, tpl
    from (
        select
            *
            ,COUNT(*) OVER (PARTITION BY module, partner, tour) AS ca
            ,COUNT(*) OVER (PARTITION BY module, partner, tour, tpl) AS ct
        from
            @tpl
    ) s
    where
        100.0 * ct / ca > @lim
        and not exists(
            select * from @tpl t where t.module = s.module and t.partner = s.partner and t.tour = s.tour and t.x1 = @def
        )

    INSERT INTO @log SELECT 'add ' + convert(varchar,@@ROWCOUNT) + ' records with default [x1]'

    delete from @tpl
    from @tpl s
    where
        s.x1 != @def
        and exists (
            select * from @tpl t where t.module = s.module and t.partner = s.partner and t.tour = s.tour and t.x1 = @def and t.tpl = s.tpl
        )

    INSERT INTO @log SELECT 'remove ' + convert(varchar,@@ROWCOUNT) + ' records with specific [x1]'

    --select * from @tpl

    INSERT INTO @log SELECT 'collapse [tour]'

    insert into @tpl (module, partner, tour, x1, tpl)
    select distinct module, partner, @def, x1, tpl
    from (
        select
            *
            ,COUNT(*) OVER (PARTITION BY module, partner) AS ca
            ,COUNT(*) OVER (PARTITION BY module, partner, x1, tpl) AS ct
        from
            @tpl
    ) s
    where
        100.0 * ct / ca > @lim
        and not exists(
            select * from @tpl t where t.module = s.module and t.partner = s.partner and t.tour = @def and t.x1 = s.x1
        )

    INSERT INTO @log SELECT 'add ' + convert(varchar,@@ROWCOUNT) + ' records with default [tour]'

    delete from @tpl
    from @tpl s
    where
        s.tour != @def
        and exists (
            select * from @tpl t where t.module = s.module and t.partner = s.partner and t.tour = @def and t.x1 = s.x1 and t.tpl = s.tpl
        )

    INSERT INTO @log SELECT 'remove ' + convert(varchar,@@ROWCOUNT) + ' records with specific [tour]'

    --select * from @tpl

    INSERT INTO @log SELECT 'collapse [partner]'

    insert into @tpl (module, partner, tour, x1, tpl)
    select distinct module, @def, tour, x1, tpl
    from (
        select
            *
            ,COUNT(*) OVER (PARTITION BY module) AS ca
            ,COUNT(*) OVER (PARTITION BY module, tour, x1, tpl) AS ct
        from
            @tpl
    ) s
    where
        100.0 * ct / ca > @lim
        and not exists (
            select * from @tpl t where t.module = s.module and t.partner = @def and t.tour = s.tour and t.x1 = s.x1
        )

    INSERT INTO @log SELECT 'add ' + convert(varchar,@@ROWCOUNT) + ' records with default [partner]'

    delete from @tpl
    from @tpl s
    where
        s.partner != @def
        and exists (
            select * from @tpl t where t.module = s.module and t.partner = @def and t.tour = s.tour and t.x1 = s.x1 and t.tpl = s.tpl
        )

    INSERT INTO @log SELECT 'remove ' + convert(varchar,@@ROWCOUNT) + ' records with specific [partner]'

    --select * from @tpl

    UPDATE @tpl SET
        [doccategory] =
            CASE [module]
                WHEN 'invoice' THEN 1
                WHEN 'insurance' THEN 3
                WHEN 'voucher' THEN 4
                WHEN 'agreement' THEN 5
                WHEN 'claim_act' THEN 6
                WHEN 'aviaticket_cost' THEN 7
                WHEN 'aviaticket' THEN 8
                WHEN 'anketa' THEN 9
                WHEN 'booklet' THEN 10
                WHEN 'confirmation' THEN 11
                WHEN 'warrant' THEN 16
                WHEN 'agreement_person' THEN 17
                ELSE NULL
            END

    DELETE FROM @tpl WHERE [doccategory] IS NULL

    INSERT INTO @log SELECT 'delete ' + CONVERT(VARCHAR,@@ROWCOUNT) + ' records because of bad doccategory'

    --select * from @tpl

    INSERT INTO Settings.PrintForm ([doccategory], [partner], [state], [tour], [inszone], [contracttype], [agreement_year], [print_form_inc], [legacy_form_name])
    SELECT
        [doccategory]
        ,NULLIF([partner],@def) AS [partner]
        ,(CASE [module] WHEN 'booklet' THEN NULLIF([x1], @def) ELSE NULL END) AS [state]
        ,NULLIF([tour],@def) AS [tour]
        ,(CASE [module] WHEN 'insurance' THEN NULLIF([x1], @def) ELSE NULL END) AS [inszone]
        ,(CASE [module] WHEN 'invoice' THEN NULLIF([x1], @def) ELSE NULL END) AS [contracttype]
        ,(CASE [module] WHEN 'agreement' THEN NULLIF([x1], @def) ELSE NULL END) AS [agreement_year]
        ,(CASE WHEN CHARINDEX('samo://', [tpl]) = 1 THEN CONVERT(INT,SUBSTRING([tpl], 8, 1000)) ELSE NULL END) AS [print_form_inc]
        ,(CASE WHEN CHARINDEX('samo://', [tpl]) = 1 THEN NULL ELSE [tpl] END) AS [legacy_form_name]
    FROM
        @tpl

    INSERT INTO @log SELECT 'add ' + convert(varchar,@@ROWCOUNT) + ' records to Settings.PrintForm'

    SELECT * FROM @log

    EXEC dbo.sp_rename 'online_pdf_templates', '_ToBeDropped_online_pdf_templates'

    EXEC up_repl_execOnlineSamo N'
        IF EXISTS(SELECT * FROM sys.objects WHERE [name] = ''online_pdf_templates'' AND [type] = ''U'')
            AND NOT EXISTS(SELECT * FROM sys.columns WHERE [object_id] = OBJECT_ID(''online_pdf_templates'') AND [is_identity] = 1)
        BEGIN
            DROP TABLE [dbo].[online_pdf_templates]
        END
    '
"; $sql = "
IF EXISTS(SELECT * FROM sys.objects WHERE [name] = 'online_pdf_templates')
BEGIN " . $sql . " END
"; $sql = $this->db->formatQuery("EXEC " . $this->OFFICEDB . ".dbo.sp_executesql N%s", array($sql)); $res = $this->db->query($sql); while ($row = $this->db->fetchRow($res)) { $this->info($row['info']); } $this->info($sql); return 0; } public function info($str = null) { static $info = array(); if ($str) { $info[] = $str; } return implode('<br>', $info); } } 