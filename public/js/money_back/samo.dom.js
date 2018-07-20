"use strict";(function($){samo.dom=function(data){var dom={};if(data instanceof Object){dom.container=samo.initModuleContainer(data.module);}
function regExpFromString(q){var flags=q.replace(/.*\/([gimuy]*)$/,'$1');if(flags===q)flags='';var pattern=(flags?q.replace(new RegExp('^/(.*?)/'+flags+'$'),'$1'):q);try{return new RegExp(pattern,flags);}catch(e){return null;}}
return{init:function(nodes){if(!nodes){nodes=data;}
var self=this;$.each(nodes,function(key,value){if(key==='elements'){$.each(value,function(variable,selector){if(selector instanceof Object){if(selector.node){dom[variable]=self.find(selector.node);dom[variable].parentNode=self.find(selector.layout);}else{if($(selector).attr('data-samo-id')){variable=self.get(selector).attr('data-samo-id');}
dom[variable]=self.get(selector);}}else{dom[variable]=self.find(selector);dom[variable].parentNode=dom[variable].parent();}
dom[variable].disable=function(){dom[variable].attr('disabled','disabled');return dom[variable];};dom[variable].enable=function(){dom[variable].removeAttr('disabled');return dom[variable];};dom[variable].setWidth=function(value){dom[variable].css('width',value);return dom[variable];};dom[variable].setHref=function(value){dom[variable].attr('href',value);return dom[variable];};dom[variable].getHref=function(){return dom[variable].attr('href');};dom[variable].validate=function(){if(dom[variable].attr('data-required')==='true'){var name=dom[variable].attr('name');var mask=null;if(samo.LANG.MB_VALIDATES[name]){mask=samo.LANG.MB_VALIDATES[name];}
return{required:true,mask:regExpFromString(mask)}}
return{required:false,mask:null}};});}});return this;},add:function(elements,name){if(name){elements.attr('data-samo-id',name);}
this.init({elements:elements});},create:function(type,data){var el;if(!data){data={};}
if(!data.className){data.className='';}
if(!data.title){data.title='';}
if(!data.attr){data.attr='';}
if(!data.label){data.label='';}
if(!data.colSpan){data.colSpan=1;}
if(!data.accept){data.accept='*';}
if(type==='option'){el=$('<option '+'value="'+data.value+'"'+'class="'+data.className+'"'+'>'+data.label+'</option>');return el;}else if(type==='row'){el=$('<tr class="'+data.className+'"></tr>');return el;}
if(type==='cell'){el=$('<td colspan="'+data.colSpan+'" class="'+data.className+'"></td>');el.html(data.label);return el;}
if(type==='a'){var target='';var download='';if(data.target){target=' target="'+data.target+'"';}
if(data.download){download=' download';}
el=$('<a href="'+data.href+'" class="'+data.className+'" '+
data.attr+target+download+'>'+data.label+'</a>');return el;}
if(type==='span'){el=$('<span title="'+data.title+'" class="'+data.className+'">'+data.label+'</span>');el.html(data.label);return el;}
if(type==='br'){el=$('<br />');return el;}
if(type==='progressbar'){el=$('<div class="result-progress progress-bar blue shine"></div>');return el;}
if(type==='inputFile'){el=$('<input type="file" class="'+data.className+'" accept="'+data.accept+'">');return el;}
if(type==='button'){el=$('<button class="'+data.className+'" '+data.attr+'>'+data.label+'</button>');return el;}},get:function(selector){return $(selector);},find:function(selector){return dom.container.find(selector);},node:dom}};})(samo.jQuery);