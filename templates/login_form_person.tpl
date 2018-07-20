<div class="logon-wrapper person">
	<div class="header">
		<div class="legend panel">
			##SAMO_FOR_PERSON##
		</div>
		{if $smarty.get.page == 'bron_person'}
			<div class="button-wrapper">
				<a class="button" href="{Samo_Url::route('bron', $smarty.get)|escape:'html'|replace:'_person':''}">##SAMO_FOR_AGENCY##</a>
			</div>
		{/if}
		{if $smarty.get.page == 'cl_refer_person' && isset($routes.cl_refer)}
			<div class="button-wrapper">
				<a class="button" href="{Samo_Url::route('cl_refer', ['CLAIM' => $smarty.get.CLAIM])|escape:'html'}">##SAMO_FOR_AGENCY##</a>
			</div>
		{/if}
	</div>
	<div class="panel" id="loginbox" data-orig-url="{$smarty.server.REQUEST_URI|escape:'html'}">
		<div class="choose">
			<span class="legend">##SAMO_LOGON##</span>
            {if $smarty.get.page == 'bron_person'}<a href="{Samo_Url::route('bron_person', array_merge($smarty.get, ['GUEST' => 1]))|escape:'html'}" class="bron-person-autoregistration button" title="##BRON_PERSON_AUTO_REGISTRATION_HELPTEXT##">##LOGON_GUEST_BTN##</a>{/if}
		</div>
		<div class="fixer"></div>
		<form method="post" id="loginForm">
			<input type="hidden" name="samo_action" value="logon" />
			<input type="hidden" name="logon_key" id="logon_key" value="{$logon_key}" />
			<div class="row">
				<label for="login">{if $smarty.get.page == 'bron_person'}##PERSON_LOGIN_EMAIL_ONLY##{else}##PERSON_LOGIN_EMAIL_OR_CLAIM##{/if}<input id="CLAIM" placeholder="{if $smarty.get.page == 'bron_person'}##PERSON_LOGIN_EMAIL_ONLY##{else}##PERSON_LOGIN_EMAIL_OR_CLAIM##{/if}" name="CLAIM" maxlength="64" {if $smarty.get.CLAIM}value="{$smarty.get.CLAIM|escape:'html'}"{/if} class="helpalt" title="{if $smarty.get.page == 'bron_person'}##PERSON_LOGIN_HELPTEXT##{else}##PERSON_LOGIN_EMAIL_OR_CLAIM_HELPTEXT##{/if}"/></label>
			</div>
			<div class="fixer"></div>
			<div class="row">
				<label for="passwd">{if $smarty.get.page == 'bron_person'}##PERSON_LOGIN_PASSWORD_ONLY##{else}##PERSON_LOGIN_PASSWORD_OR_PNUMBER##{/if}<input id="WORDPASSWORD" type="password" placeholder="{if $smarty.get.page == 'bron_person'}##PERSON_LOGIN_PASSWORD_ONLY##{else}##PERSON_LOGIN_PASSWORD_OR_PNUMBER##{/if}" name="WORDPASSWORD" class="helpalt" title="{if $smarty.get.page == 'bron_person'}##PERSON_LOGIN_HELPTEXT##{else}##PERSON_PASSWORD_OR_PNUMBER_HELPTEXT##{/if}"/></label>
			</div>
			<div class="fixer"></div>
			<div class="row">
                {if isset($routes.profile_person)}
					<a tabindex="-1" class="forgot" href="{Samo_Url::route('profile_person',['samo_action' => 'recovery_password'])}">##LOST_PASSWORD##</a>
                {/if} <button class="button">##LOGON_ACTION_BTN##</button>
			</div>
			<div class="fixer"></div>
		</form>
	</div>
</div>
