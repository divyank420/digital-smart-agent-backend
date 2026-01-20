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
    if ($status !== 0 && $status !== 1) {
        http_response_code($status); // e.g. 500, 404, 401
    } else {
        http_response_code(200);
    }
    $response = ['status' => $status, 'message' => $message];
    if (!empty($extra)) {
        extract($extra);
        $response = array_merge($response, $extra);
    }
    if ($status != 0 && !empty($data)) {
        if (!empty($data)) {
            $response['data'] = $data;
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

function getAgentList()
{
    return Helper::getTeamMember();
}
