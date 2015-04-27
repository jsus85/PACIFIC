<?php 
header('Content-Type: text/html; charset=UTF-8'); 
session_start();
include('validar.session.php');
include("model/functions.php");
$model       = new funcionesModel();
$Clientes    = $model->listarTablaGeneral("id,nombres","clientes"," where estado = 1  and id in (".$_SESSION['sClientes'].") order by nombres asc");

$extraer_periodistas = "";


$extraer_periodistas = explode(",", $_SESSION['idSelectPeriodistas']);
$array = array_values(array_diff($extraer_periodistas, array('')));

?>
<style type="text/css">
h4{	border: 1px solid #aaaaaa; background: #cccccc;  color: #222222;  font-weight: bold;  font-size: 14px;  border-radius: 5px;  padding: 5px;}
</style>
<h4>Crear Lista</h4>
<p>Ingrese los datos requeridos</p>

<p>Nombre de la Lista</p>
<p><input type="text" name="nombreLista" id="nombreLista" class="form-control" /></p>
<p>Cliente</p>

<p>
  <select id="clientesLista" name="clientesLista" class="form-control">
   <option value="0">[Seleccionar Cliente]</option>
      <?php for($i=0;$i<count($Clientes);$i++){?>
      <option <?php if($_POST['clientes'] == $Clientes[$i]["id"]){?>selected<?php }?> value="<?php echo $Clientes[$i]["id"];?>"><?php echo utf8_encode($Clientes[$i]["nombres"]);?></option>    
      <?php }?>
  </select>
</p>

<p>(<?php echo (isset($array))?count($array):'0';?>) Periodistas Seleccionados</p>
<p><button type="button" onclick="guardar_lista();" class="btn1 btn-primary">Enviar</button></p>