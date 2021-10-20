@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('로그인 아이디 찾기') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('auth.findidDo') }}" onsubmit="return searchFormSubmit();">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">이름</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="false" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label text-md-right">핸드폰번호</label>

                            <div class="col-md-6">
                                <table>
                                    <tr>
                                        <td style="display: inline-flex;">
                                            <input id="mobile" type="hidden"  class="form-control" name="mobile"  value="">
                                            <input id="mobile1" type="text"  class="form-control" style="width: 61px; margin-right: 10px;"   maxlength="3" required autocomplete="false">
                                            <input id="mobile2" type="text"  class="form-control" style="width: 61px; margin-right: 10px;"   maxlength="4" required autocomplete="false">
                                            <input id="mobile3" type="text" class="form-control" style="width: 61px;" maxlength="4" required autocomplete="false">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                       
                        @if(session()->has('message'))
                        <div class="form-group row mb-2 alert alert-success">
                            <div class="col-md-8 offset-md-4">
                                <strong>{{ session()->get('message') }}
                            </div>
                        </div>
                        @endif
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('아이디 찾기') }}
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

<script>

        $(document).ready(function() {

            searchFormSubmit = function(){
                $("#mobile").val($("#mobile1").val()+"-"+$("#mobile2").val()+"-"+$("#mobile3").val());
                
                return true;
            }
        });

</script>


@endsection
