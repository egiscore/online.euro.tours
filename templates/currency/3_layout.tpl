{if $rates}
{cssload file="common.css,currency.css"}
{cssload file="customer.css" required=false}
<div class="samo_container">
    <table id="currency" class="res panel">
    <thead>
        <tr><th class="first">##CURRENCY_DATE##</th>
            {foreach from=$rates item="CURRENCY" key="date"}
                {foreach from=$CURRENCY item="data"}
                    <th data-currency='{$data|data_json:'currency'}' class="rate">
                        {$data.CurrencyName}
                    </th>
                {/foreach}
                {break}
            {/foreach}
        </tr>
    </thead>
    <tbody>
    {foreach from=$rates item="CURRENCY" key="date"}
        <tr class="{cycle values="even,odd"}">
            <td>{$date|date_format}</td>
            {foreach from=$CURRENCY item="data"}
            <td data-currency='{$data|data_json:'currency'}' class="rate">
                {$data.BankRate}
                {if $data.ChangeValue}
                    <span class="{if $data.ChangeValue > 0}rate-up{elseif $data.ChangeValue < 0}rate-down{/if}"></span>
                {/if}
            </td>
            {/foreach}
        </tr>
    {/foreach}
    </tbody>
    </table>
</div>
{include file="../common.tpl"}
{jsload file="currency.js"}
{/if}