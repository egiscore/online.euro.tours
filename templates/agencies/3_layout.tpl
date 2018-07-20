{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="agencies.css"}
{include file="../partial_top.tpl"}
<div id="agencies" class="container">
    {note}
    <div class="controls">
        <table class="panel">
            <tr>
                <td class="r">##AGENCIES_TOWN##</td>
                <td width="40%">
                        <select data-placeholder="##TOWN_ANY##" name="TOWN" class="TOWN string" autocomplete="off"><option value=""></option>{foreach from=$TOWNS key="key" item="options"}<optgroup label="{$key}">{foreach from=$options item="item"}<option value="{$item.id}" {if $item.selected}selected{/if} data-search-string="{$item.tags|@glue:" "}">{$item.name}</option>{/foreach}</optgroup>{/foreach}</select>
                </td>
                <td class="r">##AGENCIES_METROSTATION_FILTER##</td>
                <td width="40%">
                    <select data-placeholder="##METROSTATION_ANY##"  name="METROSTATION" class="METROSTATION string" autocomplete="off"><option value=""></option>{foreach from=$METROSTATIONS key="key" item="options"}<optgroup label="{$key}">{foreach from=$options item="item"}<option value="{$item.id}" {if $item.selected}selected{/if} data-search-string="{$item.tags|@glue:" "}">{$item.name}</option>{/foreach}</optgroup>{/foreach}</select>
                </td>
            </tr>
            <tr>
                <td class="r">##AGENCIES_SEARCH_LABEL##</td>
                <td colspan="3">
                    <table width="100%">
                        <tr>
                        <td class="query-container">
                            <input type="search" class="frm-input QUERY" name="QUERY" value="{$smarty.get.QUERY|escape:'html'}" placeholder="##AGENCIES_ENTER_YOUR_QUERY##">
                        </td>
                        <td class="r"><button class="load">##AGENCIES_SEARCH##</button></td>
                    </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="resultset">{if $AGENCIES || $smarty.get.DOLOAD == 1}{include file="3_resultset.tpl"}{/if}</div>
</div>
{include file="../common.tpl"}

{jsload file="agencies.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}
