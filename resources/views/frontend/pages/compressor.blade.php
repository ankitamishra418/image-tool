@extends('frontend.layout.app')

@section('content')
    @include('frontend.pages.partials.tool-page', [
        'tool' => 'compressor',
        'title' => 'Compress image',
        'description' => 'Shrink image files while retaining the quality you choose.',
        'buttonLabel' => 'Compress image',
    ])
@endsection
