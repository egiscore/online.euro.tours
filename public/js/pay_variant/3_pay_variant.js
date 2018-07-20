
(function($){samo.pay_variant=function(){var CLAIM=$('#pay_variant').data('claim');if(samo.ROUTES.deposit){$.require(samo.ROUTES.WWWROOT+'public/js/deposit/3_deposit.js');}
if(samo.ROUTES.psbank){$.require(samo.ROUTES.WWWROOT+'public/js/psbank/3_psbank.js');}
if(samo.ROUTES.platron){$.require(samo.ROUTES.WWWROOT+'public/js/platron/platron.js');}
if(samo.ROUTES.kkb_kz){$.require(samo.ROUTES.WWWROOT+'public/js/kkb_kz/kkb_kz.js');}
if(samo.ROUTES.uniteller){$.require(samo.ROUTES.WWWROOT+'public/js/uniteller/uniteller.js');}
if(samo.ROUTES.sberbank){$.require(samo.ROUTES.WWWROOT+'public/js/sberbank/sberbank.js');}
if(samo.ROUTES.credit_europe_bank||samo.ROUTES.alfabank||samo.ROUTES.paylate||samo.ROUTES.paybox||samo.ROUTES.uniteller||samo.ROUTES.liqpay||samo.ROUTES.platron||samo.ROUTES.fondy||samo.ROUTES.agroindbank||samo.ROUTES.psb||samo.ROUTES.processing_kz||samo.ROUTES.fortebank||samo.ROUTES.openbank){$.require(samo.ROUTES.WWWROOT+'public/js/acquiring.js');}
if(samo.ROUTES.credit_europe_bank){$.require(samo.ROUTES.WWWROOT+'public/js/credit_europe_bank/credit_europe_bank.js');}
if(samo.ROUTES.liqpay){$.require(samo.ROUTES.WWWROOT+'public/js/liqpay/liqpay.js');}
if(samo.ROUTES.alfabank){$.require(samo.ROUTES.WWWROOT+'public/js/alfabank/alfabank.js');}
if(samo.ROUTES.fondy){$.require(samo.ROUTES.WWWROOT+'public/js/fondy/fondy.js');}
if(samo.ROUTES.agroindbank){$.require(samo.ROUTES.WWWROOT+'public/js/agroindbank/agroindbank.js');}
if(samo.ROUTES.processing_kz){$.require(samo.ROUTES.WWWROOT+'public/js/processing_kz/processing_kz.js');}
if(samo.ROUTES.psb){$.require(samo.ROUTES.WWWROOT+'public/js/psb/psb.js');}
if(samo.ROUTES.paylate){$.require(samo.ROUTES.WWWROOT+'public/js/paylate/paylate.js');}
if(samo.ROUTES.paybox){$.require(samo.ROUTES.WWWROOT+'public/js/paybox/paybox.js');}
if(samo.ROUTES.troyka_pay_system){$.require(samo.ROUTES.WWWROOT+'public/js/troyka_pay_system/3_troyka_pay_system.js');}
if(samo.ROUTES.invoice){$.require(samo.ROUTES.WWWROOT+'public/js/invoice/3_invoice.js');}
if(samo.ROUTES.bonus_manager){$.require(samo.ROUTES.WWWROOT+'public/js/bonus_manager/3_bonus_manager.js');}
if(samo.ROUTES.fortebank){$.require(samo.ROUTES.WWWROOT+'public/js/fortebank/fortebank.js');}
if(samo.ROUTES.openbank){$.require(samo.ROUTES.WWWROOT+'public/js/openbank/openbank.js');}
$('#v_psbank').bind('click',psbank_link);$('#v_platron').bind('click',platron_link);$('#v_kkb_kz').bind('click',kkb_kz_link);$('#v_uniteller').bind('click',uniteller_link);$('#v_sberbank').bind('click',sberbank_link);$('#v_credit_europe_bank').bind('click',credit_europe_bank_link);$('#v_alfabank').bind('click',alfabank_link);$('#v_fortebank').bind('click',fortebank_link);$('#v_openbank').bind('click',openbank_link);$('#v_fondy').bind('click',fondy_link);$('#v_agroindbank').bind('click',agroindbank_link);$('#v_processing_kz').bind('click',processing_kz_link);$('#v_psb').bind('click',psb_link);$('#v_liqpay').bind('click',liqpay_link);$('#v_paylate').bind('click',paylate_link);$('#v_paybox').bind('click',paybox_link);$('#v_troyka_pay_system').bind('click',troyka_pay_system_link);$('#invoice_'+CLAIM).bind('click',function(e){e.preventDefault();e.stopPropagation();$.getScript(samo.ROUTES.invoice.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));});function psbank_link(){$.getScript(samo.ROUTES.psbank.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}
function platron_link(){$.getScript(samo.ROUTES.platron.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}
function kkb_kz_link(){$.getScript(samo.ROUTES.kkb_kz.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}
function uniteller_link(){$.getScript(samo.ROUTES.uniteller.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}
function sberbank_link(){$.getScript(samo.ROUTES.sberbank.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}
function credit_europe_bank_link(){$.getScript(samo.ROUTES.credit_europe_bank.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}
function alfabank_link(){$.getScript(samo.ROUTES.alfabank.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}
function fortebank_link(){$.getScript(samo.ROUTES.fortebank.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}
function openbank_link(){$.getScript(samo.ROUTES.openbank.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}
function fondy_link(){$.getScript(samo.ROUTES.fondy.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}
function agroindbank_link(){$.getScript(samo.ROUTES.agroindbank.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}
function processing_kz_link(){$.getScript(samo.ROUTES.processing_kz.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}
function psb_link(){$.getScript(samo.ROUTES.psb.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}
function liqpay_link(){$.getScript(samo.ROUTES.liqpay.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}
function paylate_link(){$.getScript(samo.ROUTES.paylate.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}
function paybox_link(){$.getScript(samo.ROUTES.paybox.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}
function troyka_pay_system_link(){$.getScript(samo.ROUTES.troyka_pay_system.url+$.param({CLAIM:CLAIM,samo_action:'CHECK'}));}};$(document).ready(samo.pay_variant);})(samo.jQuery);