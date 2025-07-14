@extends('frontend.layouts.master')

@section('content')

<section class="wsus__dashboard mt_90 xs_mt_70 pb_120 xs_pb_100">
    <div class="container">
        <div class="row">
            @include('frontend.instructor-dashboard.sidebar')

            <div class="col-xl-9 col-md-8 wow fadeInRight">
                <div class="wsus__dashboard_contant">
                    <div class="wsus__dashboard_contant_top">
                        <div class="wsus__dashboard_heading relative">
                            <h2>Catatan Arisan</h2>
                                <a class="common_btn" href="{{ route('instructor.arisan.create') }}">+ Tambahkan Data</a>
                            </div>
                        </div>
                    </div>

                    <div class="wsus__dash_course_table">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <div class="container">
                                          <!-- Pilih Tahun -->
                                          <h4 class="mt-4">Pilih Tahun</h4>
                                          <form action="{{ route('instructor.arisan.showTahun') }}" method="GET" enctype="multipart/form-data">
                                              <select name="tahun_id" class="form-control" required>
                                                  <option value="">-- Pilih Tahun --</option>
                                                  @foreach($tahuns as $tahun)
                                                      <option value="{{ $tahun->id }}">{{ $tahun->tahun }}</option>
                                                  @endforeach
                                              </select>
                                              <button type="submit" class="btn btn-info mt-2">Tampilkan</button>
                                          </form>

                                    </div> <!-- End Container -->
                                </div>
                            </div>
                        </div>
                    </div> <!-- End wsus__dash_course_table -->
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
