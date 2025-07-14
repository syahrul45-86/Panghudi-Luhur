@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Anggota</h3>
                    <div class="card-actions">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                            Back
                        </a>
                    </div>
                </div>
                <section class="wsus__sign_in sign_up">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="wsus__sign_form_area">
                                    <h2 class="text-center">Tambahkan anggota</h2>

                                    <ul class="nav nav-pills justify-content-center mb-4" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="student-tab" data-bs-toggle="pill"
                                                data-bs-target="#anggota" type="button" role="tab" aria-selected="true">Anggota</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="instructor-tab" data-bs-toggle="pill"
                                                data-bs-target="#bendahara" type="button" role="tab" aria-selected="false">Bendahara</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <!-- Student Registration Form -->
                                        <div class="tab-pane fade show active" id="anggota" role="tabpanel">
                                            <form action="{{ route('register', ['type' => 'anggota']) }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Confirm Password</label>
                                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100">Tambah</button>
                                            </form>
                                        </div>

                                        <!-- Instructor Registration Form -->
                                        <div class="tab-pane fade" id="bendahara" role="tabpanel">
                                            <form action="{{ route('register', ['type' => 'bendahara']) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Confirm Password</label>
                                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <a class="btn btn-secondary" href="index.html">Back to Home</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
