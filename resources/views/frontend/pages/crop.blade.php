@extends('frontend.layout.app')

@section('content')
    @include('frontend.pages.partials.tool-page', [
        'tool' => 'crop',
        'title' => 'Crop image',
        'description' => 'Set an exact crop size and starting position for your image.',
        'buttonLabel' => 'Crop image',
    ])
@endsection
