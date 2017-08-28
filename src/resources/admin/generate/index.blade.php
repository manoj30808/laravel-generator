@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div>
                    <h3 class="box-title">
                        <a class="btn btn-sm btn-primary" href="{{$ctrl_url}}/create">
                            Add Module
                        </a>
                    </h3>
                </div>
                <div class="table-responsive">
                    <table id="example1" class="table">
                        @if($items->count())
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Icon</th>
                                <th>Is Menu</th>
                                <th>Status</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $value)
                            <tr>
                                <td>{{$srno++ }}</td>
                                <td>{{$value->name}}</td>
                                <td>{{$value->slug}}</td>
                                <td>{{$value->icon}}</td>
                                <td>
                                    <label class="label label-{{(!empty($value->is_display_in_menu))?'success':'danger'}}">
                                        {{ (!empty($value->is_display_in_menu))?'Yes':'No' }}
                                    </label>
                                </td>
                                <td>
                                    <label class="label label-{{(!empty($value->status))?'success':'danger'}}">
                                        {{ (!empty($value->status))?'Active':'Inactive' }}
                                    </label>
                                </td>
                                <td>
                                {!! Form::open(array('url' => $ctrl_url.'/'.$value->id,'method'=>'delete','class'=>'form-inline')) !!}
                                    <a href="{!! url($ctrl_url.'/'.$value->id.'/edit') !!}" class="btn btn-small btn-primary">Edit</a>
                                    {{-- <button type="submit" class="btn btn-danger delete-confirm">Delete</span></button>  --}}
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