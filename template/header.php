<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A site about movies and the frustration of coding a website.">
    <meta name="author" content="Philip">
    <title>Movie Night Stats</title>

    <link href="assets/bootstrap-5.3.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="assets/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <script src="https://kit.fontawesome.com/2b50968540.js" crossorigin="anonymous"></script>

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="images/favicon_32.png" sizes="180x180">
    <link rel="icon" href="images/favicon_32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="images/favicon_32.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

		<?php if(isset($dataTables) && $dataTables == TRUE):?>
			<link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.2.1/datatables.min.css" rel="stylesheet">
			<script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.2.1/datatables.min.js"></script>
		<?php endif; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">
    <link href="assets/mns-style.css" rel="stylesheet">
  </head>
