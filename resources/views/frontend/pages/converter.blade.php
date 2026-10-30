@extends('frontend.layout.app')

@section('content')
    @include('frontend.pages.partials.tool-page', [
        'tool' => 'converter',
        'title' => 'Convert image format',
        'description' => 'Convert your JPG, PNG, or WebP image to the format you need.',
        'buttonLabel' => 'Convert image',
    ])
@endsection
