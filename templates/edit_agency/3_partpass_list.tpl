<fieldset id="login_list" class="panel" data-delete-confirm="##LOGIN_CONFIRM_DELETE##">
    <legend>##PARTNER_AGENCY_LOGINS##</legend>
    <div class="eraser"></div>
    <table class="res logins">
        <thead>
            <tr>
                <th>##LOGIN_FULLNAME## (##LOGIN_BORN##)<br>##LOGIN_OCCUPATION##</th>
                <th>##LOGIN_LOGIN##<br>##LOGIN_EMAIL##</th>
                <th>##LOGIN_PHONES##<br>##LOGIN_FAXES##</th>
                <th>##LOGIN_CDATE##</th>
                <th>##LOGIN_ONLINE_ACCESS##</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        {foreach from=$PartnerLogins item="login"}
            <tr data-partpass="{$login.inc}" class="{cycle values="even,odd"}">
                <td>{$login.fullname}{if $login.born->not_null()} ({$login.born|date_format}){/if}<br>{$login.occupation}</td>
                <td>{$login.alias}<br/>{$login.email}</td>
                <td>{$login.phones}<br>{$login.faxes}</td>
                <td>{$login.cdate|date_format}<br>{if $login.administrator}##LOGIN_ADMINISTRATOR##{/if}</td>
                <td>{if $login.online_access}##YES##{else}##NO##{/if}</td>
                <td class="c"><button class="partpass_edit">##LOGIN_EDIT##</button></td>
                <td class="c">
                    {if $login.enable_delete}
                        <button class="partpass_delete">##BTN_DELETE##</button>
                    {else}
                        &nbsp;
                    {/if}
                </td>
            </tr>
        {/foreach}
        {if $PartPassCreate}
            <tr>
                <td align="center" colspan="8"><button class="partpass_edit partpass_create">##CREATE##</button></td>
            </tr>
        {/if}
    </table>
</fieldset>