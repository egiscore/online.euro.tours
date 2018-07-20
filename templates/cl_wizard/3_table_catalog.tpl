    <tr class="{$price.color}" data-townfrom="{$townFrom}">
        <td>{$price.CheckIn}</td>
        <td>{if $price.TourUrl}<a href="{$price.TourUrl}" target="_blank">{$price.TourLName}</a>{else}{$price.TourLName}{/if}</td>
        <td class="c">{$price.Nights}</td>
        <td>{if $price.WWW}<a href="{$price.WWW}" target="_blank">{$price.HotelLName} {$price.StarLName}</a>{else}{$price.HotelLName} {$price.StarLName}{/if}</td>
        <td class="c">{$price.MealLName}</td>
        <td>{$price.RoomName}/{$price.HtPlaceLName}</td>
        <td data-cat-price="{$price.Price}" data-cat-currency="{$price.currencyAlias}" class="price{if $price.bron} bron" data-cat-claim="{$price.Cat_Claim}"{else}{if $price.StopNote} stop" title="{$price.StopNote}"{else}"{/if}{/if} >{$price.ConvertedPrice}</td>
    </tr>
