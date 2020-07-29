<?php

include_once("vendor/autoload.php");
$config = array("endpoint" => array("localhost" => array
("host"=>"127.0.0.1",
"port"=>"8983", "path"=>"", "core"=>"Twitter", "timeout" => 50)));

// check solarium version available
echo 'Solarium library version: ' . Solarium\Client::VERSION . ' - ';

$client = new Solarium\Client(
    new Solarium\Core\Client\Adapter\Curl(), // or any other adapter implementing AdapterInterface
    new Symfony\Component\EventDispatcher\EventDispatcher(),
    $config
);

// create a ping query
$ping = $client->createPing();

// execute the ping query
try {
    $result = $client->ping($ping);
    echo 'Ping query successful';
    echo '<br/><pre>';
    var_dump($result->getData());
    echo '</pre>';
} catch (Solarium\Exception $e) {
    echo 'Ping query failed';
}

class Sol{

    function insertTweets($tweets, $client){
        //Vamos a insertar en Solr datos
        // get an update query instance
        $update = $client->createUpdate();

        // add the delete query and a commit command to the update query
        //$update->addDeleteQuery('name:Twitter*');
      //  $update->addCommit();

        // this executes the query and returns the result
        $result = $client->update($update);
        foreach($tweets as $tw)
        {
            $updateQuery = $client->createUpdate();
            $doc1 = $updateQuery->createDocument();


            $doc1->ID = $tw[9]; //la id del tweet
            $doc1->Username = $tw[0];
            $doc1->screen_name = $tw[1];
            $doc1->followers_count = $tw[2];
            $doc1->friends_count = $tw[3];
            $doc1->description = $tw[4];
            $doc1->listed_count = $tw[5];
            $doc1->statuses_count = $tw[6];
            $doc1->account_created_at = $tw[7];
            $doc1->profile_image_url = $tw[8];
            $doc1->full_text = $tw[10];
            $doc1->retweet_count = $tw[11];
            $doc1->favorite_count = $tw[12];
            $doc1->tweet_created_at = $tw[13];
            $doc1->hashtags = $tw[14];

            $updateQuery->addDocuments(array($doc1));
            $updateQuery->addCommit();
            $result = $client->update($updateQuery);
        }

    }


}


?>