{if $result}
{cycle values="even,odd" advance=false reset=true print=false}
<table class="res{if !$result.0.FreightIncBack} one_col{/if}">
    <tbody>
        {foreach from=$result item="price"}
        <tr class="thead" data-claim="{$price.id}">
            <th class="small">{$price.checkIn|date_format:'d.m.Y, D'}</th>
            <th>{$price.SrcTownName} - {$price.TrgTownName}</th>
            <th class="small">{if $price.PartnerInLogo}{$price.PartnerInName}{else}&nbsp;{/if}</th>
            {if $price.FreightIncBack}
                <th class="splitter"></th>
                <th class="small">{$price.checkOut|date_format:'d.m.Y, D'}</th>
                <th>{$price.SrcTownNameBack} - {$price.TrgTownNameBack}</th>
                <th class="small">{if $price.PartnerOutLogo}{$price.PartnerOutName}{else}&nbsp;{/if}</th>
            {/if}
            <td class="td_price" rowspan="2">
                <span data-cat-price="{$price.price}" data-cat-currency="{$price.CurrencyInc}" class="price{if $price.BlockStatusIn && ($price.BlockStatusOut || !$price.FreightIncBack)} bron price_button{/if}">{$price.price} {$price.CurrencyAlias}</span>
            </td>
        </tr>
        <tr class="{if !$price.BlockStatusIn || (!$price.BlockStatusOut && $price.FreightIncBack)}not_bron {/if}{if $price.MostRelevant}most-relevant{/if}">
            <td>{if $price.PartnerInLogo}<img src="{$price.PartnerInLogo}" title="{$price.PartnerInName}">{else}{$price.PartnerInName}{/if}</td>
            <td>{strip}
                {$price.FreightName} ({$price.TranTypeNameIn})<br/>
                {if $price.PortSrcHtmlMemo|strip_tags|html_entity_decode:$smarty.const.ENT_HTML5:$smarty.const.SMARTY_RESOURCE_CHAR_SET|trim|strlen > 3}
                    <span class="helpalt">
                        {imgload file="info.gif" inline=true}
                        <script type="text/html">
                            {$price.PortSrcHtmlMemo}
                        </script>
                    </span>
                {/if}
                    {$price.SrcTime|date_format:'H:i'}
                    {if $price.SrcPortAlias} (<span class="port_alias helpalt" title="{$price.SrcTownName} ({$price.SrcPortName})">{$price.SrcPortAlias}</span>){/if}
                    &nbsp;&mdash;&nbsp;
                {if $price.PortTrgHtmlMemo|strip_tags|html_entity_decode:$smarty.const.ENT_HTML5:$smarty.const.SMARTY_RESOURCE_CHAR_SET|trim|strlen > 3}
                    <span class="helpalt">
                        {imgload file="info.gif" inline=true}
                        <script type="text/html">
                            {$price.PortTrgHtmlMemo}
                        </script>
                    </span>
                {/if}
                    {$price.TrgTime|date_format:'H:i'}
                    {if $price.TrgPortAlias} (<span class="port_alias helpalt" title="{$price.TrgTownName} ({$price.TrgPortName})">{$price.TrgPortAlias}</span>){/if}
                    {* <span class="label">{$price.FlyTimeTo}</span>*}
                {/strip}
            </td>
            <td class="class">
                {$price.ClassName}
                <div class="{if $price.BlockStatusIn==1}yesplace{elseif $price.BlockStatusIn==2}requestplace{elseif $price.BlockStatusIn==3}yesnoplace{else}noplace{/if}">{$price.BlockCountIn}</div>
            </td>
            {if $price.FreightIncBack}
                <td class="splitter"></td>
                <td>{if $price.PartnerOutLogo}<img src="{$price.PartnerOutLogo}" title="{$price.PartnerOutName}">{else}{$price.PartnerOutName}{/if}</td>
                <td>
                    {$price.FreightNameBack} ({$price.TranTypeNameOut})<br/>
                    {$price.SrcTimeBack|date_format:'H:i'}{if $price.SrcPortAliasBack} (<span class="port_alias" title="{$price.SrcTownNameBack} ({$price.SrcPortNameBack})">{$price.SrcPortAliasBack}</span>){/if} - {$price.TrgTimeBack|date_format:'H:i'}{if $price.TrgPortAliasBack} (<span class="port_alias" title="{$price.TrgTownNameBack} ({$price.TrgPortNameBack})">{$price.TrgPortAliasBack}</span>){/if}{* <span class="label">{$price.FlyTimeBack}</span>*}
                </td>
                <td class="class">
                    {$price.ClassName}
                    <div class="{if $price.BlockStatusOut==1}yesplace{elseif $price.BlockStatusOut==2}requestplace{elseif $price.BlockStatusOut==3}yesnoplace{else}noplace{/if}">{$price.BlockCountOut}</div>
                </td>
            {/if}
        </tr>
        <tr class="splitter"><td colspan="3"></td><td></td>{if  $price.FreightIncBack}<td colspan="3"></td><td></td>{/if}</tr>
        {/foreach}
    </tbody>
</table>
{include file="../controls.tpl" control="pager"}
{else}
    ##NO_DATA##
{/if}