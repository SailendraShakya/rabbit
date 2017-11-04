@extends('main')
@section('content')
@include('errors')
<div class="clearboth"></div>
{!! Form::open(array('url' => 'client/create','clsss' => 'form-control','id'=> 'enq_form')) !!}
<input type="hidden" id="csrf" name="_token" value="{{ csrf_token() }}">
<div class="search-wrapper">
	<div class="search left">
		{{ Form::text('place', null, ['class' => 'form-control input-sm','id' => 'search-city', 'placeholder' => 'Search']) }}
		{{ Form::submit('Submit Form', ['class' => 'btn btn-primary btn-sm','id' => 'search']) }}
	</div>
</div>
<div class="history-wrapper"><a href="" class="btn-sm">History</a></div>


<div class="clearfix"></div>
<div class="">
	<h1>Map Here</h1>
	<div id="map-canvas" style="height:50em">
	</div>
</div>
{!! Form::close() !!}
@endsection
