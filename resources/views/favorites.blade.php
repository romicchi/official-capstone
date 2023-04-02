@extends('dashboard')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fav.css') }}">

    <center>
		<br>
		<h3>Favorites</h3>
		<div class="inputS">
			<input style="border-radius: 20px;" class="form-control" id="myInput" type="text" placeholder="Search..">
		</div>
		<br><br>
		<div class="container">
			<div class="overflow-auto containerfav">
				<br>
				<div class="row">
				  <div class="col-6 col-sm-5">
				    <h6 style="font-weight: bold;">Name</h6>
				  </div>
				  <div class="col-6 col-sm-2 ms-auto">
				    <!-- Empty column to push "Action" text to the right -->
				  </div>
				  <div class="col-6 col-sm-5">
				    <h6 style="font-weight: bold;">Action</h6>
				  </div>
				</div>
				<div class="cards">
					<div class="cards2">
						<div class="row">
							<div class="col-6 col-sm-5 text-start">Intelligent Way to Study</div>
							<div class="col-6 col-sm-2 ms-auto"> <!-- Empty column to push "Open" and "Remove" to the right --> </div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Open</button>
							</div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Remove</button>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="cards">
					<div class="cards2">
						<div class="row">
							<div class="col-6 col-sm-5 text-start">Intelligent Way to Study</div>
							<div class="col-6 col-sm-2 ms-auto"> <!-- Empty column to push "Open" and "Remove" to the right --> </div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Open</button>
							</div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Remove</button>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="cards">
					<div class="cards2">
						<div class="row">
							<div class="col-6 col-sm-5 text-start">Intelligent Way to Study</div>
							<div class="col-6 col-sm-2 ms-auto"> <!-- Empty column to push "Open" and "Remove" to the right --> </div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Open</button>
							</div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Remove</button>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="cards">
					<div class="cards2">
						<div class="row">
							<div class="col-6 col-sm-5 text-start">Intelligent Way to Study</div>
							<div class="col-6 col-sm-2 ms-auto"> <!-- Empty column to push "Open" and "Remove" to the right --> </div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Open</button>
							</div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Remove</button>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="cards">
					<div class="cards2">
						<div class="row">
							<div class="col-6 col-sm-5 text-start">Intelligent Way to Study</div>
							<div class="col-6 col-sm-2 ms-auto"> <!-- Empty column to push "Open" and "Remove" to the right --> </div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Open</button>
							</div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Remove</button>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="cards">
					<div class="cards2">
						<div class="row">
							<div class="col-6 col-sm-5 text-start">Intelligent Way to Study</div>
							<div class="col-6 col-sm-2 ms-auto"> <!-- Empty column to push "Open" and "Remove" to the right --> </div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Open</button>
							</div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Remove</button>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="cards">
					<div class="cards2">
						<div class="row">
							<div class="col-6 col-sm-5 text-start">Intelligent Way to Study</div>
							<div class="col-6 col-sm-2 ms-auto"> <!-- Empty column to push "Open" and "Remove" to the right --> </div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Open</button>
							</div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Remove</button>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="cards">
					<div class="cards2">
						<div class="row">
							<div class="col-6 col-sm-5 text-start">Intelligent Way to Study</div>
							<div class="col-6 col-sm-2 ms-auto"> <!-- Empty column to push "Open" and "Remove" to the right --> </div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Open</button>
							</div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Remove</button>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="cards">
					<div class="cards2">
						<div class="row">
							<div class="col-6 col-sm-5 text-start">Intelligent Way to Study</div>
							<div class="col-6 col-sm-2 ms-auto"> <!-- Empty column to push "Open" and "Remove" to the right --> </div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Open</button>
							</div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Remove</button>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="cards">
					<div class="cards2">
						<div class="row">
							<div class="col-6 col-sm-5 text-start">Intelligent Way to Study</div>
							<div class="col-6 col-sm-2 ms-auto"> <!-- Empty column to push "Open" and "Remove" to the right --> </div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Open</button>
							</div>
							<div class="col-6 col-sm-1">
								<button type="button" class="btn btn-light">Remove</button>
							</div>
						</div>
					</div>
				</div>
				</div>

			</div>
		</div>
	</center>

@show