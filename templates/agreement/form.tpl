<div id="new_reason">
    <div class="payer_info">
        <form name="REASON_FORM" id="REASON_FORM" action="{$links.save_form}" method="post">
            {include file="../fieldset_builder.tpl"  fields=$fields_agreement}
            <br>
            <div class="label">##REQUIRE_BOLD##</div>
            <br>
            <input type="button" id="REASON_FORM_SUBMIT" value="##AGREEMENT_CHECK_PARTNER_CONTINUE##">
        </form>
    </div>
</div>