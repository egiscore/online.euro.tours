<div id="login">
    <form name="PARTPASS_FORM" action="{$routes.edit_agency.url}samo_action=SAVE_LOGIN" method="post">
        <input type="hidden" name="PARTPASS_INC" value="{$login.inc}">
        {include file="../fieldset_builder.tpl"  fields=$fields_partpass}
        <div class="label">##REQUIRE_BOLD##</div>
        {if $show_save_partpass_btn}
            <br>
            <input type="submit" value="##BTN_SAVE##">
        {/if}
    </form>
</div>
