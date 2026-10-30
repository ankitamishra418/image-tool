@extends('frontend.layout.app')

@section('content')
<main class="tools-home">
    <div class="container">
        <div class="text-center mx-auto mb-5">
            <p class="tools-kicker mb-3">Your image workspace</p>
            <h1 class="tools-title mb-4">One place for every <span>image task.</span></h1>
            <p class="tools-copy mx-auto">Choose a focused tool and get exactly the controls you need—without a
                cluttered workspace.</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-sm-6 col-lg-3"><a class="tool-link" href="{{ route('image.compressor') }}"><span
                        class="tool-icon mb-4">↘</span>
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <h2>Compress image</h2>
                            <p>Reduce file size while keeping the quality you need.</p>
                        </div><span class="tool-arrow">→</span>
                    </div>
                </a></div>
            <div class="col-sm-6 col-lg-3"><a class="tool-link" href="{{ route('image.crop') }}"><span
                        class="tool-icon mb-4">⌗</span>
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <h2>Crop image</h2>
                            <p>Cut an image to the exact size and position you want.</p>
                        </div><span class="tool-arrow">→</span>
                    </div>
                </a></div>
            <div class="col-sm-6 col-lg-3"><a class="tool-link" href="{{ route('image.converter') }}"><span
                        class="tool-icon mb-4">⇄</span>
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <h2>Convert format</h2>
                            <p>Switch between JPG, PNG, and WebP in one click.</p>
                        </div><span class="tool-arrow">→</span>
                    </div>
                </a></div>
            <div class="col-sm-6 col-lg-3"><a class="tool-link" href="{{ route('image.background-remover') }}"><span
                        class="tool-icon mb-4">✦</span>
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <h2>Remove background</h2>
                            <p>Make solid-color backgrounds transparent with ease.</p>
                        </div><span class="tool-arrow">→</span>
                    </div>
                </a></div>
        </div>
    </div>
</main>
@endsection
