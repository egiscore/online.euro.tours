{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="hotels.css"}
{include file="../partial_top.tpl"}
<div id="hotels">
    {note}
    <table class="container two_col">
        <tr>
            <td class="form col">
                <div class="block panel opened">
                    <div class="title">
                        <div class="icon location"></div>
                        <span>##DIRECTION##</span>
                    </div>
                    <div class="container">
                        <table align="center" class="location">
                            <tr>
                                <td class="legend">##STATE##</td>
                                <td>
                                    <select class="STATEINC" name="STATEINC">{foreach from=$STATEINC item="item"}<option data-search-string="{$item.altName} {$item.Name}" value="{$item.Inc}" {if $item.selected}selected{/if}>{$item.LName}</option>{/foreach}</select>
                                </td>
                            </tr>
                            <tr>
                                <td class="legend">##REGION##</td>
                                <td>
                                    <select name="REGIONINC" class="REGIONINC">{foreach from=$REGIONINC item="item"}<option data-search-string="{$item.altName} {$item.Name}" value="{$item.Inc}" {if $item.selected}selected{/if}>{$item.LName}</option>{/foreach}</select>
                                </td>
                            </tr>
                            <tr class="last">
                                <td class="legend">##TOWNTO##</td>
                                <td>
                                    <select name="TOWNTO" class="TOWNTO">{foreach from=$TOWNTO item="item"}<option data-search-string="{$item.altName} {$item.Name}" value="{$item.Inc}" {if $item.selected}selected{/if}>{$item.LName}</option>{/foreach}</select>
                                </td>
                            </tr>
                        </table>   
                    </div>
                </div>
                
                <div class="block panel no_title opened">
                    <div class="textinput">
                        <div class="label">##HOTEL_NAME##</div>
                        <input class="frm-input" type="text" name="HOTELNAME" value="{$smarty.get.HOTELNAME}">
                    </div>
                </div>
                
                <div class="block panel opened">
                    <div class="title">
                        <div class="icon star"></div>
                        <span>##STAR##</span>
                    </div>
                    <div class="container no_more">
                        <div class="checklistbox CATEGORY" name="CATEGORY">
                            {include file="../controls.tpl" control="checklistbox_html" elements=$CATEGORY}
                        </div>
                        <div class="checklistbox top_border PARAMS--viptype" name="PARAMS--viptype">
                            {if $VIPTYPE}
                                {include file="../controls.tpl" control="checklistbox_html" elements=$VIPTYPE}
                            {/if}
                        </div>
                        <label class="any"><input type="hidden" value="1" name="CATEGORY_ANY" class="CATEGORY_ANY">##STAR_ANY##</label>
                        <div style="clear: both;"></div>
                    </div>
                </div>
                <div class="PARAMS">
                    {include file="controls.tpl" control="checklistbox_grouped" elements=$PARAMS}
                </div>
                <div class="link more"><a href="#" class="more" data-empty="##SHOW_MORE##" data-selected="##SHOW_MORE_SELECT##" data-close="##SHOW_MORE_CLOSE##">##SHOW_MORE##</a></div>
                <button class="load" disabled="disabled">##SEARCH##</button>
                <a href="#" class="search_link" target="_blank">##SEARCH_LINK##</a>
            </td>
            <td class="col">
                <div class="resultset scrolling">{include file="resultset.tpl"}</div>
            </td>
        </tr>
    </table>
</div>
{include file="../common.tpl"}
{jsload file="hotels.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}