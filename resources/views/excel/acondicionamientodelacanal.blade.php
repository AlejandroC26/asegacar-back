<table border="1">
    <tr>
        <td colspan="2" class="logo"></td>
        <td colspan="6" class="center">
            FORMATO DE VIGILANCIA Y VERIFICACON DE LAS OPERACIONES SANITARIAS DURANTE EL PROCESO DE BENEFICIO ANIMAL. TOLERANCIA CERO Y ACONDICIONAMIENTO DE LA CANAL.
            <br>
            <strong>Sistema Integral de Gestión de la Calidad e inocuidad<br> de los alimentos.</strong>
        </td>
        <td colspan="2">
            <b>PBA</b> <br>
            Planta de Beneficio Animal
        </td>
    </tr>
    <tr>
        <td colspan="3">Código:	PBA-PM-PB-BOV-FOR-03</td>
        <td colspan="1">versión: 4</td>
        <td colspan="4">Fecha de emisión: AGOSTO 2022</td>
        <td colspan="2">Página 1</td>
    </tr>
    <tr>
        <td colspan="4"><b>FECHA: </b></td>
        <td colspan="2"></td>
        <td colspan="4"><b>RESPONSABLE: </b></td>
    </tr>
    <tr>
        <td colspan="10"><strong>ACONDICIONAMIENTO DE LA CANAL</strong></td>
    </tr>
    <tr>
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
    @foreach($data as $element)
    <tr>
        <td>{{ $element->dailyPayroll->outlet->code }}</td>
        <td>{{ $element->dailyPayroll->code }}</td>
        <td>{{ $element->outlet }}</td>
        <td>{{ $element->code }}</td>
        <td>{{ $element->skin }}</td>
        <td>{{ $element->hair }}</td>
        <td>{{ $element->hematoma }}</td>
        <td>{{ $element->abscess }}</td>
        <td>{{ $element->parasite }}</td>
        <td>{{ $element->other }}</td>
        <td>{{ $element->correction }}</td>
        <td>{{ $element->quantity }}</td>
    </tr>
    @endforeach
    <tr><td></td></tr>
    <tr>
        <td colspan="10"><strong>OBSERVACIONES:</strong></td>
    </tr>
    <tr><td></td></tr>
    <tr>
        <td colspan="4">VERIFICADO POR: ________________</td>
        <td colspan="2"></td>
        <td colspan="4">SUPERVISADO POR: _______________</td>
    </tr>
</table>
</body>