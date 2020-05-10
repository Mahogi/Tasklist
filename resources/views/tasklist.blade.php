<?php 
session_start();

if (isset($_SESSION['user']))
{
    $connection = mysqli_connect("localhost", "root", "", "tasklist");
    if ($connection->connect_error){
        die("Connection failed: " . $connection->connect_error);
    }
    $user_name = $_SESSION['user'];
    $sql = "SELECT id, creator, task, important FROM tasklist WHERE creator='$user_name'";
    $result = $connection->query($sql);
    $sqlall = "SELECT id, creator, task, important FROM tasklist";
    $resultall = $connection->query($sqlall);
    mysqli_close($connection);
} else {
    $_SESSION['user'] = null;
}

?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="{{ URL::asset('styles.css') }}">
    </head>
<body>

    @if(!isset($_SESSION['user']))
     <script> window.location="/main";</script>
    @endif   

<h1> HELLO, {{$_SESSION['user']}}!</h1> 

<?php if (isset($_SESSION["flash"]))
    {?>
        <div id="flash"><?php echo $_SESSION["flash"]; ?></div>
        <?php unset($_SESSION["flash"]); 
    } ?>

    <br><br>
    <div id="tasklists">
    Add a new task:
    <form method="POST" action=" {{ url('/main/addTask') }}"> 
        @csrf
        <input type="hidden" name="creator" value="{{$_SESSION['user']}}">
        <input type="text" name="task" placeholder="Task name">
        <label for="imp">Is this task important?</label>
        <input type="checkbox" name="important" id="imp" value="1">
        <input type="submit">
    </form>
    <p>
        <h3>Your created tasks: </h3>
    <?php 
    if (isset($_SESSION['user'])):  
        if (($result->num_rows > 0) && (isset($_SESSION['user']))) : ?>
            <table border="1">
                <tr>
                    <th> ID </th>
                    <th> Task </th>
                    <th> Important? </th>
                    <th> Change </th>
                    <th> Delete </th>
                </tr>
                
            <?php while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td> <?php echo $row['id']; ?></td>
                <td> <?php echo $row['task']; ?></td>
                <td> <?php 
                    if ($row['important'] == 1): ?>
                        <center>✯ Yes ✯</center>
                    <?php else: ?>
                        <center>No</center>
                    <?php endif;?>
                </td>
                <td><center> 
                    <form method="POST" action="{{url('main/editTask')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$row['id']}}">
                        <input type="hidden" name="task" value="{{$row['task']}}">
                        <input type="hidden" name="important" value="{{$row['important']}}">
                        <input class="btn btn-default" type="submit" value="Edit" /> 
                    </form></center>
                </th>
                <td><center>
                    <form method="POST" action="{{url('main/deleteTask')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$row['id']}}">
                        <input class="btn btn-default" type="submit" value="Delete" />               
                    </form> </center> 
                </th>
            </tr>
            <?php
         endwhile; 
        else: echo "No tasks at the moment.";
        endif; 
    endif;
        ?>
        </table>
    </p>
    <hr>
    <h3>Current Tasklist:</h3>

    <?php 
        if (isset($_SESSION['user'])):   
            if (($resultall->num_rows > 0) && (isset($_SESSION['user']))) : ?>
                <table border="1">
                <tr>
                    <th> ID </th>
                    <th> Creator </th>
                    <th> Task </th>
                    <th> Important? </th>
                </tr>
                    
                <?php while ($row = $resultall->fetch_assoc()):
                ?>
                <tr>
                    <td> <?php echo $row['id']; ?></th>
                    <td> <?php echo $row['creator']; ?></td>
                    <td> <?php echo $row['task']; ?></td>
                    <td> <?php 
                        if ($row['important'] == 1): ?>
                            <center>✯ Yes ✯</center>
                        <?php else: ?>
                            <center>No</center>
                        <?php endif;?>
                    </td>
                </tr>
                <?php
            endwhile;  
            else: echo "No tasks at the moment.";
            endif;
        endif;
        ?>
        </table> </div>
        <br><hr><br>
        <form action=" {{ url('/main/logout') }}"> 
            <input type="submit" name="logout" class="btn btn-primary" value="Log out">
        </form>