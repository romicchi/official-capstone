@include('layout.usernav')

@yield('usernav')

<!DOCTYPE html>
<html>
<head>
	<title>Teacher Manage</title>
</head>
<body>
	<h1>Teacher Manage</h1>
	@if (session('message'))
	    <div>{{ session('message') }}</div>
	@endif
	<h2>Upload an Image</h2>
	<form method="POST" action="{{ route('image.store') }}" enctype="multipart/form-data">
	    @csrf
	    <input type="file" name="image" accept=".jpg,.jpeg,.png" />
	    <button type="submit">Upload</button>
	</form>
	<h2>Delete the Image</h2>
	<form method="POST" action="{{ route('image.destroy', 'defT5uT7SDu9K5RFtIdl') }}">
	    @csrf
	    @method('DELETE')
	    <button type="submit">Delete</button>
	</form>
	@if ($image)
	    <h2>Image</h2>
	    <img src="{{ $image }}" alt="Image" />
	@endif
</body>
</html>
