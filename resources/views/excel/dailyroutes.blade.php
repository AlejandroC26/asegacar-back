<table border="1">
    <tr>
        <td colspan="2" class="logo"></td>
        <td colspan="3" class="center">
            <strong>RUTAS VEHICULOS DIARIA </strong><br>
            Sistema Integral de Gestión de la Calidad <br>e inocuidad de los alimentos.
            
        </td>
        <td colspan="2">
            <b>PBA</b> <br>
            Planta de Beneficio Animal
        </td>
    </tr>
    <tr>
        <td colspan="3">código: PBA-PE-GC-GCL-MT01</td>
        <td>versión: 2</td>
        <td><center>fecha de emisión: JULIO 2022</center></td>
        <td colspan="2">Página 1</td>
    </tr>
    <tr></tr>
    <tr>
        <td></td>
        <td colspan="6">
            {{ $date }}
        </td>
    </tr>
    <tr>
        <td></td>
        <td>FAMA</td>
        <td># ANIMALES</td>
        <td colspan="2">ORDENES</td>
        <td>TOTAL CANALES</td>
        <td>VEHICULOS</td>
    </tr>
    @php
        $total_sacrificios = 0;
    @endphp
    @foreach($data as $rowKey => $route)
        @php
            $rows = count($route->dailyRoutes);
            $total_canales = 0;
            $vehicles = []
        @endphp
        @foreach ($route->dailyRoutes as $dr)
        @php
            $total_canales += $dr->quantity;
            $total_sacrificios += $dr->quantity;
            $vehicles[] = $dr->vehicle->plate;
        @endphp
        @endforeach
        <tr>
            <td rowspan="{{$rows}}">
                {{ $route->name }}
            </td>
            <td>{{ $route->dailyRoutes[0]->outlet->code }}</td>
            <td>{{ $route->dailyRoutes[0]->quantity }}</td>
            <td colspan="2">{{ $route->dailyRoutes[0]->orders }}</td>
            <td rowspan="{{$rows}}">{{ $total_canales }}</td>
            <td rowspan="{{$rows}}">{{implode(' ', array_unique($vehicles))}}</td>
        </tr>
        @for ($i = 1; $i < $rows; $i++)
        @php
            $element = $route->dailyRoutes[$i];
        @endphp
        <tr>
            <td>{{ $element->outlet->code }}</td>
            <td>{{ $element->quantity }}</td>
            <td colspan="2">{{ $element->orders }}</td>
        </tr>
        @endfor
    @endforeach
    <tr></tr>
    <tr>
        <td></td>
        <td colspan="5">TOTAL SACRIFICIO DIA</td>
        <td>{{ $total_sacrificios }}</td>
    </tr>
</table>