<h3>Памятка по заявке № {$CLAIM} для туристов:</h3>
<br>
{if $Peoples}
    <table class="booklet">
    <thead>
        <tr>
            <th>№</th>
            <th>ФИО</th>
        </tr>
    </thead>
    <tbody>
        <!-- {foreach from = $Peoples item = "people" name="peoples"} -->
            <tr>
                <td>{$smarty.foreach.peoples.iteration}</td>
                <td class="fio">{$people.Name}</td>
<!-- {*                <td class="human">{$people.Human}</td>
                <td class="born">{$people.Born}</td>
                <td class="passport">{$people.PSerie} {$people.PNumber} до {$people.PValid}</td> *} -->
            </tr>
        <!-- {/foreach} -->
    </tbody>
    </table>
<br>{/if}
<p>Пожалуйста, проверьте все документы перед поездкой. Убедитесь, что Ваши паспорта действительны и срок их действия достаточен для поездки в выбранную Вами страну. Мы рекомендуем брать российский паспорт. Будьте очень внимательны, если путешествуете с несовершеннолетними детьми. Если ребенок путешествует с родителями, он может быть вписан в паспорт одного или обоих родителей до достижения 14лет (с 6 лет должна быть вклеена фотография), а также иметь собственный паспорт с любого возраста. Если у ребенка свой паспорт, то нужно обязательно взять с собой его свидетельство о рождении. Если несовершеннолетний путешествует без родителей, то обязательно нужно нотариальное разрешение на вывоз несовершеннолетнего гражданина за границу самостоятельно или с сопровождающим.</p> 
{if $Freights}
<h3>Авиаперелёты</h3>
    <table class="booklet">
    <thead>
        <tr>
            <th>Дата</th>
            <th>Город и аэропорт<br>отправления</th>
            <th>Город и аэропорт<br>прибытия</th>
            <th>Номер рейса</th>
            <th>Время<br>отправления</th>
            <th>Время<br>прибытия</th>
        </tr>
    </thead>
    <tbody>
        <!-- {foreach from = $Freights item = "freight" name="freights"} -->
            <tr>
                <td>{$freight.DateBeg}</td>
                <td>{$freight.TownSrcName} ({$freight.SrcPortAlias})</td>
                <td>{$freight.TownTrgName} ({$freight.TrgPortAlias})</td>
                <td>{$freight.FreightName} ({$freight.TranTypeName})</td>
                <td>{$freight.SrcTime}{if $freight.SrcTimeDelta}<span class="delta">+{$freight.SrcTimeDelta}</span>{/if}</td>
                <td>{$freight.TrgTime}{if $freight.TrgTimeDelta}<span class="delta">+{$freight.TrgTimeDelta}</span>{/if}</td>
            </tr>
        <!-- {/foreach} -->
    </tbody>
    </table>
<br>{/if}
{if $Hotels}
<h3>ОТЕЛИ ПО МАРШРУТУ:</h3>
    <table class="booklet">
    <thead>
        <tr>
            <th>Страна</th>
            <th>Город</th>
            <th>Гостиница</th>
            <th>Номер</th>
            <th>Сроки<br>заезда</th>
            <th>Ночей</th>
            <th><nobr>Пит-е</nobr></th>
            <th>Принимающая<br>компания,<br> тел</th>
        </tr>
    </thead>
    <tbody>
    <!-- {foreach from = $Hotels item = "hotel" name="hotels"} -->
        <tr>
            <td>{$hotel.StateName}</td>
            <td>{$hotel.TownName}</td>
            <td>{$hotel.HotelName}</td>
            <td>{$hotel.RoomName} / {$hotel.HtPlaceName}</td>
            <td>{$hotel.DateBeg}<br>&mdash;<br>{$hotel.DateEnd}</td>
            <td>{$hotel.Nights}</td>
            <td>{$hotel.MealName}</td>
            <td>{$hotel.Partner_partnerlname} {$hotel.Partner_phones}</td>
        </tr>
    <!-- {/foreach} -->
    </tbody>
    </table>
{/if}<br>

{if $Services}
<h3>ДОПОЛНИТЕЛЬНЫЕ УСЛУГИ:</h3>
    <table class="booklet">
    <thead>
        <tr>
            <th>Наименование<br>услуги</th>
            <th>Сроки</th>
            <th>Кол-во<br>услуг</th>
            <th>Услугу<br>осуществляет</th>
            <th>Координаты</th>
        </tr>
    </thead>
    <tbody>
        <!-- {foreach from = $Services item = "service" name="services"} -->
            <tr>
                <td>{$service.ServTypeName}: {$service.ServiceName}</td> 
                <td>{$service.DateBeg} - {$service.DateEnd}</td>
                <td class="o_pcount">{$service.PCount}</td>
                <td>{$service.Partner_partnerlname}</td>
                <td>{$service.Partner_phones}</td>
            </tr>
        <!-- {/foreach} -->
    </tbody>
    </table>
<br>{/if}
{if $Insures}
<h3>Страховки:</h3>
    <table class="booklet">
    <thead>
        <tr>
            <th>Название</th>
            <th>Страна</th>
            <th>Сроки</th>
            <th>Кол-во</th>
        </tr>
    </thead>
    <tbody>
        <!-- {foreach from = $Insures item = "insure" name="insures"} -->
            <tr>
                <td>{$insure.InsureName}</td> 
                <td>{$insure.StateName}</td> 
                <td>{$insure.DateBeg} - {$insure.DateEnd}</td>
                <td class="o_pcount">{$insure.PCount}</td>
            </tr>
        <!-- {/foreach} -->
    </tbody>
    </table>
<br>{/if}
{if $Visas}
<h3>Визы:</h3>
    <table class="booklet">
    <thead>
        <tr>
            <th>Название</th>
            <th>Страна</th>
            <th>Сроки</th>
            <th>Кол-во</th>
        </tr>
    </thead>
    <tbody>
        <!-- {foreach from = $Visas item = "visa" name="visas"} -->
            <tr>
                <td>{$visa.VisaName}</td> 
                <td>{$visa.StateName}</td> 
                <td>{$visa.DateBeg} - {$visa.DateEnd}</td>
                <td class="o_pcount">{$visa.PCount}</td>
            </tr>
        <!-- {/foreach} -->
    </tbody>
    </table>
<br>{/if}