<?php
session_start();
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tasklist</title>

        <link rel="stylesheet" type="text/css" href="{{ URL::asset('styles.css') }}">
    </head>

<body style="background-color:powderblue;">

    @if(session()->has('user')))
        <script> window.location="/main/successlogin";</script>
    @endif
    

    <h1><center> LOGIN INTO TASKLIST </center></h1>

    @if ($message = session()->get('error1'))
    <div class="alert alert-danger alert-block">
        <center><button type="button" class="close" data-dismiss="alert"> X </button>
        <strong> {{ $message }} </strong></center><br>
    </div>
    @endif

    <form method="POST" action=" {{ url('/main/checklogin') }}"> 
        @csrf
        <center><input type="text" name="name" placeholder="username"></center>
        <br>
        <center><input type="password" name="password" placeholder="password"></center>
        <br>
        <center><input type="submit" name="login" class="btn btn-primary" value="Login"></center>
    </form>

    <hr>
    <h2><center> Not registered yet? </center></h2>

    @if(count($errors)>0)
        <div id="sarasas" class="alert alert-danger">
            <ul id="sarasas">
                @foreach($errors->all() as $error)
                <div class="alert alert-danger alert-block">
                    <li><strong> {{ $error }} </strong></li>
                </div>
                @endforeach
            </ul>    
        </div>
    @endif

    @if ($message = session()->get('error2'))
    <div class="alert alert-danger alert-block">
        <center><button type="button" class="close" data-dismiss="alert"> X </button>
        <strong> {{ $message }} </strong></center><br>
    </div>
    @endif
    @if ($message = Session::get('success'))
    <div>
        <center><button type="button" class="close" data-dismiss="alert"> &#x2714 </button>
        <strong> {{ $message }} </strong></center><br>
    </div>
    @endif

        <form method="POST" action=" {{ url('/main/register') }}"> 
            @csrf
            <center><input type="text" name="name" placeholder="username"></center>
            <br>
            <center><input type="password" name="password" placeholder="password"></center>
            <br>
            <center><input type="submit" name="register" class="btn btn-primary" value="Register"></center>
        </form>

    <hr>
    <h2><center> Currently registered: </center></h2>
  
        @if (count($users)>0)
        <div id="sarasas">
        <ul>
            @foreach ($users as $user)
            <tr>
                <td><li>{{ $user->name }} </li></td>
            </tr>
            @endforeach
        </ul>
        </div>
        @else 
            <tr>
                <td> None currently. </td>
            </tr>
        @endif
    
</body>