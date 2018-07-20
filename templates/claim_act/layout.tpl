{include file="../header.tpl" page_title=$routes.claim_act.title}
{include file="../partial_top.tpl"}
<div id="claim_act" style="width: 960px; margin: auto;">
    {note}
    {include file="../controls.tpl" control="SEARCHMODE" SEARCHMODE=$PERSONAL_AREA}
    <fieldset class="panel">
    {if $acts}
        <table class="res">
            <thead>
                <tr>
                    <th style="width: 10%;">##ACT_DATE##</th>
                    <th>##ACT_PURPOSE##</th>
                    <th style="width: 10%;">##ACT_EXISTS##</th>
                    <th style="width: 10%;">##ACT_COPY_EXISTS##</th>
                    <th style="width: 10%;">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$acts item="act"}
                    <tr class="{cycle values="even,odd"}">
                        <td>{$act.DDate}</td>
                        <td>{$act.purpose}</td>
                        <td>{if $act.havedocument}##YES##{else}##NO##{/if}</td>
                        <td>{if $act.havecopy}##YES##{else}##NO##{/if}</td>
                        <td>
                            {if !$act.havedocument}
                                {if $act.act}
                                    <a class="external" href="{Samo_Url::route('claim_act', ['samo_action' => 'download', 'act' => $act.act, 'doctype' => $act.doctype])}">##PRINT##</a>
                                {/if}
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    {else}
         ##NO_DATA##
    {/if}
    </fieldset>
</div>
{include file="../common.tpl"}
{jsload file="claim_act.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}