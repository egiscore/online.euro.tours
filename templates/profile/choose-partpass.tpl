{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="profile.css"}
{include file="../partial_top.tpl"}
<div id="choose-partpass">
    <div class="container">
    <div class="description">##RECOVERY_PASSWORD_CHOOSE_PARTPASS##</div>
        <form method="post" id="choose-partpass-frm" action="{Samo_Url::route('profile',['samo_action' => 'change_password'])}">
        <table class="res users">
            <thead>
            <tr>
                <th>##LOGIN_ALIAS##</th>
                <th>##LOGIN_FULLNAME##</th>
                <th>##OFFICIAL_NAME##</th>
                <th>##NAME##</th>
                <th>##TOWN##</th>
                <th>##ADDRESS##</th>
            </tr>
            </thead>
            <tbody>
        {foreach from=$users item="partpass"}
                <tr class="{cycle values="even,odd"}">
                    <td>
                        <button name="partpass" value="{$partpass.PartPassInc}">{$partpass.PartPassAlias}</button>
                    </td>
                    <td>
                        {$partpass.PartPassFullname|default:"&mdash;"}
                    </td>
                    <td>
                        {$partpass.PartnerOfficialname}
                    </td>
                    <td>
                        {$partpass.PartnerName}
                    </td>
                    <td>
                        {$partpass.TownName}
                    </td>
                    <td>
                        {$partpass.PartnerAddress}
                    </td>
                </tr>
        {/foreach}
            </tbody>
        </table>
        </form>
    </div>
</div>
{include file="../common.tpl"}
{jsload file="profile.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}