<script>
    let productsModal;
let cartModal;
let cart = [];

// Initialize modals when page loads
document.addEventListener('DOMContentLoaded', function() {
    productsModal = new bootstrap.Modal(document.getElementById('productsModal'));
    cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
    console.log('Modals initialized');
});

// Load products function
function loadProducts(categoryId) {
    console.log('Loading products for category:', categoryId);
    
    const container = document.getElementById('productsContainer');
    container.innerHTML = '<div class="col-12 text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Loading products...</p></div>';
    
    productsModal.show();
    
    
    fetch(`/api/products?categoryId=${categoryId}`)
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Parsed data:', data);
            displayProducts(data);
        })
        .catch(error => {
            console.error('Fetch error:', error);
            container.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-danger">
                        <strong>Error loading products:</strong> ${error.message}
                    </div>
                </div>`;
        });
}

function displayProducts(response) {
    const container = document.getElementById('productsContainer');
    
    let products = [];
    if (Array.isArray(response)) {
        products = response;
    } else if (response.data && response.data.records) {
        products = response.data.records;
    } else if (response.data) {
        products = Array.isArray(response.data) ? response.data : [response.data];
    } else if (response.products) {
        products = response.products;
    }
    
    console.log('Products to display:', products);
    container.innerHTML = '';
    
    if (!products || products.length === 0) {
        container.innerHTML = `
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No products found in this category.
                </div>
            </div>`;
        return;
    }
    
    products.forEach(product => {
        const inCart = cart.find(item => item.id === product.id);
        const quantity = inCart ? inCart.quantity : 0;
        
        const productCard = document.createElement('div');
        productCard.className = 'col-md-3 col-sm-6';
        productCard.innerHTML = `
            <div class="card shadow-sm h-100">
                <img src="${product.image || 'https://via.placeholder.com/200'}" 
                     class="card-img-top" 
                     alt="${product.title || product.name}"
                     style="height: 160px; object-fit: cover;"
                     onerror="this.src='https://via.placeholder.com/200'">
                <div class="card-body text-center">
                    <h6 class="card-title">${product.title || product.name}</h6>
                    <p class="text-primary fw-bold mb-2">${product.price} EGP</p>
                    ${product.discount > 0 ? `<p class="text-danger small mb-2">Discount: ${product.discount}%</p>` : ''}
                    
                    <div class="d-flex align-items-center justify-content-center gap-2" id="product-${product.id}">
                        ${quantity > 0 ? `
                            <button class="btn btn-sm btn-outline-danger" onclick="decreaseQuantity(${product.id})">-</button>
                            <span class="fw-bold px-2">${quantity}</span>
                            <button class="btn btn-sm btn-outline-primary" onclick="increaseQuantity(${product.id})">+</button>
                        ` : `
                            <button class="btn btn-primary btn-sm w-100" onclick="addToCart(${product.id}, '${product.title || product.name}', ${product.price}, '${product.image || ''}' , '${product.discount || 0}')">
                                Add to Cart
                            </button>
                        `}
                    </div>
                </div>
                
            </div>
        `;
        container.appendChild(productCard);
    });
// هنتأكد إن في paginationContainer واحد ونستخدمه
let paginationContainer = document.getElementById('paginationContainer');

// لو مش لقيته نعمله ونلصقه تحت الكونتينر الرئيسي (container متواجد بالفعل في الكود بتاعك)
if (!paginationContainer) {
    const paginationWrapper = document.createElement('div');
    paginationWrapper.className = 'mt-3';
    paginationWrapper.innerHTML = `<div id="paginationContainer" class="mt-4"></div>`;
    container.appendChild(paginationWrapper);
    paginationContainer = document.getElementById('paginationContainer');
}

// نظف المحتوى القديم
paginationContainer.innerHTML = '';

if (response.data.paginationLinks) {
    console.log(response.data.paginationLinks);
    
    const p = response.data.paginationLinks;
    const links = p.links || {};

    const pagination = document.createElement('div');
    pagination.className = 'd-flex flex-column align-items-center mt-4';

    // Row 1: Page info
    const info = document.createElement('p');
    info.className = 'mb-2 small text-muted';
    info.textContent = `Page ${p.currentPage} of ${p.lastPage} (${p.total} products)`;
    pagination.appendChild(info);

    // Row 2: Buttons wrapper
    const buttons = document.createElement('div');
    buttons.className = 'd-flex gap-2';

    // Helper لإنشاء زرار
    function makeButton(label, url, disabledIf) {
        const btn = document.createElement('button');
        btn.className = 'btn btn-outline-primary btn-sm';
        btn.type = 'button';
        btn.textContent = label;

        if (disabledIf) {
            btn.disabled = true;
            btn.className = 'btn btn-outline-secondary btn-sm';
            return btn;
        }

        if (url) {
            btn.addEventListener('click', function () {
                // loadProducts ممكن ترجع مسار كامل أو نسق relative، اتأكد ان دالتك بتتعامل مع الاتنين
                const params = new URLSearchParams(url.split('?')[1]);

                const urlParams = `${params.get('categoryId')}&page=${params.get('page')}`;
                console.log(urlParams);
                
                loadProducts(urlParams);
            });
        } else {
            btn.disabled = true;
            btn.className = 'btn btn-outline-secondary btn-sm';
        }

        return btn;
    }

    // First
    const firstDisabled = !links.first || p.currentPage === 1;
    buttons.appendChild(makeButton('« First', links.first, firstDisabled));

    // Prev
    const prevDisabled = !links.previous;
    buttons.appendChild(makeButton('‹ Prev', links.previous, prevDisabled));

    // Next 
    const nextDisabled = !links.next;
    buttons.appendChild(makeButton('Next ›', links.next, nextDisabled));

    // Last
    const lastDisabled = !links.last || p.currentPage === p.lastPage;
    buttons.appendChild(makeButton('Last »', links.last, lastDisabled));

    pagination.appendChild(buttons);
    paginationContainer.appendChild(pagination);
}


}

function addToCart(product_id, title, price, image ,discount ) {
    const existingItem = cart.find(item => item.product_id === product_id);
    
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({ product_id, title, price, image, discount ,quantity: 1 });
    }
    
    updateCartCount();
    updateProductDisplay(product_id);
}

function increaseQuantity(id) {
    const item = cart.find(item => item.product_id === id);
    if (item) {
        item.quantity++;
        updateCartCount();
        updateProductDisplay(id);
    }
}

function decreaseQuantity(id) {
    const item = cart.find(item => item.product_id === id);
    if (item) {
        item.quantity--;
        if (item.quantity === 0) {
            cart = cart.filter(i => i.product_id !== id);
        }
        updateCartCount();
        updateProductDisplay(id);
    }
}

function updateProductDisplay(id) {
    const productDiv = document.getElementById(`product-${id}`);
    const item = cart.find(i => i.product_id === id);
    
    if (item && item.quantity > 0) {
        productDiv.innerHTML = `
            <button class="btn btn-sm btn-outline-secondary" onclick="decreaseQuantity(${id})">-</button>
            <span class="fw-bold px-2">${item.quantity}</span>
            <button class="btn btn-sm btn-outline-secondary" onclick="increaseQuantity(${id})">+</button>
        `;
    } else {
        productDiv.innerHTML = `
            <button class="btn btn-primary btn-sm w-100" onclick="addToCart(${id}, '${item?.title || ''}', ${item?.price || 0}, '${item?.image || ''}')">
                Add to Cart
            </button>
        `;
    }
}

function updateCartCount() {
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    document.getElementById('cartCount').textContent = totalItems;
}

function viewCart() {
    const container = document.getElementById('cartContainer');
    
    if (cart.length === 0) {
        container.innerHTML = '<div class="alert alert-info text-center">Your cart is empty</div>';
        document.getElementById('cartTotal').textContent = '0';
    } else {
        let total = 0;
        let tableHTML = `
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        cart.forEach(item => {
            const subtotal =  item.price * (1 - item.discount / 100) *item.quantity;
            total += subtotal;
            
            tableHTML += `
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="${item.image || 'https://via.placeholder.com/50'}"
                                 style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;"
                                 onerror="this.src='https://via.placeholder.com/50'">
                            <span>${item.title}</span>
                        </div>
                    </td>
                    <td>${item.price} EGP</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-outline-secondary" onclick="decreaseQuantity(${item.product_id}); viewCart();">-</button>
                            <span>${item.quantity}</span>
                            <button class="btn btn-sm btn-outline-secondary" onclick="increaseQuantity(${item.product_id}); viewCart();">+</button>
                        </div>
                    </td>
                    <td class="fw-bold">${subtotal} EGP</td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="removeFromCart(${item.product_id}); viewCart();">Remove</button>
                    </td>
                </tr>
            `;
        });

        tableHTML += `
                    </tbody>
                </table>
            </div>
        `;

        tableHTML += `
            <div class="mt-4 p-3 border rounded bg-light">
                <h6 class="mb-3">Customer Details</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Select User</label>
                        <select id="orderUser" class="form-select" onchange="loadUserAddresses(this.value)">
                            <option value="">-- Choose user --</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Select Address</label>
                        <select id="userAddress" class="form-select" disabled onchange="loadAddress(this.value)">
                            <option value="">-- Choose address --</option>
                        </select>
                    </div>
                </div>
            </div>
             <div class="row mb-3">
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <div class="form-control d-flex">
                                        <div class="form-check form-check-inline m-2">
                                            <input class="form-check-input" type="radio" name="payment_method" id="payment_cash" value="cash" onchange="selectPaymentMethod('cash')">
                                            <label class="form-check-label">Cash on Delivery</label>
                                        </div>
                                        <div class="form-check form-check-inline m-2">
                                            <input class="form-check-input" type="radio" name="payment_method" id="payment_online" value="online" onchange="selectPaymentMethod('online')">
                                            <label class="form-check-label">Online Payment</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
        `;

        container.innerHTML = tableHTML;
        document.getElementById('cartSubtotal').textContent = total;

        cart['total'] = total;


        loadUsers();

        productsModal.hide();
        cartModal.show();
    }
}


