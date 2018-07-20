{if $smarty.get.samo_action != 'embed' && $smarty.get.contentonly != '1'}
<!doctype html>
{/if}
{cssload file="common.css,fast_search.css"}
{cssload file="data/search_tour/icons.css" base="" required=false}
{cssload file="customer.css" required=false}
<div class="samo_container {$search_mode}" id="fast_search" class="" data-csrf-token="{$csrf_token}">
    {include file="../controls.tpl" control="SEARCHMODE"}
    <form method="get" target="_blank" action="{$routes[$search_mode].url}" id="fast_search_frm">
        <table class="panel n1">

            <tr class="townfrom-filter{if $search_mode == 'search_tour' && count($TOWNFROMINC) == 1} hidden{/if}">
                <td width="20%">##FS_TOWNFROM##</td>
                <td width="80%" class="b" colspan="3">
                    {include file="../controls.tpl" control="TOWNFROMINC" TOWNFROMINC=$TOWNFROMINC}
                </td>
            </tr>
            <tr>
                <td>##FS_STATE##</td>
                <td class="b" colspan="3">
                    <select autocomplete="off" name="STATEINC" class="STATEINC">
                        {foreach from=$STATEINC item="item"}
                            <option value="{$item.id}" data-search-string="{$item.name} {$item.nameAlt}" {if $item.selected}selected{/if}>{$item.name}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            <tr>
                <td>##FS_TOURINC##</td>
                <td class="b" colspan="3">
                    <select autocomplete="off" name="TOURINC" class="TOURINC">
                        {foreach from=$TOURINC item="item"}
                            <option value="{$item.id}" data-search-string="{$item.name} {$item.nameAlt}" {if $item.selected}selected{/if}>{$item.name}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            <tr class="category-filter">
                <td>##FS_CATEGORY##</td>
                <td class="b" colspan="3">
                    <select autocomplete="off" name="STARS" class="STARS">
                        <option value="0">##TOUR_ANY_LNAME##</option>
                        {foreach from=$STARS item="item"}
                            <option value="{$item.id}" data-search-string="{$item.name} {$item.nameAlt}" {if $item.selected}selected{/if}>{$item.name}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            <tr>
                <td>##FS_HOTELINC##</td>
                <td class="b" colspan="3">
                    <select autocomplete="off" name="HOTELS" class="HOTELS">
                        <option value="0">##TOUR_ANY_LNAME##</option>
                        {foreach from=$HOTELS item="item"}
                            <option value="{$item.id}" data-search-string="{$item.name} {$item.nameAlt}" {if $item.selected}selected{/if}>{$item.name} {$item.star}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            <tr class="subfilter0{if !$PACKET.0.available || (!$PACKET.1.available && !$PACKET.2.available)} hidden{/if}"><td>&nbsp;</td><td colspan="3" class="l"><input type="radio" name="PACKET" value="0"/>##FS_FULL_PACKET##</td></tr>
            <tr class="subfilter1{if !$PACKET.1.available} hidden{/if}"><td>&nbsp;</td><td colspan="3" class="l"><input type="radio" name="PACKET" value="1"/>##FS_AVIATICKET_ONLY##</td></tr>
            <tr>
                <td>##FS_CHECKIN##</td><td class="l"><input autocomplete="off" type="text" class="frm-input date CHECKIN_BEG" data-name="CHECKIN_BEG" data-copyto="CHECKIN_BEG_FORM,CHECKIN_END_FORM" {datepicker_init data=$CHECKIN_BEG}/><input type="hidden" name="CHECKIN_BEG" id="CHECKIN_BEG_FORM"><input type="hidden" name="CHECKIN_END" id="CHECKIN_END_FORM"></td>
                <td>##FS_NIGHTS##</td><td class="r"><select name="NIGHTS_TILL" class="NIGHTS_TILL spin" autocomplete="off" >{foreach from=$NIGHTS_TILL item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}</select></td>
            </tr>
            <tr>
                <td>##FS_ADULTS##</td><td class="l"><select name="ADULT" class="ADULT spin" autocomplete="off" >{foreach from=$ADULT item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}</select></td>
                <td>##FS_CHILDS##</td><td class="r"><select name="CHILD" class="CHILD spin" autocomplete="off" >{foreach from=$CHILD item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}</select></td>
            </tr>
            <tr>
                <td>##FS_PRICE##</td><td class="l"><input autocomplete="off" type="text" class="frm-input spin-button price COSTMAX" name="COSTMAX" value="{$COSTMAX}" /></td>
                <td>##FS_CURRENCY##</td><td class="r"><select class="CURRENCY spin" name="CURRENCY"  autocomplete="off" >{foreach from=$CURRENCY item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>{$item.alias}</option>{/foreach}</select></td>
            </tr>
            <tr>
                <td colspan="4" class="submit"><input type="submit" class="load" value="##FS_LOAD##" /></td>
            </tr>
        </table>
        <input type="hidden" name="DOLOAD" value="1" />
        {if !$search_mode}{assign var="search_mode" value="search_tour"}{/if}
        <input type="hidden" name="page" value="{$search_mode}" />
    </form>
</div>
{include file="../common.tpl"}

{jsload file="fast_search.js"}
