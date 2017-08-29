@extends('layouts.app')
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('content')
<style type="text/css">
	.formRow.row1{
		border-bottom: 2px solid #dfdfdf !important;
	}
</style>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="white-box">
					<!-- form start -->
					{!! Form::model($item, array('method' => 'PATCH', 'url' => $ctrl_url.'/'.$item['id'],'class'=>'form-horizontal')) !!}
					<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
						<label class="col-sm-2 control-label">Module Name</label>
						<div class="col-sm-3">
							{!! Form::text('name',null,array('class'=>'form-control')) !!}
							{!! $errors->first('name', '<span class="help-block">:message</span>') !!}
						</div>
					
					 	<label class="col-sm-2 control-label">Url Slug</label>
						<div class="col-sm-3">
							{!! Form::text('slug',null,array('class'=>'form-control')) !!}
							{!! $errors->first('slug', '<span class="help-block">:message</span>') !!}
						</div>
					</div>
					<div class="form-group {{ $errors->has('icon') ? 'has-error' : '' }}">
						<label class="col-sm-2 control-label">Icon</label>
						<div class="col-sm-3">
							{!! Form::text('icon',null,array('class'=>'form-control')) !!}
							{!! $errors->first('icon', '<span class="help-block">:message</span>') !!}
						</div>
					 
					 	<label class="col-sm-2 control-label">Is Display In Menu</label>
						<div class="col-sm-3">
							{!! Form::checkbox('is_display_in_menu', 1, true, array('class' => '')) !!}
							{!! $errors->first('is_display_in_menu', '<span class="help-block">:message</span>') !!}
						</div>
					</div>
					<div class="form-group {{ $errors->has('icon') ? 'has-error' : '' }}">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-3">
							{!! Form::hidden('is_model', 1) !!}
							{!! Form::checkbox('status', 1, true, array('class' => '')) !!}
							{!! $errors->first('status', '<span class="help-block">:message</span>') !!}
						</div>
					</div>

					<table  cellpadding="0" cellspacing="0" width="100%"  id="">
	                    <thead>
	                        <tr>
	                            <th width="200" style="vertical-align:middle">Field<strong class="mendatory">*</strong></th>
	                            <th width="200" style="vertical-align:middle">Display Name<strong class="mendatory">*</strong></th>
	                            <th width="200" style="vertical-align:middle">Input Type<strong class="mendatory">*</strong></th>
	                            <th width="200" style="vertical-align:middle">Visibility</th>
	                            <th width="200" style="vertical-align:middle">Validation</th>
	                            <th width="50" style="vertical-align:middle;"> 
	                            	{!! Form::button('Add',array('class' => 'tablectrl_small bBlue tipS ','id'=>'incrementor'))!!}
	                            </th>
	                        </tr>
	                    </thead>
	                    <tbody id="template-destination">
	                    	<?php $row = (isset($old))?$old['row']:$item['sub'];?>
	                    	@foreach ($row as $key=>$value)
	                    		<tr class="formRow row1" id="unique_Row-{{$key}}">
						            <td>
						            	{!! Form::text("row[$key][field]",old('field',$value->field),array('class'=>'field','id'=>"field-$key",'style'=>'')) !!}
						            </td>
						            <td>
						            	{!! Form::text("row[$key][display_name]",old('display_name',$value->display_name),array('class'=>'display_name','id'=>"display_name-$key",'style'=>'')) !!}
						            </td>
						            <td>
						                {!! Form::select("row[$key][input_type]",$data['input_type'],old('input_type',$value->input_type),array('class'=>'input_type select-dynamic form-control','id'=>"input_type-$key","style"=>"width:200px;")) !!}
						            </td>
						            <td>
						                {!! Form::checkbox("row[$key][visibility][index]", 'index', (in_array('index', explode(',', $value->visibility)))?true:false, array('class' => '')) !!} <strong>Index</strong> <br/> 
							        	{!! Form::checkbox("row[$key][visibility][create]", 'create', (in_array('create', explode(',', $value->visibility)))?true:false, array('class' => '')) !!} <strong>Create</strong>  <br/>
							        	{!! Form::checkbox("row[$key][visibility][edit]", 'edit', (in_array('edit', explode(',', $value->visibility)))?true:false, array('class' => '')) !!} <strong>Edit</strong>  <br/>
							        	{!! Form::checkbox("row[$key][visibility][search]", 'search', (in_array('search', explode(',', $value->visibility)))?true:false, array('class' => '')) !!} <strong>Search</strong>  <br/>
						            </td>
						            <td>
						            	 {!! Form::checkbox("row[$key][validation][]", 'required', (in_array('required', explode('|', $value->validation)))?true:false, array('class' => '')) !!} <strong>Required</strong> <br/> 
						            	 {!! Form::checkbox("row[$key][validation][]", 'numeric', (in_array('numeric', explode('|', $value->validation)))?true:false, array('class' => '')) !!} <strong>Numeric</strong>  <br/>
						            	 {!! Form::text("row[$key][validation][]",old('validation'),['placeholder'=>'Other Validation']) !!}
						            </td>
						            <td>
						                <a href="javascript:void(0);" class="tablectrl_small bRed tipS removerow" id="{{$key}}">Remove</a>                
						            </td>
						        </tr>
	                    	@endforeach
	                    </tbody> 
	                </table>
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
<table>
    <tbody class="hide" id="template-source">
        <tr class="formRow row1" id="unique_Row-key">
            <td>
            	{!! Form::text("row[key][field]",old('field'),array('class'=>'field','id'=>'field-key','style'=>'')) !!}
            </td>
            <td>
            	{!! Form::text("row[key][display_name]",old('display_name'),array('class'=>'display_name','id'=>'display_name-key','style'=>'')) !!}
            </td>
            <td>
                {!! Form::select("row[key][input_type]",$data['input_type'],old('input_type'),array('class'=>'input_type select-dynamic form-control','id'=>"input_type-key","style"=>"width:200px;")) !!}
            </td>
            <td>
                {!! Form::checkbox('row[key][visibility][index]', 'index', true, array('class' => '')) !!} <strong>Index</strong> <br/> 
	        	{!! Form::checkbox('row[key][visibility][create]', 'create', true, array('class' => '')) !!} <strong>Create</strong>  <br/>
	        	{!! Form::checkbox('row[key][visibility][edit]', 'edit', true, array('class' => '')) !!} <strong>Edit</strong>  <br/>
	        	{!! Form::checkbox('row[key][visibility][search]', 'search', false, array('class' => '')) !!} <strong>Search</strong>  <br/>
            </td>
            <td>
            	 {!! Form::checkbox('row[key][validation][]', 'required', false, array('class' => '')) !!} <strong>Required</strong> <br/> 
            	 {!! Form::checkbox('row[key][validation][]', 'numeric', false, array('class' => '')) !!} <strong>Numeric</strong>  <br/>
            	 {!! Form::text('row[key][validation][]','',['placeholder'=>'Other Validation']) !!}
            </td>
            <td>
                <a href="javascript:void(0);" class="tablectrl_small bRed tipS removerow" id="key">Remove</a>                
            </td>
        </tr>
    </tbody>
</table>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/addmore.js')}}"></script>
<script type="text/javascript">
	var flag=true;
    if($('#template-destination .row1').length!=0){
        flag=false;
    }
    console.log($('#incrementor'));
    $.addmore("#template-source","#template-destination","#incrementor",".removerow",flag,".row1",1);
</script>
@stop
