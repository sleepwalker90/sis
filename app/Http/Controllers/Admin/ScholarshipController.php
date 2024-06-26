<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.scholarships.index',[ 'scholarships' => Scholarship::with('student','student.user')->get() ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $scholarships = explode(',', $request->input('scholarships'));

        $request->validate([
            'newStatus' => 'required|string',
            'reason' => 'nullable|string'
        ]);

        $scholarships = Scholarship::findMany($scholarships);

        foreach ($scholarships as $scholarship) {
            $scholarship->update([
                'status' => $request->newStatus,
                'reason' => $request->reason
            ]);
        }

        return redirect()->route('admin.scholarships.index')->with('success', 'Scholarship statuses updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Scholarship $scholarship)
    {
        $scholarship->delete();
        return back()->with('success', 'Successfully deleted scholarship application!');
    }
}
