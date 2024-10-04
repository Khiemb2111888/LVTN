<?php
require_once __DIR__ . '/../src/bootstrap.php';

use CT275\Labs\User;
use CT275\Labs\Paginator;

$User = new User($PDO);
$limit = (isset($_GET['limit']) && is_numeric($_GET['limit'])) ?
    (int)$_GET['limit'] : 5;
$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ?
    (int)$_GET['page'] : 1;
$paginator = new Paginator(
    totalRecords: $User->count(),
    recordsPerPage: $limit,
    currentPage: $page
);
$Users = $User->paginate($paginator->recordOffset, $paginator->recordsPerPage);
$pages = $paginator->getPages(length: 3);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Người Dùng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <h2>Danh Sách Người Dùng</h2>
        <table id="Users" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Tên người dùng</th>
                    <th scope="col">Email</th>
                    <th scope="col">Ngày tạo</th>
                    <th scope="col">Vai trò</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Users as $User): ?>
                    <tr>
                        <td><?= html_escape($User->username) ?></td>
                        <td><?= html_escape($User->email) ?></td>
                        <td><?= html_escape(date("d-m-Y", strtotime($User->created_at))) ?></td>
                        <td><?= html_escape($User->role) ?></td>
                        <!-- Hiển thị avatar -->
                        <td>
                            <?php if (!empty($User->avatar)): ?>
                                <img src="/../public/uploads/<?= html_escape($User->avatar) ?>" alt="Avatar" width="50" height="50">
                            <?php else: ?>
                                <img src="/../public/uploads/default-avatar.jpg" alt="Avatar" width="50" height="50">
                            <?php endif; ?>
                        </td>
                        <td class="d-flex justify-content-center">
                            <a href="<?= '/public/editUser.php?id=' . $User->id ?>" class="btn btn-xs btn-warning">
                                <i alt="Edit" class="fa fa-pencil"></i> Edit
                            </a>
                            <form class="ms-1" action="/public/deleteUser.php" method="POST">
                                <input type="hidden" name="id" value="<?= $User->id ?>">
                                <button type="submit" class="btn btn-xs btn-danger" name="delete-User">
                                    <i alt="Delete" class="fa fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>