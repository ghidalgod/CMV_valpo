<div id="infoMessage"><?php echo $message;?></div>

<div class="row">
	<!--<div class="col-xs-3 col-sm-3 widget-container-col" id="widget-container-col-5" height="123">
		<div class="widget-box" id="widget-box-5">
			<div class="widget-body">
				<div class="widget-main padding-6">
	  				<img id="avatar" class="editable img-responsive center" alt="Alex's Avatar" src=" <?= isset($avatarP) ? base_url($avatarP) : base_url('assets/images/avatars/'.$avatar) ?>" />
				</div>
			</div>
		</div>
	</div>-->


	<div class="col-xs-8 col-sm-8">
		<div class="profile-user-info profile-user-info-striped">
			<div class="profile-info-row">
				<div class="profile-info-name"> Username </div>

				<div class="profile-info-value">
					<span class="editable" id="username"><?= $username ?></span>
				</div>
			</div>

			<div class="profile-info-row">
				<div class="profile-info-name"> Nombres </div>

				<div class="profile-info-value">
					<span class="editable" id="country"><?= $nombres ?></span>
				</div>
			</div>

			<div class="profile-info-row">
				<div class="profile-info-name"> Apellidos </div>

				<div class="profile-info-value">
					<span class="editable" id="age"><?= $apellidos ?></span>
				</div>
			</div>

			<div class="profile-info-row">
				<div class="profile-info-name"> Email </div>

				<div class="profile-info-value">
					<span class="editable" id="age"><?= $email ?></span>
				</div>
			</div>

			<div class="profile-info-row">
				<div class="profile-info-name"> Telefono </div>

				<div class="profile-info-value">
					<span class="editable" id="age"><?= $phone ?></span>
				</div>
			</div>
		</div>
	</div>
</div>