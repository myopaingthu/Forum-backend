<?php

/*
** Success response for api request
*/
function success($message, $data)
{
    return response()->json([
        'result' => 1,
        'message' => $message,
        'data' => $data,
    ]);
}

/*
** Success response for api request
*/
function fail($message, $data)
{
    return response()->json([
        'result' => 0,
        'message' => $message,
        'data' => $data,
    ]);
}