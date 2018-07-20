
(function($){var bank_old_value=$('#edit_agency').find('select.PARTNER_BANK').val();var rs_old_value=$('#edit_agency').find('input.PARTNER_RS').val();var ownership_self_employed=(typeof samo.ownership_self_employed!='undefined')?samo.ownership_self_employed:1;samo.edit_agency=function($module_container){var _ROOT_URL=samo.ROUTES.edit_agency.url;if(arguments.length==0){$module_container=$('#edit_agency')}
samo.set_data_mask($module_container);samo.helpalt_field($module_container);samo.banklist_original={};samo.bank_filter=function(){var $filter=$.trim($module_container.find('input.PARTNER_BIK').val()).toLowerCase(),$strfilter=$filter.length,is_ok=true,$bank=$module_container.find('select.PARTNER_BANK').detach().empty().append('<option value="">---</option>').appendTo('.frm-bik-bank');$.each(samo.banklist_original,function(key,$value){var bik=''+$.trim($value.bik).toLowerCase(),selected='',title='';if(!$strfilter||$filter==bik.substr(0,$strfilter)){selected=(bik==$filter)?'selected="selected"':'';title=($value.deleted)?$value.text+'('+samo.i18n('BANK_NOT_ACTIVE')+')':$value.text;$bank.append($('<option data-search-string=\''+title+'\' data-bik="'+$value.bik+'" '+selected+'></option>').val($value.value).html(title));is_ok=false;}});var $bank=$module_container.find('select.PARTNER_BANK');var $rs=$module_container.find('input.PARTNER_RS');if($bank.val()==bank_old_value){if($rs.val()==''){$rs.val(rs_old_value);}}else{if($rs.val()==rs_old_value){$rs.val('');}}
$('.PARTNER_BANK',$module_container).each(function(){$(this).find('option').each(function(){if($(this).attr('data-search-string')){$(this).attr('data-search-string',$(this).attr('data-search-string')+' '+$(this).attr('data-search-string').fixKeyboardLayout());}})});$bank.trigger('chosen:updated');};var default_required=[$module_container.find('input[name*="[PARTNER_KPP]"]').hasClass('required'),$module_container.find('input[name*="[PARTNER_REGISTRATION_ORGAN]"]').hasClass('required'),$module_container.find('input[name*="[PARTNER_REGISTRATION_SERIE]"]').hasClass('required'),$module_container.find('input[name*="[PARTNER_REGISTRATION_NUMBER]"]').hasClass('required')];$module_container.find('select.PARTNER_BANK option').each(function(idx,el){var $el=$(el);samo.banklist_original[idx]={'text':$el.text(),'value':el.value,'bik':$el.attr('data-bik'),deleted:$el.data('deleted')};}).end().find('select.PARTNER_OWNERSHIP').bind('change',function(){var val=$(this).val();var $kpp=$module_container.find('input[name*="[PARTNER_KPP]"]');var $registration_organ=$module_container.find('input[name*="[PARTNER_REGISTRATION_ORGAN]"]');var $registration_serie=$module_container.find('input[name*="[PARTNER_REGISTRATION_SERIE]"]');var $registration_number=$module_container.find('input[name*="[PARTNER_REGISTRATION_NUMBER]"]');if(val==ownership_self_employed){$.each([$kpp,$registration_organ,$registration_serie,$registration_number],function(idx,el){el.parents('tr:first').find('label').removeClass('required');el.removeClass('required');});}else{$.each([$kpp,$registration_organ,$registration_serie,$registration_number],function(idx,el){if(default_required[idx]){el.parents('tr:first').find('label').addClass('required');el.addClass('required');}});}}).each(function(){$(this).triggerHandler('change');}).end().find('select.PARTNER_BANK').bind('change',function(){var selected=$(this).find('option:selected').attr('data-bik')||'';$module_container.find('input.PARTNER_BIK').val(selected);samo.bank_filter();}).each(function(){$(this).triggerHandler('change');}).end().find('input.date').datePicker().end().find('input.PARTNER_RS').bind('change',function(){var $bank=$module_container.find('select.PARTNER_BANK');if($bank.val()==bank_old_value){$module_container.find('input.PARTNER_BIK').val('').triggerHandler('clearSearch');}}).end().find('input.PARTNER_OFFICIALNAME').bind('focus',function(){$(this).val($.trim($(this).val()));if($(this).val()==''){$(this).val($('option:selected',$('select.PARTNER_OWNERSHIP',$module_container)).text());}}).bind('blur',function(){var $name=$module_container.find('input.PARTNER_OFFICIALNAME'),val=$.trim($name.val()),is_ok=false;$module_container.find('select.PARTNER_OWNERSHIP option').each(function(){if(val==$(this).text()){is_ok=true;}
if(is_ok){$name.val('');}});}).end().find('input[type=text]').bind('keypress',samo.key_press_filter).end().find('input.PARTNER_BIK').bind('keyup',function(e){if(e.keyCode==27){$.event.trigger('clearSearch');e.stopPropagation();return;}
samo.bank_filter();}).bind('clearSearch',function(){this.value='';samo.bank_filter();}).end().find('input[name=save]').bind('click',function(e){e.stopPropagation();e.preventDefault();if(check_fields($module_container)){$.post(samo.ROOT_URL+$.param({samo_action:'SAVE_PARTNER'}),$module_container.find('.partner_info').pseudoForm(),null,'script');}});$('.PARTNER_TOWN,.PARTNER_BANK,.PARTNER_METROSTATION',$module_container).each(function(){$(this).find('option').each(function(){if($(this).attr('data-search-string')){$(this).attr('data-search-string',$(this).attr('data-search-string')+' '+$(this).attr('data-search-string').fixKeyboardLayout());}})});$('.PARTNER_TOWN,.PARTNER_BANK',$module_container).chosen({enable_split_word_search:false,search_contains:true});$('.PARTNER_METROSTATION',$module_container).chosen({placeholder_text_single:samo.i18n('SELECT_METRO')});$('.PARTNER_TAXATION,.PARTNER_OWNERSHIP,.PARTNER_DIRECTORPOSITION,.PARTNER_ACTIVITY',$module_container).chosen({disable_search:true});samo.enableMetro=function(){$('.PARTNER_METROSTATION',$module_container).prop('disabled',false).trigger('chosen:updated');};samo.renderMetroStation=function(){$('.PARTNER_METROSTATION option',$module_container).each(function(){var text=$(this).text();if(text){$(this).attr('data-search-string',(text+' '+text.fixKeyboardLayout()));}});};$module_container.find('select.PARTNER_TOWN').bind('change',function(){var selected_town=this.value;var phoneprefix=$(this).find('option:selected').data('phonePrefix');var $metrostation=$module_container.find('select.PARTNER_METROSTATION').prop('disabled',true);if(selected_town>0){$module_container.find('input.PARTNER_PHONES_PREFIX').val(phoneprefix);$.getScript(_ROOT_URL+$.param({TOWN:selected_town,samo_action:'TOWN',PARTNER_METROSTATION:$metrostation.val()}));}}).triggerHandler('change');samo.request_changes=function(){$module_container.find('input:disabled').each(function(){var $self=$(this);$self.replaceWith('<span class="frm-value request-changes" data-frm-name="'+$self.attr('data-frm-name')+'">'+$self.val()+'</span>')});$module_container.find('.request-changes').on('click',function(){var params={samo_action:'REQUEST_CHANGES'};$.getScript(_ROOT_URL+$.param(params),null,false);});};samo.request_changes_form=function(){var $frm=$('#request-changes-frm').on('submit',function(e){e.stopPropagation();e.preventDefault();$('#request-changes-btn').prop('disabled',true);$.post(this.action,$(this).serialize(),function(){$('#request-changes-btn').prop('disabled',false);},'script');});samo.edit_agency($frm);};samo.set_partpass_list_events=function(){$('.logins').delegate('.partpass_edit','click',function(e){e.stopPropagation();e.preventDefault();var pinc=parseInt($(this).parent().parent().data('partpass'),10);var result={};result.samo_action='EDIT_PARTPASS';if(pinc){result.PARTPASS_INC=pinc;}
$.getScript(_ROOT_URL+$.param(result),null,false);}).delegate('.partpass_delete','click',function(e){e.stopPropagation();e.preventDefault();if(!confirm($('#login_list').data('delete-confirm'))){return false;}
var pinc=parseInt($(this).parent().parent().data('partpass'),10);var result={};result.samo_action='DELETE_PARTPASS';result.PARTPASS_INC=pinc;$.getScript(_ROOT_URL+$.param(result),null,false);return true;});};samo.edit_login_prev=function(){var $login=$('#login');samo.set_data_mask($login);samo.helpalt_field($login);$login.find('form').bind('submit',function(e){e.stopPropagation();e.preventDefault();if(check_fields($login)){$.post(this.action,$(this).serialize(),null,'script');}}).end().find('input.date').datePicker();};function check_fields($container){var is_ok=true;$container.find('.required').not('label, :disabled').each(function(){if(!$.NonEmptyValue(this)){is_ok=false;return false;}else{if($(this).hasClass('PARTNER_OFFICIALNAME')){var ownerShip=$module_container.find('.PARTNER_OWNERSHIP');if(ownerShip.val()==ownership_self_employed){if($(this).val().split(' ').length<3){is_ok=samo.field.error(samo.i18n('REQUIRED_FULL_FIO'),this);return false;}}}}});if(is_ok){$container.find('input.date').each(function(){if(!$.valid_date(this)){is_ok=false;return false;}});}
if(is_ok){$container.find('input, select').not('label, :disabled').each(function(){if(!$.RegexpValue(this)){is_ok=false;return false;}});}
var el=$container.find('input.PARTNER_OFFICIALNAME');if(el.hasClass('required')){var val=$.trim(el.val());var ownership=$.trim($('select.PARTNER_OWNERSHIP option:selected',$container).text());if(val==ownership){$.notify({text:samo.i18n('OFFICIALNAME_EMPTY'),type:'error'});return false;}}
return is_ok;}
samo.bank_filter();samo.set_partpass_list_events();if(window.location.hash=='#PARTPASS_LIST'){$module_container.find('.partpass_create').click();}
samo.googlemap($module_container);};$(document).ready(function(){samo.edit_agency($('#edit_agency'));});})(samo.jQuery);