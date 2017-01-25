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
        $is_reply = 0;
        if (!empty($params['is_reply'])) {
            $is_reply = $params['is_reply'];
        }
        if ($is_reply) {
            $isSent = Email::replyEmail($params);
        } else {
            $isSent = Email::sendEmail($params);
        }
        if ($isSent) {
            $response['message'] = "success";
            $response['data']    = "Email sent successfully";
        } else {
            $response['message'] = "error";
            $response['data']    = "Email is not sent";
        }

        return json_encode($response);

    }

    public function draftEmail()
    {
        $response       = array();
        $params         = Request::all();
        $user           = Auth::user();
        $userID         = $user->id;
        $params['from'] = $userID;
        if (!Request::ajax()) {
            return false;
        }
        $isSent = Email::draftEmail($params);
        if ($isSent) {
            $response['message'] = "success";
            $response['data']    = "Email drafted successfully";
        } else {
            $response['message'] = "error";
            $response['data']    = "Email is not drafted";
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

    public function getInboxEmails()
    {
        $inboxEmails    = array();
        $response       = array();
        $user           = Auth::user();
        $userID         = $user->id;
        $inboxEmailsRaw = Email::getInboxEmails($userID);
        foreach ($inboxEmailsRaw as $inboxEmail) {
            $inboxEmails[$inboxEmail->parent_email_id]["subject"]         = $inboxEmail->subject;
            $inboxEmails[$inboxEmail->parent_email_id]["email_id"]        = $inboxEmail->email_id;
            $inboxEmails[$inboxEmail->parent_email_id]["has_read"]        = $inboxEmail->has_read;
            $inboxEmails[$inboxEmail->parent_email_id]["created_at"]      = $inboxEmail->created_at;
            $inboxEmails[$inboxEmail->parent_email_id]["parent_email_id"] = $inboxEmail->parent_email_id;
        }
        $response['message'] = "success";
        $response['data']    = array("inbox" => $inboxEmails);

        return json_encode($response);
    }


    public function getDraftEmails()
    {
        $draftEmails    = array();
        $response       = array();
        $user           = Auth::user();
        $userID         = $user->id;
        $draftEmailsRaw = Email::getDraftEmails($userID);
        foreach ($draftEmailsRaw as $draftEmail) {
            $draftEmails[$draftEmail->parent_email_id]["parent_email_id"] = $draftEmail->parent_email_id;
            $draftEmails[$draftEmail->parent_email_id]["email_id"]        = $draftEmail->email_id;
            $draftEmails[$draftEmail->parent_email_id]["subject"]         = $draftEmail->subject;
            $draftEmails[$draftEmail->parent_email_id]["body"]            = $draftEmail->body;
            $draftEmails[$draftEmail->parent_email_id]["to_user_id"][]    = $draftEmail->to_user_id;
            $draftEmails[$draftEmail->parent_email_id]["to_user_name"][]  = $draftEmail->to_user_name;
            $draftEmails[$draftEmail->parent_email_id]["to_user_email"][] = $draftEmail->to_user_email;
        }
        $response['message'] = "success";
        $response['data']    = array("inbox" => $draftEmails);

        return json_encode($response);
    }

    public function getSentEmails()
    {
        $sentEmails    = array();
        $response      = array();
        $user          = Auth::user();
        $userID        = $user->id;
        $sentEmailsRaw = Email::getSentEmails($userID);
        foreach ($sentEmailsRaw as $sentEmail) {
            $sentEmails[$sentEmail->parent_email_id]["parent_email_id"] = $sentEmail->parent_email_id;
            $sentEmails[$sentEmail->parent_email_id]["email_id"]        = $sentEmail->email_id;
            $sentEmails[$sentEmail->parent_email_id]["subject"]         = $sentEmail->subject;
            $sentEmails[$sentEmail->parent_email_id]["body"]            = $sentEmail->body;
            $sentEmails[$sentEmail->parent_email_id]["to_user_id"][]    = $sentEmail->to_user_id;
            $sentEmails[$sentEmail->parent_email_id]["to_user_name"][]  = $sentEmail->to_user_name;
            $sentEmails[$sentEmail->parent_email_id]["to_user_email"][] = $sentEmail->to_user_email;
            $sentEmails[$sentEmail->parent_email_id]["created_at"]      = $sentEmail->created_at;
        }
        $response['message'] = "success";
        $response['data']    = array("inbox" => $sentEmails);

        return json_encode($response);
    }

    public function getTrashEmails()
    {
        $response            = array();
        $user                = Auth::user();
        $userID              = $user->id;
        $trashEmails         = Email::getTrashEmails($userID);
        $response['message'] = "success";
        $response['data']    = array("inbox" => $trashEmails);

        return json_encode($response);
    }

    public function getEmailDetails()
    {
        $response          = array();
        $params            = Request::all();
        $user              = Auth::user();
        $userID            = $user->id;
        $params['user_id'] = $userID;
        if (!Request::ajax()) {
            return false;
        }
        if ($params["has_read"] == "0") {
            $isRead = Email::markAsRead($params);
        }
        $emailDetails        = Email::getEmailDetails($params);
        $response['message'] = "success";
        $response['data']    = array("inbox" => $emailDetails);

        return json_encode($response);
    }

    public function deleteEmail()
    {
        $response       = array();
        $params         = Request::all();
        $user           = Auth::user();
        $userID         = $user->id;
        $params['from'] = $userID;
        if (!Request::ajax()) {
            return false;
        }
        $isRead = Email::deleteEmail($params);
        if ($isRead) {
            $response['message'] = "success";
            $response['data']    = "Email is deleted";
        } else {
            $response['message'] = "error";
            $response['data']    = "Email is not deleted";
        }

        return json_encode($response);
    }
}
