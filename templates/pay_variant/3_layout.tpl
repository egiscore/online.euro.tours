{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="pay_variant.css,psbank.css,reward.css,bonus_manager.css"}
{include file="../partial_top.tpl"}
<div id="pay_variant" class="container" data-claim="{$CLAIM}">
    {note}
    <br>

    <div class="panel">
        <table class="payment_container res">
            <thead><tr class="even"><th>
                <div class="payment_methods">##PAY_VARIANT_TITLE## {$CLAIM}</div>
            </th></tr></thead>
        </table>
    </div>
    {foreach from=$variants item="variant"}
        <div class="panel pay_variant" id="{$variant.name}_container">
            {include file=$variant.tpl variant=$variant}
        </div>
    {foreachelse}
        <div class="panel pay_variant empty">##PAY_VARIANT_IS_EMPTY##</div>
    {/foreach}
</div>
{include file="../common.tpl"}
{jsload file="pay_variant.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}