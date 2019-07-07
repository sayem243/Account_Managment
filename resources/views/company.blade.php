@extends('layout.Master')

@section('content')




    <div class="text-center"><h2>company profile</h2> </div>




    <form class="form-horizontal" action="{{ route('company_store')}}"  method="post"  enctype="multipart/form-data">

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
                <input type="text" class="form-control" name="name" id="name" placeholder="Company Name">
            </div>
        </div>


        <div class="form-group">
            <label class="control-label col-sm-2" for="regestration_id">Email:</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" name="c_email" id="c_email" placeholder="Company_email">
            </div>
        </div>



        <div class="form-group">
            <label class="control-label col-sm-2" for="mobile">Mobile:</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" name="c_mobile" id="c_mobile" placeholder="Mobile Number  ">
            </div>
        </div>



        <div class="form-group">

            <label class="control-label col-sm-2" for="regestration_id">Company Adress:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="c_address" id="c_address" placeholder="Address">
            </div>

        </div>





        <div class="form-group">

            <label class="control-label col-sm-2" for="c_logo">Company Images</label>
            <div class="col-sm-10">
            <input type="file" class="form-control" name="c_img" id="c_img" placeholder="Images">
            </div>

        </div>




        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-danger">Submit  </button>
            </div>
        </div>



        @endsection