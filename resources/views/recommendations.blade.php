@extends('layout.usernav')
<!DOCTYPE html>
<html>
    <head>
    </head>
    <header>
    </header>
    <main>
<div class="container">
    <h2>Relevant Resources</h2>
    <ul class="recommendations-list">
        @foreach ($resources as $resource)
            <li><a href="{{ $resource->url }}" target="_blank">{{ $resource->url }}</a></li>
        @endforeach
    </ul>
    {{ $resources->links() }}
</div>
</main>
         </body>
         <footer> 
         <footer>    
     	<p>Copyright &copy; 2023 {{config('app.name')}}. All rights reserved.</p>
     </footer>
     </html>