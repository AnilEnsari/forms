<?php  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'classes/user.php';
$objUser = new User();

// GET
if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $stmt = $objUser->runQuery("SELECT * FROM crud_users WHERE id=:id");
    $stmt->execute(array(":id" => $id));
    $rowUser = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $id = null;
    $rowUser = null;
}

// POST
if (isset($_POST['btn_save'])) {
    $name = strip_tags($_POST['name']);
    $email = strip_tags($_POST['email']);

    try {
        if ($id != null) {
            if ($objUser->update($name, $email, $id)) {
                $objUser->redirect('index.php?updated');
            } else {
                $objUser->redirect('index.php?error');
            }
        } else {
            if ($objUser->insert($name, $email)) {
                $objUser->redirect('index.php?inserted');
            } else {
                $objUser->redirect('index.php?error');
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

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
    <!-- header -->
    <div>
        <div>
            <!-- sidebar -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <h1 style="margin-top: 10px">ADD/EDIT USERS</h1>
                <p>Required fields are in (*)</p>
                <form method="post">
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input class="form-control" type="text" name="id" id="id" value="<?php echo isset($rowUser['id']) ? $rowUser['id'] : ''; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">NAME</label>
                        <input class="form-control" type="text" name="name" id="name" value="<?php echo isset($rowUser['name']) ? $rowUser['name'] : ''; ?>" placeholder="First name and last name" required maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="email">EMAIL</label>
                        <input class="form-control" type="text" name="email" id="email" placeholder="anil@example.com" value="<?php echo isset($rowUser['email']) ? $rowUser['email'] : ''; ?>" required maxlength="100">
                    </div>
                    <!-- Change type to "submit" -->
                    <button class="btn btn-primary mb-2" type="submit" name="btn_save">Save</button>
                </form>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS ve jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>