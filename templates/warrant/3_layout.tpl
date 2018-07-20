{if (!isset($content_for_layout))}
    {include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="warrant.css"}
    {include file="../partial_top.tpl"}
    <div id="warrant">
        {note}
        {include file="../controls.tpl" control="SEARCHMODE" SEARCHMODE=$PERSONAL_AREA}
        <fieldset class="panel">
            <button id="add_warrant">##WARRANT_ADD##</button>
            <div class="resultset">{include file="resultset.tpl"}</div>
        </fieldset>
    </div>
    {include file="../common.tpl"}
    {jsload file="warrant.js"}
    {include file="../partial_bottom.tpl"}
    {include file="../footer.tpl"}
{else}
    <html>
    <head>
        {cssload file="common.css, warrant.css"}
    </head>
    <body>
        <div id="warrant">
            <div class="resultset">{$content_for_layout}</div>
            <div id="buttons">
                    <button id="print" onclick="window.print();">##WARRANT_PRINT##</button>
            </div>
        </div>
        {include file="../common.tpl"}
    </body>
    </html>
{/if}