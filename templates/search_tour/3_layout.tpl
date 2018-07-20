{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="search_tour.css"}
{include file="../partial_top.tpl"}
<div id="search_tour">
    {note}

    {assign var="only_hotel" value=true}
    {foreach $TOWNFROMINC as $townfrom}
        {if $townfrom.id != Samo::TOWNFROMHOTELINC}
            {assign var="only_hotel" value=false}
        {/if}
    {/foreach}

    <div class="std container">
        {if $SEARCH_INCOMINGPARTNER_FILTER == 2}
            <div class="incoming-slider{if $PARTNER_SELECTED} open{/if}{if !$INCOMINGPARTNER} hidden{/if}">
                <div class="btn">
                    <div>##TOUR_SEARCH_INCOMINGPARTNER##<span></span></div>
                </div>
                <div class="panel">
                    <div class="checklistbox INCOMINGPARTNER"
                         name="INCOMINGPARTNER">{include file="../api_controls.tpl" control="checklistbox_html" elements=$INCOMINGPARTNER}</div>
                </div>
            </div>
        {/if}

        {include file="../controls.tpl" control="SEARCHMODE"}


        <table class="direction panel">
            <tr>
                <td class="vt width50p">
                    <table class="width100p">
                        <tr>
                            {if $only_hotel}
                                {if $STATEFROM && count($STATEFROM) > 1}
                                    <td class="direction_left">##TOUR_HOTEL_STATEFROM##</td>
                                    <td class="direction_right"><select name="STATEFROM"
                                                                        class="STATEFROM">{foreach from=$STATEFROM item="item"}
                                                <option value="{$item.id}"
                                                        {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}
                                        </select></td>
                                {else}
                                    <td class="direction_left" colspan="2"><select style="visibility: hidden"></select>
                                    </td>
                                {/if}
                            {else}
                                <td class="direction_left">##TOUR_SEARCH_TOWNFROM##</td>
                                <td class="direction_right">
                                    {include file="../controls.tpl" control="TOWNFROMINC" TOWNFROMINC=$TOWNFROMINC}
                                </td>
                            {/if}
                        </tr>
                        <tr>
                            <td class="direction_left">##TOUR_SEARCH_STATE##</td>
                            <td class="direction_right">
                                <select name="STATEINC" class="STATEINC" autocomplete="off">
                                    {foreach from=$STATEINC item="item"}
                                        <option value="{$item.id}" data-search-string="{$item.name} {$item.nameAlt}"
                                                {if $item.selected}selected{/if}>{$item.name}</option>
                                    {/foreach}
                                </select>
                            </td>
                        </tr>
                        {if $SEARCH_INCOMINGPARTNER_FILTER == 1 and $SEARCH_TOURTYPE_FILTER == 1 and $SEARCH_PROGRAMTYPE_FILTER > 0}
                            <tr>
                                <td class="direction_left">##TOUR_SEARCH_INCOMINGPARTNER##</td>
                                <td class="direction_right">
                                    <select name="INCOMINGPARTNER" class="INCOMINGPARTNER" autocomplete="off">
                                        {foreach from=$INCOMINGPARTNER item="item"}
                                            <option value="{$item.id}" data-search-string="{$item.name} {$item.nameAlt}"
                                                    {if $item.selected}selected{/if}{if $item.attributes} {$item.attributes|@glue}{/if}>{$item.name}</option>
                                        {/foreach}
                                    </select>
                                </td>
                            </tr>
                        {/if}
                        {if $SEARCH_PROGRAMTYPE_FILTER > 0 && ($SEARCH_INCOMINGPARTNER_FILTER == 1 || $SEARCH_TOURTYPE_FILTER == 1) && ($SEARCH_INCOMINGPARTNER_FILTER != 1 || $SEARCH_TOURTYPE_FILTER != 1)}
                            <tr class="ptype_filter{if $PROGRAMGROUPINC} with_groups{/if}">
                                <td class="tour_left">##TOUR_SEARCH_GROUPPROGRAMTYPE##</td>
                                <td class="tour_right">
                                    {if $SEARCH_PROGRAMTYPE_FILTER == 3}
                                        <select name="PROGRAMINC" class="PROGRAMINC width100p"
                                                autocomplete="off">{foreach from=$PROGRAMINC item="item"}
                                                <option value="{$item.id}"
                                                        {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}
                                        </select>
                                    {else}
                                        <select name="PROGRAMGROUPINC" class="PROGRAMGROUPINC width100p"
                                                autocomplete="off">{foreach from=$PROGRAMGROUPINC item="item"}
                                                <option value="{$item.id}"
                                                        {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}
                                        </select>
                                    {/if}
                                </td>
                            </tr>
                        {/if}
                    </table>
                </td>
                <td class="vt width50p">
                    <table class="width100p">
                        {if $SEARCH_INCOMINGPARTNER_FILTER == 1 and ($SEARCH_TOURTYPE_FILTER == 0 or $SEARCH_PROGRAMTYPE_FILTER == 0)}
                            <tr>
                                <td class="tour_left">##TOUR_SEARCH_INCOMINGPARTNER##</td>
                                <td class="tour_right"><select name="INCOMINGPARTNER" class="INCOMINGPARTNER"
                                                               autocomplete="off">{foreach from=$INCOMINGPARTNER item="item"}
                                            <option value="{$item.id}"
                                                    {if $item.selected}selected{/if}{if $item.attributes} {$item.attributes|@glue}{/if}>{$item.name}</option>{/foreach}
                                    </select></td>
                            </tr>
                        {/if}
                        {if $SEARCH_TOURTYPE_FILTER == 1}
                            <tr>
                                <td class="tour_left">##TOUR_SEARCH_TOURTYPE##</td>
                                <td class="tour_right">
                                    <select name="TOURTYPE" class="TOURTYPE" autocomplete="off">
                                        {foreach from=$TOURTYPE item="item"}
                                            <option value="{$item.id}" data-search-string="{$item.name} {$item.nameAlt}"
                                                    {if $item.selected}selected{/if}{if $item.attributes} {$item.attributes|@glue}{/if}>{$item.name}</option>
                                        {/foreach}
                                    </select>
                                </td>
                            </tr>
                        {/if}
                        <tr>
                            <td class="tour_left">##TOUR_SEARCH_TOURNAME##</td>
                            <td class="tour_right">
                                <select name="TOURINC" class="TOURINC" autocomplete="off">
                                    {foreach from=$TOURINC item="item"}
                                        <option value="{$item.id}" data-search-string="{$item.name} {$item.nameAlt}"
                                                {if $item.selected}selected{/if}>{$item.name}</option>
                                    {/foreach}
                                </select>
                            </td>
                        </tr>
                        {if $SEARCH_PROGRAMTYPE_FILTER > 0 && (($SEARCH_INCOMINGPARTNER_FILTER == 1 && $SEARCH_TOURTYPE_FILTER == 1) || ($SEARCH_INCOMINGPARTNER_FILTER != 1 && $SEARCH_TOURTYPE_FILTER != 1))}
                            <tr{if $SEARCH_PROGRAMTYPE_FILTER != 3} class="ptype_group_filter{if !$PROGRAMGROUPINC} hidden{/if}"{/if}>
                                <td class="tour_left">##TOUR_SEARCH_GROUPPROGRAMTYPE##</td>
                                <td class="tour_right">
                                    {if $SEARCH_PROGRAMTYPE_FILTER == 3}
                                        <select name="PROGRAMINC" class="PROGRAMINC width100p" autocomplete="off">
                                            {foreach from=$PROGRAMINC item="item"}
                                                <option value="{$item.id}"
                                                        data-search-string="{$item.name} {$item.nameAlt}"
                                                        {if $item.selected}selected{/if}>{$item.name}</option>
                                            {/foreach}
                                        </select>
                                    {else}
                                        <select name="PROGRAMGROUPINC" class="PROGRAMGROUPINC width100p"
                                                autocomplete="off">
                                            {foreach from=$PROGRAMGROUPINC item="item"}
                                                <option value="{$item.id}"
                                                        data-search-string="{$item.name} {$item.nameAlt}"
                                                        {if $item.selected}selected{/if}>{$item.name}</option>
                                            {/foreach}
                                        </select>
                                    {/if}
                                </td>
                            </tr>
                        {/if}
                        {if $SEARCH_PROGRAMTYPE_FILTER == 1}
                            <tr>
                                <td class="tour_left">##TOUR_SEARCH_PROGRAMTYPE##</td>
                                <td class="tour_right">
                                    <select name="PROGRAMINC" class="PROGRAMINC width100p"
                                            autocomplete="off">{foreach from=$PROGRAMINC item="item"}
                                            <option value="{$item.id}"
                                                    {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}
                                    </select>
                                </td>
                            </tr>
                        {/if}
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="note_container{if empty($NOTE)} blank-note{/if}">{$NOTE}</td>
            </tr>
        </table>


        <table class="user_info">
            <tr>
                <td class="col">
                    <table class="panel">
                        <tr>
                            <td class="description">{block name="CHECKIN_BEG_LABEL"}##TOUR_SEARCH_CHECKIN_FROM##{/block}</td>
                            <td class="calendar"><input type="text" name="CHECKIN_BEG"
                                                        class="frm-input date CHECKIN_BEG"
                                                        autocomplete="off" {datepicker_init data=$CHECKIN_BEG}/></td>
                            <td class="description2">##TOUR_SEARCH_NIGHTS_FROM##</td>
                            <td class="nights">
                                <select name="NIGHTS_FROM" class="NIGHTS_FROM spin nights"
                                        autocomplete="off">{foreach from=$NIGHTS_FROM item="item"}
                                        <option value="{$item.id}"
                                                {if $item.selected}selected{/if} {if $item.attributes['class-yesplace']}class="yesplace"{/if}>{$item.name}</option>{/foreach}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="description">{block name="CHECKIN_END_LABEL"}##TOUR_SEARCH_CHECKIN_TO##{/block}</td>
                            <td class="calendar"><input type="text" class="frm-input date CHECKIN_END"
                                                        autocomplete="off"
                                                        name="CHECKIN_END" {datepicker_init data=$CHECKIN_END}/></td>
                            <td class="description2">##TOUR_SEARCH_NIGHTS_TILL##</td>
                            <td class="nights">
                                <select name="NIGHTS_TILL" class="NIGHTS_TILL spin nights"
                                        autocomplete="off">{foreach from=$NIGHTS_TILL item="item"}
                                        <option value="{$item.id}"
                                                {if $item.selected}selected{/if} {if $item.attributes['class-yesplace']}class="yesplace"{/if}>{$item.name}</option>{/foreach}
                                </select>
                            </td>
                        </tr>
                    </table>

                <td class="empty">&nbsp;</td>
                <td class="col">
                    <table class="panel">
                        <tr>
                            <td class="description3">##TOUR_SEARCH_ADULTS##</td>
                            <td class="tourists"><select name="ADULT" class="ADULT spin"
                                                         autocomplete="off">{foreach from=$ADULT item="item"}
                                        <option value="{$item.id}"
                                                {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}
                                </select></td>
                            <td class="description4"><span class="currency_label">##TOUR_SEARCH_CONTROL_PRICE##</span>
                            </td>
                            <td class="cost"><select class="CURRENCY" name="CURRENCY"
                                                     autocomplete="off">{foreach from=$CURRENCY item="item"}
                                        <option value="{$item.id}"
                                                {if $item.selected}selected{/if}>{$item.alias}</option>{/foreach}
                                </select></td>
                            <td class="from">##TOUR_SEARCH_PRICE_MIN##</td>
                            <td class="count"><input type="text" data-currency="{$CURR}" name="COSTMIN"
                                                     value="{$COSTMIN}" class="frm-input price COSTMIN"
                                                     data-value="{$COSTMIN}" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td class="description3">##TOUR_SEARCH_CHILDS##</td>
                            <td class="tourists"><select name="CHILD" class="CHILD spin"
                                                         autocomplete="off">{foreach from=$CHILD item="item"}
                                        <option value="{$item.id}"
                                                {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}
                                </select></td>
                            <td colspan="2" class="child_ages_container">
                                <div class="child_ages">
                                    <select name="AGE1" class="age age_1" autocomplete="off">
                                        {section start=0 loop=$MAX_CHILD_AGE + 1 name="age"}
                                            <option value="{$smarty.section.age.index}"
                                                    {if $smarty.section.age.index == $AGE1}selected="selected"{/if}>{$smarty.section.age.index}</option>{/section}
                                    </select>
                                    <select name="AGE2" class="age age_2" autocomplete="off">
                                        {section start=0 loop=$MAX_CHILD_AGE + 1 name="age"}
                                            <option value="{$smarty.section.age.index}"
                                                    {if $smarty.section.age.index == $AGE2}selected="selected"{/if}>{$smarty.section.age.index}</option>{/section}
                                    </select>
                                    <select name="AGE3" class="age age_3" autocomplete="off">
                                        {section start=0 loop=$MAX_CHILD_AGE + 1 name="age"}
                                            <option value="{$smarty.section.age.index}"
                                                    {if $smarty.section.age.index == $AGE3}selected="selected"{/if}>{$smarty.section.age.index}</option>{/section}
                                    </select>
                                </div>
                            </td>
                            <td class="from">##TOUR_SEARCH_PRICE_MAX##</td>
                            <td class="count"><input type="text" data-currency="{$CURR}" data-value="{$COSTMAX}"
                                                     name="COSTMAX" autocomplete="off" value="{$COSTMAX}"
                                                     class="frm-input price COSTMAX"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


        <table class="programm_filter panel{if !$PACKET.1.available && (!$PACKET.2.available || $only_hotel)} hidden{/if}">
            <tr>
                <td>
                    <label class="subfilter0{if !$PACKET.0.available} hidden{/if}"><input type="radio" name="PACKET"
                                                                                          value="0"
                                                                                          {if $PACKET.0.selected}checked="checked"{/if}
                                                                                          autocomplete="off"
                                                                                          class="FULLPACKET">##FILTER_FULL_PACKET##</label>
                    <label class="subfilter1{if !$PACKET.1.available} hidden{/if}"><input type="radio" name="PACKET"
                                                                                          value="1"
                                                                                          {if $PACKET.1.selected}checked="checked"{/if}
                                                                                          class="NOHOTELS"
                                                                                          autocomplete="off">##FILTER_AVIATICKET_ONLY##</label>
                    <label class="subfilter2{if !$PACKET.2.available} hidden{/if}"><input type="radio" name="PACKET"
                                                                                          value="2"
                                                                                          {if $PACKET.2.selected}checked="checked"{/if}
                                                                                          autocomplete="off">##FILTER_HOTEL_ONLY##</label>
                </td>
            </tr>
        </table>


        <table class="hotels_container panel{if $HOTELSSEL} with-hotelssel{/if}">
            <tr class="HOTELSCONTAINER">

                <td class="control_townto">
                    <div class="header">
                        <span class="left">##TOUR_SEARCH_TOWN_TO##</span><span class="right"><label><input
                                        type="checkbox" name="TOWNS_ANY" class="TOWNS_ANY" checked="checked">##TOUR_SEARCH_ANY_TOWN##</label></span>
                    </div>

                    <div class="checklistbox TOWNS"
                         name="TOWNS">{include file="../api_controls.tpl" control="checklistbox_html" elements=$TOWNS}</div>

                </td>


                <td class="control_stars">
                    <div class="header">
                        <span class="left">##TOUR_SEARCH_HOTEL_CATEGORY##</span><span class="right"><label><input
                                        type="checkbox" name="STARS_ANY" class="STARS_ANY" checked="checked">##TOUR_SEARCH_ANY_STARS##</label></span>
                    </div>

                    <div class="checklistbox STARS"
                         name="STARS">{include file="../api_controls.tpl" control="hotel_category" SHOWICON=true ICONTYPE='hp' STARS=$STARS HOTELTYPES=$HOTELTYPES}</div>
                </td>


                <td class="control_hotels">
                    <div class="header">
                        <span class="left">##TOUR_SEARCH_HOTELS## <input type="search" name="hotelsearch"
                                                                         autocomplete="off" class="hotelsearch"> <label><input
                                        type="checkbox" name="HOTELS_SEL" class="HOTELS_SEL" autocomplete="off"> ##SHOW_ONLY_SELECTED##</label></span><span
                                class="right"><label><input type="checkbox" name="HOTELS_ANY" class="HOTELS_ANY"
                                                            checked="checked">##TOUR_SEARCH_ANY_HOTEL##</label></span>
                    </div>
                    {if $HOTELSSEL}
                        <div class="checklistbox HOTELSSEL w380" name="HOTELSSEL"></div>
                    {/if}
                    <div class="checklistbox HOTELS w380" name="HOTELS">
                        {include file="../controls.tpl" control="checklistbox_hotels" elements=$HOTELS}
                    </div>
                </td>


                <td class="control_meal">
                    <div class="header">
                        <span class="left">##TOUR_SEARCH_MEAL##</span><span class="right"><label><input type="checkbox"
                                                                                                        name="MEALS_ANY"
                                                                                                        class="MEALS_ANY"
                                                                                                        checked="checked">##TOUR_SEARCH_ANY_MEAL##</label></span>
                    </div>

                    <div class="checklistbox MEALS {if $ROOMS && count($ROOMS) > 1}small_meal{/if}"
                         name="MEALS">{include file="../api_controls.tpl" control="checklistbox_html" elements=$MEALS}</div>


                    {if $ROOMS && count($ROOMS) > 1}
                        <div class="header">
                            <span class="left">##TOUR_SEARCH_ROOM_2##</span><span class="right"><label><input
                                            type="checkbox" name="ROOMS_ANY" class="ROOMS_ANY" checked="checked">##TOUR_SEARCH_ANY_ROOM##</label></span>
                        </div>
                        <div class="checklistbox ROOMS"
                             name="ROOMS">{include file="../api_controls.tpl" control="checklistbox_html" elements=$ROOMS}</div>
                    {/if}
                </td>

            </tr>
            <tr class="filters-panel{if !$SEARCH_UFILTER} no-ufilter{/if}">
                <td colspan="{if !$SEARCH_UFILTER}4{else}2{/if}">
                    <div class="header">
                        <span class="left">##FILTERS##</span>
                    </div>
                    <div class="checklistbox">
                        <label class="left"><input type="checkbox" class="CHILD_IN_BED" name="CHILD_IN_BED"
                                                   {if $child_in_bed}checked="checked"{/if} autocomplete="off">
                            ##TOUR_SEARCH_CHILD_IN_BED##</label>
                        {if !$only_hotel}
                            <label class="left "><input type="checkbox" class="FREIGHT" name="FREIGHT"
                                                        {if $freight}checked="checked"{/if} autocomplete="off">
                                ##TOUR_SEARCH_FREIGHT_AVAIL##</label>
                        {/if}
                        <label class="left"><input type="checkbox" class="FILTER" name="FILTER"
                                                   {if $filter}checked="checked"{/if} autocomplete="off">
                            ##TOUR_SEARCH_HOTEL_NOT_STOPSALE##</label>
                        <label class="left"><input type="checkbox" class="MOMENT_CONFIRM" name="MOMENT_CONFIRM"
                                                   {if $moment_confirm}checked="checked"{/if} autocomplete="off">
                            ##TOUR_SEARCH_MOMENT_CONFIRM##</label>
                    </div>
                </td>
                {if $SEARCH_UFILTER}
                    <td colspan="2">
                        <div class="header">
                            <span class="left">##PROMOTIONS##</span>
                        </div>
                        <div class="checklistbox UFILTER" name="UFILTER">
                            {include file="../api_controls.tpl" control="checklistbox_html" SHOWICON=true ICONTYPE="uf" elements=$UFILTER}
                        </div>
                    </td>
                {/if}
            </tr>
            <tr>
                <td colspan="7" class="footer">
                    <button class="load right btn btn-success" disabled="disabled">##TOUR_SEARCH_REFRESH##</button>
                    <label class="right hotelgroup"><input type="checkbox" class="PARTITION_PRICE"
                                                           name="PARTITION_PRICE"
                                                           {if ($PARTITION_PRICE == (Search_Api::PARTITION_BY_HOTEL + Search_Api::PARTITION_BY_CHECKIN + Search_Api::PARTITION_BY_NIGHTS)) or $DEFAULT_GROUP_BY_HOTEL == 1}checked{/if}
                                                           value="{Search_Api::PARTITION_BY_HOTEL + Search_Api::PARTITION_BY_CHECKIN + Search_Api::PARTITION_BY_NIGHTS}">##TOUR_SEARCH_PARTITION_PRICE##</label>
                </td>
            </tr>
        </table>
    </div>

    <table class="price_legend">
        <tr>
            <td><span class="places"></span><span>- ##TOUR_SEARCH_LEGEND_PLACE##</span></td>
            <td><span class="confirm_now_img green_row"></span> - ##TOUR_SEARCH_PRICE_LEGEND_CONFIRM_NOW##</td>
            <td><span class="stop_sale_img red_row"></span> - ##TOUR_SEARCH_PRICE_LEGEND_STOP_SALE##</td>
        </tr>
        <tr>
            <td><span class="hotel_availability_img"></span> - ##TOUR_SEARCH_LEGEND_HOTEL_AVAILABILITY##</td>
            <td><span class="price_stats_img"></span> - ##TOUR_SEARCH_PRICE_STATS##</td>
            <td><span class="best_price_img"></span> - ##TOUR_SEARCH_PRICE_THE_BEST##</td>
        </tr>
    </table>

    <div class="resultset">{if $prices or $smarty.get.DOLOAD}{include file="resultset.tpl"}{else}&nbsp;{/if}</div>
    <div class="resultsetGrouped hidden"></div>
</div>
{include file="../common.tpl"}

{jsload file="search_tour.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}
