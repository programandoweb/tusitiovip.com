<?php
/*
	DESARROLLO Y PROGRAMACIÓN
	PROGRAMANDOWEB.NET
	LCDO. JORGE MENDEZ
	info@programandoweb.net
*/
//pre($campo);
?>
<?php
	//$campo=$data["campos"];
	if(!empty($this->Breadcrumb)){
		echo btn_add("NL",false,false,false);
	}
?>
<div class="container  mt-5">
	<div class="row justify-content-md-center">
		<div class="col">
			<div class="row filters uniformidad">
				<div class="col-md-12">
         	<table id="perfiles" class="display" style="width:100%">
              <thead>
                  <tr>
                  	<?php
											echo columnas($campo);
										?>
                  </tr>
              </thead>
              <tfoot>
                  <tr>
                     <?php
										 	echo columnas($campo);
											?>
                  </tr>
              </tfoot>
          </table>
				</div>
			</div>
		</div>
	</div>
</div>
