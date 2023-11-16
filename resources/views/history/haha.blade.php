@extends('layout.usernav')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css')}}">
	<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
            <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Gener Title</title>
</head>
<style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa; /* Light gray background */
            color: #343a40; /* Dark gray text color */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form {
            margin: 20px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #search-input {
            padding: 10px;
            border: 1px solid #007bff; /* Blue border */
            border-radius: 4px;
            margin-right: 5px;
            width: 400px; /* Adjusted width */
            outline: none;
        }

        button {
            padding: 10px 15px;
            background-color: #007bff; /* Blue background */
            color: #fff; /* White text color */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            outline: none;
        }

        button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        #nexus-container {
            margin: 20px 0;
            padding: 20px;
            width: 70%; /* Adjusted width */
            height: 800px; /* Adjusted height */
            border: 1px solid #d1d1d1; /* Light gray border */
            background-color: #fff; /* White background */
            position: relative; /* Added position relative */
        }

        .map-container {
            width: 100%;
            height: 100%;
        }

        .buttons-container {
            position: absolute;
            top: 10px; /* Adjusted top position */
            right: 10px; /* Adjusted right position */
            display: flex;
            flex-direction: column;
        }

        .buttons-container button {
            margin-bottom: 10px; /* Adjusted margin between buttons */
        }

        .recommendations-container {
            margin: 20px 0;
            padding: 20px;
            background-color: #fff; /* White background */
            border: 1px solid #d1d1d1; /* Light gray border */
            display: none;
        }

        button#send-button {
            width: 28%; /* Adjusted width */
            height: 40px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }

    </style>
<body>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
<div class="card">
    <div class="card-header"><strong>Gener Nexus</strong></div>
<form id="search-form" method="GET" action="{{ route('getRecommendations') }}">                   
        @csrf
        <input type="text" name="query" id="search-input" placeholder="Search by title or keyword">
        <button type="button" name="query" onclick="searchResources()">Search</button>
    </form>

    <div id="nexus-container" style="width: 95%; height: 80vh; border: 1px solid black; margin: 0 auto;">
     <button onclick="zoomIn()">Zoom In</button>
    <button onclick="zoomOut()">Zoom Out</button>
    <button onclick="toggleInteraction()">Toggle Interaction</button>
        <div id="nexus"></div>
    </div>
    <!-- Recommendations container -->
<div class="recommendations-container" id="recommendations-container">
        <!-- Relevant resource URLs will appear here -->
    </div>
</div>
</div>
</div>
</div>
</div>

<!-- Recommendations container -->
<div class="recommendations-container" id="recommendations-container">
        <!-- Relevant resource URLs will appear here -->
    </div>

<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        const recommendationsContainer = $("#recommendations-container");
        const loadingSpinner = $("#loading-spinner");

        // Function to fetch and display recommendations
        function fetchRecommendations(query) {
            // Display loading spinner while fetching recommendations
            loadingSpinner.css("display", "inline-block");

            // Fetch recommendations based on the user's query using jQuery
            $.ajax({
                url: /get-recommendations?query=${encodeURIComponent(query)},
                method: "GET",
                success: function (html) {
                    // Hide loading spinner
                    loadingSpinner.css("display", "none");

                    // Update the recommendations container with the fetched HTML
                    recommendationsContainer.html(html);

                    // Display the recommendations container
                    recommendationsContainer.css("display", "block");
                },
                error: function (error) {
                    console.error("Error fetching recommendations:", error);
                },
            });
        }

        // Function to search resources
        function searchResources() {
            const query = $("#search-input").val();
            fetchRecommendations(query);
        }

        // Submit event for the form
        $("form").on("submit", function (e) {
            e.preventDefault(); // Prevent the default form submission
            searchResources(); // Call the function to search resources
        });

        // Click event for the search button
        $("button[name='query']").on("click", function () {
            searchResources(); // Call the function to search resources
        });

        // Key press event for the text box
        $("#search-input").on("keypress", function (e) {
            if (e.which === 13) {
                // If the Enter key is pressed
                e.preventDefault(); // Prevent the default behavior (form submission)
                searchResources(); // Call the function to search resources
            }
        });

        // Initial fetch and display without a query (empty search)
        // Note: The container will remain hidden until a search is made
        fetchRecommendations('');
    });
</script>

