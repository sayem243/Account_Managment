@extends('admin.index')
@section('template')



    <div class="col-sm-12">
        <div class="card" id="references">
            <div class="card-header">

                <h5 > Amendment </h5>

                <table class="table table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Amendment</th>

                        <th scope="col text-center" class="sorting_disabled" rowspan="1" colspan="1" aria-label style="width: 24px;">
                            <i class="feather icon-settings"></i>

                        </th>

                    </tr>
                    </thead>




                @php $i=0; @endphp

                @foreach($amendments as $amendment)
                    @php $i++ @endphp

                    <tr>
                        <td>{{$i}}</td>

                        <td>{{$amendment->additional_amount}}</td>

                    </tr>

                    @endforeach

                </table>

            </div>
        </div>
    </div>


@endsection
