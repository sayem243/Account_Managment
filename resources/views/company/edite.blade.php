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
                                <a href="{{route('comp_profile')}}" class="btn btn-info"><i class="fa fa-angle-double-left"></i> Back</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-block">
                        <div class="card-body">

                            <form class="form-horizontal" action="{{ route('comp_update',$company->id)}}"  method="post"  enctype="multipart/form-data">

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
                                                <input type="text" class="form-control" name="name" id="name" aria-describedby="validationTooltipUsernamePrepend" value="{{$company->name}}" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label" for="email">Email Address<span class="required">*</span></label>
                                            <div class="col-form-label">
                                                <input type="text" class="form-control" name="c_email" id="c_email" aria-describedby="validationTooltipUsernamePrepend" value="{{$company->c_email}}" required="">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label" for="mobile">Mobile No <span class="required">*</span></label>
                                            <div class="col-form-label">
                                                <input type="text" class="form-control" name="c_mobile" id="c_mobile" aria-describedby="validationTooltipUsernamePrepend" value="{{$company->c_mobile}}" required="">
                                                <span class="help-block">Company's valid mobile no</span>
                                                <div class="invalid-tooltip">
                                                    Please provide a valid mobile no.
                                                </div>
                                            </div>
                                        </div>

                                    </div>




                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="name">Company Address <span class="required">*</span></label>
                                            <div class="col-form-label">
                                                <textarea type="text" class="form-control"  rows="11" name="c_address" id="c_address" aria-describedby="validationTooltipUsernamePrepend" required="">{{$company->c_address}}</textarea>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                                {{--<div class="separator"></div>--}}

                                <div class="line aligncenter" style="float: right">
                                    <div class="form-group row">
                                        <div style="padding-right: 3px" class="col-sm-12 col-form-label btn-group btn-group-lg" align="right">
                                            <button style="margin-right: 0" type="submit" class="btn btn-info"> <i class="feather icon-save"></i> Save</button>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

