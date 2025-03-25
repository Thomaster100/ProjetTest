<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des Posts</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="my-4">
        @include('lang.switcher')
    </div>
   
    <div class="container 
                d-flex 
                flex-column 
                justify-content-center 
                align-items-center">
        <p class="h1 text-center my-3">{{__('app.posts.postlist')}}</p>

 <!-- searchBar -->
 <div class="container my-4">
    <div class="row">
        <div class="col-12">
            <input 
            type="text" 
            id="search-bar" 
            class="form-control" 
            placeholder={{__('app.posts.placeholder-search')}}>
        </div>
    </div>
 </div>

 <div class="my-3">
    <a href="{{ route('createPost') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> {{ __('app.general.create') . ' ' .  __('app.posts.a-post')   }}
    </a>    
 </div>

    @include('posts.partials.results')
    
</div>
  
<div class="container d-flex justify-content-end p-5">
    <div class="row">
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger">{{__('app.general.logout')}}</button>
        </form>
    </div>
</div>

<!-- Import JS de la searchBar -->
@vite(['resources/js/searchBar.js'])

</body>
</html>
