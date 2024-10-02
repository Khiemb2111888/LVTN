<?php
require_once __DIR__ . '/../src/bootstrap.php';
require_once __DIR__ . '/../src/partials/header.php';
?>
<div class="container mt-3">
    <!-- Nav tabs -->
    <div class="tab-links">
        <button class="tab-button active" onclick="openTab(event, 'tab1')">Tab 1</button>
        <button class="tab-button" onclick="openTab(event, 'tab2')">Tab 2</button>
        <button class="tab-button" onclick="openTab(event, 'tab3')">Tab 3</button>
        <button class="tab-button" onclick="openTab(event, 'tab4')">Tab 4</button>
    </div>

    <!-- Tab panes -->
    <div id="tab1" class="tab-content active product-list">
        <div class="row">
            <div class="product border mx-2" data-id="1">
                <img src="../assets/img/banner2.jpg" alt="Product 1" class="product-image">
                <h2>Product 1</h2>
                <p>Price: $10.00</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product border mx-2" data-id="1">
                <img src="../assets/img/banner2.jpg" alt="Product 1" class="product-image">
                <h2>Product 1</h2>
                <p>Price: $10.00</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product border mx-2" data-id="1">
                <img src="../assets/img/banner2.jpg" alt="Product 1" class="product-image">
                <h2>Product 1</h2>
                <p>Price: $10.00</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product border mx-2" data-id="1">
                <img src="../assets/img/banner2.jpg" alt="Product 1" class="product-image">
                <h2>Product 1</h2>
                <p>Price: $10.00</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
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
<div id="tab2" class="tab-content">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12 grid-item">Item 2A</div>
        <div class="col-md-3 col-sm-6 col-xs-12 grid-item">Item 2B</div>
        <div class="col-md-3 col-sm-6 col-xs-12 grid-item">Item 2C</div>
        <div class="col-md-3 col-sm-6 col-xs-12 grid-item">Item 2D</div>
    </div>
</div>
<div id="tab3" class="tab-content">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12 grid-item">Item 3A</div>
        <div class="col-md-3 col-sm-6 col-xs-12 grid-item">Item 3B</div>
        <div class="col-md-3 col-sm-6 col-xs-12 grid-item">Item 3C</div>
        <div class="col-md-3 col-sm-6 col-xs-12 grid-item">Item 3D</div>
    </div>
</div>
<?php include_once __DIR__ . '/../src/partials/footer.php'; ?>
</body>

</html>