<?php
    ini_set('max_execution_time', 300);
    set_time_limit(300);
    require_once('SolrDB.php');
    require_once('MongoDB.php');
    require_once('PostgreDB.php');
    require_once('TwitterAPIExchange.php');
    require_once('Twitter.php');
        
    //extension que econtre que te mete todo en black mode por asi decirlo
    echo '<link type="text/css" id="dark-mode" rel="stylesheet" href="chrome-extension://jabpfojepndedlelamfloejfoopkogcf/data/content_script/general/dark_1.css">';
    //Clase para capturar tweets
    $tweets = new Tweets();


    //Clases de las bases de datos
    $pgadm = new PG();
    $solradm = new Sol();
    $mongoadm = new Mong();

    $content ='';
    $content.='
        <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        </head>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <h1> 💾 Welcome to your favourite database manager 💾 </h1>
        PERFECTO YA ESTA TODO CREADO! <br><br><br>
        <a href="/FinalTask/Index.php"> Volver al menu de queries </a>';

    echo $content;
    //FUNCION DE OBTENCION DE TODOS LOS TWEETS (MEJORAR Y PODER METER VARIOS USUARIOS DE UNA, NO 1 POR 1)
    $allTweets = $tweets->getTweets("NASA");
    $allTweets2 = $tweets->getTweets("jack");
    $allTweets3 = $tweets->getTweets("elonmusk");


    //PosgreSQL DATA
    $pgadm->insertTweets($allTweets,true); //el primero es true para crear todo de 0
    $pgadm->insertTweets($allTweets2,false);
    $pgadm->insertTweets($allTweets3,false);
    //SOLR DATA
    $solradm->insertTweets($allTweets, $client); 
    $solradm->insertTweets($allTweets, $client);
    $solradm->insertTweets($allTweets, $client);
    //MONGODB DATA
    $mongoadm->insert($allTweets); 
    $mongoadm->insert($allTweets2);
    $mongoadm->insert($allTweets3);

?>