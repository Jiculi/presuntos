<?php
    require_once 'database.php';
    require 'libreria.php';
    $db = new libreria();
    $notificados = $db->getJCAcontrol01();
    $sentencia = $db->getJCAcontrol02();
?>

<!DOCTYPE html>
<html lang="es">  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Juicios Contenciosos Administrativos</title>
</head>

<main>
    <div class="table-wrapper" tabindex="0">
      <p>Juicios contenciosos administrativos notificados</p>
      <table >
        <thead>
          <tr>
            <th>Resultado</th>
            <th>Juicios</th>
            <th>falta</th>
            <th>ceros</th>
            <th>Reporte</th>
            <th>2018</th>
            <th>Ene</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Abr</th>
            <th>May</th>
            <th>Jun</th>
            <th>Jul</th>
            <th>Ago</th>
            <th>Sep</th>
            <th>Oct</th>
            <th>Nov</th>
            <th>Dic</th>
            <th>2019</th>
          </tr>
        </thead>
        <tbody>
            <?php 	foreach ($notificados as $row => $r) { ?>
            <tr>
                <td><?php echo $r['resultado']; ?></td>
                <td class="numeric"><?php echo $r['juicios']; ?></td>
                <td class="numeric"><?php echo ($r['falta'] == "0"  ? '-': $r['falta'] ); ?></td>
                <td class="numeric"><?php echo ($r['ceros'] == "0"  ? '-': $r['ceros'] ); ?></td>
                <td class="numeric"><?php echo ($r['Reporte'] == "0"  ? '-': $r['Reporte'] ); ?></td>
                <td class="numeric"><?php echo ($r['2018'] == "0"  ? '-': $r['2018'] ); ?></td>
                <td class="numeric"><?php echo ($r['Ene'] == "0"  ? '-': $r['Ene'] ); ?></td>
                <td class="numeric"><?php echo ($r['Feb'] == "0"  ? '-': $r['Feb'] ); ?></td>
                <td class="numeric"><?php echo ($r['Mar'] == "0"  ? '-': $r['Mar'] ); ?></td>
                <td class="numeric"><?php echo ($r['Abr'] == "0"  ? '-': $r['Abr'] ); ?></td>
                <td class="numeric"><?php echo ($r['May'] == "0"  ? '-': $r['May'] ); ?></td>
                <td class="numeric"><?php echo ($r['Jun'] == "0"  ? '-': $r['Jun'] ); ?></td>
                <td class="numeric"><?php echo ($r['Jul'] == "0"  ? '-': $r['Jul'] ); ?></td>
                <td class="numeric"><?php echo ($r['Ago'] == "0"  ? '-': $r['Ago'] ); ?></td>
                <td class="numeric"><?php echo ($r['Sep'] == "0"  ? '-': $r['Sep'] ); ?></td>
                <td class="numeric"><?php echo ($r['Oct'] == "0"  ? '-': $r['Oct'] ); ?></td>
                <td class="numeric"><?php echo ($r['Nov'] == "0"  ? '-': $r['Nov'] ); ?></td>
                <td class="numeric"><?php echo ($r['Dic'] == "0"  ? '-': $r['Dic'] ); ?></td>
                <td class="numeric"><?php echo ($r['2019'] == "0"  ? '-': $r['2019'] ); ?></td>
            </tr>
            <?php } ?>
        </tbody>
      </table>

      <p>Con fecha de sentencia</p>
      <table >
        <thead>
          <tr>
            <th>Resultado</th>
            <th>Juicios</th>
            <th>falta</th>
            <th>ceros</th>
            <th>Reporte</th>
            <th>2018</th>
            <th>Ene</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Abr</th>
            <th>May</th>
            <th>Jun</th>
            <th>Jul</th>
            <th>Ago</th>
            <th>Sep</th>
            <th>Oct</th>
            <th>Nov</th>
            <th>Dic</th>
            <th>2019</th>
          </tr>
        </thead>
        <tbody>
            <?php 	foreach ($sentencia as $row => $r) { ?>
            <tr>
                <td><?php echo $r['resultado']; ?></td>
                <td class="numeric"><?php echo $r['juicios']; ?></td>
                <td class="numeric"><?php echo ($r['falta'] == "0"  ? '-': $r['falta'] ); ?></td>
                <td class="numeric"><?php echo ($r['ceros'] == "0"  ? '-': $r['ceros'] ); ?></td>
                <td class="numeric"><?php echo ($r['Reporte'] == "0"  ? '-': $r['Reporte'] ); ?></td>
                <td class="numeric"><?php echo ($r['2018'] == "0"  ? '-': $r['2018'] ); ?></td>
                <td class="numeric"><?php echo ($r['Ene'] == "0"  ? '-': $r['Ene'] ); ?></td>
                <td class="numeric"><?php echo ($r['Feb'] == "0"  ? '-': $r['Feb'] ); ?></td>
                <td class="numeric"><?php echo ($r['Mar'] == "0"  ? '-': $r['Mar'] ); ?></td>
                <td class="numeric"><?php echo ($r['Abr'] == "0"  ? '-': $r['Abr'] ); ?></td>
                <td class="numeric"><?php echo ($r['May'] == "0"  ? '-': $r['May'] ); ?></td>
                <td class="numeric"><?php echo ($r['Jun'] == "0"  ? '-': $r['Jun'] ); ?></td>
                <td class="numeric"><?php echo ($r['Jul'] == "0"  ? '-': $r['Jul'] ); ?></td>
                <td class="numeric"><?php echo ($r['Ago'] == "0"  ? '-': $r['Ago'] ); ?></td>
                <td class="numeric"><?php echo ($r['Sep'] == "0"  ? '-': $r['Sep'] ); ?></td>
                <td class="numeric"><?php echo ($r['Oct'] == "0"  ? '-': $r['Oct'] ); ?></td>
                <td class="numeric"><?php echo ($r['Nov'] == "0"  ? '-': $r['Nov'] ); ?></td>
                <td class="numeric"><?php echo ($r['Dic'] == "0"  ? '-': $r['Dic'] ); ?></td>
                <td class="numeric"><?php echo ($r['2019'] == "0"  ? '-': $r['2019'] ); ?></td>
            </tr>
            <?php } ?>
        </tbody>
      </table>




    </div>
  
  </main>

