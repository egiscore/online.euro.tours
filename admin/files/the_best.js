(function($) {
    $('#TOWNFROMINC').bind('change',function(){
        window.location.href = '?page=' + samo.admin_page + ' &LNG=' + samo.admin_lng + '&action=step1&TOWNFROMINC=' + this.value;
    });
    $('#STATEINC').bind('change',function(){
        var townfrom = $('#TOWNFROMINC').val();
        window.location.href = '?page=' + samo.admin_page + ' &LNG=' + samo.admin_lng + '&action=step1&TOWNFROMINC=' + townfrom + '&STATEINC=' + this.value;
    });
    $('#TOURINC').bind('change',function(){
        var townfrom = $('#TOWNFROMINC').val();
        var state = $('#STATEINC').val();
        window.location.href = '?page=' + samo.admin_page + ' &LNG=' + samo.admin_lng + '&action=step1&TOWNFROMINC=' + townfrom + '&STATEINC=' + state + '&TOURINC=' + this.value;
    });
    $('#step2,#step3,#step4,#create').bind('click',function(){
        if(this.id == 'step3'){
            var min = parseInt($('#MINDAYSBEFORE').val()) || 0, max = parseInt($('#MAXDAYSBEFORE').val()) || 0;
            if(max > 0 && max < min){
                alert('Значение "до вылета не менее" превышает значение "до вылета не более".'); //@fixme
                return false;
            }
        }
        $.post('?page=' + samo.admin_page + '&LNG=' + samo.admin_lng + '&action=' + this.id,getParams(),null,'script');
    });
    function getParams() {
        var $params = {};
        $('#TOWNFROMINC,#STATEINC,#NIGHTS_FROM,#NIGHTS_TILL,#TOURINC,#PROGRAMINC').each(function(){
            $params[this.id] = this.value;
        });
        $params['PACKET'] = $.radioValue('PACKET') || 0;
        if ($('#step2_container').is(':visible')) {
            $params.FRPLACE = $('#FRPLACE').is(':checked') ? 1 : 0;
            $('.date, .daysbefore').each(function(){
                $params[this.id] = $.controlValue(this);
            });
        }
        if ($('#step3_container').is(':visible')) {
            $('#step3_container select').each(function(){
                $params[this.id] = this.value;
            });
        }
        if ($('#step4_container').is(':visible')) {
            if ($('#TOWNTO_ANY').is(':checked')) {
                $params.TOWNS = 0;
            } else {
                var towns = [], _towns = $('#TOWNTO input:checked');
                if (!_towns.length) {
                    _towns = $('#TOWNTO input');
                }
                $(_towns).each(function (){
                    towns.push (this.value);
                });
                $params.TOWNS = towns.join(',');
            }
            if ($('#STARS_ANY').is(':checked')) {
                $params.STARS = 0;
            } else {
                var stars = [], _stars = $('#STARS input:checked');
                if (!_stars.length) {
                    _stars = $('#STARS input');
                }
                $(_stars).each(function (){
                    stars.push (this.value);
                });
                $params.STARS = stars.join(',');
            }
            if ($('#VIPTYPE_ANY').is(':checked')) {
                $params.VIPTYPES = 0;
            } else {
                var viptypes = [], _viptypes = $('#VIPTYPE input:checked');
                if (!_viptypes.length) {
                    _viptypes = $('#VIPTYPE input');
                }
                $(_viptypes).each(function (){
                    viptypes.push (this.value);
                });
                $params.VIPTYPES = viptypes.join(',');
            }
            if ($('#STARS_ANY').is(':checked') && $('#HOTELS_ANY').is(':checked') && $('#TOWNTO_ANY').is(':checked') && $('#VIPTYPE_ANY').is(':checked')) {
                $params.HOTELS = 0;
            } else {
                var hotels = [], _hotels = $('#HOTELS input:checked');
                if (!_hotels.length) {
                    $params.HOTELS = 0;
                }else{
                    $(_hotels).each(function (){
                        hotels.push (this.value);
                    });
                    $params.HOTELS = hotels.join(',');
                }
            }
            $params.LIMIT = $('#LIMIT').val();
            if ($('#MEALS_ANY').is(':checked')) {
                $params.MEALS = 0;
            } else {
                var meals = [], _meals = $('#MEALS input:checked');
                if (!_meals.length) {
                    _meals = $('#MEALS input');
                }
                $(_meals).each(function (){
                    meals.push (this.value);
                });
                $params.MEALS = meals.join(',');
            }
        }
        return $params;
    }
    function filter_hotels() {
        var gs = [],towns = [],viptypes = [], all_stars = $('#STARS_ANY').is(':checked'), all_towns = $('#TOWNTO_ANY').is(':checked'), all_viptype = $('#VIPTYPE_ANY').is(':checked');
        $('#STARS input:checked').each(function(){
            gs.push(parseInt(this.value)); 
        });
        
        $('#TOWNTO input:checked').each(function(){
            towns.push(parseInt(this.value));
        });
        $('#VIPTYPE input:checked').each(function(){
            viptypes.push(parseInt(this.value));
        });
        if (gs.length || towns.length || viptypes.length) {
            $('#HOTELS input').each(function(){
                var $hotel = $(this);
                var f_viptype = all_viptype;
                if(!f_viptype){
                    var arr = String($hotel.data('viptype')).split(',');
                    for(var i = 0; i < arr.length; i++) {
                        var hotel_type = parseInt(arr[i]);
                        if($.inArray(hotel_type,viptypes) != -1){
                            f_viptype = true;
                            break;
                        }
                    }
                }
                if (
                    (all_stars || $.inArray($hotel.data('group-star'),gs) != -1)
                    && (f_viptype)
                    && (all_towns || $.inArray($hotel.data('town'),towns) != -1)
                ) {
                    $(this).parent().css('display','block');
                } else {
                    $(this).attr('checked',false).parent().css('display','none');
                }
            });
        } else {
            $('#STARS_ANY').attr('checked',true);
            $('#VIPTYPE_ANY').attr('checked',true);
            $('#TOWNTO_ANY').attr('checked',true);
            $('#HOTELS label:hidden').css('display','block');
        }
    }

    samo.jQuery('.date').datePicker({direction: true});

    $('#HOTELS').delegate('input','click',function(){
    	$('#HOTELS_ANY').attr('checked', !($('#HOTELS input:checked').length > 0));
     });
    $('#TOWNTO').delegate('input','click',function(){
    	$('#TOWNTO_ANY').attr('checked', !($('#TOWNTO input:checked').length > 0));
        filter_hotels();
     });
    $('#STARS').delegate('input','click',function(){
        $('#STARS_ANY').attr('checked', !($('#STARS input:checked').length > 0));
        filter_hotels();
    });
    $('#MEALS').delegate('input','click',function(){
        $('#MEALS_ANY').attr('checked', !($('#MEALS input:checked').length > 0));
    });
    $('#VIPTYPE').delegate('input','click',function(){
        $('#VIPTYPE_ANY').attr('checked', !($('#VIPTYPE input:checked').length > 0));
        filter_hotels();
    });
    $('#STARS_ANY').bind('click',function(){
      if (this.checked) {
        $('#STARS input:checked').attr('checked',false);
      } else {
        this.checked = true;
      }
      filter_hotels();
    });
    $('#VIPTYPE_ANY').bind('click',function(){
      if (this.checked) {
        $('#VIPTYPE input:checked').attr('checked',false);
      } else {
        this.checked = true;
      }
      filter_hotels();
    });
    $('#TOWNTO_ANY').bind('click',function(){
        if (this.checked) {
          $('#TOWNTO input:checked').attr('checked',false);
        } else {
          this.checked = true;
        }
        filter_hotels();
    });
    $('#HOTELS_ANY').bind('click',function(){
        if (this.checked) {
          $('#HOTELS input:checked').attr('checked',false);
        } else {
          this.checked = true;
        }
        filter_hotels();
    });
})(samo.jQuery);