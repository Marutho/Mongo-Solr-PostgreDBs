<?php
    //tiempo de 5 minutos para que se hagan todas las queries
    ini_set('max_execution_time', 300);
    set_time_limit(300);
    require_once('MongoDB.php');

      //extension que econtre que te mete todo en black mode por asi decirlo
      echo '<link type="text/css" id="dark-mode" rel="stylesheet" href="chrome-extension://jabpfojepndedlelamfloejfoopkogcf/data/content_script/general/dark_1.css">';
      echo '<head>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      </head>
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>';

    //$mongoadm = new Mong();
    $Mqueries = new Mqueries();
   // $Mqueries->searchQuery($tweetcollectionM, "Mars");
   //$Mqueries->joinQuery($tweetcollectionM, 'NASA');
   //$Mqueries->aggregateQuery($tweetcollectionM);
   //$Mqueries->mapreduceQuery($tweetcollectionM);
   //$Mqueries->simpleQuery($tweetcollectionM);

   $content ='';
    

        if(isset($_POST['texto']) )
        {
        
            
            $textToSearch=$_POST['texto'];
            
            $Mqueries->searchQuery($tweetcollectionM, $textToSearch);
            
            //var_dump($productToSearch);
         
            
        }
        else if (isset($_GET['select']))
        {     
            if($_GET['select']=='Simple')
            {
                
                $queri=$Mqueries->simpleQuery($tweetcollectionM);
                echo '</div>';


            }else if($_GET['select']=='Join')
            {
                
                $Mqueries->joinQuery($tweetcollectionM, 'NASA');

            }else if($_GET['select']=='Aggregate')
            {
                $Mqueries->aggregateQuery($tweetcollectionM);
            }
            else if($_GET['select']=='Mapreduce')
            {
                $Mqueries->mapreduceQuery($tweetcollectionM);
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
        <a href="/FinalTask/MongodbQueries.php">Click here to go to the main page of MongoDB </a> <br>
        <a href="/FinalTask/Index.php">Click here to go to the GENERAL page</a> ';
        
    echo $content;

    

    class Mqueries{

        function simpleQuery($collection)
        {
            echo '<h2>MONGODB: This is a SIMPLE QUERY, with this we get the tweets with more than 400 RTS BUT LESS THAN 500</h2>';
            $rangeQuery = array('retweet_count' => array( '$gt' => 400, '$lt' => 500 ));
            $tweet = $collection->find($rangeQuery);
            $tweet->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);
           // var_dump($tweet);
            $counter = 0;

            foreach ($tweet as $document) {

                echo '<hr/><table>';
                // the documents are also iterable, to get all fields
                foreach ($document as $field => $value) {
                    // this converts multivalue fields to a comma-separated string

                        if (is_array($value)) {
                            $value = implode(', ', $value);
                        }
    
                        echo '<tr><th>' . $field . '</th><td>' . $value . '</td></tr>';
                   
                }
                

                echo '</table>';
            }
        }

        function joinQuery($collection, $textoAbuscar) //con esta query uniremos usuario con un contenido del tweet que en ete caso es el contenido como tal
        {
            echo '<h2>MONGODB: This is a JOIN QUERY, with this we get the tweets with the user "'.$textoAbuscar.'" : </h2>';
            $joinquery = array(
                array('$match' => ['id_user' => $textoAbuscar]) ,
                array('$lookup'=>[
                    'from'=>'User',
                    'localField'=>'id_user',
                    'foreignField'=>'screen_name',
                    'as'=>'User']));

            $tweet = $collection->aggregate($joinquery);
            $tweet->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);
            
            foreach ($tweet as $document) {
               // var_dump($document);
                $counter = 0;
                echo '<hr/><table>';
                // the documents are also iterable, to get all fields
                foreach ($document as $field => $value) {
                    // this converts multivalue fields to a comma-separated string

                    if($counter<8)
                    {
                        if (is_array($value)) {
                            $value = implode(', ', $value);
                        }
                        echo '<tr><th>' . $field . '</th><td>' . $value . '</td></tr>';
                    }else{
                        //var_dump($value);
                        foreach($value as $userfield => $value2)
                        {
                            if (is_array($value2)) {
                                $value2 = implode(', ', $value2);
                                $counter+=1;
                            }
                            //var_dump($value2);
                            echo '<tr><th>User Things: </th><td>' . $value2 . '</td></tr><br>';
                        }
                        
                    }

                    $counter++;
                                         
                }
            }
        }        

        function aggregateQuery($collection)
        {
            echo '<h2>MONGODB: This is a AGGREGATE QUERY, with this we get the tweets with hashtags</h2>';
            $aggregatequery= array(
                array('$unwind' => '$hashtags') 
                );

            $tweet = $collection->aggregate($aggregatequery);

            $tweet->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);
            //var_dump($tweet);

            foreach ($tweet as $document) {
               // var_dump($document);
                echo '<hr/><table>';
                // the documents are also iterable, to get all fields
                foreach ($document as $field => $value) {
                    // this converts multivalue fields to a comma-separated string

                        if (is_array($value)) {
                            $value = implode(', ', $value);
                        }
    
                        echo '<tr><th>' . $field . '</th><td>' . $value . '</td></tr>';
                   
                }
               
                echo '</table>';
            }
            

        }

        function mapreduceQuery($collection)
        {
            echo '<h2>MONGODB: This is a MAPREDUCE QUERY,  where we will do the sum of all the favs grouped for each user: </h2>';

            $map = new MongoDB\BSON\Javascript( 'function(){emit(this.id_user, this.favorite_count)}' );
            $reduce = new MongoDB\BSON\Javascript( 'function(key, values){return Array.sum(values)}' );
            $out = ['inline' =>1];

            $tweet = $collection->mapReduce($map, $reduce, $out); 

            foreach ($tweet as $document) {
                // var_dump($document);
                 echo '<hr/><table>';
                 // the documents are also iterable, to get all fields
                 foreach ($document as $field => $value) {
                     // this converts multivalue fields to a comma-separated string
 
                         if (is_array($value)) {
                             $value = implode(', ', $value);
                         }
     
                         echo '<tr><th>' . $field . '</th><td>' . $value . '</td></tr>';
                    
                 }
                
                 echo '</table>';
             }
        }

        function searchQuery($collection, $textoAbuscar)
        {
            

            echo '<h2>MONGODB: This is a SEARCH QUERY, with this we get the tweets with the text: "'.$textoAbuscar.'"</h2>';
            //$rangeQuery = array('retweet_count' => array( '$gt' => 400, '$lt' => 500 ));
            //$filter = ['$text' => ['$search' => "\"".$textoAbuscar."\""]];
            $filter = ['$text' => ['$search' => $textoAbuscar]];
            $tweet = $collection->find($filter);
            
            $tweet->setTypeMap(['root' => 'array', 'document' => 'array', 'array' => 'array']);
            //var_dump($tweet);

            foreach ($tweet as $document) {
               // var_dump($document);
                echo '<hr/><table>';
                // the documents are also iterable, to get all fields
                foreach ($document as $field => $value) {
                    // this converts multivalue fields to a comma-separated string

                        if (is_array($value)) {
                            $value = implode(', ', $value);
                        }
    
                        echo '<tr><th>' . $field . '</th><td>' . $value . '</td></tr>';
                   
                }
               
                echo '</table>';
            }
        }

    }

?>