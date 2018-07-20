
(function($){samo.profile_person=function(){function search_person(e){e.preventDefault();var $frm=$('#recovery-frm');$.post($frm.attr('action'),$frm.serialize(),null,'script');}
$('#recovery-frm').bind('submit',search_person);};$(document).ready(samo.profile_person);})(samo.jQuery);