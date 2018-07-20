<div id="psbank" data-claim="{$CLAIM}" data-update_warrant="{$update_warrant}">
<div class="payer_info">
    {if $payers}
        <div class="row">
            <label class="left_column">##SELECT_PAYER##:</label>
            <select class="PAYER">
                <option value="0">##NEW_PAYER##</option>
                {foreach from=$payers item="payer"}
                    <option value="{$payer.value}" data-payer='{$payer.data|@data_json:'payer'}' {if $payer.selected}selected="selected"{/if}>{$payer.title}</option>
                {/foreach}
            </select>
        </div>
    {/if}
    <form id="PSBANK_FORM" name="PSBANK_FORM" action="{$routes.psbank.url}samo_action=PLATEZKA&CLAIM={$CLAIM}" method="post">
        {include file="../fieldset_builder.tpl"}
        <fieldset class="panel"><legend>##PAYMENT_INFO##</legend>
            <div class="row">
                <label class="left_column">##PAYED##</label>
                <span class="rrr">{$PAYED|number_format:2:'.':''} &nbsp;&nbsp;&nbsp;{$CONFIG_BUH_CURR}</span>
            </div>
            <div class="row">
                <label class="left_column">##MAX_AMOUNT##</label>
                {if $MAX_AMOUNT_enable}
                    <div id="DIV_AMOUNT">
                        {if $SCHEDULE}
                            {foreach from=$SCHEDULE item="item"}
                                <label><input type="radio" name="MAX_AMOUNT_LABEL" class="MAX_AMOUNT" value="{$item.value}"{if $item.selected} checked="checked"{/if}><span class="rrr">{$item.value|number_format:2:'.':''} &nbsp;&nbsp;&nbsp;{$CONFIG_BUH_CURR}</span> {$item.tpercent}% </label>
                            {/foreach}
                            <label>&nbsp;</label>
                        {/if}
                        <label>
                            <input type="text" name="MAX_AMOUNT" id="MAX_AMOUNT" class="frm-input price required" min="{$MIN_AMOUNT}" max="{$MAX_AMOUNT}" value="{$MAX_AMOUNT|number_format:2:'.':''}"> <span class="rrr">{$CONFIG_BUH_CURR}</span>
                        </label>
                    </div>
                {else}
                    <span class="rrr">{$MAX_AMOUNT}</span>
                {/if}
            </div>
        </fieldset>
        <div class="row">
            <label class="left_column">##BANK_INFO##:</label>
            <select name="BANK" id="BANK">
                {foreach from=$bank item="bank_info"}
                    <option value="{$bank_info.Inc}" {if $bank_info.Default}selected="selected"{/if}>{$bank_info.Name}</option>
                {/foreach}
            </select>
        </div>
    </form>
    <button class="load">##KVITOK_BTN##</button>
    <div class="warning">##PAYER_READONLY##</div>
</div>
</div>
