@extends('layouts.main')

@section('container')
<!-- News With Sidebar Start -->
    <div class="container-fluid mt-5 pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h4 class="m-0 text-uppercase font-weight-bold">Category: {{ $activeCategory->name ?? 'All' }}</h4>
                            </div>
                            @php $visibleCount = 8; @endphp
                            <style>
                                .chipbar{display:flex;gap:8px;overflow-x:auto;white-space:nowrap;padding:8px 0;margin-bottom:14px;}
                            </style>

                            <div class="chipbar" id="chipbar">
                                <a href="{{ route('category.index') }}"
                                class="btn btn-sm m-1 {{ empty($activeSlug) ? 'btn-secondary' : 'btn-outline-secondary' }}">All</a>

                                @foreach($categories as $i => $cat)
                                    <a href="{{ route('category.index', ['cat' => $cat->slug]) }}"
                                        class="btn btn-sm m-1 {{ $activeSlug === $cat->slug ? 'btn-secondary' : 'btn-outline-secondary' }} {{ $i >= $visibleCount ? 'btn-hidden' : '' }}">
                                        {{ $cat->name }}
                                    </a>
                                @endforeach

                                @if($categories->count() > $visibleCount)
                                    <button type="button"
                                    class="btn btn-sm btn-outline-secondary m-1"
                                    id="catToggle">Lainnya</button>
                                @endif
                            </div>

                            <script>
                                (function(){
                                const bar=document.getElementById('chipbar');
                                const btn=document.getElementById('chipToggle');
                                if(!bar||!btn) return;
                                let expanded=false;
                                btn.addEventListener('click',function(){
                                    expanded=!expanded;
                                    bar.classList.toggle('is-expanded',expanded);
                                    btn.textContent=expanded?'Lebih sedikit':'Lainnya';
                                });
                                })();
                            </script>
                        </div>
                        @foreach ($articles->take(2) as $item)
                            <div class="col-lg-6">
                                <div class="position-relative mb-3">
                                    <img class="img-fluid w-100" src="{{ $item->gambar }}" style="object-fit: cover;">
                                    <div class="bg-white border border-top-0 p-4">
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                                href="{{ route('category.index', ['cat' => $item->category->slug]) }}">{{ $item->category->name }}</a>
                                            <span class="text-body"><small>{{ \Carbon\Carbon::parse($item->tanggal_posting)->diffForHumans() }}</small></span>
                                        </div>
                                        <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="{{ route('articles.show', $item->slug) }}">{{ Str::limit($item->judul, 30) }}</a>
                                        <p class="m-0">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <small>{{ $item->nama_penulis }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-lg-12 mb-3">
                            <a href=""><img class="img-fluid w-100" src="img/ads-728x90.png" alt=""></a>
                        </div>
                        @foreach ($articles->skip(2)->take(2) as $item)
                            <div class="col-lg-6">
                                <div class="position-relative mb-3">
                                    <img class="img-fluid w-100" src="{{ $item->gambar }}" style="object-fit: cover;">
                                    <div class="bg-white border border-top-0 p-4">
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                                href="{{ route('category.index', ['cat' => $item->category->slug]) }}">{{ $item->category->name }}</a>
                                            <span class="text-body"><small>{{ \Carbon\Carbon::parse($item->tanggal_posting)->diffForHumans() }}</small></span>
                                        </div>
                                        <a class="h4 d-block mb-0 text-secondary text-uppercase font-weight-bold" href="{{ route('articles.show', $item->slug) }}">{{ Str::limit($item->judul, 30) }}</a>
                                    </div>
                                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <small>{{ $item->nama_penulis }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-lg-6">
                            @foreach ($articles->skip(4)->take(2) as $item)
                                <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                    <img class="img-fluid" src="{{ $item->gambar }}" style="width:100px;height:100px;object-fit:cover;" alt="">
                                    <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="{{ route('category.index', ['cat' => $item->category->slug]) }}">{{ $item->category->name }}</a>
                                            <span class="text-body"><small>{{ \Carbon\Carbon::parse($item->tanggal_posting)->diffForHumans() }}</small></span>
                                        </div>
                                        <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="{{ route('articles.show', $item->slug) }}">{{ Str::limit($item->judul, 20) }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-lg-6">
                            @foreach ($articles->skip(6)->take(2) as $item)
                                <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                    <img class="img-fluid" src="{{ $item->gambar }}" style="width:100px;height:100px;object-fit:cover;" alt="">
                                    <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="{{ route('category.index', ['cat' => $item->category->slug]) }}">{{ $item->category->name }}</a>
                                            <span class="text-body"><small>{{ \Carbon\Carbon::parse($item->tanggal_posting)->diffForHumans() }}</small></span>
                                        </div>
                                        <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="{{ route('articles.show', $item->slug) }}">{{ Str::limit($item->judul, 20) }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-lg-12 mb-3">
                            <a href=""><img class="img-fluid w-100" src="img/ads-728x90.png" alt=""></a>
                        </div>
                        <div class="col-lg-12">
                            @foreach ($articles->skip(8)->take(1) as $item)
                                <div class="row news-lg mx-0 mb-3">
                                    <div class="col-md-6 h-100 px-0">
                                        <img class="img-fluid h-100" src="{{ $item->gambar }}" style="object-fit: cover;">
                                    </div>
                                    <div class="col-md-6 d-flex flex-column border bg-white h-100 px-0">
                                        <div class="mt-auto p-4">
                                            <div class="mb-2">
                                                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                                    href="{{ route('category.index', ['cat' => $item->category->slug]) }}">{{ $item->category->name }}</a>
                                                <span class="text-body"><small>{{ \Carbon\Carbon::parse($item->tanggal_posting)->diffForHumans() }}</small></span>
                                            </div>
                                            <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="{{ route('articles.show', $item->slug) }}">{{ Str::limit($item->judul, 30) }}</a>
                                            <p class="m-0">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between bg-white border-top mt-auto p-4">
                                            <div class="d-flex align-items-center">
                                                <small>{{ $item->nama_penulis }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-lg-6">
                            @foreach ($articles->skip(9)->take(2) as $item)
                                <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                    <img class="img-fluid" src="{{ $item->gambar }}" style="width:100px;height:100px;object-fit:cover;" alt="">
                                    <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="{{ route('category.index', ['cat' => $item->category->slug]) }}">{{ $item->category->name }}</a>
                                            <span class="text-body"><small>{{ \Carbon\Carbon::parse($item->tanggal_posting)->diffForHumans() }}</small></span>
                                        </div>
                                        <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="{{ route('articles.show', $item->slug) }}">{{ Str::limit($item->judul, 20) }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-lg-6">
                            @foreach ($articles->skip(11)->take(2) as $item)
                                <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                    <img class="img-fluid" src="{{ $item->gambar }}" style="width:100px;height:100px;object-fit:cover;" alt="">
                                    <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="{{ route('category.index', ['cat' => $item->category->slug]) }}">{{ $item->category->name }}</a>
                                            <span class="text-body"><small>{{ \Carbon\Carbon::parse($item->tanggal_posting)->diffForHumans() }}</small></span>
                                        </div>
                                        <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="{{ route('articles.show', $item->slug) }}">{{ Str::limit($item->judul, 20) }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 justify-content-center">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    {{ $articles->onEachSide(0)->links('pagination::bootstrap-4') }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                @include('partials.side')
            </div>
        </div>
    </div>
    <!-- News With Sidebar End -->
@endsection
