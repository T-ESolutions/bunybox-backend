<?php

use App\Models\Store;
use App\Models\User;
use App\Models\WalletTransaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Kreait\Firebase\Factory;

//use Kreait\Firebase\Factory;

// Status Codes
function success()
{
    return 200;
}

function register()
{
    return 201;
}

function validation()
{
    return 400;
}

function pending()
{
    return 300;
}

function failed()
{
    return 400;
}

function error()
{
    return 401;
}

function unauthorized()
{
    return 401;
}

function code_sent()
{
    return 402;
}

function token_expired()
{
    return 403;
}

function not_found()
{
    return 404;
}

function complete_register()
{
    return 405;
}

function not_accepted()
{
    return 406;
}

function nearest_radius()
{
    return 100; // 100km
}

function limousine_first_radius()
{
    return 3; // 3km
}

function checkGuard()
{
    if (auth()->guard('host')->check()) {
        return auth()->guard('host')->user();
    } else if (auth()->guard('admin')->check()) {
        return auth()->guard('admin')->user();
    } else {
        return 0;
    }
}

function createLog($item, $_causer, $name, $url, $url_name)
{
    if ($_causer = 1) {
        $causer = checkGuard();
        $details = "(Admin) {$causer->name} create {$name} : {$url_name}";
    }

    activity($name)
        ->performedOn($item)
        ->causedBy($causer->id)
        ->withProperties(['details' => $details, 'type' => 'created', 'user' => $causer->name])
        ->log(ucfirst($name) . " has been created");
}

function editLog($item, $_causer, $name, $url, $url_name)
{
    if ($_causer = 1) {
        $causer = checkGuard();
        $details = "(Admin) {$causer->name} update {$name} : {$url_name}";
    }

    activity($name)
        ->performedOn($item)
        ->causedBy($causer->id)
        ->withProperties(['details' => $details, 'type' => 'updated', 'user' => $causer->name])
        ->log(ucfirst($name) . " has been updated");
}

function delLog($item, $_causer, $name, $deleted_item)
{
    if ($_causer = 1) {
        $causer = checkGuard();
        $details = "(Admin) {$causer->name} delete {$name} : {$deleted_item} ";
    }

    activity($name)
        ->performedOn($item)
        ->causedBy($causer->id)
        ->withProperties(['details' => $details, 'type' => 'deleted', 'user' => $causer->name])
        ->log(ucfirst($name) . " has been deleted");
}

function google_api_key()
{
    return "AIzaSyAGlTpZIZ49RVV5VX8KhzafRqjzaTRbnn0";
}

function msgdata($status = true, $msg = null, $data = null, $code = 200)
{
    $responseArray = [
        'status' => $code,
        'message' => $msg,
        'data' => $data,
    ];
    return response()->json($responseArray, $code);
}


function msg($status, $msg, $code = 200)
{
    $responseArray = [
        'status' => $code,
        'message' => $msg,
    ];
    return response()->json($responseArray, $code);
}

function providerOrderCommision($order, $price, $percent = 10)
{
    $total = ($price * $percent) / 100;
    if ($wallet = Auth::guard('provider')->user()->wallet > $total) {
        $discount = $wallet - $total;
        WalletTransaction::create([
            'price' => $total,
            'type' => 'outcome',
            'provider_id' => Auth::guard('provider')->id(),
            'default_wallet' => $wallet,
            'description_ar' => ' عملية  خصم خاصة بالطلب رقم   ' . $order->id,
            'description_enr' => ' Discount Transaction for order No   ' . $order->id,
            'order_id' => $order->id,
        ]);
        Auth::guard('provider')->user()->update(['wallet' => $discount]);
        return $price;
    } else {
        return $price - $total;
    }
}


function otp_code()
{
//    $code = mt_rand(1000, 9999);
    $code = 1111;
    return $code;
}

function sendToUser($tokens, $title, $msg, $notification_type, $order_id, $order_type)
{
    send($tokens, $title, $msg, $notification_type, $order_id, $order_type);
}

function sendToProvider($tokens, $title, $msg, $notification_type, $order_id, $order_type)
{
    send($tokens, $title, $msg, $notification_type, $order_id, $order_type);
}

