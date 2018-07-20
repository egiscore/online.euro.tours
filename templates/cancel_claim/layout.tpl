<div id="cancel_claim">
    {include file="`$smarty.const._ROOT`templates/claiminfo.tpl" claim_info=$info}
    <br>

    <div>
        {$content}
        {if $penalty_size}
            <div class="warning">
                {include file="../penalty.tpl" penalty_size=$penalty_size}
            </div>
        {/if}
    </div>
    <br>
    {if count($reason) > 1}
        <select id="CANCEL_CLAIM_REASON_SELECT" class="cancel_claim_reason_select">
            {foreach from = $reason item = "reason1" name="reasons"}
                <option value="{$reason1.Inc}">{$reason1.LName}</option>
            {/foreach}
        </select>
    {/if}
    <button id="agreement">##CANCEL_AGREEMENT_BUTTON##</button>
</div>