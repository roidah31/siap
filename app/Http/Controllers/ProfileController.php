<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $username_login = $user->username;

    // Get unit data
    $units = DB::connection('mitra')->table('gate.sc_userrole as ur')
        ->join('gate.sc_role as r', 'r.koderole', '=', 'ur.koderole')
        ->join('gate.ms_unit as u', 'u.kodeunit', '=', 'ur.kodeunit')
        ->join('gate.sc_user as us', 'us.userid', '=', 'ur.userid')
        ->leftJoin('akademik.ms_mahasiswa as ms', 'ms.nim', '=', 'us.username')
        ->select([
            'u.kodeunit',
            'u.namaunit'
        ])
        ->where('us.username', $username_login)
        ->distinct()
        ->get();

    // Convert units to array for JavaScript
    // $unitsArray = $units->map(function($unit) {
    //     return [
    //         'kodeunit' => $unit->kodeunit,
    //         'namaunit' => $unit->namaunit
    //     ];
    // })->toArray();
    $unitArr = DB::connection('mitra')->table('gate.sc_userrole as ur')
    ->join('gate.sc_role as r', 'r.koderole', '=', 'ur.koderole')
    ->join('gate.ms_unit as u', 'u.kodeunit', '=', 'ur.kodeunit')
    ->select([
        'u.kodeunit',
        'u.namaunit'
    ])->get();

     
        return view('profile.edit', compact('user','units','unitArr'));
    }

    public function update(Request $request)
    {
        try {
            $user = auth()->user();
            
            // Validation rules
            $rules = [
                'name' => [ 'string', 'max:255'],
                'email' => [ 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'username' => ['string', 'max:255', Rule::unique('users')->ignore($user->id)],
                'kodeunit' => ['nullable', 'string', 'max:255'],
                'namaunit' => ['nullable', 'string', 'max:255'],
            ];
    
            // Validate request
            $validatedData = $request->validate($rules);
    
            // Log the validated data
            \Log::info('Validated Data:', $validatedData);
    
            // Update user
            $user->update($validatedData);
    
            // Log success
            \Log::info('User updated successfully:', ['user_id' => $user->id]);
    
            return redirect()->route('profile.ubah')
                            ->with('status', 'profile-updated')
                            ->with('success', 'Profile updated successfully!');
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error:', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);
            
            return redirect()->back()
                            ->withErrors($e->errors())
                            ->withInput();
                            
        } catch (\Exception $e) {
            \Log::error('Profile Update Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                            ->withErrors(['error' => 'An error occurred while updating your profile: ' . $e->getMessage()])
                            ->withInput();
        }
    }

    public function changePassword()
    {
        return view('profile.changepass');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        // Validate the request
        $validated = $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);

        try {
            // Update password
            $user->update([
                'password' => Hash::make($validated['new_password'])
            ]);

            return redirect()
                ->route('profile.password')
                ->with('success', 'Password has been updated successfully!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'An error occurred while updating your password.')
                ->withInput();
        }
    }

    public function getNamaUnit(Request $request)
    {
        $kodeGedung = $request->input('kode_gedung');
        $lantai = $request->input('lantai');

       //  if ($kodeGedung && $lantai) {
            $units = Unit::where('kode_gedung', $kodeGedung)
                ->where('lantai', $lantai)
                ->select('nama_unit')
                   ->get();
            return response()->json($units);
       //  }

        return response()->json([], 400); // Jika data tidak valid
    }

    public function getNamaGedung(Request $request)
    {
        $kodeunit = $request->kodeunit;
            $namaunit = DB::connection('mitra')->table('gate.ms_unit')
            ->where('kode_gedung', $kodeunit)->value('namaunit'); // Ambil nama_gedung
            return response()->json(['nama_gedung' => $namaunit]);      
    }
    public function getKodeUnit()
    {
        $data = DB::connection('mitra')->table('gate.ms_unit')
               ->select([
            'kodeunit',
            'namaunit'
        ])      
        ->get();       
    return response()->json($data);
    }
 

}
