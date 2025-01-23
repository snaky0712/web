<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Usuario registrado</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f1f1f1;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .error-message {
                    background-color: #ffffff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    width: 100%;
                    max-width: 400px;
                    text-align: center;
                }
                .error-message p {
                    color: #d9534f;
                    font-size: 18px;
                }
                .error-message button {
                    background-color: #636363;
                    color: white;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 16px;
                }
                .error-message button:hover {
                    background-color: #4b4b4b;
                }
            </style>
        </head>
        <body>
            <div class="error-message">
                <p>Cuenta registrada</p>

            </div>

            <script>

        setTimeout(function() {
            window.location.href = 'index.php';
        }, 2000);
    </script>
        </body>
        </html>