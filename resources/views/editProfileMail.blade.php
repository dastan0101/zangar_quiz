<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $data['title'] }}</title>
</head>
<body>
    <table>
        <tr>
            <th>Name</th>
            <td>{{ $data['name'] }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $data['email'] }}</td>
        </tr>
        
    </table>
    <p><b>Note: </b> You can use your old password.</p>
    <a href="{{ $data['url'] }}">Click here to login your account.</a>
    <p>Best Regards!</p>
</body>
</html>