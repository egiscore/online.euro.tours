{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="hotels.css"}
{include file="../partial_top.tpl"}
<div id="hotels" class="details">
<table class="container">
    <tr>
        <td colspan="2" class="">
            <div class="hotel_header panel">
            <div class="st_hotel_logo">
                {if $hotel.logo}
                    <img src="{$hotel.logo}">
                {/if}
            </div>
            <div style="float: left;">
                <div class="hotellname">{$hotel.lname}</div>
                <div class="hotelname">{$hotel.name}</div>
            </div>
            <div class="starname">
            {if $hotel.starNum}
                <span class="star" style="width: {$hotel.starNum * 20}px"></span>
            {else}
                {$hotel.star}
            {/if}
            </div>
            {if $hotel.icons.viptype}
                <div class="icons">
                    {foreach from=$hotel.icons.viptype item="icon"}
                        <span class="icon hp {$icon.class}" data-title="{$icon.title|escape:'html'}"></span>
                    {/foreach}
                </div>
            {/if}
            </div>
        </td>
    </tr>
    <tr>
        <td class="left_container">
            {if $hotel.address || $hotel.phone || $hotel.fax || $hotel.www || $hotel.email || $hotel.meal || $hotel.location || $hotel.transfer}
                <div class="hotel_info panel">
                    <div class="hotel_info_header">
                      <div class="info_img"></div> <span>##HOTEL_INFO##</span>
                    </div>
                    <table class="descr">
                    {if $hotel.address}{assign var="param" value="1"}
                        <tr>
                            <td class="title">##HOTEL_ADDRESS##</td>
                            <td>{$hotel.address}</td>
                        </tr>
                    {/if}
                    {if $hotel.phone}{assign var="param" value="1"}
                        <tr>
                            <td class="title">##HOTEL_PHONE##</td>
                            <td>{$hotel.phprefix} {$hotel.phone}</td>
                        </tr>
                    {/if}
                    {if $hotel.fax}{assign var="param" value="1"}
                        <tr>
                            <td class="title">##HOTEL_FAX##</td>
                            <td>{$hotel.phprefix} {$hotel.fax}</td>
                        </tr>
                    {/if}
                    {if $hotel.www}{assign var="param" value="1"}
                        <tr>
                            <td class="title">##HOTEL_URL##</td>
                            <td><a href="{$hotel.www}">{$hotel.www|truncate:60}</a></td>
                        </tr>
                    {/if}
                    {if $hotel.email}{assign var="param" value="1"}
                        <tr>
                            <td class="title">##HOTEL_EMAIL##</td>
                            <td>{$hotel.email}</td>
                        </tr>
                    {/if}
                    {if $hotel.meal}
                        <tr{if $param && !$margin}{assign var="margin" value="1"} class="margin_top"{/if}>
                            <td class="title">##MEAL##:</td>
                            <td>{$hotel.meal|nl2br}</td>
                        </tr>
                    {assign var="param" value="1"}{/if}
                    {if $hotel.location}
                        <tr{if $param && !$margin}{assign var="margin" value="1"} class="margin_top"{/if}>
                            <td class="title">##HOTEL_LOCATION##</td>
                            <td>{$hotel.location|nl2br}</td>
                        </tr>
                    {assign var="param" value="1"}{/if}
                    {if $hotel.transfer}
                        <tr{if $param && !$margin}{assign var="margin" value="1"} class="margin_top"{/if}>
                            <td class="title">##TRANSFER##:</td>
                            <td>{$hotel.transfer|nl2br}</td>
                        </tr>
                    {assign var="param" value="1"}{/if}
                    </table>
                </div>
            {/if}
            {if $hotel.description || $hotel.note}
                <div class="hotel_layout panel">
                    <table>
                        <tr>
                            <td colspan="2">{if $hotel.description}<div>{$hotel.description}</div>{/if}{if $hotel.note}<p{if $hotel.description} class="hotel_note"{/if}>{$hotel.note}</p>{/if}</td>
                        </tr>
                    </table>
                </div>
            {/if}
            {if $hotel.params.data}
                <div class="params">
                    {foreach from=$hotel.params.data key="key" item="group"}
                        <div class="hotel_descr panel">
                            <div class="hotel_descr_header">
                                <div class="descr_img img_{$group.inc}"></div> <span>{if $LANG == 'rus'}{$group.name}{else}{$group.lname}{/if}</span>
                            </div>
                            {if $group.grouped}
                                <p class="content">
                                    {foreach from=$group.data item="param" name="params"}
                                        {if $param.type=='5'}{if $LANG == 'rus'}{$param.title}{else}{$param.ltitle}{/if}{*if $param.value!='+'} (<span class="content">{$param.value}</span>){/if*}{else}{if $LANG == 'rus'}{$param.title}{else}{$param.ltitle}{/if}{if $param.value || $param.value===0} &#8211; <span class="content">{$param.value}</span>{/if}{/if}{if !$smarty.foreach.params.last}, {else}.{/if}
                                    {/foreach}
                                </p>
                            {else}
                                <ul class="descr">
                                    {foreach from=$group.data item="param"}
                                        <li>{if $LANG == 'rus'}{$param.title}{else}{$param.ltitle}{/if}{if $param.type=='5'}{*if $param.value!='+'} (<span class="content">{$param.value}</span>){/if*}{else}{if $param.value || $param.value===0} &#8211; <span class="content">{$param.value}</span>{/if}{/if}</li>
                                    {/foreach}
                                </ul>
                            {/if}
                        </div>
                    {/foreach}
                </div>
            {/if}
        </td>
        <td class="photos">
            {map_init point=$hotel div="map_container"}
            {foreach from=$hotel.images item="pict"}
                <a rel="hotel-picture" class="thumbnail" href="{$pict.src}" title="{$pict.alt|escape:'html'}"><img src="{$pict.tmb}" data-width="{$pict.width}" data-height="{$pict.height}"></a>
            {/foreach}
        </td>
    </tr>
    {if $SHOW_ROOMS}
    <tr>
        <td colspan="2">
            <div class="hotel_descr panel">
                <div class="hotel_descr_header">
                    <div class="descr_img img_rooms"></div> <span>##ROOM_IN_HOTEL##</span>
                </div>

                {foreach from=$ROOMS item="room"}
                <table>
                        <tr>
                            <td style="font-size: 14pt;">
                                <b>{$room.LName}</b> ({$room.Name})
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {$room.Description}
                            </td>
                        </tr>
                    {if $room.Attributes}
                        <tr>
                            <td><br><b>##ROOM_ATTR_IN_THE_ROOM##</b> {$room.Attributes|glue}</td>
                        </tr>
                    {/if}
                </table>
                    <hr>
                {/foreach}

            </div>
        </td>
    </tr>
    {/if}
{if $NIGHTS_FROM && $NIGHTS_TILL}
    <tr>
        <td colspan="2">
            <div class="hotel_descr panel">
                <div class="hotel_descr_header">
                    <div class="descr_img img_prices"></div> <span>##PRICES##</span>
                </div>

                <div class="controls">
                    <table width="100%">
                    <tr>
                    <td class="n1">
                        <table>
                            <tr class="load_price">
                                <td>##TOWNFROM##</td>
                                <td>
                                    {include file="../controls.tpl" control="TOWNFROMINC" TOWNFROMINC=$TOWNFROMINC}
                                </td>
                                <td>##CHECKIN##</td>
                                <td><input type="text" class="frm-input date CHECKIN" name="CHECKIN" {datepicker_init data=$checkin} /></td>
                                <td>##NIGHTS_FROM##</td>
                                <td><select name="NIGHTS_FROM" class="NIGHTS_FROM spin"  autocomplete="off" >{foreach from=$NIGHTS_FROM item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}</select></td>
                                <td>##NIGHTS_TILL##</td>
                                <td><select name="NIGHTS_TILL" class="NIGHTS_TILL spin"  autocomplete="off" >{foreach from=$NIGHTS_TILL item="item"}<option value="{$item.id}" {if $item.selected}selected{/if}>{$item.name}</option>{/foreach}</select></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <td class="n2">
                        <table>
                            <tr>
                                <td>##CURRENCY##</td>
                                <td>
                                    <select class="CURRENCY" name="CURRENCY">
                                        {foreach from=$CURRENCY item="currency"}
                                            <option value="{$currency.id}" {if $currency.selected}selected="selected"{/if}>{$currency.alias}</option>
                                        {/foreach}
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </td>
                    </tr>
                    </table>
                </div>

                <div class="resultset">
                    {include file="prices.tpl"}
                </div>

            </div>
        </td>
    </tr>
{/if}
</table>
</div>
{include file="../common.tpl"}
{jsload file="jquery.fancybox.js,hotels.js"}
{cssload file="jquery.fancybox.css"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}