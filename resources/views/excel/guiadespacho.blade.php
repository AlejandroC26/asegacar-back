<table border="1">
    <tr>
      <td colspan="7" rowspan="2"></td>
      <td colspan="10"><b>ÚNICAMENTE PARA CONSUMO LOCAL EN EL MUNICIPIO DE PITALITO</b></td>
    </tr>
    <tr>
      <td colspan="10"><b>GUÍA DE TRANSPORTE CARNE EN CANAL Y PRODUCTOS CÁRNICOS COMESTIBLES</b></td>
    </tr>
    <tr>
      <td colspan="4">FECHA DE EXPEDICIÓN</td>
      <td rowspan="2"></td>
      <td colspan="3">FECHA DE SACRIFICIO</td>
      <td rowspan="2"></td>
      <td>Cod. INVIMA</td>
      <td rowspan="2" colspan="2"><b>{{ $config['dispatch_guide']->code }}</b></td>
      <td rowspan="2"><b>{{ $config['year'] }}</b></td>
      <td rowspan="2" colspan="4"></td>
    </tr>
    <tr>
      <td colspan="2"><b>{{ $config['expedition_date']['day'] }}</b></td>
      <td><b>{{ $config['expedition_date']['month'] }}</b></td>
      <td><b>{{ $config['expedition_date']['year'] }}</b></td>

      <td><b>{{ $config['sacrifice_date']['day'] }}</b></td>
      <td><b>{{ $config['sacrifice_date']['month'] }}</b></td>
      <td><b>{{ $config['sacrifice_date']['year'] }}</b></td>

      <td><b>393AB</b></td>
    </tr>
    <tr>
      <td colspan="17"><b>1. IDENTIFICACIÓN DE LA PLANTA DE BENEFICIO DE PROCEDENCIA.</b></td>
    </tr>
    <tr>
      <td colspan="10"><b>Planta de beneficio de ganado bovino del municipio de Pitalito</b></td>
      <td colspan="2">Ciudad o municipio</td>
      <td colspan="5"><b>{{ $config['company']->city->name }}</b></td>
    </tr>
    <tr>
      <td colspan="4">Departamento</td>
      <td colspan="6"><b>{{ $config['company']->city->department->name }}</b></td>
      <td colspan="2">Dirección o ubicación</td>
      <td colspan="5"><b>{{ $config['company']->adress }}</b></td>
    </tr>
    <tr>
      <td colspan="3">Teléfono</td>
      <td colspan="3"><b>{{ $config['company']->phone }}</b></td>
      <td colspan="4">Hora de despacho</td>
      <td colspan="7">{{ $config['dispatch_time'] == 'AM' ? 'A.M' : 'P.M'}}</td>
    </tr>
    <tr>
      <td colspan="17"><b>2. IDENTIFICACIÓN DEL ESTABLECIMIENTO DESTINO.</b></td>
    </tr>
    <tr>
      <td colspan="6">Nombre del establecimiento:</td>
      <td colspan="4">{{ $config['outlet']->establishment_name }}</td>
      <td colspan="2">Dirección  de establecimiento:</td>
      <td colspan="5">{{ $config['outlet']->establishment_address }}</td>
    </tr>
    <tr>
      <td colspan="3">Municipio</td>
      <td colspan="3"><b>{{ $config['outlet']->city->name }}</b></td>
      <td colspan="2">Departamento</td>
      <td colspan="2"><b>{{ $config['outlet']->city->department->name }}</b></td>
      <td colspan="2">Código expendio:</td>
      <td colspan="5">{{ $config['outlet']->code }}</td>
    </tr>
    <tr>
      <td colspan="4"><b>3. TIPO DE PRODUCTO</b></td>
      <td colspan="3"></td>
      <td colspan="2"><b>ESPECIE</b></td>
      <td colspan="2">BOVINA</td>
      <td colspan="2"></td>
      <td colspan="4"></td>
    </tr>
    <tr>
      <td><b>Id</b></td>
      <td colspan="5"><b>Producto</b></td>
      <td><b>Lote</b></td>
      <td colspan="3"><b>Unidades</b></td>
      <td><b>Peso (Kg)</b></td>
      <td><b>Temperatura promedio</b></td>
      <td colspan="5"><b>CODIGOS DEL ANIMAL (ES)</b></td>
    </tr>
    <tr>
      <td>1</td>
      <td colspan="5">Carne en canal</td>
      <td>{{ $config['sacrifice_date']['complete'] }}</td>
      <td colspan="3"><b>{{ $data['products'][1] ?? 0 }}</b></td>
      <td></td>
      <td rowspan="8"><b>{{ $config['dispatch_guide']->average_temperature }}</b></td>
      <td colspan="5" rowspan="8">{{ implode(',', $data['codes']) }}</td>
    </tr>
    <tr>
      <td>2</td>
      <td colspan="5">Carne en media canal</td>
      <td>{{ $config['sacrifice_date']['complete'] }}</td>
      <td colspan="3"><b>{{ $data['products'][2] ?? 0 }}</b></td>
      <td></td>
    </tr>
    <tr>
      <td>3</td>
      <td colspan="5">Carne en cuartos de canal</td>
      <td>{{ $config['sacrifice_date']['complete'] }}</td>
      <td colspan="3"><b>{{ $data['products'][3] ?? 0 }}</b></td>
      <td></td>
    </tr>
    <tr>
      <td>4</td>
      <td colspan="5">Viscera blanca</td>
      <td>{{ $config['sacrifice_date']['complete'] }}</td>
      <td colspan="3"><b>{{ $config['dispatch_guide']->white_viscera ?? 0 }}</b></td>
      <td></td>
    </tr>
    <tr>
      <td>5</td>
      <td colspan="5">Viscera roja</td>
      <td>{{ $config['sacrifice_date']['complete'] }}</td>
      <td colspan="3"><b>{{ $config['dispatch_guide']->red_viscera ?? 0 }}</b></td>
      <td></td>
    </tr>
    <tr>
      <td>6</td>
      <td colspan="5">Cabezas</td>
      <td>{{ $config['sacrifice_date']['complete'] }}</td>
      <td colspan="3"><b>{{ $config['dispatch_guide']->heads ?? 0 }}</b></td>
      <td></td>
    </tr>
    <tr>
      <td>7</td>
      <td colspan="5">Patas</td>
      <td>{{ $config['sacrifice_date']['complete'] }}</td>
      <td colspan="3"><b>{{ $config['dispatch_guide']->legs ?? 0 }}</b></td>
      <td></td>
    </tr>
    <tr>
      <td>8</td>
      <td colspan="5">Otros</td>
      <td>{{ $config['sacrifice_date']['complete'] }}</td>
      <td colspan="3"><b>{{ $config['dispatch_guide']->others ?? 0 }}</b></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="17"> Dictamen del producto: APROBADO ( {{ $config['dispatch_guide']->approved ? 'X' : ' ' }} ) APROBADO CONDICIONAL ( {{ !$config['dispatch_guide']->approved ? 'X' : ' ' }} )</td>
    </tr>
    <tr>
      <td colspan="17">OBSERVACIONES:  {{ $config['dispatch_guide']->observations }} </td>
    </tr>
    <tr>
      <td colspan="17"><b>3.1 PRODUCTOS RETENIDOS</b></td>
    </tr>
    <tr>
      <td><b>ID</b></td>
      <td colspan="5"><b>CODIGOS DEL ANIMAL (ES)</b></td>
      <td><b>LOTE</b></td>
      <td colspan="3"><b>CAUSA</b></td>
      <td colspan="2"><b>CANTIDAD</b></td>
      <td colspan="5"><b>PRODUCTO</b></td>
    </tr>
    @if (!count($data['inspections']))
    <tr>
      <td></td>
      <td colspan="5"></td>
      <td></td>
      <td colspan="3"></td>
      <td colspan="2"></td>
      <td colspan="5"></td>
    </tr>
    @endif
    @foreach ($data['inspections'] as $key => $inspection)
    <tr>
      <td>{{ $key + 1 }}</td>
      <td colspan="5">{{ $inspection['code'] }}</td>
      <td>{{ $inspection['sacrifice_date'] }}</td>
      <td colspan="3">{{ $inspection['cause'] }}</td>
      <td colspan="2">{{ $inspection['value'] }}</td>
      <td colspan="5">{{ $inspection['field'] }}</td>
    </tr>
    @endforeach
    <tr>
      <td colspan="17"><b>4. VEHÍCULO TRANSPORTADOR</b></td>
    </tr>
    <tr>
      <td colspan="4">Tipo de vehículo:</td>
      <td colspan="4">Furgón</td>
      <td colspan="2">Placa: {{ $config['vehicle']->plate }}</td>
      <td colspan="3">Conductor: {{ $config['vehicle']->driver_name }}</td>
      <td colspan="4">CC: {{ $config['vehicle']->driver_document }}</td>
    </tr>
    <tr>
      <td colspan="6">Sistema de conservación:</td>
      <td colspan="3">{{ $config['vehicle']->refrigerated }}</td>
      <td colspan="2">Isotermo: {{ $config['vehicle']->isothermal }}</td>
      <td colspan="2">Temperatura promedio:</td>
      <td colspan="4">{{ $config['vehicle']->temperature }}</td>
    </tr>
    <tr>
      <td colspan="17"><b>5. CIERRE DE GUÍA</b></td>
    </tr>
    <tr>
      <td colspan="4">FECHA DE CIERRE</td>
      <td rowspan="2"></td>
      <td colspan="3">HORA DE CIERRE</td>
      <td rowspan="2"></td>
      <td>Responsable:</td>
      <td colspan="7"></td>
    </tr>
    <tr>
      <td colspan="2"><b>{{ $config['closing_date']['day'] }}</b></td>
      <td><b>{{ $config['closing_date']['month'] }}</b></td>
      <td><b>{{ $config['closing_date']['year'] }}</b></td>

      <td colspan="3">{{ date_format(date_create($config['dispatch_guide']->closing_time), 'H:i') }}</td>
      <td>Cargo:</td>
      <td></td>
      <td colspan="2">Tel. </td>
      <td>Firma:</td>
      <td colspan="3"></td>
    </tr>
    <tr>
      <td colspan="3"><b>Recibe:</b></td>
      <td colspan="5"></td>
      <td></td>
      <td>C.C</td>
      <td colspan="3"></td>
      <td>Firma:</td>
      <td colspan="3"></td>
    </tr>
  </table>