function selectPaymentMethod(method){
    cart['payment_method'] = method;
}

function loadAddress(addressId) {
    fetch(`/api/address/${addressId}`) 
        .then(res => res.json())
        .then(response => {
            const address= response.data || response; 
            cart['shipping_cost'] = address.city.shipping_cost|| 0
            document.getElementById('cartShippingCost').textContent =  cart['shipping_cost'];

        })
        .catch(err => console.error('Error loading address:', err));
}
function loadUsers() {
    fetch('/api/users') 
        .then(res => res.json())
        .then(response => {
            const users = response.data || response; 
            const userSelect = document.getElementById('orderUser');
            userSelect.innerHTML = '<option value="">-- Choose user --</option>';

            users.forEach(user => {
                userSelect.innerHTML += `<option value="${user.id}">${user.name} (${user.phone})</option>`;
            });
        })
        .catch(err => console.error('Error loading users:', err));
}


function loadUserAddresses(userId) {
    const addressSelect = document.getElementById('userAddress');
    if (!userId) {
        addressSelect.innerHTML = '<option value="">-- Choose address --</option>';
        addressSelect.disabled = true;
        return;
    }

    fetch(`/api/users/${userId}/addresses`)
        .then(res => res.json())
        .then(response => {
            const addresses = response.data || response;
            addressSelect.innerHTML = '<option value="">-- Choose address --</option>';
            
            if (addresses.length > 0) {
                addresses.forEach(address => {
                    addressSelect.innerHTML += `<option value="${address.id}">${address.city +"/"+address.street+"/"+address.building +"/"+address.floor+"/"+address.apartment  || address.details}</option>`;
                    cart['address_id']=address.id;
                    cart['user_id']=userId;
                });
                addressSelect.disabled = false;
            } else {
                addressSelect.innerHTML = '<option value="">No addresses found</option>';
                addressSelect.disabled = true;
            }
        })
        .catch(err => console.error('Error loading addresses:', err));        
    }


