<div class="header">
    {if $hotel.icons.viptype}
        <div class="icons">
            {foreach from=$hotel.icons.viptype item="icon"}
                <span class="icon hp {$icon.class}" title="{$icon.title|escape:'html'}">&nbsp;</span>
            {/foreach}
        </div>
    {/if}
    <div class="hotellname">
        {$hotel.lname}
        <span class="starname">
        {if $hotel.starNum}
            <span class="star star_{$hotel.starNum}"></span>
        {else}
            {$hotel.star}
        {/if}
        </span>
    </div>
</div>
<div id="hotel-info" class="hotel-popup">
    {if $hotel.images.0}
        <img class="prev" src="{$hotel.images.0.src}" title="{$hotel.images.0.alt|escape:'html'}" data-width="{$hotel.images.0.width}" data-height="{$hotel.images.0.height}" />
    {/if}
    {if $hotel.address || $hotel.phone || $hotel.fax || $hotel.h_www || $hotel.email || $hotel.location}
        <div class="hotel_info panel{if $hotel.images.0} with_image{/if}">
            <div class="hotel_info_header">
              <div class="info_img"></div> <span>##HOTEL_CONTACTS##</span>
            </div>
            <table class="descr">
            {if $hotel.address}
                <tr>
                    <td class="title">##HOTEL_ADDRESS##</td>
                    <td>{$hotel.address}</td>
                </tr>
            {/if}
            {if $hotel.phone}
                <tr>
                    <td class="title">##HOTEL_PHONE##</td>
                    <td>{$hotel.phone}</td>
                </tr>
            {/if}
            {if $hotel.fax}
                <tr>
                    <td class="title">##HOTEL_FAX##</td>
                    <td>{$hotel.fax}</td>
                </tr>
            {/if}
            {if $hotel.h_www}
                <tr>
                    <td class="title">##HOTEL_URL##</td>
                    <td><a href="{$hotel.h_www}">{$hotel.h_www}</a></td>
                </tr>
            {/if}
            {if $hotel.email}
                <tr>
                    <td class="title">##HOTEL_EMAIL##</td>
                    <td>{$hotel.email}</td>
                </tr>
            {/if}
            {if $hotel.location}
                <tr>
                    <td class="title">##HOTEL_LOCATION##</td>
                    <td>{$hotel.location|nl2br}</td>
                </tr>
            {/if}
            </table>
        </div>
    {/if}
    <div class="content">
        {if $hotel.description_short}
            <p>{$hotel.description_short}</p>
        {/if}
    </div>
</div>
<a href="{$routes.hotels.url}samo_action=hotel&HOTELINC={$hotel.key}" target="_blank" class="more">##MORE##</a>