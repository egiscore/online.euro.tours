<fieldset class="panel resultset">
    <legend>##TOUR_SEARCH_PACKET_CONTENT##</legend>
    <table class="res">
        <tbody>
        {foreach from=$packet item="order"}
            <tr class="{cycle values="even,odd"} {$order.color}_row {$order.type}_{$order.id}">
                <td class="caption">{$order.dateBeg} - {$order.dateEnd}</td>
                <td>{imgload file=$order.image inline=true}&nbsp;{$order.name|linkify:$order.url}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</fieldset>
{if $SERVICES}
    {include file="services.tpl" SERVICES=$SERVICES}
{/if}