<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link  real="stylesheet" href="{{asset('css/style.css')}}">

</head>
<body>


<div class="wrapper">

    {{--Navigation --}}

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Account Project</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('index')}}">Home <span class="sr-only">(current)</span></a>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('create')}}">Create User Account </a>

                        <a class="dropdown-item" href="{{route('comp_create')}}">create com_profile</a>
                        <a class="dropdown-item" href="{{route('project_create')}}">Create Projects</a>
                        <a class="dropdown-item" href="{{route('setting_create')}}">create Setting Table </a>
                        <a class="dropdown-item" href="{{route('payment_create')}}"> Payment create</a>

                        <div class="dropdown-divider"></div>


                        <a class="dropdown-item" href="{{route('project')}}">Projects</a>

                        <a class="dropdown-item" href="{{route('setting')}}">Setting Table</a>
                        <a class="dropdown-item" href="{{route('comp_profile')}}">Company Profile</a>


                        <a class="dropdown-item" href="{{route('payment')}}">Payment Details</a>


                    </div>
                </li>

            </ul>



            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>

            {{--LogOut --}}

            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                <button type="button" class="btn btn-outline-warning">Logout</button>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>


        </div>
    </nav>

</div>

<div class="container">


<div class="table-responsive-md">
    <table class= "table table-responsive table-hover">
        <tr>
        <th>Serial</th>
        <th>ID</th>
        <th>Name</th>
        <th>email</th>
        <th>Mobile</th>
        <th>company Details</th>
            <th>Action</th>
        </tr>
        @php $i=0; @endphp
        @foreach($accounts as $account)
            @php $i++ @endphp

        {{--@php $company = App\Company::find($account->company_id) @endphp--}}

        <tr>
            <td>{{$i}}</td>
            <td>{{$account->id}}</td>
            <td>{{$account->name}}</td>
            <td>{{$account->email}}</td>
            <td>{{$account->mobile}}</td>


            <td>  <a href="{{route('comp_view',$account->company_id)}}" class="btn btn-info">Info</a>  </td>

            {{--<td>{{$account->company['name']}}</td>--}}

            <td> <a href="{{route('edit',$account->id)}}" class="btn btn-success">Edit </a></td>
            <td> <a href="{{route('delete',$account->id)}}" class="btn btn-danger">Delete </a></td>

        </tr>
        @endforeach
    </table>
</div>

</div>




{{--CDN javaScript Link--}}

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
