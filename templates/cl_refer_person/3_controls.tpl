{if isset($cost)}
    {if 1 == count($cost)}
        ##CL_R_COST_AMOUNT##: {if !$partpass_mode}{$cost.0.Amount}{else}{$cost.0.Catalog}{/if}&nbsp;{$cost.0.CurrencyAlias} {if !$partpass_mode}/ ##CL_R_COST_TO_PAY##: {$cost.0.Debt}&nbsp;{ $cost.0.CurrencyAlias}{/if}
    {else}
        <select class="curr" name="CURRENCY">{foreach from=$cost item="cost_item"}<option value="{if !$partpass_mode}{$cost_item.Amount}{else}{$cost_item.Catalog}{/if}|{if !$partpass_mode}{$cost_item.Debt}{/if}">{$cost_item.CurrencyAlias}</option>{/foreach}</select>&nbsp;##CL_R_COST_AMOUNT##: <span class="amount">{if !$partpass_mode}{$cost.0.Amount}{else}{$cost.0.Catalog}{/if}</span>{if !$partpass_mode} / ##CL_R_COST_TO_PAY##: <span class="debt">{$cost.0.Debt}</span>{/if}
    {/if}
{/if}