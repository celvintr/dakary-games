<x-guest-layout>
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
            <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url('{{ asset('https://wallpaperaccess.com/full/273295.jpg') }}');">
                <div class="login-form text-center p-7 position-relative overflow-hidden">
                    <!--begin::Login Header-->
                    <div class="d-flex flex-center mb-15">
                             <svg xmlns="http://www.w3.org/2000/svg"class="max-h-65px" fill="currentColor" class="bi bi-controller" viewBox="0 0 16 16">
                                <path d="M11.5 6.027a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zm2.5-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zm-6.5-3h1v1h1v1h-1v1h-1v-1h-1v-1h1v-1z"/>
                                <path d="M3.051 3.26a.5.5 0 0 1 .354-.613l1.932-.518a.5.5 0 0 1 .62.39c.655-.079 1.35-.117 2.043-.117.72 0 1.443.041 2.12.126a.5.5 0 0 1 .622-.399l1.932.518a.5.5 0 0 1 .306.729c.14.09.266.19.373.297.408.408.78 1.05 1.095 1.772.32.733.599 1.591.805 2.466.206.875.34 1.78.364 2.606.024.816-.059 1.602-.328 2.21a1.42 1.42 0 0 1-1.445.83c-.636-.067-1.115-.394-1.513-.773-.245-.232-.496-.526-.739-.808-.126-.148-.25-.292-.368-.423-.728-.804-1.597-1.527-3.224-1.527-1.627 0-2.496.723-3.224 1.527-.119.131-.242.275-.368.423-.243.282-.494.575-.739.808-.398.38-.877.706-1.513.773a1.42 1.42 0 0 1-1.445-.83c-.27-.608-.352-1.395-.329-2.21.024-.826.16-1.73.365-2.606.206-.875.486-1.733.805-2.466.315-.722.687-1.364 1.094-1.772a2.34 2.34 0 0 1 .433-.335.504.504 0 0 1-.028-.079zm2.036.412c-.877.185-1.469.443-1.733.708-.276.276-.587.783-.885 1.465a13.748 13.748 0 0 0-.748 2.295 12.351 12.351 0 0 0-.339 2.406c-.022.755.062 1.368.243 1.776a.42.42 0 0 0 .426.24c.327-.034.61-.199.929-.502.212-.202.4-.423.615-.674.133-.156.276-.323.44-.504C4.861 9.969 5.978 9.027 8 9.027s3.139.942 3.965 1.855c.164.181.307.348.44.504.214.251.403.472.615.674.318.303.601.468.929.503a.42.42 0 0 0 .426-.241c.18-.408.265-1.02.243-1.776a12.354 12.354 0 0 0-.339-2.406 13.753 13.753 0 0 0-.748-2.295c-.298-.682-.61-1.19-.885-1.465-.264-.265-.856-.523-1.733-.708-.85-.179-1.877-.27-2.913-.27-1.036 0-2.063.091-2.913.27z"/>
                              </svg> <h1> DAKARY GAMES </h1>
  
                    </div>
                    <!--end::Login Header-->

                    <!--begin::Login Sign in form-->
                    <div class="login-signin">
                    

                        <div>
                            @if (Session::has('message'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('message') }}
                                </div>
                            @endif

                            <!-- Session Status -->
                            <x-auth-session-status class="mb-3" :status="session('status')" />

                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-3" :errors="$errors" />
                        </div>

                        <form method="POST" action="{{ route('login') }}" class="form" id="kt_login_signin_form">
                            @csrf

                            <div class="form-group mb-5">
                                <input class="form-control h-auto form-control-solid py-4 px-8 mask-dni" type="text" placeholder="Correo" name="email" maxlength="25" autocomplete="off" value="{{ old('dni_usuario') }}" autofocus />
                            </div>

                            <div class="form-group mb-5">
                                    <div class='input-group'>

                                    <input type='password' id='password' name="password" placeholder="Contraseña"  class='form-control h-auto form-control-solid py-4 px-8'/>
                                    <input type='text' class='form-control h-auto form-control-solid py-4 px-8 hidden' id='passwordContent' disabled/>
                                    <div class='input-group-append'>
                                        <span class='input-group-text' onclick='showHidePassword("#password","#passwordContent")'>
                                            <i class='fa fa-eye'></i>
                                        </span>
                                    </div>
                                    </div>
                                    </div>

                            <div class="d-flex justify-content-end my-4">
                                <a href="#" class="text-dark">Olvidó su contraseña?</a>
                            </div>

                            <button id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Iniciar Sesión</button>
                        </form>
                    </div>
                    <!--end::Login Sign in form-->
                </div>
            </div>
        </div>
        <!--end::Login-->

        @push('scripts')
        <script>
            $(document).ready(function() {
                $('.mask-date').datepicker({
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    orientation: "bottom left",
                    format: 'dd/mm/yyyy',
                    templates: {
                        leftArrow: '<i class="la la-angle-left"></i>',
                        rightArrow: '<i class="la la-angle-right"></i>'
                    }
                });

                $(".mask-date").inputmask("99/99/9999", {
                    "placeholder": "dd/mm/aaaa"
                });

                $('.mask-dni').inputmask("9999999999999");

            });

            // Ver pass input
            function showHidePassword(passSelector, textSelector) {
                if ($(passSelector).hasClass("hidden")) {
                    $(passSelector).val($(textSelector).val());
                    $(textSelector).addClass("hidden");
                    $(passSelector).toggleClass("hidden");
                }
                else {
                    $(textSelector).val($(passSelector).val());
                    $(passSelector).addClass("hidden");
                    $(textSelector).toggleClass("hidden");
                }
            }
        </script>
        <style>
            .hidden{
                display:none !important;
                }
        </style>
    @endpush
    </div>
</x-guest-layout>
