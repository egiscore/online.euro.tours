{if $load == 'ORDER_BUTTONS'}
    {if $btn.hotel}
        <input type="button" class="button" id="ORDER_BTN_HOTEL" name="ORDER_BTN_HOTEL" data-otype="H" value="##CL_W_ORDER_BTN_HOTEL##">&nbsp;
    {/if}
    {if $btn.load_order_btn}
        <input type="button" class="button" id="ORDER_BTN_LOAD" name="ORDER_BTN_LOAD" value="##CL_W_ORDER_BTN_LOAD##">&nbsp;
    {/if}
    {if $btn.freight}
        <input type="button" class="button" id="ORDER_BTN_FREIGHT" data-otype="F" value="##CL_W_ORDER_BTN_FREIGHT##">&nbsp;
    {/if}
    {if $btn.service}
        <input type="button" class="button" id="ORDER_BTN_SERVICE" data-otype="S" value="##CL_W_ORDER_BTN_SERVICE##">&nbsp;
    {/if}
    {if $btn.insure}
        <input type="button" class="button" id="ORDER_BTN_INSURE" data-otype="I" value="##CL_W_ORDER_BTN_INSURE##">&nbsp;
    {/if}
    {if $btn.visa}
        <input type="button" class="button" id="ORDER_BTN_VISA" data-otype="V" value="##CL_W_ORDER_BTN_VISA##">&nbsp;
    {/if}
{/if}
{if $load == 'CALC_RESULT'}
    ##CL_W_PRICE## {$Calc.PriceStr|string_format:"%.2f"} {$Calc.Currency_Alias} {if $Calc.FullNumber != ''}##CL_W_SPO## {$Calc.FullNumber}{/if}
{/if}
{if $load == 'CALC_ERROR'}
    {$error}
{/if}
{if $load == 'ORDER_TOWNS_SERVICE_OPTION'}
    {foreach from=$OrderInfo.Towns item="towns"}
        <option value="{$towns.Inc}" {if $towns.selected}selected{/if} data-target-name="{$towns.TargetLName}" data-source-name="{$towns.SourceLName}">{$towns.LName}</option>
    {/foreach}
{/if}
{if $load == 'ORDER_HOTEL_SERVICE_OPTION'}
    {foreach from=$OrderInfo.Hotel item="hotel"}
    <option value="{$hotel.Inc}" {if $hotel.selected}selected{/if} data-hotel-name="{$hotel.LName}" data-roominc="{$hotel.roomInc}" data-mealinc="{$hotel.mealInc}">{$hotel.LName}{if $hotel.TownLName}({$hotel.TownLName}){/if}</option>
    {/foreach}
{/if}
