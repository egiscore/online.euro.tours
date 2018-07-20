{if $SALELIST}

    {foreach from=$SALELIST item="partner"}
        <fieldset class="panel">
            <legend>{$partner.Name}</legend>
            {if $partner.licence}
                <div>##SALE_LICENSE## {$partner.licence}</div>
            {/if}
            <div>##TOWN## <b>{$partner.TownName}</b>{if $partner.metrostation}, ##METROLINE## {$partner.metrostation}{/if}{if $partner.metro} ({$partner.metro}){/if}</div>
            {if $partner.boss or $partner.address or $partner.phones or $partner.emails or $partner.www or $partner.uins}
                <table class="res">
                    {if $partner.boss}
                        <tr class="{cycle values="even,odd"}">
                            <td class="label">##SALE_BOSS##</td>
                            <td>{$partner.boss}</td>
                        </tr>
                    {/if}
                    {if $partner.address}
                        <tr class="{cycle values="even,odd"}">
                            <td class="label">##ADDRESS##</td>
                            <td>
                                {if $partner.addresscode}{$partner.addresscode}, {/if}{$partner.address}
                            </td>
                        </tr>
                    {/if}
                    {if $partner.phones or $partner.emails or $partner.www or $partner.uins}
                        <tr class="{cycle values="even,odd"}">
                            <td class="label">##SALE_CONTACTS##</td>
                            <td>
                                {if $partner.phones}##PHONES## <b>{if $partner.phprefix}({$partner.phprefix}){/if} {$partner.phones|@implode:", "}</b><br>{/if}
                                {if $partner.mobiles}<b>{$partner.mobiles|@implode:", "}</b><br>{/if}
                                {if $partner.emails}##EMAIL## {foreach from=$partner.emails item="mail" name="mail"}<a class="mail" href="mailto:{$mail|escape:'hex'}">{$mail|escape:'hexentity'}</a>{if !$smarty.foreach.mail.last}, {/if}{/foreach}<br>{/if}
                                {if $partner.www}##WWW## <a class="www" href="http://{$partner.www}">{$partner.www}</a><br>{/if}
                                {if $partner.icq}##ICQ## {foreach from=$partner.icq item="icq" name="icq"} <a class="icq" href="//www.icq.com/{$icq.uin}"><img src="//status.icq.com/online.gif?icq={$icq.uin}&img=26" align="absmiddle">&nbsp;{$icq.title}</a>{if $icq.name} ({$icq.name}){/if}  {if !$smarty.foreach.icq.last}, {/if}{/foreach}<br>{/if}
                            </td>
                        </tr>
                    {/if}
                </table>
            {/if}
        </fieldset>
    {/foreach}
    {include file="../controls.tpl" control="pager"}
{else}
    ##NO_DATA##
{/if}