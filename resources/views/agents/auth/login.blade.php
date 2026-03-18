@extends('layouts.agentAuthLayout')
@section('content')
<div class="col mx-auto">
    <div class="mb-4 text-center">
        <img src="{{ asset('agent_panel/images/logo.png') }}" width="200" alt="" />
    </div>
    <div class="card">
            <div class="card-body">
                <div class="border p-4 rounded">
                    <div class="text-center">
                        <h3 class="">Sign in</h3>
                        {{-- <p>Don't have an account yet? <a href="authentication-signup.html">Sign up here</a></p> --}}
                    </div>
                    <div class="form-body">
                        <form class="row g-3" action="{{ route('agent.login') }}" method="POST">
                            @csrf
                            <div class="col-12">
                                <label for="mobile_no" class="form-label">Mobile Number</label>
                                <input type="text" id="mobile_no" name="mobile" class="form-control" placeholder="Enter Mobile Number">
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">Enter Password</label>
                                <div class="input-group" id="show_hide_password">
                                    <input type="password" class="form-control border-end-0" name="password" id="password" value="123456" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">	<a href="authentication-forgot-password.html">Forgot Password ?</a>
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-theme"><i class="bx bxs-lock-open"></i>Sign in</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('customjs')
<script>
    $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("bx-hide");
                $('#show_hide_password i').removeClass("bx-show");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("bx-hide");
                $('#show_hide_password i').addClass("bx-show");
            }
        });
    });
</script>
@endpush
