<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Constant;
use App\Models\NotificationTemplate;

class NotificationTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        /*
         * NotificationTemplates Seed
         * ------------------
         */

        // DB::table('notificationtemplates')->truncate();
        // echo "Truncate: notificationtemplates \n";

        $types = [
            [
                'type' => 'notification_type',
                'value' => 'add_booking',
                'name' => 'New Service Booking Received!',
            ],
            [
                'type' => 'notification_type',
                'value' => 'assigned_booking',
                'name' => 'Booking Assigned!',
            ],
            [
                'type' => 'notification_type',
                'value' => 'update_booking_status',
                'name' => 'Update Booking',
            ],
            [
                'type' => 'notification_type',
                'value' => 'cancel_booking',
                'name' => 'Cancel On Booking',
            ],
            [
                'type' => 'notification_type',
                'value' => 'payment_message_status',
                'name' => 'Trạng thái thanh toán',
            ],

            [
                'type' => 'notification_type',
                'value' => 'wallet_payout_transfer',
                'name' => 'Wallet Payout Transfer',
            ],
            [
                'type' => 'notification_type',
                'value' => 'wallet_top_up',
                'name' => 'Wallet Topped Up! New Balance Available',
            ],
            [
                'type' => 'notification_type',
                'value' => 'wallet_refund',
                'name' => 'Wallet Refund',
            ],
            [
                'type' => 'notification_type',
                'value' => 'paid_with_wallet',
                'name' => 'Paid For Booking',
            ],
            [
                'type' => 'notification_type',
                'value' => 'job_requested',
                'name' => ' New Custom Job Request',
            ],
            [
                'type' => 'notification_type',
                'value' => 'provider_send_bid',
                'name' => 'Provider Send Bid',
            ],
            [
                'type' => 'notification_type',
                'value' => 'user_accept_bid',
                'name' => 'User Accept Bid',
            ],

            [
                'type' => 'notification_type',
                'value' => 'provider_payout',
                'name' => 'Payout Process',
            ],



            [
                'type' => 'notification_type',
                'value' => 'subscription_add',
                'name' => 'Subscription Add',
            ],
            // [
            //     'type' => 'notification_type',
            //     'value' => 'subscription_reminder',
            //     'name' => 'Subscription Reminder',
            // ],
            [
                'type' => 'notification_type',
                'value' => 'register',
                'name' => 'Register',
            ],
            [
                'type' => 'notification_type',
                'value' => 'withdraw_money',
                'name' => 'Withdraw Money',
            ],
            // [
            //     'type' => 'notification_type',
            //     'value' => 'forget_password',
            //     'name' => 'Forget Email/Password',
            // ],
            // [
            //     'type' => 'notification_param_button',
            //     'value' => 'id',
            //     'name' => 'ID',
            // ],


            [
                'type' => 'notification_param_button',
                'value' => 'customer_name',
                'name' => 'Customer Name',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'admin_name',
                'name' => 'Admin Name',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'provider_name',
                'name' => 'Provider Name',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'handyman_name',
                'name' => 'Handyman Name',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'booking_id',
                'name' => 'Booking ID',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'booking_services_name',
                'name' => 'Booking Services Name',
            ],

            [
                'type' => 'notification_param_button',
                'value' => 'booking_date',
                'name' => 'Booking Date',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'booking_time',
                'name' => 'Booking Time',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'venue_address',
                'name' => 'Venue / Address',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'booking_status',
                'name' => 'Booking Status',
            ],

            [
                'type' => 'notification_param_button',
                'value' => 'cancelled_user_name',
                'name' => 'Cancelled User Name',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'payment_status',
                'name' => 'Payment Status',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'company_contact_info',
                'name' => 'Company Info',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'company_name',
                'name' => 'Company Name',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'credit_debit_amount',
                'name' => 'Wallet Credit/Debit Amnount',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'pay_amount',
                'name' => 'Pay Amount',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'wallet_transaction_id',
                'name' => 'wallet Transaction ID',
            ],

            [
                'type' => 'notification_param_button',
                'value' => 'wallet_transaction_type',
                'name' => 'wallet Transaction Type',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'wallet_amount',
                'name' => 'wallet Amount',
            ],


            [
                'type' => 'notification_param_button',
                'value' => 'refund_amount',
                'name' => 'Refund Amount',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'amount',
                'name' => 'Amount',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'job_id',
                'name' => 'Job ID',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'job_name',
                'name' => 'Job Name',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'job_description',
                'name' => 'Job Description',
            ],
            [
                'type' => 'notification_param_button',
                'value' => 'bid_amount',
                'name' => 'Bid Amount',
            ],

            [
                'type' => 'notification_param_button',
                'value' => 'job_price',
                'name' => 'Job Price',
            ],

            [
                'type' => 'notification_param_button',
                'value' => 'plan_name',
                'name' => 'Subscription Plan Name',
            ],

            [
                'type' => 'notification_param_button',
                'value' => 'start_date',
                'name' => 'Start Date',
            ],

            [
                'type' => 'notification_param_button',
                'value' => 'end_date',
                'name' => 'End Date',
            ],

            [
                'type' => 'notification_param_button',
                'value' => 'user_name',
                'name' => 'User Name',
            ],

            [
                'type' => 'notification_param_button',
                'value' => 'user_email',
                'name' => 'User Email',
            ],






            ////////////////////////////////////////////////////////////////////////////////////////////////////////////





            [
                'type' => 'notification_to',
                'value' => 'user',
                'name' => 'User',
            ],

            [
                'type' => 'notification_to',
                'value' => 'provider',
                'name' => 'Provider',
            ],
            [
                'type' => 'notification_to',
                'value' => 'handyman',
                'name' => 'Handyman',
            ],

            [
                'type' => 'notification_to',
                'value' => 'demo_admin',
                'name' => 'Demo Admin',
            ],
            [
                'type' => 'notification_to',
                'value' => 'admin',
                'name' => 'Admin',
            ],
        ];

        foreach ($types as $value) {
            Constant::updateOrCreate(['type' => $value['type'], 'value' => $value['value']], $value);
        }

        echo " Insert: notificationtempletes \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('notification_templates')->delete();
        DB::table('notification_template_content_mapping')->delete();

        $template = NotificationTemplate::create([
            'type' => 'add_booking',
            'name' => 'add_booking',
            'label' => 'Booking confirmation',
            'status' => 1,
            'to' => '["admin","provider"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'admin',
            'status' => 1,
            'subject' => 'New Booking Received',
            'template_detail' => '<p>New booking #[[ booking_id ]] - [[ customer_name ]] has booked [[ booking_services_name ]].</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'provider',
            'status' => 1,
            'subject' => 'New Booking Received',
            'template_detail' => '<p>New booking #[[ booking_id ]] - [[ customer_name ]] has booked [[ booking_services_name ]].</p>',
        ]);

        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'handyman',
            'status' => 1,
            'subject' => 'Booking Assigned!',
            'template_detail' => '<p>#[[ booking_id ]] - You have been assigned to provide [[ booking_services_name ]]. Please proceed accordingly.</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'assigned_booking',
            'name' => 'assigned_booking',
            'label' => 'Booking Assigned',
            'status' => 1,
            'to' => '["handyman","user","provider"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'handyman',
            'status' => 1,
            'subject' => 'Booking Assigned!',
            'template_detail' => '<p>#[[ booking_id ]] - You have been assigned to provide [[ booking_services_name ]]. Please proceed accordingly.</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'user',
            'status' => 1,
            'subject' => 'Booking Assigned!',
            'template_detail' => '<p>#[[ booking_id ]] - [[ assignee_name ]] has been assigned to [[ booking_services_name ]].</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'provider',
            'status' => 1,
            'subject' => 'Booking Assigned!',
            'template_detail' => '<p>#[[ booking_id ]] - [[ assignee_name ]] has been assigned to [[ booking_services_name ]].</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'update_booking_status',
            'name' => 'update_booking_status',
            'label' => 'Booking Update',
            'status' => 1,
            'to' => '["admin", "provider" , "handyman" , "user"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'admin',
            'status' => 1,
            'status' => 1,
            'subject' => 'Booking Update',
            'template_detail' => '<p>#[[ booking_id ]] - Status for [[ booking_services_name ]] has changed to [[ booking_status ]].</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'provider',
            'status' => 1,
            'subject' => 'Booking Update',
            'template_detail' => '<p>#[[ booking_id ]] - Status for [[ booking_services_name ]] has changed to [[ booking_status ]].</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'handyman',
            'status' => 1,
            'subject' => 'Booking Update',
            'template_detail' => '<p>#[[ booking_id ]] - Status for [[ booking_services_name ]] has changed to [[ booking_status ]].</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'user',
            'status' => 1,
            'subject' => 'Booking Confirmation',
            'template_detail' => '<p>#[[ booking_id ]] - Status for [[ booking_services_name ]] has changed to [[ booking_status ]].</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'cancel_booking',
            'name' => 'cancel_booking',
            'label' => 'Cancel On Booking',
            'status' => 1,
            'to' => '["admin", "provider" , "handyman" , "user"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'admin',
            'status' => 1,
            'subject' => 'Booking Cancelled',
            'template_detail' => '<p>#[[ booking_id ]] - [[ booking_services_name ]] has been cancelled.</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'provider',
            'status' => 1,
            'subject' => 'Booking Cancelled',
            'template_detail' => '<p>#[[ booking_id ]] - [[ booking_services_name ]] has been cancelled.</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'handyman',
            'status' => 1,
            'subject' => 'Booking Cancelled',
            'template_detail' => '<p>#[[ booking_id ]] - [[ booking_services_name ]] has been cancelled.</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'user',
            'status' => 1,
            'subject' => 'Booking Cancelled',
            'template_detail' => '<p>#[[ booking_id ]] - [[ booking_services_name ]] has been cancelled.</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'payment_message_status',
            'name' => 'payment_message_status',
            'label' => 'Payment Status Update',
            'status' => 1,
            'to' => '["user","handyman","provider","admin"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'user',
            'status' => 1,
            'subject' => 'Payment Status Update',
            'template_detail' => '<p>#[[ booking_id ]] - Payment For [[ booking_services_name ]] changed to [[ payment_status ]].</p>',
        ]);

        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'admin',
            'status' => 1,
            'subject' => 'Payment Status Update',
            'template_detail' => '<p>#[[ booking_id ]] - Payment For [[ booking_services_name ]] changed to [[ payment_status ]].</p>',

        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'provider',
            'status' => 1,
            'subject' => 'Payment Status Update',
            'template_detail' => '<p><#[[ booking_id ]] - Payment For [[ booking_services_name ]] changed to [[ payment_status ]].</p>',

        ]);

        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'handyman',
            'status' => 1,
            'subject' => 'Payment Status Update',
            'template_detail' => '<p>#[[ booking_id ]] - Payment For [[ booking_services_name ]] changed to [[ payment_status ]].</p>',

        ]);

        $template = NotificationTemplate::create([
            'type' => 'wallet_payout_transfer',
            'name' => 'wallet_payout_transfer',
            'label' => 'Wallet Payout Transfer',
            'status' => 1,
            'to' => '["admin","provider","handyman"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'admin',
            'status' => 1,
            'subject' => 'Wallet Payout Transfer',
            'template_detail' => '<p>Payout of [[ pay_amount ]] has been processed.</p>',
        ]);

        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'provider',
            'status' => 1,
            'subject' => 'Payout Received',
            'template_detail' => '<p>You have received a payout of [[ pay_amount ]].</p>',
        ]);

        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'handyman',
            'status' => 1,
            'subject' => 'Payout Received',
            'template_detail' => '<p>You have received a payout of [[ pay_amount ]].</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'wallet_top_up',
            'name' => 'wallet_top_up',
            'label' => 'Wallet Top Up',
            'status' => 1,
            'to' => '["admin","provider","user"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'admin',
            'status' => 1,
            'subject' => 'Wallet Top-Up',
            'template_detail' => '<p>[[ customer_name ]] has topped up wallet with [[ credit_debit_amount ]].</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'provider',
            'status' => 1,
            'subject' => 'Wallet Top-Up',
                'template_detail' => '<p>[[ credit_debit_amount ]] has been added to your wallet.</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'user',
            'status' => 1,
            'subject' => 'Wallet Top-Up',
            'template_detail' => '<p>[[ credit_debit_amount ]] has been added to your wallet.</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'wallet_refund',
            'name' => 'wallet_refund',
            'label' => 'Wallet Refund',
            'status' => 1,
            'to' => '["admin","provider","user"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'admin',
            'status' => 1,
            'subject' => 'Wallet Refund',
            'template_detail' => '<p>#[[ booking_id ]] - Refund of [[ refund_amount ]] has been processed to the customer.</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'provider',
            'status' => 1,
            'subject' => 'Wallet Refund',
            'template_detail' => '<p>#[[ booking_id ]] - Refund of [[ refund_amount ]] has been processed to the customer.</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'user',
            'status' => 1,
            'subject' => 'Wallet Refund',
            'template_detail' => '<p>#[[ booking_id ]] - Refund of [[ refund_amount ]] has been processed to your wallet.</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'paid_with_wallet',
            'name' => 'paid_with_wallet',
            'label' => 'Paid For Booking',
            'status' => 1,
            'to' => '["admin","provider","handyman","user"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'admin',
            'status' => 1,
            'subject' => 'Payment Paid For Booking',
            'template_detail' => '<p>#[[ booking_id ]] - [[ customer_name ]] has paid payment of [[ amount ]] using wallet.</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'provider',
            'status' => 1,
            'subject' => 'Payment Paid For Booking',
            'template_detail' => '<p>#[[ booking_id ]] - [[ customer_name ]] has paid payment of [[ amount ]] using wallet.</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'handyman',
            'status' => 1,
            'subject' => 'Payment Paid For Booking',
            'template_detail' => '<p>#[[ booking_id ]] - [[ customer_name ]] has paid payment of [[ amount ]] using wallet.</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'user',
            'status' => 1,
            'subject' => 'Payment Paid For Booking',
            'template_detail' => '<p>#[[ booking_id ]] - Payment of [[ amount ]] using wallet paid successfully.</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'job_requested',
            'name' => 'job_requested',
            'label' => 'New Custom Job Request',
            'status' => 1,
            'to' => '["admin","provider"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1'],
        ]);

        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'New Custom Job Request',
            'status' => 1,
            'user_type' => 'admin',
            'subject' => 'New Custom Job Request',
            'template_detail' => '<p>#[[ job_id ]] - [[ customer_name ]] has requested a new job [[ job_name ]].</p>',
        ]);

        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'New Custom Job Request',
            'status' => 1,
            'user_type' => 'provider',
            'subject' => 'New Custom Job Request',
            'template_detail' => '<p>#[[ job_id ]] - [[ customer_name ]] has requested a new job [[ job_name ]].</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'provider_send_bid',
            'name' => 'provider_send_bid',
            'label' => 'Provider Send Bid',
            'status' => 1,
            'to' => '["user"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'user',
            'status' => 1,
            'subject' => 'New Bid Received',
            'template_detail' => '<p>#[[ job_id ]] - You have received a new bid of [[ bid_amount ]] from [[ provider_name ]] on your job request. Check it out!</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'user_accept_bid',
            'name' => 'user_accept_bid',
            'label' => 'Bid Accepted',
            'status' => 1,
            'to' => '["provider"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'provider',
            'status' => 1,
            'subject' => 'Job Bid Accepted',
            'template_detail' => '<p>#[[ job_request_id ]] - Your bid of [[ job_price ]] for the job request has been accepted by [[ customer_name ]].</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'provider_payout',
            'name' => 'provider_payout',
            'label' => 'Provider Payout',
            'status' => 1,
            'to' => '["provider","handyman_payout"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'provider',
            'status' => 1,
            'subject' => 'Payout Processed',
            'template_detail' => '<p>Your payout of [[ amount ]] has been processed.</p>',
        ]);

        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'handyman',
            'status' => 1,
            'subject' => 'Payout Processed',
            'template_detail' => '<p>Your payout of [[ amount ]] has been processed.</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'subscription_add',
            'name' => 'subscription_add',
            'label' => 'Subscription Add',
            'status' => 1,
            'to' => '["admin","provider"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'admin',
            'status' => 1,
            'subject' => 'New Subscription Plan Activated',
            'template_detail' => '<p>[[ provider_name ]] has susbcribed to a new [[ plan_name ]].</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'provider',
            'status' => 1,
            'subject' => 'New Subscription Plan Activated',
            'template_detail' => '<p>New plan susbcribed - [[ plan_name ]].</p>',
        ]);


        $template = NotificationTemplate::create([
            'type' => 'register',
            'name' => 'register',
            'label' => 'Register',
            'status' => 1,
            'to' => '["admin","provider","handyman","user"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1'],
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'admin',
            'status' => 1,
            'subject' => 'New User Registration',
            'template_detail' => '<p>[[ user_name ]] is now registered with us!</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'provider',
            'status' => 1,
            'subject' => 'New User Registration',
            'template_detail' => '<p>Welcome aboard! We are happy to have you on our team. Your expertise is going to be invaluable to our customers.</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'handyman',
            'status' => 1,
            'subject' => 'New User Registration',
            'template_detail' => '<p>Welcome to the team! We are excited to have you on board. Your skills are going to be a huge asset to our customers.</p>',
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'user',
            'status' => 1,
            'subject' => 'New User Registration',
            'template_detail' => '<p>Welcome! We are excited to have you join our community. We are looking forward to seeing how you will use our platform to achieve your goals.</p>',
        ]);

        $template = NotificationTemplate::create([
            'type' => 'withdraw_money',
            'name' => 'withdraw_money',
            'label' => 'Withdraw Money',
            'status' => 1,
            'to' => '["admin","provider","user"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1'],
        ]);

        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'admin',
            'status' => 1,
            'subject' => 'Money Withdrawn',
            'template_detail' => '<p>[[ user_name ]] has withdrawn [[ amount ]] from the wallet.</p>',
        ]);

        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'provider',
            'status' => 1,
            'subject' => 'Money Withdrawn',
            'template_detail' => '<p>You have withdrawn [[ amount ]] from the wallet.</p>',
        ]);

        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'user_type' => 'user',
            'status' => 1,
            'subject' => 'Money Withdrawn',
            'template_detail' => '<p>You have withdrawn [[ amount ]] from the wallet.</p>',
        ]);
    }
}
