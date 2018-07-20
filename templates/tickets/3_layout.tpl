{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="tickets.css"}
{include file="../partial_top.tpl"}
<div id="tickets">
    {note}
    <table class="container two_col">
        <tr>
            <td class="form col">
                {include file="../controls.tpl" control="SEARCHMODE"}
                {include file="controls.tpl" control="form"}
            </td>
            <td class="col">
                <div class="resultset scrolling">{if $prices or $smarty.get.DOLOAD}{include file="resultset.tpl"}{/if}</div>
            </td>
        </tr>
    </table>
</div>
{include file="../common.tpl"}
{jsload file="tickets.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}
