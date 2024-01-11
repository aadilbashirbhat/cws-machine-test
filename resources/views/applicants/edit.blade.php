@extends('layouts.admin_app')

@section('title', 'Edit Applicant')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Applicant') }}</div>

                <div class="card-body">
                    <!-- Display errors above the form -->
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form id="applicantEditForm" action="{{ route('applicants.update', $applicant->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Include the common form fields and update their values -->
                        @include('applicants.form-fields')

                        <button type="submit" class="btn btn-primary">Update Applicant</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('head')
<style>
    label.error {
        color: red;
        font-size: 12px;
    }
</style>
<link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.min.css">
@endpush

@push('bottom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="https://unpkg.com/cropperjs/dist/cropper.min.js"></script>
<script>
    $(document).ready(function() {
        $('#applicantEditForm').validate({
            rules: {
                // Your existing rules here
                first_name: {
                    required: true,
                    validName: true,
                },
                last_name: {
                    required: true,
                    validName: true,
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
                },
                email: {
                    required: true,
                    email: true,
                },
                address: 'required',
                dob: {
                    required: true,
                    date: true,
                    dobValidation: true, // Custom method for age validation
                },
                gender: 'required',
                resume: {
                    extension: 'pdf|docx',
                    filesize: 2048000, // Max size in bytes (2MB)
                },
                photo: {
                    extension: 'jpg|png|jpeg',
                    filesize: 2048000, // Max size in bytes (2MB)
                },
            },
            messages: {
                first_name: {
                    required: 'Please enter first name.',
                    validName: 'First name must only contain letters.',
                },
                last_name: {
                    required: 'Please enter last name.',
                    validName: 'Last name must only contain letters.',
                },
                dob: {
                    dobValidation: 'Applicant must be 18 years or older.',
                },
                resume: {
                    filesize: 'File size must be less than 2MB.',
                    extension: 'Allowed file formats are PDF and DOCX.',
                },
                photo: {
                    extension: 'Please upload a JPG or PNG file.',
                    filesize: 'File size must be less than 2MB.',
                },
                phone: {
                    required: 'Please enter your phone number.',
                    digits: 'Phone number must contain only digits.',
                    minlength: 'Phone number must be exactly 10 digits.',
                    maxlength: 'Phone number must be exactly 10 digits.',
                },
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element); // Display error messages below each input
            }
        });


        // Custom method for age validation
        $.validator.addMethod('dobValidation', function(value, element) {
            var dob = new Date(value);
            var today = new Date();
            var age = today.getFullYear() - dob.getFullYear();

            if (age < 18 || (age === 18 && (today.getMonth() < dob.getMonth() || (today.getMonth() === dob.getMonth() && today.getDate() < dob.getDate())))) {
                return false;
            }

            return true;
        }, 'Applicant must be 18 years or older.');
        // Custom method for validating names without numbers or special characters
        $.validator.addMethod('validName', function(value, element) {
            return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
        }, 'Please enter a valid name without numbers or special characters.');

        $.validator.addMethod('filesize', function(value, element, param) {
            // Check if a file is selected
            if (element.files && element.files[0]) {
                // Calculate file size in bytes
                var fileSize = element.files[0].size;
                return this.optional(element) || (fileSize <= param);
            }
            // No file selected, consider it as valid
            return true;
        }, 'File size must be less than {0} bytes.');


        var cropper;

        // Initialize Cropper.js after selecting a photo
        $('#photo').change(function() {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    // Display the image preview
                    $('#imagePreview').attr('src', e.target.result);

                    // Destroy existing Cropper instance if any
                    if (cropper) {
                        cropper.destroy();
                    }

                    // Initialize Cropper.js on the image
                    cropper = new Cropper(document.getElementById('imagePreview'), {
                        aspectRatio: 1,
                        viewMode: 1,
                        crop: function(event) {
                            // Update the hidden input field with cropped image data
                            $('#croppedImageData').val(cropper.getCroppedCanvas().toDataURL());
                        }
                    });
                };

                reader.readAsDataURL(input.files[0]);
            }
        });
    });
</script>
@endpush


@push('breadcrumb')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
                <span>Dashboard</span>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('applicants.index')}}"><span>Applicants</span></a>
            </li>
            <li class="breadcrumb-item active"><span>Edit Applicant Details</span></li>
        </ol>
    </nav>
</div>
@endpush