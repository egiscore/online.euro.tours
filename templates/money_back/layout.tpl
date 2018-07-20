{include file="../header.tpl" page_title="##MONEY_BACK##" cssfiles="money_back.css"}
{include file="../partial_top.tpl"}
<div id="money_back">
    <div class="panel controls">
        <form name="money_back">
            <table class="res">
                <thead>
                <tr>
                    <th colspan="2">##MONEY_BACK_PREPARE_BLANK##</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>##MONEY_BACK_CLAIM_FROM##:</td>
                    <td>
                        <input class="claimFrom" data-required="true"
                               name="claimFrom" type="text"
                               value=""/>
                    </td>
                </tr>
                <tr>
                    <td>##MONEY_BACK_SUMM##:</td>
                    <td>
                        <input class="summ" data-required="true"
                               name="summ" type="text"
                               value=""/>
                        <select class="cur" name="cur"></select>
                    </td>
                </tr>
                <tr>
                    <td>##MONEY_BACK_RECEIVER##:</td>
                    <td><input class="name" data-required="true" name="name"
                               type="text" value=""/></td>
                </tr>
                <tr>
                    <td>##MONEY_BACK_ACCOUNT##:</td>
                    <td><input class="account" data-required="true"
                               name="account" type="text" value=""/></td>
                </tr>
                <tr>
                    <td>##MONEY_BACK_BIC##:</td>
                    <td><input class="bik" data-required="true" name="bik"
                               type="text" value=""/></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="button" class="prepare-document">##MONEY_BACK_PREPARE##</button>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="result" id="result"></div>
        </form>
    </div>
    <table class="res paymentsList" id="paymentsList">
        <thead>
        <tr>
            <th>¹</th>
            <th>##MONEY_BACK_CLAIM##</th>
            <th>##MONEY_BACK_SUMM##</th>
            <th>##MONEY_BACK_RECEIVER##</th>
            <th>##MONEY_BACK_STATUS##</th>
            <th class="progressTd"></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <script type="template/html" id="rowTpl">
        <tr class="transition">
            <td><%= payment.inc %></td>
            <td><%= payment.claim_from %></td>
            <td><%= payment.summa %> <%= payment.currency.name %></td>
            <td><%= payment.recipient_name %></td>
            <td class="paymentStatusCell">
                <%= payment.status %> <%= payment.statusDate %>
                <div><%- payment.statusNote %></div>
            </td>
            <td class="downloadBlankCell"><%- payment.downloadBlankLink %></td>
            <td class="uploadCell"><%- payment.uploadLink %></td>
        </tr>
    </script>
    <script type="template/html" id="uploadTpl">
        <tr class="uploadRow transition">
            <td colspan="4"></td>
            <td colspan="3">
                <input type="file" class="iFile">
                <button data-parent="<%= upload.parent %>"
                        data-claim="<%= upload.claim %>"
                        data-payment="<%= upload.paymentInc %>"
                        data-doctype="<%= upload.docType %>"
                        class="sendFile"><%= upload.sendButtonLabel %>
                </button>
                <button data-parent="<%= upload.parent %>"
                        class="cancelSend"><%= upload.cancelButtonLabel %>
                </button>
            </td>
        </tr>
    </script>
</div>
{include file="../common.tpl"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}
{jsload file="ejs.js" base="public/js/sale/"}
{jsload file="money_back/validator.js"}
{jsload file="money_back/samo.dom.js"}
{jsload file="money_back.js"}