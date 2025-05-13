<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PatientRequest;

class PatientController extends Controller
{
    public function index()
    {
        return ResponseHelper::success('Patient successfully', Patient::with('user')->get()->toArray());
    }

    public function store(PatientRequest $request)
    {
        try {
            $validatedData = $request->validated();

            DB::beginTransaction();

            $user = User::create([
                'uuid' => Str::uuid(),
                'name' => $validatedData['name'],
                'id_type' => $validatedData['id_type'] ?? null,
                'id_no' => $validatedData['id_no'] ?? null,
                'gender' => $validatedData['gender'] ?? null,
                'dob' => $validatedData['dob'] ?? null,
                'address' => $validatedData['address'] ?? null,
                'password' => bcrypt($validatedData['id_no'] ?? Str::random(8)),
            ]);
            if (!$user) {
                throw new \Exception('create user failed');
            }

            $patient = Patient::create([
                'user_id' => $user->id,
                'medium_acquisition' => $validatedData['medium_acquisition'] ?? null,
            ]);

            DB::commit();

            return ResponseHelper::success('Patient created successfully', ['patient' => $patient, 'user' => $user]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => 'Failed to create patient',
                'error_code' => 'PATIENT_CREATE_FAILED',
            ];
        
            if (config('app.debug')) {
                $response['exception'] = $e->getMessage();
            }
        
            return response()->json($response, 500);
        }
    }

    public function show($id)
    {
        $patient = $this->findPatientByUuid($id);
        if ($patient instanceof \Illuminate\Http\JsonResponse) {
            return $patient;
        }

        return response()->json($patient);
    }

    public function update(PatientRequest $request, $id)
    {
        $patient = $this->findPatientByUuid($id);
        if ($patient instanceof \Illuminate\Http\JsonResponse) {
            return $patient;
        }

        $validatedData = $request->validated();

        try {
            DB::beginTransaction();
            $patient->update([
                'medium_acquisition' => $validatedData['medium_acquisition'] ?? null,
            ]);

            $patient->user->update([
                'name' => $validatedData['name'],
                'id_type' => $validatedData['id_type'] ?? null,
                'id_no' => $validatedData['id_no'] ?? null,
                'gender' => $validatedData['gender'] ?? null,
                'dob' => $validatedData['dob'] ?? null,
                'address' => $validatedData['address'] ?? null,
            ]);
            DB::commit();
            return ResponseHelper::success('Patient updated successfully', [
                'patient' => $patient->only([
                    'id', 'user_id', 'medium_acquisition', 'created_at', 'updated_at'
                ]),
                'user' => $patient->user
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => 'Failed to update patient',
                'error_code' => 'PATIENT_UPDATE_FAILED',
            ];
        
            if (config('app.debug')) {
                $response['exception'] = $e->getMessage();
            }
        
            return response()->json($response, 500);
        }
    }

    public function destroy($id)
    {
        $patient = $this->findPatientByUuid($id);
        if ($patient instanceof \Illuminate\Http\JsonResponse) {
            return $patient;
        }

        try {
            DB::beginTransaction();
            $patient->user->delete();
            $patient->delete();
            DB::commit();
            return ResponseHelper::success('Patient deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => 'Failed to delete patient',
                'error_code' => 'PATIENT_DELETE_FAILED',
            ];
        
            if (config('app.debug')) {
                $response['exception'] = $e->getMessage();
            }
        
            return response()->json($response, 500);
        }
    }


    //private
    /**
     * Retrieve a patient by UUID.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    private function findPatientByUuid($id)
    {
        // Validate UUID
        if (!Str::isUuid($id)) {
            return ResponseHelper::error('Invalid UUID format', 400);
        }

        // Retrieve patient with associated user
        $patient = Patient::with('user')->whereHas('user', function ($query) use ($id) {
            $query->where('uuid', $id);
        })->first();

        // Check if patient exists
        if (!$patient) {
            return ResponseHelper::error('Patient not found', 404);
        }

        return $patient;
    }
}
