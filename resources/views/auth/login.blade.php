<!doctype html>
<html lang="vi">
@include('layouts.masterLayout')
@include('layouts.header')
<body style="position:relative;">
    <div class="row justify-content-center project-content-section">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Đăng nhập</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('auth.login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">Username</label>

                            <div class="col-md-6">
                                <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Mật khẩu</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        Ghi nhớ đăng nhập
                                    </label>
                                </div>
                            </div>
                        </div>



                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary normal-button">
                                    Đăng nhập
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Quên mật khẩu?
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-3 d-flex justify-content-center" >
                            <h5 style="width:auto;">Đăng nhập thông qua </h5>
                        </div>
                        <div class="row mb-4">
                            <div class="d-flex justify-content-center">
                                <a class="parties3-logo-link" href={{route('auth.google.googleLogin')}}><img class="parties3-logo-login" src="{{asset('storage/logo/logo-google-1.png')}}"></a>
                                {{-- <a class="parties3-logo-link" href={{route('auth.facebook.facebookLogin')}}><img class="parties3-logo-login" src="{{asset('storage/logo/logo-facebook.png')}}"></a>
                                <a class="parties3-logo-link" href={{route('auth.vk.vkLogin')}}><img class="parties3-logo-login" src="{{asset('storage/logo/logo-vk.png')}}"></a> --}}
                                <a class="parties3-logo-link" href={{route('auth.zalo.zaloLogin')}}><img class="parties3-logo-login" src="{{asset('storage/logo/logo-zalo.svg')}}"></a>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
