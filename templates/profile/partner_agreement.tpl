{include file="../header.tpl" page_title="##PARTNER_AGREEMENT##" cssfiles="profile.css"}
{include file="../partial_top.tpl"}

<br>
<br>
<br>
##PARTNER_AGREEMENT_TEXT##
<br>
<br>
<br>
<br>
<label class="contract_agree"><input type="checkbox" autocomplete="off" id="CONTRACTAGREE">##PARTNER_CONTRACT_AGREE## <a href="{Samo_Url::route('profile', ['samo_action' => 'contractPreview'])}" target="_blank" title="##PARTNER_CONTRACT_PREVIEW##" id="partner_agreement_url" class="hidden">##PARTNER_CONTRACT_LINK##</a></label>
<br>
<br>
<button id="PARTNER_CONTRACT_AGREE_BTN">##PARTNER_CONTRACT_AGREE_BTN##</button>

{include file="../common.tpl"}
{jsload file="profile.js"}
{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}