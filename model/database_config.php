<?php

    $database_host = 'localhost';
    $database_user = 'root';
    $database_name = 'ltw_basic_news';
    $database_password = '';
    $news_table_name = 'news';
    $authors_table_name = 'authors';
    $publish_table_name = 'published';

    $connection = mysqli_connect($database_host, $database_user, $database_password);

    if(!$connection){
        $response['connection_issue'] = 'failed';
        echo json_encode($response);
        die();
    }else{
        $create_database = 'CREATE DATABASE IF NOT EXISTS '.$database_name;

        if(!mysqli_query($connection, $create_database)){
            $response['database_issue'] = 'failed to created database';
            echo json_encode($response);
            die();
        }else{
            $new_connection = mysqli_connect($database_host, $database_user, $database_password, $database_name);
            
            if(!$new_connection){
                $response['database_issue'] = 'database created but failed to connect to it';
                echo json_encode($response);
                die();
            }else{
                $create_news_table = 'CREATE TABLE IF NOT EXISTS '.$news_table_name.'(
                    id_news  smallint (5) unsigned NOT NULL AUTO_INCREMENT ,
                    title  varchar ( 100) NOT NULL ,
                    content text NOT NULL ,
                    PRIMARY KEY (id_news) 
                )';
            
                $create_authors_table = 'CREATE TABLE IF NOT EXISTS '.$authors_table_name.'(
                    id_author  smallint (5) unsigned NOT NULL AUTO_INCREMENT ,
                    author_name  varchar (30) NOT NULL ,
                    author_address  varchar ( 100) NOT NULL ,
                    PRIMARY KEY (id_author )
                )';
            
                $create_publish_table = 'CREATE TABLE IF NOT EXISTS '.$publish_table_name.'(
                    id_news_p  smallint (5) unsigned NOT NULL,
                    id_author_p  smallint (5) unsigned NOT NULL,
                    publish_date  datetime NOT NULL  DEFAULT now(),
                    updating_date  datetime NOT NULL DEFAULT now(),
                    update_times smallint(5) NOT NULL DEFAULT 0,
                    is_published boolean DEFAULT 0,
                    PRIMARY KEY (id_news_p, id_author_p )
                )';

                $response['news_table_issue'] = 'news table created';
                $response['authors_table_issue'] = 'authors table created';
                $response['publish_table_issue'] = 'publish table created';

                if(!mysqli_query($new_connection, $create_news_table)) $response['news_table_issue'] = 'news table not created';
                if(!mysqli_query($new_connection, $create_authors_table)) $response['authors_table_issue'] = 'authors table not created';
                if(!mysqli_query($new_connection, $create_publish_table)) $response['publish_table_issue'] = 'publish table not created';

                //echo json_encode($response);
            }
        }
        
    }
    $connection = mysqli_connect($database_host, $database_user, $database_password, $database_name);

?>