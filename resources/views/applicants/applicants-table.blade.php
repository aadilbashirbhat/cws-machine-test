<div>
    <a href="{{ route('applicants.create') }}" class="btn btn-success mb-3 text-white">
        <i class="fas fa-plus"></i> {{ __('Add New Applicant') }}
    </a>
    <table class="table border mb-0 table-responsive-sm" id="applicantTable">
        <thead class="table-light fw-semibold">
            <tr class="align-middle">
                <th>#</th>
                <th class="text-center">Applicant</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Resume</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applicants as $applicant)
            <tr class="align-middle">
                <td>{{ $loop->index + 1 }}</td>
                <td class="text-center">
                    <img src="{{ Storage::url($applicant->photo_path) }}" alt="" height="50" width="50" alt="Applicant Photo" class="" style="border-top-left-radius: 50% 50%; border-top-right-radius: 50% 50%; border-bottom-right-radius: 50% 50%; border-bottom-left-radius: 50% 50%;">
                </td>
                <td>{{ $applicant->first_name }}</td>
                <td>{{ $applicant->last_name }}</td>
                <td>{{ $applicant->phone }}</td>
                <td>{{ $applicant->email }}</td>
                <td>
                    @if($applicant->resume_path)
                    <a href="{{ Storage::url($applicant->resume_path) }}" target="_blank" class="btn btn-secondary"><i class="fas fa-download"></i> Download</a>
                    @endif
                </td>
                <td>
                    <div class="btn-group" role="group" aria-label="Actions">
                        <button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#viewModal" data-applicant-details='{{ json_encode($applicant) }}'>
                            <i class="fas fa-eye"></i> View
                        </button>
                        <a href="{{ route('applicants.edit', $applicant->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Modify
                        </a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $applicant->id }})">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No applicants found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @includeIf('applicants.view-modal')
    <form id="deleteForm" action="{{ route('applicants.destroy', 0) }}" method="POST">
        @csrf
        @method('DELETE')
    </form>
</div>
<script>

    function confirmDelete(applicantId) {
        if (confirm("Are you sure you want to delete this applicant?")) {
            // Update the form action with the correct ID
            var form = document.getElementById('deleteForm');
            form.action = '{{ url("applicants") }}/' + applicantId;
            form.submit();
        }
    }

    function showNotification(message, type) {
        new Noty({
            text: message,
            type: type,
            timeout: 3000, // Duration of the notification
            layout: 'topRight' // Notification position
        }).show();
    }

    document.getElementById('viewModal').addEventListener('show.coreui.modal', function(event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var applicantDetails = JSON.parse(button.getAttribute('data-applicant-details')); // Extract JSON data

        setModalContent(applicantDetails); // Set modal content
    });

    function setModalContent(applicantDetails) {
        // Custom column name mapping
        var columnNameMapping = {
            'first_name': 'First Name',
            'last_name': 'Last Name',
            'phone': 'Phone',
            'address': 'Address',
            'email': 'Email',
            'dob': 'DOB',
            'gender': 'Gender',
            // 'resume_path': 'Resume',
            // 'photo_path': 'Photo',
            // 'created_at': 'Created At   ',

            // Add more columns as needed
        };

        // Display all details in the modal body
        var detailsString = '<table class="table">';
        // Columns to exclude
        var excludeColumns = ['updated_at', 'id', 'resume_path', 'photo_path', 'created_at'];

        // Display all details in the modal body
        var detailsString = '<table class="table">';

        for (var key in applicantDetails) {
            if (!excludeColumns.includes(key)) {
                var customColumnName = columnNameMapping[key] || key; // Use custom column name if available
                var columnValue = applicantDetails[key] !== null && applicantDetails[key] !== '' ? applicantDetails[key] : '-';
                detailsString += '<tr><td>' + customColumnName + '</td><td>' + columnValue + '</td></tr>';
            }
        }

        detailsString += '</table>';

        document.getElementById('modalDetails').innerHTML = detailsString;
        // Update more details as needed
    }
</script>