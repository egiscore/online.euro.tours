<table class="res" id="bonus_manager_currency">
    <thead>
    <tr>
        <th>##BONUS_MANAGER_CURRENCY##</th>
        <th>##BONUS_MANAGER_ADD##</th>
        <th>##BONUS_MANAGER_DELETE##</th>
        <th>##BONUS_MANAGER_TOTAL##</th>
    </tr>
    </thead>
{cycle values="even,odd" reset=true print=false advance=false}
{foreach from=$bonus item="currency"}
    <tr class="{cycle values="even,odd"}">
        <td>{$currency.total.alias}</td>
        <td>{$currency.add.value}</td>
        <td>{$currency.delete.value}</td>
        <td>{$currency.total.value} {if $currency.available.value}(##BONUS_MANAGER_BONUS_TOTAL_AVAILABLE## {$currency.available.value}){/if}</td>
    </tr>
{/foreach}
</table>