{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="hotels.css"}
{include file="../partial_top.tpl"}
<div id="hotels" class="container">
    <div class="info_header">
        {note}
        <table class="std container left">
            <tr>
                {if $region.flag}<td class="flag">
                    <img src="{$region.flag}">
                </td>{/if}
                <td{if !$region.flag} colspan="2"{/if}>
                    <div class="hotellname">{$region.RegionLName}</div>
                    <div class="hotelname">{$region.RegionName}</div>
                </td>
            </tr>
            <tr>
                {if $region.picts}<td valign="top" class="photos">
                    <table>
                        <tr>{foreach from=$region.picts item="pict" key="key"}
                            {if $key%2==0 && $key!=0}</tr><tr>{/if}
                            <td><a href="{$pict.orig}" title="{$pict.descr|escape:'html'}"><img src="{$pict.tn}" data-width="{$pict.width}" data-height="{$pict.height}"></a></td>
                        {/foreach}</tr>
                    </table>
                </td>{/if}
                <td valign="top"{if !$region.picts} colspan="2"{/if}>
                    {$region.about}
                </td>
            </tr>
            {if $towns}<tr>
                <td class="panel" colspan="2">
                    <table class="location">
                        <tr>
                            <td width="10%">##TOWNTO##</td>
                            <td><select name="TOWNTO" class="TOWNTO location"><option value="">---</option>{foreach from=$towns item="item"}<option value="{$item.TownInc}">{$item.TownName}</option>{/foreach}</select></td>
                        </tr>
                    </table>
                </td>
            </tr>
            {/if}
        </table>
    </div>
    <div class="resultset location">{if $hotels}{include file="resultset.tpl"}{/if}</div>
</div>
{include file="../common.tpl"}
{jsload file="jquery.fancybox.js,hotels.js"}
{cssload file="jquery.fancybox"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}