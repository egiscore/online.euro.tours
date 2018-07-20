{if $prices}
<table class="res prices">
{foreach from=$prices item="htplaces" key="meal"}
<thead>
<tr>
    <th class="l">{$meal}</th>
    {foreach from=$nights item="night"}
        <th>{$night}</th>
    {/foreach}
</tr>
</thead>
<tbody>
    {foreach from=$htplaces item="night" key="htplace"}
        <tr class="{cycle values="even,odd"}" data-townfrom="{$townFrom}" data-state="{$state}" data-spog="0">
            <td class="l">{$htplace}</td>
            {foreach from=$night item="price"}
                <td data-cat-price="{$price.price}" data-cat-currency="{$price.currencyKey}" class="price{if $price.selected} selected{/if}{if $price.bron} bron" data-cat-claim="{$price.id}"{else}{if $price.stopSale || $price.stopSpog} stop" title="{$price.note}"{else}"{/if}{/if} >{$price.convertedPrice}</td>
            {/foreach}
        </tr>
    {/foreach}
</tbody>    

{/foreach}
</table>
{else}
<p align="center">##NO_DATA##</p>
{/if}