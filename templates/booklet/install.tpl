<h3>������� �� ������ � {$CLAIM} ��� ��������:</h3>
<br>
{if $Peoples}
    <table class="booklet">
    <thead>
        <tr>
            <th>�</th>
            <th>���</th>
        </tr>
    </thead>
    <tbody>
        <!-- {foreach from = $Peoples item = "people" name="peoples"} -->
            <tr>
                <td>{$smarty.foreach.peoples.iteration}</td>
                <td class="fio">{$people.Name}</td>
<!-- {*                <td class="human">{$people.Human}</td>
                <td class="born">{$people.Born}</td>
                <td class="passport">{$people.PSerie} {$people.PNumber} �� {$people.PValid}</td> *} -->
            </tr>
        <!-- {/foreach} -->
    </tbody>
    </table>
<br>{/if}
<p>����������, ��������� ��� ��������� ����� ��������. ���������, ��� ���� �������� ������������� � ���� �� �������� ���������� ��� ������� � ��������� ���� ������. �� ����������� ����� ���������� �������. ������ ����� �����������, ���� ������������� � ������������������� ������. ���� ������� ������������ � ����������, �� ����� ���� ������ � ������� ������ ��� ����� ��������� �� ���������� 14��� (� 6 ��� ������ ���� ������� ����������), � ����� ����� ����������� ������� � ������ ��������. ���� � ������� ���� �������, �� ����� ����������� ����� � ����� ��� ������������� � ��������. ���� ������������������ ������������ ��� ���������, �� ����������� ����� ������������ ���������� �� ����� ������������������� ���������� �� ������� �������������� ��� � ��������������.</p> 
{if $Freights}
<h3>�����������</h3>
    <table class="booklet">
    <thead>
        <tr>
            <th>����</th>
            <th>����� � ��������<br>�����������</th>
            <th>����� � ��������<br>��������</th>
            <th>����� �����</th>
            <th>�����<br>�����������</th>
            <th>�����<br>��������</th>
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
<h3>����� �� ��������:</h3>
    <table class="booklet">
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
<h3>�������������� ������:</h3>
    <table class="booklet">
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
<h3>���������:</h3>
    <table class="booklet">
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
<br>{/if}
{if $Visas}
<h3>����:</h3>
    <table class="booklet">
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
<br>{/if}