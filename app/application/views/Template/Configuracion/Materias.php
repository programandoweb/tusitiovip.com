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
	if(!empty($this->Breadcrumb)){
		echo btn_add();
	}
?>
<div class="container">
	<div class="row justify-content-md-center">
    	<div class="col">
        	<div class="row filters">
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