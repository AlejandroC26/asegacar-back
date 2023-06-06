<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container {
            width: 100%;
            max-width: 650px;
            margin: 0 auto;
        }
        body {
            font-family: 'Arial';
        }
        .logo img {
            display: block;
            width: 5.15cm;
            height: 2.17cm;
            margin: .5rem auto;
        }
        .signature {
            max-width: 500px;
            max-height: 80px;
            padding-bottom: .2rem;
            padding-left: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        table td {
            padding: 0 .5rem;
        }
        table .logo {
            width: 40%;
        }
        .super-small-size {
            font-size: 11px;
        }
        .small-size {
            font-size: .8rem;
        }
        .md-size {
            font-size: .9rem;
        }
        table .pba {
            font-size: 1.5rem;
        }
        .justify { text-align: justify; }
        .center { text-align: center; }
        .mt-md { margin-top: 2rem; }
        .pd-sm { padding: .3rem .5rem; }
    </style>
</head>
<body>
    <div class="container">
        <table border="1">
            <tr>
                <td class="logo">
                    <img src="{{ public_path('assets/logo.png') }}">
                </td>
                <td class="name center">
                    <b>
                        DEPÓSITO DE ANIMALES <br><br>
                        <span class="small-size">
                            Sistema Integral de Gestión de la <br> Calidad e inocuidad de los <br> alimentos.
                        </span>
                    </b> 
                </td>
                <td class="center">
                    <span class="pba">PBA</span><br><br>
                    <span class="small-size">PLANTA DE BENEFICIO ANIMAL</span>
                </td>
            </tr>
            <tr class="md-size">
                <td class="pd-sm" colspan="2">
                    <b>Código: </b>
                    <label>{{ $format_code }}</label> / 
                    <b>Fecha Emisión</b>
                    <span>{{ $month }} {{ $year }}</span>
                </td>
                <td class="pd-sm">
                    Versión: 2
                </td>
            </tr>
        </table>
        <p class="super-small-size justify mt-md">
            Entre quienes suscriben este documento, por una parte {!! $person !!}
            quien se identifica con la cédula de ciudadanía número  {!! $document !!}
            expedida en {!! $expedition_city !!}
            y para los efectos del presente acto se designará como EL DEPOSITANTE y, por la otra parte ASEGACAR DEL HUILA S.A.S.  Identificada con Nit. 900.582.670-6 y quien en el texto de este contrato se denominará como EL DEPOSITARIO, hemos convenido en celebrar un contrato de depósito que se regirá por las cláusulas que a continuación se enuncian en lo no previsto en ellas por   las   disposiciones  legales  aplicables a la materia de qué trata el presente acto jurídico, en especial por las prescripciones contenidas en los artículos 2236 y siguientes del Código Civil. <b>Primera. Objeto</b>. – En virtud del presente contrato EL DEPOSITANTE entrega a EL DEPOSITARIO, para su guarda y custodia, los semovientes que se encuentran relacionados en la carátula del presente documento y cuyo transporte es realizado con base en la guía sanitaria de movilización que 
            a continuación se identifica: {!! $guide_number !!}. <b>Segunda. Lugar del depósito</b>. – Los bienes objeto del presente contrato y descritos en la cláusula anterior, deberán permanecer durante la vigencia del mismo en los corrales de la Planta de Beneficio Animal del Municipio de Pitalito, los cuales son administrados por EL DEPOSITARIO, es decir, en la siguiente dirección: Calle 14 A No. 14-00 del Municipio de Pitalito. EL DEPOSITARIO podrá cambiar el sitio de ubicación de los semovientes entregados en depósito sin la previa autorización de EL DEPOSITANTE, siempre y cuando se haga por orden de una autoridad que tenga competencia para el efecto (ICA – INVIMA – Secretaría de Salud, etc.). <b>Tercera. Uso de los bienes</b>. – EL DEPOSITARIO no queda autorizado para utilizar los bienes objeto de este contrato. <b>Cuarta. Obligaciones del DEPOSITARIO</b>. – En desarrollo del presente contrato EL DEPOSITARIO se obliga especialmente a: 1. Ejercer debidamente la guarda y custodia de los bienes que se entregan, empleando para ello toda su diligencia y cuidado. 2. Conservar los bienes en el estado en que los recibe, para lo cual se obliga a tomar las medidas necesarias para el cumplimiento de dicha obligación. 3. Abstenerse de dar uso alguno a los bienes que en virtud del presente contrato se le confían. 4. No entregar los bienes en su depósito a persona alguna. 5. Conservar los semovientes en las instalaciones previamente reseñados hasta el momento en que se realice su ingreso para el respectivo faenado. 6. no cambiar la ubicación de los bienes, sin autorización expresa y escrita de EL DEPOSITANTE, salvo que se haga por orden de una autoridad que tenga competencia para el efecto (ICA – INVIMA – Secretaría de Salud, etc.). <b>Quinta. Duración del depósito</b>. – La duración del presente contrato será de cuarenta y ocho (48) horas, esto por cuanto los corrales y EL DEPOSITARIO no cuentan con la logística e infraestructura necesaria para garantizar el bienestar animal por un tiempo superior, evento en el cual se entiende que se da por terminado el contrato. <b>PARÁGRAFO</b>. En caso de que una vez cumplidas las cuarenta y ocho (48) horas el animal no sea ingresado para su respectivo faenado,  (ASEGACAR DEL HUILA S.A.S. DEL HUILA S.A.S.) estará en la obligación de informar de esta situación a las entidades encargadas de vigilar el bienestar animal para que ellas tomen las medidas a que haya lugar. <b>Sexta. Remuneración</b>. – Como contraprestación por sus servicios EL DEPOSITARIO no tendrá derecho a recibir ninguna suma durante el término de duración del contrato. <b>Séptima. Responsabilidad ante terceros</b>. En caso de que los semovientes llegaren a generar algún tipo de perjuicio a un tercero a esta relación contractual, los gastos que esto llegare a generar correrán a cargo del DEPOSITANTE, esto por cuanto el DEPOSITARIO no está recibiendo ningún tipo de contraprestación por su servicio. PARÁGRAFO. Los semovientes no se entenderán bajo la custodia del DEPOSITARIO sino hasta el momento en que hayan sido debidamente puestos dentro de las   instalaciones  que  para el efecto se indiquen al DEPOSITANTE.  <b>Octava. Estado de los bienes</b>. – Las partes declaran que los semovientes que se entregan en virtud del presente contrato se encuentran en condiciones normales de conservación. <b>Novena. Cláusula compromisoria</b>. – Las partes convienen que en el evento en que surja alguna diferencia entre las mismas por razón o con ocasión del presente Contrato, bien sea esta relativa a su nacimiento, ejecución o extinción, intentarán resolverla primeramente de forma directa. Para esto, la parte inconforme manifestará por escrito la situación a la otra y a partir de ese momento se dispondrá de un plazo de diez (10) días hábiles para que se logre resolver la diferencia. Vencido este término y sin que se haya solucionado la diferencia, o la parte que ha sido notificada no conteste, la diferencia será resuelta por un tribunal de arbitramento, el cual deberá conformarse y funcionar bajo los siguiente s   parámetro s o reglas: (i) estará conformado por un (1) árbitro, que será elegido por sorteo que haga el Centro de Arbitraje y Conciliación de la Cámara de Comercio de Neiva – Seccional Pitalito; (ii) fallará en derecho y (iii) su funcionamiento se regirá por las reglas del Centro de Arbitraje de la Cámara de Comercio de Neiva – Seccional Pitalito.
        </p>
        
        <p class="super-small-size justify mt-md">
            En señal de conformidad EL DEPOSITANTE suscribe el presente documento a los {{ $text_days }} ({{$number_days}}) días del mes de {{ $text_months }} 20{{ $year_number }}.
        </p>
        <div class="small-size mt-md">
            <p><b>Firma: </b> 
                @if($signature_path) 
                    <img class="signature" src="{{ $signature_path }}">
                @else 
                    <span> </span>
                @endif
            </p>
            <p><b>Nombre: </b> <span> {!! $person !!} </span></p>
            <p><b>C.C: </b> <span>{!! $document !!}</span></p>
        </div>
    </div>
</body>
</html>