<html>

<head>

</head>

<body>

<?php

$timestamp = time();
//echo($timestamp);
echo "\n";
echo(date("F d, Y h:i:s A", $timestamp));

?>
<h2> Payment Slip</h2>

<h1> {{ $user->d_amount}}</h1>

<div>

    <p>{{$user->due}}</p>

</div>


</body>



</html>