<script src="https://d3js.org/d3.v5.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    var resources = {!! $resources->toJson() !!};

    // Define width and height
    var width = 800;
    var height = 320;

    // Define aspect ratio
    var aspect = width / height;

    // Convert your resources into a format suitable for D3.js
    var nodes = resources.map(function(resource, index) {
        return { id: index, title: resource.title };
    });

    // Define how to create links based on common keywords
    var links = [];
    for (var i = 0; i < nodes.length; i++) {
        for (var j = i + 1; j < nodes.length; j++) {
            // Modify this condition based on your criteria for linking nodes
            if (shouldLinkNodes(resources[i], resources[j])) {
                links.push({ source: i, target: j });
            }
        }
    }

    function shouldLinkNodes(resource1, resource2) {
        return true; 
    }

    // Create SVG element and set its viewbox
    var svg = d3.select("#nexus-container").append("svg")
    .attr("viewBox", "0 0 " + width + " " + height)
    .attr("preserveAspectRatio", "xMinYMid meet")
    .call(d3.zoom().on("zoom", function () {
        svg.attr("transform", d3.event.transform);
     }))
        .append("g");

    // An event listener to the window to update the SVG's width and height when the window is resized
    d3.select(window).on("resize", function() {
        var targetWidth = svg.node().getBoundingClientRect().width;
        var targetHeight = svg.node().getBoundingClientRect().height;
        svg.attr("width", targetWidth);
        svg.attr("height", targetHeight);
    });

        svg.append("defs").selectAll("marker")
        .data(["end"])
        .enter().append("marker")
        .attr("id", String)
        .attr("viewBox", "0 -5 10 10")
        .attr("refX", 20) // Increase the position to make it more visible
        .attr("refY", 0) // Center the arrow
        .attr("markerWidth", 6)
        .attr("markerHeight", 6)
        .attr("orient", "auto")
        .append("path")
        .attr("d", "M0,-5L10,0L0,5")
        .attr("fill", "#000");

    var simulation = d3.forceSimulation(nodes)
        .force("link", d3.forceLink(links).id(function(d) { return d.id; }).distance(100)) // Increase distance between nodes
        .force("charge", d3.forceManyBody())
        .force("center", d3.forceCenter(width / 2, height / 2));

    var link = svg.append("g")
        .selectAll("line")
        .data(links)
        .enter().append("line")
        .attr("stroke", "#000") // Set the color of the line
        .attr("stroke-width", 1.5); // Set the width of the line

    var node = svg.append("g")
        .selectAll("circle")
        .data(nodes)
        .enter().append("circle")
        .attr("r", 5)
        .attr("fill", "steelblue")
        .call(d3.drag()
            .on("start", dragstarted)
            .on("drag", dragged)
            .on("end", dragended))
        .on("click", nodeClick);

    var labels = svg.append("g")
        .selectAll("text")
        .data(nodes)
        .enter().append("text")
        .text(function(d) { return d.title; });

    var interactionEnabled = true;

    var zoom = d3.zoom().on("zoom", function () {
        svg.attr("transform", d3.event.transform);
    });

    svg.call(zoom);

    simulation.on("tick", function() {
        link
            .attr("x1", function(d) { return d.source.x; })
            .attr("y1", function(d) { return d.source.y; })
            .attr("x2", function(d) { return d.target.x; })
            .attr("y2", function(d) { return d.target.y; });

        node
            .attr("cx", function(d) { return d.x; })
            .attr("cy", function(d) { return d.y; });

        labels
            .attr("x", function(d) { return d.x; })
            .attr("y", function(d) { return d.y; });
    });

    // Function to handle drag events
    function dragstarted(event, d) {
        if (!interactionEnabled) return;
        if (!event.active) simulation.alphaTarget(0.3).restart();
        d.fx = d.x;
        d.fy = d.y;
    }

    function dragged(event, d) {
        if (!interactionEnabled) return;
        d.fx = event.x;
        d.fy = event.y;

        // Move the associated arrow (link) as well
        link.filter(function (l) { return l.source === d; })
            .attr("x1", d.x)
            .attr("y1", d.y);

        link.filter(function (l) { return l.target === d; })
            .attr("x2", d.x)
            .attr("y2", d.y);
    }

    function dragended(event, d) {
        if (!interactionEnabled) return;
        if (!event.active) simulation.alphaTarget(0);
        d.fx = null;
        d.fy = null;
    }

    // Function to handle node click event
    function nodeClick(event, d) {
        // Handle node click event (you can customize this part)
        console.log('Node clicked:', d);
    }

    // Function to zoom in
    function zoomIn() {
        svg.transition().duration(500).call(
            zoom.scaleBy, 1.2
        );
    }

    // Function to zoom out
    function zoomOut() {
        svg.transition().duration(500).call(
            zoom.scaleBy, 0.8
        );
    }

    // Function to perform semantic search
    function searchResources() {
        var searchTerm = document.getElementById('search-input').value;

        // Ensure searchTerm is defined before performing the search
        if (searchTerm) {
            axios.post('/nexus', { keywords: searchTerm })
                .then(response => {
                    console.log(response.data); // Log the response data
                    var searchResults = response.data;
                    visualizeGraph(searchResults);
                })
                .catch(error => {
                    console.error('Error performing semantic search:', error);
                    alert('An error occurred while performing the search.');
                });
        } else {
            console.warn('Search term is empty');
        }
    }
    // Function to visualize the graph based on search results
    function visualizeGraph(searchResults) {
        // Clear existing graph visualization
        clearGraph();

        // Extract the titles of the resources from the search results
        var searchTitles = searchResults.map(resource => resource.title);

        // Filter nodes based on whether they are in the search results
        var filteredNodes = nodes.filter(node => searchTitles.includes(node.title));

        // Create links based on the filtered nodes
        var filteredLinks = [];
        for (var i = 0; i < filteredNodes.length; i++) {
            for (var j = i + 1; j < filteredNodes.length; j++) {
                if (shouldLinkNodes(filteredNodes[i], filteredNodes[j])) {
                    filteredLinks.push({ source: i, target: j });
                }
            }
        }

        // Add new links
        var links = svg.selectAll("line")
            .data(filteredLinks)
            .enter().append("line")
            .attr("stroke", "#000")
            .attr("stroke-width", 1.5);

        // Add new nodes
        var newNodes = svg.selectAll("circle")
            .data(filteredNodes)
            .enter().append("circle")
            .attr("r", 5)
            .attr("fill", "steelblue")
            .call(d3.drag()
                .on("start", dragstarted)
                .on("drag", dragged)
                .on("end", dragended))
            .on("click", nodeClick);

        // Add new labels
        var labels = svg.selectAll("text")
            .data(filteredNodes)
            .enter().append("text")
            .text(function (d) { return d.title; });

        // Update the simulation with the filtered nodes and links
        simulation.nodes(filteredNodes).force("link").links(filteredLinks);

        // Restart the simulation
        simulation.alpha(1).restart();

        // Update simulation tick function
        simulation.on("tick", function () {
            links
                .attr("x1", function (d) { return d.source.x; })
                .attr("y1", function (d) { return d.source.y; })
                .attr("x2", function (d) { return d.target.x; })
                .attr("y2", function (d) { return d.target.y; });

            newNodes
                .attr("cx", function (d) { return d.x; })
                .attr("cy", function (d) { return d.y; });

            labels
                .attr("x", function (d) { return d.x; })
                .attr("y", function (d) { return d.y; });
        });

        // Add new links
        svg.selectAll("line")
            .data(filteredLinks)
            .enter().append("line")
            .attr("stroke", "#000")
            .attr("stroke-width", 1.5)
            .attr("marker-end", "url(#end)");

        // Add new nodes
        svg.selectAll("circle")
            .data(filteredNodes)
            .enter().append("circle")
            .attr("r", 5)
            .attr("fill", "steelblue")
            .call(d3.drag()
                .on("start", dragstarted)
                .on("drag", dragged)
                .on("end", dragended))
            .on("click", nodeClick);

        // Add new labels
        svg.selectAll("text")
            .data(filteredNodes)
            .enter().append("text")
            .text(function (d) { return d.title; });

        // Update the simulation with the filtered nodes
        simulation.nodes(filteredNodes).force("link").links(filteredLinks);

        // Restart the simulation
        simulation.alpha(1).restart();
    }

    // Function to clear the existing graph visualization
    function clearGraph() {
        // Clear the existing nodes, links, and labels
        svg.selectAll("circle, line, text").remove();
    }
</script>
</body>
</html>