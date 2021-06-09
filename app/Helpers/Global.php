<?php
/**
 * @Author: Sudhir Beladiya
 * @Last Modified by:   Sudhir
 */
function res($message = 'Success')
{
    return response()->json([
        'success'  => true,
        'message'   => $message
    ],200);
}
function res_success($data)
{
    return response()->json($data,200);
}
function res_fail($message = '')
{
    return response()->json([
        'success'  => false,
        'message'   => $message,
    ],400);
}
function otp($length = 4)
{
    return "1234";rand(1000, 9999);
}
function random_num($length = 10)
{
    return rand(1000000000, 9999999999);
}
function unique_code($limit)
{
  return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
}
function otp_token($length = 25)
{
    return Str::random(25);
}

// https://www.codehaven.co.uk/php/php-strings/search-for-multiple-words-in-a-string-php/
function find_in_file_type($needles, $haystack) {
    $count = count(array_intersect(explode('.', strtolower($haystack)),$needles));
    return ($count) ? true : false;
}
function formatMessage($message)
{
    if (is_array($message)) {
        return var_export($message, true);
    } elseif ($message instanceof Jsonable) {
        return $message->toJson();
    } elseif ($message instanceof Arrayable) {
        return var_export($message->toArray(), true);
    }

    return $message;
}
function img($img){
    if($img == ""){
        return asset('main/avatar.jpg');
    }else if (strpos($img, 'http') !== false) {
        return $img;
    }else{
        return asset('storage/'.$img);
    }
}
function productImg($img){
    if($img == ""){
        return asset('storage/default/no-image.png');
    }else if (strpos($img, 'http') !== false) {
        return $img;
    }else if (Storage::disk('local')->exists($img) == false) {
        return asset('storage/default/no-image.png');
    }else{
        return asset('storage/'.$img);
    }
}