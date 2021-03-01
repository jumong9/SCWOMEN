@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('가입신청') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('auth.registerdo') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"><span class="text-danger">*</span>{{ __('이름') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"><span class="text-danger">*</span>{{ __('이메일') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="로그인시 사용 할 이메일">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><span class="text-danger">*</span>{{ __('비밀번호') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="8자 이상 입력">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right"><span class="text-danger">*</span>{{ __('비밀번호확인') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label text-md-right"><span class="text-danger">*</span>{{ __('핸드폰') }}</label>
                            <div class="col-md-6">
                                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required placeholder="010-XXXX-XXXX">

                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="class" class="col-md-4 col-form-label text-md-right"><span class="text-danger">*</span>{{ __('강사단') }}</label>
                            <div class="col-md-6">
                                <select name="class_category_id" id="class_category_id" class="form-control">
                                    {{-- @foreach($items as $key=>$value)
                                      <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach --}}
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->class_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="group" class="col-md-4 col-form-label text-md-right">{{ __('강사단기수') }}</label>
                            <div class="col-md-6">
                                <input id="group" type="number" class="form-control @error('group') is-invalid @enderror" name="group" value="{{ old('group') }}" >

                                @error('group')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birthday" class="col-md-4 col-form-label text-md-right"><span class="text-danger">*</span>{{ __('생년월일') }}</label>
                            <div class="col-md-6">
                                <input id="birthday" type="text" class="form-control datepicker @error('birthday') is-invalid @enderror" name="birthday" required value="{{ old('birthday') }}" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="zipcode" class="col-md-4 col-form-label text-md-right " ><span class="text-danger">*</span>{{ __('우편번호') }}</label>
                            <div class="col-md-3 row-fluid">
                                <input id="zipcode" type="text" class="form-control postcodify_postcode5 @error('zipcode') is-invalid @enderror" name="zipcode" required value="{{ old('zipcode') }}"  >
                            </div>
                            <button class="btn btn-primary" type="button"  id="postcodify_search_button">조회</button>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right"><span class="text-danger">*</span>{{ __('주소') }}</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control postcodify_address @error('address') is-invalid @enderror" name="address" required value="{{ old('address') }}" >
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('등록하기') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script src="//d1p7wdleee1q2z.cloudfront.net/post/search.min.js"></script>
<script> $(function() { $("#postcodify_search_button").postcodifyPopUp(); }); </script>

@endsection
