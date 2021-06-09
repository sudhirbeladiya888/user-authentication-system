<?php

/**
 * @Author: Sudhir Beladiya
 * @Last Modified by:   Sudhir
 */

namespace App\Interfaces;

interface AuthInterface
{
    public function register($req);
    public function verifyEmail($req);
    public function resendVerification($req);
    public function login($req);
    public function logout();
    public function updateProfile($req);
}