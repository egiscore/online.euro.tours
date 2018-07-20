{if $RESULT}
<table class="res" >
    <tbody >
        {foreach from=$RESULT item="res"}
            {if $PreviousTrgTown != $res.NewTrgTownName or $PreviousSrcTown != $res.NewSrcTownName}
                <tr><td><b>##FRCHANGES_ROUTE## {$res.NewSrcTownName} - {$res.NewTrgTownName}</b></tr></td>
            {/if}
            <tr><td>
                {if $res.OldDate != $res.NewDate}
                    ##FRCHANGES_TEXT_1## <b>{$res.OldFreightName}</b> ##FRCHANGES_TEXT_2## {$res.NewSrcTownName} - {$res.NewTrgTownName} ##FRCHANGES_TEXT_3## <b>{$res.OldDate} </b>
                    ##FRCHANGES_TEXT_4## <b>{$res.NewDate}</b> ##FRCHANGES_TEXT_5## <b>{$res.NewFreightName}</b> ##FRCHANGES_TEXT_6## <b>{$res.NewSrcTime|date_format:"time"}</b> ##FRCHANGES_TEXT_7## {$res.NewSrcPortName}.
                {elseif $res.OldFreight != $res.NewFreight}
                    <b>{$res.NewDate}</b> ##FRCHANGES_TEXT_8## {$res.NewSrcTownName} - {$res.NewTrgTownName} ##FRCHANGES_TEXT_9## <b>{$res.OldFreightName} </b>
                    ##FRCHANGES_TEXT_10## <b>{$res.NewFreightName}</b> ##FRCHANGES_TEXT_6## <b>{$res.NewSrcTime|date_format:"time"}</b> ##FRCHANGES_TEXT_7## {$res.NewSrcPortName}.
                {else}
                    <b>{$res.NewDate}</b> ##FRCHANGES_TEXT_8## {$res.NewSrcTownName} - {$res.NewTrgTownName} ##FRCHANGES_TEXT_10## <b>{$res.NewFreightName}</b> ##FRCHANGES_TEXT_6## <b>{$res.NewSrcTime|date_format:"time"}</b> ##FRCHANGES_TEXT_7## {$res.NewSrcPortName}.
                {/if}
                <i>##FRCHANGES_TEXT_11## {$res.ADate}</i>
                {assign var=PreviousTrgTown value=$res.NewTrgTownName}
                {assign var=PreviousSrcTown value=$res.NewSrcTownName}
            </td></tr>
        {/foreach}
    </tbody>
</table>
<br>
{else}
    ##NO_DATA##
{/if}