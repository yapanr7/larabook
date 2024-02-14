@extends('layouts.app')

@section('content')
  <div class="container mt-80">
      <div class="row justify-content-center">
          <div class="col-md-6 mx-auto">
              <div class="card">
                  <div class="card-header">Reset Password</div>
                  <div class="card-body">

                      <form action="{{ route('reset.password.post') }}" method="POST">
                          @csrf
                          <input type="hidden" name="token" value="{{ $token }}">

                          <div class="form-group mb-3">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif

                          </div>

                          <div class="form-group mb-3">
                              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                  <input type="password" id="password" class="form-control" name="password" required autofocus>
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif

                          </div>

                          <div class="form-group mb-3">
                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                  <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>
                                  @if ($errors->has('password_confirmation'))
                                      <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                  @endif


                          </div>
                          <button type="submit" class="btn w-100 btn-primary">
                            Reset Password
                        </button>
                      </form>

                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection
