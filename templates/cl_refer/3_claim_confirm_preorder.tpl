{if $result.Bron}
    ##CLAIM_CONFIRM_PREORDER_SUCCESSFULLY##
    <br>
    <br>
{elseif $result.result == -1}
    ##CLAIM_CONFIRM_PREORDER_PRICE_CHANGED##
    <br>
    <br>
{/if}
{if $result.result != 0 && $result.price}
    ##CLAIM_CONFIRM_PREORDER_PRICE## {$result.price} {$result.Alias}
    <br>
    {$result.priceex} {$result.AliasEx} ({$result.DateEx})
{else}
    {$result.error}
{/if}
<br>
<br>
{if $result.result != 0 && $result.Bron == 0}
    <button class="load preorder-btn" data-claim="{$claim_info.Inc}">##CLAIM_CONFIRM_PREORDER_CHECK##</button>
{/if}
<button class="close">##CL_CLOSE##</button>
