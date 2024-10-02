<?php

namespace CT275\Labs;

use PDO;

class User
{
    private ?PDO $db;

    public int $id = -1;
    public $username;
    public $password;
    public $email;
    public $created_at;
    public $role;
    public $avatar;

    public function __construct(?PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function fill(array $data): User
    {
        $this->username = $data['username'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->role = $data['role'] ?? 'custumer';
        $this->avatar = $data['avatar'] ?? '';
        return $this;
    }

    protected array $errors = [];

    public function validate(array $data): array
    {
        if (empty($data['username'])) {
            $this->errors['username'] = 'Tên là bắt buộc.';
        } elseif (strlen($data['username']) < 3) {
            $this->errors['username'] = 'Tên phải có ít nhất 3 ký tự.';
        }

        if (empty($data['email'])) {
            $this->errors['email'] = 'Email là bắt buộc.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Email không hợp lệ.';
        }

        if (empty($data['password'])) {
            $this->errors['password'] = 'Mật khẩu là bắt buộc.';
        } elseif (strlen($data['password']) < 6) {
            $this->errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        }

        return $this->errors;
    }

    // Hàm kiểm tra email đã tồn tại hay chưa
    public function emailExists(string $email): bool
    {
        $statement = $this->db->prepare('SELECT COUNT(*) FROM User WHERE email = :email');
        $statement->execute(['email' => $email]);
        return $statement->fetchColumn() > 0;
    }

    public function all(): array
    {
        $User = [];
        $statement = $this->db->prepare('SELECT * FROM User');
        $statement->execute();
        while ($row = $statement->fetch()) {
            $contact = new User($this->db);
            $contact->fillFromDbRow($row);
            $User[] = $contact;
        }
        return $User;
    }

    protected function fillFromDbRow(array $row): User
    {
        $this->id = $row['id'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->email = $row['email'];
        $this->role = $row['role'];
        $this->created_at = $row['created_at'];
        $this->avatar = $row['avatar'];
        return $this;
    }

    public function count(): int
    {
        $statement = $this->db->prepare('SELECT COUNT(*) FROM User');
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function paginate(int $offset = 0, int $limit = 10): array
    {
        $User = [];
        $statement = $this->db->prepare('SELECT * FROM User LIMIT :offset,:limit');
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();
        while ($row = $statement->fetch()) {
            $contact = new User($this->db);
            $contact->fillFromDbRow($row);
            $User[] = $contact;
        }
        return $User;
    }

    public function save(): bool
    {
        $result = false;
        // Nếu id >= 0, thực hiện cập nhật người dùng
        if ($this->id >= 0) {
            // Nếu không có avatar mới, giữ nguyên giá trị avatar hiện tại
            if (empty($this->avatar)) {
                $statement = $this->db->prepare(
                    'UPDATE User 
                SET username = :username, password = :password, email = :email, role = :role 
                WHERE id = :id'
                );
                $result = $statement->execute([
                    'username' => $this->username,
                    'password' => $this->password,
                    'email' => $this->email,
                    'role' => $this->role,
                    'id' => $this->id
                ]);
            } else {
                $statement = $this->db->prepare(
                    'UPDATE User 
                SET username = :username, password = :password, email = :email, role = :role, avatar = :avatar 
                WHERE id = :id'
                );
                $result = $statement->execute([
                    'username' => $this->username,
                    'password' => $this->password,
                    'email' => $this->email,
                    'role' => $this->role,
                    'avatar' => $this->avatar,
                    'id' => $this->id
                ]);
            }
        } else {
            // Nếu id < 0, thêm người dùng mới
            // Gán giá trị mặc định cho role là 'customer' nếu không có role được chỉ định
            $role = $this->role ?? 'customer';

            $statement = $this->db->prepare(
                'INSERT INTO User (username, password, email, role, avatar, created_at) 
             VALUES (:username, :password, :email, :role, :avatar, NOW())'
            );
            $result = $statement->execute([
                'username' => $this->username,
                'password' => password_hash($this->password, PASSWORD_DEFAULT), // Mã hóa mật khẩu
                'email' => $this->email,
                'role' => $role,  // Sử dụng biến $role đã gán giá trị
                'avatar' => $this->avatar
            ]);

            // Nếu thêm thành công, lấy id mới
            if ($result) {
                $this->id = $this->db->lastInsertId();
            }
        }
        return $result;
    }

    public function find(int $id): ?User
    {
        $statement = $this->db->prepare('select * from User where id = :id');
        $statement->execute(['id' => $id]);
        if ($row = $statement->fetch()) {
            $this->fillFromDbRow($row);
            return $this;
        }
        return null;
    }

    public function delete(): bool
    {
        $statement = $this->db->prepare('delete from User where id = :id');
        return $statement->execute(['id' => $this->id]);
    }

    public function findByEmailOrUsername($emailOrUsername)
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email = :emailOrUsername OR username = :emailOrUsername LIMIT 1");
        $stmt->execute([':emailOrUsername' => $emailOrUsername]);
        return $stmt->fetchObject();
    }
}




class Paginator
{
    public int $totalPages;
    public int $recordOffset;
    public function __construct(
        public int $recordsPerPage,
        public int $totalRecords,
        public int $currentPage = 1,
    ) {
        $this->totalPages = ceil($totalRecords / $recordsPerPage);
        if ($currentPage < 1) {
            $this->currentPage = 1;
        }
        $this->recordOffset = ($this->currentPage - 1) *
            $this->recordsPerPage;
    }
    public function getPrevPage(): int | bool
    {
        return $this->currentPage > 1 ?
            $this->currentPage - 1 : false;
    }
    public function getNextPage(): int | bool
    {
        return $this->currentPage < $this->totalPages ?
            $this->currentPage + 1 : false;
    }
    public function getPages(int $length = 3): array
    {
        $halfLength = floor($length / 2);
        $pageStart = $this->currentPage - $halfLength;
        $pageEnd = $this->currentPage + $halfLength;
        if ($pageStart < 1) {
            $pageStart = 1;
            $pageEnd = $length;
        }
        if ($pageEnd > $this->totalPages) {
            $pageEnd = $this->totalPages;
            $pageStart = $pageEnd - $length + 1;
            if ($pageStart < 1) {
                $pageStart = 1;
            }
        }
        return range((int)$pageStart, (int)$pageEnd);
    }
}
