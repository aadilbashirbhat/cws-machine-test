<div class="row">
    <div class="col-sm-6 col-lg-3">
        <a href="{{route('applicants.index')}}">
            <div class="card mb-4 text-white bg-primary">
                <div class="card-body pb-0 text-center">
                    <h2>
                        {{ \App\Models\Applicant::count() }}
                    </h2>
                    <h3>
                        Applicants
                    </h3>
                    <h3>
                        <i class="fas fa-users"></i>
                    </h3>
                </div>
            </div>
        </a>
    </div>
</div>