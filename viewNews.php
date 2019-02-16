<?php 
    $host = 'localhost';
    $db   = 'News';
    $user = 'root';
    $pass = '';
    $charset = 'utf8';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);
    $title = $_POST['title'];
    $publish_date = $_POST['publish_date'];
    $status = $_POST['status'];
    $categories = $_POST['categories'];
    $body = $_POST['body'];
    $author =  $_POST['author'];
    $errors = [];

    $isValid = true;

    if (empty(trim($title))) 
    {
        $errors['title'] ="Данное поле должно быть заполнено";
        $isValid = false;
    }

      if (empty(trim($author))) 
    {
        $errors['author'] ="Данное поле должно быть заполнено";
        $isValid = false;
    }

    if (empty(trim($body))) 
    {
        $errors['body'] ="Данное поле должно быть заполнено";
        $isValid = false;
    }

    if($isValid)
    {
        $values = [ 'title'=>$title, 
                    'publish_date'=>$publish_date, 
                    'status'=>$status,
                    'categories'=>$categories,
                    'body'=>$body,
                    'author'=>$author
                ];
        $sql = "INSERT INTO news SET title = :title, 
                                     publish_date = :publish_date, 
                                     status = :status, 
                                     caterogy_id = :categories, 
                                     body = :body, 
                                     author = :author";
        $stm = $pdo->prepare($sql);
        $stm->execute($values);
    }
    echo json_encode(compact(['errors']));
?>
