<table border="1">
    <tr>
        <td colspan="4"></td>
        <td colspan="10" class="center">
            FORMATO DE VIGILANCIA Y VERIFICACON DE LAS OPERACIONES SANITARIAS DURANTE EL PROCESO DE BENEFICIO ANIMAL. TOLERANCIA CERO Y ACONDICIONAMIENTO DE LA CANAL.
            <br>
            <strong>Sistema Integral de Gestión de la Calidad e inocuidad<br> de los alimentos.</strong>
        </td>
        <td colspan="4">
            <b>PBA</b> <br>
            Planta de Beneficio Animal
        </td>
    </tr>
    <tr>
        <td colspan="6">Código:	PBA-PM-PB-BOV-FOR-03</td>
        <td colspan="2">versión: 4</td>
        <td colspan="6">Fecha de emisión: AGOSTO 2022</td>
        <td colspan="4">Página 1</td>
    </tr>
    <tr>
        <td colspan="7"><b>FECHA: {{ $general['date'] }}</b></td>
        <td colspan="1"></td>
        <td colspan="10"><b>RESPONSABLE: {{ $general['responsable'] }}</b></td>
    </tr>
    <tr>
        <td colspan="7"><strong>INSPECCION CERO TOLERANCIA</strong></td>
        <td></td>
        <td colspan="10"><strong>ACONDICIONAMIENTO DE LA CANAL</strong></td>
    </tr>
    <tr>
        <td><strong>COD. EXPENDIO</strong></td>
        <td><strong>CONSECUTIVO</strong></td>
        <td><strong>LECHE</strong></td>
        <td><strong>MATERIA FECAL</strong></td>
        <td><strong>CONTENIDO RUMINAL</strong></td>
        <td><strong>ACCIONES CORRECTIVAS</strong></td>
        <td><strong>CANTIDAD</strong></td>

        <td></td>

        <td><strong>COD. EXPENDIO</strong></td>
        <td><strong>CONSECUTIVO</strong></td>
        <td><strong>PIEL</strong></td>
        <td><strong>PELO</strong></td>
        <td><strong>HEM</strong></td>
        <td><strong>ABS</strong></td>
        <td><strong>PARASITO</strong></td>
        <td><strong>OTROS</strong></td>
        <td><strong>CORRECCION</strong></td>
        <td><strong>CANTIDAD</strong></td>
    </tr>
    @php
    $max = max(count($data['zeroToleranceInspection']), count($data['channelConditioning']));
    @endphp

    @for ($i = 0; $i < $max; $i++)
    @php
        $channel = null;
        $element = null;
        if (isset($data['zeroToleranceInspection'][$i])) {
            $element = $data['zeroToleranceInspection'][$i];
        }
        if (isset($data['channelConditioning'][$i])) {
            $channel = $data['channelConditioning'][$i];
        } 
    @endphp
    <tr>
        <td>{{ $element?->dailyPayroll->outlet->code }}</td>
        <td>{{ $element?->dailyPayroll->incomeForm->code }}</td>
        <td>{{ $element?->milk }}</td>
        <td>{{ $element?->fecal_matter }}</td>
        <td>{{ $element?->rumen_content }}</td>
        <td>{{ $element?->corrective_actions }}</td>
        <td>{{ $element?->quantity }}</td>

        <td></td>

        <td>{{ $channel?->dailyPayroll->outlet->code }}</td>
        <td>{{ $channel?->dailyPayroll->incomeForm->code }}</td>
        <td>{{ $channel?->outlet }}</td>
        <td>{{ $channel?->code }}</td>
        <td>{{ $channel?->skin }}</td>
        <td>{{ $channel?->hair }}</td>
        <td>{{ $channel?->hematoma }}</td>
        <td>{{ $channel?->abscess }}</td>
        <td>{{ $channel?->parasite }}</td>
        <td>{{ $channel?->other }}</td>
        <td>{{ $channel?->correction }}</td>
        <td>{{ $channel?->quantity }}</td>
    </tr>
    @endfor
    <tr><td></td></tr>
    <tr>
        <td colspan="18"><strong>OBSERVACIONES:</strong></td>
    </tr>
    <tr><td></td></tr>
    <tr>
        <td colspan="3">VERIFICADO POR: {{ $general['verified_by'] }}</td>
        <td colspan="1"></td>
        <td colspan="3">SUPERVISADO POR: {{ $general['supervised_by'] }}</td>
    </tr>
</table>