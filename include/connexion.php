<div id="cont">
	<div id="connexion">
		<!-- bloc contenant le formulaire -->
		<form name="connexionForm" id="connexionForm" action="index.php"
			method="post">
			<!-- début du formulaire de connexion -->
			<fieldset>
				<legend>Connexion</legend>
				<!-- titre du formulaire -->
				<p>

					<span id="erreur"></span>
					<!-- span qui contiendra les éventuels messages d'erreur -->

				</p>
				<p>
					<label for="login">Login :</label> <input type="login" name="login"
						id="login" />
					<!-- champ pour le login -->
				</p>

				<p>
					<label for="passe">Mot de passe :</label> <input type="password"
						name="password" id="password" />
					<!-- champ pour le mot de passe -->
				</p>

				<p class="center">
					<input type="submit" value=" Je me connecte" class="bouton" />
					<!-- bouton de connexion -->
				</p>
				<p color="#808080">
					<a href="#"> > Mot de passe oublié ?</a>
				</p>
			</fieldset>
		</form>
		<!-- fin du formulaire -->
	</div>
</div>
