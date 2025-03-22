<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function scanPage()
    {
        return view('agent.scan');
    }

    public function generateQRCode(Request $request)
    {
        
    }
}