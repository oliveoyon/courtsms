<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessageTemplateSeeder extends Seeder
{
    public function run()
    {
        DB::table('message_templates')->insert([
            // 1. Initial Hearing Reminder
            [
                'title' => 'Initial Hearing Reminder',
                'body_en_sms' => 'Hello {witness_name}, your case {case_no} is scheduled on {hearing_date} at {hearing_time}. Please attend on time.',
                'body_en_whatsapp' => '📢 Reminder: Dear {witness_name}, your case {case_no} will be heard on {hearing_date} at {hearing_time}. Kindly be present at the court.',
                'body_bn_sms' => 'হ্যালো {witness_name}, আপনার মামলা {case_no} তারিখ {hearing_date} সময় {hearing_time} এ অনুষ্ঠিত হবে। সময়মতো উপস্থিত থাকুন।',
                'body_bn_whatsapp' => '📢 সতর্কবার্তা: {witness_name}, আপনার মামলা {case_no} {hearing_date} তারিখে {hearing_time} সময়ে শুনানি হবে। আদালতে উপস্থিত থাকুন।',
                'body_email' => "Subject: Court Hearing Notification – {case_no}\n\nDear {witness_name},\n\nYour case {case_no} is scheduled for hearing on {hearing_date} at {hearing_time}. Please be present at the court.\n\nThank you,\nCourt Administration",
                'channel' => 'both',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // 2. Hearing Adjourned
            [
                'title' => 'Hearing Adjourned',
                'body_en_sms' => 'Hello {witness_name}, your case {case_no} hearing has been adjourned. Please check with the court for the new date.',
                'body_en_whatsapp' => '📢 Notice: {witness_name}, your case {case_no} hearing is adjourned. Contact the court for updated schedule.',
                'body_bn_sms' => 'হ্যালো {witness_name}, মামলা {case_no} এর শুনানি স্থগিত করা হয়েছে। নতুন তারিখ জানতে আদালতের সাথে যোগাযোগ করুন।',
                'body_bn_whatsapp' => '📢 নোটিশ: {witness_name}, মামলা {case_no} এর শুনানি স্থগিত করা হয়েছে। আদালতের সাথে যোগাযোগ করুন।',
                'body_email' => "Subject: Hearing Adjourned – {case_no}\n\nDear {witness_name},\n\nYour case {case_no} hearing has been adjourned. Please contact the court for the new date.\n\nThank you,\nCourt Administration",
                'channel' => 'both',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // 3. Hearing Rescheduled
            [
                'title' => 'Hearing Rescheduled',
                'body_en_sms' => 'Hello {witness_name}, your case {case_no} hearing has been rescheduled to {hearing_date} at {hearing_time}.',
                'body_en_whatsapp' => '📢 Update: {witness_name}, your case {case_no} hearing is now on {hearing_date} at {hearing_time}.',
                'body_bn_sms' => 'হ্যালো {witness_name}, মামলা {case_no} এর শুনানি নতুন তারিখ {hearing_date} সময় {hearing_time}।',
                'body_bn_whatsapp' => '📢 নোটিশ: {witness_name}, মামলা {case_no} এর শুনানি এখন {hearing_date} তারিখে {hearing_time} সময়ে।',
                'body_email' => "Subject: Hearing Rescheduled – {case_no}\n\nDear {witness_name},\n\nYour case {case_no} hearing has been rescheduled to {hearing_date} at {hearing_time}.\n\nThank you,\nCourt Administration",
                'channel' => 'both',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // 4. Hearing Cancelled
            [
                'title' => 'Hearing Cancelled',
                'body_en_sms' => 'Hello {witness_name}, your case {case_no} hearing scheduled on {hearing_date} has been cancelled.',
                'body_en_whatsapp' => '📢 Notice: {witness_name}, your case {case_no} hearing on {hearing_date} is cancelled.',
                'body_bn_sms' => 'হ্যালো {witness_name}, মামলা {case_no} এর শুনানি {hearing_date} তারিখে বাতিল করা হয়েছে।',
                'body_bn_whatsapp' => '📢 নোটিশ: {witness_name}, মামলা {case_no} এর শুনানি {hearing_date} তারিখে বাতিল করা হয়েছে।',
                'body_email' => "Subject: Hearing Cancelled – {case_no}\n\nDear {witness_name},\n\nThe hearing for your case {case_no} scheduled on {hearing_date} has been cancelled.\n\nThank you,\nCourt Administration",
                'channel' => 'both',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // 5. Follow-up Reminder
            [
                'title' => 'Follow-up Reminder',
                'body_en_sms' => 'Hello {witness_name}, this is a reminder for your case {case_no} scheduled on {hearing_date} at {hearing_time}.',
                'body_en_whatsapp' => '📢 Reminder: {witness_name}, your case {case_no} is coming up on {hearing_date} at {hearing_time}.',
                'body_bn_sms' => 'হ্যালো {witness_name}, মামলা {case_no} এর জন্য {hearing_date} তারিখে {hearing_time} সময়ে উপস্থিত থাকুন।',
                'body_bn_whatsapp' => '📢 নোটিশ: {witness_name}, মামলা {case_no} {hearing_date} তারিখে {hearing_time} সময়ে অনুষ্ঠিত হবে। উপস্থিত থাকুন।',
                'body_email' => "Subject: Court Hearing Reminder – {case_no}\n\nDear {witness_name},\n\nReminder: Your case {case_no} is scheduled on {hearing_date} at {hearing_time}. Please be present at the court.\n\nThanks,\nCourt Administration",
                'channel' => 'both',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // 6. Important Notice / Urgent Update
            [
                'title' => 'Important Notice',
                'body_en_sms' => 'Hello {witness_name}, please note an important update regarding your case {case_no}. Check email or court notice.',
                'body_en_whatsapp' => '⚠️ Important: {witness_name}, update for case {case_no}. Check email or court notice.',
                'body_bn_sms' => 'হ্যালো {witness_name}, মামলা {case_no} সম্পর্কিত গুরুত্বপূর্ণ তথ্য। ইমেল বা আদালতের বিজ্ঞপ্তি দেখুন।',
                'body_bn_whatsapp' => '⚠️ গুরুত্বপূর্ণ: {witness_name}, মামলা {case_no} এর জন্য আপডেট। ইমেল বা আদালতের বিজ্ঞপ্তি দেখুন।',
                'body_email' => "Subject: Important Update – {case_no}\n\nDear {witness_name},\n\nThere is an important update regarding your case {case_no}. Please check your email or court notice for details.\n\nThanks,\nCourt Administration",
                'channel' => 'both',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
