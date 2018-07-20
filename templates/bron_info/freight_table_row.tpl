{strip}
    {$filterData[$id]["surcharge"] = $freight[$index][0].markup}
<tr class="{$zClass}{if $freight[$index][0].selected} superfreight {/if}"
    data-bind-filter='{$filterData[$id]|@data_json:'freightTableFilter'}'>
    {if $index eq 0}
        <td rowspan="2">
            <input type="radio" data-json='{$freight[$index][0]|@data_json:'freight'}'
                   name="freight4table"
                   value="{$freight[$index][0].Inc}">
        </td>
        <td>
            <span class="fr_place_r Y" title="##BRON_FREIGHTS_4_TABLE_THERE##"></span>
        </td>
    {else}
        <td>
            <span class="fr_place_l Y" title="##BRON_FREIGHTS_4_TABLE_BACK##"></span>
            <input type="hidden" data-json='{$freight[$index][0]|@data_json:'freight'}'
                   value="{$freight[$index][0].Inc}">
        </td>
    {/if}
    {$buildData = []}
    {foreach from=$freight[$index] key=i item=elements name=build}
        {foreach from=$elements key=key item=val}
            {if $key == 'fly_duration'}
                {$buildData[$index][$key] = $val}
            {elseif $key == 'bagage'}
                {$buildData[$index][$key] = $buildData[$index][$key]|cat:'<span title="'|cat:$val|cat:' '|cat:$elements.bagage_note|cat:'">'|cat:$val|cat:'</span><br/>'}
            {elseif $key == 'class'}
                {$buildData[$index][$key] = $buildData[$index][$key]|cat:'<span data-title="'|cat:$val|cat:' '|cat:$elements.sub_class|cat:'">'|cat:$val|cat:'</span><br/>'}
            {elseif $key == 'DepartureAirportName' || $key == 'ArrivalAirportName'}
                {if $val|count_characters > 19}
                    {$short_val = $val|substr:0:18}
                    {$buildData[$index][$key] = $buildData[$index][$key]|cat:'<span data-title="'|cat:$val|cat:'">'|cat:$short_val|cat:'<small>&#8230;</small></span><br/>'}
                {else}
                    {$buildData[$index][$key] = $buildData[$index][$key]|cat:$val|cat:'<br/>'}
                {/if}
            {elseif $key == 'flight_number'}
                {$buildData[$index][$key] = $buildData[$index][$key]|cat:'<span class="nowrap" data-title="'|cat:$elements.full_airline|cat:'">'|cat:$val|cat:'</span>'}
            {else}
                {$buildData[$index][$key] = $buildData[$index][$key]|cat:'<span class="nowrap">'|cat:$val|cat:'</span>'}
            {/if}
        {/foreach}
    {/foreach}
    {foreach from=$buildData key=i item=data}
        <td>{$data.flight_number}</td>
        <td class="text-center">{$data.fly_duration}</td>
        <td class="text-center">{$data.depart_time}</td>
        <td class="text-center">{$data.arrival_time}</td>
        <td>{$data.DepartureAirportName}</td>
        <td>{$data.ArrivalAirportName}</td>
        <td class="text-center">{$data.class}</td>
        {if $index eq 0}
            <td rowspan="2" class="text-center">
                <span class="bold">
                    {if $freight[$index][0].markup > 0}
                        {'+'|cat:$freight[$index][0].markup} {$currency}
                    {elseif $freight[$index][0].markup === 0}
                        ##BRON_FREIGHTS_4_TABLE_NO_ADDITIONAL_CHARGES##
                    {else}
                        {$freight[$index][0].markup} {$currency}
                    {/if}
                </span>
            </td>
        {/if}
        <td class="text-center">{$data.bagage}</td>
    {/foreach}
    </tr>{/strip}