<!DOCTYPE html>
<html>

<head>
    <!-- <title>Laravel 10 Generate PDF Using DomPDF - Techsolutionstuff</title> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .txt-center {
            text-align: center;
        }

        .table-bordered {
            border: none !important;

        }

        table tr td {
            border: none !important;
        }

        @page {
            margin: 80px;
        }

        .h4,
        h4 {
            font-size: 14px;
            font-weight: 800;
        }

        .h4,
        .h5,
        .h6,
        h4,
        h5,
        h6 {
            margin-top: 5px !important;
            margin-bottom: 5px !important;
        }

        p {
            margin: 0px;
            padding: 0px;
        }

        body {
            text-align: justify !important;
            text-justify: inter-word !important;

        }

        .header-logo_big {
            width: 40%;
            float: left;
            top: 0px;
            position: absolute;
            /* margin: 0; */
            /* margin-top: 0; */
            left: 0;
        }

        .header-logo-small {
            width: 20%;
            float: right;
            position: relative;
            top: 15px;
        }

        .project_info {
            float: left;
            margin-top: 30px;
        }

        hr {
            margin-top: 0px !important;
        }

        .parent {
            position: relative;
        }

        .bottom {
            position: absolute;
            bottom: 0;
        }

        .footer {
            width: 100%;
            text-align: center;
            position: fixed;
        }

        .pagenum:before {
            content: counter(page);
        }

        .footer {
            bottom: 0px;
        }

        #box1 {
            background: #edecec;
            width: 40%;
            border: 2px solid black;
            text-align: center;
            padding: 10px;
            font-size: 15px;
            font-weight: 800;
        }

        /* @media print {

        .table-bordered {
            border: solid white !important;


        }

        .table-bordered tr td {

            border: solid white !important;

        }
    } */
    </style>
</head>

