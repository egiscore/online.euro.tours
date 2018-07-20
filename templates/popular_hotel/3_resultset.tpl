{if $RESULT}
<table class="res">
<thead>
	<tr>
		<th>##HOTEL_STAR##</th>
		<th>##HOTEL_NAME##</th>
		<th>##HOTEL_ROOM##</th>
		<th>##HOTEL_HTPLACE##</th>
		<th>##HOTEL_MEAL##</th>
		<th>##HOTEL_NIGHTS##</th>
	</tr>
</thead>
<tbody>
{foreach from=$RESULT item="hotel"}
	<tr data-hotel="{$hotel.HotelInc}" data-meal="{$hotel.MealInc}" data-nights="{$hotel.Nights}" class="{cycle values="even,odd"}">
		<td>{$hotel.GroupStarName}</td>
		<td>{$hotel.HotelLName} {$hotel.StarLName}</td>
		<td>{$hotel.RoomLName}</td>
		<td>{$hotel.HtplaceLName}</td>
		<td>{$hotel.MealLName}</td>
		<td>{$hotel.Nights}</td>
	</tr>	
{/foreach}
</tbody>
</table>
{/if}