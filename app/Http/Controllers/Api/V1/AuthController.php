<?php
/**
 * @Author: Sudhir Beladiya
 * @Last Modified by:   Sudhir
 */

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Interfaces\AuthInterface;
class AuthController extends Controller
{

    private $req;
    private $auth;

    public function __construct(Request $req, AuthInterface $auth)
    {
        $this->req     = $req;
        $this->auth    = $auth;
    }

    /**
     * User Registration
     * @param string $token // get from invitation link
     * @param string $username
     * @param string $password // minimum 6 character
     * @return json
     */
    public function register()
    {
        return $this->auth->register($this->req);
    }
    /**
     * User Login
     * @param string $email
     * @param string $password // minimum 6 character
     * @return json
     */
    public function login()
    {
        return $this->auth->login($this->req);
    }

    /**
     * Verify user email
     * @param string $code // 6 DIGIT code from user's mail
     * @return json
     */
    public function verifyEmail()
    {
        return $this->auth->verifyEmail($this->req);
    }
    /**
     * Resend user email verification code
     * @return json
     */
    public function resendVerification()
    {
        return $this->auth->resendVerification($this->req);
    }
    public function logout()
    {
        return $this->auth->logout();
    }
    /**
     * User Profile update
     * @param string $name
     * @param string $email
     * @param string $avatar // max 2MB(JPG,JPEG,PNG) image and dimensions must be 256x256
     * @return json
     */
    public function updateProfile()
    {
        return $this->auth->updateProfile($this->req);
    }
}