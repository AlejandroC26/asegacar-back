<table border="1">
    <tr>
        <td colspan="2" class="logo"></td>
        <td colspan="4" class="center">
            FORMATO DE VIGILANCIA Y VERIFICACON DE LAS OPERACIONES SANITARIAS DURANTE EL PROCESO DE BENEFICIO ANIMAL. TOLERANCIA CERO Y ACONDICIONAMIENTO DE LA CANAL.
            <br>
            <strong>Sistema Integral de Gestión de la Calidad e inocuidad<br> de los alimentos.</strong>
        </td>
        <td colspan="1">
            <b>PBA</b> <br>
            Planta de Beneficio Animal
        </td>
    </tr>
    <tr>
        <td colspan="3">Código:	PBA-PM-PB-BOV-FOR-03</td>
        <td colspan="1">versión: 4</td>
        <td colspan="2">Fecha de emisión: AGOSTO 2022</td>
        <td colspan="1">Página 1</td>
    </tr>
    <tr>
        <td colspan="3"><b>FECHA: </b></td>
        <td colspan="1"></td>
        <td colspan="3"><b>RESPONSABLE: </b></td>
    </tr>
    <tr>
        <td colspan="7"><strong>INSPECCION CERO TOLERANCIA</strong></td>
    </tr>
    <tr>
        <td><strong>COD. EXPENDIO</strong></td>
        <td><strong>CONSECUTIVO</strong></td>
        <td><strong>LECHE</strong></td>
        <td><strong>MATERIA FECAL</strong></td>
        <td><strong>CONTENIDO RUMINAL</strong></td>
        <td><strong>ACCIONES CORRECTIVAS</strong></td>
        <td><strong>CANTIDAD</strong></td>
    </tr>
    @foreach($data as $element)
    <tr>
        <td>{{ $element->antemortem_daily_record->outlet->code }}</td>
        <td>{{ $element->antemortem_daily_record->code- }}</td>
        <td>{{ $element->milk }}</td>
        <td>{{ $element->fecal_matter }}</td>
        <td>{{ $element->rumen_content }}</td>
        <td>{{ $element->corrective_actions }}</td>
        <td>{{ $element->quantity }}</td>
    </tr>
    @endforeach
    <tr><td></td></tr>
    <tr>
        <td colspan="7"><strong>OBSERVACIONES:</strong></td>
    </tr>
    <tr><td></td></tr>
    <tr>
        <td colspan="3">VERIFICADO POR: ________________</td>
        <td colspan="1"></td>
        <td colspan="3">SUPERVISADO POR: _______________</td>
    </tr>
</table>