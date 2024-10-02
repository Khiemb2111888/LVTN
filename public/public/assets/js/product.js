// Danh sách sản phẩm với giá và số lượng
const products = {
  1: { name: "Product 1", price: 10.0, image: "../assets/img/banner1.jpg" },
  2: { name: "Product 2", price: 20.0, image: "../assets/img/banner2.jpg" },
  3: { name: "Product 3", price: 30.0, image: "../assets/img/banner3.jpg" },
};

let cart = {}; // Giỏ hàng

// Cập nhật giỏ hàng trên giao diện
function updateCart() {
  const cartItems = document.getElementById("cart-items");
  const totalPriceElement = document.getElementById("total-price");
  cartItems.innerHTML = "";
  let totalPrice = 0;

  for (let id in cart) {
    const product = products[id];
    const quantity = cart[id];
    const itemTotal = product.price * quantity;
    totalPrice += itemTotal;

    const listItem = document.createElement("li");

    // Tạo thẻ hình ảnh
    const img = document.createElement("img");
    img.src = product.image;
    img.alt = product.name;

    // Tạo nút xóa
    const removeButton = document.createElement("button");
    removeButton.textContent = "Remove";
    removeButton.className = "remove-from-cart";
    removeButton.addEventListener("click", () => {
      removeFromCart(id);
    });

    // Tạo nội dung của mục giỏ hàng
    listItem.innerHTML = `
            ${product.name} - $${product.price.toFixed(
      2
    )} x ${quantity} = $${itemTotal.toFixed(2)}
        `;
    listItem.prepend(img); // Thêm hình ảnh vào đầu mục
    listItem.appendChild(removeButton); // Thêm nút xóa vào cuối mục

    cartItems.appendChild(listItem);
  }

  totalPriceElement.textContent = totalPrice.toFixed(2);
}

// Thêm sản phẩm vào giỏ hàng
function addToCart(productId) {
  if (!cart[productId]) {
    cart[productId] = 1;
  } else {
    cart[productId]++;
  }
  updateCart();
}

// Xóa sản phẩm khỏi giỏ hàng
function removeFromCart(productId) {
  delete cart[productId];
  updateCart();
}

// Xử lý sự kiện khi nhấn nút "Add to Cart"
document.querySelectorAll(".add-to-cart").forEach((button) => {
  button.addEventListener("click", () => {
    const productId = button.parentElement.dataset.id;
    addToCart(productId);
  });
});

// Xử lý sự kiện khi nhấn nút "Checkout"
document.getElementById("checkout").addEventListener("click", () => {
  if (Object.keys(cart).length === 0) {
    alert("Your cart is empty!");
  } else {
    alert("Checkout process...");
    // Xử lý thanh toán ở đây
  }
});

function openTab(evt, tabName) {
  var i, tabcontent, tablinks;

  // Ẩn tất cả các tab
  tabcontent = document.getElementsByClassName("tab-content");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Loại bỏ class "active" từ tất cả các nút
  tablinks = document.getElementsByClassName("tab-button");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Hiển thị tab hiện tại và thêm class "active" vào nút đã nhấn
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Mặc định hiển thị tab đầu tiên
document.getElementById("tab1").style.display = "block";
