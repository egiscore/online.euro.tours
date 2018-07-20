{foreach from=$agreements item="agreement"}
    {if $agreement.exists}
        <fieldset class="panel">
            <legend>{$agreement.DateBeg} - {$agreement.DateEnd}</legend>
            <table width="100%">
                <tbody>
                    {if $agreement.NDog}
                    <tr>
                        <td class="left_column"><label class="required">##AGREEMENT_NUMBER##</label></td>
                        <td><strong class="frm-value">{$agreement.NDog}</strong></td>
                    </tr>
                    {/if}
                    <tr>
                        <td class="left_column"><label class="required">##AGREEMENT_TYPE##</label></td>
                        <td><strong class="frm-value">{if $LANG == 'rus'}{$agreement.ContractType_Name}{else}{$agreement.ContractType_LName}{/if}</strong></td>
                    </tr>
                    {if $agreement.Description}
                    <tr>
                        <td class="left_column"><label class="required">##AGREEMENT_DESCRIPTION##</label></td>
                        <td><strong class="frm-value">{$agreement.Description}</strong></td>
                    </tr>
                    {/if}
                    <tr>
                        <td class="left_column"><label class="required">##AGREEMENT_OWNER##</label></td>
                        <td><strong class="frm-value">{if $LANG == 'rus'}{$agreement.Owner.Partner_partnername}{else}{$agreement.Owner.Partner_partnerlname}{/if}</strong></td>
                    </tr>
                    <tr>
                        <td class="left_column">{if $agreement.HaveOriginal || $agreement.exists == 2}<label class="required">##AGREEMENT_IN_STOCK##</label>{/if}</td>
                        <td>
                            {if $agreement.HaveOriginal}
                                <span class="ui-icon-document ui-icon" title="##DOCUMENT_HAVE_ORIGINAL_TITLE##">&nbsp;</span> ##DOCUMENT_HAVE_ORIGINAL##
                            {else}
                                {if $agreement.exists == 2}
                                    <span class="ui-icon-print ui-icon" title="##PRINT##">&nbsp;</span>
                                    <a href="{$ROOT_URL}samo_action=SHOW&DATEBEG={$agreement.DateBeg|date_format:'sql'}&DATEEND={$agreement.DateEnd|date_format:'sql'}&INC={$agreement.inc|default:0}&OWNER={$agreement.Owner.Partner_partnerinc}&CONTRACTTYPE={$agreement.ContractType}" class="link print dog" >{if $agreement.HaveCopy}##DOCUMENT_HAVE_COPY##{else}##DOCUMENT_NOT_AVAILABLE##{/if}</a>
                                {else}
                                    <span class="ui-icon-plus ui-icon" title="##ADD##">&nbsp;</span>
                                    <a href="{$ROOT_URL}samo_action=SHOW&DATEBEG={$agreement.DateBeg|date_format:'sql'}&DATEEND={$agreement.DateEnd|date_format:'sql'}&INC={$agreement.inc|default:0}&OWNER={$agreement.Owner.Partner_partnerinc}&CONTRACTTYPE={$agreement.ContractType}" class="link print dog add" >##ADD##</a>&nbsp;
                                {/if}
                            {/if}
                        </td>
                    </tr>
                </tbody>
            </table>
            {if $agreement.contracts_document}
                <fieldset>
                    <legend>##E_DOCUMENTS##</legend>
                    <table class="std res" width="100%">
                        <thead>
                        <tr>
                            <th width="35%">##E_DOC_TYPE##</th>
                            <th width="10%">##E_DOC_FILE##</th>
                            <th width="30%">##E_DOC_STATUS##</th>
                            <th width="25%">##E_DOC_ACTION##</th>
                        </tr>
                        </thead>
                        {foreach from=$agreement.contracts_document item="link"}
                            <tr data-contracts_document="{$link.ContractsDocumentInc}" data-doctype="{$link.DocTypeInc}">
                                <td>{$link.DocTypeName}{if $link.doctype_note}<br><span style="font-size: 11px;">{$link.doctype_note}</span>{/if}</td>
                                <td>{$link.FileName}</td>
                                <td>
                                    {if $link.is_loaded}
                                        <span class="document_status_{$link.DocumentStatusInc}">
                                                            {$link.DocumentStatusName}
                                            {if $link.DocumentStatusInc == 3 && $link.StatusNote != ''}
                                                : {$link.StatusNote}
                                            {/if}
                                                        </span>
                                    {/if}
                                </td>
                                <td style="padding-top: 4px; padding-bottom: 4px;">
                                    {if $link.is_loaded}
                                        <div>
                                        <span class="ui-icon-print ui-icon" title="##PRINT##">&nbsp;</span>
                                        <a href="{$link.a}" target="_blank" class="button">##E_DOC_PRINT_LINK##</a>
                                        </div>
                                    {/if}
                                    {if $link.DocumentStatusInc != 2}
                                        <div>
                                        <span class="ui-icon-plus ui-icon" title="##E_DOC_BTN_ATTACH##">&nbsp;</span>
                                        <span class="e_doc_btn_attach link">##E_DOC_BTN_ATTACH##</span>
                                        </div>
                                        {if $link.DocumentStatusInc == 1}
                                        <div>
                                            <span class="ui-icon-minus ui-icon" title="##E_DOC_BTN_DETACH##">&nbsp;</span>
                                            <span class="e_doc_btn_detach link">##E_DOC_BTN_DETACH##</span>
                                        </div>
                                        {/if}
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                    </table>
                </fieldset>
            {/if}
        </fieldset>


    {/if}
{/foreach}
{*

<table class="std res">
    <thead>
    <tr>
        <th>##AGREEMENT_NUMBER##</th>
        <th>##AGREEMENT_OWNER##</th>
        <th>##AGREEMENT_DESCRIPTION##</th>
        <th>##AGREEMENT_PERIOD##</th>
        <th>##AGREEMENT_TYPE##</th>
        <th>##AGREEMENT_IN_STOCK##</th>
    </tr>
    </thead>
    <tbody>
    {foreach from=$agreements item="agreement"}
        {if $agreement.exists}
            {cycle assign="tr_class" values="even,odd"}
            <tr class="{$tr_class} agreement" data-datebeg="{$agreement.DateBeg|date_format:'sql'}" data-dateend="{$agreement.DateEnd|date_format:'sql'}" data-inc="{$agreement.inc|default:0}" data-contracttype="{$agreement.ContractType}" data-owner="{$agreement.Owner.Partner_partnerinc}">
                <td class="ndog">{$agreement.NDog}</td>
                <td>{if $LANG == 'rus'}{$agreement.Owner.Partner_partnername}{else}{$agreement.Owner.Partner_partnerlname}{/if}</td>
                <td>{$agreement.Description}</td>
                <td>{$agreement.DateBeg} - {$agreement.DateEnd}</td>
                <td>{if $LANG == 'rus'}{$agreement.ContractType_Name}{else}{$agreement.ContractType_LName}{/if}</td>
                <td>
                    {if $agreement.HaveOriginal}
                        <span class="ui-icon-document ui-icon" title="##DOCUMENT_HAVE_ORIGINAL_TITLE##">&nbsp;</span> ##DOCUMENT_HAVE_ORIGINAL##
                    {else}
                        {if $agreement.exists == 2}
                            <span class="ui-icon-print ui-icon" title="##PRINT##">&nbsp;</span>
                            <a href="{$ROOT_URL}samo_action=SHOW&DATEBEG={$agreement.DateBeg|date_format:'sql'}&DATEEND={$agreement.DateEnd|date_format:'sql'}&INC={$agreement.inc|default:0}&OWNER={$agreement.Owner.Partner_partnerinc}&CONTRACTTYPE={$agreement.ContractType}" class="link print dog" >{if $agreement.HaveCopy}##DOCUMENT_HAVE_COPY##{else}##DOCUMENT_NOT_AVAILABLE##{/if}</a>
                        {else}
                            <span class="ui-icon-plus ui-icon" title="##ADD##">&nbsp;</span>
                            <a href="{$ROOT_URL}samo_action=SHOW&DATEBEG={$agreement.DateBeg|date_format:'sql'}&DATEEND={$agreement.DateEnd|date_format:'sql'}&INC={$agreement.inc|default:0}&OWNER={$agreement.Owner.Partner_partnerinc}&CONTRACTTYPE={$agreement.ContractType}" class="link print dog add" >##ADD##</a>&nbsp;
                        {/if}
                    {/if}
                </td>
            </tr>
            {if $agreement.contracts_document}
                <tr class="{$tr_class}">
                    <td colspan="6" style="padding: 0px; border-bottom-width: 0px;">
                        <table id="e_doc" width="100%">
                            <tr>
                                <td width="15%" class="r" style="vertical-align: top">##E_DOCUMENTS##</td>
                                <td width="85%" style="padding-right: 0px;">
                                    <table class="std" width="100%">
                                        <thead>
                                        <tr>
                                            <th width="35%">##E_DOC_TYPE##</th>
                                            <th width="10%">##E_DOC_FILE##</th>
                                            <th width="30%">##E_DOC_STATUS##</th>
                                            <th width="25%">##E_DOC_ACTION##</th>
                                        </tr>
                                        </thead>
                                        {foreach from=$agreement.contracts_document item="link"}
                                            <tr data-contracts_document="{$link.ContractsDocumentInc}" data-doctype="{$link.DocTypeInc}">
                                                <td>{$link.DocTypeName}{if $link.doctype_note}<br><span style="font-size: 11px;">{$link.doctype_note}</span>{/if}</td>
                                                <td>{$link.FileName}</td>
                                                <td>
                                                    {if $link.is_loaded}
                                                        <span class="document_status_{$link.DocumentStatusInc}">
                                                            {$link.DocumentStatusName}
                                                            {if $link.DocumentStatusInc == 3 && $link.StatusNote != ''}
                                                                : {$link.StatusNote}
                                                            {/if}
                                                        </span>
                                                    {/if}
                                                </td>
                                                <td style="padding-top: 4px; padding-bottom: 4px;">
                                                    {if $link.is_loaded}
                                                        <a href="{$link.a}" target="_blank">##E_DOC_PRINT_LINK##</a>
                                                    {/if}
                                                    {if $link.DocumentStatusInc != 2}
                                                        <button class="e_doc_btn_attach">##E_DOC_BTN_ATTACH##</button>
                                                        {if $link.DocumentStatusInc == 1}
                                                            <button class="e_doc_btn_detach">##E_DOC_BTN_DETACH##</button>
                                                        {/if}
                                                    {/if}
                                                </td>
                                            </tr>
                                        {/foreach}
                                    </table>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            {/if}
        {/if}
    {/foreach}
    </tbody>
</table>
*}