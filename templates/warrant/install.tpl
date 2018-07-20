<div class="warr">
<h3>Доверенность</h3>
<br />
Дата выдачи: <b>{$dov.DateBeg|date_format}</b><br />
Доверенность действительна: с <b>{$dov.DateBeg|date_format}</b> по <b>{$dov.DateEnd|date_format}</b><br />
Организация: <b>{$dov.PartnerName}</b><br />
ИНН: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>{$dov.PartnerInn} </b><br />
Город:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>{$dov.PartnerTown} </b><br />
Адрес:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>{$dov.PartnerAddress}</b><br />
<br />
Доверенное лицо: &nbsp; <b>{$dov.name}</b> &nbsp; (ФИО плательщика)<br />
Паспорт: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>{$dov.PSerie}</b> № <b>{$dov.PNumber}</b><br />
Кем выдан: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>{$dov.PWhere}</b> &nbsp; (орган выдавший паспорт)<br />
Дата выдачи: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>{$dov.PWhen|date_format}</b><br />
<br />
<b>{$dov.name}</b> &nbsp;действуя на основании данной доверенности , может производить оплату<br />
туристического продукта, получение и подписание перевозочных и бухгалтерских документов за&nbsp; <b>{$dov.PartnerName}</b>.<br />
<br />
<br />
<br />
Подпись &nbsp;___________________________(<b>{$dov.name}</b>) удостоверяем.<br />
<br />
<br />
<br />
Руководитель организации _____________________ (подпись)<br />
<br />
М.П.<br />
<br />
<br />
<br />
</div>