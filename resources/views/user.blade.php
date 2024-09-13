<!doctype html>
<html lang="en">

<head>
    <!-- <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico"> -->

    <title>Signin Template for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

</head>

<body class="text-center">
    @foreach ($users as $user)
    <?php
    dd($users);
    ?>
    <p>This is user {{ $user->remember_token }}</p>
    @endforeach
</body>

</html>