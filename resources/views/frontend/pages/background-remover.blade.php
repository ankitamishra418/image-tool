@extends('frontend.layout.app')

@section('content')
    @include('frontend.pages.partials.tool-page', [
        'tool' => 'background',
        'title' => 'Remove background',
        'description' => 'Turn a simple, solid-color background transparent in one step.',
        'buttonLabel' => 'Remove background',
    ])
@endsection
