@extends('dashboard')
    
    <link rel="stylesheet" type="text/css" href="{{ asset('css/quantitative.css')}}">

	<h3 class="title-subject">Quantitative Methods and Simulation</h3>

	<div class="dropdown">
	  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Filter
	  </button>
	  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
	    <a class="dropdown-item" href="#">Option 1</a>
	    <a class="dropdown-item" href="#">Option 2</a>
	    <a class="dropdown-item" href="#">Option 3</a>
	  </div>
	</div>
	<div class="dropdown">
	  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Sort
	  </button>
	  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
	    <a class="dropdown-item" href="#">Name</a>
	    <a class="dropdown-item" href="#">Date</a>
	    <a class="dropdown-item" href="#">Recent</a>
	  </div>
	</div>
	<div class="dropdown">
	  <input class="form-control" id="myInput" type="text" placeholder="Search..">
	</div>
<br><br>
	<center>
		<div class="container">
			<div class="courbgcol">
				<br>
				<div class="row">
					<div class="col-6 col-sm-4"><h6 style="font-weight: bold;">Name</h6></div>
					<div class="col-6 col-sm-6"><h6 style="font-weight: bold;">Author</h6></div>
				</div>
				<div class="matcards">
					<div class="matcards2">
						<div class="row">
							<div class="col-6 col-sm-4">Intelligent Way to Study</div>
							<div style="text-align: center;" class="col-6 col-sm-6">Uykieng, Challen</div>
							<div class="col-6 col-sm-1">☆</div>
							<div class="col-6 col-sm-1">
								<div class="dropdown">
	  								<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    ⋮
								  </button>
								  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								    <a class="dropdown-item" href="#">Download</a>
								    <a class="dropdown-item" href="#">View/Add Comment</a>
								  </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="matcards">
					<div class="matcards2">
						<div class="row">
							<div class="col-6 col-sm-4">How to win someone over</div>
							<div style="text-align: center;" class="col-6 col-sm-6">Cinco, Justin Raphael</div>
							<div class="col-6 col-sm-1">☆</div>
							<div class="col-6 col-sm-1">
								<div class="dropdown">
	  								<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    ⋮
								  </button>
								  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								    <a class="dropdown-item" href="#">Download</a>
								    <a class="dropdown-item" href="#">View/Add Comment</a>
								  </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="matcards">
					<div class="matcards2">
						<div class="row">
							<div class="col-6 col-sm-4">Hypothesis</div>
							<div style="text-align: center;" class="col-6 col-sm-6">Cirera, Justine Paul</div>
							<div class="col-6 col-sm-1">☆</div>
							<div class="col-6 col-sm-1">
								<div class="dropdown">
	  								<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    ⋮
								  </button>
								  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								    <a class="dropdown-item" href="#">Download</a>
								    <a class="dropdown-item" href="#">View/Add Comment</a>
								  </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="matcards">
					<div class="matcards2">
						<div class="row">
							<div class="col-6 col-sm-4">Types of Variables</div>
							<div style="text-align: center;" class="col-6 col-sm-6">Alcontin, Zita Lourdes</div>
							<div class="col-6 col-sm-1">☆</div>
							<div class="col-6 col-sm-1">
								<div class="dropdown">
	  								<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    ⋮
								  </button>
								  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								    <a class="dropdown-item" href="#">Download</a>
								    <a class="dropdown-item" href="#">View/Add Comment</a>
								  </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="matcards">
					<div class="matcards2">
						<div class="row">
							<div class="col-sm-5 col-md-6"></div>
							<div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0"></div>
						</div>
					</div>
				</div>
				<br>
				<div class="matcards">
					<div class="matcards2">
						<div class="row">
							<div class="col-sm-5 col-md-6"></div>
							<div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0"></div>
						</div>
					</div>
				</div>
				<br>
				<div class="matcards">
					<div class="matcards2">
						<div class="row">
							<div class="col-sm-5 col-md-6"></div>
							<div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0"></div>
						</div>
					</div>
				</div>
				<br>
				<div class="matcards">
					<div class="matcards2">
						<div class="row">
							<div class="col-sm-5 col-md-6"></div>
							<div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0"></div>
						</div>
					</div>
				</div>
				<br>

			</div>
		</div>
	</center>