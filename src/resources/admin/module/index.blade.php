@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div>
                    <h3 class="box-title">
                        <a class="btn btn-sm btn-primary" href="{{$ctrl_url}}/create">
                            Add {{$module_basic_details['name']}}
                        </a>
                    </h3>
                </div>
                <div class="table-responsive">
                    <table id="example1" class="table">
                        <thead>
                            <tr>
                                <th width="10">#</th>
                                @foreach ($module_basic_details['fields'] as $value)
                                    @if (in_array('index', explode(',', $value['visibility'])))
                                        <th>{{ $value['display_name'] }}</th>
                                    @endif
                                @endforeach

                                <th width="200">Action</th>
                            </tr>
                        </thead>
                        @if($items->count())
                            <tbody>
                                @foreach ($items as $value)
                                <tr>
                                    <td>{{$srno++ }}</td>
                                    
                                    @foreach ($module_basic_details['fields'] as $field)
                                        @if (in_array('index', explode(',', $field['visibility'])))
                                            <?php $field_value = $field['field'];?>
                                            <td>{!!$value->{$field_value}!!}</td>
                                        @endif
                                    @endforeach

                                    <td>
                                    {!! Form::open(array('url' => $ctrl_url.'/'.$value->id,'method'=>'delete','class'=>'form-inline')) !!}
                                        <a href="{{ url($ctrl_url.'/'.$value->id.'/edit') }}" class="btn btn-small btn-primary">Edit</a>
                                        <button type="submit" class="btn btn-danger delete-confirm">Delete</span></button> 
                                    {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        @else
                        <tbody>
                            <tr>
                                <th>There are no records</th>
                            </tr>
                        </tbody>
                        @endif
                    </table>
                </div>
                {!! str_replace('/?', '?', $items->appends(Request::except(array('page')))->render()) !!}
            </div>
        </div>
    </div>
</div>
@endsection