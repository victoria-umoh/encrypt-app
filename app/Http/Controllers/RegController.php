<?php

namespace App\Http\Controllers;

use App\Models\Reg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegController extends Controller
{
    public function reg(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'mobile_network' => 'required|string|in:mtn,airtel,9mobile,glo',
            'message' => 'required|string',
            'ref_code' => 'required|string|unique:regs,ref_code'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()
            ], 400);
        }

        // Create a new registration
        $registration = Reg::create([
            'phone_number' => $request->phone_number,
            'mobile_network' => $request->mobile_network,
            'message' => 'Registration successful',
            'ref_code' => $request->ref_code
        ]);

        // Return the response
        return response()->json([
            'phone_number' => $registration->phone_number,
            'mobile_network' => $registration->mobile_network,
            'status' => 'success',
            'message' => 'Registration successful'
        ], 201);
    }}
