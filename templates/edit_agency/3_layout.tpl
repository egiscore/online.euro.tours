{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="edit_agency.css"}
{include file="../partial_top.tpl"}
<div id="edit_agency">
    <div class="googleMapWindow hidden">
        <div class="gdocsviewer loader">&nbsp;</div>
        {map_init point=$point div="map_container"}
    </div>
    {note}
    <div class="partner_info">
        {include file="../controls.tpl" control="SEARCHMODE" SEARCHMODE=$PERSONAL_AREA}
        {include file="../fieldset_builder.tpl"}
        {if $PartnerLogins}
            <div id="PARTPASS_LIST">
                {include file="3_partpass_list.tpl"}
            </div>
        {/if}
        {if $saveAccess}
            <input type="submit" value="##BTN_SAVE##" name="save">
        {/if}
    </div>
    <br>
    {if $URL}
        <a class="link partner_toggle" href="{$URL}">##PARTNER_WARRENT##</a>
    {/if}

</div>
{include file="../common.tpl"}
{jsload file="google_map.js"}
{jsload file="edit_agency.js"}

{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}