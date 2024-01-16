<?php


// php artisan make:controller VeroDigitalController
// after create the controller


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConstructionStage;

class VeroDigitalController extends Controller
{
    

    //Update a construction stage by ID.
    public function Vupdate(Request $request, $id)
    {

        // Find the construction stage by ID
        $constructionStage = ConstructionStage::find($id);

        if (!$constructionStage) {
            return response()->json(['error' => 'Stage not found'], 404);
        }

        // Get the fields sent by the user in the request
        $data = $request->only(['name', 'status', 'other_field']);

        // Validate the 'status' field if it is sent
        if (isset($data['status']) && !in_array($data['status'], ['NEW', 'PLANNED', 'DELETED'])) {
            return response()->json(['error' => 'Invalid status value'], 400);
        }

         // Update only the fields sent by the user
        $constructionStage->fill($data);
        $constructionStage->save();

        return response()->json(['message' => 'Construction stage updated successfully', 'constructionStage' => $constructionStage]);
    }

    //Delete a construction stage by setting its status to DELETED.
    public function Vdelete($id)
    {
         // Find the construction stage by ID
        $constructionStage = ConstructionStage::find($id);

        if (!$constructionStage) {
            return response()->json(['error' => 'Stage not found'], 404);
        }

         // Set the 'status' field to 'DELETED'
        $constructionStage->status = 'DELETED';
        $constructionStage->save();

        return response()->json(['message' => 'Stage status set to DELETED', 'constructionStage' => $constructionStage]);
    }
}