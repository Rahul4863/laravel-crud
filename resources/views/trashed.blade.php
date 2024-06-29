@extends('layouts.master')

@section('content')

<div class="main-container mt-5">
    <div class="card">
    <div class="card-header">Trashed Post
    <a href="{{route('posts.create')}}" class="btn btn-success">Create</a>
    <a href="{{route('posts.index')}}" class="btn btn-warning">Back</a>
        </div>
        
    <div class="card-body">
    <table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">title</th>
      <th scope="col">Description</th>
      <th scope="col">Category</th>
      <th scope="col">Publish Date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>

    
  <tbody>
  @foreach ($posts as $post)
        <tr>
            <th scope="row">{{$post->id}}</th>
            <td><img src="{{asset($post->image)}}" alt="" width="80px"></td>
            <td>{{$post->title}}</td>
            <td>{{$post->description}}</td>
            <td>{{$post->category->name}}</td>
            <td>{{date('d-m-Y',strtotime($post->created_at))}}</td>
            <td>
              <div class="d-flex">
              @can('restore',$post)
              <a href="{{route('posts.restore',$post->id)}}" class="btn-sm btn-primary">Restore</a>
              @endcan

              @can('forceDelete',$post)
                <form action="{{route('posts.force_delete',$post->id)}}" method="post">
                @csrf
                @method('DELETE')
                        <button class="btn-sm btn-danger btn">Delete</button>
                </form>
              @endcan  
              </div>
            </td>
        </tr>
    @endforeach
   
    
    
  </tbody>
</table>
    </div>
</div>
</div>
@endsection