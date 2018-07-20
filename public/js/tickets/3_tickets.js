"use strict";(function($){var container=samo.initModuleContainer('tickets');samo.tickets=function(){var _ROOT_URL=samo.ROUTES.tickets.url,$module_container=container,DOLOAD=(parseInt($.getParameter('DOLOAD',true,$module_container))==1);var _controls=samo.cache_controls($module_container,'.TOWNFROMINC,.TOWNTOINC,.AIRLINE,.CURRENCYINC,.CLASS,.ADULT,.CHILD,.INFANT,.CHECKIN,.CHECKOUT,.FREIGHTBACK,.YESPLACES,input[name=embed],.CHECKIN_DELTA,.CHECKOUT_DELTA')
_controls.resultset=$module_container.find('.resultset');var ONLY_ROUNDTRIP=($('.FREIGHTBACK',$module_container).length==0)?1:0;if(DOLOAD){initResultset();}
var chosenControls='.ADULT,.CHILD,.CLASS,.CURRENCYINC,.age1,.age2,.age3,.period';$(chosenControls).each(function(){var $this=$(this);$this.chosen({enable_split_word_search:false,search_contains:true,disable_search:true});var chosenEl=$this.parent().find('.chosen-container');chosenEl.addClass($this.attr('name')+'_chosen');chosenEl.css('text-align','left');});$('.AIRLINE').chosen({placeholder_text:samo.i18n('AIRLINE_ANY'),enable_split_word_search:false,search_contains:true,allow_single_deselect:true});$module_container.find('.CHECKIN').bind('change.datepicker',function(e,d){if(d){var params={};if(1==$module_container.find('.FREIGHTBACK:checked').val()||ONLY_ROUNDTRIP==1){if(d.date>$(_controls.CHECKOUT).getDate()){params.value=d.formated;}}
params.start=$(this).clearVal();$(_controls.CHECKOUT).datePicker(params);}}).end().find('.CHECKOUT').bind('change.datepicker',function(e,d){if(d){var $checkout=$(this),$checkin=$(_controls.CHECKIN);if($checkin.getDate()>$checkout.getDate()){$checkout.val($checkin.clearVal());}}}).bind('focus',function(){$module_container.find('.FREIGHTBACK[value=1]').click();}).end().find('.TOWNFROMINC,.TOWNTOINC').bind('change',function(){var name=this.name||$(this).attr('name');if($.controlValue(name,false,$module_container)){$.getScript(getParams(name),function(){},true);}}).end().find('.FREIGHTBACK').bind('change',function(){var newDate='';var $checkout=$(_controls.CHECKOUT);if($(this).val()==1){newDate=$checkout.data('calendar').first;if(newDate){var $checkin=$(_controls.CHECKIN);if($checkin.getDate()>$checkout.getDate()){newDate=$checkin.clearVal();$checkout.val(newDate);}}}else{$checkout.val('');$(_controls.CHECKOUT_DELTA).val('0').trigger('chosen:updated');}}).end().find('.port_revert').bind('click',function(){$(_controls.TOWNTOINC).data('new-value',$(_controls.TOWNFROMINC).val());$(_controls.TOWNFROMINC).val($(_controls.TOWNTOINC).val()).trigger("chosen:updated").change();});$module_container.find('.CHILD').bind('draw_child_ages',function(){var child_count=parseInt(this.value);var $child_ages=$module_container.find('.age');var $child_ages_count=$child_ages.length;var $pcountLabel=$module_container.find('.pcount_label');if(child_count>0){$pcountLabel.css('visibility','visible');for(var i=1;i<=$child_ages_count;i++){if(i<=child_count){var $age=$child_ages.filter('.age'+i);$age.trigger('chosen:updated');$module_container.find('.AGE'+i+'_chosen').css('visibility','visible');}else{$module_container.find('.AGE'+i+'_chosen').css('visibility','hidden');}}}else{$pcountLabel.css('visibility','hidden');$module_container.find('.age_wrapper .chosen-container').css('visibility','hidden');}}).bind('change',function(){$(this).triggerHandler('draw_child_ages');}).triggerHandler('draw_child_ages');$('.resultset',$module_container).delegate('td.td_price span.price','click',function(){if($(this).is('.stop')){$.notify({text:$(this).attr('title'),type:'error',disappearTime:3000});}else{if($(this).is('.bron')){var $data=$(this).parents('tr:first').data();var params={TICKET:$data.claim}
window.open(samo.ROUTES.bron.url+$.param(params));}}}).end().find('input.date').datePicker().end().find('.CHECKOUT').bind('blur',function(){var newDate=$(this).clearVal();if(newDate==''){$module_container.find('.FREIGHTBACK[value=0]').click();}});if(ONLY_ROUNDTRIP==1){var newDate=$(_controls.CHECKIN).clearVal();$(_controls.CHECKOUT).val(newDate);var params={};params.start=newDate;$(_controls.CHECKOUT).datePicker(params);}
$module_container.find('.load').bind('click',getPrices);$module_container.find('.TOWNFROMINC,.TOWNTOINC').chosen({no_results_text:samo.i18n('NOT_SET_TOWNFROMINC'),enable_split_word_search:false,search_contains:true});function getPrices(){if(!checkParams()){return;}
if($module_container.hasClass('fast')){window.open(getParams(false)+'&DOLOAD=1');}else{$.getScript(getParams('PRICES'),initResultset,true);}}
function checkParams(){if($(_controls.CHECKIN).clearVal()==''){$(_controls.CHECKIN).errorField(samo.i18n('CL_W_NO_DATE_BEG'));return false;}
if($(_controls.FREIGHTBACK).is(':checked')&&$(_controls.CHECKOUT).clearVal()==''){$(_controls.CHECKOUT).errorField(samo.i18n('CL_W_NO_DATE_END'));return false;}
if(0==$(_controls.ADULT).val()&&0==$(_controls.CHILD).val()){$(_controls.ADULT).errorField(samo.i18n('CHOOSE_PEOPLE_COUNT'));return false;}
return true;}
function getParams(action){var useGET=arguments[1]||false;var params={};if(action){params.samo_action=action;}
$.each(_controls,function(i,v){var name=v.name||$(v).attr('name');if(name){if(false==action&&'embed'==name){return false;}
var new_value=$(v).data('new-value');if(typeof new_value!='undefined'&&new_value){params[name]=new_value;$(v).data('new-value',false);}else{params[name]=$.controlValue(v,useGET);}
if(name=='TOWNFROMINC'||name=='TOWNTOINC'){var list=(params[name]+'').split('.');if(list.length==2){params[name]=list[0];params[name.replace(/TOWN/,'PORT')]=list[1];}else{params[name.replace(/TOWN/,'PORT')]='';}}}});if(params.CHILD){var $ages=[];$module_container.find('.age').each(function(){if(this.value.length){$ages.push(parseInt(this.value));}});params.AGES=$ages.sort(function(a,b){return a-b;}).join(',');}
return _ROOT_URL+$.param(params);}
function initResultset(){var $legend=$module_container.find('.resultset').show();var $scrollTo=$module_container.find('#scrollto');var offset=($scrollTo.length?$scrollTo:$legend).offset();window.scrollTo(offset.left,offset.top);samo.helpalt_field($module_container.find('.resultset'),'hover','bottomLeft');}
$module_container.find('.searchmodes .searchmode .searchmode_button').on('mousedown keypress',function(e){var $self=$(this),params={};if(!$self.data('origHref')){$self.data('origHref',this.href);}
params['CHECKIN_BEG']=$.controlValue('CHECKIN',false,$module_container);if(1==$module_container.find("input[name=FREIGHTBACK]:radio:checked").val()){var checkout=$.controlValue('CHECKOUT',false,$module_container);var datebeg=samo.dateFromString(params['CHECKIN_BEG'],'yyyymmdd'),dateend=samo.dateFromString(checkout,'yyyymmdd');if(samo.dateAsString(datebeg)!=samo.dateAsString(dateend)){params['NIGHTS_FROM']=parseInt((dateend.getTime()-datebeg.getTime())/86400000);}}
params['CURRENCY']=$.controlValue('CURRENCYINC',false,$module_container);params['FREIGHT']=$.controlValue('YESPLACES',false,$module_container);params['ADULT']=$.controlValue('ADULT',false,$module_container);params['CHILD']=$.controlValue('CHILD',false,$module_container);if(params.CHILD){var $ages=[];$module_container.find('.ages').find('.age').each(function(){if(this.value.length){$ages.push(parseInt(this.value));}});params.AGES=$ages.sort(function(a,b){return a-b;}).join(',');}
var currentHref=$self.data('origHref');this.href=currentHref+(currentHref.indexOf('?')==-1?'?':'&')+$.param(params);return false;});};$(document).ready(samo.tickets);})(samo.jQuery);