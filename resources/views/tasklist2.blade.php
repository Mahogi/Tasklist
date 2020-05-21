<?php 
use App\Tasks;
session_start();
$user = session()->get('user');
$tasks = Tasks::all()->sortBy('id');
$usertask = Tasks::where('creator', $user)->orderBy('id')->get();
?>

<head>
    <link rel="stylesheet" href="{{ URL::asset('styles.css') }}">
</head>

<body>
    @if(!isset($user))
     <script> window.location="/main";</script>
    @endif 

<h1> Welcome, {{ $user }} !</h1> 

<form action=" {{ url('/main/changePass') }}"> 
    @csrf
    <input type="hidden" name="user" value="{{$user}}">
    <input class="btn btn-default" type="submit" value="Change password">
</form>

@if ($message = session()->get('success'))
    <div id="success">
        <button type="button" class="close" data-dismiss="alert"> &#x2714 </button>
        <strong> {{ $message }} </strong>
    </div>
    <br>
@elseif ($message = session()->get('error'))
    <div id="error">
        <button type="button" class="close" data-dismiss="alert"> X </button>
        <strong> {{ $message }} </strong>
    </div>
<br>
@endif

<br>
<div id="tasklists">
Add a new task:
<form method="GET" action="/task/create">
    @csrf
    <input type="hidden" name="creator" value="{{$user}}">
    <input type="text" name="task" placeholder="Task name">
    <label for="imp">Is this task important?</label>
    <input type="checkbox" name="important" id="imp" value="1">
    <input type="submit">
</form>
<p>
    <h3>Your created tasks: </h3>

    @if (count($usertask) == 0)
        <strong> None currently! </strong><br>
    @else
        <table border="1">
            <tr>
                <th> ID </th>
                <th> Task </th>
                <th> Important? </th>
                <th> Change </th>
                <th> Delete </th>
                <th> Complete? </th>
            </tr>
            @foreach ($usertask as $task)
            <tr>
                <td> <?php echo $task->id; ?></td>
                <td> <?php echo $task->task; ?></td>
                <td> @if ($task->important == 1)
                        <center>✯ Yes ✯</center>
                    @else 
                        <center>No</center>
                    @endif
                </td>
                <td>@if ($task->complete == null)
                    <a href="{{action('TaskController@edit', $task->id)}}"> <input id="button" class="btn btn-default" type="submit" value="Edit" /> </a> 
                    @endif         
                </td>
                <td>
                    <form method="POST" action="/task/{{$task->id}}">
                        @csrf
                        <input id="button" class="btn btn-default" type="submit" value="Delete" />
                        @method('DELETE')               
                    </form>
                </td>
                <td> @if ($task->complete == null)
                    <form action=" {{ url('/task/complete') }}"> 
                        <input type="hidden" name="id" value="{{$task->id}}">
                        <input id="button" type="submit" class="btn btn-default" value="Complete" >
                    </form>
                    @else 
                        <center>Completed!</center>
                    @endif
                </td>
            </tr>
        @endforeach
        </table>
    @endif
</p>
<hr>

    <h3>Current Tasklist:</h3>

    @if (count($tasks) == 0)
        <strong> No tasks at the moment. </strong><br>
    @else
        <table border="1">
            <tr>
                <th> ID </th>
                <th> Creator </th>
                <th> Task </th>
                <th> Important? </th>
            </tr>
            @foreach ($tasks as $task)
                @if ($task->complete == 0)
                <tr>
                    <td> <?php echo $task->id; ?></td>
                    <td> <?php echo $task->creator; ?></td>
                    <td> <?php echo $task->task; ?></td>
                    <td>  @if ($task->important == 1)
                            <center>✯ Yes ✯</center>
                        @else 
                            <center>No</center>
                        @endif
                    </td>
                </tr>
                @endif
            @endforeach
        </table>
        <br>
    @endif
    
<br><hr><br>

    <form action=" {{ url('/main/logout') }}"> 
        <input type="submit" name="logout" class="btn btn-primary" value="Log out">
    </form> 
    <form action=" {{ url('/main/deleteAccount') }}"> 
        <input type="hidden" name="creator" value="{{$user}}">
        <input type="submit" name="logout" class="btn btn-primary" value="Delete account" onclick="return confirm('Are you sure?')">
    </form>
</body>