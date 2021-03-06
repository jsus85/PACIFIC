
<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="noindex" />

    <meta name="googlebot" content="noindex">

    <title>PACIFIC LATAM - Reporte Horas</title>



   <!-- Bootstrap core CSS -->

    <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet">

    <!--external css-->

    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/zabuto_calendar.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/gritter/css/jquery.gritter.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/lineicons/style.css">    

    

    <!-- Custom styles for this template -->

    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">

    <link href="<?php echo base_url();?>assets/css/style-responsive.css" rel="stylesheet">



    <script src="<?php echo base_url();?>assets/js/chart-master/Chart.js"></script>

    <link href="<?php echo base_url();?>assets/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />

 

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>

      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>

      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <![endif]-->

 <!-- daterange picker -->
<style type="text/css">
  .input-group{	width: 50%;}
 
</style>
   

  </head>



  <body>



  <section id="container" >

      <!-- **********************************************************************************************************************************************************

      TOP BAR CONTENT & NOTIFICATIONS

      *********************************************************************************************************************************************************** -->

      <!--header start-->

      <?php $this->load->view('include/header.php');?>

      <!--header end-->

     
      <!-- **********************************************************************************************************************************************************

      MAIN SIDEBAR MENU

      *********************************************************************************************************************************************************** -->

      <!--sidebar start-->
     
      <?php $this->load->view('include/left.php');?>

      <!--sidebar end-->

      

      <!-- **********************************************************************************************************************************************************

      MAIN CONTENT

      *********************************************************************************************************************************************************** -->

      <!--main content start-->

      <section id="main-content">

          <section class="wrapper">



              <div class="row">

                  <div class="col-lg-12 main-chart">

                    <form id="form" name="form" class="form-horizontal style-form" method="post" action="<?php echo base_url('index.php/horas');?>">

                     <!--Leyenda-->

                  
<?php           


      //  foreach ($tareas_empleados as $value) {
?>
 <!--                
      
      <button style="margin-bottom:10px;" type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="<?php echo $value->descripcion;?>"><?php echo $value->nombres;?></button>&nbsp;&nbsp;-->
<?php
         //             }// foreach
                  
?>  


<br ><br >

<?php 

      // llamar al modelo
      $ci = &get_instance();
      $ci->load->model("Horas_model");

          $primer_dia = mktime();

          $ultimo_dia = mktime();

          while(date("w",$primer_dia)!=1){

            $primer_dia -= 3600;

          }

          while(date("w",$ultimo_dia)!=0){

            $ultimo_dia += 3600;

          }

          $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
          $fecha1 = trim((isset($fecha_inicial))?$fecha_inicial:date("Y-m-d",$primer_dia));
          $fecha2 = trim( (isset($fecha_final))? $fecha_final:date("Y-m-d",$ultimo_dia));
