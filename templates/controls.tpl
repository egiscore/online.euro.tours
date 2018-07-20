{* if $control == "checklistbox"}
    [{foreach from=$elements item="option" name="options"}
            {ldelim}inc: {$option.Inc}, title: "{$option.LName|escape:'javascript'}",selected: {if isset($option.selected) && $option.selected == true}true{else}false{/if},required: {if isset($option.required) && $option.required == true}true{else}false{/if}{rdelim}{if $smarty.foreach.options.last ne true},{/if}
    {/foreach}]
{/if *}
{if $control == "checklistbox_html" or $control == 'checklistbox'}
   {if is_array($elements)}
        {assign var="prev_group" value=0}
        {foreach from=$elements item="option" name="options"}
            {if $option.Group && $option.Group != $prev_group}
              {if $prev_group != 0}
                </div>
              {/if}
              <div class="groupbox{if $group_expanded} expanded{/if}">
              <label class="groupname"><input type="checkbox" class="group" {if isset($option.group_selected) && $option.group_selected == true}checked="checked"{/if} />{$option.GroupLName}</label>
              {assign var="prev_group" value=$option.Group}
            {/if}
            <label {if isset($option.group_selected) && $option.group_selected == false}class="hidden"{else}{if $option.addition}class="has_input"{/if}{/if}>
                <input type="checkbox" {if $class}class="{$class}"{/if} {if isset($option.selected) && $option.selected == true}checked="checked"{/if} {if isset($option.required) && $option.required == true}disabled="disabled"{/if} value="{$option.Inc}" {if isset($option.attrs)}{$option.attrs}{/if}/>{if $option.Url}<a class="help" href="{$option.Url}" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;</a>{/if} {$option.LName}{if $option.DateBeg} {if $option.DateBeg == $option.DateEnd}({$option.DateBeg|date_format}){else}({$option.DateBeg|date_format} - {$option.DateEnd|date_format}){/if}{/if}
            </label>
            {if $option.addition}
                <input type="text" name="addit_{$option.Inc}" disabled="disabled" class="addit">
            {/if}
        {/foreach}
        {if $prev_group != 0}
          </div>
        {/if}
   {/if}
{/if}
{if $control == "checklistbox_hotels"}
    {if is_array($elements)}
        {foreach from=$elements item="option" name="options"}
            <label><input type="checkbox" data-town="{$option.townKey}" data-group-star="{$option.starGroupList}" data-type="{$option.typeList}" {if $option.selected == true}checked="checked"{/if} value="{$option.id}" />{$option.name} {$option.star}</label>
        {/foreach}
    {/if}
{/if}
{if $control == 'options'}
    [
      {if is_array($elements)}
        {foreach from=$elements item="option" name="options"}
            {ldelim}inc: '{$option.Inc}', title: '{if !isset($option.LName)}{$option.Name|escape:'javascript'}{else}{$option.LName|escape:'javascript'}{/if}', selected: {if isset($option.selected) && $option.selected == true}true{else}false{/if}{if $option.attributes}, attrs: {ldelim}{$option.attributes|@glue:",":"json"}{rdelim}{/if}{rdelim}{if $smarty.foreach.options.last ne true},{/if}
        {/foreach}
      {/if}
    ]
{/if}
{if $control == "pager" and isset($pages) && is_array($pages) and isset($current_page)}
<div class="pager">
    {foreach from=$pages item="page"}
        {if $page == $current_page}
            <span class="current_page">{$page}</span>
        {else}
            <span class="page" data-page="{$page}">{$page}</span>
        {/if}
    {/foreach}
