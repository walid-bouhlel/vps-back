<?php

namespace App\Http\Controllers\OpenStack;

use App\Http\Controllers\Controller;
use App\Services\OpenStackService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function test(Request $request, OpenStackService $openStackService){
        return response()->json($openStackService->createKeyPair());
    }
}
