{include file="header.tpl" page_title="##PAGE_TITLE##"}
{include file="partial_top.tpl"}

<br>
<br>
<br>
<br>
<br>
<br>

{if $result == 'OK'}
    ##ACQUIRING_PAY_RESULT_OK##
{else}
    ##ACQUIRING_PAY_RESULT_FAIL##
{/if}

<br>
<br>
<br>
<br>
<br>
<br>


{include file="common.tpl"}
{include file="partial_bottom.tpl"}
{include file="footer.tpl"}