<?php

namespace CT275\Labs;

use PDO;

class Order
{
    private ?PDO $db;
    // Hàm khởi tạo
    public function __construct(?PDO $PDO)
    {
        $this->db = $PDO;
    }

    // Thêm đơn hàng mới
    public function create($customer_name, $product_id, $address, $total_price, $status)
    {
        $stmt = $this->db->prepare("INSERT INTO orders (customer_name, product_id, address, total_price, status, created_at, updated_at) VALUES (:customer_name, :product_id, :address, :total_price, :status, NOW(), NOW())");
        return $stmt->execute([
            ':customer_name' => $customer_name,
            ':product_id' => $product_id,
            ':address' => $address,
            ':total_price' => $total_price,
            ':status' => $status
        ]);
    }


    // Lấy tất cả đơn hàng
    public function getAllOrders()
    {
        $stmt = $this->db->prepare("SELECT * FROM orders");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    // Lấy đơn hàng theo ID
    public function getOrderById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    // Cập nhật đơn hàng
    public function update($id, $customer_name, $product_id, $address, $total_price, $status)
    {
        $stmt = $this->db->prepare("UPDATE orders SET customer_name = :customer_name, product_id = :product_id, address = :address, total_price = :total_price, status = :status, updated_at = NOW() WHERE id = :id");
        return $stmt->execute([
            ':customer_name' => $customer_name,
            ':product_id' => $product_id,
            ':address' => $address,
            ':total_price' => $total_price,
            ':status' => $status,
            ':id' => $id
        ]);
    }

    // Xóa đơn hàng
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM orders WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
