<?php
session_start();
if(isset($_SESSION['privilegije'])) {
    header('Location: ../client/index.php');
    exit;
}
include 'headerNijeUlogovan.php'; ?>

<!-- ucitavanje kontrolera -->

<div class="container text-center" style="margin: 100px; " ng-cloak>
	<div class="row">
		<div class="col-sm-12">
			<h1>  {{ tr.dobrodosli }} 
                        <a href="registracija.php" class=" btn-link">{{tr.ovde}}</a>
                        </h1>
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>