function send($tokens, $title, $msg, $product_id)
{
    $api_key = getServerKey();
    $fields = array
    (
        "registration_ids" => $tokens,
        "priority" => 10,
        'data' => [
            'title' => $title,
            'sound' => 'default',
            'message' => $msg,
            'body' => $msg,
            'product_id' => $product_id,
        ],
        'notification' => [
            'title' => $title,
            'sound' => 'default',
            'message' => $msg,
            'body' => $msg,
            'product_id' => $product_id,
        ],
        'vibrate' => 1,
        'sound' => 1
    );
    $headers = array
    (
        'accept: application/json',
        'Content-Type: application/json',
        'Authorization: key=' . $api_key
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    //  var_dump($result);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);

    return $result;
}


function sendRandomNotification($tokens, $title, $msg)
{
    $api_key = getServerKey();
    $fields = array
    (
        "registration_ids" => $tokens,
        "priority" => 10,
        'data' => [
            'title' => $title,
            'sound' => 'default',
            'message' => $msg,
            'body' => $msg,
            'notification_type' => "notification",

        ],
        'notification' => [
            'title' => $title,
            'sound' => 'default',
            'message' => $msg,
            'body' => $msg,
            'notification_type' => "notification",

        ],
        'vibrate' => 1,
        'sound' => 1
    );
    $headers = array
    (
        'accept: application/json',
        'Content-Type: application/json',
        'Authorization: key=' . $api_key
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    //  var_dump($result);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);

    return $result;
}


function getServerKey()
{
//    return 'AAAADvbdcPk:APA91bHaZR9aVyWk4McHLE-KquvHJV3koFG4zjcp5DJOS5I6SAoR-aJ95_D-WY_sFh_2G75U5xkVUOFfTvcAMUOlYI-0hww3jBnDHUS_lSD6I6uPk4t85R6iLdqZgJX2PSghSs2oZYRH';
    return 'AAAA7ZeuoI0:APA91bG--4YIJfp3NPn6xIAiBIYIeDGAOJwXNXm4JM8YYUIvRnbPtwC_SArBLf-OpylQK2LT8--j9Firwt0cX8m5mPFhziFtizOx4pyOZh4fezHwC4P7KsySE400V1JeKeJPOGb_d9iL';
}

function callback_data($status, $key, $data = null, $token = "")
{
    $language = request()->header('lang');
    $response = [
        'status' => $status,
        'msg' => isset($language) && Config::has('response.' . $key) ? Config::get('response.' . $key . '.' . request()->header('lang')) : $key,
        'data' => $data,
    ];
    $token ? $response['token'] = $token : '';
    return response()->json($response);
}

function rateValue($amount, $rate)
{
    return round(($amount * $rate / 100), 2);
}


function getStartOfDate($date)
{
    return date('Y-d-m', strtotime($date)) . ' 00:00';
}

function getEndOfDate($date)
{
    return date('Y-d-m', strtotime($date)) . ' 23:59';
}

function getTimeSlot($interval, $start_time, $end_time)
{
    $start = new DateTime($start_time);
    $end = new DateTime($end_time);
    $startTime = $start->format('H:i');
    $endTime = $end->format('H:i');
    $i = 0;
    $time = [];
    while (strtotime($startTime) <= strtotime($endTime)) {
        $start = $startTime;
        $end = date('H:i', strtotime('+' . $interval . ' minutes', strtotime($startTime)));
        $startTime = date('H:i', strtotime('+' . $interval . ' minutes', strtotime($startTime)));
        $i++;
        if (strtotime($startTime) <= strtotime($endTime)) {
            $time[$i]['slot_start_time'] = $start;
            $time[$i]['slot_end_time'] = $end;
        }
    }
    return $time;
}


if (!function_exists('ArabicDate')) {
    function ArabicDate()
    {
        $months = array("Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر");
        $your_date = date('y-m-d'); // The Current Date
        $en_month = date("M", strtotime($your_date));
        foreach ($months as $en => $ar) {
            if ($en == $en_month) {
                $ar_month = $ar;
            }
        }

        $find = array("Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri");
        $replace = array("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
        $ar_day_format = date('D'); // The Current Day
        $ar_day = str_replace($find, $replace, $ar_day_format);

        header('Content-Type: text/html; charset=utf-8');
        $standard = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $eastern_arabic_symbols = array("٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩");
        $current_date = $ar_day . ' - ' . date('d') . ' ' . $ar_month . ' ' . date('Y');
        $arabic_date = str_replace($standard, $eastern_arabic_symbols, $current_date);

        return $arabic_date;
    }
}


function distance($lat1, $lon1, $lat2, $lon2, $unit = 'K')
{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

function upload($file, $dir)
{
    $image = time() . uniqid() . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('uploads' . '/' . $dir), $image);
    return $image;
}

function unlinkFile($image, $path)
{
    if ($image != null) {
        if (!strpos($image, 'https')) {
            if (file_exists(storage_path("app/public/$path/") . $image)) {
                unlink(storage_path("app/public/$path/") . $image);
            }
        }
    }
    return true;
}


function unlinkImage($image)
{
    if ($image != null) {
        if (!strpos($image, 'https')) {
            if (file_exists($image)) {
                unlink($image);
            }
        }
    }
    return true;
}

// Firebase Connect

function firebase_connect()
{
    $firebase = (new Factory)
        ->withServiceAccount(app_path('goapp-90825-firebase-adminsdk-cp0vq-17f2269a1a.json'))
        ->withDatabaseUri('https://goapp-90825-default-rtdb.firebaseio.com/')
        ->createDatabase();
    return $firebase;
}

function driverChangeOrderStatus($status, $order_type)
{
    if ($order_type == 'Magic') {
        return [
            'AcceptedDelivery' => 'GoToStore',
            'GoToStore' => 'ArriveToStore', // 3
            'ArriveToStore' => 'SendPriceList', // 4
            'AcceptedList' => 'OnWay', // 6
            'OnWay' => 'Arrived',
            'Arrived' => 'Completed',
        ][$status];
    }
    // subscribed
    return [
        'AcceptedDelivery' => 'GoToStore',
        'GoToStore' => 'ArriveToStore', // 3
        'ArriveToStore' => 'OnWay', // 6
        'OnWay' => 'Arrived',
        'Arrived' => 'Completed',
    ][$status];
}

// Admin Helper Functions

if (!function_exists('company_parent')) {
    function company_parent()
    {
        if (Auth::guard('companies')->user()->type == 'Admin') {
            return Auth::guard('companies')->user()->id;
        } else {
            return Auth::guard('companies')->user()->company_id;
        }
    }
}

if (!function_exists('admin_url')) {
    function admin_url($url = null)
    {
        return url('admin/' . $url);
    }
}


if (!function_exists('company_url')) {
    function company_url($url = null)
    {
        return url('company/' . $url);
    }
}
if (!function_exists('admin')) {
    function admin()
    {
        return auth()->guard('admins');
    }
}
if (!function_exists('store')) {
    function store()
    {
        return auth()->guard('stores');
    }
}


function generateArray($products, $min, $max, $limit = 4)
{

    $element = 0;
    $total = 0;
    $newArr = [];
    $new_product_Arr = [];
    $catsArr = [];
    $secArr = [];
    $secondCatsArr = [];
    foreach ($products as $product) {
        if ($total < $max && count($newArr) < $limit) {
            if ($total + $product['sel_price'] <= $max && !in_array($product['category_id'], $catsArr)) {
                array_push($newArr, $product);
                array_push($catsArr, $product['category_id']);
                $total += $product['sel_price'];
            }
        }
    }

    $x = array_merge($products, $newArr);
    $new_product_Arr = arrayUniqueByKey($x, "id");

    foreach ($new_product_Arr as $pro) {
        if ((($total + $pro['sel_price']) >= $min) &&
            (($total + $pro['sel_price']) <= $max) &&
            (!in_array($pro['category_id'], $secondCatsArr))) {
            array_push($secArr, $pro);
            array_push($secondCatsArr, $pro['category_id']);
        }
    }

    if (count($secArr) == 0) {
        if ($element <= 1 && $limit > 3) {
            generateArray($products, $min, $max, $limit - 1);
            $limit--;
            $element++;
        }
    }


    $data = array_merge($newArr, $secArr);
    $data = arrayUniqueByKey($data, "id");
    return $data;

}


function arrayUniqueByKey($array, $key)
{
    $result = [];
    $seenKeys = [];

    foreach ($array as $item) {
        $value = $item[$key];
        if (!isset($seenKeys[$value])) {
            $result[] = $item;
            $seenKeys[$value] = true;
        }
    }

    return $result;
}


