@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a type="button" href="" data-toggle="modal"
                           data-target="#composeModal">Compose
                        </a>
                    </li>
                    <li class="list-group-item"><a href="#">Inbox <span id="js-inbox-unread-count"
                                                                        class="badge">59</span></a></li>
                    <li class="list-group-item"><a href="#">Drafts <span id="js-drafts-count" class="badge">3</span></a>
                    </li>
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
    <!-- Modal -->
    <div class="modal fade" id="composeModal" tabindex="-1" role="dialog" aria-labelledby="composeModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Compose</h4>
                    <form>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">To</button>
                                </span>
                                <input type="text" class="form-control" placeholder="openingknots@gmail.com"
                                       aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Subject</button>
                                </span>
                                <input type="text" class="form-control" placeholder="Regarding hiring you...">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-body">
                    <textarea placeholder="Email Body" class="form-control" rows="3"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send</button>
                </div>
            </div>
        </div>
    </div>
@endsection
