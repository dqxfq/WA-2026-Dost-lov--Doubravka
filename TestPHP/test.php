<?php
$name = "";
$message = "";
$age =

if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
    $name = $_POST["my_name"];
    if($name == "dabi") {
        $message = "  Ahoj Dabi";
    }
    else {
        $message = "Neznám tě";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Test formuláře</h1>
<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur amet culpa minima iusto! Necessitatibus dolorem dignissimos eveniet ipsam est dolor eos, consectetur magni, modi, laborum ut praesentium. Dolore, impedit cumque!</p>
<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit, unde nostrum debitis voluptate aperiam dolores sunt nemo corporis ut, eos explicabo atque ab repellendus, culpa quidem modi illum officia adipisci?</p>
<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Enim doloremque eaque sed fugiat deserunt molestias facilis quod labore amet laboriosam eligendi quisquam obcaecati officiis, culpa, sequi velit facere error ex?</p>
<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi sapiente quam, perferendis ipsum officia voluptates at voluptate error ratione. Voluptas quos rem laborum, quam perferendis ipsum numquam velit libero consequatur.</p>
<form method = "post">
<input type="text" name= "my_name" placeholder = "Zadejte jméno">
<button type= "submit"> Odevzdat</button>

</form>
 
<p>
    <?php echo "Výstup"; echo $message ?>
</p>

</body>
</html>