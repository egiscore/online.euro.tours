{include file="../header.tpl" page_title="##PAGE_TITLE##" cssfiles="register_agency.css"}
{include file="../partial_top.tpl"}
<div id="register_agency">
    {if $registerByInn}
        {include file="register_by_inn.tpl"}
    {else}
        <div class="googleMapWindow hidden">
            <div class="gdocsviewer loader">&nbsp;</div>
            {map_init point=$point div="map_container"}
        </div>
        {note}
        {include file="../fieldset_builder.tpl"  fields=$fields_partner}
        <div class="label">##REQUIRE_BOLD##</div>
        <br>
        {if isset($routes.registration) && $routes.registration.public}
            {include file="../fieldset_builder.tpl"  fields=$fields_partpass}
            <div class="label">##REQUIRE_BOLD##</div>
            <br>
        {/if}
        <table class="std">
            <tr>
                <td>
                    <img id="icaptcha"
                         src="{$APP_HTTP_HOST}{$WWWROOT}vendor/kcaptcha/reg.php?{$SESSION.NAME}={$SESSION.ID}&_={$smarty.now}"/><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="link" id="recaptcha">##CAPTCHA_RELOAD##</span>
                </td>
                <td>##SAMO_FOR_ROBOT##<br><br>
                    <input type="text" id="fcaptcha" name="are_you_human" class="num" value="" size="5"></td>
            </tr>
        </table>
        <br>
        <input type="submit" value="##BTN_REGISTER##" name="save">
    {/if}
</div>
{include file="../common.tpl"}
{jsload file="google_map.js"}
{jsload file="register_agency/jquery.validationEngine-en.js"}
{jsload file="register_agency/jquery.validationEngine.js"}
{jsload file="register_agency.js"}

{include file="../partial_bottom.tpl"}
{include file="../footer.tpl"}