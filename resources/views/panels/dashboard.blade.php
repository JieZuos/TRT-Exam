@extends('index')
@section('content')
<div class="container">
    <div class="card">
        <h4 class="mb-2">Congratulations {{ Auth::user()->name }} on Registering on this application</h2>
        <p class="">Thank you and have a Good Day</p>
        
        <form action="{{ route('logout') }}" method="POST" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
</div>
@endsection
