<table border="1">
    <tr>
        <td colspan="4"></td>
        <td colspan="13">
            MATRIZ INFORMACION DIARIA DE BOVINOS <br>
            Sistema Integral de Gestión de la Calidad e inocuidad de los alimentos.
        </td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td colspan="3">código: PBA-PE-GC-GCL-MT-01</td>
        <td colspan="2">versión: 3</td>
        <td colspan="6">fecha de emisión: JULIO 2022</td>
        <td colspan="6"></td>
        <td colspan="2" rowspan="2"></td>
    </tr>
    <tr>
        <td colspan="4"><b>FECHA DE BENEFICIO: {{ $benefit_date }}</b></td>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td rowspan="2"><b>FECHA INGRESO</b></td>
        <td rowspan="2"><b>CÓDIGO ASIGNADO</b></td>
        <td rowspan="2"><b>NO GUIA</b></td>
        <td rowspan="2"><b>HORA DE INGRESO</b></td>
        <td colspan="2"><b>TOTAL</b></td>
        <td rowspan="2"><b>EDAD</b></td>
        <td rowspan="2"><b>SEXO</b></td>
        <td rowspan="2"><b>PROPÓSITO</b></td>
        <td rowspan="2"><b>COLOR</b></td>
        <td rowspan="2"><b>No. EXPENDIOS</b></td>
        <td rowspan="2"><b>HORA DE INGRESO CORRALES DE SACRIFICIO</b></td>
        <td rowspan="2"><b>FECHA DE BENEFICIO</b></td>
        <td rowspan="2"><b>NOMBRE DEL PROPIETARIO</b></td>
        <td rowspan="2"><b>IDENTIFICACION CEDULA</b></td>
        <td rowspan="2"><b>NOMBRE DEL COMPRADOR</b></td>
        <td rowspan="2"><b>NOMBRE DEL PREDIO</b></td>
        <td colspan="2"><b>PROCEDENCIA</b></td>
    </tr>
    <tr>
        <td><b>M</b></td>
        <td><b>H</b></td>
        <td><b>MUNICIPIO</b></td>
        <td><b>DEPARTAMENTO</b></td>
    </tr>
    @php
        $total_males = 0;
        $total_females = 0;
    @endphp
    @foreach($data as $income)
        @php
            $male = 0;
            $female = 0;
            if($income->id_gender === 1) 
                $male = 1;
            else 
                $female = 1;
    
            $total_males += $male;
            $total_females += $female;
        @endphp
    <tr>
        <td>{{ $income->date_entry }}</td>
        <td>{{ $income->asigned_code }}</td>
        <td>{{ $income->no_guide }}</td>
        <td>{{ $income->time_entry }}</td>
        <td>{{ $male }}</td>
        <td>{{ $female }}</td>
        <td>{{ $income->age }}</td>
        <td>{{ $income->gender }}</td>
        <td>{{ $income->purpose }}</td>
        <td>{{ $income->color }}</td>
        <td>{{ $income->outlet }}</td>
        <td></td>
        <td>{{ $income->sacrifice_date }}</td>
        <td>{{ $income->owner }}</td>
        <td>{{ $income->owner_document }}</td>
        <td>{{ $income->buyer }}</td>
        <td>{{ $income->establishment_name }}</td>
        <td>{{ $income->source_city }}</td>
        <td>{{ $income->source_department }}</td>
    </tr>
    @endforeach
    <tr>
        <td colspan="4"></td>
        <td>{{ $total_males }}</td>
        <td>{{ $total_females }}</td>
    </tr>
    <tr>
        <td colspan="4"><b>TOTAL BOVINOS EN RECEPCION</b></td>
        <td colspan="2"> {{ $total_males + $total_females }} </td>
    </tr>
</table>