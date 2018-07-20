<table class="res bonus_manager_detail" id="bonus_manager_detail">
    <thead>
    <tr>
        <th>##BONUS_MANAGER_DATE##</th>
        <th>##BONUS_MANAGER_TYPE##</th>
        <th>##BONUS_MANAGER_CLAIM##</th>
        <th>##BONUS_MANAGER_BONUS##</th>
        <th>##BONUS_MANAGER_BONUS_STATUS##</th>
    </tr>
    </thead>
{cycle values="even,odd" reset=true print=false advance=false}
{foreach from=$values item="item"}
    <tr class="{cycle values="even,odd"}">
        <td>{$item.issue|date_format:"datetime"}</td>
        <td>{if $item.type == 1}##BONUS_MANAGER_IN##{elseif $item.type == 2}##BONUS_MANAGER_OUT##{else}##BONUS_MANAGER_UNKNOWN##{/if}</td>
        <td><a href="{$routes.cl_refer.url}CLAIM={$item.claim}" data-claim="{$item.claim}" class="claiminfo">{$item.claim}</a></td>
        <td>{$item.value}&nbsp;{$item.currency_alias}</td>
        <td{if $item.status} class="active"{/if}>{if $item.status == 1}##BONUS_MANAGER_BONUS_AVAILABLE##{elseif $item.type == 1}##BONUS_MANAGER_BONUS_UNAVAILABLE##{else}&nbsp;{/if}</td>
    </tr>
{/foreach}
</table>
