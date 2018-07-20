{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="hotels.css"}
{include file="../partial_top.tpl"}
<div id="hotels" class="container">
    <div class="info_header">
        {note}
        <table class="std container left">
            <tr>
                {if $state.flag}<td class="flag">
                    <img src="{$state.flag}">
                </td>{/if}
                <td{if !$state.flag} colspan="2"{/if}>
                    <div class="hotellname">{$state.StateLName}</div>
                    <div class="hotelname">{$state.StateName}</div>
                </td>
            </tr>
            <tr>
                {if $state.picts}<td valign="top" class="photos">
                    <table>
                        <tr>{foreach from=$state.picts item="pict" name="array"}
                            {if $smarty.foreach.array.iteration%2!=0}</tr><tr>{/if}
                            <td{if $smarty.foreach.array.iteration%2!=0 && $smarty.foreach.array.last} colspan="2"{/if}><a href="{$pict.orig}" title="{$pict.descr|escape:'html'}"><img src="{$pict.tn}" data-width="{$pict.width}" data-height="{$pict.height}"></a></td>
                        {/foreach}</tr>
                    </table>
                </td>{/if}
                <td valign="top"{if !$state.picts} colspan="2"{/if}>
                    {$state.about}
                </td>
            </tr>
            {if $regions}
            <tr>
                <td class="panel" colspan="2">
                    <table class="location">
                        <tr>
                            <td width="10%">##REGION##</td>
                            <td><select name="REGIONINC" class="REGIONINC location"><option value="">---</option>{foreach from=$regions item="item"}<option value="{$item.RegionInc}">{$item.RegionName}</option>{/foreach}</select></td>
                        </tr>
                    </table>
                </td>
            </tr>
            {/if}
        </table>
    </div>
    <div id="resultset"><div class="resultset">{if $hotels}{include file="resultset.tpl"}{/if}</div></div>
</div>
{include file="../common.tpl"}
{jsload file="jquery.fancybox.js,hotels.js"}
{cssload file="jquery.fancybox"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}