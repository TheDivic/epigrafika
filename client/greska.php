<?php
session_start();
if(!isset($_SESSION['privilegije'])) {
    include 'headerNijeUlogovan.php';
}
else if($_SESSION['status'] === "aktivan") {
    include 'headerAktivan.php';

}
else if($_SESSION['status'] === "neaktivan") {
    include 'headerNeaktivan.php';

}
?>

<!-- ucitavanje kontrolera -->

<div class="container text-center" style="margin: 100px; " ng-cloak>
	<div class="row">
		<div class="col-sm-12">
			<h1>  {{ tr.greska404 }} </h1>
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>
