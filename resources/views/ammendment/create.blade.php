@extends('admin.index')
@section('template')

    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">
              <h3> Amendment</h3>
            </div>

          <div class="card-body">

                <form class="form-horizontal" action="{{ route('amendment_store',$payment->id)}}" method="post" enctype="multipart/form-data">

                    {{ csrf_field() }}

                    <div class="form-group row">
            <label for="additional" class="col-sm-2 col-form-label">Additional Amount</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" name="additional_amount" id="additional_amount" placeholder="">
            </div>
            </div>




                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-danger">Approve  </button>
                        </div>
                    </div>



                </form>


          </div>





        </div>
    </div>







@endsection
