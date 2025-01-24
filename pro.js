// Array para almacenar los productos registrados
let registeredProducts = [];

// Referencias a los elementos del formulario
const productForm = document.getElementById('productForm');
const productList = document.getElementById('productList');

// Función para verificar si un producto ya está registrado
function isProductRegistered(productName) {
    return registeredProducts.some(product => product.name.toLowerCase() === productName.toLowerCase());
}

// Función para agregar el producto a la lista de registrados
function addProductToList(productName, productPrice) {
    // Crear un nuevo elemento en la lista
    const listItem = document.createElement('li');
    listItem.textContent = ${productName} - $${productPrice.toFixed(2)};
    
    // Agregar el producto a la lista visual en HTML
    productList.appendChild(listItem);
}

// Función para manejar el envío del formulario
productForm.addEventListener('submit', function(event) {
    event.preventDefault();

    const productName = document.getElementById('productName').value.trim();
    const productPrice = parseFloat(document.getElementById('productPrice').value);

    // Verificar si el producto ya está registrado
    if (isProductRegistered(productName)) {
        alert(El producto "${productName}" ya está registrado.);
    } else {
        // Registrar el producto
        registeredProducts.push({ name: productName, price: productPrice });

        // Añadirlo a la lista visible
        addProductToList(productName, productPrice);

        // Mostrar mensaje de éxito
        alert(Producto "${productName}" registrado con éxito.);

        // Limpiar el formulario
        productForm.reset();
    }
});