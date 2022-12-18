@extends('layouts.app')

@section('content')
<div class="navbar-wrapper">
    <div class="container">
        <nav class="legrand-navbar">
            <a className="navbar-brand" href="/" style={logoStyle}>
            <svg width="166" height="22" viewBox="0 0 166 22" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0)">
<path d="M7.20582 22.0537L22.7383 9.28292C22.7917 9.22926 22.7383 9.1756 22.6849 9.1756L14.3049 8.58536C14.2515 8.58536 14.1981 8.5317 14.2515 8.47804L21.2971 0.160967C21.3505 0.107308 21.2971 0.0536499 21.2438 0.0536499H21.1904L7.52607 10.0878C7.4727 10.0878 7.52607 10.1951 7.57945 10.1951L15.319 11L7.09906 21.9463C7.04569 22 7.09906 22.0537 7.20582 22.0537C7.15244 22.0537 7.20582 22.0537 7.20582 22.0537Z" fill="#E72E4B"/>
<path d="M31.4388 8.42439L25.781 2.89756C25.7276 2.8439 25.6742 2.8439 25.6208 2.8439H20.817C20.7636 2.8439 20.7102 2.89756 20.6568 2.89756L19.2691 4.50732C19.2157 4.56098 19.2691 4.61463 19.3224 4.61463H24.8736C24.9269 4.61463 24.9803 4.61463 25.0337 4.66829L28.7167 8.26341C28.77 8.31707 28.77 8.37073 28.7167 8.42439L15.7462 19.1561C15.6929 19.2098 15.6395 19.2098 15.5861 19.1561L14.1983 18.0293C14.1449 17.9756 14.0916 17.9756 14.0382 18.0293L12.8105 19.0488C12.7572 19.1024 12.7572 19.1561 12.8105 19.2098L15.5861 21.5171H15.6395H15.6929L31.4388 8.58537C31.4922 8.53171 31.4922 8.42439 31.4388 8.42439Z" fill="#1F3654"/>
<path d="M10.5685 14.9707L2.6688 8.42439C2.61543 8.37073 2.61543 8.31707 2.6688 8.26342L6.35176 4.66829C6.40514 4.61463 6.45851 4.61463 6.51189 4.61463H12.7035C12.7569 4.61463 12.8103 4.61463 12.8103 4.56098L15.0521 2.95122C15.1055 2.89756 15.1055 2.8439 14.9987 2.8439H5.76462C5.71125 2.8439 5.65787 2.8439 5.60449 2.89756L-6.90669e-06 8.42439C-0.0533831 8.47805 -0.0533831 8.53171 -6.90669e-06 8.58537L9.50096 16.4195C9.55433 16.4732 9.60771 16.4732 9.66109 16.4195L10.6219 15.1317C10.6219 15.0781 10.6219 15.0244 10.5685 14.9707Z" fill="#1F3654"/>
<path d="M48.3596 13.4146C48.1461 14.5951 47.6657 15.5073 46.9184 16.0975C46.1711 16.6878 45.2637 17.0097 44.1428 17.0097C42.9152 17.0097 41.901 16.5805 41.1004 15.7756C40.8869 15.561 40.6734 15.2927 40.5133 14.9707C40.3531 14.7024 40.2464 14.4341 40.193 14.2195C40.1396 14.0049 40.0862 13.6829 40.0329 13.2536C39.9795 12.8244 39.9795 12.5561 39.9795 12.3951C39.9795 12.2341 39.9795 11.8585 39.9795 11.3756C39.9795 10.8927 39.9795 10.5171 39.9795 10.3561C39.9795 10.1951 39.9795 9.87315 40.0329 9.49754C40.0862 9.06828 40.1396 8.74632 40.193 8.53169C40.2464 8.31706 40.3531 8.04876 40.5133 7.78047C40.6734 7.51218 40.8335 7.24389 41.1004 7.02925C41.901 6.22437 42.9686 5.7951 44.1428 5.7951C45.2104 5.7951 46.1178 6.11706 46.9184 6.7073C47.6657 7.29754 48.1461 8.20974 48.3596 9.39023H45.584C45.3705 8.58535 44.8901 8.20974 44.1962 8.20974C43.7158 8.20974 43.3422 8.37071 43.1287 8.69267C42.9686 8.85364 42.8618 9.17559 42.8084 9.49754C42.7551 9.87315 42.7017 10.5171 42.7017 11.4293C42.7017 12.3414 42.7551 12.9853 42.8084 13.361C42.8618 13.7366 42.9686 14.0049 43.1287 14.1658C43.3422 14.4878 43.7158 14.6488 44.1962 14.6488C44.9435 14.6488 45.3705 14.2732 45.584 13.4683H48.3596V13.4146Z" fill="#173856"/>
<path d="M57.9675 5.84875L54.1244 14.9707C53.5906 16.2585 52.6832 16.9024 51.509 16.9024H50.0144V14.4878H50.9752C51.6157 14.4878 52.0427 14.1122 52.2029 13.4146L48.7334 5.84875H51.5623L53.4839 10.4634L55.2453 5.84875H57.9675Z" fill="#173856"/>
<path d="M67.3618 16.9561H64.6397V8.26339H61.7573V16.9024H59.0352V5.84875H67.3085V16.9561H67.3618Z" fill="#173856"/>
<path d="M77.0762 16.9561H69.6035V5.84875H77.0762V8.26339H72.2723V10.0878H76.3823V12.5024H72.2723V14.4878H77.0762V16.9561Z" fill="#173856"/>
<path d="M86.0437 6.86827C86.7376 7.51217 87.1112 8.37071 87.1112 9.44388C87.1112 10.4634 86.7376 11.3219 86.0437 12.0195C85.3498 12.6634 84.4424 13.039 83.3215 13.039H81.6669V17.0097H78.998V5.84875H83.3749C84.4424 5.84875 85.3498 6.17071 86.0437 6.86827ZM84.0688 10.1951C84.2823 9.98046 84.3891 9.71217 84.3891 9.39022C84.3891 9.06827 84.2823 8.79997 84.0688 8.58534C83.8553 8.37071 83.5884 8.26339 83.2148 8.26339H81.6669V10.517H83.2148C83.5884 10.517 83.8553 10.4097 84.0688 10.1951Z" fill="#173856"/>
<path d="M87.5908 13.4683H90.2596C90.4731 14.2732 91.0069 14.6488 91.7008 14.6488C92.1812 14.6488 92.5548 14.4878 92.8217 14.1658C93.0352 13.8439 93.1953 13.3073 93.2487 12.5561H90.313V10.1951H93.2487C93.1953 9.44389 93.0886 8.9073 92.8217 8.63901C92.5548 8.31706 92.1812 8.15608 91.7008 8.15608C90.9535 8.15608 90.4731 8.53169 90.2596 9.33657H87.5908C87.7509 8.20974 88.2313 7.29754 88.9786 6.7073C89.7259 6.11706 90.6333 5.7951 91.7542 5.7951C92.9818 5.7951 93.996 6.22437 94.7966 7.02925C95.0101 7.24389 95.2236 7.51218 95.3838 7.78047C95.5439 8.04876 95.6506 8.31706 95.704 8.53169C95.7574 8.74632 95.8108 9.06828 95.8641 9.49754C95.9175 9.92681 95.9175 10.1951 95.9175 10.3561C95.9175 10.5171 95.9175 10.8927 95.9175 11.3756C95.9175 11.8585 95.9175 12.2341 95.9175 12.3951C95.9175 12.5561 95.9175 12.878 95.8641 13.2536C95.8108 13.6829 95.7574 14.0049 95.704 14.2195C95.6506 14.4341 95.5439 14.7024 95.3838 14.9707C95.2236 15.239 95.0635 15.5073 94.7966 15.7756C93.996 16.5805 92.9284 17.0097 91.7542 17.0097C90.6866 17.0097 89.7792 16.6878 88.9786 16.0975C88.2313 15.5073 87.8043 14.6488 87.5908 13.4683Z" fill="#173856"/>
<path d="M105.739 16.9561H103.017V8.26341H101.096V11.161C101.096 12.6634 100.935 13.8439 100.669 14.7024C100.402 15.561 100.028 16.1512 99.5477 16.4195C99.0673 16.7415 98.3734 16.9024 97.5727 16.9024H96.5586V14.4878H96.8789C97.2525 14.4878 97.5194 14.4341 97.7329 14.2732C97.9464 14.1122 98.1599 13.7902 98.2666 13.3073C98.3734 12.8244 98.4801 12.1268 98.4801 11.2146V5.90244H105.739V16.9561Z" fill="#173856"/>
<path d="M115.453 16.9561H107.98V5.84875H115.453V8.26339H110.649V10.0878H114.759V12.5024H110.649V14.4878H115.453V16.9561Z" fill="#173856"/>
<path d="M120.043 16.9561H117.321V5.84875H120.043V11.1073L123.033 5.84875H126.128L122.872 11L126.502 16.9024H123.299L120.043 11.1073V16.9561Z" fill="#173856"/>
<path d="M134.936 8.26339H132.214V16.9024H129.492V8.26339H126.77V5.84875H134.883V8.26339H134.936Z" fill="#173856"/>
<path d="M143.582 6.86827C144.276 7.51217 144.65 8.37071 144.65 9.44388C144.65 10.4634 144.276 11.3219 143.582 12.0195C142.889 12.6634 141.981 13.039 140.86 13.039H139.206V17.0097H136.483V5.84875H140.86C141.981 5.84875 142.889 6.17071 143.582 6.86827ZM141.608 10.1951C141.821 9.98046 141.928 9.71217 141.928 9.39022C141.928 9.06827 141.821 8.79997 141.608 8.58534C141.394 8.37071 141.127 8.26339 140.753 8.26339H139.206V10.517H140.753C141.074 10.517 141.394 10.4097 141.608 10.1951Z" fill="#173856"/>
<path d="M154.846 16.9561H152.123V10.8927L148.601 16.9024H146.252V5.84875H148.974V11.8585L152.497 5.84875H154.846V16.9561Z" fill="#173856"/>
<path d="M159.755 16.9561H157.033V5.84875H159.755V11.1073L162.744 5.84875H165.84L162.584 11L166.214 16.9024H163.011L159.755 11.1073V16.9561Z" fill="#173856"/>
</g>
<defs>
<clipPath id="clip0">
<rect width="166" height="22" fill="white"/>
</clipPath>
</defs>
</svg>

            </a>
        </nav>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center" style="margin-top:40px;">
    <h3>{{ __('reset-password.title') }}</h3>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('reset-password.email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} legrand-input" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label  for="password" class="col-md-4 col-form-label text-md-right">{{ __('reset-password.password') }}</label>

                            <div  class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} legrand-input" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('reset-password.password-confirm') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control legrand-input" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="legrand-btn btn-accent">
                                    {{ __('reset-password.send') }}
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
