<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\FreeBottleEmail;
use App\Mail\IncompleFormEmail;
use Exception;

// Models
use App\User;
use App\Models\Feedback;
use App\Models\FormTimeTracker;
use App\Models\OrderDetails;
use App\Models\Bottle;
use App\Models\Questionnaire;
use App\Models\QualifyBottles;
use App\Models\VerifiedAsin;
use App\Models\ProductDetails;

use Looxis\LaravelAmazonMWS\Facades\AmazonMWS;

class VimersonHealthController extends Controller
{
    /**
     * store users
     * @param User $model
     * @return array
     */
    public function storeUser(User $model)
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string'
        ]);

        if ($validator->fails()) return $this->resValidator(current($validator->errors()->all()));

        $user = $model->getUserByEmail($data['email']);

        if ($user) $user->update($data);
        else {
            try {
                $user = $model->createUser($data);
            } catch (Exception $e) {
                return $this->resBadRequest($e->getMessage());
            }
        }

        return $this->resSuccess('User Created', $user);
    }

    /**
     * add feedback
     * @param Feedback $model
     * @return array
     */
    public function addFeedback(Feedback $model, QualifyBottles $qb_model, Bottle $b_model)
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'user_id' => 'required|numeric',
            'order_id' => 'required|string',
            'bottle_ids' => 'required|array|exists:bottles,id',
            'stars' => 'required|numeric|min:1|max:5',
            'feedback' => 'required|string|min:50',
            'questionnaire' => 'array'
        ], [
            'feedback.min' => 'Please make your feedback longer (50 characters minimum)'
        ]);
        
        if ($validator->fails()) return $this->resValidator($validator->errors()->all());
        
        if (isset($data['questionnaire'])) $data['questionnaire'] = json_encode($data['questionnaire']);

        if ($qb = $qb_model->getQualifyBottlesByOrder($data['order_id'])) {
            $selected_bottles = count($data['bottle_ids']);
            $qualified_bottles = $qb->qualified_bottles ? explode(',', $qb->qualified_bottles) : [];

            $available_bottles = $qb->total_free_bottles - $qb->qualify_free_bottles;

            if ($selected_bottles > $available_bottles) {
                return $this->resBadRequest('You Qualify for ' . $available_bottles . ' Free Bottle');
            } else if ($qualified_bottles) {
                $diff = array_intersect($data['bottle_ids'], $qualified_bottles);
                if ($diff) return $this->resBadRequest('The ' . $b_model->getBottleNameByID($diff[0])->name . ' bottle you already qualified');
            }
        } else return $this->resBadRequest('Invalid order ID');

        try {
            $feedback = $model->createFeedback($data);
        } catch (Exception $e) {
            return $this->resBadRequest($e->getMessage());
        }

        return $this->resSuccess('Feedback Created', $feedback);
    }

    public function addQualifiedBottles(QualifyBottles $model, Bottle $b_model)
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'user_id' => 'required|numeric',
            'order_id' => 'required|string',
            'bottle_ids' => 'required|array'
        ]);

        if ($validator->fails()) return $this->resValidator(current($validator->errors()->all()));

        if ($qb = $model->getQualifyBottlesByOrder($data['order_id'])) {

            $selected_bottles = count($data['bottle_ids']);
            $qualified_bottles = $qb->qualified_bottles ? explode(',', $qb->qualified_bottles) : [];

            $available_bottles = $qb->total_free_bottles - $qb->qualify_free_bottles;

            if ($selected_bottles > $available_bottles) {
                return $this->resBadRequest('You Qualify for ' . $available_bottles . ' Free Bottle');
            } else if ($qualified_bottles) {
                $diff = array_intersect($data['bottle_ids'], $qualified_bottles);
                if ($diff) return $this->resBadRequest('The ' . $b_model->getBottleNameByID($diff[0])->name . ' bottle you already qualified');
            }

            $qb_data = [
                'qualify_free_bottles' => count($data['bottle_ids']),
                'qualified_bottles' => implode(',', array_merge($data['bottle_ids'], $qualified_bottles))
            ];

            $qb->update($qb_data);

            return $this->resSuccess('Updated');
        }

        return $this->resBadRequest('Invalid order ID');
    }

    public function stepFormTimeTracker(FormTimeTracker $model)
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'user_id' => 'required|numeric',
            'form_id' => 'required|numeric'
        ]);

        if ($validator->fails()) return $this->resValidator(current($validator->errors()->all()));

        $form_time_tracker = $model->getDataByFormUser(['user_id' => $data['user_id'], 'form_id' => $data['form_id']]);

        if ($form_time_tracker) $form_time_tracker->update($data);
        else {
            $model->createFormTimeTracker($data);
        }

        return $this->resSuccess('added');
    }

    /** get amazon order details */
    public function amazonOrderDetails(QualifyBottles $model, VerifiedAsin $va_model, /* Bottle $b_model */ ProductDetails $pd_model)
    {
        $data = request()->all();
        
        $validator = Validator::make($data, [
            'user_id' => 'required|numeric',
            'order_id' => 'required|string'
        ]);

        if ($validator->fails()) return $this->resValidator(current($validator->errors()->all()));

        try {
            $order_details = AmazonMWS::orders()->get($data['order_id']);
            
            if (isset($order_details['data']) && $order_details['data']) {

                $order_items_detail = AmazonMWS::orders()->getItems($data['order_id']);
                
                // $asin_list = $va_model->getAsinList();
                $order_item_list = [];
                
                foreach ($order_items_detail['data'] as $order_items) {
                    $order_item_list[] = $order_items['ASIN'];
                }
                
                // $total_asin = $b_model->bottleCountByAsin($order_item_list);
                $total_free_bottles = $pd_model->productCountByAsin($order_item_list);
                // $total_free_bottles = $total_asin - count(array_intersect($asin_list, $order_item_list));
                
                $model->createOrUpdateQualifyBottle(['user_id' => $data['user_id'], 'order_id' => $data['order_id'], 'total_free_bottles' => $total_free_bottles]);
                return ['status' => ['item_details' => $order_items_detail, 'order_details' => $order_details]];
            } else return ['status' => false];
        } catch (Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
    
    /** get amazon product details by ID */
    public function amazonProducdDetailsByID()
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'order_id' => 'required|string'
        ]);

        if ($validator->fails()) return $this->resValidator(current($validator->errors()->all()));

        return AmazonMWS::orders()->getItems($data['order_id']);
    }

    /**
     * get steps details
     */
    public function getStepDetails(User $model)
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'user_id' => 'required|numeric',
            'bottle_ids' => 'required|array'
        ]);

        if ($validator->fails()) return $this->resValidator(current($validator->errors()->all()));

        $step_details = $model->stepDetails($data['user_id']);
        $step_details['bottles'] = (new Bottle)->getBottleByIDs($data['bottle_ids']);

        if (isset($data['type']) && $data['type'] === 'html') {
            return view('ajax_pages.step_details', compact('step_details'))->render();
        }

        return $step_details;
    }

    /**
     * create order
     */
    public function createOrder(OrderDetails $model)
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'user_id' => 'required|numeric',
            'order_id' => 'required|string',
            'bottle' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required'
        ]);

        if ($validator->fails()) return $this->resValidator(current($validator->errors()->all()));

        $order = $model->updateOrCreate(
            [
                'user_id' => $data['user_id'],
                'order_id' => $data['order_id']
            ],
            $data
        ) ?? [];

        return $this->resSuccess('order created', $order);
    }

    /** get free featured bottles */
    public function getFeaturedBottles(Bottle $model)
    {
        $bottles = $model->getFeaturedBottle();
        
        if (request('type') === 'html') return view('ajax_pages.free_bottles', compact('bottles'))->render();

        return $bottles;
    }

    /** get free featured bottles by ASIN */
    public function getBottleByAsin(Bottle $model, ProductDetails $p_model)
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'asin' => 'required|array'
        ]);

        $bottle_ids = $p_model->getBottleIdsByAsin($data['asin']);
        
        if ($bottle_ids) {
            
            $bottles = [];
            
            foreach ($bottle_ids as $asin => $ids) {
                $bottles[$model->bottleInfoByAsin($asin)->name] = $model->getBottleByAsin(json_decode($ids, true));
            }
            
            if (request('type') === 'html') return view('ajax_pages.free_bottles', compact('bottles'))->render();
            return $bottles;
        }

        return '<div class="text-center">This order does not qualify for a free product. If you think that this information is wrong, or you have any questions, please contact our Customer Happiness team via the chat button at the bottom right of this screen, calling <a href="tel:+8009103491" target="_blank">(800) 910-3491</a> or email us at<strong> </strong><a data-link-card="true" href="mailto:info@vimerson.com" target="_blank">info@vimerson.com</a>.</div>';
    }

    /** get featured questionnaire */
    public function getFeaturedQuestionnaire(Questionnaire $model)
    {
        $questionnaire = $model->getFeaturedQuestion();

        if (request('type') === 'html') {
            return view('ajax_pages.questionnaire', compact('questionnaire'))->render();
        }

        return $questionnaire;
    }

    /**
     * send email
     */
    public function sendEmail(User $model)
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'user_id' => 'required|numeric',
            'bottle_ids' => 'required|array'
        ]);

        if ($validator->fails()) return $this->resValidator(current($validator->errors()->all()));

        if ($mail_data = $model->stepDetails($data['user_id'])) {
            $mail_data['bottles'] = (new Bottle)->getBottleByIDs($data['bottle_ids']);
            $free_bottle_email = 'info@vimerson.com';

            try {
                Mail::to([$mail_data->email/* , $free_bottle_email */])->send(new FreeBottleEmail($mail_data));
            } catch (Exception $e) {
                return $this->resBadRequest($e->getMessage());
            }
            
            return $this->resSuccess('Email has been sent.');
        } else {
            return $this->resBadRequest('Invalid user');
        }
    }

    /** send email for incomplete form time tracker */
    public function sendFormTrackerEmail(FormTimeTracker $model)
    {        
        $interval_mintues = date('Y-m-d H:i:s', strtotime('-10 minutes'));
        $users = $model->sendFormTrackerEmail($interval_mintues);
        
        foreach ($users as $user) {
            $email = $user->userData->email;
            $name = $user->userData->first_name;
            try {
                Mail::to([$email])->send(new IncompleFormEmail(['name' => $name]));
                $user->e_status = 1;
                $user->update();
            } catch (Exception $e) {
                return $this->resBadRequest($e->getMessage());
            }
        }

        return $this->resSuccess('successfully send');
    }

    /** get bottles to qualify */
    public function getBottleToQualify(QualifyBottles $model)
    {   
        $data = request()->all();
        
        $validator = Validator::make($data, [
            'user_id'  => 'required|numeric',
            'order_id' => 'required|string'
        ]);

        if ($validator->fails()) return $this->resValidator(current($validator->errors()->all()));

        $qualify['bottles_to_qualify'] = 0;
        $qualify['total_free_bottles'] = 0;
        
        if ($bottles = $model->getBottlesToQualify($data)) {            
            $qualify['bottles_to_qualify'] = $bottles->total_free_bottles - $bottles->qualify_free_bottles;
            $qualify['total_free_bottles'] = $bottles->total_free_bottles;
        }
        
        return $this->resSuccess('Your order qualifies for ' . $qualify['bottles_to_qualify'] . ' free supplement(s). Please choose which supplement(s) you’d like to order by clicking on the image below', compact('qualify'));
    }

    /** create shopify order */
    public function createShopifyOrder(OrderDetails $model)
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'user_id' => 'required|numeric',
            'order_id' => 'required|string',
            'variant_ids' => 'required|array',
            'shipping_address' => 'required'
        ]);

        if ($validator->fails()) return $this->resValidator(current($validator->errors()->all()));
            
        $shopify_order_data = [];

        foreach ($data['variant_ids'] as $variant) {
            $shopify_order_data['line_items'][] = [
                'variant_id' => $variant,
                'quantity' => 1
            ];
        }

        $shopify_order_data['customer'] = $data['customer_data'];
        $shopify_order_data['customer']['tags'] = 'free_bottle';
        $shopify_order_data['shipping_address'] = $data['shipping_address'];
        $shopify_order_data['tags'] = 'web, free_bottle';
        $shopify_order_data['discount_codes'][] = ['amount' => 100, 'type' => 'percentage'];
        $shopify_order_data['note'] = 'This order is created from free bottles';

        $shopify_order['order'] = $shopify_order_data;
        $headers = ['content-type' => 'application/json'];

        // sahil changes
        $test_url = 'https://api.vimerson.com/app/order/create';
        $shop_resp = json_decode($this->curlReq($test_url, 'POST', json_encode($shopify_order), $headers), true);
        // #sahil changes
        
        // $shop_resp = json_decode($this->curlReq($shopify_url, 'POST', json_encode($shopify_order), $headers), true);
        
        if (isset($shop_resp['order']['id'])) {
            $filter = ['user_id' => $data['user_id'], 'order_id' => $data['order_id']];
            $update_data = ['shopify_order_id' => $shop_resp['order']['id'], 'shopify_order_status' => 1];

            $model->updateOrderById($filter, $update_data);

            return $this->resSuccess('Order successfully created on shopify store');
        }

        $error_message = isset($shop_resp['errors']['line_items'][0]) ? $shop_resp['errors']['line_items'][0] : 'Something went wrong with the store'; 

        return $this->resSuccess($error_message);
    }

    public function testEmail()
    {
        $data = request()->all();
        
        $validator = Validator::make($data, [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) return $this->resValidator(current($validator->errors()->all()));
        
        try {
            Mail::raw('Hello Test Email', function ($message) {
                $message->to(request('email'), 'Test Email')->subject('Test Email');
            });
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return 'success';
    }

    // curl request for all request 
    public function curlReq($url, $request, $payload = [], $headers = [])
    {
        if ($headers) $headers = $this->arrayToCurlHeader($headers);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL             => $url,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => '',
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 30,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => $request,
            CURLOPT_POSTFIELDS      => $payload,
            CURLOPT_HTTPHEADER      => $headers,
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);

        if ($err) echo "cURL Error #:" . $err;
        else return $response;
    }

    // array convert to curl header
    public function arrayToCurlHeader($header)
    {
        foreach ($header as $key => $value) {
            $headers[] = $key . ':' . $value;
        }
        return $headers;
    }
}
