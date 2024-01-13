<table border="1">
    <tr>
        <td colspan="3" class="logo"></td>
        <td colspan="36" class="center">
            FORMATO INSPECCIÓN POST MORTEM 
            <br>
            <strong>Sistema Integral de Gestión de la Calidad e inocuidad<br> de los alimentos.</strong>
        </td>
        <td colspan="4">
            <b>PBA</b> <br>
            Planta de Beneficio Animal
        </td>
    </tr>
    <tr>
        <td colspan="5">Código: PBA-PM-PB-BOV-PLA-13</td>
        <td colspan="2">versión: 3</td>
        <td colspan="32">Fecha de emisión 05/12/2021</td>
        <td colspan="4">Página 1</td>
    </tr>
    <tr>
        <td colspan="7"><b>FECHA: {{ $general['date'] }}</b></td>
        <td colspan="12"><b>RESPONSABLE: {{ $general['responsable'] }}</b></td>
        <td colspan="24"></td>
    </tr>
    <tr>
        <td rowspan="2" colspan="2">NUMERO EXPENDIO</td>
        <td rowspan="2">CÓDIGO CONSECUTIVO</td>
        <td colspan="2"><strong>CABEZA</strong></td>
        <td colspan="2"><strong>INT. DELGADO</strong></td>
        <td colspan="2"><strong>INT. GRUESO</strong></td>
        <td colspan="2"><strong>OMENTO</strong></td>
        <td colspan="2"><strong>CUAJO</strong></td>
        <td colspan="2"><strong>CALLO</strong></td>
        <td colspan="2"><strong>HÍGADO</strong></td>
        <td colspan="2"><strong>PULMONES</strong></td>
        <td colspan="2"><strong>UBRES</strong></td>
        <td colspan="2"><strong>PATAS</strong></td>
        <td colspan="2"><strong>MANOS</strong></td>
        <td colspan="2"><strong>RIÑÓN</strong></td>
        <td colspan="2"><strong>CORAZÓN</strong></td>
        <td colspan="2"><strong>LIBRILLO</strong></td>
        <td colspan="2"><strong>VISCERA BLANCA</strong></td>
        <td colspan="2"><strong>VISCERA ROJA</strong></td>
        <td colspan="2"><strong>DESPURGOS</strong></td>
        <td colspan="2"><strong>CANAL</strong></td>
        <td colspan="4"><strong>OTROS</strong></td>
    </tr>
    <tr>
        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>ÓRGANO</td>
        <td>CAUSA</td>
        <td>CANT</td>
        <td>INSP. GANGLIOS</td>
    </tr>
    @foreach($data as $key => $element)
    <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ $element->dailyPayroll->outlet->code }}</td>
        <td>{{ $element->dailyPayroll->incomeForm->code }}</td>

        <td>{{ $element->head?->name }}</td>
        <td>{{ $element->head_quantity }}</td>

        <td>{{ $element->small_ints?->name }}</td>
        <td>{{ $element->small_ints_quantity }}</td>

        <td>{{ $element->large_ints?->name }}</td>
        <td>{{ $element->large_ints_quantity }}</td>

        <td>{{ $element->oment?->name }}</td>
        <td>{{ $element->oment_quantity }}</td>

        <td>{{ $element->renet?->name }}</td>
        <td>{{ $element->renet_quantity }}</td>

        <td>{{ $element->callus?->name }}</td>
        <td>{{ $element->callus_quantity }}</td>

        <td>{{ $element->liver_cause?->name }}</td>
        <td>{{ $element->liver_quantity }}</td>

        <td>{{ $element->lungs_cause?->name }}</td>
        <td>{{ $element->lungs_quantity }}</td>

        <td>{{ $element->legs?->name }}</td>
        <td>{{ $element->legs_quantity }}</td>

        <td>{{ $element->hands?->name }}</td>
        <td>{{ $element->hands_quantity }}</td>

        <td>{{ $element->udder?->name }}</td>
        <td>{{ $element->udder_quantity }}</td>

        <td>{{ $element->kidney?->name }}</td>
        <td>{{ $element->kidney_quantity }}</td>

        <td>{{ $element->heart?->name }}</td>
        <td>{{ $element->heart_quantity }}</td>

        <td>{{ $element->booklet?->name }}</td>
        <td>{{ $element->booklet_quantity }}</td>

        <td>{{ $element->white_viscera?->name }}</td>
        <td>{{ $element->white_viscera_quantity }}</td>

        <td>{{ $element->red_viscera?->name }}</td>
        <td>{{ $element->red_viscera_quantity }}</td>

        <td>{{ $element->destocking?->name }}</td>
        <td>{{ $element->destocking_quantity }}</td>

        <td>{{ $element->canal?->name }}</td>
        <td>{{ $element->canal_quantity }}</td>

        <td>{{ $element->other_organ }}</td>
        <td>{{ $element->other_cause?->name }}</td>
        <td>{{ $element->other_quantity }}</td>
        <td>{{ $element->insp_ganglions }}</td>
    </tr>
    @endforeach
</table>