<style>
/* basic styles */
body, input, textarea, select, option, button, label {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Droid Sans", "Helvetica Neue", sans-serif;
  font-size: 100%;
}
main {
    padding: 1em;
  }
  
  .table-wrapper {
    overflow: auto;
      max-width: 100%;
      background:
          linear-gradient(to right, white 30%, rgba(255,255,255,0)),
          linear-gradient(to right, rgba(255,255,255,0), white 70%) 0 100%,
          radial-gradient(farthest-side at 0% 50%, rgba(0,0,0,.2), rgba(0,0,0,0)),
          radial-gradient(farthest-side at 100% 50%, rgba(0,0,0,.2), rgba(0,0,0,0)) 0 100%;
      background-repeat: no-repeat;
      background-color: white;
      background-size: 40px 100%, 40px 100%, 14px 100%, 14px 100%;
    background-position: 0 0, 100%, 0 0, 100%;
      background-attachment: local, local, scroll, scroll;
  }
  
  tr {
    border-bottom: 1px solid;
  }
  
  th {
    background-color: #555;
    color: #fff;
    white-space: nowrap;
  }
  
  th,
  td {
    text-align: left;
    padding: 0.5em 1em;
  }
  
  .numeric {
    text-align: right;
  }
  
  p {
    text-align: left;
    margin-top: 1em;
    font-style: italic;
  }

  tr:nth-child(odd) {
  background-color: #eee;
}

</style>