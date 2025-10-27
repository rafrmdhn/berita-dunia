@extends('layouts.main')

@section('container')
<!-- Contact Start -->
    <div class="container-fluid mt-5 pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">Contact Us For Any Queries</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-4 mb-3">
                        <div class="mb-4">
                            <h6 class="text-uppercase font-weight-bold">Contact Info</h6>
                            <p class="mb-4">Apakah Anda memiliki pertanyaan tentang talent, harga, portofolio, atau hal lain, tim kami siap menjawab semua pertanyaan Anda.</p>
							<div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-map-marker-alt text-primary mr-2"></i>
                                    <h6 class="font-weight-bold mb-0">Our Office</h6>
                                </div>
                                <p class="m-0">Residence One BSD, Jl. Raya Serpong Kilometer 7, Jelupang, Kec. Serpong Utara,Kota Tangerang Selatan, Banten 15310</p>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-envelope-open text-primary mr-2"></i>
                                    <h6 class="font-weight-bold mb-0">Email Us</h6>
                                </div>
                                <p class="m-0">partnership@fypmedia.id</p>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-phone-alt text-primary mr-2"></i>
                                    <h6 class="font-weight-bold mb-0">Call Us</h6>
                                </div>
                                <p class="m-0">+62 851 7512 3014‬ (Jaya)</p>
                            </div>
                        </div>
                        <h6 class="text-uppercase font-weight-bold mb-3">Contact Us</h6>
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <form action="{{ route('contact.store') }}" method="POST" novalidate>
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control p-4" placeholder="Your Name" value="{{ old('name') }}" required/>
                                        @error('name')
                                            <p class="help-block text-danger mb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control p-4" placeholder="Your Email" value="{{ old('email') }}" required/>
                                        @error('email')
                                            <p class="help-block text-danger mb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="telp" class="form-control p-4" placeholder="Phone Number"
                                                value="{{ old('telp') }}" required>
                                        @error('telp')
                                            <p class="help-block text-danger mb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="subject" class="form-control p-4" placeholder="Subject"
                                                value="{{ old('subject') }}" required>
                                        @error('subject')
                                            <p class="help-block text-danger mb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="message" rows="4" class="form-control" placeholder="Message" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="help-block text-danger mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <button class="btn btn-primary font-weight-semi-bold px-4" style="height: 50px;" type="submit">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @include('partials.side')
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
