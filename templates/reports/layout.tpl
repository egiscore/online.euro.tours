{if $smarty.get.as_module == 1}
    {assign var="page_title" value="##REPORTS_REPORTS##"}
    {foreach $reportList as $reportInfo}
        {if $reportInfo.selected}
            {assign var="page_title" value=$reportInfo.Name}
        {/if}
    {/foreach}
{/if}
{include file="../header.tpl" page_title=$page_title cssfiles="reports.css"}
{include file="../partial_top.tpl"}
<div id="reports">
    <div class="reportsInfo">
        {if !$smarty.get.as_module == 1}
            {include file="../controls.tpl" control="SEARCHMODE" SEARCHMODE=$PERSONAL_AREA}
            <fieldset class="panel">
                <legend>##REPORTS_AVAILABLE_REPORTS##</legend>
                <table class="reportTable res">
                    <thead>
                    <tr>
                        <th colspan="2">##REPORTS_REPORT##</th>
                    </tr>
                    </thead>
                    <tbody>
                    {if $reportList|count > 0}
                        <tr>
                            <td>##REPORTS_SELECT_REPORT##:</td>
                            <td>
                                <select name="template" class="selectReport">
                                    <option disabled selected>----</option>
                                    {foreach $reportList as $reportInfo}
                                        <option class="reportLink" value="{$reportInfo.Inc}" {if $reportInfo.selected}selected="selected"{/if}>{$reportInfo.Name}</option>
                                    {/foreach}
                                </select>
                            </td>
                        </tr>
                    {else}
                        <tr>
                            <td colspan="2" class="noReports">##REPORTS_NO_REPORTS_AVAILABLE##</td>
                        </tr>
                    {/if}
                    </tbody>
                </table>
            </fieldset>
        {/if}
            <div class="reportParams">
                {if $fields}{include file="reports.tpl" load="reportParams"}{/if}
            </div>
            <button type="button" class="getReport">##REPORTS_GENERATE_A_REPORT##</button>
            <div class="downloadLinkBlock">
                <a class="getReport" href="{Samo_Url::route('reports', ['samo_action' => 'PDF_SAMOTOUR'])}">
                    ##REPORTS_GENERATE_A_REPORT##
                </a>
            </div>
    </div>
</div>
{include file="../common.tpl"}
{jsload file="reports.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}
