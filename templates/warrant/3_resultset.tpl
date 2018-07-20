{if $RESULT}
<table class="res">
<thead>
    <tr>
        <th>##WARRANT_PNAME##</th>
        <th>##WARRANT_PSNUMBER##</th>
        <th>##WARRANT_PSWHEN##</th>
        <th>##WARRANT_PSWHERE##</th>
        <th>##WARRANT_PCODEORG##</th>
        <th>##WARRANT_PBORN##</th>
        <th>##WARRANT_PADD##</th>
        <th>##WARRANT_PDATE##</th>
        <th>##WARRANT_PHAVE##</th>
    </tr>
</thead>
<tbody>
    {foreach from=$RESULT item="warrant"}
        <tr class="{cycle values="even,odd"}">
        <td data-warrant="{$warrant.inc}"><div {if $warrant.haveoriginal == 0}class="link"{/if}>{$warrant.name}{if $warrant.haveoriginal == 0}</div>{/if}</td>
            <td>{$warrant.PSerie} ¹ {$warrant.PNumber}</td>
            <td>{$warrant.PWhen}</td>
            <td>{$warrant.PWhere}</td>
            <td>{$warrant.PCodeOrg}</td>
            <td>{$warrant.Born}</td>
            <td>{$warrant.Address}</td>
            <td>{$warrant.DateBeg}-{$warrant.DateEnd}</td>
            <td>
                {if $warrant.haveoriginal}
                    <span class="ui-icon-document ui-icon" title="##DOCUMENT_HAVE_ORIGINAL_TITLE##">&nbsp;</span> ##DOCUMENT_HAVE_ORIGINAL##
                {else}
                    {if $warrant.havecopy}
                        <span class="ui-icon-document ui-icon" title="##DOCUMENT_HAVE_COPY_TITLE##">&nbsp;</span> ##DOCUMENT_HAVE_COPY##
                    {else}
                        <span class="ui-icon-document ui-icon">&nbsp;</span> ##DOCUMENT_NOT_AVAILABLE##
                    {/if}
                {/if}
            </td>
        </tr>
    {/foreach}
</tbody>
</table>
{else}
    ##NO_DATA##
{/if}