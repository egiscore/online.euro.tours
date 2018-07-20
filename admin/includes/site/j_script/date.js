// ****** Функции работы с датами ********
function ChD(el){    
    d = ChDate(el.value)?ChDate(el.value):(null);
    el.value = ff('dd/mm/yyyy', d)
}

function addZerro(value){
    return (value<10?'0':'')+value;
}

function ff(format, date){

    if (!date){
        return "";
    }else{
        if (format == ''){
            format = 'dd/mm/yyyy';
        }
        if (date == ''){
            return "";
        }
        var Day=this.addZerro(date.getDate());
        var Month=this.addZerro(date.getMonth()+1);
        var Year=date.getFullYear();
        var shortYear=date.getYear();
        if (shortYear>=2000) { shortYear-=2000; } // перегибы на местах
        shortYear=this.addZerro(shortYear);

        if (format=='dd-mm-yy') { return Day+'-'+Month+'-'+shortYear; }
        else if (format=='dd/mm/yyyy') { return Day+'/'+Month+'/'+Year; }
        else if (format=='dd.mm.yy') { return Day+'.'+Month+'.'+shortYear; }
        else if (format=='yyyy-mm-dd') { return Year+'-'+Month+'-'+Day; }
        else if (format=='yyyy.mm.dd') { return Year+'.'+Month+'.'+Day; }
        else if (format=='dd.mm.yyyy') { return Day+'.'+Month+'.'+Year; }
        else if (format=='yyyymmdd') { return Year+Month+Day; }
        else { return Day+'-'+Month+'-'+Year; }
    }
}

function ChDate(Str){
    if (Str){
        var RegYMDHIS = /^(\d{4})[-|.|\/](\d+)[-|.|\/](\d+)\s+(\d+):(\d+):(\d+)$/i; // yyyy-mm-dd hh:ii:ss
        var RegDMYHIS = /^(\d+)[-|.|\/](\d+)[-|.|\/](\d{4})\s+(\d+):(\d+):(\d+)$/i; // dd-mm-yyyy hh:ii:ss
        var RegYMD = /^(\d{4})[-|.|\/](\d+)[-|.|\/](\d+)$/i; // yyyy-mm-dd
        var RegDMY = /^(\d+)[-|.|\/](\d+)[-|.|\/](\d{4})$/i; // dd-mm-yyyy
        var RegDMY2 = /^(\d+)[-|.|\/](\d+)[-|.|\/](\d{2})$/i; // dd-mm-yy
        var RegYMD2 = /^(\d{4})(\d{2})(\d{2})$/i; // yyyymmdd
        var RegYMD3 = /^(\d{4})(\d{2})(\d{3})$/i; // yyyymmddd

        var date = RegYMDHIS.exec(Str);
        if (date) { return (new Date(date[1],date[2]-1,date[3],date[4],date[5],date[6])); }
        
        var date = RegDMYHIS.exec(Str);
        if (date) { return (new Date(date[3],date[2]-1,date[1],date[4],date[5],date[6])); }
        
        var date = RegYMD.exec(Str);
        if (date) { return (new Date(date[1],date[2]-1,date[3])); }
        
        var date = RegDMY.exec(Str);
        if (date) { return (new Date(date[3],date[2]-1,date[1])); }
        
        var date = RegDMY2.exec(Str);
        if (date){
            Year=Number(date[3]);
            if (Year<10){
                Year+=2000;
            }else{
                Year+=1900;
            }
            return (new Date(Year, (date[2]-1), date[1]));
        }
        var date = RegYMD2.exec(Str);
        if (date) { return (new Date(date[1],date[2]-1,date[3])); }
        
        var date = RegYMD3.exec(Str);
        if (date) { return (new Date(date[1],date[2]-1,date[3])); }
    }
    return null;
}

function ValidBetween(d,syear,eyear){
    if (!d){
        return null;
    }
    if (d == '') {
        return '';
    }
    if (syear == "") {
        syear = 1900;
    }
    if (eyear == "") {
        eyear = 2078;
    }
    var Year=d.getFullYear();
    if ((Year < syear) || (Year > eyear)) {
        return null;
    }
    return d;
}

function YYYYMMDD_to_DD_MM_YYYY(d){
        return (d.substring(6, 8) + '/' + d.substring(4, 6) + '/' + d.substring(0, 4));
}
function DD_MM_YYYY_to_YYYYMMDD(str){
        return (str.substring(6, 10) + str.substring(3, 5) + str.substring(0, 2));
}
function daysBetween(date1, date2){
    var DSTAjust = 0;
    oneMinute = 1000 * 60;
    var oneDay = oneMinute * 60 * 24;
    date1.setHours(0);
    date1.setMinutes(0);
    date1.setSeconds(0);
    date2.setHours(0);
    date2.setMinutes(0);
    date2.setSeconds(0);
    
    if (date2 > date1){
        DSTAdjust = (date2.getTimezoneOffset() - date1.getTimezoneOffset()) * oneMinute;
    }else{
        DSTAdjust = (date1.getTimezoneOffset() - date2.getTimezoneOffset()) * oneMinute;
    }
    var diff = Math.abs(date2.getTime() - date1.getTime()) - DSTAdjust;
    return Math.ceil(diff / oneDay)
}