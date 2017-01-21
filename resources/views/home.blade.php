@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <ul class="list-group">
                <li class="list-group-item"><a href="#">Compose</a></li>
                <li class="list-group-item"><a href="#">Inbox <span id="js-inbox-unread-count" class="badge">59</span></a></li>
                <li class="list-group-item"><a href="#">Drafts <span id="js-drafts-count" class="badge">3</span></a></li>
                <li class="list-group-item"><a href="#">Sent</a></li>
                <li class="list-group-item"><a href="#">Trash</a></li>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading" id="js-box-name">Inbox</div>

                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item"><a href="#">Email 1</a></li>
                        <li class="list-group-item"><a href="#">Email 2</a></li>
                        <li class="list-group-item"><a href="#">Email 3</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
