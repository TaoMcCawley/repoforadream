<?php echo $this->render('view/header.html',NULL,get_defined_vars(),0); ?>
<div class="container">
	<div class="row justify-content-center">
		<h1 class="display-1"></h1>
	</div>
	<hr>
	<div class="row">
		<div class="col bg-dark">
			<div class="row bg-white">
				<!-- Product Information Goes Here -->
			</div>
			<div class="row bg-white">
				<!-- Product Information Goes Here -->
			</div>
			<div class="row bg-white">
				<!-- Product Information Goes Here -->
			</div>
		</div> <!-- .col -->

		<div class="col">
			<form class="form card border-dark bg-dark text-white p-3" method="post">
				<div class="form-group">
					<label for="name">Name</label><span class="text-danger"><?= ($errors['name']) ?></span>
					<input required type="text" class="form-control" id="name" name="name" value="<?= ($name) ?>">
				</div>
				<div class="form-group">
					<label for="username">Username</label><span class="text-danger"><?= ($errors['username']) ?> <?= ($errors['duplicateUsername']) ?></span>
					<input required type="text" class="form-control" id="username" name="username" value="<?= ($username) ?>">
				</div>
				<div class="form-group">
					<label for="email">E-mail</label><span class="text-danger"><?= ($errors['email']) ?> <?= ($errors['duplicateEmail']) ?></span>
					<input required type="text" class="form-control" id="email" name="email" value="<?= ($email) ?>">
				</div>
				<div class="form-group">
					<label for="password">Password</label><span class="text-danger"><?= ($errors['password']) ?></span>
					<input required type="password" class="form-control" id="password" name="password">
				</div>
				<div class="form-group">
					<label for="retype">Re-type Password</label><span class="text-danger"><?= ($errors['retype']) ?></span>
					<input required type="password" class="form-control" id="retype" name="retype">
				</div>
				<div class="form-group text-center">
					<input class="btn btn-light" type="submit" id="signupsubmit" name="signupsubmit" value="Sign Up!">
				</div>
			</form>
		</div><!-- .col -->
	</div><!-- .row -->

	<div class="row text-center">
		<div class="col small"><a href="#">Continue as Guest &xrArr;</a></div>
	</div><!-- .row -->
</div><!-- .container -->

<!-- Bootstrap dependencies -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<?php echo $this->render('view/footer.html',NULL,get_defined_vars(),0); ?>