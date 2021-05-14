<?php
if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0)))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);

    die("Couldn't create socket: [$errorcode] $errormsg \n");
}

echo "Socket created \n";

// Bind the source address
if(!socket_bind($sock, "127.0.0.1" , 9545) )
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);

    die("Could not bind socket : [$errorcode] $errormsg \n");
}

echo "Socket bind OK \n";

if(!socket_listen ($sock , 10))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);

    die("Could not listen on socket : [$errorcode] $errormsg \n");
}

echo "Socket listen OK \n";

echo "Waiting for incoming connections... \n";

//Accept incoming connection - This is a blocking call
$client = socket_accept($sock);

//display information about the client who is connected
if(socket_getpeername($client , $address , $port))
{
    echo "Client $address : $port is now connected to us.";
}

socket_close($client);
socket_close($sock);