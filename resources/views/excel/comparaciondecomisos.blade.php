<table border="1">
    <tr>
        <td colspan="2" class="logo"></td>
        <td colspan="6" class="center">
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
        <td colspan="3">Fecha de emision:24/01/2022</td>
        <td colspan="2">Página 1</td>
    </tr>
    <tr>
        <td colspan="1"><b>FECHA: </b></td>
        <td colspan="9"></td>
    </tr>
    <tr>
        <td><strong>INT. DELGADO</strong></td>
        <td><strong>INT. GRUESO</strong></td>
        <td><strong>HIGADO</strong></td>
        <td><strong>PULMONES</strong></td>
        <td><strong>UBRE</strong></td>
        <td><strong>CABEZA</strong></td>
        <td><strong>MANOS</strong></td>
        <td><strong>PATAS</strong></td>
        <td><strong>OTROS</strong></td>
        <td><strong>DESPURGOS</strong></td>
    </tr>
    @foreach($data as $element)
    <tr>
        <td>{{ $element->small_ints }}</td>
        <td>{{ $element->large_ints }}</td>
        <td>{{ $element->liver }}</td>
        <td>{{ $element->lung }}</td>
        <td>{{ $element->udders }}</td>
        <td>{{ $element->head }}</td>
        <td>{{ $element->hands }}</td>
        <td>{{ $element->legs }}</td>
        <td>{{ $element->others }}</td>
        <td>{{ $element->destocking }}</td>
    </tr>
    @endforeach
    <tr><td></td></tr>
    <tr>
        <td colspan="4">RESPONSABLE: ________________</td>
        <td colspan="2"></td>
        <td colspan="4">SUPERVISO: _______________</td>
    </tr>
</table>