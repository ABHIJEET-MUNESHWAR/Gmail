<?php

namespace App\Http\Controllers;

use App\Email;
use App\User;
use Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Get email list
     *
     * @return array
     */
    public function emailList()
    {
        $emails    = User::getEmailList();
        $emailList = array();
        foreach ($emails as $email) {
            $emailList[$email->id] = $email->email;
        }

        return $emailList;
    }

    public function sendEmail()
    {
        $response       = array();
        $params         = Request::all();
        $user           = Auth::user();
        $userID         = $user->id;
        $params['from'] = $userID;
        if (!Request::ajax()) {
            return false;
        }
        $isSent = Email::sendEmail($params);
        if ($isSent) {
            $response['message'] = "success";
            $response['data']    = "Email sent successfully";
        } else {
            $response['message'] = "error";
            $response['data']    = "Email is not sent";
        }

        return json_encode($response);

    }

    public function checkEmail()
    {
        $response            = array();
        $user                = Auth::user();
        $userID              = $user->id;
        $unreadInbox         = Email::getUnreadInboxCount($userID);
        $unreadDrafts        = Email::getUnreadDraftsCount($userID);
        $response['message'] = "success";
        $response['data']    = array("inbox" => $unreadInbox, "drafts" => $unreadDrafts);

        return json_encode($response);
    }

    public function getInboxEmails(){
        $response            = array();
        $user                = Auth::user();
        $userID              = $user->id;
        $inboxEmails = Email::getInboxEmails($userID);
        $response['message'] = "success";
        $response['data']    = array("inbox" => $inboxEmails);

        return json_encode($response);
    }
}
