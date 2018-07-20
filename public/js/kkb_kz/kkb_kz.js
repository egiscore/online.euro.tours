
(function($){samo.kkb_kz=function(){var $cont=$('#kkb_kz_form');var _ROOT_URL=samo.ROUTES.kkb_kz.url;if(-1!=_ROOT_URL.indexOf('?')){_ROOT_URL+='&';}
function checkAmount(){var amo=$('input[name=amount]');var val=amo.val();val=parseFloat(val.replace(',','.'));var err=false;if(isNaN(val)||val==0){val=0;err=samo.i18n('NO_CLAIM_PAYMENT');}else{var m=parseFloat(amo.data('max'));if(val>m){err=samo.i18n('PAYER_AMOUNT_BIG')+' '+m;}}
amo.val(val);if(err){amo.addClass('error');}else{amo.removeClass('error');}
if(err){$.notify({text:err,type:'error'});}
return!err?true:false;}
$('input[name=amount]',$cont).bind('blur',checkAmount);$('#kkb_kz_submit').bind('click',function(){makePost();return false;});$('#kkb_kz_submit').bind('ajaxStart',function(){$(this).attr('disabled','disabled');});$('#kkb_kz_submit').bind('ajaxStop',function(){$(this).removeAttr('disabled');});function makePost(){if(!checkAmount())return false;var params={};params.samo_action='GET_POST_DATA';params.CLAIM=samo.CLAIM;$('input,textarea',$cont).each(function(i,e){params[e.name]=e.value;});$.getScript(_ROOT_URL+$.param(params));return true;}
$cont.bind('submitKKBKZForm',function(){$('#kkb_kz_form').get(0).submit();$.modal.close();});if($.getParameter('DOPAY',true)==1){$('#kkb_kz_submit').click();}}})(samo.jQuery);