
(function($){samo.anketa=function(){var _ROOT_URL=samo.ROUTES.anketa.url,$module_container=$('#anketa'),_controls=$module_container.find('select,input').not(':file');$.each(['edit_tourist'],function(){if(typeof samo.ROUTES[this]!='undefined'){$.require(samo.ROUTES.WWWROOT+'public/js/'+this+'/3_'+this+'.js');}});samo.load_orders=function(){window.location.href=window.location+"&accept=1"};var edit_tourist_saved=false;samo.helpalt_field($module_container);$('input[name=anketa_file]',$module_container).bind('change',function(){if(check_file_extension(this)){$(this).parent().parent().submit();}});function check_file_extension(input_file_field){if(input_file_field.value){var tmp=input_file_field.value.toLowerCase().split('.'),ext=tmp[tmp.length-1];if($.inArray(ext,['jpg','jpeg','gif','png'])!=-1){if(input_file_field.files&&input_file_field.files[0]&&input_file_field.files[0].size&&input_file_field.files[0].size>2000000){$.notify({text:samo.i18n('FILE_TOO_LARGE'),type:'error'});}else{return true;}}else{$.notify({text:samo.i18n('NOT_SUPPORTED_FILETYPE'),type:'error'});}}
return false;}
$module_container.find('input.date').mask(samo.dateMask).attr('placeholder',samo.i18n('DATE_FORMAT_TITLE'));samo.set_data_mask($module_container);$('.load',$module_container).click(function(){var tmp=$('#VISA_INPUTED').is(':checked');if(!tmp||(check_fields_old()&&confirm(samo.i18n('ANKETA_CONFIRM_SAVE')))){$.post(getURL('SAVE')+'&VISA_INPUTED='+Number(tmp),getParams(),null,'script');}});$module_container.find('#ANKETA_FORM').bind('submit',function(e){e.stopPropagation();e.preventDefault();var visa_inputed=!$('#VISA_INPUTED').is(':disabled')&&$('#VISA_INPUTED').is(':checked');if(check_fields('#anketa')){if(!visa_inputed||confirm(samo.i18n('ANKETA_CONFIRM_SAVE'))){if($('#VISA_INPUTED').is(':disabled')){$('#VISA_INPUTED').removeAttr('disabled');}
$.post(this.action,$(this).serialize(),null,'script');}}});$('.load_children',$module_container).click(function(){$.post(getURL('LOAD_CHILDREN'),getParams(),null,'script');});$('input[type=text]',$module_container).bind('keypress',samo.key_press_filter);$('#anketa_print_btn').bind('click',samo.delayed_download);function getParams(){var result={};_controls.each(function(){var name=this.name||$(this).attr('name');if(name!='VISA_INPUTED'){if(!$(this).is(':disabled')){var value=$.controlValue(this);var tag=this.tagName.toLowerCase();if(tag=='select'&&value==''){result[name]=0;}else if(value!=''){result[name]=value;}}}});return result;}
var fieldgroup_required=[];fieldgroup_required['greece_mow_v1']=[['PreviousShengen_Country','PreviousShengenVisaNumber1','PreviousShengenDateFrom1','PreviousShengenDateTo1'],['PreviousShengen1_Country','PreviousShengenVisaNumber2','PreviousShengenDateFrom2','PreviousShengenDateTo2'],];function check_fields(container){var is_ok=true;var visa_inputed=$('#VISA_INPUTED').is(':checked');$container=$(container);if(visa_inputed){if(!edit_tourist_saved){$container.find('.frm-value').not('label').each(function(){if(!$.NonEmptyValue(this)){samo.load_orders=function(){edit_tourist_saved=true;$module_container.find('#ANKETA_FORM').submit();};is_ok=false;var PEOPLE=$module_container.data('people');var CLAIM=$module_container.data('claim');samo.edit_tourist_link(PEOPLE,CLAIM);return false;}});}
if(is_ok){$container.find('.required').not('label, :disabled').each(function(){if(!$.NonEmptyValue(this)){is_ok=false;return false;}});}
if(is_ok){var anketa=$module_container.data('anketa');if(fieldgroup_required[anketa]!==undefined){$.each(fieldgroup_required[anketa],function(index,groupf){var empty=[];$.each(groupf,function(index,item){var element=$('[name*="['+item+']"]');if(element!=undefined&&$('[name*="['+item+']"]').val()==''){empty.push(item);}});if(empty.length>0&&empty.length!=groupf.length){is_ok=false;$.NonEmptyValue($('[name*="['+empty[0]+']"]'));return false;}});}}}
if(is_ok){$container.find('.date').each(function(){if(!$.valid_date(this)){is_ok=false;return false;}});}
if(is_ok){$container.find('input[type="text"]').not(':disabled').each(function(){$(this).val($.trim($(this).val()));if(!$.RegexpValue(this)){is_ok=false;return false;}});}
return is_ok;}
function check_fields_old(){var is_ok=true;samo.field.clear_errors($module_container);$('.required',$module_container).not('label').not(':disabled').each(function(){if(!$(this).val().length){is_ok=samo.field.error(samo.i18n('REQUIRED_FIELD_EMPTY'),this);return false;}});if(is_ok){$('.date',$module_container).each(function(){if(this.value.length&&!$.valid_date(this)){is_ok=samo.field.error(samo.i18n('DATE_FORMAT_TITLE'),this);return false;}});}
return is_ok;}
function getURL(action){var useGET=arguments[1]||false;var result={};result.samo_action=action;result.PEOPLE=$module_container.data('people');result.CLAIM=$module_container.data('claim');result.ANKETA=$module_container.data('anketa');return _ROOT_URL+$.param(result);}
$('.crop_button',$module_container).bind('click',function(){send_crop_picture($(this).data('type'));});function send_crop_picture(type){if($('#samo-'+type+'-edtor').hasClass('samo-edtor-red')){if(!confirm(samo.i18n('ANKETA_LOW_QUALITY_IMAGE_CONFIRM'))){return false;}}
var sss=$('#samo-'+type+'-edtor').find('.area-select').imgAreaSelect({instance:true});if(!sss.getSelection().width){alert('Not selected');return false;}
var top=parseInt($('#samo-'+type+'-edtor').data('offset-top'));var left=parseInt($('#samo-'+type+'-edtor').data('offset-left'));if(isNaN(top)){top=0;}
if(isNaN(left)){left=0;}
var params={};params.PICTURE_TYPE=type;params.x1=sss.getSelection().x1+left;params.x2=sss.getSelection().x2+left;params.y1=sss.getSelection().y1+top;params.y2=sss.getSelection().y2+top;params.zoom=parseFloat($('#samo-'+type+'-edtor').data('zoom'));params.rotate=$('#samo-'+type+'-edtor .rotate_angle input').val();$.post(getURL('CROP_PICTURE'),params,null,'script');}
function FingersChange(){var val=$('input[name*="[Fingers]"]:radio:checked').val();var dis=true;if(val=='True'){dis=false;}
$('[name*="[Fingers_date]"]').attr('disabled',dis);$('[name*="[Fingers_VisaNumber]"]').attr('disabled',dis);if(dis){$('[name*="[Fingers_date]"]').removeClass('required').closest('tr').find('label').removeClass('required');$('[name*="[Fingers_VisaNumber]"]').removeClass('required').closest('tr').find('label').removeClass('required');}else{$('[name*="[Fingers_date]"]').addClass('required').closest('tr').find('label').addClass('required');$('[name*="[Fingers_VisaNumber]"]').addClass('required').closest('tr').find('label').addClass('required');}};$('[name*="[Fingers]"]').bind('change',FingersChange).triggerHandler('change');}
samo.edit_tourist_link=function(PEOPLE,CLAIM){$.getScript(samo.ROUTES.edit_tourist.url+$.param({PEOPLE:PEOPLE,CLAIM:CLAIM}));}
samo.return_show=function(type){$('.anketa_hide').show();$('#div_crop_'+type).hide();$('#anketa .fieldset_photo').show();$('#samo-'+type+'-edtor .area-select').imgAreaSelect({remove:true});$('#samo-'+type+'-edtor .container img').parent().rotate(0)
$('#samo-'+type+'-edtor .container img').attr('style','').wrap('<div class="img"></div>');$('#samo-'+type+'-edtor').parent().html($('#samo-'+type+'-edtor .container .img').html());}
samo.image_select=function(type,w_min,h_min,w_max,h_max){samo.return_show(type);samo.anketa.hasMousedown=false;$('#div_crop_'+type).show();$('#anketa .fieldset_photo[id!="fieldset_'+type+'"]').hide();var tmp=w_min+':'+h_min;var img='#'+type+'_anketa';$('.anketa_hide').hide();$(img).data('width',$(img).width()).data('height',$(img).height()).attr('width','').attr('height','').data('o_width',$(img).width()).data('o_height',$(img).height()).width($(img).data('width')).height($(img).data('height'));$(img).wrap('<div id="samo-'+type+'-edtor" class="samo-edtor"><div class="container odd"><div class="inner"><div class="rotate"></div></div></div>');$('#samo-'+type+'-edtor .container').after('<div class="panel"><span class="icon rotate_left" title="'+samo.i18n('ANKETA_ROTATE_LEFT')+'"></span><span class="icon rotate_angle"><input type="text" class="frm-input" /></span><span class="icon rotate_right" title="'+samo.i18n('ANKETA_ROTATE_RIGHT')+'"></span><span class="ctrl ctrl_rotate" title="'+samo.i18n('ANKETA_ROTATE')+'"></span><span class="ctrl ctrl_zoom-in" title="'+samo.i18n('ANKETA_ZOOM_IN')+'"></span><span class="ctrl ctrl_zoom-out" title="'+samo.i18n('ANKETA_ZOOM_OUT')+'"></span></div>');var containerSize=Math.round(Math.sqrt(Math.pow($(img).width(),2)+Math.pow($(img).height(),2)));$('#samo-'+type+'-edtor, #samo-'+type+'-edtor .container').width(containerSize).height(containerSize);$('#samo-'+type+'-edtor .container .inner').css({paddingTop:Math.round((containerSize-$(img).height())/2),paddingRight:containerSize-$(img).width()-Math.round((containerSize-$(img).width())/2),paddingBottom:containerSize-$(img).height()-Math.round((containerSize-$(img).height())/2),paddingLeft:containerSize-$(img).width()-Math.round((containerSize-$(img).width())/2)}).prepend('<div class="area-select"></div>').find('.area-select').data('width',$(img).width()).data('height',$(img).height());var panel=$('#samo-'+type+'-edtor .container').parent().find('.panel');var pageX=0;var pageY=0;var selectAreaCenter=[0,0,0];var rotateValue=0;var blockHeight=$('#samo-'+type+'-edtor').height();var ctrlRotate=$('#samo-'+type+'-edtor .container').parent().find('.ctrl_rotate');var ctrlZoomIn=$('#samo-'+type+'-edtor .container').parent().find('.ctrl_zoom-in');var ctrlZoomOut=$('#samo-'+type+'-edtor .container').parent().find('.ctrl_zoom-out');var rotateNoMargin=false;if($.browser.msie){$(ctrlRotate).remove();rotateNoMargin=true;}
var getSelectAreaCenter=function(){var area=$('#samo-'+type+'-edtor .area-select').imgAreaSelect({instance:true});var x=area.getSelection().x1;var y=area.getSelection().y1;var prev=parseInt($('#samo-'+type+'-edtor .rotate_angle input').data('prev'));if(isNaN(prev)){$('#samo-'+type+'-edtor .rotate_angle input').data('prev',0);prev=0}
selectAreaCenter=[parseInt($('#samo-'+type+'-edtor .inner').css('padding-left'))+parseInt($('#samo-'+type+'-edtor .area-select').css('margin-left'))+x+Math.round((area.getSelection().x2-x)/2),parseInt($('#samo-'+type+'-edtor .inner').css('padding-top'))+parseInt($('#samo-'+type+'-edtor .area-select').css('margin-top'))+y+Math.round((area.getSelection().y2-y)/2),prev,area.getSelection().x2-x,area.getSelection().y2-y];}
var areaSelect=null;$('#samo-'+type+'-edtor').data('offset-left',0).data('offset-top',0).data('zoom',1);var getImgAreaSelect=function(obj,options){var cont=$(obj).parents('.container:first');if($(obj).height()==$(cont).height()){$(obj).css({position:'absolute',top:$(cont).offset().top});}else{$(obj).css({position:'',top:''});}
options.onSelectChange=function(img,selection){var obj=$(img).parent().find('img');var scale=parseInt($(obj).data('o_width'))/$(obj).width();var wSelect=Math.round(parseFloat(selection.width*scale));var hSelect=Math.round(parseFloat(selection.height*scale));if(Math.round(w_min*$(obj).data('o_width')/$(obj).data('width'))>wSelect||Math.round(h_min*$(obj).data('o_width')/$(obj).data('width'))>hSelect){$(img).parents('.samo-edtor:first').addClass('samo-edtor-red');}else{$(img).parents('.samo-edtor:first').removeClass('samo-edtor-red');}}
areaSelect=$(obj).imgAreaSelect(options);$('.imgarea-'+type).each(function(){if(this.addEventListener){if('onwheel'in document){this.addEventListener("wheel",onWheel,false);}else if('onmousewheel'in document){this.addEventListener("mousewheel",onWheel,false);}else{this.addEventListener("MozMousePixelScroll",onWheel,false);}}else{this.attachEvent("onmousewheel",onWheel);}});}
var onWheel=function(e){e=e||window.event;var delta=e.deltaY||e.detail||e.wheelDelta;if(($.browser.opera?(-1)*delta:delta)<0){$(ctrlZoomOut).click();}else{$(ctrlZoomIn).click();}
return false;}
var getCoord=function(center,container,angle){if(center==null){center=selectAreaCenter;}
if(container==null){container=[containerSize,containerSize];}
x=center[0]-Math.round(container[0]/2);y=Math.round(container[1]/2)-center[1];var a=Math.atan(Math.abs(y)/Math.abs(x))*180/Math.PI;if(isNaN(a)){a=0;}
var r=Math.round(Math.sqrt(Math.pow(x,2)+Math.pow(y,2)));if(x<0){if(y<0){a=360-a;}}else{if(y<=0){a=180+a;}else{a=180-a;}}
return[x,y,r,(a-center[2]+angle)];}
var getMargin=function(top,left,angle){var x=0;var y=0;if(top&&left){x=left*Math.cos(angle*Math.PI/180)+top*Math.sin(angle*Math.PI/180);y=-left*Math.sin(angle*Math.PI/180)+top*Math.cos(angle*Math.PI/180);}else{if(top){x=top*Math.sin(angle*Math.PI/180);y=top*Math.cos(angle*Math.PI/180);}else{x=left*Math.cos(angle*Math.PI/180);y=-left*Math.sin(angle*Math.PI/180);}}
return{top:Math.round(y),left:Math.round(x)};}
var ctrlZoomFn=function(zoom){var area=$('#samo-'+type+'-edtor .area-select').imgAreaSelect({instance:true});var x1=area.getSelection().x1;var x2=area.getSelection().x2;var y1=area.getSelection().y1;var y2=area.getSelection().y2;var width=x2-x1;var height=y2-y1;var angle=parseInt($('#samo-'+type+'-edtor .rotate_angle input').val());if(isNaN(angle)){angle=0;$(img).data('angle','0');$('#samo-'+type+'-edtor .rotate_angle input').val('0');}
$('#samo-'+type+'-edtor .area-select').imgAreaSelect({remove:true});var imgWidth=$('#samo-'+type+'-edtor .container img').data('width')*zoom;var imgHeight=$('#samo-'+type+'-edtor .container img').data('height')*zoom;var size=getAreaSelectSize(imgWidth,imgHeight,null);var newWidth=size[0],newHeight=size[1];var offsetTop=0;var offsetLeft=0;var scale=zoom/parseFloat($('#samo-'+type+'-edtor').data('zoom'));var paddingTop=Math.max(0,Math.floor((containerSize-newHeight)/2));var paddingLeft=Math.max(0,Math.floor((containerSize-newWidth)/2));if(paddingTop==0){offsetTop=Math.round(containerSize/2)-Math.round((parseInt($('#samo-'+type+'-edtor').data('offset-top'))+y1+Math.round((y2-y1)/2))*scale);if(offsetTop>0){offsetTop=0;}
if(Math.abs(offsetTop)+containerSize>newHeight){offsetTop=containerSize-newHeight;}}
if(paddingLeft==0){offsetLeft=Math.round(containerSize/2)-Math.round((parseInt($('#samo-'+type+'-edtor').data('offset-left'))+x1+Math.round((x2-x1)/2))*scale);if(offsetLeft>0){offsetLeft=0;}
if(Math.abs(offsetLeft)+containerSize>newWidth){offsetLeft=containerSize-newWidth;}}
$('#samo-'+type+'-edtor .container .inner').css({width:Math.min(containerSize,newWidth),height:Math.min(containerSize,newHeight),paddingTop:paddingTop,paddingRight:Math.max(0,Math.ceil((containerSize-newWidth)/2)),paddingBottom:Math.max(0,Math.ceil((containerSize-newHeight)/2)),paddingLeft:paddingLeft});var top=Math.round((containerSize-newHeight)/2);var left=Math.round((containerSize-newWidth)/2);var offset=getMargin(offsetTop-top,offsetLeft-left,angle);if(Object.prototype.toString.call(rotateNoMargin)==='[object Array]'){top=top+rotateNoMargin[0]*zoom;left=left+rotateNoMargin[1]*zoom;}
$('#samo-'+type+'-edtor .container .rotate').css({marginTop:Math.floor((newHeight-imgHeight)/2)+top,marginLeft:Math.floor((newWidth-imgWidth)/2)+left,width:imgWidth,height:imgHeight});$('#samo-'+type+'-edtor .container img').css({top:offset.top,left:offset.left,width:imgWidth,height:imgHeight});$('#samo-'+type+'-edtor .container .area-select').width(Math.min(containerSize,newWidth)).height(Math.min(containerSize,newHeight))
$('#samo-'+type+'-edtor .container .inner').css({paddingTop:Math.max(0,Math.floor((containerSize-newHeight)/2)),paddingRight:Math.max(0,Math.floor((containerSize-newWidth)/2)),paddingBottom:Math.max(0,Math.ceil((containerSize-newHeight)/2)),paddingLeft:Math.max(0,Math.ceil((containerSize-newWidth)/2))});getImgAreaSelect($('#samo-'+type+'-edtor .area-select'),{classPrefix:'imgarea-'+type+' imgareaselect',x1:Math.round((parseInt($('#samo-'+type+'-edtor').data('offset-left'))+x1)*scale)-Math.abs(offsetLeft),y1:Math.round((parseInt($('#samo-'+type+'-edtor').data('offset-top'))+y1)*scale)-Math.abs(offsetTop),x2:Math.round((parseInt($('#samo-'+type+'-edtor').data('offset-left'))+x1)*scale)-Math.abs(offsetLeft)+(x2-x1)*scale,y2:Math.round((parseInt($('#samo-'+type+'-edtor').data('offset-top'))+y1)*scale)-Math.abs(offsetTop)+(y2-y1)*scale,minHeight:h_min,minWidth:w_min,persistent:true,aspectRatio:tmp,handles:true});$('#samo-'+type+'-edtor').data('offset-left',Math.abs(offsetLeft)).data('offset-top',Math.abs(offsetTop)).data('zoom',zoom);if(rotateNoMargin){$(panel).find('input').val(angle).change();}
$(img).removeClass('hand');}
var setAreaSelect=function(){var angle=parseInt($('#samo-'+type+'-edtor .rotate_angle input').val());if(isNaN(angle)){angle=0;$(img).data('angle','0');$('#samo-'+type+'-edtor .rotate_angle input').val('0');}
var width=parseFloat($('#samo-'+type+'-edtor .inner img').data('width'))*parseFloat($('#samo-'+type+'-edtor').data('zoom'));var height=parseFloat($('#samo-'+type+'-edtor .inner img').data('height'))*parseFloat($('#samo-'+type+'-edtor').data('zoom'));size=getAreaSelectSize(width,height,angle);size_old=getAreaSelectSize(width,height,$('#samo-'+type+'-edtor .rotate_angle input').data('prev'));var w=size[0],h=size[1];var top=Math.min(0,Math.round((containerSize-h)/2));var left=Math.min(0,Math.round((containerSize-w)/2));if($('#samo-'+type+'-edtor .area-select').width()){center=[parseInt($('#samo-'+type+'-edtor').data('offset-left'))+Math.round(Math.min(containerSize,size_old[0])/2),parseInt($('#samo-'+type+'-edtor').data('offset-top'))+Math.round(Math.min(containerSize,size_old[1])/2),selectAreaCenter[2]];center=getCoord(center,[size_old[0],size_old[1]],angle);x=Math.min(0,Math.floor(containerSize/2)-(Math.floor(center[2]*Math.cos(center[3]*Math.PI/180)*(-1)+Math.round(w/2))));y=Math.min(0,Math.floor(containerSize/2)-(Math.floor(Math.round(h/2)-center[2]*Math.sin(center[3]*Math.PI/180))));$('#samo-'+type+'-edtor .inner .rotate img').css(getMargin(y-top,x-left,angle));$('#samo-'+type+'-edtor').data('offset-left',Math.abs(x)).data('offset-top',Math.abs(y));}
$('#samo-'+type+'-edtor .container .area-select, #samo-'+type+'-edtor .inner').width(Math.min(containerSize,w)).height(Math.min(containerSize,h));$('#samo-'+type+'-edtor .container .area-select').data('width',w).data('height',h);if(rotateNoMargin){rotateNoMargin=[Math.round(parseInt($('#samo-'+type+'-edtor .container .rotate').css('margin-top'))/parseFloat($('#samo-'+type+'-edtor').data('zoom'))),Math.round(parseInt($('#samo-'+type+'-edtor .container .rotate').css('margin-left'))/parseFloat($('#samo-'+type+'-edtor').data('zoom')))];top=top+rotateNoMargin[0]*parseFloat($('#samo-'+type+'-edtor').data('zoom'));left=left+rotateNoMargin[1]*parseFloat($('#samo-'+type+'-edtor').data('zoom'));}
$('#samo-'+type+'-edtor .inner .rotate').css({marginTop:Math.floor((h-height)/2)+top,marginLeft:Math.floor((w-width)/2)+left,width:width,height:height});$('#samo-'+type+'-edtor .container .inner').css({paddingTop:Math.max(0,Math.floor((containerSize-h)/2)),paddingRight:Math.max(0,Math.floor((containerSize-w)/2)),paddingBottom:Math.max(0,Math.ceil((containerSize-h)/2)),paddingLeft:Math.max(0,Math.ceil((containerSize-w)/2))});$('#samo-'+type+'-edtor .container .rotate').data('offset-top',parseInt((h-height)/2)).data('offset-left',parseInt((w-width)/2));if(selectAreaCenter[3]==0){selectAreaCenter[3]=w_min;selectAreaCenter[0]+=Math.round(w_min/2);}
if(selectAreaCenter[4]==0){selectAreaCenter[4]=h_min;selectAreaCenter[1]+=Math.round(h_min/2);}
var coord=getCoord(null,null,angle);x=Math.floor(coord[2]*Math.cos(coord[3]*Math.PI/180)*(-1)+Math.round(containerSize/2)-parseInt($('#samo-'+type+'-edtor .inner').css('padding-left'))-parseInt($('#samo-'+type+'-edtor .area-select').css('margin-left')));y=Math.floor(Math.round(containerSize/2)-coord[2]*Math.sin(coord[3]*Math.PI/180)-parseInt($('#samo-'+type+'-edtor .inner').css('padding-top'))-parseInt($('#samo-'+type+'-edtor .area-select').css('margin-top')));if(y-Math.floor(selectAreaCenter[4]/2)<0){y=Math.floor(selectAreaCenter[4]/2);}
if(y+Math.floor(selectAreaCenter[4]/2)>$('#samo-'+type+'-edtor .container .area-select').height()){y=$('#samo-'+type+'-edtor .container .area-select').height()-Math.ceil(selectAreaCenter[4]/2);}
if(x-Math.floor(selectAreaCenter[3]/2)<0){x=Math.floor(selectAreaCenter[3]/2);}
if(x+Math.floor(selectAreaCenter[3]/2)>$('#samo-'+type+'-edtor .container .area-select').width()){x=$('#samo-'+type+'-edtor .container .area-select').width()-Math.ceil(selectAreaCenter[3]/2);}
var $a_select=$('#samo-'+type+'-edtor .container .area-select');getImgAreaSelect($a_select,{classPrefix:'imgarea-'+type+' imgareaselect',x1:Math.min($a_select.width(),x-Math.ceil(selectAreaCenter[3]/2)),y1:Math.min($a_select.height(),y-Math.ceil(selectAreaCenter[4]/2)),x2:Math.min($a_select.width(),x+Math.floor(selectAreaCenter[3]/2)),y2:Math.min($a_select.height(),y+Math.floor(selectAreaCenter[4]/2)),minHeight:h_min,minWidth:w_min,persistent:true,aspectRatio:tmp,handles:true});$('#samo-'+type+'-edtor .rotate_angle input').data('prev',getAngle($('#samo-'+type+'-edtor .rotate_angle input').val()));}
var disableSelection=function(obj){$(obj).each(function(){this.onselectstart=function(){return false;};this.unselectable="on";$(this).css('-moz-user-select','none');});}
var enableSelection=function(obj){$(obj).each(function(){this.onselectstart=function(){};this.unselectable="off";$(this).css('-moz-user-select','auto');});}
var moveRotate=function(){setRotate(parseInt(rotateValue+360/100*(samo.anketa.pageY-pageY)*100/blockHeight));if($(img).hasClass('hand')){setTimeout(moveRotate,100);}}
var getAngle=function(angle){if(Math.abs(angle)>359){angle=angle%360;}
if(angle<0){angle=Math.abs(360+angle);}
return angle;}
var setRotate=function(angle){if(!$('#samo-'+type+'-edtor .container .area-select').hasClass('shifted')){getSelectAreaCenter();$('#samo-'+type+'-edtor .container .area-select').addClass('shifted');$('#samo-'+type+'-edtor .container .area-select').imgAreaSelect({remove:true});}
var finish=function(){setAreaSelect();$('#samo-'+type+'-edtor .container .area-select').removeClass('shifted');};if(angle===false){angle=0;finish();}else{if(rotateNoMargin){$(img).parent().rotate(angle);setTimeout(function(){finish();},100);}else{$(img).parent().rotate({animateTo:angle,callback:finish});}}
$(img).data('angle',angle);$(panel).find('input').val(getAngle(angle));}
var getAreaSelectSize=function(width,height,angle){if(width==null){width=parseFloat($('#samo-'+type+'-edtor .container img').data('width'));}
if(height==null){height=parseFloat($('#samo-'+type+'-edtor .container img').data('height'));}
if(angle==null){angle=parseInt($('#samo-'+type+'-edtor .rotate_angle input').val());}
var horizontal=(Math.ceil(angle/90)%2)?true:false;if(angle%90==0?!horizontal:horizontal){w=Math.round(Math.cos((angle%90)*Math.PI/180)*width+Math.cos((90-angle%90)*Math.PI/180)*height);h=Math.round(Math.sin((angle%90)*Math.PI/180)*width+Math.sin((90-angle%90)*Math.PI/180)*height);}else{w=Math.round(Math.sin((angle%90)*Math.PI/180)*width+Math.sin((90-angle%90)*Math.PI/180)*height);h=Math.round(Math.cos((angle%90)*Math.PI/180)*width+Math.cos((90-angle%90)*Math.PI/180)*height);}
return[w,h];}
$('.rotate_left, .rotate_right',panel).click(function(){var angle=parseInt($(img).data('angle'));if($(this).hasClass('rotate_left')){angle=(angle==undefined?0:angle)-90;}else{angle=(angle==undefined?0:angle)+90;}
setRotate(angle);});$(ctrlRotate).mousedown(function(){samo.anketa.hasMousedown=true;disableSelection('body *');$('body').css({cursor:'n-resize'});$(img).addClass('hand');pageX=samo.anketa.pageX;pageY=samo.anketa.pageY;rotateValue=parseInt($(img).data('angle'));if(isNaN(rotateValue)){rotateValue=0;}
getSelectAreaCenter();setTimeout(moveRotate,100);});$(panel).find('input').change(function(){var value=parseInt($(this).val());rotateValue=getAngle(parseInt($(img).data('angle')));if(Math.abs(rotateValue-value)>180){if(rotateValue>value){$(img).data('angle',rotateValue-360+value);}else{value=rotateValue-360+value;}}
setRotate(value);});$(ctrlZoomIn).click(function(){if(!$(img).hasClass('hand')){$(img).addClass('hand');var area=$('#samo-'+type+'-edtor .area-select').imgAreaSelect({instance:true});var x1=area.getSelection().x1;var x2=area.getSelection().x2;var y1=area.getSelection().y1;var y2=area.getSelection().y2;var width=x2-x1;var height=y2-y1;zoom=Math.min(1.5,containerSize*0.95/height);if(zoom>1.1){ctrlZoomFn(parseFloat($('#samo-'+type+'-edtor').data('zoom'))*zoom);}}});$(ctrlZoomOut).click(function(){zoom=Math.max(1,parseFloat($('#samo-'+type+'-edtor').data('zoom'))/1.5);if(zoom!=parseFloat($('#samo-'+type+'-edtor').data('zoom'))){ctrlZoomFn(zoom);}});if(samo.anketa.bindMouse==undefined){samo.anketa.bindMouse=true;samo.anketa.pageX=0;samo.anketa.pageY=0;$(document).mouseup(function(e){if(samo.anketa.hasMousedown){if($(img).hasClass('hand')){$(img).removeClass('hand')}
enableSelection('body *');$('body').css({cursor:''});samo.anketa.hasMousedown=false;}});$(document).mousemove(function(e){samo.anketa.pageX=e.pageX;samo.anketa.pageY=e.pageY;});}
setRotate(false);};samo.samo=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','samo');};samo.spain_mow=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','spain_mow');function WhoIsPayingChange(){var ms=$('#WhoIsPaying').val();var dis=true;if(ms==1){dis=false;}
$('#WhoIsPayingOther').attr('disabled',dis);};$('#WhoIsPaying').bind('change',WhoIsPayingChange);WhoIsPayingChange();};samo.greece_mow=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','greece_mow');function WhoPayingChange(){var ms=$('#WhoPaying').val();var dis=true;if(ms==1){dis=false;}
$('#eWhoPaying').attr('disabled',dis);};function PreviousShengenChange(){var ms=$('#PreviousShengen').val();ms=$.trim(ms).toUpperCase();$('#Entries').find('option').remove();if(ms!='NO'&&ms!=''){$('#Entries').append('<option value="2">'+$('#PreviousShengen').attr('multivisa')+'</option>');}else{$('#Entries').append('<option value="0">'+$('#PreviousShengen').attr('onevisa')+'</option>');}};$('#WhoPaying').bind('change',WhoPayingChange);$('#PreviousShengen').bind('change',PreviousShengenChange);WhoPayingChange();PreviousShengenChange();};samo.uae_mow=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','uae_mow');};samo.india_mow_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','india_mow_v1');};samo.spain_mow_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','spain_mow_v1');function WhoIsPayingChange(){var ms=$('[name*="[WhoIsPaying]"]').val();var dis=true;if(ms==1){dis=false;}
$('[name*="[WhoIsPayingOther]"]').attr('disabled',dis);};function PreviousShengenChange(){var ms=$.trim($('[name*="[PreviousShengen]"]').val()).toUpperCase();if(ms==''){ms='NO';}
$('[name*="[PreviousShengen]"]').val(ms);};function OccupationIndexChange(){var ms=$('[name*="[OccupationIndex]"]').val();if(ms==34||ms==18||ms==39){$('[name*="[EmployerName]"],[name*="[EmployerAddress]"],[name*="[EmployerPhone]"]').removeClass('required').closest('tr').find('label').removeClass('required');}else{$('[name*="[EmployerName]"],[name*="[EmployerAddress]"],[name*="[EmployerPhone]"]').addClass('required').closest('tr').find('label').addClass('required');}};function BirthSurName_changeChange(){var el=$('[name*="[BirthSurName]"]');if($(this).val()=='True'){$(el).css('display','block').addClass('required').closest('tr').find('label').addClass('required').css('display','block');}else{$(el).val('').css('display','none').removeClass('required').closest('tr').find('label').removeClass('required').css('display','none');}};$('[name*="[WhoIsPaying]"]').bind('change',WhoIsPayingChange).triggerHandler('change');$('[name*="[PreviousShengen]"]').bind('change',PreviousShengenChange).triggerHandler('change');$('[name*="[OccupationIndex]"]').bind('change',OccupationIndexChange).triggerHandler('change');$('[name*="[BirthSurName_change]"]').bind('change',BirthSurName_changeChange);$('[name*="[BirthSurName_change]"]:checked').triggerHandler('change');};samo.malta_mow_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','malta_mow_v1');function WhoIsPayingChange(){var ms=$('[name*="[WhoIsPaying]"]').val();var dis=true;if(ms==1){dis=false;}
$('[name*="[WhoIsPayingOther]"]').attr('disabled',dis);};function PreviousShengenChange(){var ms=$.trim($('[name*="[PreviousShengen]"]').val()).toUpperCase();if(ms==''){ms='NO';}
$('[name*="[PreviousShengen]"]').val(ms);};function OccupationIndexChange(){var ms=$('[name*="[OccupationIndex]"]').val();if(ms==34||ms==18||ms==39){$('[name*="[EmployerName]"],[name*="[EmployerAddress]"],[name*="[EmployerPhone]"]').removeClass('required').closest('tr').find('label').removeClass('required');}else{$('[name*="[EmployerName]"],[name*="[EmployerAddress]"],[name*="[EmployerPhone]"]').addClass('required').closest('tr').find('label').addClass('required');}};function BirthSurName_changeChange(){var el=$('[name*="[BirthSurName]"]');if($(this).val()=='True'){$(el).css('display','block').addClass('required').closest('tr').find('label').addClass('required').css('display','block');}else{$(el).val('').css('display','none').removeClass('required').closest('tr').find('label').removeClass('required').css('display','none');}};$('[name*="[WhoIsPaying]"]').bind('change',WhoIsPayingChange).triggerHandler('change');$('[name*="[PreviousShengen]"]').bind('change',PreviousShengenChange).triggerHandler('change');$('[name*="[OccupationIndex]"]').bind('change',OccupationIndexChange).triggerHandler('change');$('[name*="[BirthSurName_change]"]').bind('change',BirthSurName_changeChange);$('[name*="[BirthSurName_change]"]:checked').triggerHandler('change');};samo.china_mow_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','china_mow_v1');function OccupationIndexChange(){var ms=parseInt($('[name*="[OccupationIndex]"]').val());if(ms==7||ms==8){$('[name*="[EmployerName]"],[name*="[EmployerAddress]"],[name*="[EmployerPhone]"],[name*="[EmployerAddresscode]"]').removeClass('required').closest('tr').find('label').removeClass('required');}else{$('[name*="[EmployerName]"],[name*="[EmployerAddress]"],[name*="[EmployerPhone]"],[name*="[EmployerAddresscode]"]').addClass('required').closest('tr').find('label').addClass('required');}
if($.inArray(ms,[9,10,11,15])<0){$('[name*="[Post]"]').removeClass('required').closest('tr').find('label').removeClass('required');}else{$('[name*="[Post]"]').addClass('required').closest('tr').find('label').addClass('required');}};$('[name*="[OccupationIndex]"]').bind('change',OccupationIndexChange).triggerHandler('change');};samo.uae_mow_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','uae_mow_v1');};samo.cyprus_mow_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','cyprus_mow_v1');};samo.spain_ua_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','spain_ua_v1');};samo.andorra_ua_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','andorra_ua_v1');};samo.cyprus_ua_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','cyprus_ua_v1');};samo.uae_ua_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','uae_ua_v1');};samo.india_ua_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','india_ua_v1');};samo.greece_ua_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','greece_ua_v1');};samo.morocco_ua_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','morocco_ua_v1');};samo.italy_mow_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','italy_mow_v1');function WhoIsPayingChange(){var ms=$('[name*="[WhoIsPaying]"]').val();var dis=true;if(ms==1){dis=false;}
$('[name*="[WhoIsPayingOther]"]').attr('disabled',dis);};function OccupationIndexChange(){var ms=$('[name*="[OccupationIndex]"]').val();if(ms==34||ms==18){$('[name*="[EmployerName]"],[name*="[EmployerAddress]"],[name*="[EmployerPhone]"]').removeClass('required').closest('tr').find('label').removeClass('required');}else{$('[name*="[EmployerName]"],[name*="[EmployerAddress]"],[name*="[EmployerPhone]"]').addClass('required').closest('tr').find('label').addClass('required');}};$('[name*="[WhoIsPaying]"]').bind('change',WhoIsPayingChange).triggerHandler('change');$('[name*="[OccupationIndex]"]').bind('change',OccupationIndexChange).triggerHandler('change');};samo.bulgaria_mow_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','bulgaria_mow_v1');var ms=$.trim($('[name*="[PreviousShengen]"]').val()).toUpperCase();function OccupationBlur(){var val_EmployerName=$('[name*="[EmployerName]"]').val();var val_Employer_town=$('[name*="[Employer_town]"]').val();var val_EmployerAddress=$('[name*="[EmployerAddress]"]').val();var val_Occupation=$.trim($('[name*="[Occupation]"]').val()).toUpperCase();if(val_Occupation==samo.i18n('ANKETA_OCCUPATION_UNEMPLOYED')){val_EmployerName=samo.i18n('ANKETA_NO');val_Employer_town=samo.i18n('ANKETA_NO');val_EmployerAddress=samo.i18n('ANKETA_NO');}else{val_EmployerName=(val_EmployerName==samo.i18n('ANKETA_NO')?'':val_EmployerName);val_Employer_town=(val_Employer_town==samo.i18n('ANKETA_NO')?'':val_Employer_town);val_EmployerAddress=(val_EmployerAddress==samo.i18n('ANKETA_NO')?'':val_EmployerAddress);}
$('[name*="[EmployerName]"]').val(val_EmployerName);$('[name*="[Employer_town]"]').val(val_Employer_town);$('[name*="[EmployerAddress]"]').val(val_EmployerAddress);};function WhoIsPayingChange(){var ms=$('[name*="[WhoIsPaying]"]').val();var dis=true;$('[name*="[WhoIsPayingOther]"]').removeClass('required');if(ms==1){dis=false;$('[name*="[WhoIsPayingOther]"]').addClass('required');}
$('[name*="[WhoIsPayingOther]"]').attr('disabled',dis);};$('[name*="[WhoIsPaying]"]').bind('change',WhoIsPayingChange).triggerHandler('change');$('[name*="[Occupation]"]').bind('blur',OccupationBlur).triggerHandler('blur');};samo.greece_mow_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','greece_mow_v1');function WhoPayingChange(){var ms=$('[name*="[WhoPaying]"]').val();var dis=true;if(ms==1){dis=false;}
$('[name*="[eWhoPaying]"]').attr('disabled',dis);};function OccupationIndexChange(){var ms=$('[name*="[OccupationIndex]"]').val();if(ms==28||ms==26){$('[name*="[EmployerName]"],[name*="[EmployerAddress]"],[name*="[EmployerPhone]"],[name*="[Post]"]').removeClass('required').closest('tr').find('label').removeClass('required');}else{$('[name*="[EmployerName]"],[name*="[EmployerAddress]"],[name*="[EmployerPhone]"],[name*="[Post]"]').addClass('required').closest('tr').find('label').addClass('required');}};$('[name*="[WhoPaying]"]').bind('change',WhoPayingChange).triggerHandler('change');$('[name*="[OccupationIndex]"]').bind('change',OccupationIndexChange).triggerHandler('change');};samo.czech_mow_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','czech_mow_v1');function OccupationIndexChange(){var ms=$('[name*="[OccupationIndex]"]').val();if(ms==34||ms==18){$('[name*="[EmployerName]"],[name*="[EmployerAddress]"],[name*="[EmployerPhone]"],[name*="[Post]"]').removeClass('required').closest('tr').find('label').removeClass('required');}else{$('[name*="[EmployerName]"],[name*="[EmployerAddress]"],[name*="[EmployerPhone]"],[name*="[Post]"]').addClass('required').closest('tr').find('label').addClass('required');}};$('[name*="[OccupationIndex]"]').bind('change',OccupationIndexChange).triggerHandler('change');};samo.france_mow_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','france_mow_v1');function WhoIsPayingChange(){var ms=$('[name*="[WhoIsPaying]"]').val();var dis=true;if(ms==1){dis=false;}
$('[name*="[WhoIsPayingOther]"]').attr('disabled',dis);};function PreviousShengenChange(){var ms=$.trim($('[name*="[PreviousShengen]"]').val()).toUpperCase();if(ms==''){ms='NO';}
$('[name*="[PreviousShengen]"]').val(ms);};function OccupationIndexChange(){var ms=$('[name*="[OccupationIndex]"]').val();if(ms==34||ms==18||ms==39){$('[name*="[EmployerName]"],[name*="[EmployerAddress]"],[name*="[EmployerPhone]"]').removeClass('required').closest('tr').find('label').removeClass('required');}else{$('[name*="[EmployerName]"],[name*="[EmployerAddress]"],[name*="[EmployerPhone]"]').addClass('required').closest('tr').find('label').addClass('required');}};function BirthSurName_changeChange(){var el=$('[name*="[BirthSurName]"]');if($(this).val()=='True'){$(el).css('display','block').addClass('required').closest('tr').find('label').addClass('required').css('display','block');}else{$(el).val('').css('display','none').removeClass('required').closest('tr').find('label').removeClass('required').css('display','none');}};$('[name*="[WhoIsPaying]"]').bind('change',WhoIsPayingChange).triggerHandler('change');$('[name*="[PreviousShengen]"]').bind('change',PreviousShengenChange).triggerHandler('change');$('[name*="[OccupationIndex]"]').bind('change',OccupationIndexChange).triggerHandler('change');$('[name="[BirthSurName_change]"]').bind('change',BirthSurName_changeChange);$('[name*="[BirthSurName_change]"]:checked').triggerHandler('change');};samo.austria_mow_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','austria_mow_v1');};samo.croatia_mow_v1=function(){var $module_container=$('#anketa');samo.anketa();$module_container.data('anketa','croatia_mow_v1');function WhoIsPayingChange(){var ms=$('[name*="[WhoIsPaying]"]').val();var dis=true;if(ms==1){dis=false;}
$('[name*="[WhoIsPayingOther]"]').attr('disabled',dis);};function OccupationIndexChange(){var ms=$('[name*="[OccupationIndex]"]').val();if(ms==7||ms==43||ms==29){$('[name*="[EmployerName]"],[name*="[EmployerAddress]"],[name*="[EmployerPhone]"]').removeClass('required').closest('tr').find('label').removeClass('required');}else{$('[name*="[EmployerName]"],[name*="[EmployerAddress]"],[name*="[EmployerPhone]"]').addClass('required').closest('tr').find('label').addClass('required');}};function BirthSurName_changeChange(){var el=$('[name*="[BirthSurName]"]');if($(this).val()=='True'){$(el).css('display','block').addClass('required').closest('tr').find('label').addClass('required').css('display','block');}else{$(el).val('').css('display','none').removeClass('required').closest('tr').find('label').removeClass('required').css('display','none');}};$('[name*="[WhoIsPaying]"]').bind('change',WhoIsPayingChange).triggerHandler('change');$('[name*="[OccupationIndex]"]').bind('change',OccupationIndexChange).triggerHandler('change');$('[name*="[BirthSurName_change]"]').bind('change',BirthSurName_changeChange);$('[name*="[BirthSurName_change]"]:checked').triggerHandler('change');};})(samo.jQuery);