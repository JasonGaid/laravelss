<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Violation;

class ViolationController extends Controller
{
    public function index()
    {
        $violations = Violation::get(); // Retrieve all violations from the database
        return view('violation.index', ['violations' => $violations]); // Pass the violations to the view
    }

    public function add()
    {
        return view('violation.form');
    }

    public function save(Request $request)
    {
        // Create a new Violation instance and save it to the database
        Violation::create([
            'keyword' => $request->keyword,
        ]);

        return redirect()->route('violation');
    }

    public function edit($id)
    {
        $violation = Violation::find($id); // Find the violation by its ID
        return view('violation.form', ['violation' => $violation]); // Pass the violation to the view
    }

    public function update($id, Request $request)
    {
        // Find the violation by its ID and update its keyword
        $violation = Violation::find($id);
        $violation->update([
            'keyword' => $request->keyword,
        ]);

        return redirect()->route('violation');
    }

    public function delete($id)
    {
        // Delete the violation with the given ID
        Violation::destroy($id);
        return redirect()->route('violation.index');
    }
}
