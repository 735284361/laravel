<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MiniAuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $code = $request->input('code');
        $app = app('wechat.mini_program');

        $data = $app->auth->session($code);
        $openId = $data['openid'];
        //查看对应的openid是否已被注册
        $userModel = User::where('openid', $openId)->first();
        //如果未注册，跳转到注册
        if (!$userModel) {
            return ['code' => 10000, 'data' => $data];
        } else {
            return ['code' => 0, 'data' => $userModel];
        }
    }

    public function register(Request $request)
    {
        $app = app('wechat.mini_program');

        $data = $request->validate([
            'session' => 'required',
            'iv' => 'required',
            'encryptedData' => 'required'
        ]);
        $session = $data['session'];
        $iv = $data['iv'];
        $encryptedData = $data['encryptedData'];

        $userInfo = $app->encryptor->decryptData($session, $iv, $encryptedData);
        //根据微信信息注册用户。
        $userData = [
            'openid' => $userInfo['openId'],
            'nickname' => $userInfo['nickName'],
            'api_token' => Str::random(60),
        ];
        //注意批量写入需要把相应的字段写入User中的$fillable属性数组中
        User::create($userData);
        return ['code' => 0];
    }

    public function checkToken(Request $request)
    {
        $data = $request->validate([
            'token' => 'required',
        ]);

        $user = User::where('api_token', $data['token'])->first();

        if ($user) {
            return ['code' => 0];
        } else {
            return ['code' => 1, 'msg' => 'token无效'];
        }
    }
}
