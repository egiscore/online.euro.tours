{if $visa_status}
<table class="visa_status">
    <tr>
        <td class="label">##VISA_STATUS_DOC_FULL_TAKEN##</td>
        <td>
        {if $visa_status.fulltakendoc}
            {imgload file="paid.gif" title="##YES##"}
        {else}
            {imgload file="unpaid.gif" title="##NO##"}
        {/if}</td> 
        <td>{$visa_status.fulltakendate}</td>
    </tr>
   <tr>
        <td>##VISA_STATUS_DOC_PREPARED_TO_EMBASSY##</td>
        <td>
        {if $visa_status.prepareddoc}
            {imgload file="paid.gif" title="##YES##"}
        {else}
            {imgload file="unpaid.gif" title="##NO##"}
        {/if}
        </td> 
        <td>{$visa_status.prepareddate}</td>
    </tr>
    <tr>
        <td>##VISA_STATUS_DOC_GIVEN_INTO_EMBASSY##</td>
        <td>{if $visa_status.givendoc}
            {imgload file="paid.gif" title="##YES##"}
        {else}
            {imgload file="unpaid.gif" title="##NO##"}
        {/if}
        </td> 
        <td>{$visa_status.givendate}</td>
    </tr>
    <tr>
        <td>##VISA_STATUS_DOC_APPROXIMATE_RECEIVING_DATE##</td>
        <td></td>
        <td>{$visa_status.receiveddate|default:'---'}</td>
    </tr>
    <tr>
        <td>##VISA_STATUS_DOC_RECEIVED_FROM_EMBASSY##</td>
        <td>
        {if $visa_status.receiveddoc}
            {imgload file="paid.gif" title="##YES##"}
        {else}
            {imgload file="unpaid.gif" title="##NO##"}
        {/if}
        </td> 
        <td>{$visa_status.realreceiveddate}</td>
    </tr>
    <tr>
        <td>##VISA_STATUS_DOC_VISA_RECEIVED##</td>
        <td>
        {if $visa_status.VReceived}
            {imgload file="paid.gif" title="##YES##"}</td> 
        {else}
            {imgload file="unpaid.gif" title="##NO##"}
        {/if}
        </td> 
        <td>{$visa_status.VReceivedDate}</td>
    </tr>
    <tr>
        <td>##VISA_STATUS_DOC_VISA_EXPIREDATE##</td>
        <td></td>
        <td>{$visa_status.VisaExpireDate|default:'---'}</td>
    </tr>
    <tr>
        <td>##VISA_STATUS_PASSPORT_RETURNED##</td>
        <td>
        {if $visa_status.passportgivendate|date_format} 
            {imgload file="paid.gif" title="##YES##"}
        {else}
            {imgload file="unpaid.gif" title="##NO##"}
        {/if}
        </td> 
        <td>{$visa_status.passportgivendate}</td>
    </tr>
    <tr>
        <td>##VISA_STATUS_VISA_DOCUMENTS_STATUS##</td>
        <td>{if $visa_status.VStatusNote}{$visa_status.VStatusNote}{else}{if $visa_status.VStatusName}{$visa_status.VStatusName}{else}---{/if}&nbsp;{/if}</td>
    </tr>
    {if $visa_status.ANote}
    <tr>
        <td colspan="3">##VISA_STATUS_NOTE##</td>
    </tr>
    <tr>
        <td colspan="3" class="visa_status_note">{$visa_status.ANote}<br><br></td>
    </tr>
    {/if}
</table>
{else}
    ##NO_DATA##
{/if}