<?php


// System Varialbes

$host_info["name"]="stodge";

// DB Connection

$database[0]["server"]="localhost";
$database[0]["username"]="portal";
$database[0]["password"]="p0rta1";
$database[0]["dbname"]="portal";
$database[0]["type"]="mysql";

// Make connections

foreach ($database as $key => $value)
         {

         $connection[$key]=NewADOConnection( $value["type"] );
         $connection[$key]->Connect($value["server"],$value["username"], $value["password"], $value["dbname"]);
         // On failure to connect:

         if ($connection[$key] === false)

              {
              die ("<p>Could not connect to ".$database[0]["type"]." database ".$database[0]["dbname"]." on ".$database[0]["server"].".</p> ");
              }
              else
              {
              // echo "<!--Connected to ".$database[0]["type"]." database ".$database[0]["dbname"]." on ".$database[0]["server"].". -->";
              }


         }

?>