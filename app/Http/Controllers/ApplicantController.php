<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ApplicantController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applicants = Applicant::all();
        return view('applicants.index', compact('applicants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('applicants.register',);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Add validation rules here
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits:10',
            'email' => 'required|email|unique:applicants',
            'address' => 'required|string|max:255',
            'dob' => 'required|date|before_or_equal:today|date_format:Y-m-d',
            'gender' => 'required|in:male,female',
            'resume' => 'required|mimes:pdf,docx|max:2048',
            'photo' => 'required|image|mimes:jpg,png|max:2048',
        ]);
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        // Add logic to create a new applicant
        Applicant::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'resume_path' => $request->file('resume')->storeAs('public/resumes', $request->user()->id . '_' . $request->file('resume')->getClientOriginalName()),
            'photo_path' => $request->file('photo')->storeAs('public/photos', $request->user()->id . '_' . $request->file('photo')->getClientOriginalName()),
        ]);

        return redirect()->route('applicants.index')->with('success', 'Applicant added successfully');
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
    public function edit(Applicant $applicant)
    {
        return view('applicants.edit', compact('applicant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Applicant $applicant)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits:10',
            'email' => ['required', 'email', Rule::unique('applicants')->ignore($applicant->id)],
            'address' => 'required|string|max:255',
            'dob' => 'required|date|before_or_equal:today|date_format:Y-m-d',
            'gender' => 'required|in:male,female',
            'resume' => 'nullable|mimes:pdf,docx|max:2048',
            'photo' => 'nullable|image|mimes:jpg,png|max:2048',
        ], [
            'dob.before_or_equal' => 'Applicant must be 18 years or older.',
            'resume.mimes' => 'Allowed file formats are PDF and DOCX.',
            'photo.mimes' => 'Allowed file formats are JPG and PNG.',
            'phone.digits' => 'Phone number must be exactly 10 digits.',
        ]);


        // Update applicant fields
        $applicant->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            // Update other fields as needed
        ]);

        // Update resume if a new file is provided
        if ($request->hasFile('resume')) {
            $applicant->update(['resume_path' => $request->file('resume')->storeAs('public/resumes', $request->user()->id . '_' . $request->file('resume')->getClientOriginalName())]);
        }

        // Update photo if a new file is provided
        if ($request->hasFile('photo')) {
            $applicant->update(['photo_path' => $request->file('photo')->storeAs('public/photos', $request->user()->id . '_' . $request->file('photo')->getClientOriginalName())]);
        }

        return redirect()->route('applicants.index')->with('success', 'Applicant updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $applicant = Applicant::find($id);

        if (!$applicant) {
            return redirect()->route('applicants.index')->with('error', 'Applicant not found');
        }

        $applicant->delete();

        return redirect()->route('applicants.index')->with('success', 'Applicant deleted successfully');
    }

    public function checkEmailUnique(Request $request)
    {
        $email = $request->input('email');

        $isUnique = !Applicant::where('email', $email)->exists();

        return response()->json(['unique' => $isUnique]);
    }
}
