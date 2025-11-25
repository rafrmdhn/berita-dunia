<!-- Topbar Start -->
<div class="container-fluid d-none d-lg-block">
    <div class="row align-items-center bg-dark px-lg-5">
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-sm bg-dark p-0">
                <ul class="navbar-nav ml-n2">
                    <li class="nav-item border-right border-secondary">
                        <span class="nav-link text-body small">{{ date('l, d F Y') }}</span>
                    </li>
                    {{-- <li class="nav-item border-right border-secondary">
                        <a class="nav-link text-body small" href="#">Advertise</a>
                    </li> --}}
                    {{-- <li class="nav-item border-right border-secondary">
                        <a class="nav-link text-body small" href="{{ route('contact.index') }}">Contact</a>
                    </li> --}}
                </ul>
            </nav>
        </div>
        <div class="col-lg-3 text-right d-none d-md-block">
            <nav class="navbar navbar-expand-sm bg-dark p-0">
                <ul class="navbar-nav ml-auto mr-n2">
                    <li class="nav-item">
                        <a class="nav-link text-body" href="https://www.tiktok.com/@fypmedia.id"><small class="fab fa-tiktok"></small></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-body" href="https://linkedin.com/company/fypgroup/"><small class="fab fa-linkedin-in"></small></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-body" href="https://www.instagram.com/fypmedia.id"><small class="fab fa-instagram"></small></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-body" href="https://www.youtube.com/@fypmediaid"><small class="fab fa-youtube"></small></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="row align-items-center bg-white py-3 px-lg-5">
        <div class="col-lg-4">
            <a href="{{ route('home') }}" class="navbar-brand p-0 d-none d-lg-block">
                <h1 class="m-0 display-4 text-uppercase text-primary">Berita<span class="text-secondary font-weight-bold">Dunia</span></h1>
            </a>
        </div>
        @if(!empty($headerAd))
            <div class="col-lg-8 text-center text-lg-right">
                <a href="{{ $headerAd->link_url }}" target="_blank" rel="noopener"><img class="img-fluid" src="{{ $headerAd->image_path }}" alt="{{ $headerAd->title }}"></a>
            </div>
        @endif
    </div>
</div>
<!-- Topbar End -->
