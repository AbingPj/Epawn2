<!-- pdf.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <meta charset="utf-8">
    <title></title>
    {{--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    --}}
    {{--
    <link rel="stylesheet" type="text/css" href="{{ base_path().'/css/app.css' }}"> --}}
    {{--
    <link href="{{ public_path('css/app.css') }}" rel="stylesheet"> --}}
    <style>
        hr {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 1px;
        }

        .table1 {
            width: 100%;
            /* border: 2px solid #ddd; */
            padding: 10px;
        }

        .thead1 {
            border-bottom: 1px solid #f57224;
        }

        .theadth1 {
            text-align: left;
            padding: 15px 5px 15px 5px;
        }

        .theadtd1 {
            text-align: left;
            padding: 15px 5px 15px 5px;
        }

        .tbodytd1 {
            text-align: left;
            padding: 5px;
        }

        .tfootth1 {
            text-align: left;
            padding: 15px 5px 15px 5px;
            border-top: 1px solid #ddd;
        }

        .tfoottd1 {
            text-align: left;
            padding: 15px 5px 0px 5px;
        }

        .tfoot1 {
            border-top: 1px solid #ddd;
        }


        .sun-text-left {
            text-align: left !important;
        }

        .sun-text-center {
            text-align: center !important;
            ;
        }

        .sun-text-right {
            text-align: right !important;
        }

        .logo {
            width: 100px;
            height: 100px;
            object-fit: cover !important;
        }



        .table2 {
            width: 100%;
            /* border: 2px solid #ddd; */
            padding: 10px;
        }

        .thead2 {
            /* border-bottom: 1px solid  #f57224; */
        }

        .theadth2 {
            text-align: left;
            padding: 5px 5px 5px 5px;
        }

        .theadtd2 {
            text-align: left;
            padding: 5px 5px 5px 5px;
        }

        .tbodytd2 {
            text-align: left;
            padding: 1px;
            color: #f57224;
        }


        .table3 {
            width: 50%;
            border: 2px solid #f57224;
            padding: 10px;
        }

        .tbodytd3 {
            text-align: left;
            padding: 4px;
            color: #f57224;
            border-bottom: 1px solid #f57224;
        }
    </style>

</head>

<body>

    <div class="card" style="margin-top:0px !important; padding-top:0px !important;">
        <table class="table1" style="margin-top:0px !important; padding-top:0px !important;">
            <thead class="thead1" style="margin-top:0px !important; padding-top:0px !important;">
                <tr style="margin-top:0px !important; padding-top:0px !important;">
                    <th class="theadth1 sun-text-left" style="margin-top:0px !important; padding-top:0px !important;">
                        <img class="logo" src="{{$class->epawn_logo}}" alt=""></th>
                    <td class="theadtd1 sun-text-center" style="margin-top:0px !important; padding-top:0px !important;">
                        <b>
                            <h4 style="color: #f57224; margin: 0px 0px; font-size:25px !important;">Pawn Information
                                Receipt</h4>
                        </b>
                        <p>
                            <span><b>{{$class->pawnshop->fname}}</b></span><br>
                            <span>{{$class->pawnshop->address }}</span><br>
                            <span>tel: {{$class->pawnshop->contact}} / e: {{$class->pawnshop->email}}</span><br><br>
                            <span style="color: #f57224;">Pawned ID #{{$class->number}}</span>
                        </p>
                    </td>
                    <th class="theadth1 sun-text-right" style="margin-top:0px !important; padding-top:0px !important;">
                        <img class="logo" src="{{$class->pawnshop->atr_image_link }}" alt=""></th>
                </tr>
            </thead>
        </table>
        <div style="width: 100%  !important;  text-align:center !important;">printed: {{$class->printed}}</div>

        <div><b>Pawner</b></div>
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 70%;">
                        <div>Name: {{$class->customer->fname}}</div>
                    </td>
                    <td>contact #: {{$class->customer->contact}}</td>
                </tr>
                <tr>
                    <td style="width: 70%;">
                        <div> Address: {{$class->customer->address}}</div>
                    </td>
                    <td>
                        <div> email: {{$class->customer->email}}</div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <div><b>Pawn Agreement Information:</b></div>
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 70%;">
                        <div> Amount: <b><u>Php {{$class->amount}}</u></b></div>
                    </td>
                    <td>
                        <div> Date Pawned: {{$class->datePawned}}</div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 70%;">
                        <div> Item: {{$class->item_name}} / {{$class->item_desc}}</div>
                    </td>
                    <td>{{$class->dateRenew}}</td>
                </tr>
            </tbody>
        </table>
        <br>
        <div style="width: 100%  !important;  text-align:left !important;"> <b>
                <h4 style="color: #f57224; margin: 0px 0px; font-size:25px !important;">Claimed</h4>
            </b></div>
        <div style="width: 100%  !important;  text-align:left !important;">
            <table class="table3">
                {{-- <thead></thead> --}}
                <tbody class="thead3">
                    <tr>
                        <td class="tbodytd3 sun-text-left">
                            Pawned Amount:
                            </th>
                        <th class="tbodytd3 sun-text-right">
                            Php {{$class->amount}}
                        </th>
                    </tr>
                    <tr>
                        <th class="tbodytd3 sun-text-left">
                            Interest:
                        </th>
                        <th class="tbodytd3 sun-text-right">
                            {{$class->current_interest_rate}} %
                        </th>
                    </tr>
                    <tr>
                        <th class="tbodytd3 sun-text-left">
                            Claimed Amount:
                        </th>
                        <th class="tbodytd3 sun-text-right">
                            Php {{$class->current_payment}}
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>

        <br>
        <br>

        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td class="sun-text-center">____________________________________________________</td>
                    <td class="sun-text-center" style="width:100px;"></td>
                    <td class="sun-text-center">____________________________________________________</td>
                </tr>
                <tr>
                    <td class="sun-text-center">Signature of Pawner</td>
                    <td class="sun-text-center" style="width:100px;"></td>
                    <td class="sun-text-center">Pawnshop`s Autorized Representative Name & Signature</td>
                </tr>
            </tbody>
        </table>
        <br>
    </div>
</body>

</html>
