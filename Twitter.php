<?php
require_once('TwitterAPIExchange.php');


//$content = new Content();

class Tweets{

    function getTweets($nameUser){
        /** Set access tokens here - see: https://dev.twitter.com/apps/ **/

        $content = '';
        $settings = array(
            'oauth_access_token' => "your private key, i cant put mine here",
            'oauth_access_token_secret' => "your private key, i cant put mine here",
            'consumer_key' => "your private key, i cant put mine here",
            'consumer_secret' => "your private key, i cant put mine here"
        );

        $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

        $requestMethod = "GET";

        if (isset($_GET['user']))
        {
            $user = preg_replace("/[^A-Za-z0-9_]/", '', $_GET['user']);
        }else {
            $user  = $nameUser;
        }

        if (isset($_GET['count']) && is_numeric($_GET['count']))
        {
            $count = $_GET['count'];
        } 
        else {
            $count = 10;
        }

        $getfield = "?screen_name=$user&count=$count&tweet_mode=extended";

        $twitter = new TwitterAPIExchange($settings);

        $string = json_decode($twitter->setGetfield($getfield)

        ->buildOauth($url, $requestMethod)

        ->performRequest(),$assoc = TRUE);

        if(array_key_exists("errors", $string)) {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}

        
        $allTweets = array();
        foreach($string as $items)
        {
            $tweet = array();
            array_push($tweet,
            
            //ABOUT USER
            $items['user']['name'], //0
            $items['user']['screen_name'], //1
            $items['user']['followers_count'], //2
            $items['user']['friends_count'], //3
            $items['user']['description'], //4
            $items['user']['listed_count'], //5
            $items['user']['statuses_count'], //6
            $items['user']['created_at'], //7
            $items['user']['profile_image_url'], //8

            //ABOUT TWEETS
            $items['id_str'], //9
            $items['full_text'], //10
            $items['retweet_count'], //11
            $items['favorite_count'], //12
            $items['created_at'] //13
        );

        $hashtagsArray = array();
            //ABOUT HASHTAG
        foreach($items['entities']['hashtags'] as $hashtags)
        {
            array_push($hashtagsArray, $hashtags['text']);
        }

        array_push($tweet, $hashtagsArray);
        
            /*foreach($items['entities']['hashtags'] as $hashtags)
            {
                array_push($tweet, $hashtags['text']);
            }*/
            /*
                $content .= "Time and Date of Tweet: ".$items['created_at']."<br />";
                $content .= "Number of Retweets: ".$items['retweet_count']."<br />";
                $content .= "Number of favs: ".$items['favorite_count']."<br />";
                $content .= "Tweet: ". $items['full_text']."<br />";
                $content .= "Tweeted by: ". $items['user']['name']."<br />";
                $content .= "Screen name: ". $items['user']['screen_name']."<br />";
                $content .= "Count created in: ". $items['user']['created_at']."<br />";
                $content .= "Total number of tweets: ". $items['user']['statuses_count']."<br />";
                $content .= "Biography: ". $items['user']['description']."<br />";
                $content .= "Followers: ". $items['user']['followers_count']."<br />";
                $content .= "Friends: ". $items['user']['friends_count']."<br />";
               // $content .= "Listed: ". $items['user']['listed_count']."<br />";
                $content .= "Hashtag: ";
                foreach($items['entities']['hashtags'] as $hashtags)
                {
                    var_dump($hashtags);
                    $content .= $hashtags['text']. ", ";
                }
                $content .= "<br />";
                $content .= '<img src='.$items['user']["profile_image_url"].'>';
                $content .= "<br /><hr />";*/

                array_push($allTweets, $tweet);
        }
            //var_dump($allTweets);
            return $allTweets;
        }
}
?>