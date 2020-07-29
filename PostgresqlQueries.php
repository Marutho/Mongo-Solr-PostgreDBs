<?php
    //tiempo de 5 minutos para que se hagan todas las queries
    ini_set('max_execution_time', 300);
    set_time_limit(300);   
    require_once('PostgreDB.php');


    

     //extension que econtre que te mete todo en black mode por asi decirlo
     echo '<link type="text/css" id="dark-mode" rel="stylesheet" href="chrome-extension://jabpfojepndedlelamfloejfoopkogcf/data/content_script/general/dark_1.css">';
     echo '<head>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
     </head>
     <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>';

     

    $PGqueries = new Pqueries();

    //escape the text
    $escape1 = '"TwUser".id';
    $escape2 = '"TwUser"';
    $escape3 = '"Tweet"';
    $escape4 = '"Tweet".iduser';

    //SYNTAX QUERIES
    $joinquery = "SELECT ".$escape1.",
            followers,
            pfollowing,
            biography,
            profilepic,
            contenttw
            FROM
            ".$escape2."
            INNER JOIN ".$escape3." ON ".$escape4." = ".$escape1."";
    
    $simplequery = "SELECT * FROM ".$escape3." WHERE favs > 300";
    $aggregatequery = "SELECT iduser, max(favs) FROM ".$escape3." GROUP BY iduser HAVING max(favs) > 5000";
    $mapreducequery = "SELECT  SUM(favs),iduser FROM ".$escape3." group by iduser";
    //$PGqueries->joinQuery($joinquery);
    //$PGqueries->simpleQuery($simplequery);
    //$PGqueries->searchQuery('launch');
    //$PGqueries->aggregateQuery($aggregatequery);
    //$PGqueries->mapreduceQuery($mapreducequery);

    $content ='';
    

        if(isset($_POST['texto']) )
        {
        
            
            $textToSearch=$_POST['texto'];
            
            $PGqueries->searchQuery($textToSearch);
            
            //var_dump($productToSearch);
         
            
        }
        else if (isset($_GET['select']))
        {     
            if($_GET['select']=='Simple')
            {
                
                $queri=$PGqueries->simpleQuery($simplequery);
                echo '</div>';


            }else if($_GET['select']=='Join')
            {
                
                $PGqueries->joinQuery($joinquery);

            }else if($_GET['select']=='Aggregate')
            {
                $PGqueries->aggregateQuery($aggregatequery);
            }
            else if($_GET['select']=='Mapreduce')
            {
                $PGqueries->mapreduceQuery($mapreducequery);
            }           

        }else{
            $content.='

        <div class="row" style="background: grey">
        <div class="col-lg-4" style="background: blue; color: white">
            <ul>
            <li>
            <h1>SIMPLE QUERY</h1>
                <div>
                    <a href="?select=Simple">SIMPLE QUERY EXAMPLE</a><br>
                </div>
            </li>
            
            <li >
            <h1>JOIN QUERY</h1>
                <div>
                    <a href="?select=Join">JOIN QUERY EXAMPLE</a><br>
                </div>
            </li>
            
            <li >
            <h1>AGGREGATE QUERY</h1>
                <div>
                    <a href="?select=Aggregate">AGGREGATE QUERY EXAMPLE</a><br>
                </div>
            </li>
            <li >
            <h1>MAPREDUCE QUERY</h1>
                <div class="dropdown-content">
                    <a href="?select=Mapreduce">MAPREDUCE QUERY EXAMPLE</a><br>
                </div>
            </li>
            <li >
            <h1>SEARCH QUERY</h1>
                <div class="dropdown-content">
                    <form method ="post" action ="">
                    <p><label></label>
                    <input type="text" name="texto"></p>
                    <input type="submit" name="buscar" value="Search by terms">
                    </form> 
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
        }

        $content.='
        </div> </div><br><br><h2>Return to other pages</h1>
        <a href="/FinalTask/PostgresqlQueries.php">Click here to go to the main page of PostgreSQL </a> <br>
        <a href="/FinalTask/Index.php">Click here to go to the GENERAL page</a> ';
        
    echo $content;

    class Pqueries{

        function simpleQuery($simplequery)
        {
            echo '<h2>POSTGRESQL: This is a SIMPLE QUERY, with this we get the tweets with more than 300 favs</h2><br />';
            echo '<h4>'.$simplequery.'</h4>';
            echo '<br /><hr />';

            $result = pg_query($simplequery) or die('La consulta fallo: ' . pg_last_error());

            // Imprimiendo los resultados en HTML
            
            while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                foreach ($line as $col_value => $value) {    
                        echo $col_value.': ' .$value .'<br />';
                    }
                echo "<hr />";
            }
        }

        function joinQuery($joinquery) //con esta query uniremos usuario con un contenido del tweet que en ete caso es el contenido como tal
        {
            echo '<h2>POSTGRESQL: This is a join example, where we will do a join to get the tweet content attached to the user who wrote it</h2><br />';
            echo '<h4>'.$joinquery.'</h4>';
            echo '<br /><hr />';

            $result = pg_query($joinquery) or die('La consulta fallo: ' . pg_last_error());

            // Imprimiendo los resultados en HTML
            
            while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                foreach ($line as $col_value => $value) {    
                        echo $col_value.': ' .$value .'<br />';
                    }
                echo "<hr />";
            }
        }          

        function aggregateQuery($aggregatequery)
        {
            echo '<h2>POSTGRESQL: This is a an AGGREGATE example, where we will do an aggregate where we take the most faved tweet of the users, but only if is more than 5000</h2><br />';
            echo '<h4>'.$aggregatequery.'</h4>';
            echo '<br /><hr />';

            $result = pg_query($aggregatequery) or die('La consulta fallo: ' . pg_last_error());

            // Imprimiendo los resultados en HTML
            
            while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                foreach ($line as $col_value => $value) {    
                        echo $col_value.': ' .$value .'<br />';
                    }
                echo "<hr />";
            }
        }

        function mapreduceQuery($mapreducequery)
        {
            echo '<h2>POSTGRESQL: This is a a Mapreduce try example, where we will do the sum of all the favs grouped for each user</h2><br />';
            echo '<h4>'.$mapreducequery.'</h4>';
            echo '<br /><hr />';

            $result = pg_query($mapreducequery) or die('La consulta fallo: ' . pg_last_error());

            // Imprimiendo los resultados en HTML
            
            while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                foreach ($line as $col_value => $value) {    
                        echo $col_value.': ' .$value .'<br />';
                    }
                echo "<hr />";
            }
        }

        function searchQuery($textoAbuscar)
        {
            $escape3 = '"Tweet"';
            echo '<h2>POSTGRESQL: This is the result of your search in the Postgredatabase with this text: "'.$textoAbuscar.'"</h2><br />';

            $searchAnyTerm = '%'.$textoAbuscar.'%';
            $textquery = "SELECT * FROM ".$escape3." WHERE contenttw LIKE '{$searchAnyTerm}'";
            echo '<h4>'.$textquery.'</h4>';
            echo '<br /><hr />';

            $result = pg_query($textquery) or die('La consulta fallo: ' . pg_last_error());
            // Imprimiendo los resultados en HTML
            while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                foreach ($line as $col_value => $value) {    
                        echo $col_value.': ' .$value .'<br />';
                    }
                echo "<hr />";
            }

            
        }

    }

?>