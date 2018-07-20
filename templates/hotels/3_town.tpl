{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="hotels.css"}
{include file="../partial_top.tpl"}
<div id="hotels" class="container">
    <div class="info_header">
        {note}
        <table class="std container left">
            <tr>
                {if $town.flag}<td class="flag">
                    <img src="{$town.flag}">
                </td>{/if}
                <td{if !$town.flag} colspan="2"{/if}>
                    <div class="hotellname">{$town.TownLName}</div>
                    <div class="hotelname">{$town.TownName}</div>
                </td>
            </tr>
            <tr>
                {if $town.picts}<td valign="top" class="photos">
                    <table>
                        <tr>{foreach from=$town.picts item="pict" key="key"}
                            {if $key%2==0 && $key!=0}</tr><tr>{/if}
                            <td><a href="{$pict.orig}" title="{$pict.descr|escape:'html'}"><img src="{$pict.tn}" data-width="{$pict.width}" data-height="{$pict.height}"></a></td>
                        {/foreach}</tr>
                    </table>
                </td>{/if}
                <td valign="top"{if !$town.picts} colspan="2"{/if}>
                    {$town.about}
                </td>
            </tr>
        </table>
    </div>
    <div class="resultset">{if $hotels}{include file="resultset.tpl"}{/if}</div>
</div>
{include file="../common.tpl"}
{jsload file="jquery.fancybox.js,hotels.js"}
{cssload file="jquery.fancybox"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}