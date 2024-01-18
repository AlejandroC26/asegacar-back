<table border="1">
    <tr>
        <td class="logo" colspan="2"></td>
        <td colspan="4" class="center">
            Registro diario de bovinos <br>
            Sistema Integral de Gestión de la Calidad <br>e inocuidad de los alimentos.
            
        </td>
        <td colspan="4">
            <b>PBA <br>
            Planta de Beneficio Animal</b>
        </td>
    </tr>
    <tr>
        <td colspan="3">código: PBA-PE-GC-GCL-MT01</td>
        <td colspan="2">versión: 2</td>
        <td colspan="4">
            <center>fecha de emisión: JULIO 2022</center>
        </td>
        <td>Página 1</td>
    </tr>
    <tr>
        <td colspan="4"><b>FECHA DE BENEFICIO: {{ $general['date'] }}</b></td>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td rowspan="2"><b>NO GUÍA</b></td>
        <td rowspan="2"><b>FECHA INGRESO</b></td>
        <td rowspan="2"><b>HORA INGRESO</b></td>
        <td rowspan="2"><b>CÓDIGO ASIGNADO</b></td>
        <td colspan="2"><b>TOTAL</b></td>
        <td rowspan="2"><b>EDAD</b></td>
        <td rowspan="2"><b>No. EXPENDIOS</b></td>
        <td colspan="2"><b>INGRESO A SACRIFICIO</b></td>
    </tr>
    <tr>
        <td><b>M</b></td>
        <td><b>H</b></td>
        <td><b>M</b></td>
        <td><b>H</b></td>
    </tr>
    @php
        $total_males   = 0;
        $total_females = 0;
        
        $total_sacrifice_males   = 0;
        $total_sacrifice_females = 0;
    @endphp
    @foreach($data as $element)
    <tr>
        @php
            $total_males += $element['tm'];
            $total_females += $element['tf'];

            $total_sacrifice_males += $element['st'];
            $total_sacrifice_females += $element['sf'];
        @endphp


        <td rowspan="{{ (count($element['records']) + 1) }}">{{ $element['guide'] }}</td>
        <td rowspan="{{ (count($element['records']) + 1) }}">{{ $element['date_entry'] }}</td>
        <td rowspan="{{ (count($element['records']) + 1) }}">{{ $element['time_entry'] }}</td>

        <td>{{ $element['code'] }}</td>
        <td>{{ $element['tm'] }}</td>
        <td>{{ $element['tf'] }}</td>
        <td>{{ $element['age'] }}</td>
        <td>{{ $element['outlet'] }}</td>
        <td>{{ $element['st'] }}</td>
        <td>{{ $element['sf'] }}</td>
    </tr>
        @foreach($element['records'] as $record)
            @php
                $total_males += $record['tm'];
                $total_females += $record['tf'];

                $total_sacrifice_males += $record['st'];
                $total_sacrifice_females += $record['sf'];
            @endphp
            <tr>
                <td>{{ $record['code'] }}</td>
                <td>{{ $record['tm'] }}</td>
                <td>{{ $record['tf'] }}</td>
                <td>{{ $record['age'] }}</td>
                <td>{{ $record['outlet'] }}</td>
                <td>{{ $record['st'] }}</td>
                <td>{{ $record['sf'] }}</td>
            </tr>
        @endforeach
    @endforeach
    <tr>
        <td colspan="4" rowspan="2"><b>TOTAL BOVINOS EN PLANTA</b></td>
        <td>{{ $total_males }}</td>
        <td>{{ $total_females }}</td>
        <td rowspan="2" colspan="2"><b>ANIMALES PARA <br>BENEFICIO</b></td>
        <td>{{ $total_sacrifice_males }}</td>
        <td>{{ $total_sacrifice_females }}</td>
    </tr>
    <tr>
        <td colspan="2">{{ $total_males + $total_females }}</td>
        <td colspan="2">{{ $total_sacrifice_males + $total_sacrifice_females }}</td>
    </tr>
    <tr></tr>
    <tr>
        <td><b>RESPONSABLE</b></td>
        <td colspan="2">{{ $general['responsable'] }}</td>
    </tr>
</table>