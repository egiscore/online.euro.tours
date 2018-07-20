{if isset($cost)}
    <table class="res cl_referer_cost">
        <thead>
            <tr>
                <td>&nbsp;</td>
                <td>{$cost.now.0.CurrencyAlias|strtoupper}</td>
                <td>{$cost.now.1.CurrencyAlias|strtoupper}<br>##CL_RATE_FOR## {$cost.now.0.rate_dateex|date_format}</td>
                <td>{$cost.now.1.CurrencyAlias|strtoupper}<br>##CL_RATE_FOR## {$cost.tomorrow.0.rate_dateex|date_format}</td>
            </tr>
        </thead>
        <tbody>
            <tr class="even">
                <td nowrap>##CL_R_COST_CATALOG##</td>
                <td>{$cost.now.0.Catalog}</td>
                <td>{$cost.now.1.Catalog}</td>
                <td>{$cost.tomorrow.1.Catalog}</td>
            </tr>
                <tr class="odd">
                    <td nowrap>##CL_R_COST_AMOUNT##</td>
                {if $partpass_mode}
                    <td>{$cost.now.0.Catalog}</td>
                    <td>{$cost.now.1.Catalog}</td>
                    <td>{$cost.tomorrow.1.Catalog}</td>
                {else}
                    <td>{$cost.now.0.Amount}</td>
                    <td>{$cost.now.1.Amount}</td>
                    <td>{$cost.tomorrow.1.Amount}</td>
                {/if}
                </tr>
            {if !$partpass_mode}
                <tr class="even">
                    <td>##CL_R_COST_PAID##</td>
                    <td>{$cost.now.0.Paid}</td>
                    <td>{$cost.now.1.Paid}</td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="odd">
                    <td>{if $cost.now.0.Debt >=0}<span class="red">##CL_REFER_DEBT##</span>{elseif $cost.now.0.Debt <0}<span class="green">##CL_REFER_PAYBACK##</span>{else}##CL_R_COST_TO_PAY##{/if}</td>
                    <td>{$cost.now.0.Debt}</td>
                    <td>{$cost.now.1.Debt}</td>
                    <td>{$cost.tomorrow.1.Debt}</td>
                </tr>
{*
                {if $cost.now.0.PartnerCommiss}
				<tr class="odd">
                    <td>##CL_R_COST_PARTNER_COMISS##</td>
                    <td>{$cost.now.0.PartnerCommiss}</td>
                    <td>{$cost.now.1.PartnerCommiss}</td>
                    <td>{$cost.tomorrow.1.PartnerCommiss}</td>
                </tr>
				{/if}
				{if $cost.now.0.MediatorCommiss}
				<tr class="odd">
                    <td>##CL_R_COST_MEDIATOR_COMISS##</td>
                    <td>{$cost.now.0.MediatorCommiss}</td>
                    <td>{$cost.now.1.MediatorCommiss}</td>
                    <td>{$cost.tomorrow.1.MediatorCommiss}</td>
                </tr>
				{/if}
                <tr class="even">
                    <td>##CL_R_COST_COMISS##</td>
                    <td>{$cost.now.0.Commiss}</td>
                    <td>{$cost.now.1.Commiss}</td>
                    <td>{$cost.tomorrow.1.Commiss}</td>
                </tr>
                <tr class="odd">
                    <td>##CL_R_COST_COMISS_PERCENT##</td>
                    <td>{$cost.now.0.CommissPercent}</td>
                    <td>{$cost.now.1.CommissPercent}</td>
                    <td>{$cost.tomorrow.1.CommissPercent}</td>
                </tr>
*}
            {/if}
        </tbody>
    </table>
    {if $future_bonus.bonus_value}
        <br>
        {include file="../bonus_manager/future_bonus.tpl" future_bonus=$future_bonus}
    {/if}

    {if !$claim_paymentschedule}
        <br>
        {if !$claim_info.PPDate->is_null()}{note page='cl_refer_cost_part' include="true" assign="note"}<div class="l cost"><div class="title">##CL_DATE_PARTPAYMENT##</div> &nbsp;{if $note}{$note}{else}{$claim_info.PPDate|date_format}{/if}</div>{/if}
        {if !$claim_info.PDate->is_null()}{note page='cl_refer_cost_full' include="true" assign="note"}<div class="l cost"><div class="title">##CL_DATE_FULLPAYMENT##</div> &nbsp;{if $note}{$note}{else}{$claim_info.PDate|date_format}{/if}</div>{/if}
    {/if}
{/if}
{if isset($claim_paymentschedule)}
    <br>
    ##PAYMENT_SCHEDULE_TITLE##
    <table class="res cl_referer_cost">
        <thead>
        <tr>
            <td>##PAYMENT_SCHEDULE_PDATE##</td>
            <td>##PAYMENT_SCHEDULE_PAYMENT##</td>
            <td>##PAYMENT_SCHEDULE_PERCENT_CLAIM##</td>
            <td>##PAYMENT_SCHEDULE_PERCENT_STATUS##</td>
        </tr>
        </thead>
        <tbody>
            {foreach from=$claim_paymentschedule item="row"}
            <tr class="{cycle values="even,odd"}">
                <td>{$row.pdate|date_format}</td>
                <td>{$row.tpaysum} {$cost.now.0.CurrencyAlias|strtoupper}</td>
                <td>{$row.tpercent}%</td>
                <td>{if $row.status==1}##PAYMENT_SCHEDULE_PAID###{elseif $row.status==6}##PAYMENT_SCHEDULE_PARTPAID##{else}{/if}</td>
            </tr>
            {/foreach}
        </tbody>
    </table>
{/if}
<br>
<button class="cost_close">##CL_CLOSE##</button>
{if $claim_info.AccessPay}
    &nbsp;&nbsp;&nbsp;<button class="pay_claim" data-claim="{$claim_info.Inc}">##CL_PAY_VARIANT##</button>
{/if}
{*<button class="money_back" data-claim="{$claim_info.Inc}">##MONEY_BACK##</button>*}