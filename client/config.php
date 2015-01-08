<?php include 'header-admin.php'; ?>
<div class="container">
	<h2>Konfiguracija sajta</h2>
	<form class="form-horizontal" role="form">
	<class="row">
		<div class="form-group">
			<label for="selectPag" class="col-sm-4 control-label">Broj rezultata po strani</label>
			<div class="col-sm-3">
				<select class="form-control" id="selectPag">
					<option>5</option>
					<option selected>10</option>
					<option>15</option>
					<option>20</option>
					<option>30</option>
					<option>40</option>
					<option>50</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="selectFoto" class="col-sm-4 control-label">Maksimalan broj fotografija</label>
			<div class="col-sm-3">
				<select class="form-control" id="selectFoto">
					<option>5</option>
					<option selected>10</option>
					<option>15</option>
					<option>20</option>
					<option>30</option>
					<option>40</option>
					<option>50</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="selectDoc" class="col-sm-4 control-label">Broj dokumenata uz bibliografski podatak</label>
			<div class="col-sm-3">
				<select class="form-control" id="selectDoc">
					<option>5</option>
					<option selected>10</option>
					<option>15</option>
					<option>20</option>
					<option>30</option>
					<option>40</option>
					<option>50</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group">
		<div class="col-sm-3 col-sm-offset-2">
			<button type="submit" class="btn btn-success btn-block" > Sacuvaj </button>
		</div>
		<div class="col-sm-3">
			<button type="reset" class="btn btn-primary btn-block" > Ponisti </button>
		</div>
		</div>
	</div>
  </form>

</div>
<!-- podesavanje broj rezultata po strani (podrazumevano 10)
– broj fotografija koje se mogu prikaciti uz objekat (podrazumevano 10)
– broj dokumenata koji se mogu prikaciti uz bibliografski podatak (podrazumevano 10) -->


<?php include 'footer.php'; ?>