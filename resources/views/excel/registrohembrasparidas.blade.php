<table border="1">
    <tr>
        <td colspan="2" class="logo"></td>
        <td colspan="4" class="center">
            <strong>REGISTRO DE HEMBRAS PARIDAS</strong><br>
            <strong>Sistema integral de gestion de la Calidad e<br> Inocuidad de los alimentos.</strong><br>
        </td>
        <td colspan="2">
            <b>PBA</b> <br>
            Planta de Beneficio Animal
        </td>
    </tr>
    <tr>
        <td colspan="2"><strong>CODIGO: PBA-PM-PB-BOV-FOR-07</strong></td>
        <td colspan="1"><strong>VERSIÓN: 1</strong></td>
        <td colspan="3"><strong>FECHA DE EMISION: ENERO 2021</strong></td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td colspan="8"></td>
    </tr>
    <tr>
        <td colspan="4"><strong>FECHA:</strong>&nbsp;{{ $data['date'] }}</td>
        <td colspan="4"><strong>HORA:</strong>&nbsp;{{ $data['time'] }}</td>
    </tr>
    <tr>
        <td colspan="4"><strong>SUPERVISO:</strong>&nbsp;{{ $data['supervisor'] }}</td>
        <td colspan="4"><strong>RESPONSABLE:</strong>&nbsp;{{ $data['responsable'] }}</td>
    </tr>
    <tr>
        <td colspan="8"></td>
    </tr>
    <tr>
        <td colspan="8"><strong>MEDICO VETERINARIO RESPONSABLE: {{ $data['veterinary'] }}</strong></td>
    </tr>
    <tr>
        <td colspan="8"><strong>PROPIETARIO DEL ANIMAL: {{ $data['owner'] }}</strong></td>
    </tr>
    <tr>
        <td colspan="8"><strong>FIRMA: </strong></td>
    </tr>
    <tr>
        <td colspan="8"><strong>HORA DEL PARTO: {{ $data['delivery_time'] }}</strong></td>
    </tr>
    <tr>
        <td colspan="8"><strong>El medico veterinario responsable, certifica haber declarado PARTO EN CORRALES durante el tiempo de<br> cuarentena del animal con la siguiente identificacion:</strong></td>
    </tr>
    <tr>
        <td><strong>HIERRO</strong></td>
        <td colspan="2">{{ $data['iron'] }}</td>
        <td colspan="2"><strong>Ubicación en corral</strong></td>
        <td colspan="3">{{ $data['corral_location'] }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Procedencia:</strong></td>
        <td colspan="6">{{ $data['location'] }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Guia sanitaria de movilizacion: </strong></td>
        <td colspan="6">{{ $data['guide'] }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Peso: </strong></td>
        <td colspan="6">{{ $data['weight'] }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Temperatura: </strong></td>
        <td colspan="6">{{ $data['temperature'] }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Frecuencia cardiaca: </strong></td>
        <td colspan="6">{{ $data['heart_frequency'] }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Frecuencia Respiratoria: </strong></td>
        <td colspan="6">{{ $data['respiratory_frequency'] }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Hallazgos: </strong></td>
        <td colspan="6">{{ $data['findings'] }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Disposición final del feto: </strong></td>
        <td colspan="6">{{ $data['final_definition_feto'] }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>OBSERVACIONES: </strong></td>
        <td colspan="6">{{ $data['observations'] }}</td>
    </tr>
</table>