<body>
    <!-- <header class="parent">
        <div class="row">
            <span class="project_info">Prüfbericht NR 2020-177 PS bvs-Nr.63735</span>
        </div>
        <div class="row">
            <hr />
        </div>
    </header> -->
    <main>
        <div class="container">
            <table style="width:100%;">
                <?php 
                $image = public_path('assets/img/logo-p.png');
                $path = $image;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                ?>
                <tr>
                    <td style="width:60%;text-align: left; vertical-align: middle;position: relative;">
                        <p style="font-size:12px;">Ingenieurbüro v.Spiess & Partner mbB, Kaiserstraße 61, 44135 Dortmund
                        </p>
                        <p style=" font-size:12px;">{{$client->client_name}}<br />{{$client->client_full_address}}</p>
                        <div style="clear: both;" />
                        <!-- <img class="header-logo_big" src="{{$base64}}" /> -->
                        <!-- <div style="clear: both;" /> -->
                    </td>
                    <td colspan="2">
                        <div style="font-size: 10px;">
                            <p>Beratende Ingenieure für Tragwerksplanung, Brandschutz,
                                Schallschutz und Energieeffizienz von Gebäuden
                            </p>
                            <p>
                            <h5>Dipl.-Ing.
                                Gerd von Spiess
                            </h5>
                            Beratender Ingenieur, qTWP VPI, VBI, IKNW
                            Sachverständiger für Brandschutz
                            st.a. Sachverständiger für Schall- und Wärmeschutz
                            Effizienzhaus-Experte (Dena)
                            </p>
                            <p>
                            <h5>M.Sc. Dipl.-Ing. Karsten Kemper</h5>
                            Prüfingenieur für Baustatik VPI
                            staatlich anerkannter Sachverständiger
                            für die Prüfung der Standsicherheit
                            </p>
                            <p>
                            <h5>
                                Dipl.-Ing.
                                Christian Bäker
                            </h5>
                            Beratender Ingenieur IKNW
                            Prüfingenieur für Brandschutz VPI
                            staatlich anerkannter Sachverständiger für die Prüfung des Brandschutzes
                            </p>
                            <p>
                            <h5>Dipl.-Ing.
                                Jörg Roloff
                            </h5>
                            Beratender Ingenieur IKNW
                            qualifizierter Tragwerksplaner IKNW
                            </p>

                            <p>
                                Datum: {{date('d.m.Y')}}
                            </p>

                        </div>

                    </td>
                </tr>

            </table>
            <table>
                <tr>
                    <td colspan="3" class="text-center">
                        <h4>RECHNUNG NR.: {{$invoice->invoice_number}}</h4>
                    </td>
                </tr>
                <tr>
                    <td style="width:40%;text-align:right;padding-right: 10%;">{{$project->number}}</td>
                    <td colspan="2">
                        <span>{{$project->project_name}}<br />{{$project->full_address}}</span>
                    </td>

                </tr>
                <tr>
                    <td style="width:40%;text-align:right;padding-right: 10%;"></td>
                    <td colspan="2" style="font-size:12px;">
                        <p>für:{{$client->client_name}}, {{$client->client_full_address}}</p>
                        <p>Auftragsdatum:{{$invoice->invoice_order_date}}</p>
                        <p>Ortstermine am {{$invoice->onsite_appointments_on}} </p>
                        <p>{{$invoice->project_status}} </p>
                        <p>Bearbeitungszeitraum: bis {{$invoice->processing_period}}</p>
                    </td>

                </tr>
                <tr>
                    <td colspan="3" style="margin-top:15px;padding-top:15px;">
                        <hr style="border-top: 2px dashed black;" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p>Die Erstellung der o. g. Unterlagen berechnen wir wie folgt:</p>
                    </td>
                </tr>
                <tr style="padding-top:25px;margin-top: 25px;">
                    <td style="padding-top:25px;margin-top: 25px;"></td>
                </tr>
                @foreach(json_decode($invoice->invoice_items) as $index=>$item)
                <tr>
                    <td colspan="2" style="padding:2px;">{{$item->description}}</td>
                    <td style="text-align:right;">{{$item->cost}} &euro;</td>
                </tr>
                @endforeach
                <tr style="padding-top:25px;margin-top: 25px;">
                    <td style="padding-top:25px;margin-top: 25px;"></td>
                </tr>
                <tr>
                    <td>Zwischensumme</td>
                    <td style="text-align:right;" colspan="2">{{$invoice->sub_total}} &euro;</td>
                </tr>

                <tr>
                    <td>Mehrwertsteuer</td>
                    <td style="text-align:right;padding-right:5%;">zuzugl. 19%</td>
                    <td style="text-align:right;">{{$invoice->taxes}} &euro;</td>
                </tr>
                <tr>
                    <td><strong>Reechnungssumme</strong></td>
                    <td colspan="2" style="text-align:right;">{{$invoice->total_amount}} &euro;</td>
                </tr>
                <tr style="padding-top:25px;margin-top: 25px;">
                    <td style="padding-top:25px;margin-top: 25px;"></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p> Bitte überweisen Sie den Rechnungsbetrag von <strong>{{$invoice->total_amount}}
                                €</strong>
                            ohne Abzug bis zum <strong>{{$invoice->value_position}}</strong>
                            (Wertstellung) auf eines unserer Konten unter Angabe der Rechnung
                            Nr. <strong>{{$invoice->invoice_number}}</strong> . Bei
                            Missachtung der Zahlungsfrist tritt automatisch ein Verzug ein.</p>
                        <p>Diese Rechnung und die dazugehörigen Zahlungsbelege sind gem. § 14b Abs. 1 Satz 5 UStG zwei
                            Jahre lang aufzubewahren, sofern Sie diese Leistung als Privatperson beziehen.</p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="footer" style="border-top:1px solid black;">
            <table style="width:100%;">
                <tr>
                    <td style="font-size:11px;font-style: italic;">
                        <div style="justify-items: stretch;">
                            Ingenieurbüro v.Spiess & Partner mbB<br />
                            Kaiserstraße 61 44135 Dortmund<br />
                            Telefon 0231 556922-0
                        </div>
                    </td>
                    <td style="font-size:11px;text-align: right;font-style: italic;">
                        <p align="justify">Deutsche Bank AG</p>
                        <p align="justify">Sparkasse Dortmund</p>
                        <p align="justify">info@von-spiess.de</p>
                    </td>
                    <td style="font-size:11px;text-align: right;font-style: italic;">
                        <p align="justify">BIC: DEUTDEDB440</p>
                        <p align="justify">BIC: DORTDE33XXX</p>
                        <p align="justify">www.von-spiess.de</p>
                    </td>
                    <td style="font-size:11px;text-align: right;font-style: italic;">
                        <p>IBAN: DE98 4407 0024 0177 0684 00</p>
                        <p>IBAN: DE93 4405 0199 0181 0405 13</p>
                        <p>Steuer-Nr. 317-5779-0475</p>
                    </td>
                </tr>
            </table>
        </div>
        </div>
    </main>

</body>

</html>