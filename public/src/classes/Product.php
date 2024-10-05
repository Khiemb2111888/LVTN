<?php

namespace CT275\Labs;

use PDO;

class Product
{
    private ?PDO $db;
    private $id;
    private $name;
    private $price;
    private $description;
    private $category_id;
    private $image;
    private $quantity;

    // Hàm khởi tạo
    public function __construct(?PDO $PDO)
    {
        $this->db = $PDO;
    }

    // Thêm sản phẩm mới vào cơ sở dữ liệu
    public function create()
    {
        $stmt = $this->db->prepare("INSERT INTO products (name, price, description, category_id, image, quantity) VALUES (:name, :price, :description, :category_id, :image, :quantity)");
        return $stmt->execute([
            ':name' => $this->name,
            ':price' => $this->price,
            ':description' => $this->description,
            ':category_id' => $this->category_id,
            ':image' => $this->image,
            ':quantity' => $this->quantity
        ]);
    }

    // Cập nhật sản phẩm
    public function update($id)
    {
        $stmt = $this->db->prepare("UPDATE products SET name = :name, price = :price, description = :description, category_id = :category_id, image = :image, quantity = :quantity WHERE id = :id");
        return $stmt->execute([
            ':name' => $this->name,
            ':price' => $this->price,
            ':description' => $this->description,
            ':category_id' => $this->category_id,
            ':image' => $this->image,
            ':quantity' => $this->quantity,
            ':id' => $id
        ]);
    }

    // Lấy sản phẩm theo ID
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    // Xóa sản phẩm
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Lấy tất cả sản phẩm
    public function getAllProducts()
    {
        $stmt = $this->db->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getProductsByCategory($categoryId)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE category_id = :category_id");
        $stmt->execute(['category_id' => $categoryId]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getProductById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    // Lấy danh sách danh mục
    public function getCategories()
    {
        $stmt = $this->db->prepare("SELECT * FROM categories"); // Giả định có bảng categories
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ); // Trả về danh sách các danh mục
    }

    // Thiết lập thuộc tính sản phẩm
    public function setProductData($name, $price, $description, $category_id, $image, $quantity)
    {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->category_id = $category_id;
        $this->image = $image;
        $this->quantity = $quantity; // Thêm số lượng vào phương thức thiết lập
    }

    // Cập nhật thông tin sản phẩm
    public function setProductDetails($id, $name, $price, $description, $category_id, $quantity, $image)
    {
        // Thiết lập lại thông tin sản phẩm
        $this->id = $id; // Lưu ID sản phẩm
        $this->setProductData($name, $price, $description, $category_id, $image, $quantity); // Gọi phương thức thiết lập

        // Cập nhật vào cơ sở dữ liệu
        return $this->update($id); // Gọi phương thức update
    }
}
