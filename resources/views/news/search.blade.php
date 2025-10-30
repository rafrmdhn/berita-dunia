@extends('layouts.main')

@section('container')
    <div class="container-fluid py-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-3">
                        @if($q || $cat || $days)
                            <small class="text-muted">
                                Menampilkan {{ $articles->total() }} hasil
                                @if($q) untuk "<strong>{{ $q }}</strong>" @endif
                                @if($days) dalam <strong>{{ $days }} hari</strong> terakhir @endif
                                (urut: {{ $sort==='popular'?'Terpopuler':'Terbaru' }})
                            </small>
                        @else
                            <small class="text-muted">Menampilkan {{ $articles->total() }} hasil</small>
                        @endif
                    </div>

                    <style>
                        .news-card{
                            display:flex; gap:12px; background:#fff;
                            overflow:hidden; border:1px solid #eee;
                        }
                        .news-card .news-thumb{
                            width:160px; flex:0 0 160px; position:relative; overflow:hidden;
                        }
                        .news-card .news-thumb img{
                            width:100%; height:100%; object-fit:cover; display:block;
                            transition: transform .3s ease;
                        }
                        .news-card:hover .news-thumb img{ transform: scale(1.04); }
                        .news-card .overlay{
                            flex:1; padding:12px 14px;
                            display:flex; flex-direction:column; justify-content:center;
                        }
                        @media (max-width: 576px){
                        .news-card{ flex-direction:column; }
                        .news-card .news-thumb{ width:100%; flex:0 0 auto; height:190px; }
                        }
                    </style>

                    @if($articles->count())
                        <div class="row row-cols-1 g-4">
                            @foreach($articles as $article)
                                <div class="col">
                                    <article class="news-card mb-2">
                                        <div class="news-thumb">
                                            <img src="{{ $article->gambar }}" alt="{{ $article->judul }}" loading="lazy">
                                        </div>

                                        <div class="position-relative bg-light">
                                            <div class="mb-2" style="font-size:14px;">
                                                <a href="{{ route('category.index', ['cat' => $article->category->slug]) }}">
                                                {{ $article->category->name }}
                                                </a>
                                                <span class="px-1">/</span>
                                                <span>{{ \Carbon\Carbon::parse($article->tanggal_posting)->diffForHumans() }}</span>
                                            </div>

                                            <a class="h5 mb-1 d-block" href="{{ route('articles.show', ['slug' => $article->slug]) }}">
                                                {{ \Illuminate\Support\Str::limit($article->judul, 80) }}
                                            </a>
                                            <p class="m-0">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($article->deskripsi), 140) }}
                                            </p>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
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
                    @else
                        <div class="bg-light p-4 rounded border">
                            <h5 class="mb-1">Tidak ada hasil</h5>
                        </div>
                    @endif
                </div>
                @include('partials.side')
            </div>
        </div>
    </div>
@endsection
