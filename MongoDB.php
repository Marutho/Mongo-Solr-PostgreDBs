<?php
    include_once("vendor/autoload.php");

    $m = new MongoDB\Client;
    $twitterMDB = $m->Twitter;
    $tweetcollectionM = $twitterMDB->Tweet;
    $usercollectionM = $twitterMDB->User;

    $resultCollec1 = $tweetcollectionM->createIndex(["$**" => "text" ]); 
    //var_dump($resultCollec1);

  

class Mong{

    function insert($tweets){
                // conectar
        $m = new MongoDB\Client;
       // $resultDropDB = $m->dropDatabase('Twitter');
        $twitterMDB = $m->Twitter;

        if (!$twitterMDB->Tweet || !$twitterMDB->User){
            $resultM1 = $twitterMDB->createCollection('Tweet');
            $resultM2 = $twitterMDB->createCollection('User');
        }
        
        $tweetcollectionM = $twitterMDB->Tweet;
        $usercollectionM = $twitterMDB->User;

  
        foreach($tweets as $tw)
        {        
        $insertTweets = $tweetcollectionM->insertOne(
                ['id_str' => $tw[9],
                'id_user' => $tw[0],
                'full_text' => $tw[10] ,
                'retweet_count' => $tw[11] ,
                'favorite_count' => $tw[12] ,
                'created_at' => $tw[13],
                'hashtags' => $tw[14]]
            );
        }

            $insertUsers = $usercollectionM ->insertOne(
                ['name' => $tw[0],
                'screen_name' => $tw[1] ,
                'followers_count' => $tw[2] ,
                'friends_count' => $tw[3] ,
                'description' => $tw[4] ,
                'listed_count' => $tw[5],
                'statuses_count' => $tw[6],
                'created_at' => $tw[7],
                'profile_image_url' => $tw[8]]
            );

    }

}


/*Node
{
    "value" : "root"
    "children" : [ { "value" : "child1", "children" : [ ... ] }, 
                   { "value" : "child2", "children" : [ ... ] } ]
}*/ //un ejemplo de estructuracion en mongo, con anidados, como lo que necesitaremos nosotros pa los tweets




//$result3 = $m->dropDatabase('twitterdb');
//$result4 = $m->dropDatabase('Twitter');

//var_dump($result1);

//$bd = $m->Twitter;

//$bulk = new MongoDB\Driver\BulkWrite;

/*
$stats = new MongoDB\Driver\Command(["dbstats" =>1]);
$res = $m->executeCommand("Twitter", $stats);

$stats = current($res->$toArray());

print_r($stats);*/

/*
// seleccionar una colección (equivalente a una tabla en una base de datos relacional)
$coleccion = $bd->Twitter;

// añadir un registro
$documento = array( "title" => "Calvin and Hobbes", "author" => "Bill Watterson" );
$coleccion->insert($documento);

// añadir un nuevo registro, con un distinto "perfil"
$documento = array( "title" => "XKCD", "online" => true );
$coleccion->insert($documento);

// encontrar todo lo que haya en la colección
$cursor = $coleccion->find();

// recorrer el resultado
foreach ($cursor as $documento) {
    echo $documento["title"] . "\n";
}*/

//$result2 = $twitterDB->dropCollection('Tweet'); SI QUEREMOS DROPEAR LA COLECCION PORQUE LA HEMOS LIADO PUES ESTE COMMAND
//$result3 = $m->dropDatabase('twitterdb'); ESTO PA DROPEAR LA DATABASE ENTERA CUIDADIN

//$twitterDB = $m->twitterdb; CREAMOS LA DATABASE
//$result1 = $twitterDB->createCollection('Tweet'); CReamos collecion ou yea

?>