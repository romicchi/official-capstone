@extends('layout.usernav')
<!DOCTYPE html>
<html>
    <head>
    </head>
        <style>
            th {
                color: black;
            }
            h4 {
                font-size: 20px;
            }
            p {
                font-size: 16px;
            }
        </style>
    </header>
<main>
<div class="container">
    <h2>Relevant Resources</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Content</th>
                <th>Link</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resources as $resource)
                <tr>
                    <td>
                        <h4>
                            <a href="{{ $resource->url }}" target="_blank">{{ $resource->title }}</a>
                        </h4>
                        <p><strong>Author:</strong> {{ $resource->author }}</p>
                        <p><strong>Topic:</strong> {{ $resource->topic }}</p>
                    </td>
                    <td>{{ $resource->description }}</td>
                    <td>{{ $resource->content }}</td>
                    <td>
                        <a href="{{ $resource->url }}" target="_blank">{{ $resource->url }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
        </main>
</body>
    <footer> 
         <footer>    
     </footer>
    </html>