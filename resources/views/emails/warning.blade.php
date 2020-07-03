
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
		We warn you that your item: <b>{{$item}}</b>
		<br> at <b>{{$pawnshop}}</b>, will due on {{ $duedate }}.
	    </p> 
	    <p>
		Your current claim payment: ₱{{$claim_payment}}.
		<br>
		For your renewal payment: ₱{{$renewal_payment}}.
			</p>
			<br/>
			<p>
				Please paid on time to avoid additional penalty.
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
