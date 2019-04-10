<?php
   header("Content-Type: text/html;charset=utf-8");
   require_once('db.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    <script type="text/javascript" src="jquery-3.3.1.js"></script>
    <script type="text/javascript" src="jquery.dataTables.js"></script>
    <script type="text/javascript" src="tablita.js"></script>   

    	

</head>

<body>
    <?php
        $sql = 'SELECT * FROM juiciosnew WHERE 1';
        $pdo_statement = $pdo_conn->prepare($sql);
        $pdo_statement->execute();
        $result = $pdo_statement->fetchAll();

    ?>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Procedimiento</th>
                <th>Actor</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            
            <?php
	        if(!empty($result)) { 
		        foreach($result as $row) {
	          ?>
	        <tr>
		        <td><?php echo $row['procedimiento']; ?></td>
		        <td><?php echo $row['actor']; ?></td>
		        <td><?php echo $row['f_resolucion']; ?></td>
	        </tr>
            <?php
		        }
	        }
	        ?>
            
        </tbody>
        <tfoot>
            <tr>
                <th>Procedimiento</th>
                <th>Actor</th>
                <th>Fecha</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>