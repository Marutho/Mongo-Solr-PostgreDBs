<?php
//EXPLICAR COMO INDEXAR, SI NO HUBIERAMOS USADO SOLARIUM
    //tiempo de 5 minutos para que se hagan todas las queries
    ini_set('max_execution_time', 300);
    set_time_limit(300);    
    require_once('SolrDB.php');

     //extension que econtre que te mete todo en black mode por asi decirlo
     echo '<link type="text/css" id="dark-mode" rel="stylesheet" href="chrome-extension://jabpfojepndedlelamfloejfoopkogcf/data/content_script/general/dark_1.css">';
     echo '<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>';

    $SRqueries = new Squeries();
    //$SRqueries->simpleQuery($client);
    //$SRqueries->searchQuery($client, 'na');

    $content ='';
    

        if(isset($_POST['texto']) )
        {
        
            
            $textToSearch=$_POST['texto'];
            
            $SRqueries->searchQuery($client, $textToSearch);
            
            //var_dump($productToSearch);
         
            
        }
        else if (isset($_GET['select']))
        {     
            if($_GET['select']=='Simple')
            {
                
                $queri=$SRqueries->simpleQuery($client);
                echo '</div>';


            }else if($_GET['select']=='Join')
            {
                
                $SRqueries->joinQuery();
                echo 'We can cant because we have all in one table, but with duplicated information </div>';

            }else if($_GET['select']=='Aggregate')
            {
                $SRqueries->aggregateQuery();
                echo 'We cant do aggregates, one option would be a pipeline of filters </div>';
            }
            else if($_GET['select']=='Mapreduce')
            {
                $SRqueries->mapreduceQuery();
                echo 'We cant do aggregates, one option would be a pipeline of filters </div>';
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
        <a href="/FinalTask/SolrQueries.php">Click here to go to the main page of Solr </a> <br>
        <a href="/FinalTask/Index.php">Click here to go to the GENERAL page</a> ';
        
    echo $content;

    class Squeries{

        function simpleQuery($client)
        {
            echo '<h2>SOLR: This is a SIMPLE QUERY, with this we get 20 tweets with more than 300 favs</h2><br />';
            // get a select query instance
            $query = $client->createSelect();
            // get the facetset component
            $facetSet = $query->getFacetSet();

            // create a facet field instance and set options
            $facetSet->createFacetField('Rts')->setField('retweet_count');

            // set a query (all prices starting from 12)
            //$query->setQuery('price:[12 TO *]');
            $query->setQuery('favorite_count:[300 TO *]');

            // set start and rows param (comparable to SQL limit) using fluent interface
            $query->setStart(2)->setRows(20);

            // set fields to fetch (this overrides the default setting 'all fields')
            //$query->setFields(array('ID','Username','favorite_count', 'description','full_text'));

            // sort the results by price ascending
            //$query->addSort('price', $query::SORT_ASC);
            $query->addSort('favorite_count', $query::SORT_ASC);

            // this executes the query and returns the result
            $resultset = $client->select($query);

            // display the total number of documents found by solr
            echo 'NumFound: '.$resultset->getNumFound();

            
            // display the max score
            echo '<br>MaxScore: '.$resultset->getMaxScore();

            // show documents using the resultset iterator
            foreach ($resultset as $document) {

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

            // display facet counts
            echo '<hr/>Facet counts for field "retweet_count":<br/>';
            $facet = $resultset->getFacetSet()->getFacet('Rts');
            foreach ($facet as $value => $count) {
                echo $value . ' [' . $count . ']<br/>';
            }

        }

        function joinQuery()
        {
            //No se puede proque tenemos todo en una tabla, pero informacion duplicada
        }        

        function aggregateQuery()
        {

        }//el aggregate no se puede ,lo mas parecido es el pipeline de filtros

        function mapreduceQuery()
        {

        }//map reduce no se puede de ninguna manera

        function searchQuery($client, $textoAbuscar)
        {
            echo '<h2>SOLR: This is the result of your search in the Solr database with this text: "'.$textoAbuscar.'"</h2><br />';
            // get a select query instance
            $query = $client->createSelect();

            // get the facetset component
            $facetSet = $query->getFacetSet();

            // create a facet field instance and set options
            $facetSet->createFacetField('Rts')->setField('retweet_count');

            // set a query (all prices starting from 12)
            //$query->setQuery('price:[12 TO *]');
            $query->setQuery('full_text: *'.$textoAbuscar.'*');

            // set start and rows param (comparable to SQL limit) using fluent interface
            $query->setStart(2)->setRows(20);

            // set fields to fetch (this overrides the default setting 'all fields')
            //$query->setFields(array('ID','username','favorite_count', 'description','full_text'));

            // sort the results by price ascending
            //$query->addSort('price', $query::SORT_ASC);
            $query->addSort('favorite_count', $query::SORT_ASC);

            // this executes the query and returns the result
            $resultset = $client->select($query);

            // display the total number of documents found by solr
            echo 'NumFound: '.$resultset->getNumFound();

            // show documents using the resultset iterator
            foreach ($resultset as $document) {

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

            // display facet counts
            echo '<hr/>Facet counts for field "retweet_count":<br/>';
            $facet = $resultset->getFacetSet()->getFacet('Rts');
            foreach ($facet as $value => $count) {
                echo $value . ' [' . $count . ']<br/>';
            }

        }

    }

?>