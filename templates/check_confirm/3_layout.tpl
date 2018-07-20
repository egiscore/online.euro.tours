{cssload file="common.css,check_confirm.css"}
{cssload file="customer.css" required=false}
<div class="samo_container" id="check_confirm" data-csrf-token="{$csrf_token}">
    {if $is_embedable}
        {include file="3_resultset.tpl"}
    {else}
        <div class="container">
            {if $fields.claim_required}
                <input type="text" class="frm-input CLAIM num" name="CLAIM" size="15" autocomplete="off" value="{$smarty.get.CLAIM|default:'##CLAIM_FIELD##'}">
            {/if}
            {if $fields.pnumber_required}
                <input type="text" class="frm-input num" name="PNUMBER" size="26" autocomplete="off" value="##PNUMBER_FIELD##">
            {/if}
            {if $fields.fio_required}
                <input type="text" class="frm-input eng FIO" name="LASTNAME" size="56" autocomplete="off" value="##FIO_FIELD##">
            {/if}
            <button class="load">##CHECK_LOAD##</button>
        </div>
    {/if}
</div>
{include file="../common.tpl"}
{jsload file="check_confirm.js"}