</div>
{/if}
{if $control == 'logout'}
    ##SAMO_LOGON_PARTNER## {$LOGIN_AGENCY_PARTNER_TYPE} &laquo;{$LOGIN_AGENCY_OFFICIAL_NAME}&raquo; {if $LOGIN_OFFICIAL_NAME}, {$LOGIN_OFFICIAL_NAME}{/if} <button id="logout" class="button">##SAMO_LOGOUT##</button>
{/if}
{if $control == 'hotel_category'}
    {include file="`$smarty.const._ROOT`templates/controls.tpl" control="checklistbox" elements=$STARS class="star"}
    {if $HOTELTYPES}<hr>
    {include file="`$smarty.const._ROOT`templates/controls.tpl" control="checklistbox" elements=$HOTELTYPES class="hoteltype"}
    {/if}
{/if}
{if $control == 'TOWNFROMINC'}
    {assign var="countStates" value=0}
    {assign var="oldStateFrom" value=0}
    {foreach from=$TOWNFROMINC item="item"}
        {if $oldStateFrom != $item.stateFromKey}
            {assign var="countStates" value=$countStates+1}
            {assign var="oldStateFrom" value=$item.stateFromKey}
        {/if}
    {/foreach}
    {assign var="oldStateFrom" value=0}
    <select name="TOWNFROMINC" class="TOWNFROMINC" autocomplete="off" >
        {foreach from=$TOWNFROMINC item="item"}
        {if $countStates > 1}
        {if $oldStateFrom != $item.stateFromKey}
        {if $oldStateFrom > 0}
            </optgroup>
        {/if}
        {assign var="oldStateFrom" value=$item.stateFromKey}
        <optgroup label="{$item.stateFromName}">
            {/if}
            {/if}
            <option value="{$item.id}"{if $item.attributes} {$item.attributes|@glue:" "}{else} data-search-string="{$item.name} {$item.nameAlt}"{/if}{if $item.selected} selected{/if}>{$item.name}</option>
            {/foreach}
            {if $countStates > 1 && $oldStateFrom > 0}
        </optgroup>
        {/if}
    </select>
{/if}

{if $control == 'FRPLACEMENT'}
    <h3 class="frplacement">
        {imgload file="freight.gif" inline=true}&nbsp;{$freight.FreightName} ({$freight.TranTypeName}) {$freight.DateBeg} {$freight.TownSrcName} ({$freight.SrcPortAlias} {$freight.SrcTime}{if $freight.SrcTimeDelta}<span class="delta">+{$freight.SrcTimeDelta}</span>{/if}) -> {$freight.TownTrgName} ({$freight.TrgPortAlias} {$freight.TrgTime}{if $freight.TrgTimeDelta}<span class="delta">+{$freight.TrgTimeDelta}</span>{/if}) {imgload file="class.gif" inline=true} {$freight.ClassName}
    </h3>
    {if count($boarding) > 1}
        {assign var="multiple" value=true}
    {else}
        {assign var="multiple" value=false}
    {/if}
    {note page="frplacement"}
    <h3 class="frplacement">##FRPLACEMENT_PEOPLES_HEADER##</h3>
    <table class="peoples{if $multiple} show-wagon{/if}" id="frplacement_peoples" data-freight="{$freight.FreightInc}" {if $seats}data-seats='{$seats|json_encode}'{/if}{if $seats_service} data-seats_service='{$seats_service|json_encode}'{/if}{if $CLAIM} data-claim="{$CLAIM}"{/if}{if $CLAIM} data-order="{$ORDER}"{/if}>
        <thead>
        <tr>
            <th class="name">##FRPLACEMENT_PEOPLE_NAME##</th>
            <th class="wagon">##FRPLACEMENT_PEOPLE_WAGON##</th>
            <th class="frplacement">##FRPLACEMENT_PEOPLE_PLACE##</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$peoples item="people" name="peoples"}
            <tr {if 1 == $smarty.foreach.peoples.iteration} class="selected"{/if} data-people="{$people.key}" {if $people.opeople}data-opeople="{$people.opeople}"{/if}>
                <td class="name">{$people.human} {if $people.VisiblePersonalInformation}{if $people.lname}{$people.lname}{else}NO NAME {$smarty.foreach.peoples.iteration}{/if}{else}##CL_R_P_HIDDEN##{/if}</td>
                <td class="wagon">&nbsp;</td>
                <td class="frplacement">&nbsp;</td>
                <td class="action hidden"><span class="ui-icon-trash ui-icon free-seat" title="##FRPLACEMENT_CLEANUP##">&nbsp;</span></td>
            </tr>
        {/foreach}
        </tbody>
    </table>
    <h3 class="frplacement">##FRPLACEMENT_SEATS_HEADER##
        <span class="legend pass      icon">&nbsp;</span><span class="legend pass      text">##FRPLACEMENT_LEGEND_PASS##</span>
        <span class="legend available icon">&nbsp;</span><span class="legend available text">##FRPLACEMENT_LEGEND_AVAILABLE##</span>
        <span class="legend occupied  icon">&nbsp;</span><span class="legend occupied  text">##FRPLACEMENT_LEGEND_OCCUPIED##</span>
        <span class="legend selected  icon">&nbsp;</span><span class="legend selected  text">##FRPLACEMENT_LEGEND_SELECTED##</span>
        <span class="legend otherclass  icon">&nbsp;</span><span class="legend otherclass  text">##FRPLACEMENT_OTHER_CLASS##</span>
        <span class="legend emergency_seat  icon">&nbsp;</span><span class="legend emergency_seat  text">##FRPLACEMENT_EMERGANCY_CLASS##</span>
    </h3>
    <div id="frplacement_container" {if $description.FrPlacementNote}class="with-description"{/if}>
        {include file="`$smarty.const._ROOT`templates/controls.tpl" control="WAGON" freight=$freight FrPlacementClass=$FrPlacementClass rows=$boarding[0] wagon=0 multiple=false wagon_name=$boarding[0][0][0]['WagonName']}
    </div>
    {if $description.FrPlacementNote}
    <div class="frplacement_note">
        {$description.FrPlacementNote}
    </div>
    {/if}
    {if $multiple}
        <h3 class="frplacement">##FRPLACEMENT_WAGONS_HEADER##</h3>
        <div id="frplacement_preview">
            <table class="wagons">
                <tr>
                    {foreach from=$boarding key="wagon" item="rows" name="wagons"}
                        <td class="wagon{if $smarty.foreach.wagons.first} selected{/if}">
                            {include file="`$smarty.const._ROOT`templates/controls.tpl" freight=$freight control="WAGON" FrPlacementClass=$FrPlacementClass rows=$rows wagon=$wagon multiple=true wagon_name=$rows[0][0]['WagonName']}
                        </td>
                    {/foreach}
                </tr>
            </table>
        </div>
    {/if}
    <div class="save">
        <button id="frplacement_save">##FRPLACEMENT_SAVE_BTN##</button>
    </div>

