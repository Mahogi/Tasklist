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

    @if(isset($_SESSION['user']))
        <script> window.location="/main/successlogin";</script>
    @endif
    

    <h1><center> LOGIN INTO TASKLIST </center></h1>

    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert"> X </button>
        <strong> {{ $message }} </strong>
    </div>
    @endif
    
    @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <ul> 
                        <li> {{ $error }}</li> 
                    </ul>
                @endforeach
            </ul>    
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

        <p>
            @if ($statusas == 1)
            <center>Failed to create...</center>
            @elseif ($statusas == 2)
            <center>User wuccessfully created!</center>
            @endif
            </p>

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
                <td><li id>{{ $user->name }} </li></td>
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