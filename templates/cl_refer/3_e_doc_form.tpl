{if $ENABLE_UPLOAD}
    <div id="e_doc_tabs">
        <button class="e_doc_tab {if $TAB==1}e_doc_tab_selected{/if}" id="E_DOC_BTN_PRINT">##E_DOC_BTN_PRINT##</button>
        <button class="e_doc_tab {if $TAB==2}e_doc_tab_selected{/if}" id="E_DOC_BTN_ADD">##E_DOC_BTN_ADD##</button>
    </div>
{/if}
<div id="e_doc" data-claim="{$CLAIM}" {if $edoc_confirm}data-confirm-note="{$edoc_confirm}"{/if}>
    {if $TAB == 1}
        {if $links}
            <table class="res">
                <thead>
                <tr>
                    <th>##E_DOC_TYPE##</th>
                    <th>##E_DOC_DESCRIPTION##</th>
                    <th>##E_DOC_PRINT##</th>
                </tr>
                </thead>
                {foreach from=$links item="link"}
                    <tr class="{cycle values="even,odd"}{if $link.data.DocCategory > 0} doccategory-{$link.data.Module}{/if}">
                        <td>{$link.t|nl2br}</td>
                        <td>{$link.td|nl2br}</td>
                        <td>
                            {if $link.error == ''}
                                {if isset($link.odate) && $link.odate->not_null()}
                                    {assign var="printed" value=true}
                                {else}
                                    {assign var="printed" value=false}
                                {/if}
                                <a href="{$link.a}" target="_blank"
                                        {if $printed or $edoc_confirm or ($link.type && $link.type=='external')}
                                            class="
                                               {if $printed}printed{/if}
                                               {if $edoc_confirm}confirm_required{/if}
                                               {if $link.type && $link.type=='external'}external{/if}
                                            "
                                        {/if}
                                        {if $printed}title="{$link.odate|date_format:"datetime"}"{/if}
                                        >
                                    ##E_DOC_PRINT_LINK##
                                </a>
                                {if $link.document_status}
                                    <br>
                                    <span class="document_status_{$link.document_status_inc}">
                                        {$link.document_status}
                                        {if $link.document_status_inc == 3}
                                            <br>
                                            {$link.status_note}
                                        {/if}
                                    </span>
                                {/if}
                            {else}
                                <span class="red">{$link.error}</span>
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            </table>
            {note page='edocs'}
        {else}
            ##E_DOC_NOT_AVAILABLE##
        {/if}
    {/if}
    {if $TAB == 2}
        ##E_DOC_TYPE##
        <select id="E_DOC_TYPE">
            {foreach from=$edoc_types item="item"}
                <option value="{$item.id}"
                        {if $item.selected}selected{/if}
                        data-upload_format="{$item.upload_format|@glue}"
                        data-upload_size="{$item.upload_size}"
                        data-upload_req_people="{$item.upload_req_people}">
                    {$item.nameAlt}
                </option>
            {/foreach}
        </select>
        <br>
        <br>
        <div id="UPLOAD_DIV" class="hidden vi">
            {foreach from=$edoc_types item="item"}
                <div id="type_note_{$item.id}" class="hidden type_note_x">{if $item.note}{$item.note|nl2br}<br><br>{/if}</div>
            {/foreach}
            <table class="std" style="width: 97%;">
                <tr>
                    <td colspan="2" style="text-align: left">
                        <div id="E_DOC_PEOPLE_DIV" class="hidden" style="white-space: nowrap;">##E_DOC_TOURIST##:
                            <select id="E_DOC_PEOPLE" style="width: auto;">
                                {foreach from=$peoples item="people"}
                                    <option value="{$people.Inc}">{$people.Human}&nbsp;{$people.LName}</option>
                                {/foreach}
                            </select>
                            <br>
                            <br>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left">
                        <input type="file" id="edoc_file" name="edoc_file" style="width: 100%"><br>
                        ##UPLOAD_FILE_TYPE## <span id="upload_file_format"></span>
                    </td>
                    <td class="vt" style="text-align: right">
                        <button id="E_DOC_BTN_UPLOAD">##E_DOC_BTN_UPLOAD##</button>
                    </td>
                </tr>
            </table>
            <br>
        </div>
        {if $links}
            <table class="res">
                <thead>
                <tr>
                    <th>##E_DOC_TYPE##</th>
                    <th>##E_DOC_DESCRIPTION##</th>
                    <th>##E_DOC_PRINT##</th>
                </tr>
                </thead>
                {foreach from=$links item="link"}
                    <tr class="{cycle values="even,odd"}{if isset($last_upload) && $link.DocInc eq $last_upload.Inc} flash{/if}">
                        <td>{$link.t}</td>
                        <td>{$link.td}</td>
                        <td>
                            {if $link.error == ''}
                                {if isset($link.odate) && $link.odate->not_null()}
                                    {assign var="printed" value=true}
                                {else}
                                    {assign var="printed" value=false}
                                {/if}
                                <a href="{$link.a}" target="_blank"
                                        {if $printed or $edoc_confirm or ($link.type && $link.type=='external')}
                                            class="
                                                {if $printed}printed{/if}
                                                {if $edoc_confirm}confirm_required{/if}
                                                {if $link.type && $link.type=='external'}external{/if}
                                            "
                                        {/if}
                                        {if $printed}title="{$link.odate|date_format:"datetime"}"{/if}
                                        >
                                    ##E_DOC_PRINT_LINK##
                                </a>
                                {if $link.document_status}
                                    <br>
                                    <span class="document_status_{$link.document_status_inc}">
                                        {$link.document_status}
                                        {if $link.document_status_inc == 3}
                                            <br>
                                            {$link.status_note}
                                        {/if}
                                    </span>
                                {/if}
                            {else}
                                <span class="red">{$link.error}</span>
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            </table>
        {/if}
    {/if}
</div>
