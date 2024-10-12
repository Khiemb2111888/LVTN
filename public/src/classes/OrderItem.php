<?php

namespace CT275\Labs;

class OrderItem
{
    private $db;

    public $id;
    public $order_id;
    public $product_id;
    public $quantity;
    public $price;
    public $total_price;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    // Phương thức để thêm chi tiết sản phẩm vào đơn hàng
    public function create($orderId, $productId, $quantity, $price)
    {
        $stmt = $this->db->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)');
        return $stmt->execute([$orderId, $productId, $quantity, $price]);
    }


    // Phương thức để lấy chi tiết sản phẩm theo mã đơn hàng
    public function getOrderItemsByOrderId($order_id)
    {
        $stmt = $this->db->prepare("
            SELECT oi.*, p.name AS product_name 
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = :order_id
        ");

        $stmt->execute(['order_id' => $order_id]);

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    // Phương thức để tính tổng giá trị của tất cả sản phẩm trong một đơn hàng
    public function calculateTotalPrice($order_id)
    {
        $stmt = $this->db->prepare("
            SELECT SUM(quantity * price) AS total_price 
            FROM order_items 
            WHERE order_id = :order_id
        ");
        $stmt->execute(['order_id' => $order_id]);

        return $stmt->fetchColumn();
    }

    // Trong class OrderItem (src/classes/OrderItem.php):
    public function deleteItemsByOrderId($orderId)
    {
        $stmt = $this->db->prepare('DELETE FROM order_items WHERE order_id = :order_id');
        return $stmt->execute(['order_id' => $orderId]);
    }
}
