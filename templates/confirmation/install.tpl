<h3>������������� �� ������ � {$CLAIM}</h3>

<table class="confirmation">
<tbody>
    <tr><td>����</td><td>{$smarty.now|datetime_format}</td></tr>
    <tr><td>���������</td><td>{$claim_info.POfficialName}</td></tr>
    <tr><td>��� ������</td><td>{$claim_info.PPhonePref}</td></tr>
    <tr><td>�������</td><td>{$claim_info.phones|@glue}</td></tr>
    <tr><td>����</td><td>{$claim_info.faxes|@glue}</td></tr>
    <tr><td>Email</td><td>{$claim_info.PEmail}</td></tr>
</tbody>
</table>
{if $Peoples}
<h3>�������</h3>    
    <table class="confirmation">
    <thead>
        <tr>
            <th>�</th>
            <th>���</th>
        </tr>
    </thead>
    <tbody>
        <!-- {foreach from = $Peoples item = "people" name="peoples"} -->
            <tr>
                <td class="human">{$people.Human}</td>
                <td class="fio">{$people.Name}</td>
                <td class="born">{$people.Born}</td>
                <td class="passport">{$people.PSerie} {$people.PNumber} �� {$people.PValid}</td>
            </tr>
        <!-- {/foreach} -->
    </tbody>
    </table>
{/if}<br>


{if $Freights}
<h3>�����������</h3>
    <table class="confirmation">
    <thead>
        <tr>
            <th>����</th>
            <th>����� � ��������<br>�����������</th>
            <th>����� � ��������<br>��������</th>
            <th>����</th>
            <th>�����<br>�����������</th>
            <th>�����<br>��������</th>
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
<h3>����� �� ��������:</h3>
    <table class="confirmation">
    <thead>
        <tr>
            <th>������</th>
            <th>�����</th>
            <th>���������</th>
            <th>�����</th>
            <th>�����<br>������</th>
            <th>�����</th>
            <th><nobr>���-�</nobr></th>
            <th>�����������<br>��������,<br> ���</th>
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
<h3>�������������� ������:</h3>
    <table class="confirmation">
    <thead>
        <tr>
            <th>������������<br>������</th>
            <th>�����</th>
            <th>���-��<br>�����</th>
            <th>������<br>������������</th>
            <th>����������</th>
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
<h3>���������:</h3>
    <table class="confirmation">
    <thead>
        <tr>
            <th>��������</th>
            <th>������</th>
            <th>�����</th>
            <th>���-��</th>
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
<h3>����:</h3>
    <table class="confirmation">
    <thead>
        <tr>
            <th>��������</th>
            <th>������</th>
            <th>�����</th>
            <th>���-��</th>
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
<tr><td>�������� �� �������: {$claim_info.ClaimManager}</td></tr>
<!-- {if $claim_info.PDate && $claim_info.PDate->not_null()} -->
<tr><td>���� ��������� ������: {$claim_info.PDate}</td></tr>
<!-- {/if} -->
<tr><td>�����: {$claim_info.ClaimPrice} {$claim_info.ClaimCurrency}</td></tr>
<!-- {if $claim_info.ClaimCommission} -->
<tr><td>��������: {$claim_info.ClaimCommission}</td></tr>
<!-- {/if} -->
    </tbody>
</table>