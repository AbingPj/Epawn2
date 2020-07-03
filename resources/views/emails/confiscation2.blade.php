
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
		Your item: <b>{{$item}}</b>
		<br> at <b>{{$pawnshop}}</b>, has been confiscated, due to your last due date is: {{ $duedate }}.
		<br/>
		<p>
		Sincerly,
		</p>

		<p>
		E-Pawn | Team Revil
        </p>
        </div>

	
	@include('beautymail::templates.widgets.articleEnd')

@stop
