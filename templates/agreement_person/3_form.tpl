

<div id="select_fields">
    <div class="payer_info">
        <form id="form_select_fields" name="select_fields" action="{$routes.agreement_person.url}samo_action=SAVE_FIELDS_FOR_PDF&CLAIM={$CLAIM}" method="post">
            {include file="../fieldset_builder.tpl"}
           <a  id="agr_pers"  href="{$href}">##SAVE_BTN_AGREEMENT_PERSON##</a>
        </form>

    </div>
</div>
