<?php

    class Publish{
        public $id_news;
        public $id_author;
        public $publish_date;
        public $updating_date;
        public $update_times;
        public $is_published;
        private $connection;

        public function __construct($id_news, $id_author, $publish_date, $updating_date, $update_times, $is_published)
        {

            require 'database_config.php';
            $this->connection = $connection;

            $this->id_news = $id_news;
            $this->id_author = $id_author;
            $this->publish_date = $publish_date;
            $this->updating_date = $updating_date;
            $this->update_times = $update_times;
            $this->is_published = $is_published;
        }

        public function setAuthor($id){

            $query = 'UPDATE published SET id_author_p = '.$id.' WHERE id_news_p = '
            .$this->id_news;//' AND id_author_p = '.$this->id_author;

            mysqli_query($this->connection, $query);

        }
        public function setNews($id){

            $query = 'UPDATE published SET id_news_p = '.$id.' WHERE id_news_p = '
            .$this->id_news;//.' AND id_author_p = '.$this->id_author;

            mysqli_query($this->connection, $query);

            $this->id_author = $id;

        }

        public function publish($id_news, $id_author){

            $query  = 'UPDATE published SET is_published = 1 WHERE id_news_p = '
            .$id_news.' AND id_author_p = '.$id_author;

            mysqli_query($this->connection, $query);

        }

        public function unPublish($id_news, $id_author){

            $query  = 'UPDATE published SET is_published = 0 WHERE id_news_p = '
            .$id_news.' AND id_author_p = '.$id_author;

            mysqli_query($this->connection, $query);

        }
        public function isPublished(){

            $query = 'SELECT is_published FROM published WHERE id_news_p = '.$this->id_news;

            return mysqli_fetch_array(mysqli_query($this->connection, $query));

        }

        // public function setPublishDate($publish_date){

        //     $query = 'UPDATE published SET publish_date = "'.$publish_date.'" WHERE id_news_p = '
        //     .$this->id_news.' AND id_author_p = '.$this->id_author;

        //     mysqli_query($this->connection, $query);

        //     $this->publish_date = $publish_date;

        // }

        public function setUpdatingDate($updating_date){

            $query = 'UPDATE published SET updating_date = now() WHERE id_news_p = '
            .$this->id_news.' AND id_author_p = '.$this->id_author;

            mysqli_query($this->connection, $query);

            $this->updating_date = $updating_date;

        }

        public function setUpdateTimes($update_times){

            $query = 'UPDATE published SET update_times = '.$update_times.' WHERE id_news_p = '
            .$this->id_news.' AND id_author_p = '.$this->id_author;

            mysqli_query($this->connection, $query);

            $this->update_times = $update_times;

        }

    }

?>