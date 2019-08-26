@extends('admin.index')

@section('template')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
        <div class="card" >
            <div class="card-header">
            <h5 align="center">User Sub Type Form</h5>
            </div>
            <div class="card-block">
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
    <label class="col-form-label" for="u_title">Tittle :</label>
    <div class="col-form-label">
        <input type="text" class="form-control" name="u_title" id="u_title" placeholder="User Tittle">
    </div>
</div>






    </div>
    </div>

     <div class="separator"></div>

    <div class="line aligncenter">

     <div class="form-group row">
      {{--<div class="col-sm-3 col-form-label"></div>--}}
       <div class="col-sm-12 col-form-label" align="right">
        <button type="submit" class="btn purple-bg white-font" data-original-title="" title=""> <i class="feather icon-save"></i>Save</button>
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