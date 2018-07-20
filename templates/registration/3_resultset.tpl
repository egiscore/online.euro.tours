{if $result}
    <table class="res">
        <thead>
            <tr>
                <td>##NAME##</td>
                <td>##OFFICIAL_NAME##</td>
                <td>##EMAIL##</td>
            </tr>
        </thead>
        <tbody>
        {foreach from=$result item="res"}
            <tr class="{cycle values="even,odd"}">
                <td>{$res.PartnerName}</td>
                <td>{$res.PartnerOfficialName}</td>
                <td>{$res.email}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
    {if $have_administrator}
        <br>
        <div class="red">##NEW_PARTPASS_EMAIL_TO_ADMINISTRATOR##</div>
        <br>
    {/if}
{else}
    ##NO_DATA##
{/if}