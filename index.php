<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require 'config/config.php';

$stmt = $pdo->query('SELECT * FROM users');
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CRUD USERS PHP</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="d-flex flex-column" style="scroll-behavior: smooth;">
	<section id="user-list" class="vh-100">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th scope="col">
						ID
					</th>
					<th scope="col">
						Username
					</th>
					<th scope="col">
						Email
					</th>
					<th scope="col">
						Password
					</th>
					<th scope="col">
						Created At
					</th>
					<th>
						Actions
					</th>
				</tr>
			</thead>
			<tbody class="table-group-divider">
				<?php while ($row = $stmt->fetch()) { ?>
					<tr>
						<th scope="row" class="align-middle">
							<?= $row['id'] ?>
						</th>
						<td class="align-middle">
							@<?= $row['username'] ?>
						</td>
						<td class="align-middle">
							<?= $row['email'] ?>
						</td>
						<td class="align-middle">
							<?= $row['password'] ?>
						</td>
						<td class="align-middle">
							<?= $row['created_at'] ?>
						</td>
						<td class="align-middle d-flex gap-2">
							<button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateUserModal" data-id="<?= $row['id'] ?>" data-username="<?= $row['username'] ?>" data-email="<?= $row['email'] ?>">
								Update
							</button>

							<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-id="<?= $row['id'] ?>" data-username="<?= $row['username'] ?>">
								Delete
							</button>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</section>

	<!-- Add User Form -->
	<section id="add-user" class="vh-100 d-flex align-items-center justify-content-center">
		<div class="d-flex gap-2 flex flex-column">
			<h4 class="display-4 text-center">Add New User</h4>

			<form style="width: 500px;" action="add.php" method="POST">
				<div class="mb-3">
					<div class="input-group">
						<span class="input-group-text" id="basic-addon1">@</span>
						<input type="text" class="form-control" id="username" name="username" placeholder="Username" aria-label="Username" aria-describedby="Username" for="username" minlength="3" maxlength="12" required>
					</div>
					<div id="usernameHelp" class="form-text">Your username must be 3-12 characters long.</div>
				</div>

				<div class="mb-3">
					<div class="input-group">
						<input type="text" class="form-control" id="email" name="email" placeholder="Recipient's email" aria-label="Recipient's email" aria-describedby="Recipient's email" required>
					</div>
					<div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
				</div>

				<div class="mb-3">
					<input type="password" class="form-control" id="password" name="password" placeholder="Your Password" minlength="8" maxlength="20" aria-label="password" aria-describedby="password" required>
					<div id="passwordHelp" class="form-text">
						Your password must be 8-20 characters long.
					</div>
				</div>
				<button type="submit" class="btn btn-primary w-100 p-2 fw-semibold">Add User</button>
			</form>
		</div>
	</section>

	<!-- Update User Modal -->
	<div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="updateUserModalLabel">Update User</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="updateUserForm" method="post" action="update.php">
					<div class="modal-body">
						<input type="hidden" id="updateUserId" name="id">
						<div class="mb-3">
							<label for="updateUsername" class="form-label">Username</label>
							<input type="text" class="form-control" id="updateUsername" name="username">
						</div>
						<div class="mb-3">
							<label for="updateEmail" class="form-label">Email</label>
							<input type="email" class="form-control" id="updateEmail" name="email">
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-warning">Update</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Delete User Modal -->
	<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="deleteUserForm" method="post" action="delete.php">
					<div class="modal-body">
						<input type="hidden" id="deleteUserId" name="id">
						<p>Are you sure you want to delete this user?</p>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-danger">Delete</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script>
		var updateUserModal = document.getElementById('updateUserModal');
		updateUserModal.addEventListener('show.bs.modal', function(event) {
			var button = event.relatedTarget;
			var id = button.getAttribute('data-id');
			var username = button.getAttribute('data-username');
			var email = button.getAttribute('data-email');

			var modalTitle = updateUserModal.querySelector('.modal-title');
			var modalBodyInputId = updateUserModal.querySelector('#updateUserId');
			var modalBodyInputUsername = updateUserModal.querySelector('#updateUsername');
			var modalBodyInputEmail = updateUserModal.querySelector('#updateEmail');

			modalTitle.textContent = 'Update @' + username;
			modalBodyInputId.value = id;
			modalBodyInputUsername.value = username;
			modalBodyInputEmail.value = email;
		});

		var deleteUserModal = document.getElementById('deleteUserModal');
		deleteUserModal.addEventListener('show.bs.modal', function(event) {
			var button = event.relatedTarget;
			var id = button.getAttribute('data-id');
			var username = button.getAttribute('data-username');

			var modalTitle = deleteUserModal.querySelector('.modal-title');
			var modalBodyParagraph = deleteUserModal.querySelector('.modal-body p');

			var modalBodyInputId = deleteUserModal.querySelector('#deleteUserId');

			modalTitle.textContent = 'Delete @' + username;
			modalBodyParagraph.textContent = `Are you sure you want to delete @${username}?`;
			modalBodyInputId.value = id;
		});
	</script>
</body>

</html>