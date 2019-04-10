<?php
header("Content-Type: text/html;charset=utf-8");

define("ROW_PER_PAGE",10);
require_once('db.php');
?>

<!DOCTYPE html>
<html  lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="tabla.css">	
</head>
<body>
<?php	
	$search_keyword = '';
	if(!empty($_POST['search']['keyword'])) {
		$search_keyword = $_POST['search']['keyword'];
	}
	$sql = 'SELECT * FROM juiciosnew WHERE procedimiento LIKE :keyword OR actor LIKE :keyword OR f_resolucion LIKE :keyword ORDER BY actor ';
	
	/* Pagination Code starts */
	$per_page_html = '';
	$page = 1;
	$start=0;
	if(!empty($_POST["page"])) {
		$page = $_POST["page"];
		$start=($page-1) * ROW_PER_PAGE;
	}
	$limit=" limit " . $start . "," . ROW_PER_PAGE;
	$pagination_statement = $pdo_conn->prepare($sql);
	$pagination_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
	$pagination_statement->execute();

	$row_count = $pagination_statement->rowCount();
	if(!empty($row_count)){
		$per_page_html .= "<div style='text-align:center;margin:20px 0px;'>";
		$page_count=ceil($row_count/ROW_PER_PAGE);
		if($page_count>1) {
			for($i=1;$i<=$page_count;$i++){
				if($i==$page){
					$per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page current" />';
				} else {
					$per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page" />';
				}
			}
		}
		$per_page_html .= "</div>";
	}
	
	$query = $sql.$limit;
	$pdo_statement = $pdo_conn->prepare($query);
	$pdo_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();
?>
<h3>Demo PHP Search and Pagination using PDO</h3>
<form name='frmSearch' action='' method='post'>
<div style='text-align:right;margin:20px 0px;'><input type='text' name='search[keyword]' value="<?php echo $search_keyword; ?>" id='keyword' maxlength='25'></div>
<table class='tbl-qa'>
  <thead>
	<tr>
	  <th class='table-header' width='20%'>Procedimiento</th>
	  <th class='table-header' width='50%'>Autor</th>
	  <th class='table-header' width='10%'>Fecha</th>
	</tr>
  </thead>
  <tbody id='table-body'>
	<?php
	if(!empty($result)) { 
		foreach($result as $row) {
	?>
	  <tr class='table-row'>
		<td><?php echo $row['procedimiento']; ?></td>
		<td><?php echo $row['actor']; ?></td>
		<td><?php echo $row['f_resolucion']; ?></td>
	  </tr>
    <?php
		}
	}
	?>
  </tbody>
</table>
<?php echo $per_page_html; ?>
</form>
</body>
</html>