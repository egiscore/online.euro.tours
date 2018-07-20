<div class="CLAIMRESULT">
    ##BRON_RESERVATION_NUMBER## {$bron.Claim}<br>
    ##BRON_RESERVATION_PRICE## {$bron.PriceStr|string_format:"%.2f"} {$bron.Currency_Alias}<br>
    <a href="{$cl_refer}">##BRON_SEE_RESERVATION##</a> | <a href="{$bron_again}">##BRON_NEW_RESERVATION##</a>
</div>