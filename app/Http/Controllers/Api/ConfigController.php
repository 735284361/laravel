<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Http\Controllers\BaseController;
use App\Models\SysConfig;
use Illuminate\Http\Request;

class ConfigController extends BaseController
{
    //
    public function value(Request $request)
    {
        $validatedData = $request->validate([
            'key' => 'required',
        ]);

        $data = SysConfig::where('key',$validatedData['key'])->first();
        if ($data) {
            return $this->success($data);
        } else {
            return $this->error('404');
        }
    }

}
