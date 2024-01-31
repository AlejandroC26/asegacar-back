<table border="1">
    <tr>
        <td colspan="2" class="logo"></td>
        <td colspan="15" class="center">
            FORMATO COMPARACION DECOMISOS
            <br>
            <strong>Sistema Integral de Gestión de la Calidad e inocuidad<br> de los alimentos.</strong>
        </td>
        <td colspan="2">
            <b>PBA</b> <br>
            Planta de Beneficio Animal
        </td>
    </tr>
    <tr>
        <td colspan="3">Código:	PBA-PM-PB-BOV-FOR-16</td>
        <td colspan="2">versión: 1</td>
        <td colspan="12">Fecha de emision:24/01/2022</td>
        <td colspan="2">Página 1</td>
    </tr>
    <tr>
        <td colspan="1"><b>FECHA: </b></td>
        <td colspan="9">{{ $general['date'] }}</td>
    </tr>
    <tr>
        <td><strong>CABEZA</strong></td>
        <td><strong>INT. DELGADO</strong></td>
        <td><strong>INT. GRUESO</strong></td>
        <td><strong>OMENTO</strong></td>
        <td><strong>CUAJO</strong></td>
        <td><strong>CALLO</strong></td>
        <td><strong>HÍGADO</strong></td>
        <td><strong>PULMONES</strong></td>
        <td><strong>UBRES</strong></td>
        <td><strong>PATAS</strong></td>
        <td><strong>MANOS</strong></td>
        <td><strong>RIÑÓN</strong></td>
        <td><strong>CORAZÓN</strong></td>
        <td><strong>LIBRILLO</strong></td>
        <td><strong>VISCERA BLANCA</strong></td>
        <td><strong>VISCERA ROJA</strong></td>
        <td><strong>DESPURGOS</strong></td>
        <td><strong>CANAL</strong></td>
        <td><strong>OTROS</strong></td>
    </tr>
    @foreach($data as $element)
    <tr>
        <td>{{ $element->head_quantity }}</td>
        <td>{{ $element->small_ints_quantity }}</td>
        <td>{{ $element->large_ints_quantity }}</td>
        <td>{{ $element->oment_quantity }}</td>
        <td>{{ $element->renet_quantity }}</td>
        <td>{{ $element->callus_quantity }}</td>
        <td>{{ $element->liver_quantity }}</td>
        <td>{{ $element->lungs_quantity }}</td>
        <td>{{ $element->legs_quantity }}</td>
        <td>{{ $element->hands_quantity }}</td>
        <td>{{ $element->udder_quantity }}</td>
        <td>{{ $element->kidney_quantity }}</td>
        <td>{{ $element->heart_quantity }}</td>
        <td>{{ $element->booklet_quantity }}</td>
        <td>{{ $element->white_viscera_quantity }}</td>
        <td>{{ $element->red_viscera_quantity }}</td>
        <td>{{ $element->destocking_quantity }}</td>
        <td>{{ $element->canal_quantity }}</td>
        <td>{{ $element->other_quantity }}</td>
    </tr>
    @endforeach
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <td><b>RESPONSABLE:</b></td>
        <td colspan="3">{{ $general['responsable']?->fullname }}</td>
        <td></td>
        <td><b>SUPERVISO:</b></td>
        <td colspan="3"> {{ $general['supervised_by']->fullname }}</td>
    </tr>
</table>