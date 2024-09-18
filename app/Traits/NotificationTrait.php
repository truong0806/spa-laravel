<?php

namespace App\Traits;

use App\Models\MailTemplates;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\NotificationTemplate;
use App\Models\Setting;
use App\Models\Country;

trait NotificationTrait
{
    function sendNotification($data)
    {
        $sitesetup = \App\Models\Setting::where('type', 'site-setup')->where('key', 'site-setup')->first();
        $app_setting = $sitesetup ? json_decode($sitesetup->value) : null;
        date_default_timezone_set($app_setting->time_zone ?? 'UTC');
        $data['datetime'] = date('Y-m-d H:i:s');
        $admin = User::where('user_type', 'admin')->first();
        $notification_type = $data['activity_type'];
        if (isset($data['booking'])) {
            $booking = $data['booking'];
            $id = $booking->id;
            $providerId = [$booking->provider_id];
            $userId = $booking->customer_id;
        } else if (isset($data['wallet'])) {
            $id = $data['wallet']->id;
            $user_id =  $data['wallet']->user_id;
            $user = User::find($user_id);
            if ($user->user_type == 'provider') {
                $providerId = [$user_id];
            } else if ($user->user_type == 'handyman') {
                $handymanId = [$user_id];
            } else if ($user->user_type == 'user') {
                $userId = $user_id;
            }
            $data['user_id'] = $user_id;
        } else if (isset($data['bid_data'])) {
            $bid_data = $data['bid_data'];

            $id = $bid_data->id;
            $userId = $bid_data->customer_id;
        } else if (isset($data['post_job'])) {
         
            $post_job = $data['post_job'];
            log::info( $post_job );
            $id = $post_job->id;
            $providerId = [$post_job->provider_id];
            $userId = $post_job->customer_id;
        }


        switch ($data['activity_type']) {
            case "add_booking":
                $customer_name = $booking->customer->display_name;

                $data['activity_message'] = __('messages.booking_added', ['name' => $customer_name]);
                $data['activity_type'] = __('messages.add_booking');
                $activity_data = [
                    'service_id' => $booking->service_id,
                    'service_name' => isset($booking->service) ? $booking->service->name : '',
                    'customer_id' => $booking->customer_id,
                    'customer_name' => isset($booking->customer) ? $booking->customer->display_name : '',
                    'provider_id' => $booking->provider_id,
                    'provider_name' => isset($booking->provider) ? $booking->provider->display_name : '',
                ];
                $data['activity_data'] = json_encode($activity_data);
                \App\Models\BookingActivity::create($data);
                break;

            case "assigned_booking":
                $assigned_handyman = handymanNames($booking->handymanAdded);
                $data['activity_message'] = __('messages.booking_assigned', ['name' => $assigned_handyman, 'id' => $booking->id]);
                $data['activity_type'] = __('messages.assigned_booking');
                $handymanId = $booking->handymanAdded->pluck('handyman_id');

                $activity_data = [
                    'handyman_id' => $booking->handymanAdded->pluck('handyman_id'),
                    'handyman_name' => $booking->handymanAdded,
                ];
                $data['activity_data'] = json_encode($activity_data);
                \App\Models\BookingActivity::create($data);

                break;

            case "update_booking_status":
                $status = \App\Models\BookingStatus::bookingStatus($booking->status);
                $old_status = \App\Models\BookingStatus::bookingStatus($booking->old_status);
                $data['activity_type'] = __('messages.update_booking_status');
                $data['activity_message'] = __('messages.booking_status_update', ['id' => $booking->id, 'from' => $old_status, 'to' => $status]);
                $handymanId = $booking->handymanAdded ? $booking->handymanAdded->pluck('handyman_id') : null;
                $activity_data = [
                    'reason' => $booking->reason,
                    'status' => $booking->status,
                    'status_label' => $status,
                    'old_status' => $booking->old_status,
                    'old_status_label' => $old_status,
                ];
                $data['activity_data'] = json_encode($activity_data);
                \App\Models\BookingActivity::create($data);

                break;

            case "cancel_booking":
                $status = \App\Models\BookingStatus::bookingStatus($booking->status);
                $old_status = \App\Models\BookingStatus::bookingStatus($booking->old_status);
                $cancelled_user_name = isset($data['user']) ? $data['user']->display_name: '';
                $data['activity_type'] = __('messages.cancel_booking');
                $data['activity_message'] = __('messages.cancel_booking');
                $handymanId = $booking->handymanAdded ? $booking->handymanAdded->pluck('handyman_id') : null;
                $activity_data = [
                    'reason' => $booking->reason,
                    'status' => $booking->status,
                    'status_label' => \App\Models\BookingStatus::bookingStatus($booking->status),
                ];
                $data['activity_data'] = json_encode($activity_data);
                \App\Models\BookingActivity::create($data);
                break;

            case "payment_message_status":
                $data['activity_type'] = __('messages.payment_message_status');
                $data['activity_message'] = __('messages.payment_message', ['status' => $data['payment_status']]);
                $data['payment_status'] = ($data['payment_status'] === 'advanced_paid')
                    ? __('messages.advance_paid')
                    : $data['payment_status'];
                $data['pay_amount'] = isset($data['booking_amount']) ? $data['booking_amount'] : '';
                $activity_data = [
                    'activity_type' => $data['activity_type'],
                    'payment_status' => $data['payment_status'],
                    'booking_id' => $data['booking_id'],
                    'booking_amount' => $data['booking_amount'] ?? null,
                ];
                $data['activity_data'] = json_encode($activity_data);
                \App\Models\BookingActivity::create($data);
                break;

            case "wallet_payout_transfer":
                $data['activity_message'] = __('messages.wallet_amount', ['value' => getPriceFormat($data['transfer_amount'])]);
                $user = \App\Models\User::find($data['wallet']->user_id);
                $data['customer_name'] = isset($user->display_name) ? $user->display_name : null;
                $data['user_name'] = isset($user->display_name) ? $user->display_name : null;
               $data['pay_amount'] = isset($data['transfer_amount']) ?  getPriceFormat($data['transfer_amount']) : '';
                $activity_data = [
                    'title' => $data['wallet']->title,
                    'user_id' => $data['wallet']->user_id,
                    'provider_name' => isset($data['wallet']->provider) ? $data['wallet']->provider->display_name : '',
                    'amount' => $data['wallet']->amount,
                    'credit_debit_amount' => (float)$data['transfer_amount'],
                    'transaction_type' => __('messages.debit'),
                ];

                $data['activity_data'] = json_encode($activity_data);
                \App\Models\WalletHistory::create($data);

                break;

            case "wallet_top_up":
                $data['activity_message'] = trans('messages.wallet_top_up', ['amount' => getPriceFormat($data['top_up_amount'])]);
              
                $user = \App\Models\User::find($data['wallet']->user_id);
                $data['user_name'] = isset($user->display_name) ? $user->display_name : null;
                $data['credit_debit_amount'] = isset($data['top_up_amount']) ? (float) $data['top_up_amount'] : '';
                $activity_data = [
                    'title' => $data['wallet']->title,
                    'user_id' => $data['wallet']->user_id,
                    'provider_name' => isset($data['wallet']->provider) ? $data['wallet']->provider->display_name : '',
                    'amount' => $data['wallet']->amount,
                    'transaction_id' => $data['transaction_id'],
                    'transaction_type' => $data['transaction_type'],
                    'credit_debit_amount' => (float)$data['top_up_amount'],
                    'transaction_type' => __('messages.credit'),
                ];

    
                $data['activity_data'] = json_encode($activity_data);
                \App\Models\WalletHistory::create($data);
            
            break;

            case "wallet_refund":
                $data['activity_message'] = trans('messages.wallet_refund', ['value' => $data['booking_id']]);
                $data['credit_debit_amount'] = isset($data['refund_amount']) ? $data['refund_amount'] : '';
                $activity_data = [
                    'title' => $data['wallet']->title,
                    'user_id' => $data['wallet']->user_id,
                    'amount' => $data['wallet']->amount,
                    'credit_debit_amount' => $data['refund_amount'],
                    'transaction_type' => __('messages.credit'),
                ];

                $data['activity_data'] = json_encode($activity_data);
                \App\Models\WalletHistory::create($data);
                break;

            case "paid_with_wallet":

            

                $data['activity_message'] = trans('messages.paid_with_wallet', ['value' => $data['booking_id']]);
                $user = \App\Models\User::find($data['wallet']->user_id);
                $data['customer_name'] = isset($user->display_name) ? $user->display_name : null;
                $data['pay_amount'] = isset($data['booking_amount']) ? $data['booking_amount'] : '';
                $amount = isset($data['booking_amount']) ? getPriceFormat($data['booking_amount']) : '';

                $activity_data = [
                    'title' => $data['wallet']->title,
                    'user_id' => $data['wallet']->user_id,
                    'amount' => $data['wallet']->amount,
                    'service_name' => $data['service_name'],
                    'customer_name' => $user->name,
                    'credit_debit_amount' => $data['booking_amount'],
                    'transaction_type' => __('messages.debit'),
                ];

                $data['activity_data'] = json_encode($activity_data);
                \App\Models\WalletHistory::create($data);
                break;

            case "job_requested":
                $data['activity_message'] = __('messages.post_request_message', ['name' => $post_job->customer->display_name,]);
                $data['activity_type'] =  __('messages.post_request_title');
                $customerLatitude = 50.930557;
                $customerLongitude = -102.80777;
                $radius = 50;
                $job_id= isset($post_job->id) ? $post_job->id :'';

                $providers = \App\Models\ProviderAddressMapping::selectRaw("id, provider_id, address, latitude, longitude,
                                ( 6371 * acos( cos( radians($customerLatitude) ) *
                                cos( radians( latitude ) )
                                * cos( radians( longitude ) - radians($customerLongitude)
                                ) + sin( radians($customerLatitude) ) *
                                sin( radians( latitude ) ) )
                                ) AS distance")
                    ->having("distance", "<=", $radius)
                    ->orderBy("distance", 'asc')
                    ->get();
                $providerId = $providers->pluck('providers.id')->toArray();
                $data['provider_name'] = $post_job->provider->display_name ?? null;
                $data['user_name'] = isset($post_job->customer) ? $post_job->customer->display_name : '';
                $activity_data = [
                    'post_request_id' => $post_job->post_request_id,
                    'post_job_name' => $post_job->title,
                    'customer_id' => $post_job->customer_id,
                    'customer_name' => isset($post_job->customer) ? $post_job->customer->display_name : '',
                ];

                $data['activity_data'] = json_encode($activity_data);
                \App\Models\BookingActivity::create($data);


                break;
            case "user_accept_bid":

                $data['activity_message'] = __('messages.bid_accepted_message', ['name' => $post_job->customer->display_name,]);
                $data['activity_type'] =  __('messages.bid_accepted_title');
                $data['provider_name'] = $post_job->provider->display_name ?? null;
                $data['user_name'] = $post_job->customer->display_name ?? null;
                $job_request_id= isset($post_job->id) ?  $post_job->id :'';
                $data['job_price'] = isset(optional($data['post_job'])->job_price) ? optional($data['post_job'])->job_price : '';
                $activity_data = [
                    'post_request_id' => $post_job->post_request_id,
                    'customer_id' => $post_job->customer_id,
                    'customer_name' => isset($post_job->customer) ? $post_job->customer->display_name : '',
                ];

                $data['activity_data'] = json_encode($activity_data);
                \App\Models\BookingActivity::create($data);
                break;
            case "provider_send_bid":
    
                $job_id= isset($bid_data->post_request_id) ? $bid_data->post_request_id :'';

                $bid_amount= isset($bid_data->price) ? getPriceFormat($bid_data->price) :'';

                $data['activity_message'] = __('messages.incomming_bid_message', ['name' =>  $bid_data->provider->display_name, 'price' => getPriceFormat($bid_data->price)]);
                $data['activity_type'] = __('messages.incomming_bid_title', ['name' =>  $bid_data->provider->display_name]);
                $data['user_name'] = isset($bid_data->provider) ? $bid_data->provider->display_name : '';
                $data['customer_name'] = isset($bid_data->customer) ? $bid_data->customer->display_name : '';
         
                $activity_data = [
                    'post_request_id' => $bid_data->post_request_id,
                    'provider_id' => $bid_data->provider_id,
                    'provider_name' => isset($bid_data->provider) ? $bid_data->provider->display_name : '',
                ];

                $data['activity_data'] = json_encode($activity_data);
                \App\Models\BookingActivity::create($data);
                break;


            case "provider_payout":
                $id = $data['id'];
                $providerId = [$data['user_id']];
                $amount = isset($data['amount']) ? getPriceFormat($data['amount']) : '';
                $data['activity_message'] = __('messages.payout_paid', ['type' => 'Admin', 'amount' => getPriceFormat($data['amount'])]);
                $data['currency_symbol'] = countrySymbol();
                $data['pay_amount'] = isset($data['amount']) ? $data['amount'] : '';
                $data['payout_date'] = isset($data['pay_date']) ? $data['pay_date'] : '';
                $activity_data = [
                    'user_id' => $data['user_id'],
                    'amount' => $data['amount'],
                    'credit_debit_amount' => $data['amount'],
                    'transaction_type' => __('messages.debit'),
                ];

                $data['activity_data'] = json_encode($activity_data);
                \App\Models\WalletHistory::create($data);

                break;
            case "handyman_payout":
                $id = $data['id'];
                $handymanId = [$data['user_id']];
                $amount = isset($data['amount']) ? getPriceFormat($data['amount']) : '';
                $data['activity_message'] = __('messages.payout_paid', ['type' => 'Provider', 'amount' => getPriceFormat($data['amount'])]);
                $data['currency_symbol'] = countrySymbol();
                $data['pay_amount'] = isset($data['amount']) ? $data['amount'] : '';
                $data['payout_date'] = isset($data['pay_date']) ? $data['pay_date'] : '';
                $activity_data = [
                    'user_id' => $data['user_id'],
                    'amount' => $data['amount'],
                ];

                $data['activity_data'] = json_encode($activity_data);
                \App\Models\WalletHistory::create($data);

                break;
            case "subscription_add":
                $id = $data['subscription_data']->id;
                $providerId = [$data['subscription_data']->user_id];
                $data['activity_message'] = __('messages.subscription_added');
                $provider = \App\Models\User::find($data['subscription_data']->user_id);
                $data['provider_name'] = isset($provider->display_name) ? $provider->display_name : '';
                $data['plan_name'] = isset(optional($data['subscription_data'])->title) ? optional($data['subscription_data'])->title : '';
                $data['start_date'] = isset(optional($data['subscription_data'])->start_at) ? optional($data['subscription_data'])->start_at : '';
                $data['end_date'] = isset(optional($data['subscription_data'])->end_at) ? optional($data['subscription_data'])->end_at : '';
                $activity_data = [
                    'user_id' => [$data['subscription_data']->user_id],
                    'title' => $data['subscription_data']->title,
                ];
                break;
            case "register":

                $id = $data['user_id'];
                $data['activity_message'] = __('messages.registeration_msg');
                if ($data['user_type'] == 'provider') {
                    $providerId = [$data['user_id']];
                } else if ($data['user_type'] == 'handyman') {
                    $handymanId = [$data['user_id']];
                } else if ($data['user_type'] == 'user') {
                    $userId = $data['user_id'];
                }
                $data['provider_name'] = isset($data['user_name']) ? $data['user_name'] : '';
                $data['handyman_name'] = isset($data['user_name']) ? $data['user_name'] : '';
                $data['customer_name'] = isset($data['user_name']) ? $data['user_name'] : '';
                $data['employee_email'] = isset($data['user_email']) ? $data['user_email'] : '';
                $data['staff_email'] = isset($data['user_email']) ? $data['user_email'] : '';
                $data['user_email'] = isset($data['user_email']) ? $data['user_email'] : '';
                $activity_data = [
                    'user_id' => $data['user_id'],
                    'user_type' => $data['user_type'],
                ];
                break;
            case "withdraw_money";
                $id = $data['id'];
                $data['activity_type'] = $data['activity_type'];
                $data['activity_message'] = trans('messages.withdraw_money',['amount' => getPriceFormat($data['amount'])]);
                $user=User::where('id',$data['user_id'])->first();

                $data['user_name'] = $user->display_name ? $user->display_name  : '';

                $amount = isset($data['amount']) ? getPriceFormat($data['amount']) : '';

                $activity_data = [
                    'user_id' => $data['user_id'],
                    'credit_debit_amount' => $data['amount'],
                    'amount' => $data['wallet']->amount,
                    'transaction_type' => __('messages.debit'),
                ];

                $data['activity_data'] = json_encode($activity_data);
                \App\Models\WalletHistory::create($data);

                break;           
            default:
                $activity_data = [];
                break;
        }
      
        // if (isset($data['booking']) || isset($data['bid_data']) || isset($data['post_job'])) {
        //     \App\Models\BookingActivity::create($data);
        // } else if (isset($data['wallet'])) {            
        //     \App\Models\WalletHistory::create($data);
        // }else if($data['type'] == 'wallet'){
        //     \App\Models\WalletHistory::create($data);
        // }
        $generalsetting = \App\Models\Setting::where('type', 'general-setting')->where('key', 'general-setting')->first();
        $generalsetting = json_decode($generalsetting->value);
        $notification_data = [
            'id'   => $id,
            'type' => $data['activity_type'],
            'message' => $data['activity_message'],
            "ios_badgeType" => "Increase",
            "ios_badgeCount" => 1,
            "notification-type" => $notification_type,
            'admin_name' => $admin ? $admin['display_name'] ?: default_user_name() : '',
            'logged_in_user_role' => $admin ? ucfirst($admin->user_type) ?? '-' : '',
            'company_name' => env('APP_NAME'),
            'company_contact_info' => implode('', [
                $generalsetting->helpline_number . PHP_EOL,
                $generalsetting->inquriy_email,
            ]),
        ];

        if (isset($booking)) {

            $handymanName = null;
            $handymanEmail = null;
            $handymanContact = null;

            $handyman_data = optional(optional($booking->handymanAdded)[0])->handyman;
            if ($handyman_data) {
                $handymanName = $handyman_data->display_name ?? null;
                $handymanEmail = $handyman_data->email ?? null;
                $handymanContact = $handyman_data->contact_number ?? null;
            }
            $booking_datetime = $booking->date;
            list($date, $time) = explode(' ', $booking_datetime);
            
            $notification_data['assignee_name'] = isset($assigned_handyman) ? $assigned_handyman : '';
            $notification_data['booking_id'] = isset($booking->id) ? $booking->id : '';
            $notification_data['amount'] = isset($amount) ? $amount: '';

            $notification_data['booking_status'] = isset($status) ? $status : '';
            $notification_data['old_status'] = isset($status) ? $old_status : '';
            $notification_data['customer_name'] = isset($booking->customer) ? $booking->customer->display_name : '';
            $notification_data['user_email'] = isset($booking->customer) ? $booking->customer->email : '';
            $notification_data['user_contact'] = isset($booking->customer) ? $booking->customer->contact_number : '';
            $notification_data['provider_name'] = isset($booking->provider) ? $booking->provider->display_name : '';
            $notification_data['employee_email'] = isset($booking->provider) ? $booking->provider->email : '';
            $notification_data['employee_contact'] = isset($booking->provider) ? $booking->provider->contact_number : '';
            $notification_data['cancelled_user_name'] =isset($cancelled_user_name) ? $cancelled_user_name : '';
            $notification_data['handyman_name'] = $handymanName;
            $notification_data['staff_email'] = $handymanEmail;
            $notification_data['staff_contact'] = $handymanContact;
            $notification_data['booking_services_name'] = isset($booking->service) ? $booking->service->name : '';
            $notification_data['description'] = isset($booking->service) ? $booking->service->description : '';
            $notification_data['booking_date'] = $date;
            $notification_data['booking_duration'] = isset($booking->service) ? $booking->service->duration : '';
            $notification_data['booking_time'] = $time;
            $notification_data['venue_address'] = $booking->address;
            $notification_data['payment_status'] = isset($data['payment_status']) ? $data['payment_status'] : '';
            $notification_data['payment_type'] = isset($booking->payment) ? $booking->payment->payment_type : '';
            $notification_data['pay_amount'] = isset($booking->payment) ? getPriceFormat($booking->payment->total_amount) : '';
            $notification_data['admin_name'] = $admin ? $admin['display_name'] ?: default_user_name() : '';
            $notification_data['company_contact_info'] = $generalsetting->helpline_number;
            $notification_data['company_name'] =  env('APP_NAME');
            $notification_data['check_booking_type'] = 'booking';
        } elseif (isset($data)) {

            $booking_datetime = $data['datetime'];
            list($date, $time) = explode(' ', $booking_datetime);
            $notification_data['assignee_name'] = isset($assigned_handyman) ? $assigned_handyman : '';
            $notification_data['booking_id'] = isset($data['booking_id']) ? $data['booking_id'] : '';
            $notification_data['booking_date'] = $date;
            $notification_data['booking_time'] = $time;
            $notification_data['amount'] = isset($amount) ? $amount: '';
            $notification_data['booking_services_name'] = isset($data['service_name']) ? $data['service_name'] : '';
            $notification_data['wallet_transaction_id'] = isset($data['transaction_id']) ? $data['transaction_id'] : '';
            $notification_data['wallet_transaction_type'] = isset($data['transaction_type']) ? $data['transaction_type'] : '';
            $notification_data['wallet_amount'] = isset($data['wallet']->amount) ? getPriceFormat($data['wallet']->amount) : '';
            $notification_data['credit_debit_amount'] = isset($data['credit_debit_amount']) ? getPriceFormat($data['credit_debit_amount']) : '';
            $notification_data['job_id'] = isset($job_id) ? $job_id: '';
            $notification_data['job_request_id'] = isset( $job_request_id) ? $job_request_id : '';
            $notification_data['job_name'] = isset($post_job->title) ? $post_job->title : '';
            $notification_data['job_price'] = isset($data['job_price']) ? getPriceFormat($data['job_price']) : '';
            $notification_data['customer_name'] = isset($data['user_name']) ? $data['user_name'] : '';
            $notification_data['job_description'] = isset($data['postjob_data']->description) ? $data['postjob_data']->description : '';
            $notification_data['bid_amount'] = isset($bid_amount) ? $bid_amount: '';
            $notification_data['provider_name'] = isset($data['user_name']) ? $data['user_name'] : '';
            $notification_data['handyman_name'] = isset($data['staff_name']) ? $data['staff_name'] : '';
            $notification_data['refund_amount'] = isset($data['refund_amount']) ? getPriceFormat($data['refund_amount']): '';
            $notification_data['plan_name'] = isset($data['plan_name']) ? $data['plan_name'] : '';
            $notification_data['start_date'] = isset($data['start_date']) ? $data['start_date'] : '';
            $notification_data['end_date'] = isset($data['end_date']) ? $data['end_date'] : '';
            $notification_data['user_name'] = isset($data['user_name']) ? $data['user_name'] : '';
            $notification_data['user_email'] = isset($data['user_email']) ? $data['user_email'] : '';
            $notification_data['employee_email'] = isset($data['user_email']) ? $data['user_email'] : '';
            $notification_data['staff_email'] = isset($data['user_email']) ? $data['user_email'] : '';
            $notification_data['currency_symbol'] = isset($data['currency_symbol']) ? $data['currency_symbol'] : '';
            $notification_data['payout_date'] = isset($data['payout_date']) ? $data['payout_date'] : '';
            $notification_data['admin_name'] = $admin ? $admin['display_name'] ?: default_user_name() : '';
            $notification_data['company_contact_info'] = $generalsetting->helpline_number;
            $notification_data['company_name'] =  env('APP_NAME');
            $notification_data['pay_amount'] = isset(  $data['pay_amount'] ) ?   $data['pay_amount']  : '';

        }
        $mailable = NotificationTemplate::where('type', $notification_type)->with('defaultNotificationTemplateMap')->first();
        if ($mailable != null && $mailable->to != null) {
            $mails = json_decode($mailable->to);

            foreach ($mails as $key => $mailTo) {

                switch ($mailTo) {
                    case 'admin':

                        $admin = \App\Models\User::role('admin')->first();

                        if (isset($admin->email)) {
                            try {
                                $notification_data['user_type'] = $mailTo;
                                $admin->notify(new \App\Notifications\CommonNotification($notification_type, $notification_data));
                            } catch (\Exception $e) {
                                Log::error($e);
                            }
                        }

                        break;

                    case 'provider':
                        if (isset($providerId)) {
                            foreach ($providerId as $id) {
                                $employee = \App\Models\User::find($id);
                                if (isset($employee->email)) {
                                    try {
                                        $notification_data['user_type'] = $mailTo;
                                        $employee->notify(new \App\Notifications\CommonNotification($notification_type, $notification_data));
                                    } catch (\Exception $e) {
                                        Log::error($e);
                                    }
                                }
                            }
                        }
                        break;

                    case 'handyman':
                        if (isset($handymanId)) {
                            foreach ($handymanId as $id) {
                                $employee = \App\Models\User::find($id);
                                if (isset($employee->email) && $employee->user_type == 'handyman') {
                                    try {
                                        $notification_data['user_type'] = $mailTo;
                                        $employee->notify(new \App\Notifications\CommonNotification($notification_type, $notification_data));
                                    } catch (\Exception $e) {
                                        Log::error($e);
                                    }
                                }
                            }
                        }
                        break;

                    case 'user':
                        if (isset($userId)) {
                            $user = \App\Models\User::find($userId);
                            try {
                                $notification_data['user_type'] = $mailTo;
                                $user->notify(new \App\Notifications\CommonNotification($notification_type, $notification_data));
                            } catch (\Exception $e) {
                                Log::error($e);
                            }
                        }
                        break;
                }
            }
        }
    }
}
