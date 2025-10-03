<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessageTemplateSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // 1️⃣ Insert categories
        $categories = [
            ['name_en' => 'CourtSMS', 'name_bn' => 'কোর্টএসএমএস', 'is_active' => true],
            ['name_en' => 'Urgent Notices', 'name_bn' => 'জরুরি বিজ্ঞপ্তি', 'is_active' => true],
            ['name_en' => 'Reminders', 'name_bn' => 'মনে করিয়ে দিচ্ছে', 'is_active' => true],
            ['name_en' => 'Follow-ups', 'name_bn' => 'ফলোআপ', 'is_active' => true],
        ];

        $categoryIds = [];
        foreach ($categories as $cat) {
            $categoryIds[$cat['name_en']] = DB::table('message_template_categories')->insertGetId(array_merge($cat, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        // 2️⃣ Insert templates (only 1-2 samples per category)
        $templates = [
            // CourtSMS category
            [
                'title' => 'Initial Hearing Reminder',
                'category_id' => $categoryIds['CourtSMS'],
                'body_en_sms' => 'Hello {witness_name}, your case {case_no} is scheduled on {hearing_date} at {hearing_time}. Please attend on time.',
                'body_en_whatsapp' => '📢 Reminder: Dear {witness_name}, your case {case_no} will be heard on {hearing_date} at {hearing_time}. Kindly be present at the court.',
                'body_bn_sms' => 'হ্যালো {witness_name}, আপনার মামলা {case_no} তারিখ {hearing_date} সময় {hearing_time} এ অনুষ্ঠিত হবে। সময়মতো উপস্থিত থাকুন।',
                'body_bn_whatsapp' => '📢 সতর্কবার্তা: {witness_name}, আপনার মামলা {case_no} {hearing_date} তারিখে {hearing_time} সময়ে শুনানি হবে। আদালতে উপস্থিত থাকুন।',
                'body_email' => "Subject: Court Hearing Notification – {case_no}\n\nDear {witness_name},\n\nYour case {case_no} is scheduled for hearing on {hearing_date} at {hearing_time}. Please be present at the court.\n\nThank you,\nCourt Administration",
                'channel' => 'both',
                'is_active' => true,
            ],

            [
                'title' => 'Hearing Adjourned',
                'category_id' => $categoryIds['CourtSMS'],
                'body_en_sms' => 'Hello {witness_name}, your case {case_no} hearing has been adjourned. Please check with the court for the new date.',
                'body_en_whatsapp' => '📢 Notice: {witness_name}, your case {case_no} hearing is adjourned. Contact the court for updated schedule.',
                'body_bn_sms' => 'হ্যালো {witness_name}, মামলা {case_no} এর শুনানি স্থগিত করা হয়েছে। নতুন তারিখ জানতে আদালতের সাথে যোগাযোগ করুন।',
                'body_bn_whatsapp' => '📢 নোটিশ: {witness_name}, মামলা {case_no} এর শুনানি স্থগিত করা হয়েছে। আদালতের সাথে যোগাযোগ করুন।',
                'body_email' => "Subject: Hearing Adjourned – {case_no}\n\nDear {witness_name},\n\nYour case {case_no} hearing has been adjourned. Please contact the court for the new date.\n\nThank you,\nCourt Administration",
                'channel' => 'both',
                'is_active' => true,
            ],

            // Urgent Notices category
            [
                'title' => 'Important Notice',
                'category_id' => $categoryIds['Urgent Notices'],
                'body_en_sms' => 'Hello {witness_name}, please note an important update regarding your case {case_no}. Check email or court notice.',
                'body_en_whatsapp' => '⚠️ Important: {witness_name}, update for case {case_no}. Check email or court notice.',
                'body_bn_sms' => 'হ্যালো {witness_name}, মামলা {case_no} সম্পর্কিত গুরুত্বপূর্ণ তথ্য। ইমেল বা আদালতের বিজ্ঞপ্তি দেখুন।',
                'body_bn_whatsapp' => '⚠️ গুরুত্বপূর্ণ: {witness_name}, মামলা {case_no} এর জন্য আপডেট। ইমেল বা আদালতের বিজ্ঞপ্তি দেখুন।',
                'body_email' => "Subject: Important Update – {case_no}\n\nDear {witness_name},\n\nThere is an important update regarding your case {case_no}. Please check your email or court notice for details.\n\nThanks,\nCourt Administration",
                'channel' => 'both',
                'is_active' => true,
            ],

            // Reminders category
            [
                'title' => 'Follow-up Reminder',
                'category_id' => $categoryIds['Reminders'],
                'body_en_sms' => 'Hello {witness_name}, this is a reminder for your case {case_no} scheduled on {hearing_date} at {hearing_time}.',
                'body_en_whatsapp' => '📢 Reminder: {witness_name}, your case {case_no} is coming up on {hearing_date} at {hearing_time}.',
                'body_bn_sms' => 'হ্যালো {witness_name}, মামলা {case_no} এর জন্য {hearing_date} তারিখে {hearing_time} সময়ে উপস্থিত থাকুন।',
                'body_bn_whatsapp' => '📢 নোটিশ: {witness_name}, মামলা {case_no} {hearing_date} তারিখে {hearing_time} সময়ে অনুষ্ঠিত হবে। উপস্থিত থাকুন।',
                'body_email' => "Subject: Court Hearing Reminder – {case_no}\n\nDear {witness_name},\n\nReminder: Your case {case_no} is scheduled on {hearing_date} at {hearing_time}. Please be present at the court.\n\nThanks,\nCourt Administration",
                'channel' => 'both',
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            DB::table('message_templates')->insert(array_merge($template, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
