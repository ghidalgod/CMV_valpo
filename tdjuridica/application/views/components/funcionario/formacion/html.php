<div class="profile-user-info profile-user-info-striped">
	<div class="profile-info-row">
		<div class="profile-info-name"> Título </div>

		<div class="profile-info-value">
			<span class="editable" id="username"><?=strcmp($funcionario->Titulo, "S") === 0 ? "Sí" : "No" ?></span>
		</div>
	</div>

	<div class="profile-info-row">
		<div class="profile-info-name"> Fecha Título </div>

		<div class="profile-info-value">
			<span class="editable" id="city"><?=$funcionario->FechaTitulo ? date("d/m/Y", strtotime($funcionario->FechaTitulo)) : "Sin información"?></span>
		</div>
	</div>

	<div class="profile-info-row">
		<div class="profile-info-name"> Institución Título </div>

		<div class="profile-info-value">
			<span class="editable" id="city"><?=$funcionario->Institucion ? $funcionario->Institucion : "Sin información"?></span>
		</div>
	</div>
	
	<div class="profile-info-row">
		<div class="profile-info-name"> Profesión </div>

		<div class="profile-info-value">
			<span class="editable" id="city"><?=$funcionario->Profesion ? $funcionario->Profesion : "Sin información"?></span>
		</div>
	</div>	
	
	<!-- Mostrar solo si la persona es de salud-->
	<div class="profile-info-row">
		<div class="profile-info-name"> Especialidad </div>

		<div class="profile-info-value">
			<span class="editable" id="city">No informa</span>
		</div>
	</div>
	
	<div class="profile-info-row">
		<div class="profile-info-name"> Subespecialidad </div>

		<div class="profile-info-value">
			<span class="editable" id="city">No informa</span>
		</div>
	</div>
</div>