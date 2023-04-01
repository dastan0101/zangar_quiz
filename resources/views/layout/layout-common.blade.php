<!DOCTYPE html>
<html lang="en">
<head>
    <title>Zangar Quiz</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <style>
        body {
            background: url(/images/zangar.jpg); 
            background-size: cover;
        }
        .opacity {
            background-size: cover; 
            background-color:rgba(253, 253, 253, 0.5);
            height: 100vh;
        }
    </style>
</head>
<body>
    <div class="opacity">
        @yield('space-work')
    </div>
    


    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

</body>
</html>