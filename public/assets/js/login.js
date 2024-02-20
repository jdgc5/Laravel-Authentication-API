(() => {
    'use strict';
    const csrf = document.querySelector('meta[name="csrf-token"]')['content'];
    const url = document.querySelector('meta[name="url-base"]')['content'];
    
    function updateModalContent(userData){
        document.getElementById('password-label').textContent = 'User';
        document.getElementById('password').value = userData.name;
        document.getElementById('password').type = 'text';
        document.getElementById('email').value = userData.email;
        document.getElementById('btn-login').style.display = 'none';
        document.getElementById('btn-logout').style.display = 'block';
        document.getElementById('login').style.display = 'none';
        document.getElementById('logout').style.display = 'flex';
    } 
    
    function resetModalContent() {
        document.getElementById('password-label').textContent = 'Password';
        document.getElementById('password').value = '';
        document.getElementById('password').type = 'password';
        document.getElementById('email').value = '';
        document.getElementById('btn-login').style.display = 'block';
        document.getElementById('btn-logout').style.display = 'none';
        document.getElementById('login').style.display = 'flex';
        document.getElementById('logout').style.display = 'none';
    }
    
    document.addEventListener("DOMContentLoaded", function(event) {
        let loginDiv = document.getElementById('loginDiv');
        
        document.getElementById('btn-logout').addEventListener('click', function() {
            fetch(url + '/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('accessToken')
                }
            })
            .then(response => {
                if (response.ok) {
                    localStorage.removeItem('accessToken');
                    resetModalContent();

                } else {
                    // Manejar errores de respuesta
                    console.error('Error al realizar logout:', response.statusText);
                }
            })
            .catch(error => {
                console.error('Error al realizar logout:', error);
            });
        });

        fetch(url + '/api/user', {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
            },
        })
        .then(response => response.json())
        .then((data) => {
            if(data.user != null) {
                updateModalContent(data.user);
            } else {
                resetModalContent();
            }
        })
        .catch(error => {
            console.log("Error:", error);
        });
        
        // Agregar evento 'click' al botón de login
        document.getElementById('btn-login').onclick = (e) => {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
        
            fetch(url + '/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email, password }),
            })
            .then(response => response.json())
            .then(data => {
                localStorage.setItem('accessToken', data.access_token);
                // Hacer una solicitud para obtener la información del usuario
                fetch(url + '/api/user', {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + data.access_token,
                    },
                })
                .then(response => response.json())
                .then((data) => {
                                if(data.user != null) {
                updateModalContent(data.user);
            } else {
                resetModalContent();
            }
                });
            })
            .catch(error => {
                console.error('Error de inicio de sesión:', error);
            });
        };
    });
})();
