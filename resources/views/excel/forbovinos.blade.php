<table border="1">
    <tr>
        <td class="logo"></td>
        <td colspan="2" class="center">
            Planilla  Diaria de Bovinos <br>
            Sistema Integral de Gestión de la Calidad e inocuidad de los <br>
            alimentos.

        </td>
        <td colspan="4">
            <b>PBA <br>
            Planta de Beneficio Animal</b>
        </td>
    </tr>
    <tr>
        <td colspan="2">código: PBA-PE-GC-GCL-MT01</td>
        <td>versión: 2</td>
        <td>
            <center>fecha de emisión: JULIO 2022</center>
        </td>
        <td><b>M</b></td>
        <td><b>H</b></td>
        <td>Página 1</td>
    </tr>
    <tr>
        <td colspan="3"><b>FECHA: {{ $general['date'] }}</b></td>
        <td><b>CANTIDAD</b></td>
        <td>{{ $males }} </td>
        <td>{{ $females }}  </td>
        <td>{{ ($males + $females )}} </td>
    </tr>
    <tr>
        <td colspan="7">
            <b>PITALITO</b>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><b>EXP</b></td>
        <td><b>CANTIDAD</b></td>
        <td><b>COLOR</b></td>
        <td><b>SEXO</b></td>
        <td><b>ORDEN ESPECIAL</b></td>
        <td></td>
    </tr>
    @php
        $total_males = 0;
        $total_females = 0;
    @endphp
    @foreach($data as $element)
        @php
            $total = $element['total_males'] + $element['total_females'];
        @endphp
    <tr>
        <td></td>
        <td>{{ $element['outlet']['code'] ?? '' }}</td>
        <td>{{ $total }}</td>
        <td>{{ $element['colors'] }}</td>
        <td>{{ $element['genders'] }}</td>
        <td>{{ $element['special_order'] }}</td>
        <td></td>
    </tr>
    @endforeach
</table>