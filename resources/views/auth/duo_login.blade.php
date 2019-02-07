@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">

                    <iframe id="duo_iframe" height="400" style="border:none;width:100%"></iframe>
                    <script>
                        Duo.init({
                            'host': '{{ $host }}',
                            'sig_request': '{{ $sig_request }}'
                        });
                    </script>
                    <form method="POST" id="duo_form">
                        {{ csrf_field() }}
                        <input type="hidden" name="remember" value="{{ $remember }}"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
