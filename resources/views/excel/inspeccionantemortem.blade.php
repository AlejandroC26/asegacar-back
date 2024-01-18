<table border="1">
    <tr>
        <td colspan="3" class="logo"></td>
        <td colspan="5" class="center">
            <strong>Formato de inspección Ante Mortem</strong><br>
            <strong>Sistema integral de gestion de la Calidad e<br> Inocuidad de los alimentos.</strong><br>
        </td>
        <td colspan="3">
            <b>PBA</b> <br>
            Planta de Beneficio Animal
        </td>
    </tr>
    <tr>
        <td colspan="3">CODIGO: PBA-PM-PB-BOV-FOR-01</td>
        <td colspan="4">Versión: 4</td>
        <td colspan="2">Fecha de Emisión: 17/01/2024</td>
        <td colspan="2">Página 1</td>
    </tr>
    <tr>
        <td colspan="11"></td>
    </tr>
    <tr>
        <td colspan="3"><strong>FECHA: {{ $request->date }}</strong></td>
        <td colspan="8"><strong>MEDICO VETERINARIO: {{ $request->veterinary }}</strong></td>
    </tr>
    <tr>
        <td colspan="11"></td>
    </tr>
    <tr>
        <td><strong>ITEM</strong></td>
        <td><strong>HORA ANTEMORTEM</strong></td>
        <td><strong># CORRAL</strong></td>
        <td colspan="2"><strong>No. DE GUIA SANITARIA</strong></td>
        <td><strong>No. CONSECUTIVO</strong></td>
        <td><strong>SEXO</strong></td>
        <td><strong>TIEMPO DE DESCANSO</strong></td>
        <td><strong>HALLAZGOS Y OBSERVACIONES</strong></td>
        <td><strong>DICTAMEN FINAL</strong></td>
        <td><strong>CAUSA DE DECOMISO</strong></td>
    </tr>
    @php 
        $key = 1;
    @endphp
    @foreach($data as $element)
    <tr>
        <td>{{ $key }}</td>
        <td>{{ $element['corral_entry'] }}</td>
        <td>{{ $element['corral_number'] }}</td>
        <td colspan="2">{{ $element->dailyPayroll->incomeForm->guide->code }}</td>
        <td>{{ $element->dailyPayroll->incomeForm->code }}</td>
        <td>{{ $element->dailyPayroll->incomeForm->gender->name }}</td>
        <td>{{ $element['rest_time'] }}</td>
        <td>{{ $element['findings_and_observations'] }}</td>
        <td>{{ $element['final_dictament'] }}</td>
        <td>{{ $element['cause_for_seizure'] }}</td>
    </tr>
    @php 
        $key += 1;
    @endphp
    @endforeach
    <tr>
        <td colspan="11"></td>
    </tr>
    <tr>
        <td colspan="2"><strong>MACHOS</strong></td>
        <td colspan="2">{{ $request['count']['males'] }}</td>
        <td colspan="2"><strong>HEMBRAS</strong></td>
        <td colspan="2">{{ $request['count']['females'] }}</td>
        <td><strong>TOTAL BOVINOS</strong></td>
        <td colspan="2">{{ $request['total'] }}</td>
    </tr>
</table>