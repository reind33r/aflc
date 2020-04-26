<?php

namespace App\Http\Controllers\Race;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Race\Team;

class PaymentController extends Controller
{
    public function showStep5(Request $request) {
        return view('race.register.step5', [
        ]);
    }
}