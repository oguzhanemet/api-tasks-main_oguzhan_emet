<?php

// php artisan make:controller VeroDigitalController
// after create the controller

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VeroDigitalController extends Controller
{
    //Validate the input data against specified rules.
    public function InputV(Request $request)
    {
        $Vrules = [
            'name' => 'max:255',
            'start_date' => 'required|date_format:Y-m-d\TH:i:s\Z',
            'end_date' => 'nullable|date_format:Y-m-d\TH:i:s\Z|after_or_equal:start_date',
            'duration' => 'sometimes', 
            'durationUnit' => 'in:HOURS,DAYS,WEEKS',
            'color' => 'nullable|regex:/^#[0-9a-fA-F]{6}$/',
            'externalId' => 'nullable|max:255',
            'status' => 'in:NEW,PLANNED,DELETED',
        ];

        $vMessages = [
            'start_date.date_format' => 'The start_date must be in ISO8601 format (e.g., 2022-12-31T14:59:00Z).',
            'end_date.date_format' => 'The end_date must be in ISO8601 format (e.g., 2022-12-31T14:59:00Z).',
            'end_date.after_or_equal' => 'The end_date must be later than or equal to the start_date.',
            'color.regex' => 'The color must be a valid HEX color (e.g., #FF0000).',
            'status.in' => 'The status field must be one of NEW, PLANNED, or DELETED.',
        ];

        $validator = Validator::make($request->all(), $Vrules, $vMessages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        
    }

    //Process the endpoint after validating input data.

    public function endPointV(Request $request)
    {
    //Illuminate\Http\Request $request The HTTP request object.
        $this->InputV($request);

        
    }
}