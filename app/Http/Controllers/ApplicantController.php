<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

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
        return view('applicants.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateApplicant($request);

        $filePath = $this->storePhoto($request);

        $this->createApplicant($request, $filePath);

        return redirect()->route('applicants.index')->with('success', 'Applicant added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not implemented yet
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
        $this->validateApplicant($request, $applicant);

        if( $request->croppedImageData){
            $filePath = $this->updatePhoto($request);
        }else{
            $filePath = null;
        }
        $this->updateApplicant($request, $applicant, $filePath);

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

    /**
     * Check if the email is unique via AJAX.
     */
    public function checkEmailUnique(Request $request)
    {
        $email = $request->input('email');

        $isUnique = !Applicant::where('email', $email)->exists();

        return response()->json(['unique' => $isUnique]);
    }

    /**
     * Validate the applicant data.
     */
    private function validateApplicant(Request $request, $applicant = null)
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits:10',
            'email' => ['required', 'email', Rule::unique('applicants')->ignore($applicant ? $applicant->id : null)],
            'address' => 'required|string|max:255',
            'dob' => 'required|date|before_or_equal:today|date_format:Y-m-d',
            'gender' => 'required|in:male,female',
            'resume' => 'nullable|mimes:pdf,docx|max:2048',
            'photo' => 'nullable|image|mimes:jpg,png|max:2048',
        ];

        $messages = [
            'dob.before_or_equal' => 'Applicant must be 18 years or older.',
            'resume.mimes' => 'Allowed file formats are PDF and DOCX.',
            'photo.mimes' => 'Allowed file formats are JPG and PNG.',
            'phone.digits' => 'Phone number must be exactly 10 digits.',
        ];

        $request->validate($rules, $messages);
    }

    /**
     * Store the applicant's photo.
     */
    private function storePhoto(Request $request)
    {
        $base64Image = preg_replace('/^data:image\/\w+;base64,/', '', $request->croppedImageData);
        $imageData = base64_decode($base64Image);
        $filename = $request->user()->id . '_' . time() . '.png';
        $filePath = 'public/photos/' . $filename;
        Storage::put($filePath, $imageData);

        return $filePath;
    }

    /**
     * Create a new applicant.
     */
    private function createApplicant(Request $request, $photoPath)
    {
        Applicant::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'resume_path' => $request->file('resume')->storeAs('public/resumes', $request->user()->id . '_' . $request->file('resume')->getClientOriginalName()),
            'photo_path' => $photoPath,
        ]);
    }

    /**
     * Update the applicant's photo.
     */
    private function updatePhoto(Request $request)
    {
        $base64Image = preg_replace('/^data:image\/\w+;base64,/', '', $request->croppedImageData);
        $imageData = base64_decode($base64Image);
        $filename = $request->user()->id . '_' . time() . '.png';
        $filePath = 'public/photos/' . $filename;
        Storage::put($filePath, $imageData);

        return $filePath;
    }

    /**
     * Update an existing applicant.
     */
    private function updateApplicant(Request $request, Applicant $applicant, $photoPath)
    {
        $applicant->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'resume_path' => $request->hasFile('resume') ? $request->file('resume')->storeAs('public/resumes', $request->user()->id . '_' . $request->file('resume')->getClientOriginalName()) : $applicant->resume_path,
            'photo_path' => $photoPath ??  $applicant->photo_path,
        ]);
    }
}
