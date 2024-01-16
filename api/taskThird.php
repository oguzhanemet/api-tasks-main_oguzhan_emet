<?php

// php artisan make:controller VeroDigitalController
// after create the controller

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class VeroDigitalController extends Controller
{

    //Calculate the duration based on start_date, end_date, and durationUnit
    public function DurationV($start_date, $end_date, $durationUnit)
    {
        // Calculate duration logic
        
        $start = Carbon::parse($start_date); //string $start_date The start date in ISO8601 format.
        $end = Carbon::parse($end_date); //string|null $end_date The end date in ISO8601 format (nullable).

        
        switch ($durationUnit) {
            //string $durationUnit The duration unit (HOURS, DAYS, WEEKS).
            case 'HOURS':
               
                $duration = $start->diffInHours($end);
                break;
            case 'DAYS':
                
                $duration = $start->diffInHours($end) / 24;
                break;
            case 'WEEKS':
              
                $duration = $start->diffInHours($end) / (7 * 24);
                break;
            default:
              
                $duration = $start->diffInHours($end) / 24;
                break;
        }

        //int The calculated duration in whole hours.
        $roundedDuration = round($duration);

        return $roundedDuration;
    }
    //Call this function at taskSecond or write again
    public function InputV(Request $request)
    {
        // Validation rules and duration calculation
        
        //Validate the input data against specified rules and calculate duration.
        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Request the all valuables
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $durationUnit = $request->input('durationUnit');

       //Illuminate\Http\Request $request The HTTP request object.
        $request->merge(['duration' => $this->DurationV($start_date, $end_date, $durationUnit)]);
    }

    public function endPoint(Request $request)
    {

        // Call the validation method before processing the request
        $this->InputV($request);

        
    }
}