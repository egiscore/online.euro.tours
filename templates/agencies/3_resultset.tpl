{if $AGENCIES}
    <table class="res">
        <thead>
            <tr>
                <th>##AGENCIES_NAME##</th>
                <th>##AGENCIES_TOWN##</th>
                <th>##AGENCIES_ADDRESS##</th>
                <th>##AGENCIES_INN##</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
    {foreach from=$AGENCIES item="item"}
            <tr class="{cycle values="even,odd"}" data-partner="{$item.id}">
                <td>{$item.officialName}</td>
                <td>{$item.town}</td>
                <td>{$item.address}</td>
                <td>{$item.inn}</td>
                <td><span class="link">##AGENCIES_MORE##</span></td>
            </tr>
    {/foreach}
    </tbody>
    </table>
{else}
    ##NO_DATA##
{/if}