<?php

    class NewsManager{

        private $connection;

        public function __construct(){
            
            require 'database_config.php';
            $this->connection = $connection;

        }

        public function addNews($news){

            
                
            $query = 'INSERT INTO news(id_news, title, content) values ('.
                $news->id_news.', "'.
                $news->title.'", "'.
                $news->content.'"'.
            ')';

            mysqli_query($this->connection, $query);

        }

        public function deleteNews($id){

            $query = 'DELETE FROM news WHERE id_news = '.$id;

            mysqli_query($this->connection, $query);

        }

        public function updateNews($news){

            $news->setTitle($news->title);
            $news->setContent($news->content);
            
        }
        public function count(){

            $query = 'SELECT id_news FROM news';

            return mysqli_num_rows(mysqli_query($this->connection, $query));

        }

        public function getList(){

            $query = 'SELECT id_news, title, content, author_name, is_published, id_author FROM news, authors, published WHERE news.id_news = published.id_news_p AND authors.id_author = published.id_author_p';

            $res = mysqli_query($this->connection, $query);
            $i = 0;

            $result = array();
            
            while($line = mysqli_fetch_assoc($res)){

                $result[$i] = json_encode(array('id_news' => $line['id_news'],
                    'title' => $line['title'],
                    'content' => $line['content'],
                    'author_name' => $line['author_name'],
                    'id_author' => $line['id_author'],
                    'is_published' => $line['is_published']
                ));
                $i++;

            }

            echo json_encode($result);

        }

        public function getUnique($id_news, $id_author){

            $query = 'SELECT id_news, title, content, author_name, id_author, publish_date, updating_date FROM news, authors, published WHERE news.id_news = published.id_news_p 
            AND authors.id_author = published.id_author_p
            AND news.id_news = '.$id_news.'
            AND authors.id_author = '.$id_author.'';
            
            $res = mysqli_query($this->connection, $query);
            $line = mysqli_fetch_assoc($res);
            
            $result = array();

            $result[0] = json_encode(array('id_news' => $line['id_news'],
                    'title' => $line['title'],
                    'content' => $line['content'],
                    'author_name' => $line['author_name'],
                    'id_author' => $line['id_author'],
                    'publish_date' => $line['publish_date'],
                    'updating_date' => $line['updating_date']
                ));

            echo json_encode($result);

        }

    }

?>