<?php

/*<h1>Users</h1>
                <div>
                    <a href="?select=user&username=Jack">Jack</a><br>
                    <a href="?select=user&username=ElonMusk">Elon Musk</a><br>
                    <a href="?select=user&username=Snowden">Snowden</a><br>
                    <a href="?select=user&username=PewdiePie">PewdiePie</a><br>
                </div>
            </li>*/

            /*&nbsp;&nbsp;<form method ="post" action ="">
            <p><label></label>
            <input type="text" name="producto"></p>
            <input type="submit" name="buscar" value="Search by terms">
            
    </form> */
//tiempo de 5 minutos para que se hagan todas las queries
    ini_set('max_execution_time', 300);
    set_time_limit(300);
    require_once('TwitterAPIExchange.php');
    require_once('Twitter.php');


    $tweets = new Tweets();

    //extension que econtre que te mete todo en black mode por asi decirlo
    echo '<link type="text/css" id="dark-mode" rel="stylesheet" href="chrome-extension://jabpfojepndedlelamfloejfoopkogcf/data/content_script/general/dark_1.css">';

    $content ='';
    $content.='
    <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <h1> 💾 Welcome to your favourite database manager 💾 </h1>
    
    
 
    <div class="row" style="background: grey">
    <div class="col-lg-2" style="background: blue; color: white">
            <ul>
            <li>
            <h1>Create Data</h1>
                <div>
                <a href="/FinalTask/CreateData.php"> Create DATA in the 3 databases </a><br>
                </div>
            </li>

            <li>
            <h1>Solr</h1>
                <div>
                    <a href="/FinalTask/SolrQueries.php"> Queries in Solr </a><br>
                </div>
            </li>
            
            <li >
            <h1>PostgreSQL</h1>
                <div>
                    <a href="/FinalTask/PostgresqlQueries.php"> Queries in PostgreSQL </a><br>
                </div>
            </li>
            
            <li >
            <h1>MongoDB</h1>
                <div>
                    <a href="/FinalTask/MongodbQueries.php"> Queries in MongoDB </a><br>
                </div>
            </li>
            </ul>
        </div>
       
             
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            
                
        ';
    

echo $content;
//$allTweets = $tweets->getTweets("NASA");

//$pgadm->insertTweets($allTweets);


//solradm->insertTweets($allTweets, $client);


?>