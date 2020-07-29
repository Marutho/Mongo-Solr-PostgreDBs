<?php
    //tiempo de 5 minutos para que se hagan todas las queries
    ini_set('max_execution_time', 300);
    set_time_limit(300);
    require_once('MongoDB.php');

    echo joinQuery();

    class Mqueries{

        function simpleQuery()
        {

        }

        function joinQuery() //con esta query uniremos usuario con un contenido del tweet que en ete caso es el contenido como tal
        {
            $escape1 = '"TwUser".id';
            $escape2 = '"TwUser"';
            $escape3 = '"Tweet"';
            $escape4 = '"Tweet".iduser';
            $joinquery = "SELECT ".$escape1."
            followers,
            pfollowing,
            biography,
            profilepic,
            contenttw
            FROM
            ".$escape2."
            INNER JOIN ".$escape3." ON ".$escape4." = ".$escape1."";
            pg_query($joinquery) or die('La consulta fallo: ' . pg_last_error());
        }        

        function aggregateQuery()
        {

        }

        function mapreduceQuery()
        {

        }

        function searchQuery($textoAbuscar)
        {

        }

    }

?>