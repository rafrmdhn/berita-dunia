@extends('layouts.main')

@section('container')
    <!-- Breaking News Start -->
    <div class="container-fluid mt-5 mb-3 pt-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <div class="section-title border-right-0 mb-0" style="width: 180px;">
                            <h4 class="m-0 text-uppercase font-weight-bold">Trending</h4>
                        </div>
                        <div class="owl-carousel tranding-carousel position-relative d-inline-flex align-items-center bg-white border border-left-0"
                            style="width: calc(100% - 180px); padding-right: 100px;">
                            @foreach ($trending as $item)
                                <div class="text-truncate"><a class="text-secondary text-uppercase font-weight-semi-bold" href="{{ route('articles.show',['slug' => $item->slug]) }}">{{  Str::limit($item->judul, 80) }}</a></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breaking News End -->


    <!-- News With Sidebar Start -->
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- News Detail Start -->
                    <div class="position-relative mb-3">
                        <img class="img-fluid w-100" src="{{ $article->gambar }}" style="object-fit: cover;">
                        @if (!empty($article->image_source))
                            <span class="text-muted ml-2" style="font-size: 0.8rem;">
                                Sumber gambar: {{ $article->image_source }}
                            </span>
                        @endif
                        <div class="bg-white border border-top-0 p-4">
                            <div class="mb-3">
                                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                    href="{{ route('category.index', ['cat' => $article->category->slug]) }}">{{ $article->category->name }}</a>
                                <span class="text-body">{{ \Carbon\Carbon::parse($article->tanggal_posting)->translatedFormat('l, d F Y ') }}</span>
                            </div>
                            <h1 class="mb-3 text-secondary text-uppercase font-weight-bold">{{ $article->judul }}</h1>
                            <p class="text-justify">{!! $article->deskripsi !!}</p>
                        </div>
                        <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                            <div class="d-flex align-items-center">
                                <span>{{ $article->nama_penulis }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="ml-3"><i class="far fa-comment mr-2"></i>{{ $article->comments()->count() }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- News Detail End -->

                    <!-- Comment List Start -->
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">{{ $article->comments()->count() }} Comments</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-4">
                            @foreach ($article->comments->where('parent_id', null) as $comment)
                                <div class="media mb-4">
                                    <img src="{{ $comment->avatar }}" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                    <div class="media-body">
                                        <h6 class="text-secondary font-weight-bold">{{ $comment->name }}<small><i>{{ $comment->created_at->diffForHumans() }}</small></i></h6>
                                        <p>{{ $comment->message }}</p>
                                        <button class="btn btn-sm btn-outline-secondary"
                                                onclick="document.getElementById('reply-form-{{ $comment->id }}').style.display='block'">
                                            Reply
                                        </button>

                                        <div id="reply-form-{{ $comment->id }}" style="display:none; margin-top:15px;">
                                            <form action="{{ route('comments.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="article_id" value="{{ $article->id }}">
                                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="name" placeholder="Name *" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="email" class="form-control" name="email" placeholder="Email *" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="Website" class="form-control" name="Website" placeholder="Website">
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" name="message" rows="3" placeholder="Reply..." required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-sm">Submit Reply</button>
                                            </form>
                                        </div>

                                        @foreach($comment->replies as $reply)
                                            <div class="media mt-4">
                                                <img src="{{ $reply->avatar }}" alt="Avatar" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                                <div class="media-body">
                                                    <h6>{{ $reply->name }} <small><i>{{ $reply->created_at->diffForHumans() }}</i></small></h6>
                                                    <p>{{ $reply->message }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Comment List End -->

                    <!-- Comment Form Start -->
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Leave a comment</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-4">
                            <form action="{{ route('comments.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="article_id" value="{{ $article->id }}">
                                <input type="hidden" name="parent_id" id="parent_id" value="">
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Name *</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Email *</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input type="url" class="form-control" id="website" name="website">
                                </div>

                                <div class="form-group">
                                    <label for="message">Message *</label>
                                    <textarea id="message" cols="30" rows="5" class="form-control" name="message" required></textarea>
                                </div>
                                <div class="form-group mb-0">
                                    <input type="submit" value="Leave a comment"
                                        class="btn btn-primary font-weight-semi-bold py-2 px-3">
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Comment Form End -->
                </div>
                @include('partials.side')
            </div>
        </div>
    </div>
    <!-- News With Sidebar End -->
@endsection
