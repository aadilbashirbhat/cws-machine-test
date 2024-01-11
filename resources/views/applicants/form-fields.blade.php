<div class="mb-3">
    <label for="first_name" class="form-label">First Name:</label>
    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $applicant->first_name ?? '') }}">
</div>

<div class="mb-3">
    <label for="last_name" class="form-label">Last Name:</label>
    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $applicant->last_name ?? '') }}">
</div>

<div class="mb-3">
    <label for="phone" class="form-label">Phone:</label>
    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $applicant->phone ?? '') }}">
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email:</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $applicant->email ?? '') }}">
    <span id="email-error" class="text-danger"></span>
</div>

<div class="mb-3">
    <label for="address" class="form-label">Address:</label>
    <textarea class="form-control" id="address" name="address">{{ old('address', $applicant->address ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="dob" class="form-label">Date of Birth:</label>
    <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob', $applicant->dob ?? '') }}">
</div>

<div class="mb-3">
    <label>Gender:</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ old('gender', $applicant->gender ?? '') == 'male' ? 'checked' : '' }}>
        <label class="form-check-label" for="male">Male</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ old('gender', $applicant->gender ?? '') == 'female' ? 'checked' : '' }}>
        <label class="form-check-label" for="female">Female</label>
    </div>
</div>

<div class="mb-3">
    <label for="resume" class="form-label">Resume (PDF, DOCX):</label>
    @isset($applicant)
    @if($applicant->resume_path)
    <p>
        <a href="{{ Storage::url($applicant->resume_path) }}" target="_blank" class="btn btn-secondary"><i class="fas fa-download"></i> Download Resume</a>
    </p>
    @endif
    @endisset
    <input type="file" class="form-control" id="resume" name="resume">
</div>


<div class="mb-3">
    <label for="photo" class="form-label">Applicant's Photo</label>
    <input type="file" class="form-control" id="photo" name="photo">
    <small id="photoHelp" class="form-text text-muted">Format: jpg, png | Max Size: 2MB</small>

    <!-- Hidden input field to store cropped image data -->
    <input type="hidden" id="croppedImageData" name="croppedImageData">
</div>
<div class="mb-3">
    @isset($applicant)
    <img id="imagePreview" class="img-fluid mt-2" style="max-width: 100%" src="{{ Storage::url($applicant->photo_path) }}" alt="" height="250" width="250">
    @else
    <img id="imagePreview" class="img-fluid mt-2" style="max-width: 100%" src="" alt="">
    @endisset
</div>