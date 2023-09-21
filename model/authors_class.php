<?php

    class Author{
        protected $id_author;
        public $author_name;
        public $author_address;
        private $connection;

        public function __construct($id, $name, $address)
        {

            require 'database_config.php';
            $this->connection = $connection;

            $this->id_author = $id;
            $this->author_name = $name;
            $this->author_address = $address;
        }

        public function setId($id_author){

            $query = 'UPDATE authors SET id_author = "'.$id_author.'" WHERE id_author = '
            .$this->id_author;

            mysqli_query($this->connection, $query);

            $this->id_author = $id_author;

        }

        public function setName($author_name){

            $query = 'UPDATE authors SET author_name = "'.$author_name.'" WHERE id_author = '
            .$this->id_author;

            mysqli_query($this->connection, $query);

            $this->author_name = $author_name;

        }

        public function setAddress($author_address){

            $query = 'UPDATE authors SET author_address = "'.$author_address.'" WHERE id_author = '
            .$this->id_author;

            mysqli_query($this->connection, $query);

            $this->author_address = $author_address;

        }

    }
?>