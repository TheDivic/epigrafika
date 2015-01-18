<?php
session_start();
if(isset($_SESSION['privilegije'])) {
    header('Location: ../client/index.php');
    exit;
}
include 'headerNijeUlogovan.php'; ?>

<!-- ucitavanje kontrolera -->
<script src="static/scripts/zaboravljena.js"></script>

<div class="container text-center" style="margin: 100px; " ng-controller='zaboravljenaSifraController' ng-cloak>
    <h1>{{tr.zaboravili_sifru}} </h1>
    <form name='formSifra' style="margin: 30px; ">
    <div class="form-group col-sm-6 col-sm-offset-3" >
	<label for="user" class="control-label">{{tr.korisnicko_ime}}:<span style="color:red">*</span></label>
	<input type="text" name="user" ng-model="user" ng-pattern="/^[A-Za-z0-9_-]{3,20}$/" ng-required="true" class="form-control" placeholder={{tr.korisnicko_max}}>
	<span class="text-transparent" ng-class="{textred:formSifra.user.$dirty && (formSifra.user.$error.required || formSifra.user.$error.pattern)}">
	{{tr.obavezno_polje}} {{tr.dozvoljeni}} 
        </span>
    </div>
    <div class="col-sm-6 col-sm-offset-3">
        <button type="submit" ng-click="posaljiEmail()" class="btn btn-primary btn-block" ng-class="{'disabled':!formSifra.$valid }" ng-enabled="formSifra.$valid"> {{tr.posalji_email}}</button>
    </div>    
        
    </form>
</div>

<?php include 'footer.php'; ?>
