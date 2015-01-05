<?php include 'header.php'; ?>

<!-- ucitavanje kontrolera -->
<script src="static/scripts/registracija.js"></script>

<div class="container">
	<div ng-controller='registracijaController'>
		<h1> Registracija <br> <small> Polja oznacena sa * su obavezna!</small> </h1>
		<br/>
		<br/>
		<style> .textred{color:red;} .text-transparent{ color:transparent;} </style>
		
		<form class="form" name="registrationForm" method="get" action="">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label for="imeprezime" class="control-label">Ime i prezime: <span style="color:red">*</span></label>
						<input type="text" name="imeprezime" ng-model="imeprezime" class="form-control" id="imeprezime" ng-required="true" placeholder="Ime Prezime" required />
						<span class="text-transparent" ng-class="{textred:registrationForm.imeprezime.$error.required && registrationForm.imeprezime.$dirty}">
							Ovo polje je obavezno.
						</span>
					</div>
					<div class="form-group">
						<label for="email" class="control-label">Email:<span style="color:red">*</span></label>
						<input type="email" ng-model="email" name="email" ng-required="true" class="form-control" id="email" placeholder="primer@email.com">
						<span span class="text-transparent" ng-class="{textred: registrationForm.email.$dirty &&(registrationForm.email.$error.required || registrationForm.email.$error.email)}">
							Ovo polje je obavezno i mora biti formata primer@gmail.com
						</span>
					</div>
					<div class="form-group">
						<label for="institucija" class="control-label">Institucija:<span style="color:red">*</span></label>
						<input type="text" name="institucija" ng-model="institucija" ng-required="true" class="form-control" id="institucija" placeholder="Institucija">
						<span class="text-transparent" ng-class="{textred:registrationForm.institucija.$error.required && registrationForm.institucija.$dirty}">
							Ovo polje je obavezno.
						</span>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="user" class="control-label">Korisnicko ime:<span style="color:red">*</span></label>
						<input type="text" name="user" ng-model="user" ng-pattern="/[\w\d]+/" ng-required="true" class="form-control" id="user" placeholder="korisnickoIme (max 20 karaktera)">
						<span class="text-transparent" ng-class="{textred:registrationForm.user.$dirty && (registrationForm.user.$error.required || registrationForm.user.$error.pattern)}">
							Ovo polje je obavezno. Dozvoljeni su svi karakteri sem razmaka,; i =.
						</span>
					</div>
					<div class="form-group">
						<label for="pwd" class="control-label">Sifra:<span style="color:red">*</span></label>
						<input type="password" name="pwd" ng-model="pwd" ng-required="true" class="form-control" id="pwd" >
						<span class="text-transparent" ng-class="{textred:registrationForm.pwd.$dirty && registrationForm.pwd.$error.required}">
							Ovo polje je obavezno. 
						</span>
					</div>
					<div class="form-group">
						<label for="pwdR" class="control-label">Ponovite sifru:<span style="color:red">*</span></label>
						<input type="password" name="pwdR" ng-model="pwdR" ng-required="true" ng-keyup="same()" class="form-control" id="pwdR">
						<span class="text-transparent" ng-class="{textred:registrationForm.pwdR.$dirty && (registrationForm.pwdR.$error.required || sameR)}">
							Ovo polje je obavezno. 
						</span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="info" class="control-label">Dodatne informacije:</label>
						<textarea style="max-width:100%;" name="info" ng-maxLenght="45" class="form-control" rows="3" id="info"></textarea>
					`	<span class="text-transparent" ng-class="{textred:registrationForm.info.$dirty && registrationForm.info.$error.maxLenght}">
							Dozvoljeno je manje od 45 karaktera
						</span>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<button type="submit" class="btn btn-primary btn-block" ng-class="{'disabled':!registrationForm.$valid && sameR}" ng-enabled="!sameR && registrationForm.$valid">Registruj se </button>
				</div>
			</div>
		</form>
	</div>	
</div>

<br/> <br/>
<?php include('footer.php'); ?>
