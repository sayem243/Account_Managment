@extends('layout')
@section('title','Update Company')
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Company</h5>
                        <div class="card-header-right">
                            <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
                                <a href="{{route('expenditure_sector_index')}}" class="btn btn-info"><i class="fa fa-angle-double-left"></i> Back</a>
                            </div>
                        </div>
                    </div>

                        <div class="card-body">

                            <form class="form-horizontal" action="{{ route('expenditure_sector_update',$expenditureSector->id)}}"  method="post"  enctype="multipart/form-data">

                                {{ csrf_field() }}
                                {{--error showing --}}

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="col-form-label" for="name">Company Name <span class="required">*</span></label>
                                            <div class="col-form-label">
                                                <input type="text" class="form-control" name="name" id="name" aria-describedby="validationTooltipUsernamePrepend" value="{{$expenditureSector->name}}" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="separator"></div>--}}

                                <div class="line aligncenter" style="float: right">
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-form-label btn-group btn-group-lg" align="right">
                                            <button style="margin-right: 0" type="submit" class="btn btn-info btn-lg" data-original-title="" title=""><i class="feather icon-save"></i> Save</button>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </div>

                </div>
            </div>
        </div>
    </div>

@endsection

