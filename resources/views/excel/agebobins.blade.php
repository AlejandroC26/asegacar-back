<table border="1">
    <tr>
        <td rowspan="2" colspan="3"></td>
        <td colspan="5" class="center">
            <b>CATEGORÍA / EDAD DE LOS ANIMALES</b>
        </td>
        <td colspan="2" rowspan="2">
            <b>PBA</b> <br>
            Planta de Beneficio Animal
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <b>SISTEMA INTEGRAL DE GESTION DE LA CALIDAD DE INOCUIDAD DE LOS ALIMENTOS</b>
        </td>
    </tr>
    <tr>
        <td colspan="3"><b>CÓDIGO: PBA-PM-PB-BOV-FOR-05</b></td>
        <td colspan="2"><b>VERSIÓN: 3</b></td>
        <td colspan="3">
            <b>FECHA DE EMISIÓN: {{ $dates['month'] }} {{ $dates['year'] }}</b>
        </td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td colspan="10">
            <b>INGRESO BOVINOS MES {{ $dates['month'] }} {{ $dates['year'] }}</b>
        </td>
    </tr>
    <tr>
        <td rowspan="2"><b>FECHA</b></td>
        <td colspan="4"><b>HEMBRAS</b></td>
        <td colspan="4"><b>MACHOS</b></td>
        <td rowspan="2"><b>TOTAL</b></td>
    </tr>
    <tr>
        <td><b>1 - 2 AÑOS</b></td>
        <td><b>2 - 3 AÑOS</b></td>
        <td><b>3 - 4 AÑOS</b></td>
        <td><b>TOTAL</b></td>
        
        <td><b>1 - 2 AÑOS</b></td>
        <td><b>2 - 3 AÑOS</b></td>
        <td><b>3 - 4 AÑOS</b></td>
        <td><b>TOTAL</b></td>
    </tr>
    @foreach($data as $record)
    <tr>
        <td><b>{{ $config['date'] }}</b></td>
        <td>{{ $record['females']['1-2'] }}</td>
        <td>{{ $record['females']['2-3'] }}</td>
        <td>{{ $record['females']['> 3'] }}</td>
        <td><b>{{ $record['females']['total'] }}</b></td>
        <!-- MACHOS -->
        <td>{{ $record['males']['1-2'] }}</td>
        <td>{{ $record['males']['2-3'] }}</td>
        <td>{{ $record['males']['> 3'] }}</td>
        <td><b>{{ $record['males']['total'] }}</b></td>
        <td>{{ $record['total'] }}</td>
    </tr>
    @endforeach
    <tr>
        <td><b>TOTAL</b></td>
        <td>{{ $totals['females']['1-2'] }}</td>
        <td>{{ $totals['females']['2-3'] }}</td>
        <td>{{ $totals['females']['> 3'] }}</td>
        <td><b>{{ $totals['females']['total'] }}</b></td>
        <!-- MACHOS -->
        <td>{{ $totals['males']['1-2'] }}</td>
        <td>{{ $totals['males']['2-3'] }}</td>
        <td>{{ $totals['males']['> 3'] }}</td>
        <td><b>{{ $totals['males']['total'] }}</b></td>
        <td>{{ $totals['total'] }}</td>
    </tr>

    <tr>
        <td colspan="5"><b>PROPÓSITO</b></td>
    </tr>
    <tr>
        <td><b>FECHA</b></td>
        <td><b>CARNE</b></td>
        <td><b>LECHE</b></td>
        <td><b>DOBLE PROPÓSITO</b></td>
        <td><b>TOTAL</b></td>
        <!--  -->
        <td></td>
        <!--  -->
        <td colspan="2"><b>TOTAL GSM</b></td>
    </tr>
    @php
        $total_guides = 0;
    @endphp
    @foreach($data as $record)
    @php
        $total_guides += count($record['guides']);
    @endphp
    <tr>
        <td><b>{{ $config['date'] }}</b></td>
        <td>{{ $record['purposes']['meat'] }}</td>
        <td>{{ $record['purposes']['milk'] }}</td>
        <td>{{ $record['purposes']['double'] }}</td>
        <td>{{ $record['purposes']['total'] }}</td>
        <!--  -->
        <td></td>
        <!--  -->
        <td><b>{{ $config['date'] }}</b></td>
        <td>{{ count($record['guides']) }}</td>
    </tr>
    @endforeach
    <tr>
        <td><b>TOTAL</b></td>
        <td>{{ $totals['purposes']['meat'] }}</td>
        <td>{{ $totals['purposes']['milk'] }}</td>
        <td>{{ $totals['purposes']['double'] }}</td>
        <td>{{ $totals['purposes']['total'] }}</td>
        <!--  -->
        <td></td>
        <!--  -->
        <td><b>TOTAL</b></td>
        <td>{{ $total_guides }}</td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="2"><b>RESPONSABLE</b></td>
        <td colspan="2">{{ $config['responsable'] }}</td>
    </tr>
</table>