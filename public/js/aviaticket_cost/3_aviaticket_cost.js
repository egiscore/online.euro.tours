
(function($){samo.aviaticket_cost=function(){var _ROOT_URL=samo.ROUTES.aviaticket_cost.url,$module_container=$('#resultset');$('#loadBtn').bind('click',function(){var result={};result.CLAIM=$('#resultset').attr('claim');var tmp=[];var tmpi=[];var tmplname=[];var error='';$('input.adult:checked').each(function(){var p=$(this).parent().parent();var name=$(p).find('input.tourist').val();var lname=$(p).find('td.fio').html();var pinf=$(p).attr('peopleinfo');if(name==''){error=samo.i18n('AV_NO_PEOPLE_NAME');return false;}
tmp.push(name);tmplname.push(lname);tmpi.push(pinf);});if(error!=''){alert(error);return false;}
result.adults=tmp.join(', ');result.adults_inc=tmpi.join(', ');result.adultslname=tmplname.join(', ');var tmp1=[];var tmp1i=[];var tmp1lname=[];$('input.infant:checked').each(function(){var p=$(this).parent().parent();var name=$(p).find('input.tourist').val();var pinf=$(p).attr('peopleinfo');var lname=$(p).find('td.fio').html();if(name==''){error=samo.i18n('AV_NO_PEOPLE_NAME');return false;}
tmp1.push(name);tmp1i.push(pinf);tmp1lname.push(lname);});if(error!=''){alert(error);return false;}
result.infants=tmp1.join(', ');result.infants_inc=tmp1i.join(', ');result.infantslname=tmp1lname.join(', ');$.post(_ROOT_URL+$.param({samo_action:'SPRAVKA'}),result,null,'script');$('#resultset').html(samo.i18n('AV_SUCCESS_RESULT'));});}
$(document).ready(samo.aviaticket_cost);})(samo.jQuery);