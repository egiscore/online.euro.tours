
(function($){var cookies=function(){this.get=function(name){var value=false;if(cookie=document.cookie){if(cookie.match(new RegExp(name+'=([^;]*)','g'))){value=RegExp.$1;}}
return value;};this.set=function(name,value,expire){if(!this.is_enabled()){return false;}
expire=new Date((new Date)+expire);document.cookie=name+'='+value+';expires='+expire.toGMTString()+';';return true;};this.remove=function(name){if(document.cookie){document.cookie=name+'='+this.get(name)+';expires=Thu, 01-Jan-1970 00:00:01 GMT;';return true;}
return false;};this.is_enabled=function(){if(typeof navigator.cookieEnabled!='undefined'){return navigator.cookieEnabled;}
this.set('testcookie','testvalue',1000);if(!document.cookie){return false;}
this.remove('testcookie');return true;};};$(function(){var cookie=new cookies();if(cookie.is_enabled()){if($('#login').length){$('#login').get(0).focus();window.setTimeout(function(){$('.flash_message').fadeOut('slow');},3000);$('#loginForm').bind('submit',function(e){$('#login,#passwd',this).each(function(){if(!$(this).val()){e.preventDefault();e.stopPropagation();$(this).addClass('error').get(0).focus();}else{$(this).removeClass('error');}});});}
$(window).bind('beforeunload',function(){$.event.trigger('ajaxStart');});}else{$('#loginForm input').prop('disabled',true);$('.cookie_help').css('display','block');}
$('#recaptcha').bind('click',samo.recaptcha);});})(samo.jQuery);