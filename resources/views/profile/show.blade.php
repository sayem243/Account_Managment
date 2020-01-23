@extends('admin.index')
@section('template')

<div class="col-sm-12">
  <div class="row">
      <div class="col-sm-12">
        <div class="card">
           <div class="card-header">
              <h5>User Profile Details</h5>
                  <div class="card-header-right">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
                       <a href="{{route('register')}}" class="btn btn-sm  btn-info"><i class="fas fa-sign-out-alt"></i>Add New</a>
                            </div>
                            <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle btn-more" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-original-title="" title="">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                    <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                    <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                    <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li>

                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="">First Name: </label>
                                  {{$users->UserProfile->fname}}
                              </div>
                              <div class="form-group">
                                  <label for=""> Father's Name :</label>
                                  {{$users->UserProfile->fathername}}
                              </div>
                              <div class="form-group">
                                  <label for="">Present Address :</label>
                                  {{$users->UserProfile->p_address}}
                              </div>

                              <div class="form-group">
                                  <label for="">Company Name:</label>
                                  {{$users->UserProfile->company['name']}}
                              </div>

                              <div class="form-group">
                                  <label class="">Mobile Number :</label>
                                  {{$users->UserProfile->mobile}}
                              </div>

                              <div class="form-group">
                                  <label class="">Joining Date</label>
                                  {{$users->UserProfile->joindate}}
                              </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Last Name:</label>
                                    {{$users->UserProfile->lname}}
                                </div>

                                <div class="form-group">
                                    <label for="">Mother's Name :</label>
                                    {{$users->UserProfile->mothername}}
                                </div>

                                <div class="form-group">
                                    <label for="">Permanent Address :</label>
                                    {{$users->UserProfile->address}}
                                </div>

                                <div class="form-group">
                                    <label for="">NID :</label>
                                    {{$users->UserProfile->nid}}
                                </div>

                                <div class="form-group">
                                    <label for="">Nick Name :</label>
                                    {{$users->name}}
                                </div>



                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
   </div>
@endsection