@extends('layouts.master')

@section('content')

<div class="main-container mt-5">
    <div class="card">
    <div class="card-header">Show Post

    <a href="{{route('posts.index')}}" class="btn btn-warning">Back</a>

    </div>
        
    <div class="card-body">
    <table class="table table-striped table-bordered">
  <thead>
   
  </thead>

    
  <tbody>
        <tr>
            <td>id</td>
            <td>{{$posts->id}}</td>
        </tr>
        <tr>
            <td>image</td>
            <td><img src="{{asset($posts->image)}}" alt="" width="80px"></td>
        </tr>
        <tr>
            <td>title</td>
            <td>{{$posts->title}}</td>
        </tr>
        <tr>
            <td>Description</td>
            <td>{{$posts->description}}</td>
        </tr>
        <tr>
            <td>Category</td>
            <td>{{$posts->category->name}}</td>
        </tr>
        <tr>
            <td>Publish_Date</td>
            <td>{{date('d-m-Y',strtotime($posts->created_at))}}</td>
        </tr>
  </tbody>
</table>
    </div>
</div>
</div>
@endsection