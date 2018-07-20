<div id="edit_tourist" {if $is_layout}data-layout="1"{/if} data-claiminc="{$CLAIM}">
    <form method="POST" action="{$routes.edit_tourist.url}samo_action=SAVE&CLAIM={$CLAIM}" class="edit_tourist">
    {include file="../fieldset_builder.tpl" fields=$TOURIST}
    {if !$reason_for_readonly}
        <input type="submit" class="load" value="##BTN_SAVE##" />
    {else}
        <div class="warning">{$reason_for_readonly}</div>
    {/if}
    </form>
</div>