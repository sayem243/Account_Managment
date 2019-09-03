@extends('admin.index')
@section('template')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>New Company</h5>
                    </div>

                   <div class="card-block">
                    <div class="card-body">

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

      <div class="row">
          <div class="col-md-6">

              <div class="form-group">
                  <label class="col-form-label" for="name">Company Name <span class="required">*</span></label>
                  <div class="col-form-label">
                      <input type="text" class="form-control" name="name" id="name" aria-describedby="validationTooltipUsernamePrepend" required="">
                  </div>
              </div>

          <div class="form-group">
                   <label class="col-form-label" for="email">Email Address<span class="required">*</span></label>
                      <div class="col-form-label">
                         <input type="text" class="form-control" name="c_email" id="c_email" aria-describedby="validationTooltipUsernamePrepend" required="">

                   </div>
            </div>

                <div class="form-group">
                    <label class="col-form-label" for="mobile">Mobile No <span class="required">*</span></label>
                    <div class="col-form-label">
                        <input type="text" class="form-control" name="c_mobile" id="c_mobile" aria-describedby="validationTooltipUsernamePrepend" required="">
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
                              <textarea type="text" class="form-control"  rows="6" name="c_address" id="c_address" aria-describedby="validationTooltipUsernamePrepend" required=""></textarea>
                          </div>
                      </div>


                  </div>

      </div>
                            {{--<div class="separator"></div>--}}

                            <div class="line aligncenter">

                                <div class="form-group row">
                                    <div class="col-sm-3 col-form-label"></div>
                                    <div class="col-sm-12 col-form-label" align="right">

                                        {{--<button type="reset" class="btn btn btn-outline-danger" data-original-title="" title=""> <i class="feather icon-refresh-ccw"></i> Cancel</button>--}}
                                        <button type="submit" class="btn btn-primary" data-original-title="" title=""> <i class="feather icon-save"></i> Save</button>
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

