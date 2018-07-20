{if $load eq "reportParams"}
    <table>
        <tr>
            <td>
                <form class="reportForm" action="{Samo_Url::route('reports', ['samo_action' => 'PDF_SAMOTOUR'])}" method="post">
                {include file="../fieldset_builder.tpl" }
                </form>
            </td>
        </tr>
    </table>
{/if}