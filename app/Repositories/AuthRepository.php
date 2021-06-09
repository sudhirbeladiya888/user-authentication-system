<?php

/**
 * @Author: Sudhir Beladiya
 * @Last Modified by:   Sudhir
 */

namespace App\Repositories;

use App\Interfaces\AuthInterface;

use App\Models\User;
use App\Models\Invitation;
use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Mail;
use Setting;
use Carbon\Carbon;

// FILE UPLOAD
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;

class AuthRepository implements AuthInterface
{
	use UploadAble;
	public function register($req)
	{
		$validator = Validator::make($req->all(),[
			'token' => 'required|string|exists:invitations,token',
			'username' => 'required|string|min:4|max:20||unique:users,username',
			'password' => 'required|string|min:6'
		]);
		if ($validator->fails()) {
			return res_fail($validator->messages()->first());
		}
		$invitation = Invitation::where('token',$req->token)->first();
		$user = User::create([
			'username' => $req->username,
			'email' => $invitation->email,
			'status' => 'deactivated',
			'password' => bcrypt($req->password),
			'registered_at' => Carbon::now()
		]);
		Invitation::where('token',$req->token)->delete();
		$email_verification_code = rand(100000,999999);


		$emailVerification = EmailVerification::create([
			'email' => $user->email,
			'code' => $email_verification_code,
			'token' => unique_code(20),
			'expires_at' => Carbon::now()->addMinutes(10)->toDateTimeString()
		]);
		$details = [
			'title' => 'Verify your acoount using below code',
			'code' => $email_verification_code
		];
		\Mail::to($user->email)->send(new \App\Mail\EmailVerificationMail($details));
		return res_success(['success'=>true,'message'=>'Verify your email to activate your account.',
			'token' => $user->createToken($user->username)->accessToken
		]);
	}
	public function verifyEmail($req)
	{
		$validator = Validator::make($req->all(),[
			'code' => 'required|digits:6'
		]);
		if ($validator->fails()) {
			return res_fail($validator->messages()->first());
		}
		$user = auth()->user();
		$checkCode = EmailVerification::where('code',$req->code)->where('email',$user->email)->first();
		if($checkCode){
			EmailVerification::where('code',$req->code)->where('email',$user->email)->delete();
			$details = [
				'title' => 'Welcome to '.Setting('site_title'),
				'body' => 'Thanks for register i hope you get best service at our platform'
			];
			\Mail::to($user->email)->send(new \App\Mail\WelcomeMail($details));
			return res_success(['success'=>true,'message'=>'Register successfully.',
				'token' => $user->createToken($user->username)->accessToken
			]);
		}else{
			return res_fail('Verification code not valid!');
		}


	}
	public function resendVerification($req)
	{
		$user = auth()->user();
		$email_verification_code = rand(100000,999999);


		$emailVerification = EmailVerification::updateOrCreate(
			['email' => $user->email],
			[
				'email' => $user->email,
				'code' => $email_verification_code,
				'token' => unique_code(20),
				'expires_at' => Carbon::now()->addMinutes(10)->toDateTimeString()
			]);
		$details = [
			'title' => 'Verify your acoount using below code',
			'code' => $email_verification_code
		];
		\Mail::to($user->email)->send(new \App\Mail\EmailVerificationMail($details));
		return res_success(['success'=>true,'message'=>'Verification code successfully sent you email.'
	]);
	}

	public function login($req)
	{
		$validator = Validator::make($req->all(),[
			'email' => 'required|email|exists:users,email',
			'password' => 'required|string|min:6'
		]);
		if ($validator->fails()) {
			return res_fail($validator->messages()->first());
		}
		$attr = [
			'email' => $req->email,
			'password' => $req->password
		];

		if (!Auth::attempt($attr)) {
			return res_fail('Credentials not match');
		}
		$user = auth()->user();
		return res_success(['success'=>true,'data'=>$user,'message'=>'Logged in success.',
			'token' => $user->createToken($user->username)->accessToken
		]);
	}
	public function logout()
	{
		auth()->user()->tokens()->delete();

		return res("Logged out success.");
	}

	public function updateProfile($req)
	{
		$validator = Validator::make($req->all(),[
			'name' => 'required|string|max:255',
			'email' => 'required|string|email',
			'avatar' => 'mimes:jpg,jpeg,png|max:2048|dimensions:width=256,height=256'
		]);
		if ($validator->fails()) {
			return res_fail($validator->messages()->first());
		}
		$user = auth()->user();
		$userupdate = User::find($user->id);
		$userupdate->name = $req->name;
		$userupdate->email = $req->email;
		if ($req->has('avatar') && ($req->avatar instanceof  UploadedFile)) {
			if ($userupdate->avatar != null) {
				$this->deleteOne($userupdate->avatar);
			}
			$userupdate->avatar = $this->uploadOne($req->avatar, 'users_avatar');
		}
		$userupdate->save();
		$user = User::find($user->id);
		return res_success(['success'=>true,'data'=>$user,'message'=>'Profile update successfully.'
	]);
	}
}