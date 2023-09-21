<?php

    include "../model/news_manager.php";
    include "../model/published_manager.php";
    include "../model/news_class.php";
    include "../model/publish_class.php";
    include "../model/authors_manager.php";

    $id_news = $_POST['id_news'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $id_author = $_POST['id_author'];

    $action = $_POST['action'];

    $news = new News($id_news, $title, $content);

    $newsManager = new NewsManager();
    $publish = new Publish($id_news, $id_author, '', '', 0, 0);
    $publishManager = new PublishedManager();

    if($action == 'addNews'){

        $newsManager->addNews($news);
        $publishManager->addPublish($publish);

    }elseif($action == 'getNewsList'){

        $newsManager->getList();

    }elseif($action == 'deleteNews'){

        $newsManager->deleteNews($id_news);
        $publishManager->deleteCoupleAuthorNews($id_news, $id_author);

        echo ('deleted successfully ');

    }elseif($action == 'updateNews'){

        $newsManager->updateNews($news);
        $publishManager->updatePublish($publish);

        echo ('updated successfully ');

    }elseif($action == 'publishNews'){

        $publish->publish($id_news, $id_author);

    }elseif($action == 'unPublishNews'){

        $publish->unPublish($id_news, $id_author);

    }elseif($action == 'preUpdateNews'){

        $newsManager->getUnique($id_news, $id_author);

    }
    elseif($action == 'getAuthors'){

        $authorManager = new AuthorsManager();
        $authorManager->getList();

    }
    elseif($action == 'getUnique'){

        $newsManager->getUnique($id_news, $id_author);

    }


?>