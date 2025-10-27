<div class="col-lg-4">
    <!-- Social Follow Start -->
    <div class="mb-3">
        <div class="section-title mb-0">
            <h4 class="m-0 text-uppercase font-weight-bold">Follow Us</h4>
        </div>
        <div class="bg-white border border-top-0 p-3">
            <a href="https://linkedin.com/company/fypgroup/" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #0185AE;">
                <i class="fab fa-linkedin-in text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                <span class="font-weight-medium">Linkedin</span>
            </a>
            <a href="https://www.instagram.com/fypmedia.id" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #C8359D;">
                <i class="fab fa-instagram text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                <span class="font-weight-medium">Instagram</span>
            </a>
            <a href="https://www.youtube.com/@fypmediaid" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #DC472E;">
                <i class="fab fa-youtube text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                <span class="font-weight-medium">Youtube</span>
            </a>
            <a href="https://www.tiktok.com/@fypmedia.id" class="d-block w-100 text-white text-decoration-none" style="background: #474747;">
                <i class="fab fa-tiktok text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                <span class="font-weight-medium">Tiktok</span>
            </a>
        </div>
    </div>
    <!-- Social Follow End -->

    <!-- Ads Start -->
    <div class="mb-3">
        <div class="section-title mb-0">
            <h4 class="m-0 text-uppercase font-weight-bold">Advertisement</h4>
        </div>
        <div class="bg-white text-center border border-top-0 p-3">
            <a href=""><img class="img-fluid" src="img/news-800x500-2.jpg" alt=""></a>
        </div>
    </div>
    <!-- Ads End -->

    <!-- Popular News Start -->
    <div class="mb-3">
        <div class="section-title mb-0">
            <h4 class="m-0 text-uppercase font-weight-bold">Tranding News</h4>
        </div>
        <div class="bg-white border border-top-0 p-3">
            @foreach ($trending as $item)
                <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                    <img class="img-fluid" src="{{ $item->sumber_gambar }}" style="object-fit: cover; object-position: center; display: block; width: 110px; height: 110px;" alt="">
                    <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                        <div class="mb-2">
                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="">{{ $item->category->name }}</a>
                            <a class="text-body" href=""><small>Jan 01, 2045</small></a>
                        </div>
                        <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="">{{ Str::limit($item->judul, 20) }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Popular News End -->

    <!-- Tags Start -->
    <div class="mb-3">
        <div class="section-title mb-0">
            <h4 class="m-0 text-uppercase font-weight-bold">Tags</h4>
        </div>
        <div class="bg-white border border-top-0 p-3">
            <div class="d-flex flex-wrap m-n1">
                @foreach ($tags as $item)
                    <a href="{{ route('tags.show', $item->slug) }}" class="btn btn-sm btn-outline-secondary m-1">{{ $item->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Tags End -->
</div>
