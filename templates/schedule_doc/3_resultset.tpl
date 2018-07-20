{if $RESULT}
<table class="res">
    <thead>
        <tr>
            <th>##FLY_DATE##</th>
            <th>##FREIGHT##</th>
            <th>##TOUR##</th>
            <th>##ARRIVAL##</th>
            <th>##DEPARTURE##</th>
            <th>##DATETIME##</th>
            <th>##NOTE##</th>
        </tr>
    </thead>
    <tbody>
    {foreach from=$RESULT item="doc"}
        <tr class="{cycle values="even,odd"}">
            <td>{$doc.DateBeg}</td>
            <td>{$doc.FreightName}</td>
            <td>{$doc.TourName}</td>
            <td>{$doc.SourceName} ({$doc.SrcPortAlias} {$doc.SrcTime}{if $doc.SrcTimeDelta}<span class="delta">+{$doc.SrcTimeDelta}</span>{/if})</td>
            <td>{$doc.TargetName} ({$doc.TrgPortAlias} {$doc.TrgTime}{if $doc.TrgTimeDelta}<span class="delta">+{$doc.TrgTimeDelta}</span>{/if})</td>
            <td>{$doc.IDate} {$doc.ITime}</td>
            <td>{$doc.Note}</td>
        </tr>
    {/foreach}
    </tbody>
</table>
{else}
    ##NO_DATA##
{/if}