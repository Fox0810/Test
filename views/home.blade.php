@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div id="user-info-container">
    <p class="center-inner center-text" id="user-login">{{$helloMsg}}</p>
    <br/>

    <form id="user-form" class="center-inner" action="/src/auth/logout.php" method="post">
        <div class="center-text">
            <button type="submit">Log out</button>
        </div>
    </form>
</div>

<script type="text/javascript" src="/public/js/auth/log_out.js"></script>
@endsection