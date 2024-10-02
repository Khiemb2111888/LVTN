<?php

namespace CT275\Labs;

class Product
{
    private $id;
    private $name;
    private $price;
    private $description;
    private $category_id;
    private $image;
    private $PDO;

    // Hàm khởi tạo
    public function __construct($PDO)
    {
        $this->PDO = $PDO;
    }

    // Thiết lập thuộc tính sản phẩm
    public function setProductData($name, $price, $description, $category_id, $image)
    {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->category_id = $category_id;
        $this->image = $image;
    }

    // Thêm sản phẩm mới vào cơ sở dữ liệu
    public function create()
    {
        $stmt = $this->PDO->prepare("INSERT INTO products (name, price, description, category_id, image) VALUES (:name, :price, :description, :category_id, :image)");
        return $stmt->execute([
            ':name' => $this->name,
            ':price' => $this->price,
            ':description' => $this->description,
            ':category_id' => $this->category_id,
            ':image' => $this->image
        ]);
    }

    // Cập nhật sản phẩm
    public function update($id)
    {
        $stmt = $this->PDO->prepare("UPDATE products SET name = :name, price = :price, description = :description, category_id = :category_id, image = :image WHERE id = :id");
        return $stmt->execute([
            ':name' => $this->name,
            ':price' => $this->price,
            ':description' => $this->description,
            ':category_id' => $this->category_id,
            ':image' => $this->image,
            ':id' => $id
        ]);
    }

    // Lấy sản phẩm theo ID
    public function findById($id)
    {
        $stmt = $this->PDO->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    // Xóa sản phẩm
    public function delete($id)
    {
        $stmt = $this->PDO->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Lấy tất cả sản phẩm

    public function getAllProducts()
    {
        $stmt = $this->PDO->prepare("
            SELECT products.*, categories.name AS category_name 
            FROM products 
            JOIN categories ON products.category_id = categories.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    public function getProductsByCategory($categoryId)
    {
        $stmt = $this->PDO->prepare("
            SELECT * FROM products WHERE category_id = :category_id
        ");
        $stmt->execute(['category_id' => $categoryId]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
