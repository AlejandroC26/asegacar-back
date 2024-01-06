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
      <td colspan="3">_____________</td>
      <td colspan="2">Departamento</td>
      <td colspan="2">_____________</td>
      <td colspan="2">Código expendio:</td>
      <td colspan="5">{{ $config['outlet']->code }}</td>
    </tr>
    <tr>
      <td colspan="17">3. PRODUCTOS RETENIDOS</td>
    </tr>
    <tr>
      <td>Id</td>
      <td colspan="3">CÓDIGO DEL ANIMAL</td>
      <td colspan="3">LOTE</td>
      <td colspan="3">CAUSA</td>
      <td colspan="2">CANTIDAD</td>
      <td colspan="5">PRODUCTO</td>
    </tr>
    @foreach ($data['codes'] as $key => $code)
    <tr>
      <td>{{$key+1}}</td>
      <td colspan="3">{{ $code }}</td>
      <td colspan="3">{{ $config['sacrifice_date']['complete'] }}</td>
      <td colspan="3"></td>
      <td colspan="2"></td>
      <td colspan="5"></td>
    </tr>
    @endforeach
    <tr>
      <td colspan="12">Observaciones: </td>
      <td colspan="5">Veterinario:</td>
    </tr>
  </table>