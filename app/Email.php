<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Log;

class Email extends Model
{
    public static function sendEmail($email)
    {
        try {
            $to      = $email['to'];
            $subject = $email['subject'];
            $body    = $email['body'];
            $from    = $email['from'];
            $emailID = DB::table('emails')->insertGetId(
                ['subject' => $subject, 'body' => $body]
            );
            foreach ($to as $user_id) {
                $ID = DB::table('email_user')->insertGetId(
                    ['from_user_id' => $from, 'to_user_id' => $user_id, 'email_id' => $emailID, 'parent_email_id' => $emailID]
                );
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public static function getUnreadInboxCount($userID)
    {
        $unreadEmail = DB::table('email_user')
            ->where('to_user_id', $userID)
            ->where('has_read', 0)
            ->count();

        return $unreadEmail;

    }

    public static function getUnreadDraftsCount($userID)
    {
        $sql          = "select
        count(DISTINCT(email_id)) as no_of_drafts
        from email_user
        where from_user_id=$userID and
        is_draft=1";
        $unreadDrafts = DB::select($sql);
        $unreadDrafts = reset($unreadDrafts);
        $unreadDrafts = $unreadDrafts->no_of_drafts;

        return $unreadDrafts;
    }

    public static function getInboxEmails($userID)
    {
        $sql         = "SELECT
            e.id as email_id,
            e.subject as subject,
            e.body as body,
            fu.id as from_user_id,
            fu.name as from_user_name,
            fu.email as from_user_email,
            tu.id as to_user_id,
            tu.name as to_user_name,
            tu.email as to_user_email,
            eu.parent_email_id as parent_email_id,
            eu.has_read as has_read,
            eu.created_at
            from email_user as eu 
            left join users as fu on eu.from_user_id = fu.id 
            left join users as tu on eu.to_user_id = tu.id
            left join emails as e on eu.email_id = e.id
            where 
            eu.is_deleted = 0 AND 
            eu.is_draft = 0 AND
            (eu.to_user_id=$userID OR eu.from_user_id=$userID)
            order by created_at desc";
        $inboxEmails = DB::select($sql);

        return $inboxEmails;
    }

    public static function getDraftEmails($userID)
    {
        $sql         = "SELECT
            e.id as email_id,
            e.subject as subject,
            e.body as body,
            tu.id as to_user_id,
            tu.name as to_user_name,
            tu.email as to_user_email,
            eu.parent_email_id as parent_email_id,
            eu.created_at
            from email_user as eu 
            left join users as tu on eu.to_user_id = tu.id 
            left join emails as e on eu.parent_email_id = e.id
            where eu.from_user_id=$userID
            and eu.is_draft=1
            order by created_at desc";
        $inboxEmails = DB::select($sql);

        return $inboxEmails;
    }

    public static function getSentEmails($userID)
    {
        $sql         = "SELECT
            e.id as email_id,
            e.subject as subject,
            e.body as body,
            tu.id as to_user_id,
            tu.name as to_user_name,
            tu.email as to_user_email,
            eu.parent_email_id as parent_email_id,
            eu.created_at
            from email_user as eu 
            left join users as tu on eu.to_user_id = tu.id 
            left join emails as e on eu.parent_email_id = e.id
            where eu.from_user_id=$userID
            order by created_at desc";
        $inboxEmails = DB::select($sql);

        return $inboxEmails;
    }

    public static function getTrashEmails($userID)
    {
        $sql         = "SELECT
            e.id as email_id,
            e.subject as subject,
            e.body as body,
            fu.id as from_user_id,
            fu.name as from_user_name,
            fu.email as from_user_email,
            eu.parent_email_id as parent_email_id,
            eu.has_read as has_read,
            eu.created_at
            from email_user as eu 
            left join users as fu on eu.from_user_id = fu.id 
            left join emails as e on eu.parent_email_id = e.id
            where eu.to_user_id=$userID
            and eu.is_deleted=1
            order by created_at desc";
        $inboxEmails = DB::select($sql);

        return $inboxEmails;
    }

    public static function draftEmail($email)
    {
        try {
            $to      = $email['to'];
            $subject = $email['subject'];
            $body    = $email['body'];
            $from    = $email['from'];
            $emailID = DB::table('emails')->insertGetId(
                ['subject' => $subject, 'body' => $body]
            );
            foreach ($to as $user_id) {
                $ID = DB::table('email_user')->insertGetId(
                    ['from_user_id'    => $from, 'to_user_id' => $user_id, 'email_id' => $emailID,
                     'parent_email_id' => $emailID,
                     'is_draft'        => 1]
                );
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public static function markAsRead($params)
    {
        $markAsRead = DB::table('email_user')
            ->where('email_id', $params['email_id'])
            ->where('parent_email_id', $params['parent_email_id'])
            ->update(['has_read' => 1]);

        return $markAsRead;
    }

    public static function deleteEmail($params)
    {
        $markAsRead = DB::table('email_user')
            ->where('email_id', $params['email_id'])
            ->where('parent_email_id', $params['parent_email_id'])
            ->update(['is_deleted' => 1]);

        return $markAsRead;
    }

    public static function replyEmail($email)
    {
        try {
            $to              = $email['to'];
            $subject         = $email['subject'];
            $body            = $email['body'];
            $from            = $email['from'];
            $parent_email_id = $email['parent_email_id'];
            $emailID         = DB::table('emails')->insertGetId(
                ['subject' => $subject, 'body' => $body]
            );
            foreach ($to as $user_id) {
                $ID = DB::table('email_user')->insertGetId(
                    ['from_user_id' => $from, 'to_user_id' => $user_id, 'email_id' => $emailID, 'parent_email_id' => $parent_email_id]
                );
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
