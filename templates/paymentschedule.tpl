<table class="res">
    <thead>
        <tr>
            <td>##PAYMENT_SCHEDULE_PDATE##</td>
            <td>##PAYMENT_SCHEDULE_PERCENT##</td>
        </tr>
    </thead>
    <tbody>
        {foreach from=$paymentschedule item="row"}
            <tr class="{cycle values="even,odd"}">
                <td>{$row.date|date_format|default:$row.pdate|date_format}</td>
                <td>{$row.percent}%</td>
            </tr>
        {/foreach}
    </tbody>
</table>
