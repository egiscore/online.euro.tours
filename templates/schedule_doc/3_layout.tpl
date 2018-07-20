{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="schedule_doc.css"}
{include file="../partial_top.tpl"}
<div id="schedule_doc">
    {note}
    <div class="controls">
        <table class="std panel n1">
            <tr>
                {if count($TOWNFROM) > 1}
                    <th>##SHEDULE_DOC_TOWNFROM##</th>
                    <td>
                        <select name="TOWNFROMINC" class="TOWNFROMINC"  autocomplete="off">{foreach from=$TOWNFROM item="row"}<option data-search-string="{$row.LName} {$row.altName}" value="{$row.Inc}" {if $row.selected}selected="selected"{/if}>{$row.LName}</option>{/foreach}</select>
                    </td>
                {/if}
                {if count($STATE) > 0}
                    <th>##SHEDULE_DOC_STATE##</th>
                    <td>
                        <select name="STATEINC" class="STATEINC"  autocomplete="off">{foreach from=$STATE item="row"}<option data-search-string="{$row.LName} {$row.altName}" value="{$row.Inc}" {if $row.selected}selected="selected"{/if}>{$row.LName}</option>{/foreach}</select>
                    </td>
                {/if}
                {if count($OWNER) > 0}
                    <th>##SHEDULE_DOC_OFFICE##</th>
                    <td>
                        <select name="OWNERINC" class="OWNERINC" autocomplete="off">{foreach from=$OWNER item="owner"}<option data-search-string="{$row.LName} {$row.altName}" value="{$owner.Inc}" {if $owner.selected}selected="selected"{/if}>{$owner.LName}</option>{/foreach}</select>
                    </td>
                {/if}
                <th>##SHEDULE_DOC_CHECKIN##</th>
                <td><input type="text" class="frm-input date CHECKIN" name="CHECKIN"  autocomplete="off" {datepicker_init direction=true}></td>
                <td><button class="load">##REFRESH##</button></td>
            </tr>
        </table>
    </div>
    <div class="resultset">{include file="resultset.tpl"}</div>
</div>
{include file="../common.tpl"}
{jsload file="schedule_doc.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}