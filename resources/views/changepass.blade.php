<?php
session_start();
$user = session()->get('user');
?>

<h2>Change password: {{ $user }}</h2>

@if ($message = session()->get('error'))
    <div id="error">
        <button type="button" class="close" data-dismiss="alert"> X </button>
        <strong> {{ $message }} </strong>
    </div>
<br>
@endif

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

<form method="GET"  action="{{url('main/editPass')}}"> 
    {{ csrf_field() }}
    <input type="hidden" name="user" value="{{$user}}">
    <label for="pass1">Type your old password:</label>
    <input id="pass1" type="text" name="oldpassword" placeholder="old password">
    <br><br>
    <label for="pass2">Type new password:</label>
    <input id="pass2" type="password" name="newpassword1" placeholder="password">
    <br><br>
    <label for="pass3">Repeat new password:</label>
    <input id="pass3" type="password" name="newpassword2" placeholder="password">
    <br><br>
    <input type="submit" value="Change">
</form>