
(function($){var container=samo.initModuleContainer('the_best');samo.the_best=function(container){var _ROOT_URL=samo.ROUTES.the_best.url,$module_container=container;$module_container.find('select').chosen();var _controls=samo.cache_controls($module_container,'select,input[type=hidden],.resultset');samo.price_helpers($module_container);samo.price_clickable($module_container);$('.load',$module_container).bind('click',function(){$.getScript(getParams('PRICES'),initResultset);});$.each(_controls,function(){$(this).bind('change',function(){if($(this).is('.TOWNFROMINC')||$(this).is('.STATEINC')){$.getScript(getParams(this.name),samo.blink_element);}})});function getParams(action){var useGET=arguments[1]||false;var result={samo_action:action};$.each(_controls,function(i,v){var name=v.name||$(v).attr('name');var value=$.controlValue(v,useGET);if(name&&value&&value!==0)
result[name]=value;});return _ROOT_URL+samo.getParams($.param(result),$module_container);}
function initResultset(){$module_container.find('.resultset').find('td.bron').addClass('active').end().find('td.stop').addClass('notactive').end().find('table.res tr:odd td').addClass('silver');}
initResultset();};samo.initHotelPopup(container);$(document).ready(samo.the_best(container));})(samo.jQuery);