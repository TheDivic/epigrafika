<?php include 'header.php'; ?>

<!-- ucitavanje kontrolera -->
<script src="static/scripts/registracija.js"></script>

<div class="container">
	<div ng-controller='registracijaController'>
		<h1> {{tr.registracija}} <br> <small> {{tr.polje_zvezda}}</small> </h1>
		<br/>
		<br/>
		<form class="form" name="registrationForm" method="get" action="">
			<div class="row">
				<div class="col-sm-6">
					<div  class="col-sm-6">
						<label for="ime" class="control-label">{{tr.ime}}: <span style="color:red">*</span></label>
						<input type="text" name="ime" ng-model="ime" class="form-control" id="ime" ng-required="true" placeholder={{tr.pera_peric}} />
						<span class="text-transparent" ng-class="{textred:registrationForm.ime.$error.required && registrationForm.ime.$dirty}">
							{{tr.obavezno_polje}}
						</span>
					</div>
                                        <div  class="col-sm-6">
						<label for="prezime" class="control-label">{{tr.prezime}}: <span style="color:red">*</span></label>
						<input type="text" name="prezime" ng-model="prezime" class="form-control" id="prezime" ng-required="true" placeholder={{tr.pera_peric}} />
						<span class="text-transparent" ng-class="{textred:registrationForm.prezime.$error.required && registrationForm.prezime.$dirty}">
							{{tr.obavezno_polje}}
						</span>
					</div> 
					<div class="form-group">
						<label for="email" class="control-label">Email:<span style="color:red">*</span></label>
						<input type="email" ng-model="email" name="email" ng-required="true" class="form-control" id="email" placeholder="primer@email.com">
						<span span class="text-transparent" ng-class="{textred: registrationForm.email.$dirty &&(registrationForm.email.$error.required || registrationForm.email.$error.email)}">
							{{tr.obavezno_polje}} {{tr.email_format}}
						</span>
					</div>
					<div class="form-group">
						<label for="institucija" class="control-label">{{tr.institucija}}:<span style="color:red">*</span></label>
						<input type="text" name="institucija" ng-model="institucija" ng-required="true" class="form-control" id="institucija" placeholder={{tr.institucija}}>
						<span class="text-transparent" ng-class="{textred:registrationForm.institucija.$error.required && registrationForm.institucija.$dirty}">
							{{tr.obavezno_polje}}
						</span>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="user" class="control-label">{{tr.korisnicko_ime}}:<span style="color:red">*</span></label>
						<input type="text" name="user" ng-model="user" ng-change="jedinstven()"ng-pattern="/^[A-Za-z0-9_-]{3,20}$/" ng-required="true" class="form-control" id="user" placeholder={{tr.korisnicko_max}}>
						<span class="text-transparent" ng-class="{textred:registrationForm.user.$dirty && (registrationForm.user.$error.required || registrationForm.user.$error.pattern)}">
							{{tr.obavezno_polje}} {{tr.dozvoljeni}} 
						</span><span ng-show="greska" style="color:red" class="glyphicon glyphicon-remove">{{tr.greska_jedinstven_username}}</span>
					</div>
					<div class="form-group">
						<label for="pwd" class="control-label">{{tr.sifra}}:<span style="color:red">*</span></label>
						<input type="password" name="pwd" ng-pattern="/^[A-Za-z0-9_-]{6,32}$/" ng-model="pwd" ng-required="true" class="form-control" id="pwd" >
						<span class="text-transparent" ng-class="{textred:registrationForm.pwd.$dirty && (registrationForm.pwd.$error.required || registrationForm.pwd.$error.pattern)}">
							{{tr.obavezno_polje}} {{tr.dozvoljeni}}
						</span>
					</div>
					<div class="form-group">
						<label for="pwdR" class="control-label">{{tr.ponovljena_sifra}}:<span style="color:red">*</span></label>
						<input type="password" name="pwdR" ng-model="pwdR" ng-required="true" ng-change="same(pwd,pwdR)" class="form-control" id="pwdR">
						<span class="text-transparent" ng-class="{textred:registrationForm.pwdR.$dirty && (registrationForm.pwdR.$error.required || sameR)}">
							{{tr.obavezno_polje}} {{tr.razlicite_sifre}}
						</span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="info" class="control-label">{{tr.dodatne_info}}:</label>
                                                <textarea style="max-width:100%;" name="info" ng-model="info" ng-maxLenght="45" class="form-control" rows="3" id="info"></textarea>
					`	<span class="text-transparent" ng-class="{textred:registrationForm.info.$dirty && registrationForm.info.$error.maxLenght}">
							{{tr.info_max}}
						</span>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
                                    <button type="submit" ng-click="posaljiPodatke()" class="btn btn-primary btn-block" ng-class="{'disabled':!registrationForm.$valid && sameR}" ng-enabled="!sameR && registrationForm.$valid">{{tr.registruj_se}}</button>
				</div>
			</div>
		</form>
	</div>	
</div>

<br/> <br/>
<?php include('footer.php'); ?>
