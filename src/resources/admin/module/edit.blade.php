@extends('layouts.app')
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="white-box">
					<h1 style="margin-left: 20%"> {{$module_basic_details['name']}} </h1>
					<hr>
					<!-- form start -->
					{!! Form::model($item, array('method' => 'PATCH', 'url' => $ctrl_url.'/'.$item->id,'class'=>'form-horizontal')) !!}
					
					@foreach ($module_basic_details['fields'] as $value)
                        @if (in_array('create', explode(',', $value['visibility'])))
							<div class="form-group {{ $errors->has($value['field']) ? 'has-error' : '' }}">
								<label class="col-sm-3 control-label">{{$value['display_name']}}</label>
								<div class="col-sm-6">
									{!! Form::text($value['field'],$item->{$value['field']},array('class'=>'form-control','placeholder'=>"$value[display_name]")) !!}
									{!! $errors->first($value['field'], '<span class="help-block">:message</span>') !!}
								</div>
							</div>
						@endif
                    @endforeach

	                <br/>
	                <br/>
					<div class="form-group m-b-0 text-center">
						<div class="col-sm-12">
							<button type="submit" name="save" class="btn btn-info waves-effect waves-light m-t-10">Update</button>
							<a class="btn btn-danger waves-effect waves-light m-t-10" href="{{ url($ctrl_url) }}">Cancel</a>
						</div>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</section>
@stop
