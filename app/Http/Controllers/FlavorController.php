<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenStack\OpenStack;
use App\Services\OpenStackService;
use App\Models\Flavor;


class FlavorController extends Controller
{
    public function storeFlavor(Request $request, OpenStackService $openStackService)
    {

        $flavorId = $request->input('flavorId');
        $flavorName = $request->input('name');
        $existingFlavor = $this->checkFlavorByStackId($flavorId);
        if ($existingFlavor) {
            return response()->json(['error' => 'Flavor with the given stackId already exists.'], 409);
        }
        $createdFlavor = $openStackService->storeChosenFlavor($flavorId,$flavorName);

        return response()->json([
            'message' => 'Chosen flavor stored successfully',
            'flavor' => [
                'id' => $createdFlavor->id,
                'Stackid' => $createdFlavor->stackId,
                'name' => $createdFlavor->name,
                'nameInStack'=> $createdFlavor->nameInStack,
                'disk' => $createdFlavor->disk,
                'ram' => $createdFlavor->ram,
                'swap' => $createdFlavor->swap,
                'vcpus' => $createdFlavor->vcpus,
            ],
        ]);
    }

    public function index()
    {
        $flavors = Flavor::getAllFlavors();
        return response()->json($flavors);
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $flavor = Flavor::getFlavor($id);

        if ($flavor) {
            return response()->json($flavor);
        } else {
            return response()->json(['error' => 'Flavor not found'], 404);
        }
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flavor = Flavor::deleteFlavor($id);

        if ($flavor) {
            return response()->json(['message' => 'Flavor deleted successfully']);
        } else {
            return response()->json(['error' => 'Flavor not found'], 404);
        }
    }

    public function checkFlavorByStackId($stackId): ?Flavor
    {
        return Flavor::where('stackId', $stackId)->first();
    }
}
