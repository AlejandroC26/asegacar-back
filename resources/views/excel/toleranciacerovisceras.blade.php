<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            font-family: 'Arial';
        }
        table {
            border-collapse: collapse;
        }
        .logo img {
            display: block;
            width: 5.15cm;
            height: 2.17cm;
            margin: .5rem auto;
        }
        .center p {
            align-items: center;
        }
    </style>
</head>
<body>
    <table border="1">
        <tr>
            <td colspan="3" class="logo"></td>
            <td colspan="9" class="center">
                FORMATO DE VIGILANCIA Y VERIFICACON DE LAS OPERACIONES UNITARIAS DURANTE EL PROCESO DE BENEFICIO ANIMAL. TOLERANCIA CERO (subproductos comestibles)
                <br>
                <strong>Sistema Integral de Gestión de la Calidad e inocuidad<br> de los alimentos.</strong>
            </td>
            <td colspan="2">
                <b>PBA</b> <br>
                Planta de Beneficio Animal
            </td>
        </tr>
        <tr>
            <td colspan="5">Código:	PBA-PM-PB-BOV-FOR-16</td>
            <td colspan="2">versión: 1</td>
            <td colspan="5">Fecha de emision:24/01/2022</td>
            <td colspan="2">Página 1</td>
        </tr>
        <tr>
            <td colspan="2"><b>FECHA:</b></td>
            <td colspan="5">{{ $general['date'] }}</td>
            <td colspan="2"><b>ESPECIE: </b></td>
            <td colspan="5">{{ $general['specie'] }}</td>
        </tr>
        <tr>
            <td><strong>CÓDIGO Exp.</strong></td>
            <td><strong>Consecutivo</strong></td>
            <td><strong>ORGANO</strong></td>
            <td><strong>M. FECAL</strong></td>
            <td><strong>RESUMEN</strong></td>
            <td><strong>PIEL</strong></td>
            <td><strong>PELO</strong></td>
            <td><strong>HEM</strong></td>
            <td><strong>ABSESO</strong></td>
            <td><strong>PARASITO</strong></td>
            <td><strong>OTROS</strong></td>
            <td><strong>CORRECCION</strong></td>
            <td><strong>CANTIDAD</strong></td>
            <td><strong>OBSERVACIONES</strong></td>
        </tr>
        @foreach($data as $element)
        <tr>
            <td>{{ $element->dailyPayroll->outlet->code }}</td>
            <td>{{ $element->dailyPayroll->incomeForm->code }}</td>
            <td>{{ $element->organ }}</td>
            <td>{{ $element->fecal_matter }}</td>
            <td>{{ $element->resume }}</td>
            <td>{{ $element->hide }}</td>
            <td>{{ $element->hair }}</td>
            <td>{{ $element->hem }}</td>
            <td>{{ $element->abscess }}</td>
            <td>{{ $element->parasite }}</td>
            <td>{{ $element->others }}</td>
            <td>{{ $element->correction }}</td>
            <td>{{ $element->quantity }}</td>
            <td>{{ $element->observations }}</td>
        </tr>
        @endforeach
        <tr><td></td></tr>
        <tr>
            <td></td>
            <td><strong>COMVENCIONES:</strong></td>
            <td colspan="3">GM (glándula mamaria)</td>
            <td colspan="3">HEM: (hematoma)</td>
            <td colspan="3">M: (materia)</td>
            <td colspan="3">EXP: (expendio)</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5"><b>ELABORO: {{ $general['elaborated_by'] }}</b></td>
            <td colspan="2"></td>
            <td colspan="5"><b>VERIFICÓ: {{ $general['verified_by'] }}</b></td>
        </tr>
    </table>
</body>
</html>