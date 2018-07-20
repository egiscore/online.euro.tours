{if $hotels} 
    <table class="res">
        <thead>
            <tr>
                <th>##HOTELNAME##</th>
                <th>##STARNAME##</th>
                <th>##STATENAME##</th>
                <th>##TOWNNAME##</th>
                <th>##PARAMS##</th>
                {if $searchTour}
                    <th style="width: 100px;" nowrap>##FIND_TOUR##</th>
                {/if}
            </tr>
        </thead>
        <tbody>
            {foreach from=$hotels item="hotel"}
            <tr class="{cycle values="even,odd"}" data-hotel="{$hotel.key}" data-state="{$hotel.stateKey}" data-region="{$hotel.regionKey}" data-town="{$hotel.townKey}" data-www="{$hotel.www}">
                <td>{if $hotel.www}<span class="link hotel">{/if}{$hotel.lname}{if $hotel.www}</span>{/if}</td>
                <td>{if $hotel.starNum}<span class="star" style="width: {$hotel.starNum * 20}px"></span>{else}{$hotel.star}{/if}</td>
                <td>{if $hotel.stateEnable}<span class="link state">{/if}{$hotel.stateLName}{if $hotel.stateEnable}</span>{/if}</td>
                <td>{if $hotel.townEnable}<span class="link town">{/if}{$hotel.townLName}{if $hotel.townEnable}</span>{/if}</td>
                <td>
                    {if ($hotel.params.data|@count > 5 && $hotel.params.find|@count!=0 || $hotel.params.miss|@count!=0) || $hotel.params.miss|@count > 0}
                        <span class="show-detail ui-icon ui-icon-triangle-1-s" title="##ALL_PARAMS##" style="float: right;"></span>
                    {/if}
                    <div class="briefly">
                    {if $hotel.params.find|@count==0 && $hotel.params.miss|@count==0}
                        {foreach from=$hotel.params.data item="param" name="p_data"}
                            <span class="{if $param.note}link {/if}param{if $param.find} hit{/if}" data-param="{$param.inc}">{if $LANG == 'rus'}{$param.title}{else}{$param.ltitle}{/if}</span>{if $smarty.foreach.p_data.iteration == 5}{break}{elseif !$smarty.foreach.p_data.last}, {/if}
                        {/foreach}
                    {else}
                        [{$hotel.params.find|@count}/{$hotel.params.count}]: 
                        {if ($hotel.params.find|@count > $hotel.params.miss|@count && $hotel.params.find|@count != $hotel.params.count)}
                            {foreach from=$hotel.params.miss item="param" name="p_data"}
                                <span class="{if $param.note}link {/if}param miss" data-param="{$param.inc}">{if $LANG == 'rus'}{$param.title}{else}{$param.ltitle}{/if}</span>{if $smarty.foreach.p_data.iteration == 5}{break}{elseif !$smarty.foreach.p_data.last}, {/if}
                            {/foreach}
                        {else}
                            {foreach from=$hotel.params.find item="param" name="p_data"}
                                <span class="{if $param.note}link {/if}param" data-param="{$param.inc}">{if $LANG == 'rus'}{$param.title}{else}{$param.ltitle}{/if}</span>{if $smarty.foreach.p_data.iteration == 5}{break}{elseif !$smarty.foreach.p_data.last}, {/if}
                            {/foreach}
                        {/if}
                    {/if}
                    </div>
                    {if $hotel.params.find|@count!=0 || $hotel.params.miss|@count!=0}
                        <div class="details" style="display: none;">
                            {foreach from=$hotel.params.find item="param"}
                                <span class="{if $param.note}link {/if}param hit" data-param="{$param.inc}">{$param.title}</span>
                            {/foreach}
                            {foreach from=$hotel.params.miss item="param"}
                                <span class="{if $param.note}link {/if}param miss" data-param="{$param.inc}">{$param.title}</span>
                            {/foreach}
                        </div>
                    {/if}
                </td>
                {if $searchTour}
                    <td>
                        <input class="tour" type="checkbox" value="{$hotel.key}" />
                        <span class="link tour">##SEARCH##</span>
                    </td>
                {/if}
            </tr>
            {/foreach}
        </tbody>
    </table>
    {include file="../controls.tpl" control="pager"}
{else}
    <p>##NO_DATA##</p>
{/if}