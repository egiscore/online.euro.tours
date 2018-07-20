{if $spos}
<table class="res">
    <thead>
        <tr>
            <th class="c">##LAST_SPO_NUMBER##</th>
            <th class="c">##LAST_SPO_CDATE##</th>
            <th class="c">##LAST_SPO_CHECKIN_FROM##</th>
            <th class="c">##LAST_SPO_CHECKIN_TILL##</th>
            <th>##LAST_SPO_SPONOTE##</th>
            <th>##LAST_SPO_CATALOGNOTE##</th>
            <th class="c">##LAST_SPO_FILES##</th>
        </tr>
    </thead>
    <tbody>
    {foreach from=$spos item="spo"}
        <tr class="{cycle values="even,odd"}">
            <td class="spo c" data-spog="{$spo.Inc}" data-date-start="{$spo.DateBeg|date_format:"sql"}" data-date-end="{$spo.DateEnd|date_format:"sql"}"><div class="sponum link">{$spo.FullNumber}</div></td>
            <td class="c">{$spo.SpoDate}</td>
            <td class="c">{$spo.DateBeg}</td>
            <td class="c">{$spo.DateEnd}</td>
            <td>{$spo.SpoNote}</td>
            <td>{$spo.CatalogNote}</td>
            <td class="c">{$spo.FullNumber|spo2link:"xls"} {$spo.FullNumber|spo2link:"doc"} {$spo.FullNumber|spo2link:"xml"} {$spo.FullNumber|spo2link:"rar"} {$spo.FullNumber|spo2link:"zip"}</td>
        </tr>
    {/foreach}
    </tbody>
</table>
{else}
    ##NO_DATA##
{/if}