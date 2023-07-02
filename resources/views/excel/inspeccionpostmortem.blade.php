<table border="1">
    <tr>
        <td colspan="3" class="logo"></td>
        <td colspan="12" class="center">
            FORMATO INSPECCIÓN POST MORTEM 
            <br>
            <strong>Sistema Integral de Gestión de la Calidad e inocuidad<br> de los alimentos.</strong>
        </td>
        <td colspan="4">
            <b>PBA</b> <br>
            Planta de Beneficio Animal
        </td>
    </tr>
    <tr>
        <td colspan="5">Código: PBA-PM-PB-BOV-PLA-13</td>
        <td colspan="2">versión: 3</td>
        <td colspan="8">Fecha de emisión 05/12/2021</td>
        <td colspan="4">Página 1</td>
    </tr>
    <tr>
        <td colspan="7"><b>FECHA: </b></td>
        <td colspan="12"><b>RESPONSABLE: </b></td>
    </tr>
    <tr>
        <td rowspan="2" colspan="2">NUMERO EXPENDIO</td>
        <td rowspan="2">CÓDIGO CONSECUTIVO</td>
        <td colspan="2"><strong>INTESTINOS</strong></td>
        <td colspan="2"><strong>HÍGADOS</strong></td>
        <td colspan="2"><strong>PULMONES</strong></td>
        <td colspan="2"><strong>UBRES</strong></td>
        <td colspan="2"><strong>PATAS</strong></td>
        <td colspan="2"><strong>DESPURGOS</strong></td>
        <td colspan="4"><strong>OTROS</strong></td>
    </tr>
    <tr>
        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>CAUSA</td>
        <td>CANT</td>

        <td>ÓRGANO</td>
        <td>CAUSA</td>
        <td>CANT</td>
        <td>INSP. GANGLIOS</td>
    </tr>
    @foreach($data as $key => $element)
    <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ $element->antemortem_daily_record->outlet->code }}</td>
        <td>{{ $element->antemortem_daily_record->code }}</td>

        <td>{{ $element->intestines_cause?->name }}</td>
        <td>{{ $element->intestines_quantity }}</td>

        <td>{{ $element->livers_cause?->name }}</td>
        <td>{{ $element->liver_quantity }}</td>

        <td>{{ $element->lungs_cause?->name }}</td>
        <td>{{ $element->lungs_quantity }}</td>

        <td>{{ $element->udders_cause?->name }}</td>
        <td>{{ $element->udders_quantity }}</td>

        <td>{{ $element->legs_cause?->name }}</td>
        <td>{{ $element->legs_quantity }}</td>

        <td>{{ $element->purges_cause?->name }}</td>
        <td>{{ $element->purges_quantity }}</td>

        <td>{{ $element->other_organ }}</td>
        <td>{{ $element->other_cause }}</td>
        <td>{{ $element->other_quantity }}</td>
        <td>{{ $element->insp_ganglions }}</td>
    </tr>
    @endforeach
    <tr><td></td></tr>
    <tr>
        <td></td>
        <td colspan="10"><strong>CÓDIGO DE PATOLOGÍAS</strong></td>
    </tr>
    <tr>
        <td></td>
        <td>DISTOMATOSIS</td>
        <td><strong>1</strong></td>
        <td>ABSCESOS</td>
        <td><strong>5</strong></td>
        <td>PARÁSITOS</td>
        <td><strong>9</strong></td>
        <td>HEMATOMAS</td>
        <td><strong>13</strong></td>
        <td>ADHERENCIAS</td>
        <td><strong>14</strong></td>
    </tr>
    <tr>
        <td></td>
        <td>TELANGECTASIA</td>
        <td><strong>2</strong></td>
        <td>CIRROSIS</td>
        <td><strong>6</strong></td>
        <td>QUISTES<br>PARASITARIOS</td>
        <td><strong>10</strong></td>
        <td>CROMATOSIS</td>
        <td><strong>14</strong></td>
        <td>ENFISEMA</td>
        <td><strong>16</strong></td>
    </tr>
    <tr>
        <td></td>
        <td>De. GRASA </td>
        <td><strong>3</strong></td>
        <td>CONGESTIÓN</td>
        <td><strong>7</strong></td>
        <td>PERITONITIS</td>
        <td><strong>11</strong></td>
        <td>MIASIS</td>
        <td><strong>15</strong></td>
        <td>BRONCO<br>ASPIRACIÓN</td>
        <td><strong>19</strong></td>
    </tr>
    <tr>
        <td></td>
        <td>TUMORES</td>
        <td><strong>4</strong></td>
        <td>HIDRONEFROSIS</td>
        <td><strong>8</strong></td>
        <td>TRAUMATISMOS</td>
        <td><strong>12</strong></td>
        <td>NECROSIS</td>
        <td><strong>16</strong></td>
        <td>HEMORRÁGICO</td>
        <td><strong>20</strong></td>
    </tr>
    <tr>
        <td></td>
        <td>DESHIDRATACION</td>
        <td><strong>21</strong></td>
    </tr>
</table>