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
<form method="GET" action="/main/create">
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
                <td><center> 
                    <a href="{{action('MainController@edit', $task->id)}}"> <input class="btn btn-default" type="submit" value="Edit" /> </a>
                </center>
                </td>
                <td><center> <form method="POST" action="/main/{{$task->id}}">
                        @csrf
                        <input class="btn btn-default" type="submit" value="Delete" /> 
                        @method('DELETE')               
                    </form></center> 
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
            @endforeach
        </table>
        <br>
    @endif
    
<br><hr><br>

    <form action=" {{ url('/main/logout') }}"> 
        <input type="submit" name="logout" class="btn btn-primary" value="Log out">
    </form>

</body>