document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar el envío del formulario
  
    // Datos de prueba
    const usuariosValidos = [
      { username: 'admin', password: '1234' },
      { username: 'user1', password: 'password1' },
      { username: 'user2', password: 'password2' }
    ];
  
    // Obtener los valores ingresados por el usuario
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
  
    // Verificar si las credenciales coinciden con algún usuario válido
    const usuarioValido = usuariosValidos.find(user => user.username === username && user.password === password);
  
    if (usuarioValido) {
      alert('Inicio de sesión exitoso');
      // Redirigir a la página principal o dashboard
      window.location.href = 'index.html';
    } else {
      document.getElementById('errorMessage').textContent = 'Usuario o contraseña incorrectos';
    }
  });