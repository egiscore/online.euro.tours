
(function($){var container=samo.initModuleContainer('freight_time');samo.freight_time=function(){var _ROOT_URL=samo.ROUTES.freight_time.url,$module_container=container,_controls=$('select,input',$module_container),DOLOAD=(parseInt($.getParameter('DOLOAD',true,$module_container))==1);samo.cache_controls($module_container);$('select',$module_container).bind('change',function(){$('.resultset',$module_container).empty();});$('.TOWNFROMINC,.STATEINC,.TOWNTOINC',$module_container).each(function(){$(this).find('option').each(function(){if($(this).attr('data-search-string')){$(this).attr('data-search-string',$(this).attr('data-search-string')+' '+$(this).attr('data-search-string').fixKeyboardLayout());}})}).chosen({});$('.TOWNFROMINC,.STATEINC',$module_container).bind('change',function(){$.getScript(getParams(this.name),function(){$(this).trigger('chosen:udated');});});$('.load',$module_container).bind('click',getResult);if(DOLOAD){getResult();}
function getResult(){if(samo.checkStateAndTownfrom($module_container)){$.getScript(getParams('FREIGHTTIME'),true);}}
function getParams(action){var useGET=arguments[1]||false;var result={};result.samo_action=action;_controls.each(function(){var name=this.name||$(this).attr('name');var value=$.controlValue(this,useGET);if(name&&value&&value!==0)
result[name]=value;});return _ROOT_URL+$.param(result);}}
$(document).ready(samo.freight_time);})(samo.jQuery);