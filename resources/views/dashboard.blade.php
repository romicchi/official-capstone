@include('layout.usernav')
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css')}}">
		<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
      </head>
    <body>
  <!-- Nav Bar -->
  @yield('usernav')
  <!-- Content -->
  <header>
		<div class="dashboard">
    <h2>Welcome to the User Dashboard, <strong>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</strong></h2>
			<p>Here you can manage your account, view statistics, history, and more.</p>
		</div>
	</header>
	<main>
    
    <section class="personal-info">
        <h2>Personal Information</h2>
        <p>Name: {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</p>
        <p>Email: {{ Auth::user()->email }}</p>
    </section>
		
    <section class="chart">
        <h2>User Statistics</h2>
        <canvas id="myChart"></canvas>
    </section>
	
</section>



</main>
<footer>
	<p>Copyright &copy; 2023 {{config('app.name')}}. All rights reserved.</p>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
// Initialize Pusher
var pusher = new Pusher('{{env("PUSHER_APP_KEY")}}', {
    cluster: '{{env("PUSHER_APP_CLUSTER")}}',
    encrypted: true
});

// Subscribe to the channel that broadcasts updates to the user count
var channel = pusher.subscribe('user-count');

// Listen for updates to the user count
channel.bind('update', function(data) {
    // Update the data for the chart
    myChart.data.datasets[0].data = data;
    
    // Update the chart
    myChart.update();
});

// Initialize the chart with the initial data
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Teachers', 'Students'],
        datasets: [{
            label: 'Number of users',
            data: [{{$teachersCount}}, {{$studentsCount}}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 1
        }]
    },
});
</script>
    </body>
</html>
