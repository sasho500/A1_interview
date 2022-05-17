<?php
session_start();
$connection = mysqli_connect('localhost', 'root', "", 'a1_interview');
$color = null;

if(!empty($_POST["number"]) && array_key_exists('number', $_POST)) {

    $number = +$_POST["number"];
    $query = "  SELECT *
FROM colors
WHERE (start_index<=$number  AND  $number<=end_index) OR (start_index>=$number  AND  $number>=end_index) ";
    $result = mysqli_query($connection, $query);
    $userResult = $result->fetch_assoc();
    if(!empty($userResult['color'])) {

        $color = $userResult['color'];
    }
 else  {
     $color="No color diapason found";
 }
}
if(!empty($_POST["start_index"]) && array_key_exists("start_index", $_POST)) {
    $color_from_input=$_POST["color"];
    $start = $_POST["start_index"];
    $end = $_POST["end_index"];


    $query = "INSERT INTO colors ( color, start_index, end_index )
VALUES ('$color_from_input', '$start','$end' )";
    if (mysqli_query($connection, $query)) {
        echo "New record created successfully";
        echo "<br/>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
        echo "<br/>";
    }

}




if(!empty($_POST["change_start"]) && array_key_exists("change_start", $_POST))
{
 $color_id=+$_POST["color"];

 $change_start=$_POST["change_start"];
 $change_end=$_POST["change_end"];

 $query="UPDATE colors SET start_index='$change_start', end_index='$change_end' WHERE id= $color_id ";
    if ($connection->query($query)) {
        echo " successfully change Diapason";
        echo "<br/>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
        echo "<br/>";
    }
}



$query_all_colors = "  SELECT *
FROM colors
";
$result_get_all = mysqli_query($connection, $query_all_colors );
$result_all_colors =[];
while ($row = mysqli_fetch_array($result_get_all)) {
    $result_all_colors[]=$row;
}







$get_url_task = null;
if($_GET) {
    $get_url_task = (+$_GET["task"]);

}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width = device - width, initial - scale = 1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href=" ../styles.css">
</head>
<body>

<a href="?task=0" class="btn btn-<?php echo $get_url_task ? "default" : "primary" ?>">Enter number</a>
<a href="?task=1" class="btn btn-<?php echo $get_url_task==1 ? "primary" : "default" ?>">Enter new color</a>
<a href="?task=2" class="btn btn-<?php echo $get_url_task==2 ? "primary" : "default" ?>">Edit diapason</a>
<?php if(!$get_url_task) { ?>
    <form action=UI.php method="post">


        <div class="container">
            <label for="uname"><b>Enter number</b></label>
            <input type="text" placeholder="Enter number" name="number">

            <label for="psw"><b>The color is :</b></label>
            <input type="text" value="<?php echo $color ? $color : "hello" ?>" readonly="readonly">

            <button>Submit</button>

        </div>

    </form>
    <?php
} ?>

<?php if($get_url_task == 1) {
?>

<form action=UI.php method="post">


    <div class="container">


        <br/>
        <label for="uname"><b> Add new Color</b></label>
        <input type="text" placeholder="Start of Color Diapason" name="color">

        <label for="uname"><b> Start of Color Diapason</b></label>
        <input type="text" placeholder="Start of Color Diapason" name="start_index">

        <label for="uname"><b> End</b></label>
        <input type="text" placeholder="End of Color Diapason" name="end_index">


        <button>Submit</button>

    </div>

</form>
<?php
} ?>
<?php if($get_url_task==2) {
    ?>
    <form action=UI.php method="post">


        <div class="container">
            <label for="lang">Color</label>
            <select name="color" id="lang">

              <?php foreach($result_all_colors as $key=>$value){ ?>
                <option value="<?php echo $value[0]?>" ><?php echo $value[1]?></option>
                <?php }?>
            </select>
<br/>
            <label for="uname"><b> Start of Color Diapason</b></label>
            <input type="text" placeholder="Start of Color Diapason" name="change_start">

            <label for="uname"><b> End</b></label>
            <input type="text" placeholder="End of Color Diapason" name="change_end">


            <button>Submit</button>

        </div>

    </form>
    <?php
} ?>


</body>
</html>
