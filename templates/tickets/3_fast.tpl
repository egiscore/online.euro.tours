{cssload file="common.css,tickets.css"}
{cssload file="data/search_tour/icons.css" base="" required=false}
<div id="tickets" class="samo_container fast" data-csrf-token="{$csrf_token}">
    {include file="../controls.tpl" control="SEARCHMODE"}
    <div class="form">
        {include file="controls.tpl" control="form"}
    </div>
</div>
{include file="../common.tpl"}
{jsload file="tickets.js"}
