// *********************************** Calendar ***********************************
// путь к картинкам
var imagesFolder = 'files/img/';

// язык интерфейса
var tasksLanguage = 'ru'
var txtHideCalendar = 'Скрыть календарь';
var txtShowCalendar = 'Показать календарь';


// имена месяцев и т.п.
var calendarNamesHash = new Array();
calendarNamesHash.ru = new Array();
calendarNamesHash.en = new Array();
calendarNamesHash.ru.month = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
calendarNamesHash.ru.monthShort = ['янв', 'фев', 'мар', 'апр', 'мая', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'];
calendarNamesHash.ru.weekday = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
calendarNamesHash.ru.today= 'сегодня';

calendarNamesHash.en.month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
calendarNamesHash.en.monthShort = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
calendarNamesHash.en.weekday = ['M', 'T', 'W', 'T', 'F', 'S', 'S'];
calendarNamesHash.en.today= 'today';
var calendarNames = calendarNamesHash[tasksLanguage=='en'?'en':'ru'];



// интерфейсные функции
var closeCalendarTimeOut = 0;
var activeCalendarName = '';

// получить текущую дату календаря
function getCalendarDate(name) {
    if (!LSCalendars[name].GetDate()) { return (new Date()); }
    else { return LSCalendars[name].GetDate(); }
}

// мы нажали какой то день в таблице календаря
function ClickDate(dayToSet, monthToSet, yearToSet)
{
	// устанавливаем дату в поле input для текущего календаря
	LSCalendars[activeCalendarName].SetDateSet(dayToSet, monthToSet, yearToSet);

	if (LSCalendars[activeCalendarName].OnChange != ''){
        str = LSCalendars[activeCalendarName].OnChange + '(document.getElementById("' + LSCalendars[activeCalendarName].name + '"));';
        eval(str);
    }
	// закрываем календарь
    hideCalendar();
	return;
}
/*
// переопределить дату календаря и на выводе
function setDateForCalendar(dayToSet, monthToSet, yearToSet)
{
		// что бы сохранить минуты, мы делаем так
    if (!LSCalendars[activeCalendarName].GetDate())
			var dateToSet = new Date();
    else
			var dateToSet = LSCalendars[activeCalendarName].GetDate();

    dateToSet.setFullYear(yearToSet);
    dateToSet.setMonth(monthToSet,1);
    dateToSet.setDate(dayToSet);

    LSCalendars[activeCalendarName].SetDate(dateToSet);
    setInputByLSCalendar(activeCalendarName);

    // закрываем календарь
    hideCalendar();
}
*/


// переопределить дату календаря из строки
function setCalendarDateByStr(name, strDate)
{
  if (strDate==null || strDate=="")
	{ // если пустая строка
	  LSCalendars[name].SetDate(null);
  } 
  else
	{
	  MyCal=new LSCalendar();
    if (!MyCal.Validate(strDate))
		{
      alert("Неверный формат даты - "+strDate);
			LSCalendars[name].SetDate(null);
      setInputByLSCalendar(name);
      return false;
    }
    else
		{
	    LSCalendars[name].SetDate(strDate);
      setInputByLSCalendar(name);
      return true;
    }
  }
  closeCalendarTimeOut = 0; // важно
}


// синхронизирует текущее значение календаря и форму ввода
function setInputByLSCalendar(name) {
    document.getElementsByName(name)[0].value=LSCalendars[name].GetStrDate('','');
    return true;
}


// задать сегодняшнюю дату для значений календаря
function setTodayFromCalendar() {
    var date=new Date();
    LSCalendars[activeCalendarName].setDateForCalendar(date.getDate(),date.getMonth(),date.getFullYear());
}



// вычислить элементы select и div под слоем и скрыть или показать
function ChangeElVis(MyVisibility) {
    var calLeer = document.getElementById('calendarDiv');
    
    if ((MyVisibility=='hide') || (MyVisibility=='hidden')) { MyVisibility='hidden'; }
    else { MyVisibility='visible'; }
    
    // вычисляем где именно должен быть этот календарь.
    var calPosition = new getElementPosition(calLeer);
    
    CalTop=calPosition.y;
    CalLeft=calPosition.x;
    CalBottom=CalTop+calLeer.clientHeight;
    CalRight=CalLeft+calLeer.clientWidth;


    // select
    for (var i = 0; i < document.getElementsByTagName('select').length; i++) {
        Cu = document.getElementsByTagName('select')[i];
        if (Cu.name == 'calMonth') { continue; } // calMonth - селект выбора месяца в календаре

        // координаты углов объекта
        var CuPosition=new getElementPosition(Cu);
        CuTop=CuPosition.y;
        CuLeft=CuPosition.x;
        CuBottom=CuTop+Cu.clientHeight;
        CuRight=CuLeft+Cu.clientWidth;

        if ((CuLeft<=CalLeft)&&(CuRight>=CalLeft)||
            (CuLeft>=CalLeft)&&(CuRight<=CalRight)||
            (CuLeft<=CalRight)&&(CuRight>=CalRight)) {

            if ((CuTop<=CalTop)&&(CuBottom>=CalTop)||
                (CuTop>=CalTop)&&(CuBottom<=CalBottom)||
                (CuTop<=CalBottom)&&(CuBottom>=CalBottom)) {
                Cu.style.visibility = MyVisibility;
            }
        }
    }


    // iframe
    for (var i=0; i<document.getElementsByTagName('iframe').length; i++) {
        Cu=document.getElementsByTagName('iframe')[i];

        // координаты углов объекта
        var CuPosition=new getElementPosition(Cu);
        CuTop=CuPosition.y;
        CuLeft=CuPosition.x;
        CuBottom=CuTop+Cu.clientHeight;
        CuRight=CuLeft+Cu.clientWidth;

        if ((CuLeft<=CalLeft)&&(CuRight>=CalLeft)||
            (CuLeft>=CalLeft)&&(CuRight<=CalRight)||
            (CuLeft<=CalRight)&&(CuRight>=CalRight)) {

            if ((CuTop<=CalTop)&&(CuBottom>=CalTop)||
                (CuTop>=CalTop)&&(CuBottom<=CalBottom)||
                (CuTop<=CalBottom)&&(CuBottom>=CalBottom)) {
                Cu.style.visibility = MyVisibility;
            }
        }
    }

    return true;
}


function showCalendarForElement(elemName, evt, defaultDate)
{
  var calPtr = document.getElementById(elemName + 'Ptr');
  if (calPtr)
	{
  	// определяем существование слоя календаря
    var calLeer = document.getElementById('calendarDiv');
    if (!calLeer)  // если такого слоя несуществует
		{
	    calLeer = document.createElement('div');  // создаем слой для календаря
      calLeer.id = 'calendarDiv';
      document.getElementsByTagName('body')[0].appendChild(calLeer);  // добавляем слой к документу
    }
     
    // проверяем показан ли слой, если да - скрываем
    if (calLeer.style.visibility=='visible' && activeCalendarName==elemName){
        calLeer.style.visibility = 'hidden';
        ChangeElVis('visible');
    }else{
        activeCalendarName = elemName;
      // скрываем слой
      calLeer.style.visibility = 'hidden';
      // вычисляем где именно должен быть этот календарь.
      var calPosition = new getElementPosition(calPtr);
//alert(calPosition);
			// заполняем нужным кодом...
      // смотрим какая дата нас интересует
      var currDate = getCalendarDate(elemName);
      // дата по умолчанию, применяется если по умолчанию сеголня
      CDate=currDate.getDate()+"-"+currDate.getMonth()+"-"+currDate.getFullYear();
      TDate=(new Date()).getDate()+"-"+(new Date()).getMonth()+"-"+(new Date()).getFullYear();
      if (CDate==TDate)
			{
      	if (typeof(defaultDate)=="object" && defaultDate) { currDate=defaultDate; }
      }
      // собственно вызываем код
      calLeer.innerHTML = calendarHTML(currDate.getMonth(), currDate.getFullYear(), currDate);
      // ставим слой на место
      calLeer.style.left = calPosition.x;
      calLeer.style.top = calPosition.y;
      // показываем календарик
      calLeer.style.visibility = 'visible';
      ChangeElVis('hidden');
      // наконец, прекращаем баблинг (может, кто-то открыл без event'а)
      if (evt)
				evt.cancelBubble = true;
			// и ставим свой обработчик на клик на календаре (чтобы не скрывался)
			addEvent(calLeer, 'click', calendarClick);
			// и на mouseout (чтобы скрывался, но через некоторое время ;-)
			addEvent(calLeer, 'mouseover', calendarMouseOver);
			addEvent(calLeer, 'mouseout', calendarMouseOut);
		}
	}
}


function calendarClick(e) {
    evt = (e)? e : window.event;
    evt.cancelBubble = true;
}


function calendarMouseOver(e) {
    if (closeCalendarTimeOut) {
        clearTimeout(closeCalendarTimeOut);
        closeCalendarTimeOut = 0;
    }
}

function calendarMouseOut(e) {
    if (closeCalendarTimeOut) {
        clearTimeout(closeCalendarTimeOut);
    }
}

function hideCalendar() {
    var calLeer = document.getElementById('calendarDiv');
    if (calLeer) {
        ChangeElVis('show');
        calLeer.style.visibility = 'hidden';
    }
    closeCalendarTimeOut = 0;
}


function switchMonthTo(month, year) {
    var calLeer = document.getElementById('calendarDiv');
    if (calLeer) {
        // заполняем нужным кодом...
        // смотрим какая дата нас интересует
        var currDate = getCalendarDate(activeCalendarName);
        // собственно вызываем код
        calLeer.innerHTML = calendarHTML(month, year, currDate);
    }
}

function calendarHTML(month, year, currDate) {
    // смотрим этот ли месяц показываем
    var isThisMonth = (currDate)? (currDate.getMonth() == month && currDate.getFullYear() == year) : false;

    // генерирует html-код для указанного месяца
    // устанавливаем месяц, который будем рисовать
    var drawMonth = new Date();
    drawMonth.setMonth(month, 1);
    drawMonth.setYear(year);
    drawMonth.setDate(1);
    
    // переменные для кнопок навигации по месяцам/годам
    var thisMonth = drawMonth.getMonth();
    var nextMonth = (thisMonth == 11)? 0 : thisMonth + 1;
    var prevMonth = (thisMonth == 0)? 11 : thisMonth - 1;
    
    var thisYear = drawMonth.getFullYear();
    var nextYear = thisYear + 1;
    var prevYear = thisYear - 1;
    var nextMonthYear = (thisMonth == 11)? thisYear + 1 : thisYear;
    var prevMonthYear = (thisMonth == 0)? thisYear - 1 : thisYear;
    
    var calendarCode = '<table style="background-color: #FFFFFF" border="1" width="150px" cellspacing="0" cellpadding="0"><tr><td>';
		calendarCode += '<table style="background-color: #FFFFFF" border="0" cellspacing="1" width="100%" cellpadding="1">';
    calendarCode += '<tr><td align="left"><img src="' + imagesFolder + 'cal_left.gif" alt="Предыдущий месяц" width="14" height="7" border="0" onClick="switchMonthTo(' + prevMonth + ', ' + prevMonthYear + '); return false;" style="CURSOR: pointer"></td>';
		calendarCode += '<td align="center" class="capt border_dark">' + calendarNames.month[thisMonth] + ', ' + thisYear + '</td>';
		calendarCode += '<td align="right"><img src="' + imagesFolder + 'cal_right.gif" alt="Следующий месяц" width="14" height="7" border="0" onClick="switchMonthTo(' + nextMonth + ', ' + nextMonthYear + '); return false;" style="CURSOR: pointer"></td></tr>';
    calendarCode += '<tr><td class="border_dark" colspan=3>';
		calendarCode += '<table border="0" cellspacing="1" cellpadding="1" width="100%">';
		calendarCode += '<tr>';
    for (var i = 0; i < calendarNames.weekday.length; i++)
		{
    	var styleClass = (i < calendarNames.weekday.length - 2)? 'cal_weekDay border_dark' : 'cal_holyday border_dark';
//    	var styleClass = '';
      calendarCode += '<td class="' + styleClass + '" align="right" width="20px">' + calendarNames.weekday[i] + '</td>';
    }
    calendarCode += '</tr>';
		calendarCode += '<tr>';


    var daysToStart = (drawMonth.getDay() == 0)? 7 : drawMonth.getDay();
    for (var i = 0; i < daysToStart - 1; i++) calendarCode += '<td class="cal_emptytd" height="20px"><br></td>';

		flydate = LSCalendars[activeCalendarName].flydate;
    // числа
    for (var i = 1; i < 33; i++)
		{
      drawMonth.setDate(i);
			// переводим дату в формат ГГГММДД
			datestr = LSCalendars[activeCalendarName].GetStrDate('yyyymmdd', drawMonth);

/*
				if (isThisMonth && i == currDate.getDate())
				{
					var styleClass = ((drawMonth.getDay()==0) || (drawMonth.getDay()==6))? 'cal_seldate' : 'cal_emptytd';
					calendarCode += '<td align="right" class="cal_seldate" height="20px" onMouseOver="this.className = \'overCell\';" onMouseOut="this.className = \'' + styleClass + '\';" onClick="setDateForCalendar(' + i + ', ' + month + ', ' + year + '); return false;" style="CURSOR: pointer">' + i + '</td>'
				}
				else
				{
*/
					if (drawMonth.getMonth() == thisMonth)
					{
						var styleClass = ((drawMonth.getDay()==0) || (drawMonth.getDay()==6))? 'cal_sundaytd' : 'cal_emptytd';
						if (flydate.length > 0)
						{
							for (var k = 0; k < flydate.length; k++) 
							{
								if (datestr == flydate[k])
								{
									styleClass = 'flyday';
									break;
								}
							}
//							calendarCode += '<td class="' + styleClass + '" height="20px" onMouseOver="this.className = \'overCell\';" onMouseOut="this.className = \'' + styleClass + '\';" onClick="setDateForCalendar(' + i + ', ' + month + ', ' + year + '); return false;" style="CURSOR: pointer">' + i + '</td>'
						}

						calendarCode += '<td class="' + styleClass + '" align="right" height="20px" onMouseOver="this.className = \'overCell\';" onMouseOut="this.className = \'' + styleClass + '\';" onClick="ClickDate(' + i + ', ' + month + ', ' + year + '); return false;" style="CURSOR: pointer">' + i + '</td>';
					}
					else
						break;
//	      }
      if (drawMonth.getDay() == 0) calendarCode += '</tr><tr>';
    }
    calendarCode += '</tr>';
		calendarCode += '</table>';
		calendarCode += '</td></tr>';
    calendarCode += '</tr>';
    // ссылка на сегодня
//    calendarCode += '<tr><td colspan="3" class="cal_emptytd" onMouseOver="this.className = \'overCell\';" onMouseOut="this.className = \'cal_emptytd\';" style="padding: 6px; CURSOR: pointer" align="center" onClick="setTodayFromCalendar(); return false;">'+calendarNames.today+'<\/td><\/tr>';
    // конец

		calendarCode += '</table></td></tr></table>';
    return calendarCode;
}

function getElementPosition(elemPtr) {
    var posX = elemPtr.offsetLeft;
    var posY = elemPtr.offsetTop;

//alert(elemPtr.offsetParent);
		while (elemPtr.offsetParent != null)
		{
			elemPtr = elemPtr.offsetParent;
			posX += elemPtr.offsetLeft;
			posY += elemPtr.offsetTop;
    }
    this.x = posX;
    this.y = posY;
    
    return this;
}



function addEvent(Obj, eventType, eventFunc) {
    if (Obj.addEventListener) { Obj.addEventListener(eventType, eventFunc, false); }
    else if (Obj.attachEvent) { Obj.attachEvent('on'+eventType, eventFunc); }
    else {
        // что делать если ни то ни другое не поддерживается
    }
}

addEvent(document, 'click', hideCalendar);
addEvent(window, 'resize', hideCalendar);
// *********************************** Calendar ***********************************


// *********************************** LSCalendar ***********************************
function LSCalendar() {
    this.name='';
    this.date=null;
    this.format='dd/mm/yyyy';
		this.flydate = new Array();              // массив вылетов Array('ггггммдд','ггггммдд');
    
    this.SetDate=_SetDate;
    this.GetDate=_GetDate;
    this.Str2Date=_Str2Date;
    this.zeroFill=_zeroFill;
    this.Validate=_Validate;
    this.SetFormat=_SetFormat;
    this.OnChange = '';

		// Установить дату
    this.SetDateSet=
		function setDateForCalendar(dayToSet, monthToSet, yearToSet)
		{
			activeCalendarName = this.name;
			// что бы сохранить минуты, мы делаем так
			if (!this.GetDate())
				var dateToSet = new Date();
			else
				var dateToSet = this.GetDate();
	
			dateToSet.setFullYear(yearToSet);
			dateToSet.setMonth(monthToSet,1);
			dateToSet.setDate(dayToSet);
	
			this.SetDate(dateToSet);
			setInputByLSCalendar(activeCalendarName);
			
//            if (OnChange != ''){
//alert(this.OnChange.name);
//                this.OnChange();
//            }

		}

		// Получить дату в строковом формате
    this.GetStrDate=
			function(format, date)
			{
				if ((!this.date) && (!date))
				{
					return "";
				}
				else
				{
					if (format == '')
					{
						format = this.format;
					}
					if (date == '')
					{
						date = this.date;
					}
					var Day=this.zeroFill(date.getDate());
					var Month=this.zeroFill(date.getMonth()+1);
					var Year=date.getFullYear();
					var shortYear=date.getYear();
					if (shortYear>=2000) { shortYear-=2000; } // перегибы на местах
					shortYear=this.zeroFill(shortYear);
				
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


		return true;
}



// Date - текст или объект Date
function _SetDate(Date)
{
//alert(Date);
	if (Date==null || Date=="")
	{
		this.date=null;
	}
  else
	if (typeof(Date)=="object")
	{
		this.date=Date;
	}
  else
	{
		this.date=this.Str2Date(Date)?this.Str2Date(Date):(new Date());
	}
  return true;
}



// Получить текущую дату, объект Date
function _GetDate() {
    return this.date;
}


/*
*/
function _zeroFill(value) {
    return (value<10?'0':'')+value;
}

// маленькая хитрая функция, проверки правильности формата даты
function _Validate(Str) {
    return this.Str2Date(Str)?true:false;
}


// Преобразовать строку в объект Date
function _Str2Date(Str) {
    if (Str) {
        var RegYMDHIS = /^(\d{4})[-|.|\/](\d+)[-|.|\/](\d+)\s+(\d+):(\d+):(\d+)$/i; // yyyy-mm-dd hh:ii:ss
        var RegDMYHIS = /^(\d+)[-|.|\/](\d+)[-|.|\/](\d{4})\s+(\d+):(\d+):(\d+)$/i; // dd-mm-yyyy hh:ii:ss
        var RegYMD = /^(\d{4})[-|.|\/](\d+)[-|.|\/](\d+)$/i; // yyyy-mm-dd
        var RegDMY = /^(\d+)[-|.|\/](\d+)[-|.|\/](\d{4})$/i; // dd-mm-yyyy
        var RegDMY2 = /^(\d+)[-|.|\/](\d+)[-|.|\/](\d{2})$/i; // dd-mm-yy
        var RegYMD2 = /^(\d{4})(\d{2})(\d{2})$/i; // yyyymmdd

        var date = RegYMDHIS.exec(Str);
        if (date) { return (new Date(date[1],date[2]-1,date[3],date[4],date[5],date[6])); }

        var date = RegDMYHIS.exec(Str);
        if (date) { return (new Date(date[3],date[2]-1,date[1],date[4],date[5],date[6])); }

        var date = RegYMD.exec(Str);
        if (date) { return (new Date(date[1],date[2]-1,date[3])); }

        var date = RegDMY.exec(Str);
        if (date) { return (new Date(date[3],date[2]-1,date[1])); }

        var date = RegDMY2.exec(Str);
        if (date) {
            Year=Number(date[3]);
            if (Year<10) { Year+=2000; }
            else { Year+=1900; }
            return (new Date(Year, (date[2]-1), date[1]));
        }
        var date = RegYMD2.exec(Str);
        if (date) { return (new Date(date[1],date[2]-1,date[3])); }
    }
    
    return null;
}



function _SetFormat(Str) {
    if (Str=='dd-mm-yy') { this.format='dd-mm-yy'; }
    else if (Str=='dd.mm.yy') { this.format='dd.mm.yy'; }
    else if (Str=='yyyy-mm-dd') { this.format='yyyy-mm-dd'; }
    else if (Str=='yyyy.mm.dd') { this.format='yyyy.mm.dd'; }
    else if (Str=='dd.mm.yyyy') { this.format='dd.mm.yyyy'; }
    else { this.format='dd-mm-yyyy'; }

    return true;
}
// *********************************** LSCalendar ***********************************

// функция инициализации
//var pixelSpacer = '<div style="width: 1px; height: 1px;"><spacer type="block" width="1" height="1"></div>';
var pixelSpacer = '';

// массив объектов LSCalendar для каждого календаря
var LSCalendars=new Array();

function calendar(name, Date, im_Folder, ShowButton, OnChange)
{
    LSCalendars[name]=new LSCalendar();
    LSCalendars[name].SetDate(Date);
    LSCalendars[name].name = name;
		if (im_Folder != '')
			imagesFolder = im_Folder;
    

    // Вставляет HTML-код с необходимыми полями...
    document.write('<span style"position:absolute;">');
    document.write('<table cellpadding="0" cellspacing="0" border="0"><tr valign="bottom">');
    tmp = '';
    if (OnChange != ''){
        tmp = ' onChange = "' + OnChange + '(this);"';
        LSCalendars[name].OnChange = OnChange;
    }
    document.write('<td><input type="text" class="element" name = "' + name + '" id = "' + name + '" size="12" maxlength=10 value="' + LSCalendars[name].GetStrDate('','') + '" onBlur="setCalendarDateByStr(this.name, this.value);" ' + tmp + '></td>');

		document.write('<td valign="middle">&nbsp;');
		if (ShowButton == true)
			document.write('<input type="button" class="buttom" style="width: 24px; height: 24px; background: url(' + imagesFolder + 'calendar.gif) no-repeat center;" onClick="showCalendarForElement(\'' + name + '\', event); return false;">');
		document.write('</td>');
//    document.write('<td>' + pixelSpacer + '</td>');
    document.write('</tr>');
    

//    document.write('<tr><td colspan="2">' + pixelSpacer + '</td>');
    document.write('<td><span id="' + name + 'Ptr" style="width: 1px; height: 1px; background-color: red;"><spacer type="block" width="1" height="1"></span></td>');
		document.write('</tr>');

		document.write('</table>');
    document.write('</span>');
	return (LSCalendars[name]);
}
