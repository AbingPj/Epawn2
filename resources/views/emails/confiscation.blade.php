
@extends('beautymail::templates.widgets')

@section('content')

    @include('beautymail::templates.widgets.articleStart')

        <div class="text-center">
		<h4 class="secondary">
		<strong>
		Hi {{ ucfirst($customer) }},</strong></h4>
		{{-- Hi Pj Abing,</strong></h4> --}}
		<br/>
		<br/>  
		
		<p>
		We warning you that your item: <b>{{$item}}</b>
		<br> at <b>{{$pawnshop}}</b>, will confiscate after on {{ $duedate }}.
	    </p> 
	    <p>
		Your claim payment: ₱{{$claim_payment}}.
		<br>
		For your renewal payment: ₱{{$renewal_payment}}.
	    </p>
		
		<br/>
		<p>
		Cheers,
		</p>

		<p>
		E-Pawn | Team Revil
        </p>
        </div>

	
	@include('beautymail::templates.widgets.articleEnd')

@stop
