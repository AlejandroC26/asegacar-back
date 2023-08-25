<table border="1">
    <tr>
        <td colspan="2" class="logo"></td>
        <td colspan="3" class="center">
            <strong>Sistema integral de gestion de la Calidad e<br> Inocuidad de los alimentos.</strong><br>
            <br>
            <strong>PLANILLA ORDEN DE BENEFICIO</strong>
            
        </td>
        <td>
            <b>PBA</b> <br>
            Planta de Beneficio Animal
        </td>
    </tr>
    <tr>
        <td colspan="3">código: PBA-PM-PB-BOV-PLA-02</td>
        <td>versión: 2</td>
        <td>Fecha de vigencia:MAYO-2018</td>
        <td>Página 1</td>
    </tr>
    <tr>
        <td colspan="6"><b>FECHA: VIERNES 16 DE DICIEMBRE DE 2022</b></td>
    </tr>
    <tr>
        <td></td>
        <td><strong>N° EXPENDIO</strong></td>
        <td colspan="3"><strong>CÓDIGO</strong></td>
        <td></td>
    </tr>
    @foreach($data as $key => $income)
    <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ $income->dailyPayroll->outlet->code }}</td>
        <td 
            colspan="3"
        >{{ $income->dailyPayroll->code }}</td>
        <td></td>
    </tr>
    @endforeach
    <tr>
        <td colspan="2">______________________________</td>
    </tr>
    <tr>
        <td colspan="2"><strong></strong></td>
    </tr>
    <tr>
        <td colspan="2"><strong>JEFE OPERATIVO</strong></td>
    </tr>
    <tr>
        <td colspan="2"><strong>RESPONSABLE</strong></td>
    </tr>
</table>