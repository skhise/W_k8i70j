<!DOCTYPE html>
<html>

<head>
    <title>Laravel 10 Generate PDF Using DomPDF - Techsolutionstuff</title>
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
            margin: 80px 20px;
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
            margin: 0 0 5px;
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
                <tr style="margin-bottom 10px;">
                    <td style="width:60%;text-align: center; vertical-align: middle;position: relative;">
                        <img class="header-logo_big" src="{{$base64}}" />
                        <div style="clear: both;" />
                        <div id="box1">1. Ausfertigung</div>
                    </td>
                    <td>
                        <div style="font-size: 10px;">
                            <p>Beratende Ingenieure für
                                Tragwerksplanung, Brandschutz,
                                Schallschutz und
                                Energieeffizienz von Gebäuden
                            </p>
                            <p>
                            <h4>Dipl.-Ing.
                                Gerd von Spiess
                            </h4>
                            Beratender Ingenieur VBI, IKNW
                            Sachverständiger für Brandschutz
                            st.a. Sachverständiger für
                            Schall- und Wärmeschutz
                            Effizienzhaus-Experte (Dena)
                            Vor-Ort-Berater (BAFA)

                            </p>
                            <p>
                            <h4> M.Sc. Dipl.-Ing.</h4>
                            Karsten Kemper
                            Prüfingenieur für Baustatik VPI
                            staatlich anerkannter Sachverständiger für die Prüfung der Standsicherheit

                            </p>
                            <p>
                            <h4>
                                Dipl.-Ing.
                                Christian Bäker
                            </h4>
                            Beratender Ingenieur IKNW
                            Prüfingenieur für Brandschutz VPI
                            staatlich anerkannter Sachverständiger für die Prüfung des Brandschutzes
                            </p>
                            <p>
                            <h4>Dipl.-Ing.
                                Jörg Roloff
                            </h4>
                            Beratender Ingenieur IKNW
                            qualifizierter Tragwerksplaner IKNW
                            </p>

                            <p>
                            <h4>M.Sc.
                                Silvio von Spiess
                            </h4>
                            Beratender Ingenieur IKNW
                            </p>
                            <p>
                            <h6><strong>Ingenieurbüro von Spiess
                                    & Partner mbB</strong></h6>
                            Kaiserstr. 61, 44135 Dortmund
                            Telefon: 0231/556922-0
                            E-Mail: info@von-spiess.de
                            Internet: www.von-spiess.de

                            Steuer-Nr. 317-5779-0475

                            <h6><strong>Bankverbindungen</strong></h6>

                            Deutsche Bank AG
                            BIC: DEUTDEDB440
                            IBAN DE98 4407 0024 0177 0684 00

                            Sparkasse Dortmund
                            BIC: DORTDE33XXX
                            IBAN DE98 4405 0199 0181 0405 13

                            </p>

                        </div>

                    </td>
                </tr>
                <tr class="txt-center" style="margin-bottom 10px;">
                    <td colspan="2">
                        <p>Datum: {{date('d.m.Y', strtotime($document['created_at'])) ?? ""}}</p>
                        <h4>1. Prüfbericht {{$document->document_number}} </h4>

                    </td>
                </tr>
                <!-- <tr>
                    <td colspan="2">bvs-Nr.63735</td>
                </tr> -->
                @foreach ($headings as $index=>$heading)
                @if($index+1 == 1)
                <tr>
                    <td style="margin-bottom 10px;"><strong>{{$index+1}}. {{$heading->heading_title}}</strong></td>
                    <td style="margin-bottom 10px;">{{$client->client_name}}</td>
                </tr>
                <tr>
                    <td colspan="2"><br /></td>
                </tr>
                @elseif($index+1 == 2)
                <tr style="margin-bottom 10px;">
                    <td><strong>{{$index+1}}. {{$heading->heading_title}}</strong></td>
                    <td>{{$project->project_address}}</td>
                </tr>
                <tr>
                    <td colspan="2"><br /></td>
                </tr>
                @elseif($index+1 == 5 || $index+1 ==6)
                <tr>
                    <td colspan="2" style="margin-bottom 10px;"><strong>{{$index+1}}.
                            {{$heading->heading_title}}</strong> :
                        {!!trim($heading->heading_selected_content)!!}</td>

                </tr>

                @elseif($index+1 == 7)
                <tr>
                    <td><strong>{{$index+1}}. {{$heading->heading_title}}</strong></td>
                    <td style="margin-bottom 10px;">{!!trim($heading->heading_selected_content)!!}</td>
                </tr>
                @elseif($index+1 == 8)

                <tr style="page-break-before:always;">
                    <td colspan="2"><strong>{{$index+1}}. {{$heading->heading_title}}</strong></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p>{!!trim($heading->heading_selected_content)!!}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><br /></td>
                </tr>
                @else
                <tr>
                    <td colspan="2"><strong>{{$index+1}}. {{$heading->heading_title}}</strong></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p>
                            {!!trim($heading->heading_selected_content)!!}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><br /></td>
                </tr>
                @endif
                @endforeach
            </table>
        </div>
    </main>

</body>

</html>