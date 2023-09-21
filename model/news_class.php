<?php

    class News{
        public $id_news;
        public $title;
        public $content;
        private $connection;

        public function __construct($id, $title, $content)
        {

            require 'database_config.php';
            $this->connection = $connection;

            $this->id_news = $id;
            $this->title = $title;
            $this->content = $content;
        }

        public function isNew(){

            $query = 'SELECT * FROM news WHERE title = "'
            .$this->title.'" AND content = "'.
            $this->content
            .'"';

            return(
                mysqli_num_rows(mysqli_query($this->connection, $query)) > 0
            );
        }

        public function setId($id){

            $query = 'UPDATE news SET id_news = '.$id.' WHERE id_news = '.$this->id_news;

            mysqli_query($this->connection, $query);

        }

        public function setTitle($title){

            $query = 'UPDATE news SET title = "'.$title.'" WHERE id_news = '.$this->id_news;

            mysqli_query($this->connection, $query);

        }

        public function setContent($content){

            $query = 'UPDATE news SET content = "'.$content.'" WHERE id_news = '.$this->id_news;

           mysqli_query($this->connection, $query);

        }

    }

?>