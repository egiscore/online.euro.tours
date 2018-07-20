{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="registration.css"}
{include file="../partial_top.tpl"}
<div id="registration">
    {note}
    <div class="controls container">
        <br>
        {include file="usage.tpl"}
        <br><br>
        <fieldset class="panel"><legend>##REGISTRATION_SEARCH##</legend>
            <table>
                <tr>
                    <td class="label">##TOWN##</td>
                    <td>
                        <select name="FIRM_TOWN" class="FIRM_TOWN" autocomplete="off" >
                            {foreach from=$FIRM_TOWN key="key" item="options"}
                                <optgroup label="{$key}">
                                    {foreach from=$options item="item"}
                                        <option value="{$item.id}" data-search-string="{$item.name} {$item.nameAlt}" {if $item.selected}selected{/if}>{$item.name}</option>
                                    {/foreach}
                                </optgroup>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">##PHONE##</td>
                    <td>
                        <input type="text" class="frm-input string FIRM_PHONE" name="FIRM_PHONE" id="FIRM_PHONE" value="{$FIRM_PHONE}">
                    </td>
                </tr>
                <tr>
                    <td class="label">##NAME##</td>
                    <td>
                        <input type="text" class="frm-input string FIRM_NAME" name="FIRM_NAME" id="FIRM_NAME" value="{$FIRM_NAME}">
                    </td>
                </tr>
                <tr>
                    <td class="label">##EMAIL##</td>
                    <td>
                        <input type="text" class="frm-input string FIRM_EMAIL" name="FIRM_EMAIL" id="FIRM_EMAIL" value="{$FIRM_EMAIL}">
                    </td>
                </tr>
                <tr>
                    <td class="label">##NDOG##</td>
                    <td>
                        <input type="text" class="frm-input string FIRM_NDOG" name="FIRM_NDOG" id="FIRM_NDOG" value="{$FIRM_NDOG}">
                    </td>
                </tr>
                <tr>
                    <td class="label">##INN##</td>
                    <td>
                        <input type="text" class="frm-input string FIRM_INN" name="FIRM_INN" id="FIRM_INN" value="{$FIRM_INN}">
                    </td>
                </tr>
            </table>
        </fieldset>
        <button class="load">##SEARCH##</button>
    </div>
    <div class="container"><div id="resultset" class="resultset"> </div></div>
    <br>
    <div id="login" class="container password_prepare">
        <form name="PARTPASS_FORM" action="{$routes.registration.url}&samo_action=SAVE_LOGIN" method="post">
            {include file="../fieldset_builder.tpl" fields=$fields_partpass}
            <div class="label">##REQUIRE_BOLD##</div>
            <br>
            <input type="submit" value="##BTN_SAVE##">
        </form>
    </div>
    <div class="post_password"></div>
</div>
{include file="../common.tpl"}
{jsload file="registration.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}