function removeFromCart(id) {
    cart = cart.filter(item => item.product_id !== id);
    updateCartCount();
    viewCart();
}

function submitOrder() {
    if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
    }

    const form = document.getElementById('orderForm');
    form.innerHTML = ''; 

    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    form.appendChild(csrfInput);

    cart.forEach((item, index) => {
        ['product_id', 'quantity'].forEach(key => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `items[${index}][${key}]`;
            input.value = item[key];
            form.appendChild(input);
        });
    });

   
    
    const subtotalInput = document.createElement('input');
    subtotalInput.type = 'hidden';
    subtotalInput.name = 'subtotal_price';
    subtotalInput.value = cart.total;
    form.appendChild(subtotalInput);
    
    const totalInput = document.createElement('input');
    totalInput.type = 'hidden';
    totalInput.name = 'total_price';
    totalInput.value = cart.total + cart.shipping_cost;
    form.appendChild(totalInput);
    
    const addressIdInput = document.createElement('input');
    addressIdInput.type = 'hidden';
    addressIdInput.name = 'address_id';
    addressIdInput.value = cart.address_id;
    form.appendChild(addressIdInput);
    
    const userIdInput = document.createElement('input');
    userIdInput.type = 'hidden';
    userIdInput.name = 'user_id';
    userIdInput.value = cart.user_id;
    form.appendChild(userIdInput);
    
    const payment_method = document.createElement('input');
    payment_method.type = 'hidden';
    payment_method.name = 'payment_method';
    payment_method.value = cart.payment_method;
    form.appendChild(payment_method);   
    
    const shipping_cost = document.createElement('input');
    shipping_cost.type = 'hidden';
    shipping_cost.name = 'shipping_cost';
    shipping_cost.value = cart.shipping_cost;
    form.appendChild(shipping_cost);   
    

    document.body.appendChild(form);
    console.log('Submitting form with cart data:', cart);
    form.submit();
}
</script>