?>
            <div class="form-group">
            <label>Seleccionar Días:</label>
            <div class="input-group">
              <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right"  id="reservation" value="<?php echo $fecha1;?> - <?php echo $fecha2;?>" name="fechas"/>
            </div><!-- /.input group -->
            </div><!-- /.form group -->
            <button type="submit"  class="btn btn-primary">Buscar</button>      
            <!-- Leyenda-->

                     <table class="table table-striped table-advance table-hover">                            

                           <thead>
                              <tr>
                                  <th><i class="fa fa-tags"></i> Tareas</th>
                                  <?php for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){ ?>
                                  <th><?php echo substr($dias[date('N', strtotime($i))],0,3);?>. <?php echo substr($i,8,5);?></th>
                                  <?php }?>
                                  <td><i class="fa fa-tags"></i> <b>TOTAL</b><td>
                              </tr>
                              </thead>                       
                              <tbody>
                           <?php        


                        $array_sumaVertical   = array();      

                        $array_sumaHorizontal = array();      

                        

                        foreach ($tareacliente_empleados as $value) {

                    ?>

                              <tr> 

                                  <td>
                                    <a title="Limpiar Horas" onclick="limpiarHorasxFilas('<?php echo $value->id;?>','<?php echo $this->session->userdata('idEmpleado');?>','<?php echo $i;?>')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a> 
                                    <?php echo $value->nombrecliente;?> - <a title="<?php echo $value->descripcion;?>" class="tooltips" data-placement="right"  style="cursor:pointer" data-original-title="<?php echo $value->descripcion;?>"><?php echo $value->nombretarea;?></a>
                                  </td>
                                  
                            <?php

								$cantidadHoras                = "";
								$sumaTotalVertical_Horitonzal = 0;

								for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){

								// tarea - usuario - fecha
								$cantidadHoras = $ci->Horas_model->consultar_horas($value->id,$this->session->userdata('idEmpleado'),$i);                               
								// sumas Vertical y Horizontal  
								$array_sumaHorizontal['sumaHorizontal'][$value->id] += $cantidadHoras[0]['hora'];
								$array_sumaVertical['sumaVertical'][$i]             += $cantidadHoras[0]['hora'];

                                
                             ?>

                              <td>
                                <select class="filaTareas_<?php echo $value->id;?>"  onchange="guardarHoras(this.value,'<?php echo $value->id;?>','<?php echo $this->session->userdata('idEmpleado');?>','<?php echo $i;?>')" id="<?php echo $i;?>_<?php echo $value->id;?>">

                                  <?php
                                      foreach ($horas as $value2 =>$idx) {
                                  ?>
										<option <?php if($cantidadHoras[0]['hora']==$value2){?> selected <?php } ?> value="<?php echo $value2;?>"><?php echo $idx;?>
										</option>
                                  <?php }// FOREACH?>
                                  </select>
                                  </td>

                                  <?php 

                                      }// FOR DE DIAS
                                  ?>

                          
                            <!-- Suma Totales Horizontal -->                          
                            <td id="Tarea<?php echo $value->id;?>" align="center" >
                              <b>
                                  <?php echo toHours($array_sumaHorizontal['sumaHorizontal'][$value->id],1);?>
                              </b>

                            </td>

                            <!-- Suma Totales Horizontal -->                                  

                          



                            </tr>







                               <?php } // while tareas ?>

                               

                               <!-- Suma ToTales Vertical -->

                                <tr>                                

                                      <td class="sumVert">

                                          <i class="fa fa-tags"></i> TOTAL:

                                      </td>

                                <?php for($x=$fecha1;$x<=$fecha2;$x = date("Y-m-d", strtotime($x ."+ 1 days"))){ ?>
                                <td id="fec<?php echo $x;?>" align="center" class="hidden-phone">                                  
                                  <b><?php echo toHours($array_sumaVertical['sumaVertical'][$x],1);?></b>
                                </td>
                                <?php }?>     



                                  <!--Suma Totales-->

                                  <td id="SumaTotalVerticalHorizontal" align="center">

                                    <b>

                                    <?php

                                     

                                        $TotalMinutos =  (array_sum($array_sumaVertical['sumaVertical'])+array_sum($array_sumaHorizontal['sumaHorizontal']));



                                        echo toHours($TotalMinutos,1);



                                      ?>

                                    </b>

                                  </td>

                                  <!--Suma Totales-->
                                </tr>
                              <!-- Suma Totales Vertical -->
                              </tbody>
                          </table>       

           

                    </form>



                  </div><!-- /col-lg-9 END SECTION MIDDLE -->                   

              </div><!-- /row -->

              

          </section>

      </section>



      <!--main content end-->
      <!--footer start-->
       <?php $this->load->view('include/footer.php');?>
      <!--footer end-->
  </section>


    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.sparkline.js"></script>
    <!--common script for all pages-->
    <script src="<?php echo base_url();?>assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/gritter-conf.js"></script>
    <!-- InputMask -->
    <script src="<?php echo base_url();?>assets/js/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <!-- date-range-picker -->
    <script src="<?php echo base_url();?>assets/js/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- Page script -->
    <script type="text/javascript">

	 


      // ---------------- Limpiar horas por fila -------
      // ------------------------------------------------------
      function limpiarHorasxFilas(tareasConfig,usuario,fecha){

          var fecha1 =  $('#reservation').val().substring(0,10);// fecha1 
          var fecha2 =  $('#reservation').val().substring(13,23);// fecha2
            
                  
              $(".filaTareas_"+tareasConfig).each(function() {
                  this.value=0;
              });
            


          if(confirm('¿Desea limpiar? '))   {

			        // obtiene texto plano o html
			        $.post('<?php echo base_url(); ?>'+'index.php/horas/editHourforRow', {tarea : tareasConfig,usuario : usuario, fecha1:fecha1, fecha2:fecha2}, function(resp) {
			          
			            var fields = resp.split("*");

			            $('#fec'+fecha).html(fields[0]);//Vertical
			            $('#Tarea'+tareasConfig).html(fields[1]);//horizontal
			            $('#SumaTotalVerticalHorizontal').html(fields[2]);//suma total


			            $.gritter.add({
			              // (string | mandatory) the heading of the notification
			              title: 'MENSAJE:',
			              // (string | mandatory) the text inside the notification
			              text: 'Registros limpiado.'
			            });
			             
			          });// End: ajax


          }      	
      }



      // Guardar la cantidad de hora
     function guardarHoras(valorHora,tarea,usuario,fecha){


       var fecha1 =  $('#reservation').val().substring(0,10);// fecha1 
       var fecha2 =  $('#reservation').val().substring(13,23);// fecha2

        // obtiene texto plano o html
        $.post('<?php echo base_url(); ?>'+'index.php/horas/add', { hora : valorHora,tarea : tarea,usuario : usuario, fecha:fecha,fecha1:fecha1, fecha2:fecha2}, function(resp) {

            var fields = resp.split("*");

            $('#fec'+fecha).html(fields[0]);//Vertical
            $('#Tarea'+tarea).html(fields[1]);//horizontal
            $('#SumaTotalVerticalHorizontal').html(fields[2]);//suma total


            $.gritter.add({
              // (string | mandatory) the heading of the notification
              title: 'MENSAJE:',
              // (string | mandatory) the text inside the notification
              text: 'Registro guardado correctamente.'
            });
    
         
          });// End: ajax
      

     }// End Function 



            $(function() {

               

                //Datemask dd/mm/yyyy
                $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                //Datemask2 mm/dd/yyyy
                $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
                //Money Euro
                $("[data-mask]").inputmask();
                //Date range picker
                $('#reservation').daterangepicker({format: 'YYYY-MM-DD'});       
                //Date range picker with time picker
                $('#reservationtime').daterangepicker({timePicker: false, timePickerIncrement: 7, format: 'YYYY-MM-DD'});               
                //Date range as a button
                $('#daterange-btn').daterangepicker(
                        {

                            ranges: {

                                'Today': [moment(), moment()],

                                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],

                                'Last 7 Days': [moment().subtract('days', 6), moment()],

                                'Last 30 Days': [moment().subtract('days', 29), moment()],

                                'This Month': [moment().startOf('month'), moment().endOf('month')],

                                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]

                            },



                            startDate: moment().subtract('days', 29),

                            endDate: moment()

                        },



                        function(start, end) {

                            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

                        }



                );



                //iCheck for checkbox and radio inputs

                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({

                    checkboxClass: 'icheckbox_minimal',

                    radioClass: 'iradio_minimal'

                });

                //Red color scheme for iCheck

                $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({



                    checkboxClass: 'icheckbox_minimal-red',

                    radioClass: 'iradio_minimal-red'

                });

                //Flat red color scheme for iCheck

                $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({

                    checkboxClass: 'icheckbox_flat-red',

                    radioClass: 'iradio_flat-red'

                });



                //Colorpicker

                $(".my-colorpicker1").colorpicker();







                //color picker with addon

                $(".my-colorpicker2").colorpicker();



                //Timepicker

                $(".timepicker").timepicker({

                    showInputs: false

                });

            });

        </script>	

	     

       <script type="application/javascript">

          $(document).ready(function () {
      

        

        

        

        function myNavFunction(id) {

            $("#date-popover").hide();

            var nav = $("#" + id).data("navigation");

            var to = $("#" + id).data("to");

            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);

        }

    </script>

  



  </body>

</html>

