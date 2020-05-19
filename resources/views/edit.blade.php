<h2>Edit task: "{{$task->task}}":</h2>

@if(count($errors) > 0)
<div class="alert alert-danger"
    <ul>
    @foreach($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
    </ul>
@endif

<form method="POST"  action="{{action('MainController@update', $task->id)}}"> 
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <input type="text" name="task" value="{{$task->task}}">
    <label for="imp">Is this task important?</label>
    <input type="checkbox" name="important" id="imp" value="1" <?php if ($task->important == 1) echo "checked='checked'"; ?>>
    <input type="submit" value="Change">
</form>