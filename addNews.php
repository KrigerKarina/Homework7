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
    $sql = "SELECT `news`.`caterogy_id`, `categories`.`name`
			FROM `news` 
			LEFT JOIN `categories`
			ON `news`.`caterogy_id`=`categories`.`id`
			WHERE `news`.`caterogy_id` IS NOT NULL
			GROUP BY `news`.`caterogy_id`";
    $rows = $pdo->query($sql);
	$categories = $rows->fetchAll(PDO::FETCH_KEY_PAIR);
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		 $indexCategory = $_POST['categories'];
		 $category = $categories[$indexCategory];
	}
?>

<style>
	.error{
		color: red;
	}
</style>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Добавление новости</title>
</head>
<body>
	<form method="post" onsubmit="return false;" id='textForm'>
		<div>
			<div>Название новости:</div>
			<input type="text" id="title" name="title">
		</div>
		<div class="error_title error"></div>
		<br>
		<div>
			<div>Дата публикации:</div>
			<input type="date" id="publish_date" name="publish_date">
		</div>

		<br>
		<div>
			<div>Статус:</div>
			<input type="radio" name="status" value="опубликована">Опубликована<br>
			<input type="radio" name="status" value="черновик">Черновик 
		</div>
		<br>
		<div>
			<div>Раздел новости:</div>
			<select name="categories" id="categories">
				<option disabled selected>Выберете категорию из списка..</option>
				<?php foreach($categories as $key => $value) { ?>
			      <option value="<?php echo $key ?>"><?php echo $value ?></option>
			    <?php }?>
			</select>
		</div>
		<br>
		<div>
			<div>Текст новости:</div>
			<textarea name="body" id="body" cols="30" rows="10"></textarea>
		</div>
		<div class="error_body error"></div>
		<br>
		<div>
			<div>Автор:</div>
			<input type="text" id="author" name="author">
		</div>
			<div class="error_author error"></div>
		<br>
		<button type="submit" name="btn" id="btn">Добавить новость</button>
	</form>
	<div class="result"></div>
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<script>
            $(function(){
                $('#btn').click(function(){
                    
                    $.ajax({
                        url: 'viewNews.php',
                        type: 'POST',
                        data: $('#textForm').serialize(),
                        dataType: 'json',
                        success: function(responce)
                        {
                       		$('.error_title').html(responce.errors['title']);  
                       		$('.error_body').html(responce.errors['body']); 
                       		$('.error_author').html(responce.errors['author']);
                        },
                        error: function(){
                        }
                    })
                })
            })
</script>
