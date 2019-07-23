@extends('admin.index')

@section('template')

    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">

                <div class="container">


                    <div class="text-center"><h2>company profile</h2> </div>




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





                        <div class="form-group">
                            <label class="control-label col-sm-2" for="Name">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Company Name" value="{{$company->name}}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-sm-2" for="regestration_id">Email:</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="c_email" id="c_email" placeholder="Company_email" value="{{$company->c_email}}">
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="control-label col-sm-2" for="mobile">Mobile:</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="c_mobile" id="c_mobile" placeholder="Mobile Number" value="{{$company->c_mobile}}" >
                            </div>
                        </div>



                        <div class="form-group">

                            <label class="control-label col-sm-2" for="regestration_id">Company Adress:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="c_address" id="c_address" placeholder="Address" value="{{$company->c_address}}">
                            </div>

                        </div>





                        <div class="form-group">

                            <label class="control-label col-sm-2" for="c_logo">Company Images</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="c_img" id="c_img" placeholder="Images" value="{{$company->c_img}}">
                            </div>

                        </div>




                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-danger">Submit  </button>
                            </div>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>


@endsection