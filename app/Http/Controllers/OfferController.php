<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Offer;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function index(){
        $offers= Offer::all();
        return response()->json($offers, 200);
        /*return view('offers.index',compact('offers'))*/;
    }

    public function show($offer){
        $offer= Offer::find($offer);
        return view('offers.show',compact('offer'));
    }

    public function findBySearchTerm(string $searchTerm) {
        $offer = Offer::with(['appointments', 'user'])
            ->where('title', 'LIKE', '%' . $searchTerm. '%')
            ->orWhere('subject' , 'LIKE', '%' . $searchTerm. '%')
            ->orWhere('description' , 'LIKE', '%' . $searchTerm. '%')

            /* search term in authors name */
            ->get();
        return $offer;
    }

    public function findById (int $id) :Offer{
        $offer = Offer::where('id', $id)
            ->with(['appointments', 'user', 'comments'])
            ->first();
        return $offer;
    }

    private function parseRequest(Request $request) : Request{
        $date = new \DateTime($request->created_at);
        $request['created_at'] = $date;
        return $request;
    }

    public function delete($id) : JsonResponse
    {
        $offer = Offer::where('id', $id)->first();
        if ($offer != null) {
            $offer->delete();
        }
        else
            throw new \Exception("Offer couldn't be deleted - it does not exist");
        return response()->json('Offer (' . $id . ') successfully deleted', 200);

    }

    //create new Offer
    public function save(Request $request) : JsonResponse{
        $request = $this->parseRequest($request);
        DB::beginTransaction();
        try{
            $offer = Offer::create($request->all());
            //appointments
            if (isset($request['appointments'])&& is_array($request['appointments'])){
                foreach ($request['appointments'] as $app) {
                    $appointment = Appointment::firstOrNew([
                        'date' => $app['date'],
                        'time' => $app['time']
                    ]);
                    $offer->appointments()->save($appointment);
                }
            }

            DB::commit();
            return response()->json($offer, 201);
        }
        catch (\Exception $e){
            DB::rollBack();
            return response()->json('saving offer failed'.$e->getMessage(), 420);
        }
    }

    //update Offer
    public function update(Request $request, int $id) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $offer = Offer::with(['appointments', 'user'])
                ->where('id', $id)->first();
            if ($offer != null) {
                $request = $this->parseRequest($request);
                $offer->update($request->all());

                //delete all old appointments
                $offer->appointments()->delete();
                // save appointments
                if (isset($request['appointments']) && is_array($request['appointments'])) {
                    foreach ($request['appointments'] as $app) {
                        $appointment = Appointment::firstOrNew(['date'=>$app['date'],'time'=>$app['time']]);
                        $offer->appointments()->save($appointment);
                    }
                }
                $offer->save();
            }
            DB::commit();
            $offer1 = Offer::with(['appointments', 'user'])
                ->where('id', $id)->first();
            // return a vaild http response
            return response()->json($offer1, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating offer failed: " . $e->getMessage(), 420);
        }
    }

}
