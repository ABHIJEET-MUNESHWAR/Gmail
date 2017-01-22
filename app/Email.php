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
        $unreadDrafts = DB::table('email_user')
            ->where('to_user_id', $userID)
            ->where('is_draft', 1)
            ->count();

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
            eu.parent_email_id as parent_email_id,
            eu.has_read as has_read,
            eu.created_at
            from email_user as eu 
            left join users as fu on eu.from_user_id = fu.id 
            left join emails as e on eu.parent_email_id = e.id
            where eu.to_user_id=$userID
            order by created_at desc";
        $inboxEmails = DB::select($sql);

        return $inboxEmails;
    }
}
