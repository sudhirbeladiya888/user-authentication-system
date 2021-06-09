<?php
/**
 * @Author: Sudhir Beladiya
 * @Last Modified by:   Sudhir
 */
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Mail;
use Setting;

use App\Models\Invitation;
class InvitationController extends Controller
{

    public function send(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|unique:users,email',
        ]);
        if ($validator->fails()) {
            return res_fail($validator->messages()->first());
        }
        $invitation = Invitation::updateOrCreate(['email' => $request->email],
            [
                'email' => $request->email,
                'token' => unique_code(20)
            ]
        );
        $details = [
            'title' => 'Invitation mail',
            'body' => 'We warmly inviting you to register in our platform and get exciting feature only for you'
        ];
        \Mail::to($request->email)->send(new \App\Mail\InvitationMail($details));
        return res_success(['success'=>true,'message'=>'Invitation send successfully.'
        ]);
    }
}