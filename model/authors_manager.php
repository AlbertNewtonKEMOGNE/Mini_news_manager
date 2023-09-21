<?php

    class AuthorsManager{
        
        private $connection;

        public function __construct(){
            
            require 'database_config.php';
            $this->connection = $connection;
            
        }

        public function addAuthor($author)
        {
            $query = 'INSERT INTO authors(id_author, author_name, author_address) values ('.
                $author->id_author.', "'.
                $author->author_name.'" , "'.
                $author->author_address.
                '")';

            mysqli_query($this->connection, $query);
        }

        public function updateAuthor($author){

            $author->setName($author->author_name);
            $author->setAddress($author->author_address);
            
        }

        public function count(){

            $query = 'SELECT id_author FROM authors';

            return mysqli_num_rows(mysqli_query($this->connection, $query));

        }

        public function getList(){

            $query = 'SELECT id_author, author_name FROM authors';

            $res = mysqli_query($this->connection, $query);
            $i = 0;
            
            $result = array();
            
            while($line = mysqli_fetch_assoc($res)){

                $result[$i] = json_encode(array('id_author' => $line['id_author'],
                    'author_name' => $line['author_name']
                ));
                $i++;

            }


            echo json_encode($result);

        }

        public function getUnique($id){

            $query = 'SELECT * FROM authors WHERE id_authors = '.$id;
            
            $result = mysqli_fetch_assoc(mysqli_query($this->connection, $query));

            return new Author($result['id_author'], $result['author_name'], $result['author_address']);

        }

    }

?>