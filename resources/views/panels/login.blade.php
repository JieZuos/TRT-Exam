@extends('index')
@section('content')
<div class="screen">
    <div class="loader">
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>
  
  </div>
<div class="container" id="loginContainer">
    <div class="card">
        <h2 class="mb-2">Login</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="text" name="email" id="lUsername" placeholder="Email" required>
            <input type="password" name="password" id="lPassword" placeholder="Password" required>
            <button class="mt-3" type="submit">Login</button>
            <p class="text-muted mt-2">Don't have an account yet? <a href="#" id="showSignup">Sign-up now</a></p>
        </form>
    </div>
</div>

<div class="container" id="signupContainer">
    <div class="card p-4">
        <h2 class="mb-4">Signup</h2>
            <div class="row mb-3">
                <div class="col-12">
                    <input type="text" class="form-control" id="sName" placeholder="Name" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <input type="text" class="form-control" id="sUsername" placeholder="Username" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <input type="email" class="form-control" id="sEmail" placeholder="Email" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <input type="password" class="form-control" id="sPass" placeholder="Password" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <input type="password" class="form-control" id="sConPass" placeholder="Confirm Password" required>
                </div>
                <span class="text-muted" id="passInfo">Make a password with 8 or more characters</span>
            </div>
            <div class="row mb-3" id="user-details"> 
                <div class="col-12 mb-3">
                    <input type="number" class="form-control" id="sTele" placeholder="Telephone Number">
                </div>
                <div class="col-12 mb-3">
                    <input type="text" class="form-control" id="sAddr1" placeholder="Address Line 1">
                </div>
                <div class="col-12 mb-3">
                    <input type="text" class="form-control" id="sAddr2" placeholder="Address Line 2">
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <input type="text" class="form-control" id="sCity" placeholder="City">
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control" id="sState" placeholder="State / Province">
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <input type="number" class="form-control" id="sZip" placeholder="Zip Code">
                </div>                
            </div>
            <button class="btn btn-primary mt-3" id="signUp">Register</button>
            <p class="text-muted mt-2">Already have an account? <a href="#" id="showLogin">Log-in Here</a></p>
    </div>
</div>
@endsection

