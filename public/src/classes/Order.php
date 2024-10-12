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
    public function create($customerName, $address, $totalPrice, $status)
    {
        $stmt = $this->db->prepare('
            INSERT INTO orders (customer_name, address, total_price, status, created_at) 
            VALUES (:customer_name, :address, :total_price, :status, NOW())
        ');

        return $stmt->execute([
            ':customer_name' => $customerName,
            ':address' => $address,
            ':total_price' => $totalPrice,
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
    public function update($id, $customer_name, $address, $total_price, $status)
    {
        $stmt = $this->db->prepare("UPDATE orders SET customer_name = :customer_name = :product_id, address = :address, total_price = :total_price, status = :status, updated_at = NOW() WHERE id = :id");
        return $stmt->execute([
            ':customer_name' => $customer_name,
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
    public function addOrderItem($orderId, $productId, $quantity, $price)
    {
        $stmt = $this->db->prepare("
        INSERT INTO order_items (order_id, product_id, quantity, price) 
        VALUES (:order_id, :product_id, :quantity, :price)
    ");
        $stmt->execute([
            'order_id' => $orderId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $price
        ]);
    }
    public function getOrderItems($orderId)
    {
        $stmt = $this->db->prepare("
        SELECT p.name, oi.quantity, oi.price, oi.total_price 
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = :order_id
    ");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function calculateTotalPrice($orderId)
    {
        $stmt = $this->db->prepare("
        SELECT SUM(total_price) AS total_price 
        FROM order_items 
        WHERE order_id = :order_id
    ");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchColumn();
    }

    public function updateStatus($orderId, $status)
    {
        $stmt = $this->db->prepare("
        UPDATE orders SET status = :status, updated_at = NOW() 
        WHERE id = :id
    ");
        return $stmt->execute(['status' => $status, 'id' => $orderId]);
    }

    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }
}
