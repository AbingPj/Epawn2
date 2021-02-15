<!-- pdf.blade.php -->

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <meta charset="utf-8">
    <title></title>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ base_path().'/css/app.css' }}"> --}}
    {{-- <link href="{{ public_path('css/app.css') }}" rel="stylesheet"> --}}
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

      .table1{
            width: 100%;
            /* border: 2px solid #ddd; */
            padding: 10px;
        }

        .thead1 {
          border-bottom: 1px solid  #f57224;
        }

        .theadth1{
            text-align:left;
            padding:15px 5px 15px 5px;
        }
        .theadtd1{
            text-align:left;
            padding:15px 5px 15px 5px;
        }
        .tbodytd1{
            text-align:left;
            padding:5px;
        }
        .tfootth1{
            text-align:left;
            padding:15px 5px 15px 5px;
            border-top: 1px solid #ddd;
        }
        .tfoottd1{
            text-align:left;
            padding:15px 5px 0px 5px;
        }

        .tfoot1{
           border-top: 1px solid #ddd;
        }


        .sun-text-left{
            text-align:left !important;
        }
        .sun-text-center{
            text-align:center !important;;
        }
        .sun-text-right{
            text-align:right !important;
        }
        .logo{
            width:100px; height:100px; object-fit:cover !important;
        }



        .table2{
            width: 100%;
            /* border: 2px solid #ddd; */
            padding: 10px;
        }
        .thead2 {
          /* border-bottom: 1px solid  #f57224; */
        }

        .theadth2{
            text-align:left;
            padding:5px 5px 5px 5px;
        }
        .theadtd2{
            text-align:left;
            padding:5px 5px 5px 5px;
        }
        .tbodytd2{
            text-align:left;
            padding:1px;
            color: #f57224;
        }




    </style>

  </head>
  <body>

	<div class="card" style="margin-top:0px !important; padding-top:0px !important;">
            <table class="table1" style="margin-top:0px !important; padding-top:0px !important;">
                <thead class="thead1" style="margin-top:0px !important; padding-top:0px !important;" >
                    <tr style="margin-top:0px !important; padding-top:0px !important;" >
                    <th class="theadth1 sun-text-left" style="margin-top:0px !important; padding-top:0px !important;" ><img class="logo" src="{{$class->epawn_logo}}" alt=""></th>
                    <td class="theadtd1 sun-text-center" style="margin-top:0px !important; padding-top:0px !important;" >
                        <b><h4 style="color: #f57224; margin: 0px 0px; font-size:25px !important;">Pawn Information Receipt</h4></b>
                        <p>
                            <span><b>{{$class->pawnshop->fname}}</b></span><br>
                            <span>{{$class->pawnshop->address }}</span><br>
                            <span>tel: {{$class->pawnshop->contact}}  / e: {{$class->pawnshop->email}}</span><br><br>
                            <span style="color: #f57224;">Pawned ID #{{$class->number}}</span>
                        </p>
                    </td>
                    <th class="theadth1 sun-text-right" style="margin-top:0px !important; padding-top:0px !important;" ><img class="logo" src="{{$class->pawnshop->atr_image_link }}" alt=""></th>
                    </tr>
                </thead>
            </table>
           <div style="width: 100%  !important;  text-align:center !important;">printed: {{$class->printed}}</div>

           <div><b>Pawner</b></div>
           <table style="width: 100%;">
               <tbody>
                   <tr>
                       <td style="width: 70%;"><div>Name: {{$class->customer->fname}}</div></td>
                       <td>contact #: {{$class->customer->contact}}</td>
                   </tr>
                   <tr>
                       <td style="width: 70%;"> <div> Address: {{$class->customer->address}}</div></td>
                       <td><div> email: {{$class->customer->email}}</div></td>
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
                       <td><div> Date Pawned: {{$class->datePawned}}</div></td>
                   </tr>
                   <tr>
                       <td style="width: 70%;"> <div> Item: {{$class->item_name}}   /    {{$class->item_desc}}</div></td>
                       <td>{{$class->dateRenew}}</td>
                    </tr>
               </tbody>
           </table>
           <br>
           <br>
           <div><b>Payment Schedule:</b></div>
           <table class="table2">
               <thead class="thead2">
                   <tr>
                       <th class="theadth2 sun-text-center">Date</th>
                       <th class="theadth2 sun-text-center">Total Interest</th>
                       <th class="theadth2 sun-text-center">Renewal Amount</th>
                       <th class="theadth2 sun-text-center">Redemtion</th>
                   </tr>
               </thead>
               <tbody>
                    @foreach ($class->details->specials as $item)
                    <tr>
                        <td class="tbodytd2 sun-text-center">{{ $item['from'] }} - {{ $item['to'] }}</td>
                        <td class="tbodytd2 sun-text-center">{{$item['interest']}} %</td>
                        <td class="tbodytd2 sun-text-center">Php {{$item['renewal_f']}}</td>
                        <td class="tbodytd2 sun-text-center">Php {{$item['redemption_f']}}</td>
                    </tr>
                    @endforeach

                   @foreach ($class->details->monthly as $item)
                   <tr>
                       <td class="tbodytd2 sun-text-center">{{$item['month']}}</td>''
                       <td class="tbodytd2 sun-text-center">{{$item['total_interest']}} %</td>
                       <td class="tbodytd2 sun-text-center">Php {{$item['renewal_f']}}</td>
                       <td class="tbodytd2 sun-text-center">Php {{$item['redemption_f']}}</td>
                   </tr>
                   @endforeach
               </tbody>
           </table>

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


           <div></div>

           <br>


           <div></div>
           <div></div>
    </div>
  </body>
</html>






