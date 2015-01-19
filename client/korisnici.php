<?php
session_start();
if(!isset($_SESSION['privilegije'])) {
    header('Location: ../client/pocetna.php');
    exit;
}
else if($_SESSION['privilegije']!=="admin") {
    header('Location: ../client/index.php');
    exit;
}
include "header-admin.php"; ?>
<?php if(isset($_GET['korisnickoIme'])){ ?>
<script src="static/scripts/korisnici.js"> </script>
<div class="container" ng-controller="adminKorisnici" ng-init="init();">
			<h1> Izmena podataka</h1>
			<form class="form" name="novakorisnik" method="get" action="" ng-repeat="s in single">
			<div class="row">
				<div class="col-sm-6">
					<div class="row">
						<div class="col-sm-6">
							<div class= "form-group">
								<label for="ime" class="control-label">{{tr.ime}}: <span style="color:red">*</span></label>
								<input type="text" name="ime" ng-model="s.ime" class="form-control" id="ime" ng-required="true" ng-pattern="/^[a-zA-Z ]+$/"/>
								<span class="text-transparent" ng-class="{textred:(novakorisnik.ime.$error.required || novakorisnik.ime.$error.pattern) && novakorisnik.ime.$dirty}">
									{{tr.format_error_slova}}
								</span>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="prezime" class="control-label">{{tr.prezime}}: <span style="color:red">*</span></label>
								<input type="text" name="prezime" ng-model="s.prezime" class="form-control" id="prezime" ng-required="true" ng-pattern="/^[a-zA-Z ]+$/"/>
								<span class="text-transparent" ng-class="{textred:(novakorisnik.prezime.$error.required || novakorisnik.prezime.$error.pattern) && novakorisnik.prezime.$dirty}">
									{{tr.format_error_slova}}
								</span>
							</div>
						</div>
					</div>
					<div class="form-group clearfix">
						<label for="email" class="control-label">Email:<span style="color:red">*</span></label>
						<input type="email" ng-model="s.email" name="email" ng-required="true" class="form-control" id="email">
						<span span class="text-transparent" ng-class="{textred: novakorisnik.email.$dirty &&(novakorisnik.email.$error.required || novakorisnik.email.$error.email)}">
							{{tr.obavezno_polje}} {{tr.email_format}}
						</span>
					</div>
					<div class="form-group">
						<label for="institucija" class="control-label">{{tr.institucija}}:<span style="color:red">*</span></label>
						<input type="text" name="institucija" ng-model="s.institucija" ng-required="true" class="form-control" id="institucija" ng-pattern="/^[a-zA-Z ]+$/">
						<span class="text-transparent" ng-class="{textred:(novakorisnik.institucija.$error.required ||novakorisnik.institucija.$error.pattern) && novakorisnik.institucija.$dirty}">
							{{tr.obavezno_polje}}{{tr.format_error_slova}}
						</span>
					</div>
					
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="user" class="control-label">{{tr.korisnicko_ime}}:</label>
						<input type="text" name="user" ng-disabled="true;"ng-model="s.korisnickoIme" ng-change="jedinstvenA(s.korisnickoIme)"ng-pattern="/^[A-Za-z0-9_-]{3,20}$/" ng-required="true" class="form-control" id="user">
						<span class="text-transparent" ng-class="{textred:true}">
							Korisnicko ime se ne moze promeniti 
						</span>
					</div>
					<div class="form-group">
						<label for="privilegije" class="control-label"> Privilegije:<span style="color:red">*</span></label>
						<select class="form-control" id="privilegije" name="privilegije" ng-model="s.privilegije">
							<option>admin</option>
							<option selected>korisnik</option>
						</select>
						<span class="text-transparent" ng-class="{textred:novakorisnik.privilegije.$dirty && novakorisnik.privilegije.$error.required}">
							{{tr.obavezno_polje}} 
						</span>
					</div>
					<div class="form-group">
						<label for="status" class="control-label"> Status:<span style="color:red">*</span></label>
						<select class="form-control" id="status" name="status" ng-model="s.status">
							<option>aktivan</option>
							<option>neaktivan</option>
						</select>
						<span class="text-transparent" ng-class="{textred:novakorisnik.status.$dirty && novakorisnik.status.$error.required}">
							{{tr.obavezno_polje}} 
						</span>
					</div>
				</div>
			</div>
			<div class="row">
					<div class="col-sm-4">
						<button type="button" ng-click="sacuvaj(s.korisnickoIme, s.ime,s.prezime,s.email,s.institucija, s.privilegije,s.status)" class="btn btn-success btn-block" ng-class="{'disabled':!novakorisnik.$valid}" ng-enabled="novakorisnik.$valid"> Sacuvaj </button>
					</div>
					<div class="col-sm-4">
						<button type="button" ng-click="ponisti()" class="btn btn-primary btn-block" > Ponisti </button>
					</div>
			</div>
		</form>

</div>
<?php }else{ ?>
<!-- ucitavanje kontrolera -->
<script src="static/scripts/korisnici.js"></script>


<div class="container">

<!-- Tab menu -->
	<ul id="myTab" class="nav nav-tabs">
        <li class="active"><a href="#pregled" data-toggle="tab">Pregled &nbsp; <span class="glyphicon glyphicon-list"></span> </a>
        </li>
        <li><a href="#nova" data-toggle="tab">Novi &nbsp; <span class="glyphicon glyphicon-plus"></span></a>
        </li>
    </ul>
<!-- Sadrzaj tabova-->
	<div id="myTabContent" class="tab-content" ng-controller="adminKorisnici" ng-init="tmp=null;"ng-cloak>
		<!--Pregled tab -->
        <div class="tab-pane fade in active col-sm-12" id="pregled"><br/><br/>
            <table class="table table-striped hover">
                <thead>
                    <tr class="success row">
						<th>KORISNICKO IME</th>
						<th>IME PREZIME</th>
						<th>PRIVILEGIJE</th>
						<th>STATUS</th>
						<th>INSTITUCIJA</th>
						<th>DATUM</th>
						<th>IZMENI</th>
						<th>OBRISI</th>
					</tr>
                </thead>
                <tbody>
                    <tr ng-repeat="korisnik in korisnici" ng-class-even="'success'" class="row">
						<td class="col-sm-2"><p>{{ korisnik.korisnickoIme }}</p></td>
						<td class="col-sm-3"><p>{{ korisnik.ime }} {{korisnik.prezime}}</p></td>
						<td class="col-sm-1"><p>{{ korisnik.privilegije }}</p></td>
						<td class="col-sm-1"><p>{{ korisnik.status }}</p></td>
						<td class="col-sm-1"><p>{{ korisnik.institucija }}</p></td>
						<td class="col-sm-2"><p>{{ korisnik.datumRegistrovanja }}</p></td>
						<td class="col-sm-1 text-center" ><span ng-click="izmeni(korisnik.korisnickoIme)" class="glyphicon glyphicon-pencil"></span></td>
						<td class="col-sm-1 text-center"><span ng-click="obrisi(korisnik.korisnickoIme)" class="glyphicon glyphicon-remove"></span></td>
					</tr>
                </tbody>
            </table>
				<!-- paginacija -->
			<div class="text-center">
				<ul class="pagination pagination-sm">
					<li ng-class="{disabled: pageNumber <= 1}"><a href="#" ng-click="previousPage()">«</a></li>
					<li class="active"><a href="#">{{pageNumber}}</a></li>
					<li ng-class="{disabled: remainingResults <= 0}"><a href="#" ng-click="nextPage()">»</a></li>
				</ul>
			</div>
        </div>
		<!-- Nova tab -->
        <div class="tab-pane fade" id="nova">
			<h1> Unos novog korisnika</h1>
			<form class="form" name="novakorisnik" method="get" action="">
			<div class="row">
				<div class="col-sm-6">
					<div class="row">
						<div class="col-sm-6">
							<div class= "form-group">
								<label for="ime" class="control-label">{{tr.ime}}: <span style="color:red">*</span></label>
								<input type="text" name="ime" ng-model="ime" class="form-control" id="ime" ng-required="true" placeholder={{tr.pera}} ng-pattern="/^[a-zA-Z ]+$/" />
								<span class="text-transparent" ng-class="{textred:(novakorisnik.ime.$error.required||novakorisnik.ime.$error.pattern) && novakorisnik.ime.$dirty}">
									{{tr.format_error_slova}}
								</span>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="prezime" class="control-label">{{tr.prezime}}: <span style="color:red">*</span></label>
								<input type="text" name="prezime" ng-model="prezime" class="form-control" id="prezime" ng-required="true" placeholder={{tr.peric}} ng-pattern="/^[a-zA-Z ]+$/"/>
								<span class="text-transparent" ng-class="{textred:(novakorisnik.prezime.$error.required || novakorisnik.prezime.$error.pattern) && novakorisnik.prezime.$dirty}">
									{{tr.format_error_slova}}
								</span>
							</div>
						</div>
					</div>
					<div class="form-group clearfix">
						<label for="email" class="control-label">Email:<span style="color:red">*</span></label>
						<input type="email" ng-model="email" name="email" ng-required="true" class="form-control" id="email" placeholder="primer@email.com">
						<span span class="text-transparent" ng-class="{textred: novakorisnik.email.$dirty &&(novakorisnik.email.$error.required || novakorisnik.email.$error.email)}">
							{{tr.obavezno_polje}} {{tr.email_format}}
						</span>
					</div>
					<div class="form-group">
						<label for="institucija" class="control-label">{{tr.institucija}}:<span style="color:red">*</span></label>
						<input type="text" name="institucija" ng-model="institucija" ng-required="true" class="form-control" id="institucija" placeholder={{tr.institucija}} ng-pattern="/^[a-zA-Z ]+$/">
						<span class="text-transparent" ng-class="{textred:(novakorisnik.institucija.$error.required || novakorisnik.institucija.$error.pattern) && novakorisnik.institucija.$dirty}">
							{{tr.obavezno_polje}}{{tr.format_error_slova}}
						</span>
					</div>
					<div class="form-group">
						<label for="privilegije" class="control-label"> Privilegije:<span style="color:red">*</span></label>
						<select class="form-control" id="privilegije" name="privilegije" ng-model="privilegije">
							<option>admin</option>
							<option selected>korisnik</option>
						</select>
						<span class="text-transparent" ng-class="{textred:novakorisnik.privilegije.$dirty && novakorisnik.privilegije.$error.required}">
							{{tr.obavezno_polje}} 
						</span>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="user" class="control-label">{{tr.korisnicko_ime}}:<span style="color:red">*</span></label>
						<input type="text" name="user" ng-model="user" ng-change="jedinstven()"ng-pattern="/^[A-Za-z0-9_-]{3,20}$/" ng-required="true" class="form-control" id="user" placeholder={{tr.korisnicko_max}}>
						<span class="text-transparent" ng-class="{textred:novakorisnik.user.$dirty && (novakorisnik.user.$error.required || novakorisnik.user.$error.pattern)}">
							{{tr.obavezno_polje}} {{tr.dozvoljeni}} 
						</span>
						<span class="text-transparent" ng-class="{textred:greska}">
							<span style="top:2px;" class="glyphicon glyphicon-remove"></span> {{tr.greska_jedinstven_username}}
						</span>
					</div>
					<div class="form-group">
						<label for="pwd" class="control-label">{{tr.sifra}}:<span style="color:red">*</span></label>
						<input type="password" name="pwd" ng-pattern="/^[A-Za-z0-9_-]{6,32}$/" ng-model="pwd" ng-required="true" class="form-control" id="pwd" >
						<span class="text-transparent" ng-class="{textred:novakorisnik.pwd.$dirty && (novakorisnik.pwd.$error.required || novakorisnik.pwd.$error.pattern)}">
							{{tr.obavezno_polje}} {{tr.dozvoljeni}}
						</span>
					</div>
					<div class="form-group">
						<label for="pwdR" class="control-label">{{tr.ponovljena_sifra}}:<span style="color:red">*</span></label>
						<input type="password" name="pwdR" ng-model="pwdR" ng-required="true" ng-change="same(pwd,pwdR)" class="form-control" id="pwdR">
						<span class="text-transparent" ng-class="{textred:novakorisnik.pwdR.$dirty && (novakorisnik.pwdR.$error.required || sameR)}">
							{{tr.obavezno_polje}} {{tr.razlicite_sifre}}
						</span>
					</div>
					<div class="form-group">
						<label for="status" class="control-label"> Status:<span style="color:red">*</span></label>
						<select class="form-control" id="status" name="status" ng-model="status">
							<option>aktivan</option>
							<option>neaktivan</option>
						</select>
						<span class="text-transparent" ng-class="{textred:novakorisnik.status.$dirty && novakorisnik.status.$error.required}">
							{{tr.obavezno_polje}} 
						</span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="info" class="control-label">{{tr.dodatne_info}}:</label>
                                                <textarea style="max-width:100%;" name="info" ng-model="info" ng-maxLenght="45" class="form-control" rows="3" id="info" ng-pattern="/^[a-zA-Z0-9 \. , ' \( \) ]+$/"></textarea>
						<span class="text-transparent" ng-class="{textred:novakorisnik.info.$dirty && (novakorisnik.info.$error.maxLenght || novakorisnik.info.$error.pattern)}">
							{{tr.info_max}} {{tr.format_error_slova_cifre_tacka}}
						</span>
					</div>
				</div>
			</div>
			
			<div class="row">
					<div class="col-sm-4">
						<button type="button" ng-click="submit()" class="btn btn-success btn-block" ng-class="{'disabled':(!novakorisnik.$valid || sameR)}" ng-enabled="!sameR && novakorisnik.$valid"> Unesi </button>
					</div>
					<div class="col-sm-4">
						<button type="reset" class="btn btn-primary btn-block" > Ponisti </button>
					</div>
			</div>
		</form>
				
				
        </div>
    </div>
	


</div> <!-- Container end -->

<?php } ?>
<?php include "footer.php"; ?>