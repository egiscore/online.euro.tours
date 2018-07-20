{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="sale.css"}
{include file="../partial_top.tpl"}
<div id="sale" class="container">
    {note}
    {if $MAP_KEY}
        <div id="google_map">
            <div id="map_canvas"></div>
            <script src="//maps.google.com/maps/api/js?key={$MAP_KEY}" type="text/javascript"></script>
            <script type="text/html" id="partner-info-tpl">
                {literal}
                <div class="panel partner-info">
                    <fieldset>
                        <legend><%= partner.name %></legend>
                        <table class="res">
                        <tr><td><%= partner.town %></td><td><% if (partner.metrostation) { %>##METRO_SHORT## <%= partner.metrostation %><% } %></td></tr>
                        <% if (partner.address) { %>
                            <tr><td>##ADDRESS##</td><td><%= partner.address %></td></tr>
                        <% } %>
                        <% if (partner.phones) { %>
                            <tr><td>##PHONES##</td><td><% if (partner.phonePrefix) {%>(<%= partner.phonePrefix %>) <% } %><%= partner.phones %></td></tr>
                        <% } %>
                        <% if (partner.email) { %>
                        <tr><td>##EMAIL##</td><td><%= partner.email %></td></tr>
                        <% } %>
                        <% if (partner.www) { %>
                        <tr><td>##WWW##</td><td><%= partner.www %></td></tr>
                        <% } %>
                        </table>
                    </fieldset>
                </div>
                {/literal}
            </script>
        </div>
    {/if}
    <div class="controls">
        <table class="std panel n1">
            <tr>
                <td width="10%">##SALE_TOWN##</td>
                <td width="40%"><select name="TOWNINC"  class="TOWNINC" autocomplete="off" >{foreach from=$TOWNINC item="item"}<option data-search-string="{$item.LName} {$item.altName}" value="{$item.Inc}" {if $item.selected}selected{/if}>{$item.LName}</option>{/foreach}</select></td>
                <td width="10%" class="metroBlock">##SALE_METRO##</td>
                <td width="40%" class="metroBlock"><select name="METRO" class="METRO string" autocomplete="off" >{foreach from=$METRO item="item"}<option data-search-string="{$item.LName} {$item.altName}" value="{$item.Inc}" {if $item.selected}selected{/if}>{$item.LName}</option>{/foreach}</select></td>
            </tr>
        </table>
    </div>
    <div class="resultset">{if $SALELIST}{include file="resultset.tpl"}{/if}</div>
</div>
{include file="../common.tpl"}
{jsload file="markerclusterer.js" base="public/js/marker_clusterer/"}
{jsload file="ejs.js" base="public/js/sale/"}
{jsload file="jquery.fancybox.js,sale.js"}
{cssload file="jquery.fancybox.css"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}
