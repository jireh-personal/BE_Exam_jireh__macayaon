@extends('welcome')
@section('content')
<div class="container container-table">
    <div class="row d-flex justify-content-center align-items-center" style="height:100%;">
        <div class="col-lg-6 col-md-8 col-sm-12 mt-2">
            <div class="card border shadow mb-5 bg-white rounded border-primary">
                <div class="card-header bg-primary text-light"><i class="fa fa-trash"></i> SIGN UP</div>
                <div class="card-body">
                    @if(Session::has('error'))
                    <p class="text-danger">{{ Session::get('error') }}</p>
                    @endif
                    <form method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="row form-group">
                            <label for="name" class="col-sm-12 col-md-4 col-lg-3 col-form-label">Name</label>
                            <div class="col-sm-12 col-md-8 col-lg-9">
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                                @if($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>                            
                        </div>
                        <div class="row form-group mt-2">
                            <label for="username" class="col-sm-12 col-md-4 col-lg-3 col-form-label">Username</label>
                            <div class="col-sm-12 col-md-8 col-lg-9">
                                <input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}">
                                @if($errors->has('username'))
                                    <p class="text-danger">{{ $errors->first('username') }}</p>
                                @endif
                            </div>                            
                        </div>
                        <div class="row form-group mt-2">
                            <label for="email" class="col-sm-12 col-md-4 col-lg-3 col-form-label">Email</label>
                            <div class="col-sm-12 col-md-8 col-lg-9">
                                <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}">
                                @if($errors->has('email'))
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>                            
                        </div>
                        <div class="row form-group mt-2">
                            <label for="password" class="col-sm-12 col-md-4 col-lg-3 col-form-label">Password</label>
                            <div class="col-sm-12 col-md-8 col-lg-9">
                                <input type="password" class="form-control" name="password" id="password">
                                @if($errors->has('password'))
                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group mt-2">
                            <label for="password_confirmation" class="col-sm-12 col-md-4 col-lg-3 col-form-label">Confirm Password</label>
                            <div class="col-sm-12 col-md-8 col-lg-9">
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                                @if($errors->has('password_confirmation'))
                                    <p class="text-danger">{{ $errors->first('password_confirmation') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3 text-right">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary btn-md float-end">Register</button>
                            </div>
                        </div>                        
                    </form>
                    <div class="row">
                        <div class="col">
                            <span><a href="/">Sign In</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection