<table border="1">
    <tr>
        <td colspan="4" class="logo"></td>
        <td colspan="9" class="center">
            FORMATO VERIFICACION SALIDA DE PRODUCTOS(VISCERAS)
            <br>
            <strong>Sistema Integral de Gestión de la Calidad e inocuidad<br> de los alimentos.</strong>
        </td>
        <td colspan="3">
            <b>PBA</b> <br>
            Planta de Beneficio Animal
        </td>
    </tr>
    <tr>
        <td colspan="6">Codigo:PBA-PE-GC-GCL-FOR-22</td>
        <td colspan="2">versión: 3</td>
        <td colspan="6">Fecha de emisión DICIEMBRE 2022</td>
        <td colspan="2">Página 1</td>
    </tr>
    <tr>
        <td colspan="2"><b>FECHA: </b></td>
        <td colspan="14"></td>
    </tr>
    <tr>
        <td></td>
        <td><strong>FAMA</strong></td>
        <td><strong>CODIGO</strong></td>
        <td><strong>CAB</strong></td>
        <td><strong>INT.DEL</strong></td>
        <td><strong>INT.GR</strong></td>
        <td><strong>PAÑ</strong></td>
        <td><strong>CUAJ</strong></td>
        <td><strong>CALL</strong></td>
        <td><strong>HIG</strong></td>
        <td><strong>PUL</strong></td>
        <td><strong>PAT</strong></td>
        <td><strong>PAN</strong></td>
        <td><strong>UBR</strong></td>
        <td><strong>LIBR</strong></td>
        <td><strong>OBSERVACIONES</strong></td>
    </tr>
    @foreach($data as $key => $element)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $element->dailyPayroll->outlet->code }}</td>
        <td>{{ $element->dailyPayroll->code }}</td>
        <td>{{ $element->head }}</td>
        <td>{{ $element->small_ints }}</td>
        <td>{{ $element->large_ints }}</td>
        <td>{{ $element->panolon }}</td>
        <td>{{ $element->rennet }}</td>
        <td>{{ $element->callus }}</td>
        <td>{{ $element->liver }}</td>
        <td>{{ $element->lung }}</td>
        <td>{{ $element->legs }}</td>
        <td>{{ $element->hands }}</td>
        <td>{{ $element->udders }}</td>
        <td>{{ $element->booklet }}</td>
        <td>{{ $element->observations }}</td>
    </tr>
    @endforeach
    <tr>
        <td></td>
        <td colspan="2"><strong>TOTAL DECOMISOS</strong></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td rowspan="2" colspan="2"><strong>COMVENCIONES:</strong></td>
        <td><strong>CAB</strong></td>
        <td><strong>INT.DEL</strong></td>
        <td><strong>INT.GR</strong></td>
        <td><strong>PAÑ</strong></td>
        <td><strong>CUAJ</strong></td>
        <td><strong>CALL</strong></td>
        <td><strong>HIG</strong></td>
        <td><strong>PUL</strong></td>
        <td><strong>PAT</strong></td>
        <td><strong>PAN</strong></td>
        <td><strong>UBR</strong></td>
        <td><strong>LIBR</strong></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>Cabeza</td>
        <td>Intestino delgado</td>
        <td>Intestino grueso</td>
        <td>Pañolon</td>
        <td>Cuajo</td>
        <td>Callo</td>
        <td>Hígado</td>
        <td>Pulmones</td>
        <td>Patas</td>
        <td>Manos</td>
        <td>Ubre</td>
        <td>Librillo</td>
        <td>P. Parcial <br>T. Total</td>
    </tr>
    <tr><td></td></tr>
    <tr>
        <td></td>
        <td colspan="5">ELABORO: ________________</td>
        <td colspan="4"></td>
        <td colspan="5">SUPERVISO: _______________</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="5">CARGO: ________________</td>
        <td colspan="4"></td>
        <td colspan="5">CARGO: _______________</td>
    </tr>
</table>