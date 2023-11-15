<table border="1">
    <tr>
        <td colspan="3" class="logo"></td>
        <td colspan="3" class="center">
            <strong>Formato de inspección Ante Mortem</strong><br>
            <strong>Sistema integral de gestion de la Calidad e<br> Inocuidad de los alimentos.</strong><br>
        </td>
        <td colspan="2">
            <b>PBA</b> <br>
            Planta de Beneficio Animal
        </td>
    </tr>
    <tr>
        <td colspan="2">CODIGO: PBA-PM-PB-BOV-FOR-01</td>
        <td colspan="2">versión: 1</td>
        <td colspan="2">Fecha de Emisión: 05/12/2021</td>
        <td colspan="2">Página 1</td>
    </tr>
    <tr>
        <td colspan="8"></td>
    </tr>
    <tr>
        <td colspan="3"><strong>FECHA: {{ $request->date }}</strong></td>
        <td colspan="2"><strong>HORA I: {{ $request->time_entry }}</strong></td>
        <td colspan="3"><strong>MEDICO VETERINARIO: {{ $request->veterinary }}</strong></td>
    </tr>
    <tr>
        <td colspan="8"></td>
    </tr>
    <tr>
        <td><strong>ITEM</strong></td>
        <td><strong># CORRAL</strong></td>
        <td><strong>No. DE GUIA SANITARIA</strong></td>
        <td colspan="2"><strong>No. CONSECUTIVO código</strong></td>
        <td colspan="2"><strong>HORA DE INGRESO CORRALES DE SACRIFICIO</strong></td>
        <td><strong>TIEMPO DE DESCANSO</strong></td>
    </tr>
    @php 
        $key = 1;
    @endphp
    @foreach($data as $element)
    <tr>
        <td>{{ $key }}</td>
        <td>{{ $element['corral_number'] }}</td>
        <td>{{ $element['guide'] }}</td>
        <td colspan="2">{{ $element['animal_code'] }}</td>
        <td colspan="2">{{ $element['corral_entry'] }}</td>
        <td>{{ $element['time_off'] }}</td>
    </tr>
    @php 
        $key += 1;
    @endphp
    @endforeach

    <tr>
        <td colspan="8"></td>
    </tr>
    <tr>
        <td colspan="8">
            <b>ANIMALES SOSPECHOSOS</b>
        </td>
    </tr>
    @php
        $males = 0;
        $females = 0;
    @endphp
    @foreach ($request->suspiciousAnimals as $animal)
    @php
    $males += $animal['male'];
    $females += $animal['female'];    
    @endphp
    @endforeach
    <tr>
        <td colspan="2"><b>HEMBRAS: {{ $females }}</b> </td>
        <td colspan="2"><b>MACHOS: {{ $males }}</b> </td>
        <td colspan="4"><b>TOTAL BOBINOS: {{ count($request->suspiciousAnimals) }}</b></td>
    </tr>
    <tr>
        <td colspan="2"><b>SEXO</b></td>
        <td rowspan="2"><b># DE GUIA <br>SANITARIA</b></td>
        <td colspan="2" rowspan="2"><b>HALLAZGOS Y<br>OBSERVACIONES</b></td>
        <td rowspan="2"><b>DECISION</b></td>
        <td rowspan="2"><b>CAUSA DE<br>DECOMISO</b></td>
        <td rowspan="2"><b>CORRAL</b></td>
    </tr>
    <tr>
        <td><b>MACHO</b></td>
        <td><b>HEMBRA</b></td>
    </tr>
    @foreach ($request->suspiciousAnimals as $animal)
    <tr>
        <td>{{ $animal['male'] ? 'X' : '' }}</td>
        <td>{{ $animal['female'] ? 'X' : '' }}</td>
        <td>{{ $animal['guide'] }}</td>
        <td colspan="2">{{ $animal['findings_and_observations'] }}</td>
        <td>{{ $animal['decision'] }}</td>
        <td>{{ $animal['cause_forfeiture'] }}</td>
        <td>{{ $animal['corral'] }}</td>
    </tr>
    @endforeach
</table>