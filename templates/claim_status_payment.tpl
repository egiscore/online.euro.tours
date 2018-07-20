{if $claim.Status == Samo_Claim::STATUS_CALCULATED}
    ##CL_ST_P_CALCULATION##
{elseif (in_array($claim.Status, [Samo_Claim::STATUS_CANCELED, Samo_Claim::STATUS_PENALTY, Samo_Claim::STATUS_PAID_PENALTY]))}
    <span class="warn">##CL_ST_P_CANCELED##</span>
{elseif (in_array($claim.Status, [Samo_Claim::STATUS_PAID, Samo_Claim::STATUS_UNPAID]) and $claim.RequestCancelDate->not_null())}
    <span class="warn">##CL_ST_P_CANCEL_REQUEST##</span>
{elseif $claim.Status == Samo_Claim::STATUS_PAID}
    ##CL_ST_P_PAID##
{elseif $claim.Status == Samo_Claim::STATUS_UNPAID}
    {if $claim.Partpayment && $claim.PaidPercent}
        {assign var="pay_status" value="##CL_ST_P_PART_PAID_PERCENT## `$claim.PaidPercent`%)"}
    {elseif $claim.Partpayment}
        {assign var="pay_status" value="##CL_ST_P_PART_PAID##"}
    {else}
        {assign var="pay_status" value="##CL_ST_P_PART_NOT_PAID##"}
    {/if}
    {if $claim.PDate->not_null() && $claim.PDate->lt()}
        <span class="warn">{$pay_status}<br>##CL_ST_P_FULL_EXPIRED##</span>
    {elseif $claim.PPDate->not_null() && $claim.PPDate->lt() && !$claim.Partpayment}
        <span class="warn">{$pay_status}<br>##CL_ST_P_EXPIRED##</span>
    {elseif $claim.PPDate->not_null() && $claim.PPDate->gte() && !$claim.Partpayment}
        {$pay_status}<br>##CL_ST_P_PAY_PERIOD## {$claim.PPDate|date_format:'datetime'}
    {elseif $claim.PDate->not_null() && $claim.PDate->gte() }
        {$pay_status}<br>##CL_ST_P_FULL_PAY_PERIOD## {$claim.PDate|date_format:'datetime'}
    {else}
        <span class="warn">{$pay_status}</span>
    {/if}
{/if}