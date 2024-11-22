@extends('layouts.theme')

@section('content')

    <h1>test</h1>

    <!---@foreach($menus as $menu)
        <div>
            <h2>{{ $menu->name }}</h2>
            <ul>
                @foreach($menu->submenus as $submenu)
                    <li>{{ $submenu->name }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach --> 



 @foreach($menus as $menu)
        <div>
            <h2>{{ $menu->name }}</h2>
            <ul>
                @foreach($menu->submenus as $submenu)
                    <li>{{ $submenu->name }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach
	
	
@endsection