{/if}
{if $control == 'WAGON'}
    <table class="boarding" data-wagon="{$wagon}" data-title="{$wagon_name|default:$wagon}">
        {foreach from=$rows item="cells" key="row"}
            <tr>
                {if $row == 0}
                    <td rowspan="{$rows|count}" class="vertical-tooltip">
                        {'##FRPLACEMENT_FRONT##'|vertical_string}
                    </td>
                {/if}
                {foreach from=$cells item="cell"}
                    <td data-inc="{$cell.Inc}" data-serviceinc="{$cell.ServiceInc}" data-servicedeparture="{$freight.TownSrcInc}" data-servicearrival="{$freight.TownTrgInc}" data-partner="{$cell.Partner}" data-price="{$cell.Price}" data-routeindex="{$cell.RouteIndex}" {if !in_array($cell.FrPlacementTypeInc, [1, 7])} data-title="{$cell.FrPlacementTypeName|escape}" {elseif $cell.FrPlacementTypeInc == 1 && $cell.Price} data-title="+{$cell.Price|escape}" {/if}
                        class="frplacement_{$cell.FrPlacementTypeInc}{if $cell.emergency_seat} emergency_seat{/if}{if $cell.Seat && $FrPlacementClass == $cell.FrPlacementClass} seat available_{if $seats && in_array($cell.Inc, array_values($seats))}1{else}{$cell.Available}{/if}{/if}">{$cell.CellName}</td>
                {/foreach}
                {if $row == 0}
                    <td rowspan="{$rows|count}" class="vertical-tooltip">
                        {'##FRPLACEMENT_BACK##'|vertical_string}
                    </td>
                {/if}
            </tr>
        {/foreach}
    </table>
{/if}
{if $control == 'SEARCHMODE'}
    <div class="searchmodes">
        {foreach from=$SEARCHMODE item="element"}
            <div class="panel searchmode searchmode_{$element.id}{if $element.selected} searchmode_selected{/if}" data-searchmode="{$element.id}">
                {if $element.selected}
                    {$element.name}
                {else}
                    <a class="searchmode_button" href="{$element.url}">{$element.name}</a>
                {/if}
            </div>
        {/foreach}
    </div>
{/if}