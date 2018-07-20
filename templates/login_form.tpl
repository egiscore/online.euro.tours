{if !$antibot}
{if $popup_login}{cssload file="login.css"}{/if}
<div class="logon-wrapper">
	<div class="header">
		<div class="legend panel">
			##SAMO_FOR_AGENCY##
		</div>
		{if $smarty.get.page == 'bron' && isset($routes.bron_person) && !isset($smarty.get.KEY)}
			<div class="button-wrapper">
				<a class="button" href="{$routes.bron_person.url}{if isset($smarty.get.KEY)}KEY={$smarty.get.KEY|escape:'html'}{elseif isset($smarty.get.TICKET)}TICKET={$smarty.get.TICKET|escape:'html'}{else}CATCLAIM={$smarty.get.CATCLAIM|escape:'html'}{/if}">##SAMO_FOR_PERSON##</a>
			</div>
		{/if}
		{if $smarty.get.page == 'cl_refer' && isset($routes.cl_refer_person) && $routes.cl_refer_person.public}
			<div class="button-wrapper">
				<a class="button" href="{Samo_Url::route('cl_refer_person', ['CLAIM' => $smarty.get.CLAIM])}">##SAMO_FOR_PERSON##</a>
			</div>
		{/if}
	</div>
	<div class="panel" id="loginbox" data-orig-url="{$smarty.server.REQUEST_URI|escape:'html'}">
		<div class="choose">
			<span class="legend">##SAMO_LOGON##</span>
			{if isset($routes.register_agency) && $routes.register_agency.public}
				<a target="_blank" href="{$routes.register_agency.url}">{$routes.register_agency.title}</a>
			{/if}
		</div>
		<div class="fixer"></div>
		<form method="post" id="loginForm">
			<input type="hidden" name="samo_action" value="logon" />
			<input type="hidden" name="logon_key" id="logon_key" value="{$logon_key}" />
		<div class="row">
			<label for="login">##SAMO_LOGIN##<input id="login" placeholder="##LOGIN_ALIAS##" name="login" maxlength="64" /></label>
		</div>
		<div class="fixer"></div>
		<div class="row">
			<label for="passwd">##SAMO_PASSWORD##<input id="passwd" type="password" placeholder="##LOGIN_PASSWORD##" name="passwd"/></label>
		</div>
		<div class="fixer"></div>
		<div class="row">
			{if isset($routes.profile)}
			<a tabindex="-1" class="forgot" href="{Samo_Url::route('profile',['samo_action' => 'recovery_password'])}">##LOST_PASSWORD##</a>
			{/if} <button class="button">##LOGON_ACTION_BTN##</button>
		</div>
		<div class="fixer"></div>
		</form>
	</div>
</div>
{else}
<table class="std" id="logonform">
	<tr>
	<td class="n1">
            <form method="post" id="captchaForm" action="{$APP_HTTP_HOST|cat:$smarty.server.REQUEST_URI|escape:'html'}">
            <input type="hidden" name="samo_action" value="antibot" />
			<fieldset class="panel" id="captchabox" data-orig-url="{$APP_HTTP_HOST|cat:$smarty.server.REQUEST_URI|escape:'html'}">
				<legend>##SAMO_FOR_ROBOT##</legend>
				<table align="center">
					<tr>
					    <td align="center"><img id="icaptcha" height="48" width="120" src="{$APP_HTTP_HOST}{$WWWROOT}vendor/kcaptcha/reg.php?{$SESSION.NAME}={$SESSION.ID}&_={$smarty.now}" /><br>
					    <span class="link" id="recaptcha">##CAPTCHA_RELOAD##</span>
					    </td>
					</tr>
				</table>
				<div class="r submit">
					<input type="text" id="fcaptcha" name="antibot" class="frm-input num" value=""><input type="submit" class="button" value="##SAMO_LOGON##">
				</div>
				<p class="ffixer"></p>
			</fieldset>
            </form>
        </td>

	</tr>
</table>
{/if}
