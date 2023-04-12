<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['title'] }}</title>
</head>
<body>
    
    <p>

        Hii<b> {{ $data['name'] }}, </b><br>
        Your Exam {{ $data['exam_name'] }} review passed. So now you can check your 
        <b>marks</b>
        
    </p>

    <a href="{{ $data['url'] }}">Click here to see your results</a>

</body>
</html>