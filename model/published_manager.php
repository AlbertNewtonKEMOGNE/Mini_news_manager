<?php

    class PublishedManager{

        private $connection;

        public function __construct(){
            
            require 'database_config.php';
            $this->connection = $connection;
            
        }

        public function addPublish($publish)
        {
            $query = 'INSERT INTO published (id_news_p, id_author_p,  update_times, is_published) values ('.
                $publish->id_news.', '.
                $publish->id_author.', '.
                $publish->update_times.', '.
                $publish->is_published.
                ')';
                
            if(!mysqli_query($this->connection, $query)){
                $response['publish'] = 'failed to publish';
                echo json_encode($response);
            }else{
                $response['publish'] = 'successfully add';
                echo json_encode($response);
            }

            
        }

        public function deleteCoupleAuthorNews($id_news, $id_author){

            $query = 'DELETE FROM published WHERE id_news_p = '.$id_news.' AND id_author_p = '.$id_author;

            mysqli_query($this->connection, $query);

        }

        public function updatePublish($publish){

            $publish->setAuthor($publish->id_author);
            $publish->setNews($publish->id_news);
            //$publish->setPublishDate($publish->publish_date);
            $publish->setUpdatingDate($publish->updating_date);
            $publish->setUpdateTimes($publish->update_times);
            
        }

        public function count(){

            $query = 'SELECT id_news_p, id_author_p FROM published';

            return mysqli_num_rows(mysqli_query($this->connection, $query));

        }

        public function getUnique($id_news, $id_author){

            $query = 'SELECT * FROM published WHERE id_news_p = '.$id_news.' AND id_author_p = '.$id_author;
            
            $result = mysqli_fetch_assoc(mysqli_query($this->connection, $query));

            return new Publish($result['id_news_p'], $result['id_author_p'], $result['publish_date'], $result['updating_date'], $result['update_times'], $result['is_published']);

        }
    }

    // include "../model/news_manager.php";
    // include "../model/news_class.php";
    // include "../model/publish_class.php";

    // $news = new News(4, "Life in Beverly's High School", "Every day students go to school, the have a lot of teachers and of hobbies, they can also decide which or not hobby they can enjoy and what kind of friend they need, however, some of them take drugs and are really dishonest.");

    // $newsManager = new NewsManager();
    // $publish = new Publish(4, 1, '', '', 0, 0);
    // $publishManager = new PublishedManager();

    // $newsManager->addNews($news);
    // $publishManager->addPublish($publish);

?>