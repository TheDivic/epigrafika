<?php include 'header.php'; ?>

<br/>
<br/>
<div ng-controller='formControllerRegistration'>

	<form action=""  name='formRegistration' method="post" enctype='multipart/form-data' novalidate>
	<h1> Registration </h1>
	<table style="padding:10px; ">
	<tr>
	<td> <label for="username"> Korisnicko ime: </label> </td>
	<td> <input type="text" name='username' id="username" ng-maxlength="30" ng-model='username' required /> </td>
	<td>
		<span style="color:red" ng-show='formRegistration.username.$error.maxlength'> Polje mora biti krace od 30 karaktera! </span>
		<span style="color:red" ng-show='formRegistration.username.$error.required'> Polje je obavezno! </span>
	</td>
	</tr>
	<tr>
	<td> <label for="password"> Sifra:</label> </td>
	<td><input type="password" id="password" ng-model="password" ng-maxlength="20" ng-minLenght="6" required/> <td>
	<td>
		<span style="color:red" ng-show='formRegistration.password.$error.minlength'> Polje mora biti duze od 6 karaktera! &nbsp; </span>
		<span style="color:red" ng-show='formRegistration.password.$error.maxlength'> Polje mora biti krace od 20 karaktera! &nbsp; </span>
		<span style="color:red" ng-show='formRegistration.password.$error.required'> Polje je obavezno! </span>
	</td>
	</tr>
	<tr>
	<td><label for="passwordR"> Ponovite sifru:</label> </td>
	<td><input type="password" id="passwordR" ng-model="passwordR" ng-maxlength="20" ng-minLenght="6" ng-blur="same()" required/> </td>
	<td>
		<span style="color:red"  ng-show='formRegistration.passwordR.$error.maxlength'> Polje mora biti krace od 20 karaktera! &nbsp;</span>
		<span style="color:red" ng-show='formRegistration.passwordR.$error.required'> Polje je obavezno! &nbsp; </span>
		<span style="color:red" ng-show='sameR'> Sifre se ne poklapaju </span>
	</td>
	</tr>
	<tr>
	<td> <label for="email"> Email:</label> </td>
	<td> <input type="email" id="email" ng-model="email" required /> </td>
	<td>
		<span style="color:red" ng-show='formRegistration.email.$error.email'> Email je neispravnog formata &nbsp;</span>
		<span style="color:red" ng-show='formRegistration.email.$error.required'> Polje je obavezno! </span>
	</td>
	</tr>
	<tr>
	<td><label for="info"> Dodatne informacije:</label> </td>
	<td><input type="text" id="info" ng-model="info" ng-maxlength="250"/></td>
	<td>
		<span style="color:red" ng-show='formRegistration.info.$error.maxlength'> Max broj karaktera je 250</span>
	</td>
	</tr>
	</table>
	<br/>
	<br/>
	<input type="submit" value="Registruj se" />
		
    </form>
</div>
</div>
</body>
</html>
