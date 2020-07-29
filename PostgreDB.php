<?php
// Conectando y seleccionado la base de datos  
    $dbconn = pg_connect("host=localhost dbname=Twitter user=postgres password=admin")
    or die('No se ha podido conectar: '. pg_last_error());
    //INSERTAMOS DATOS

class PG{
    
    function insertTweets($tweets, $createTablesAgain){

        //$this->restartTables();
        if($createTablesAgain==true)
        {
            $this->restartTables();
        }
        $firstTimeUser = false;
        foreach($tweets as $tw)
        {
         
          if(!$firstTimeUser){
            $usertable = '"TwUser"';
            $query1 = "INSERT INTO ".$usertable." (ID, screenname, followers, pfollowing, biography, listedcount , numberoftweets, startontwitter, profilepic) 
            VALUES ('".$tw[0]."','".$tw[1]."','{$tw[2]}','{$tw[3]}','".$tw[4]."','{$tw[5]}','{$tw[6]}', '".$tw[7]."','".$tw[8]."')"; 
            pg_query($query1) or die('La consulta fallo: ' . pg_last_error());
            $firstTimeUser = true;           
          }

            //var_dump($tw[9]);
            $removeThingContent = array("'");
            $contentTweet = str_replace($removeThingContent, "", $tw[10]);
            //Tweet insertion
            $tweettable = '"Tweet"';
            $query2 = "INSERT INTO ".$tweettable." (ID, IDUser, ContentTw, Retweets, Favs, ttime) VALUES ('".$tw[9]."', '".$tw[0]."','".$contentTweet."','{$tw[11]}','{$tw[12]}','".$tw[13]."')";              
            pg_query($query2) or die('La consulta fallo: ' . pg_last_error());

            
            //Hashtag insertions
            $hashtagtable = '"Hashtag"';

            
           if(count($tw)>13)
            {
                foreach($tw[14] as $hashtag)
                {
                    $query3 = "INSERT INTO ".$hashtagtable." (IDTweet, ContentHash) VALUES ('".$tw[9]."','".$hashtag."')";
                    pg_query($query3) or die('La consulta fallo: ' . pg_last_error());
                }
            }
            
            
        }
        
    }

    function restartTables()
    {
        $dropall = ' DROP TABLE IF EXISTS "TwUser" CASCADE;
                 DROP TABLE IF EXISTS "Tweet" CASCADE;
                 DROP TABLE IF EXISTS "Hashtag" CASCADE;';

        $userTable = 'CREATE TABLE "TwUser" (
        ID varchar(128) NOT NULL,
        screenname varchar(128),
        followers integer,
        pfollowing integer,
        biography varchar(128),
        listedcount integer,
        numberoftweets integer,
        startontwitter varchar(128),
        profilepic varchar(128),
        PRIMARY KEY (ID));';

    $tweetTable = 'CREATE TABLE "Tweet" (
        ID varchar(128) NOT NULL,
        IDUser varchar(128) NOT NULL,
        ContentTw varchar(500),
        Retweets integer,
        Favs integer,
        ttime varchar(128),
        PRIMARY KEY (ID),
        FOREIGN KEY (IDUser) REFERENCES "TwUser" (ID)
    );';

    $hashtagTable = 'CREATE TABLE "Hashtag" (
        ID SERIAL,
        IDTweet text NOT NULL,
        ContentHash varchar(128),
        PRIMARY KEY (ID),
        FOREIGN KEY (IDTweet) REFERENCES "Tweet" (ID)
    );';
            
            
    //EJECUCIONES INICIALES 
    pg_query($dropall) or die('La consulta fallo: ' . pg_last_error());              
    pg_query($userTable) or die('La consulta fallo: ' . pg_last_error());
    pg_query($tweetTable) or die('La consulta fallo: ' . pg_last_error());
    pg_query($hashtagTable) or die('La consulta fallo: ' . pg_last_error());

        
    }
}
// Realizando una consulta SQL



/*
// Realizando una consulta SQL
$query = 'SELECT * FROM authors';
$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());

// Imprimiendo los resultados en HTML
echo "<table>\n";
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";*/

// Liberando el conjunto de resultados
/*pg_free_result($result);

// Cerrando la conexión
pg_close($dbconn);*/
?>