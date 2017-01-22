@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <ul class="list-group">
                    <li class="list-group-item" id="js-compose-btn">
                        <a type="button" href="" data-toggle="modal"
                           data-target="#composeModal">Compose
                        </a>
                    </li>
                    <li class="list-group-item"><a href="#">Inbox <span id="js-inbox-unread-count"
                                                                        class="badge"></span></a></li>
                    <li class="list-group-item"><a href="#">Drafts <span id="js-drafts-count" class="badge"></span></a>
                    </li>
                    <li class="list-group-item"><a href="#">Sent</a></li>
                    <li class="list-group-item"><a href="#">Trash</a></li>
                </ul>
            </div>
            <div class="col-md-10">
                <div class="panel panel-default" id="js-panel-alert-type">
                    <div class="panel-heading" id="js-box-name">
                        Inbox
                    </div>
                    <div class="panel-body">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <form id="js-compose-email-form">
        <input type="hidden" name="_token" value="{{ Session::token() }}">
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
                                    <select id="js-compose-email-to" multiple="multiple" style="width: 100%" required>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default"
                                            type="button">Subject</button>
                                </span>
                                    <input type="text" class="form-control" id="js-compose-subject"
                                           placeholder="Congratulations !!! You're hired !" required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-body">
                        <textarea placeholder="Email Body" class="form-control" id="js-compose-body" rows="3"
                                  required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="js-compose-close" data-dismiss="modal">Close
                        </button>
                        <button type="submit" class="btn btn-primary" id="js-compose-send">Send</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection
