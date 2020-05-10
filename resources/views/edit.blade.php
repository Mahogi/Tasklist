<h2>Edit task: "{{$task}}":</h2>

@if(count($errors) > 0)
<div class="alert alert-danger"
    <ul>
    @foreach($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
    </ul>
@endif

<form method="POST" action="{{url('main/dbEdit')}}"> 
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$id}}">
    <input type="text" name="task" value="{{$task}}">
    <label for="imp">Is this task important?</label>
    <input type="checkbox" name="important" id="imp" value="1" <?php if ($important == 1) echo "checked='checked'"; ?>>
    <input type="submit" value="Change">
</form>