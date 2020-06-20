@extends('layout')

@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 align="center">User Type</h5>
                        <div class="card-header-right">
                            <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
                                <a href="{{route('usertype')}}" class="btn btn-sm  btn-info"><i class="fas fa-angle-double-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('usertype_store')}}" method="post">

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
                                            <label class="col-form-label" for="u_title">Title :</label>
                                            <div class="col-form-label">
                                                <input type="text" class="form-control" name="u_title" id="u_title"
                                                       placeholder="User Type">
                                            </div>
                                        </div>


                                    </div>
                                </div>


                                <div class="line aligncenter" style="float: right">
                                    <div class="form-group row">
                                        <div style="padding-right: 3px"
                                             class="col-sm-12 col-form-label btn-group btn-group-lg" align="right">
                                            <button style="margin-right: 0" type="submit" class="btn btn-info"><i
                                                        class="feather icon-save"></i> Save
                                            </button>
                                            {{--<button type="reset" class="btn btn btn-outline-danger" data-original-title="" title=""> <i class="feather icon-refresh-ccw"></i> Cancel</button>--}}
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