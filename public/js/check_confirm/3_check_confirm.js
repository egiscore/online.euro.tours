
(function($){var container=samo.initModuleContainer('check_confirm');samo.check_confirm=function(){var $module_container=container,_ROOT_URL=samo.ROUTES.check_confirm.url,loadBtn=$('.load',$module_container);samo.cache_controls($module_container);loadBtn.bind('click',function(){var is_ok=true;$('input',$module_container).each(function(){if(is_ok&&samo[this.name.toLowerCase()+'_required']&&this.value==$(this).data('default')){$.notify({text:samo.i18n('EMPTY_'+this.name),type:'error'});this.focus();is_ok=false;}});if(is_ok){if(top.location!=self.location){var width=600,height=400;var pop=window.open(getParams('check_popup'),'check_confirm','width='+width+',height='+height+',left='+((screen.width-width)/2)+',location=no,resizable=yes');pop.focus();}else{$.getScript(getParams('check'));}}});$('input',$module_container).each(function(){$(this).data('default',this.value);}).bind('focus',function(){if(this.value==$(this).data('default')){this.value='';}}).bind('blur',function(){if(this.value==''){this.value=$(this).data('default')}}).bind('keypress',function(e){if(13==e.which){loadBtn.click();}}).bind('keypress',samo.key_press_filter);samo.phones=function(){var $check_c=$('.check_c'),$phones=$check_c.find('[name^=PHONES]');samo.tourist_helpers($check_c);$check_c.find('.save').bind('click',function(){var phones={};$phones.each(function(){if(this.value!=''){phones[this.name]=this.value;}});params=$.param(phones);$.post(_ROOT_URL+$.param({samo_action:'SAVE_PHONES',CLAIM:$check_c.data('claim')}),params,null,'script');});};if($('.check_c .save').length){samo.phones();}
function getParams(action){var result={};result.samo_action=action;$('input',$module_container).each(function(){if(this.value!=$(this).data('default')||this.name=='embed'){result[this.name]=this.value;}});return _ROOT_URL+$.param(result);}};$(document).ready(samo.check_confirm);})(samo.jQuery);