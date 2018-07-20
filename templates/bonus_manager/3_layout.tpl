{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="bonus_manager.css"}
{include file="../partial_top.tpl"}
<div id="bonus_manager">
    {note}
    {include file="../controls.tpl" control="SEARCHMODE" SEARCHMODE=$PERSONAL_AREA}
    {if $RESULT}
        {foreach from=$RESULT item="manager"}
            <fieldset class="panel">
                <legend>{$manager.detail.0.fullname} ({$manager.detail.0.id})</legend>
                <br>
                    {include file="resultset.tpl" bonus=$manager.currency}
                <br>
                <span class="toggle_detail link" data-show="##BONUS_MANAGER_SHOW_DETAIL##" data-hide="##BONUS_MANAGER_HIDE_DETAIL##">##BONUS_MANAGER_SHOW_DETAIL##<br></span>
                <div class="detail" style="display: none">
                    {include file="details.tpl" values=$manager.detail}
                </div>
            </fieldset>
            <br>
        {/foreach}
        {else}
        ##NO_DATA##
    {/if}
</div>
{include file="../common.tpl"}
{jsload file="bonus_manager.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}
