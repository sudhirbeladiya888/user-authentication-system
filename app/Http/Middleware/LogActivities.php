<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class LogActivities
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard)
    {
        $response = $next($request);
        // https://github.com/csinghdev/laravel-starter/blob/master/app/Http/Middleware/LogRoute.php
        $log = [
          "user_id"=>auth()->check() ? auth()->user()->id : null,
          "full_path"=>$request->getUri(),
          "name"=>$request->path(),
          "mothod"=>$request->getMethod(),
          "version"=>$guard,
          "request"=>$request->all() ? self::formatMessage($request->all()) : null,
          "headers"=>json_encode($request->headers->all()),
          "auth_token"=>$request->header('Authorization') ?? null,
          "response"=>$response->getContent(),
          "channel"=>app()->environment(),
          "unix_time"=>Carbon::now()->timestamp,
          "agent"=>$request->server('HTTP_USER_AGENT'),
          "remote_ip"=>$request->ip(),
          "remote_location"=>$request->ip(),
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ];
        app('db')
        ->table('log_activities')
        ->insert($log);
        return $response;
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
}