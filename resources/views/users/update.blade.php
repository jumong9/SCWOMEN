@extends('layouts.main_layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('개인정보수정') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('auth.myinfo.updateDo') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('이름') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $userInfo->name }}"  readonly>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('이메일') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $userInfo->email }}"  readonly>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('핸드폰') }}</label>
                            <div class="col-md-6">
                                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ $userInfo->mobile }}" required autocomplete="mobile" >

                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="birthday" class="col-md-4 col-form-label text-md-right">{{ __('생년월일') }}</label>
                            <div class="col-md-6">
                                <input id="birthday" type="text" class="form-control datepicker @error('birthday') is-invalid @enderror" readonly name="birthday" value="{{ $userInfo->birthday }}" autocomplete="birthday" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birthday" class="col-md-4 col-form-label text-md-right">{{ __('강사단명') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="@foreach($classList as $category){{ $category->class_name }}@if(!$loop->last), @endif @endforeach" readonly >
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="zipcode" class="col-md-4 col-form-label text-md-right">{{ __('우편번호') }}</label>
                            <div class="col-md-3">
                                <input id="zipcode" type="text" class="form-control postcodify_postcode5 @error('zipcode') is-invalid @enderror" name="zipcode" value="{{ $userInfo->zipcode }}" autocomplete="zipcode" >
                            </div>
                            <button class="btn btn-primary" type="button"  id="postcodify_search_button">조회</button>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('주소') }}</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control postcodify_address @error('address') is-invalid @enderror" name="address" value="{{$userInfo->address }}" autocomplete="address" >
                            </div>
                        </div>

                        @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{!! \Session::get('success') !!}</li>
                            </ul>
                        </div>
                        @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('저장하기') }}
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
