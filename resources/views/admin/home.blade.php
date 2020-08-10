@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                <div class="card-body">
                <a href="{{ route('admin.addngo')}}" class="btn btn-primary mb-8">Add NGO</a>
                <table class="table mt-8">
                    <thead>
                      <tr>
                        <th>name</th>
                        <th>Register No</th>
                        <th>Create Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_vendor as $item)       
                        <tr>
                        <td>{{ $item->user->user_name}}</td>
                        <td>{{ $item->regno}}</td>
                        <td>{{ $item->created_at }}</td>
                        <td> <a href="{{ $item->user->user_id}}">Edit</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>  
                @if (session('status'))
                    
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- {{ __('You are logged in!') }} --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
