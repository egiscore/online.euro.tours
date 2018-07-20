{if $freight_time}
<table class="res">
    {assign var="prevt" value=0}
    {foreach from=$freight_time item="ft" key="towninc"}
        {if $prevt != $ft.TownInc}
            <thead>
                {if $show_town}
                <tr><th colspan="12" class="target">{$ft.TownName}</th></tr>
                {/if}
                <tr>
                    <th>##FREIGHT_TIME_DAY_WEEK##</th>
                    <th>##FREIGHT_TIME_DATEBEG##</th>
                    <th>##FREIGHT_TIME_DATEEND##</th>
                    <th>##FREIGHT_TIME_AVIACOMPANY##</th>
                    <th>##FREIGHT_TIME_ARRIVAL_PORT##</th>
                    <th>##FREIGHT_TIME_DEPARTURE_PORT##</th>
                    <th>##FREIGHT_TIME_FREIGHT##</th>
                    <th>##FREIGHT_TIME_SRC_TIME##</th>
                    <th>##FREIGHT_TIME_TRG_TIME##</th>
                    <th>##FREIGHT_TIME_SRC_TIME_BACK##</th>
                    <th>##FREIGHT_TIME_TRG_TIME_BACK##</th>
                    <th>##FREIGHT_TIME_TRANTYPE##</th>
                </tr>
            </thead>
        {/if}
        {assign var="prevt" value=$ft.TownInc}
        <tr class="{cycle values="even,odd"}">
            <td>{$ft.fdatebeg|date_format:"l"}</td>
            <td>{$ft.fdatebeg}</td>
            <td>{$ft.fdateend}</td>
            <td>{$ft.PartnerName}</td>
            <td>{$ft.DSrcPortAlias}</td>
            <td>{$ft.DTrgPortAlias}</td>
            <td>{$ft.DFreightName}/{$ft.BFreightName}</td>
            <td>{$ft.DSrcTime}{if $ft.DSrcTimeDelta}<span class="delta">+{$ft.DSrcTimeDelta}</span>{/if}</td>
            <td>{$ft.DTrgTime}{if $ft.DTrgTimeDelta}<span class="delta">+{$ft.DTrgTimeDelta}</span>{/if}</td>
            <td>{$ft.BSrcTime}{if $ft.BSrcTimeDelta}<span class="delta">+{$ft.BSrcTimeDelta}</span>{/if}</td>
            <td>{$ft.BTrgTime}{if $ft.BTrgTimeDelta}<span class="delta">+{$ft.BTrgTimeDelta}</span>{/if}</td>
            <td>{$ft.TranTypeName}</td>
        </tr>
    {/foreach}
</table>

{else}
    ##NO_DATA##
{/if}