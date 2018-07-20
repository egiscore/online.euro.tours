<h3>Подтверждение по заявке № {$CLAIM}</h3>

<table class="confirmation">
<tbody>
    <tr><td>Дата</td><td>{$smarty.now|datetime_format}</td></tr>
    <tr><td>Агентство</td><td>{$claim_info.POfficialName}</td></tr>
    <tr><td>Код города</td><td>{$claim_info.PPhonePref}</td></tr>
    <tr><td>Телефон</td><td>{$claim_info.phones|@glue}</td></tr>
    <tr><td>Факс</td><td>{$claim_info.faxes|@glue}</td></tr>
    <tr><td>Email</td><td>{$claim_info.PEmail}</td></tr>
</tbody>
</table>
{if $Peoples}
<h3>Туристы</h3>    
    <table class="confirmation">
    <thead>
        <tr>
            <th>№</th>
            <th>ФИО</th>
        </tr>
    </thead>
    <tbody>
        <!-- {foreach from = $Peoples item = "people" name="peoples"} -->
            <tr>
                <td class="human">{$people.Human}</td>
                <td class="fio">{$people.Name}</td>
                <td class="born">{$people.Born}</td>
                <td class="passport">{$people.PSerie} {$people.PNumber} до {$people.PValid}</td>
            </tr>
        <!-- {/foreach} -->
    </tbody>
    </table>
{/if}<br>


{if $Freights}
<h3>Авиаперелёты</h3>
    <table class="confirmation">
    <thead>
        <tr>
            <th>Дата</th>
            <th>Город и аэропорт<br>отправления</th>
            <th>Город и аэропорт<br>прибытия</th>
            <th>Рейс</th>
            <th>Время<br>отправления</th>
            <th>Время<br>прибытия</th>
        </tr>
    </thead>
    <tbody>
        <!-- {foreach from = $Freights item = "freight" name="freights"} -->
            <tr>
                <td>{$freight.DateBeg}</td>
                <td>{$freight.TownSrcLName} ({$freight.SrcPortAlias})</td>
                <td>{$freight.TownTrgLName} ({$freight.TrgPortAlias})</td>
                <td>{$freight.FreightLName} ({$freight.TranTypeLName}) {$freight.ClassLName} ({$freight.FrPlaceLName})</td>
                <td>{$freight.SrcTime}{if $freight.SrcTimeDelta}<span class="delta">+{$freight.SrcTimeDelta}</span>{/if}</td>
                <td>{$freight.TrgTime}{if $freight.TrgTimeDelta}<span class="delta">+{$freight.TrgTimeDelta}</span>{/if}</td>
            </tr>
        <!-- {/foreach} -->
    </tbody>
    </table>
{/if}<br>

{if $Hotels}
<h3>ОТЕЛИ ПО МАРШРУТУ:</h3>
    <table class="confirmation">
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
            <td>{$hotel.StateLName}</td>
            <td>{$hotel.TownLName}</td>
            <td>{$hotel.HotelLName} {$hotel.StarLName}</td>
            <td>{$hotel.RoomLName} / {$hotel.HtPlaceLName}</td>
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
    <table class="confirmation">
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
                <td>{$service.ServiceTypeName}: {$service.ServiceName}</td>
                <td>{$service.DateBeg} - {$service.DateEnd}</td>
                <td class="o_pcount">{$service.PCount}</td>
                <td>{$service.Partner_partnerlname}</td>
                <td>{$service.Partner_phones}</td>
            </tr>
        <!-- {/foreach} -->
    </tbody>
    </table>
{/if}<br>

{if $Insures}
<h3>Страховки:</h3>
    <table class="confirmation">
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
{/if}<br>

{if $Visas}
<h3>Визы:</h3>
    <table class="confirmation">
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
{/if}<br>

<table class="confirmation">
    <tbody>
<tr><td>Менеджер по туризму: {$claim_info.ClaimManager}</td></tr>
<!-- {if $claim_info.PDate && $claim_info.PDate->not_null()} -->
<tr><td>Дата последней оплаты: {$claim_info.PDate}</td></tr>
<!-- {/if} -->
<tr><td>Итого: {$claim_info.ClaimPrice} {$claim_info.ClaimCurrency}</td></tr>
<!-- {if $claim_info.ClaimCommission} -->
<tr><td>Комиссия: {$claim_info.ClaimCommission}</td></tr>
<!-- {/if} -->
    </tbody>
</table>