<?php
require_once '../includes/config.php'
?>

<body>
    <?php require_once __DIR__ . '/../includes/header.php'; ?>
    <div class="container mt-3">
        <h2>Giỏ Hàng</h2>
        <div id="cartItems">
            <div class="cart">
                <h2>Shopping Cart</h2>
                <ul id="cart-items">
                    <!-- Cart items will be added here -->
                </ul>
                <p>Total: $<span id="total-price">0.00</span></p>
                <button id="checkout">Checkout</button>
            </div>

        </div>
        <button id="checkoutBtn">Thanh Toán</button>
    </div>
    </div>
    <!-- <?php require_once __DIR__ . '/../includes/footder.php'; ?> -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../assets/js/product.js"></script>
</body>

</html>