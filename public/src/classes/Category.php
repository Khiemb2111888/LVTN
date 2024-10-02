<?php

namespace CT275\Labs;

class Category
{
    protected $PDO;

    public function __construct($PDO)
    {
        $this->PDO = $PDO;
    }

    // Thêm một danh mục mới
    public function create($name, $description)
    {
        $stmt = $this->PDO->prepare("
            INSERT INTO categories (name, description) 
            VALUES (:name, :description)
        ");
        $stmt->execute([
            'name' => $name,
            'description' => $description
        ]);
        return $this->PDO->lastInsertId();
    }

    // Lấy danh mục theo ID
    public function getById($id)
    {
        $stmt = $this->PDO->prepare("
            SELECT * FROM categories WHERE id = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    // Lấy tất cả danh mục
    public function getAllCategories()
    {
        $stmt = $this->PDO->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    // Cập nhật danh mục
    public function update($id, $name, $description)
    {
        $stmt = $this->PDO->prepare("
            UPDATE categories 
            SET name = :name, description = :description 
            WHERE id = :id
        ");
        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'description' => $description
        ]);
    }

    // Xóa danh mục
    public function delete($id)
    {
        $stmt = $this->PDO->prepare("
            DELETE FROM categories WHERE id = :id
        ");
        return $stmt->execute(['id' => $id]);
    }
}
