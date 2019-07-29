@extends('admin.index')

@section('template')

    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Profile View</h5>
            </div>

            <div class="card-body">


                <form class="form-horizontal" method="POST" action="{{ route('userprofile_store') }}">

                    {{ csrf_field() }}

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="fname" id="fname"placeholder="First Name">
                            </div>





                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label">E-Mail Address</label>

                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                                             </span>
                                @endif

                            </div>


                            <div class="form-group">
                                <label>Mothers Name</label>
                                <input type="text" class="form-control" name="mothername" id="mothername"placeholder="Text">
                            </div>



                            <div class="form-group">
                                <label for="p_address">Present Address</label>
                                <textarea class="form-control" name="p_address" id="p_address" rows="1"></textarea>
                            </div>


                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input type="text" class="form-control" name="mobile" id="mobile"placeholder="Mobile">
                            </div>




                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lname" id="lname"placeholder="Last Name">
                            </div>





                            <div class="form-group">
                                <label for="exampleFormControlSelect1">select company</label>
                                <select class="form-control" name="company_id" >
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}"> {{$company->name}} </option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="form-group">
                                <label>Fathers Name</label>
                                <input type="text" class="form-control" name="fathername" id="fathername"placeholder="Text">
                            </div>



                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Permanent Address</label>
                                <textarea class="form-control" id="address" name="address" rows="1"></textarea>
                            </div>








                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">NID</label>
                                <textarea class="form-control" id="nid" name="nid" rows="1"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="joindate">joining Date</label>
                                <textarea class="form-control" id="joindate" name="joindate" rows="1"></textarea>
                            </div>


                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>

            </div>

        </div>
        <!-- Input group -->

    </div>




@endsection
