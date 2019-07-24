@extends('admin.index')

@section('template')




{{--<form method="post" action="/register">--}}

<form class="form-horizontal" action="{{ route('account_store')}}" method="post">

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

    {{--<div class="form-group">--}}
    {{--<label class="control-label col-sm-2" for="Name">Name:</label>--}}
    {{--<div class="col-sm-10">--}}
        {{--<input type="text" class="form-control" name="name" id="name" placeholder="Name">--}}
    {{--</div>--}}
{{--</div>--}}


{{--<div class="form-group">--}}
    {{--<label class="control-label col-sm-2" for="regestration_id">Email:</label>--}}
    {{--<div class="col-sm-10">--}}
        {{--<input type="email" class="form-control" name="email" id="email" placeholder="Email">--}}
    {{--</div>--}}
{{--</div>--}}



{{--<div class="form-group">--}}
    {{--<label class="control-label col-sm-2" for="mobile">Mobile:</label>--}}
    {{--<div class="col-sm-10">--}}
        {{--<input type="number" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number">--}}
    {{--</div>--}}
{{--</div>--}}


    {{--<div class="form-group">--}}
        {{--<label class="control-label col-sm-2" for="mobile">NID</label>--}}
        {{--<div class="col-sm-10">--}}
            {{--<input type="number" class="form-control" name="nid" id="nid" placeholder="NID Number">--}}
        {{--</div>--}}
    {{--</div>--}}


    {{--<div class="form-group">--}}
        {{--<label class="control-label col-sm-2" for="mobile">Joining Date</label>--}}
        {{--<div class="col-sm-10">--}}
            {{--<input type="text" class="form-control" name="date" id="date" placeholder="Joining Date">--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="form-group">--}}
        {{--<label class="control-label col-sm-2" for="Name">Address:</label>--}}
        {{--<div class="col-sm-10">--}}
            {{--<input type="text" class="form-control" name="address" id="addres" placeholder="Address">--}}
        {{--</div>--}}
    {{--</div>--}}


    {{--<div class="form-group">--}}
    {{--<label class="control-label col-sm-2" for="text">Company Name:</label>--}}
    {{--<div class="col-sm-10">--}}
        {{--<select name="company_id">--}}
            {{--<option value="">Select Company</option>--}}
            {{--@foreach($companies as $company)--}}
                {{--<option value="{{$company->id}}">{{$company->name}}</option>--}}
                {{--@endforeach--}}
        {{--</select>--}}

    {{--</div>--}}
{{--</div>--}}



    {{--<div class="form-group">--}}
        {{--<label class="control-label col-sm-2" for="project_id">Projects</label>--}}
        {{--<div class="col-sm-10">--}}

            {{--<select name="project_id">--}}
                {{--<option value="">Select User</option>--}}
                {{--@foreach($projects as $project)--}}
                    {{--<option value="{{$project->id}}"> {{$project->p_name}} </option>--}}
                {{--@endforeach--}}
            {{--</select>--}}
        {{--</div>--}}
    {{--</div>--}}






    {{--<div class="form-group">--}}
    {{--<div class="col-sm-offset-2 col-sm-10">--}}
        {{--<button type="submit" class="btn btn-danger">Submit  </button>--}}
    {{--</div>--}}
{{--</div>--}}


    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Form Elements</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Form Componants</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Form Elements</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Basic Componant</h5>
                                        </div>

                                        <div class="card-body">

                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form>

                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Name</label>
                                                            <input type="text" class="form-control" id="names" aria-describedby="name" placeholder="name">
                                                            <small id="name" class="form-text text-muted"></small>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Email address</label>
                                                            <input type="email" class="form-control" id="email" aria-describedby="email" placeholder="Enter email">
                                                            <small id="email" class="form-text text-muted"></small>
                                                        </div>



                                                        {{--<div class="form-group">--}}
                                                            {{--<label for="exampleInputPassword1">Password</label>--}}
                                                            {{--<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">--}}
                                                        {{--</div>--}}



                                                    </form>

                                                </div>
                                                <div class="col-md-6">
                                                    <form>
                                                        <div class="form-group">
                                                            <label>Text</label>
                                                            <input type="text" class="form-control" placeholder="Text">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1">Example select</label>
                                                            <select class="form-control" id="exampleFormControlSelect1">
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                                <option>5</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1">Example select</label>
                                                            <select class="form-control" id="exampleFormControlSelect2">
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                                <option>5</option>
                                                            </select>
                                                        </div>




                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1">Example textarea</label>
                                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="1"></textarea>
                                                        </div>


                                                    </form>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>


                                        </div>

                                    </div>
                                    <!-- Input group -->

                                </div>
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Form Elements</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Form Componants</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Form Elements</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Basic Componant</h5>
                                        </div>

                                        <div class="card-body">

                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form>

                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Name</label>
                                                            <input type="text" class="form-control" id="names" aria-describedby="name" placeholder="name">
                                                            <small id="name" class="form-text text-muted"></small>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Email address</label>
                                                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                                            <small id="emailHelp" class="form-text text-muted"></small>
                                                        </div>



                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Password</label>
                                                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                                        </div>



                                                    </form>

                                                </div>
                                                <div class="col-md-6">
                                                    <form>
                                                        <div class="form-group">
                                                            <label>Text</label>
                                                            <input type="text" class="form-control" placeholder="Text">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1">Example select</label>
                                                            <select class="form-control" id="exampleFormControlSelect1">
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                                <option>5</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1">Example select</label>
                                                            <select class="form-control" id="exampleFormControlSelect2">
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                                <option>4</option>
                                                                <option>5</option>
                                                            </select>
                                                        </div>




                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1">Example textarea</label>
                                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="1"></textarea>
                                                        </div>


                                                    </form>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>


                                        </div>

                                    </div>
                                    <!-- Input group -->

                                </div>
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





</form>

@endsection