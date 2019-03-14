<?php

function test_webhook()
{
    echo $json_string = file_get_contents("php://input");
}

test_webhook();