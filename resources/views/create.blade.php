@extends('layouts.master')

@section('content')

<div class="main-container mt-5">
    @if ($errors->any())
        @foreach ($errors->all() as $error  )
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    @endif  
    <div class="card">
    <div class="card-header">Create Post
    <a href="" class="btn btn-success">Back</a>
    

    </div>
     
    <div class="card-body">
        <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="" class="form-label">Image</label>
            <input type="file" name="image" id="" class="form-control">
        </div>
        <div class="form-group">
            <label for="" class="form-label">Title</label>
            <input type="text" name="title"  class="form-control">
        </div>
        <div class="form-group">
            <label for="" class="form-label">Category</label>
            <select  id="" class="form-control" name="category_id">
                <option value="">select a category</option>
                @foreach ($categories as $category )
                
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
               
            </select>
        </div>   
        <div class="form-group">
            <label for="" class="form-label">Description</label>
            <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
        </div>
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
            

            
        
        </form>
    </div>
</div>
</div>
@endsection