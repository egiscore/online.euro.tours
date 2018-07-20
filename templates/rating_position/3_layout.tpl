{if !$smarty.get.samo_action}
{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="rating_position.css"}
{include file="../partial_top.tpl"}
{else}
{cssload file="rating_position.css"}
{/if}
<div id="rating_position">
    {note}
    <div class="result">{include file="resultset.tpl"}</div>
</div>
{if !$smarty.get.samo_action}
{include file="../common.tpl"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}
{/if}