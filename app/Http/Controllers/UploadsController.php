<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Upload;

class UploadsController extends Controller
{
    public function show(Request $request, $id)
    {
        $userId = $request->input('user_id', optional($request->user())->id);
        return Upload::where('id', $id)->where('user_id', $userId)->firstOrFail();
    }
}
