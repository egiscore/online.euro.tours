{foreach from=$Order item="order" name=oname}
    {assign var='n' value=$smarty.foreach.oname.iteration}

    <tr data-order-type="{$order.ORDER_TYPE}" data-order="{$order.inc}" class="{cycle values="even,odd"}">
        {if $order.ORDER_TYPE == 'H'}
            <td>{$n}<br>##CL_W_HOTEL##</td>
            <td>
                {$order.ORDER_DATEBEG} - {$order.ORDER_DATEEND} <span class="bold">{$order.hotelname}</span><br>
                <span class="link">{$order.roomname}/{$order.htplacename} {$order.mealname}</span>
            </td>
        {/if}
        {if $order.ORDER_TYPE == 'F'}
            <td>{$n}<br>##CL_W_FREIGHT##</td>
            <td>
                {$order.ORDER_DATEBEG} <span class="bold">{$order.freight_name} ({$order.tpartner_name})</span><br>
                <span class="link">{$order.source_name}({$order.srcport} {$order.src_time}) --> {$order.target_name}({$order.trg_port} {$order.trg_time}) {$order.class_name}/{$order.frplace_name}</span>
            </td>
        {/if}
        {if $order.ORDER_TYPE == 'S'}
            <td>{$n}<br>##CL_W_SERVICE##</td>
            <td>
                {$order.ORDER_DATEBEG} - {$order.ORDER_DATEEND}<br>
                <span class="{if $order.auto_added != 1}link{/if}">{$order.servtype_name}: {$order.service_name} ({$order.source_name}{if $order.target_name != ''} --> {$order.target_name}{/if}) {if $order.service_hotel_name != ''}({$order.service_hotel_name}){/if} {$order.trantype_name}</span>
            </td>
        {/if}
        {if $order.ORDER_TYPE == 'I'}
            <td>{$n}<br>##CL_W_INSURE##</td>
            <td>
                {$order.ORDER_DATEBEG} - {$order.ORDER_DATEEND}<br>
                <span class="link">{$order.state_name}: {$order.insure_name} ({$order.partner_name})</span>
            </td>
        {/if}
        {if $order.ORDER_TYPE == 'V'}
            <td>{$n}<br>##CL_W_VISA##</td>
            <td>
                {$order.ORDER_DATEBEG} - {$order.ORDER_DATEEND}<br>
                <span class="link">{$order.state_name}: {$order.visa_name} ({$order.days})</span>
            </td>
        {/if}
        <td>
            {foreach from=$order.OPEOPLE item="opeople"}
                <div class="finish_opeople">
                    {foreach from=$opeople item="people"}
                        {if $people.Inc == 0}
                            <span class="red">{$people.LName}</span><br>
                        {else}
                            {$people.LName}<br>
                        {/if}
                    {/foreach}
                </div>
            {/foreach}
        </td>
        <td>
            {if $order.auto_added != 1}
                <input type="button" class="button delete_order_botton"  value="##CL_W_DELETE##">
            {/if}
        </td>
    </tr>
{foreachelse}
    <tr><td colspan="4" class="c"><br>##CL_W_ORDER_EMPTY##<br><br></td></tr>
{/foreach}
