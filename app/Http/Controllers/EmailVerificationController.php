<?php

namespace App\Http\Controllers;


use App\Exceptions\InvalidRequestException;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Http\Request;
use Exception;
use Cache;



class EmailVerificationController extends Controller
{
    //

    public function verify(Request $request){

        $email = $request->input('email');
        $token = $request->input('token');

        if(!$email || !$token){
            throw New InvalidRequestException('验证链接不正确');
        }

        if($token != Cache::get('email_verification_'.$email)){
                throw New InvalidRequestException('验证链接不正确或已过期');
        }


        if (!$user = User::where('email', $email)->first()) {
            throw new InvalidRequestException('用户不存在');
        }
        // 将指定的 key 从缓存中删除，由于已经完成了验证，这个缓存就没有必要继续保留。
        Cache::forget('email_verification_'.$email);
        // 最关键的，要把对应用户的 `email_verified` 字段改为 `true`。
        // 之前$user->update(['email_verified' => true]);并不会更新
        // User::where('email', $email)->update(['email_verified' => true]);
        // $user->where('email', $email)->update(['email_verified' => true]);
        $user->update(['email_verified' => true]);

        return view('pages.success',['msg'=>'邮箱验证成功']);

    }

    public function send(Request $request){
        $user = $request->user();
        if($user->email_verified){
            throw new InvalidRequestException('你已经验证过邮箱了');
        }

        $user->notify(new EmailVerificationNotification());

        return view('pages.success',['msg'=>'邮件发送成功']);
    }


}
