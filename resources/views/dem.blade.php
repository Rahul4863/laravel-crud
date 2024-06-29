@extends('layouts.master')

@section('content')
<div class="row">

@foreach ($posts as $post )
    <x-form :post="$post"  />

@endforeach
</div>
@endsection