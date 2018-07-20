<fieldset class="panel">
    <legend>##TOUR_ADDITIONAL_SERVICES##</legend>
    <div id="ADDITIONAL_SERVICES">
        <table class="res">
        {foreach from=$SERVICES item="group" name="srvtype"}
            {if $group.services}
                <thead>
                <tr>
                    <th colspan="3">{$group.name}</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$group.services item="option" name="options"}
                    <tr class="{cycle values="even,odd"}">
                        <td class="caption">
                            {if $option.dateBeg->not_null()} {if $option.dateBeg->eq($option.dateEnd)}{$option.dateBeg}{else}{$option.dateBeg} - {$option.dateEnd}{/if}{/if}
                        </td>
                        <td>
                            {imgload file="service.gif" inline=true}&nbsp;{$option.title|linkify:$option.url}
                        </td>
                        <td class="price">
                            {if $option.price} {$option.price}&nbsp;{$option.currency}{/if}
                        </td>
                    </tr>
                {/foreach}
                <tr class="eraser">
                    <td colspan="3">&nbsp;</td>
                </tr>
                </tbody>
            {/if}
        {/foreach}
        </table>
    </div>
</fieldset>
