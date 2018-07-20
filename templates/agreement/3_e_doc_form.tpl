<div id="e_doc"
     data-contracts_document_inc="{$CONTRACTS_DOCUMENT_INC}"
     data-doctype="{$DOCTYPEINC}"
     data-upload_format="{$edoc_types.upload_format|@glue}"
     data-upload_size="{$edoc_types.upload_size}">
    <div id="UPLOAD_DIV">
        <div>{if $edoc_types.note}{$edoc_types.note|nl2br}<br><br>{/if}</div>
        <table class="std" style="width: 97%;">
            <tr>
                <td style="text-align: left">
                    <input type="file" id="edoc_file" name="edoc_file" style="width: 100%"><br>
                    ##UPLOAD_FILE_TYPE## <span id="upload_file_format">{$edoc_types.upload_format|@glue}</span>
                </td>
                <td class="vt" style="text-align: right">
                    <button id="E_DOC_BTN_UPLOAD">##E_DOC_BTN_UPLOAD##</button>
                </td>
            </tr>
        </table>
        <br>
    </div>
</div>
