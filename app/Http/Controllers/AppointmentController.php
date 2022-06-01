<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class AppointmentController extends Controller
{
    public function bookAppointment(Request $request, string $id): JsonResponse {
        DB::beginTransaction();
        try {
            $appointment = Appointment::with(['user', 'offer'])
                ->where('id', $id)->first();
            if ($appointment != null) {
                $appointment->update($request->all());
                $appointment->save();
            }
            DB::commit();
            $appointment1= Appointment::with(['user', 'offer'])
                ->where('id', $id)->first();
            // return a vaild http response
            return response()->json($appointment1, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
        }
    }

    public function deleteAppointment(string $id) : JsonResponse
    {
        $appointment = Appointment::where('id', $id)->first();
        if ($appointment != null) {
            $appointment->delete();
        }
        else
            throw new \Exception("Termin konnte nicht gelöscht werden, er existiert nicht");
        return response()->json('Termin (' . $id . ') wurde gelöscht', 200);

    }

    public function getAppointmentsFromUser(string $userId) {
        $appointments = Appointment::where('user_id',$userId)->with(['offer'])->get();
        return $appointments;
    }
}
