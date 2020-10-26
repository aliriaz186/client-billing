<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <link href="{{asset('bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin-login.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin-login.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800&amp;display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800&amp;display=swap"
          rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript" src="{{ \Illuminate\Support\Facades\URL::asset('jquery/3.5.1/jquery.min.js')}}"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fbfbfb!important">
    <a class="navbar-brand" href="{{ url('/') }}">App</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    </div>
</nav>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
            <h4 style="color: #0d0d0d" class="mt-4 mb-3">Create New Account</h4>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <h4>{{$errors->first()}}</h4>
            </div>
        @endif
        <form method="POST" action="{{ url('create-new-account') }}">
            @csrf
            <input type="text" id="name" class="fadeIn second" name="name" placeholder="name">
            <input type="text" id="email" class="fadeIn second" name="email" placeholder="email">
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
            <input type="submit" class="fadeIn fourth" value="Create Account">
        </form>
        <div id="formFooter">
            <a class="underlineHover" href="{{url('/user-login')}}">Login</a>
        </div>

    </div>
</div>
</body>
</html>
<script>
    $("#login-button").click(function(event){
        event.preventDefault();

        $('form').fadeOut(500);
        $('.wrapper').addClass('form-success');
    });
</script>
