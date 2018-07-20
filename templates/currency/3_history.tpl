<table width="100%">
<tr>
<td width="71%" id="currency-chart">
</td>
<td width="27%" id="currency-history-container">
<table id="currency-history" class="res" data-base="{$history.0.currencyBase}">
    <thead>
    <tr>
        <th>##CURRENCY_DATE##</th>
        <th data-title="{$history.0.currency}">##CURRENCY_RATE##</th>
        <th>##CURRENCY_CHANGE##</th>
    </tr>
    </thead>
    <tbody>
    {foreach from=$history item="rate"}
    <tr class="{cycle values='even,odd'}">
        <td data-date="{$rate.date|date_format:'%d %F'}">{$rate.date|date_format}</td>
        <td>{$rate.rate|number_format:"4"}</td>
        <td>{if $rate.change}
            {if $rate.change > 0}+{/if}{$rate.change|number_format:"4"} <span class="{if $rate.change > 0}rate-up{elseif $rate.change < 0}rate-down{/if}"></span>
            {/if}
        </td>
    </tr>
    {/foreach}
    </tbody>
</table>
</td>
</tr>
</table>