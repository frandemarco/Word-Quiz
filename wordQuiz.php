<?php
$fileName="allwords.txt";
if($_POST["score"])
{
    $score = $_POST["score"];
    $totalQuestions = $_POST["totalQuestions"];
}
else{
    $score = 0;
    $totalQuestions = 0;
}
if(isset($_POST["guess"]))
{
    $guess=$_POST["guess"];
    $correct_choice=$_POST["correct_answer"];
    if($guess==$correct_choice){
        $score++;
    }
    $totalQuestions++;
}

function read_words($fileName)
{
$parts_of_speech = array("noun", "verb", "adjective");
shuffle($parts_of_speech);
$answer_part=array_pop($parts_of_speech);
$lines=file($fileName);
shuffle($lines);
$choices= array();
while(count($choices)<5){
    $line =array_pop($lines);
    list($word, $part,$defn)=explode("\t",$line);
    if ($part=$answer_part){
        $choices[]=$line;
    }
    }
    return $choices;
}
var_dump($_POST);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="quizStyle.css">
    <title>Document</title>
</head>
<body>

<?php
$choices=read_words("allwords.txt");
$randomIndex=rand(0,count($choices)-1);
$correctChoice=$choices[$randomIndex];
list($correct_answer,$correct_part,$correct_defn)=explode("\t",$correctChoice);

?>
<h2>Score: <?= $score ?> / <?= $totalQuestions?></h2>
<h2><?=$correct_part?> - <?=$correct_defn?></h2>
<?php
if(isset($_POST["guess"]))
{
    if($guess==$correct_choice)
    {
    ?>
        <h2 class="correct">Correct!</h2>
    <?php
    }
    else{
    ?>
        <h2 class="incorrect">Incorrect, the correct answer was <?= $correct_choice?></h2>
    <?php
    }
}
?>
<form action="wordQuiz.php" method="post">
<ol>
    <?php
    foreach ($choices as $choice){
        list($word, $part,$defn)=explode("\t",$choice);

    ?>
        <li>
            <label>
                <input type="radio" name="guess" value="<?=$word?>"> <?= $word ?>
            </label>
        </li>
    <?php
    }

    ?>
</ol>
    <input type="hidden" name="correct_answer" value="<?=$correct_answer?>">
    <input type="hidden" name="score" value="<?=$score?>">
    <input type="hidden" name="totalQuestions" value="<?=$totalQuestions?>">
    <input type="submit">
</form>
</body>
</html>
