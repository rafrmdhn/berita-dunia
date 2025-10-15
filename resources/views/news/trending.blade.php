@extends('layouts.main')

@section('container')
    <style>
        .news-card{
            display:grid;
            grid-template-columns: 320px 1fr;
            gap:16px;
            background:#fff;
            border:1px solid #e9ecef;
            overflow:hidden;
        }
        .news-thumb{ block-size:100%; inline-size:100%; }
        .news-thumb img{
            width:100%; height:100%; object-fit:cover; display:block;
        }
        .news-body{ padding:16px; background:#f8f9fa; }
        @media (max-width: 992px){
            .news-card{ grid-template-columns: 1fr; }
            .news-thumb{ height:220px; }
        }
    </style>
    <div class="container-fluid mt-5 pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h4 class="m-0 text-uppercase font-weight-bold">Trending</h4>
                            </div>

                            <div class="row row-cols-1 g-4">
                                @foreach ($articles as $article)
                                    <div class="col">
                                        <article class="news-card mb-4">
                                            <div class="news-thumb">
                                                <img src="{{ $article->sumber_gambar }}" alt="{{ $article->judul }}" loading="lazy">
                                            </div>

                                            <div class="news-body position-relative">
                                                <div class="mb-2">
                                                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="{{ route('category.index', ['cat' => $article->category->slug]) }}">{{ $article->category->name }}</a>
                                                    <span class="text-body"><small>{{ \Carbon\Carbon::parse($article->tanggal_posting)->diffForHumans() }}</small></span>
                                                </div>
                                                <a class="h5 mb-1 d-block text-secondary text-uppercase font-weight-bold" href="{{ route('articles.show', $article->slug) }}">{{ Str::limit($article->judul, 80) }}</a>
                                                <p class="m-0">{{ Str::limit(strip_tags($article->deskripsi), 140) }}</p>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>

                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    {{ $articles->onEachSide(0)->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('partials.side')
            </div>
        </div>
    </div>
@endsection
