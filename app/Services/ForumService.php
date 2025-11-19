<?php

namespace App\Services;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;




class ForumService
{

    public function __construct()
    {
    }


    /**
     * The params required are following like this:
     *
     * @var array<User>,
     * @var message,
     * @var type
     */
    public function createForumAccount($data)
    {
        $credentials =  $this->grapAuthorizationData()->headers();
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-CSRF-Token' => $credentials['X-CSRF-Token'][0],
            'Token' => $credentials['X-CSRF-Token'][0],
            'Cookie' => $credentials['Set-Cookie'][0],
        ])->post(config('constants.flarum.url') . 'api/users', [
            'data' => [ 
                'attributes' => [
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'isEmailConfirmed' => true,
                    'password' => $data['password'],
                ],
            ],
        ]);
        return $response;

    }


    public function grapAuthorizationData()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(config('constants.flarum.url'). 'api/token', [
             'identification' => config('constants.flarum.identification'),
             'password' => config('constants.flarum.granted'),
        ]);

        return $response;
    }


    public function initAccessForum($credential)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(config('constants.flarum.url'). 'api/token', [
             'identification' => $credential['username'],
             'password' => $credential['password'],
            ]);

        return $response;
        }


    public function setCookie($cookieString)
    {
        $cookieParts = explode('; ', $cookieString);        
        $name = null;
        $access = null;
        $value = null;
        $minutes = null;
        $path = null;
        $domain = null;
        $secure = false;
        $httpOnly = true;
       
        
        foreach ($cookieParts as $part) {
            $part = explode('=', $part);
            $key = $part[0];
            $value = isset($part[1]) ? $part[1] : null;
        
            switch ($key) {
                case 'flarum_session':
                    $access = $value;
                    break;
                case 'Domain':
                    $domain = $value;
                    break;
                case 'Path':
                    $path = $value;
                    break;
                case 'Max-Age':
                    $minutes = $value / 60; 
                    break;
                case 'HttpOnly':
                    $httpOnly = true;
                    break;
            }
        }


        $response = response('forum')->cookie('flarum_session', $access, $minutes, $path, $domain, $secure, $httpOnly);
        return $response;
    }
    
}
