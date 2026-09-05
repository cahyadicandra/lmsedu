<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class AdminSchoolController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // Get the first school record since this is a single-school system
        $school = School::first();

        // If no school exists, create a default one
        if (!$school) {
            $school = School::create([
                'name' => 'Nama Sekolah',
                'npsn' => '-',
                'level' => 'SD',
                'status' => 'Negeri',
                'address' => '-',
                'phone' => '-',
            ]);
        }

        return view('admin.sekolah.edit', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'npsn' => 'nullable|string|max:20',
            'level' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
        ]);

        $school = School::first();
        
        if ($school) {
            $school->update($request->all());
        }

        return redirect()->route('admin.sekolah.edit')->with('success', 'Data Sekolah berhasil diperbarui.');
    }
}
