<body>
   <form action="resol.php" method="post">
      <label type="label"> INSERTAR QUERY : </label>
      <input type="text" name="sql"></input>
      <input type="submit"></input>
   </form>

</body>

<?php

function displayTable($sql){

 echo "<table border=0 cellpadding=0 cellspacing=0 width=204 style='border-collapse:
 collapse;table-layout:fixed;width:153pt'>" ;
  echo "<col width=204 style='mso-width-source:userset;mso-width-alt:7253;width:153pt'>";
  echo "<tr height=19 style='height:14.4pt'>";
   echo "<td height=19 width=204 style='height:14.4pt;width:153pt'>Click para
  descargar la resoluci&oacute;n</td>";
  echo "</tr>";
  echo "<tr height=19 style='height:14.4pt'>";
   echo "<td height=19 class=xl65 style='height:14.4pt'>";
 
   echo "<a  href='file:///sadadicom/adicom/dgr/DGR-B-10-2014-R-09-035.pdf' >DGR-B-10-2014-R-09-035</a></td>";

  echo "</tr>";

 echo "</table>";

}
if(empty($_POST) || $_POST["sql"] == ""){
     DIE("");
 }
$sql = $_POST["sql"];
echo $sql;
displayTable($sql);
?>