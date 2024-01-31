<table border="1">
    <tr>
        <td colspan="3" class="logo"></td>
        <td colspan="6" class="center">
            <strong>BENEFICIO DE ANIMALES SOSPECHOSOS</strong><br>
            <strong>Sistema integral de gestion de la Calidad e<br> Inocuidad de los alimentos.</strong><br>
        </td>
        <td colspan="2">
            <b>PBA</b> <br>
            Planta de Beneficio Animal
        </td>
    </tr>
    <tr>
        <td colspan="3"><strong>CODIGO: PBA-PM-PB-BOV-FOR-06</strong></td>
        <td colspan="3"><strong>VERSIÓN: 1</strong></td>
        <td colspan="5"><strong>FECHA DE EMISION: ENERO 2021</strong></td>
    </tr>
    <tr>
        <td colspan="11"></td>
    </tr>
    <tr>
        <td><strong>FECHA:</strong></td>
        <td colspan="5">{{ $data['date'] }}</td>
        <td><strong>HORA:</strong></td>
        <td colspan="4">{{ $data['time'] }} </td>
    </tr>
    <tr>
        <td colspan="2"><strong>SUPERVISO:</strong></td>
        <td colspan="4">{{ $data['supervisor'] }}</td>
        <td colspan="2"><strong>RESPONSABLE:</strong></td>
        <td colspan="3">{{ $data['responsable'] }}</td>
    </tr>
    <tr>
        <td colspan="11"></td>
    </tr>
    <tr>
        <td colspan="3"><strong>MEDICO VETERINARIO RESPONSABLE:</strong></td>
        <td colspan="10"> {{ $data['veterinary'] }}</td>
    </tr>
    <tr>
        <td colspan="3"><strong>PROPIETARIO DEL ANIMAL:</strong></td>
        <td colspan="11"> {{ $data['owner'] }}</td>
    </tr>
    <tr>
        <td colspan="11"><strong>FIRMA: </strong></td>
    </tr>
    <tr>
        <td colspan="11"><strong>El medico veterinario responsable,certifica haber declarado SOSPECHOSO, durante la inspeccion ANTE MORTEM al animal con la siguiente indicacion:</strong></td>
    </tr>
    <tr>
        <td><strong>HIERRO</strong></td>
        <td colspan="4">{{ $data['iron'] }}</td>
        <td colspan="2"><strong>Ubicación en corral</strong></td>
        <td colspan="4">{{ $data['corral_location'] }}</td>
    </tr>
    <tr>
        <td colspan="11"><strong>Procedencia: {{ $data['location'] }}</strong></td>
    </tr>
    <tr>
        <td colspan="11"><strong>Guia sanitaria de movilizacion: {{ $data['guide'] }}</strong></td>
    </tr>
    <tr>
        <td><strong>SEXO:</strong></td>
        <td><strong>M</strong></td>
        <td>{{ $data['id_gender'] === 1 ? 'X' : '' }}</td>
        <td><strong>H</strong></td>
        <td colspan="7"> {{ $data['id_gender'] === 2 ? 'X' : '' }}</td>
    </tr>
    <tr>
        <td><strong>PESO:</strong></td>
        <td colspan="2">{{ $data['weight'] }}</td>
        <td><strong>T°:</strong></td>
        <td>{{ $data['temperature'] }}</td>
        <td><strong>FC:</strong></td>
        <td>{{ $data['heart_frequency'] }}</td>
        <td><strong>FR:</strong></td>
        <td colspan="3">{{ $data['respiratory_frequency'] }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>HALLAZGOS: </strong></td>
        <td colspan="9">{{ $data['findings'] }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>OBSERVACIONES: </strong></td>
        <td colspan="9">{{ $data['observations'] }}</td>
    </tr>
</table>