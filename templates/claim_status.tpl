{if $claim.Status != Samo_Claim::STATUS_CALCULATED}
    {if $claim.ConfirmedDate->not_null() && $claim.Confirmed == 1}
        {if $claim.RequestCancelDate->is_null() and in_array($claim.Status, [Samo_Claim::STATUS_UNPAID, Samo_Claim::STATUS_PENALTY])}
            <span class="green bold">{if $claim.AccessPay}##CL_R_RES_PAYABLE##{else}##CL_R_RES_NOT_PAYABLE##{/if}</span><br>
        {else}
            <span class="green bold">##CL_R_RES_CONFIRMED##</span><br>{$claim.ConfirmedDate|date_format:'datetime'}<br>
        {/if}
    {elseif $claim.RequestCancelDate->is_null() && !in_array($claim.Status, [Samo_Claim::STATUS_CANCELED, Samo_Claim::STATUS_PENALTY, Samo_Claim::STATUS_PAID_PENALTY])}
        {if $claim.ConfirmedDate->not_null() && $claim.Confirmed != 1}
            <span class="red bold">##CL_R_RES_NOT_CONFIRMED##</span><br>{$claim.ConfirmedDate|date_format:'datetime'}<br>
        {else}
            <span>##CL_R_RES_IN_PROCESS##</span><br>
        {/if}
    {/if}
    {if in_array($claim.Status, [Samo_Claim::STATUS_CANCELED, Samo_Claim::STATUS_PENALTY, Samo_Claim::STATUS_PAID_PENALTY])}
        <span class="dark_red bold">##CL_R_RES_CANCELED##</span><br>{$claim.CancelDate|date_format:'datetime'}
    {elseif $claim.RequestCancelDate->not_null()}
        <span class="red bold">##CL_R_RES_CANCEL_REQUEST##</span><br>{$claim.RequestCancelDate|date_format:'datetime'}
    {/if}
{/if}