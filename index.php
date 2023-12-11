<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("form.php");
require_once('classes/user.php');

$objUser = new User(); // Instantiate the User class

if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    try {
        if ($objUser->delete($deleteId)) {
            $objUser->redirect('index.php?deleted');
        } else {
            $objUser->redirect('index.php?error');
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- head methods, CSS, and title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anils Form</title>
</head>
<body>
    <div class="row">
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h1 style="margin-top:10px">User Table</h1>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM crud_users";
                        $stmt = $objUser->runQuery($query);
                        $stmt->execute();

                        while ($rowUser = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr>
                                <td><?php echo $rowUser['id']; ?></td>
                                <td><?php echo $rowUser['name']; ?></td>
                                <td><?php echo $rowUser['email']; ?></td>
                                <td>
                                    <a href="form.php?edit_id=<?php echo $rowUser['id']; ?>">Edit</a>
                                    |
                                    <a href="index.php?delete_id=<?php echo $rowUser['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
