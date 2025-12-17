<?php

use App\Helper\Helper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

function amountFormat($amount)
{
    return '₹' . number_format($amount);
}

function pr($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
function getUser()
{
    return Auth::user();
}

function sendResponse($message = 'Something went wrong', $status = 0, $data = null, $extra = null)
{
    $response = ['status' => $status, 'message' => $message];
    if (!empty($extra)) {
        extract($extra);
        $response = array_merge($response, $extra);
    }
    if ($status != 0) {
        if (!empty($data)) {
            $response['data'] = $data;
        }
    }
    echo json_encode($response);
    die;
}

function getAgentList()
{
    return Helper::getTeamMember();
}
