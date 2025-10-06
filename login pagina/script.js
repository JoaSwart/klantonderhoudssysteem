
        const passwordInput = document.getElementById('password');
        const togglePasswordIcon = document.querySelector('.toggle-password');

        togglePasswordIcon.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          
            passwordInput.setAttribute('type', type);
           
            if (type === 'password') {
                this.textContent = 'visibility';
            } else {
                this.textContent = 'visibility_off';
            }
        });