<div class="CLAIMRESULT">
    ##BRON_RESERVATION_NUMBER## {$bron.Claim}<br>
    ##BRON_RESERVATION_PRICE## {$bron.PriceStr|string_format:"%.2f"} {$bron.Currency_Alias}<br>
    {if $smarty.get.page == 'bron_person'}{note page='bron_person_result'}{/if}
    {if $print_contract}<a href="{$print_contract}">##BRON_PERSON_CONTRACT_PRINT##</a> | {/if}<a href="{$cl_refer}">##BRON_SEE_RESERVATION##</a> | <a href="{$bron_again}">##BRON_NEW_RESERVATION##</a>
</div>