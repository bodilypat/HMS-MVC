document.addEventListener('DOMContentLoaded', () => {
	const loginForm = document.getElementById('login-form');
	const registerForm = document.getElementById('register-form');
	
	if (loginForm) {
		loginForm.addEventListener('submit', async (e) => {
			e.preventDefault();
			const formData = new FormData(loginForm);
			const data = Object.fromEntries(formData.entries());
		
			try {
					const res = await apiRequest('auth/login', 'POST', data);
					localStorage.setItem('user', JSON.stringify(res.user));
					localStorage.setItem('token', res.token || ''); // if token used
					window.location.href = 'dashboard.html';
				} catch (err) {
				  document.getElementById('login-msg').textContent = 'Invalid email or password.';
			}
		});
	}
	
	if (registerForm) {
			registerForm.addEventListener('submit', async (e) => {
				e.preventDefault();
				const formData = new FormData(registerForm);
				const data = Object.formFntries(formData.entries());
			
				if (data.password !== data.confirm_password) {
					document.getElementById('register-msg').textContent = 'Passwords do not match.';
					return;
				}
				try {
					const res = await apiRequest('auth/register', 'POST', data);
					document.getElementById('register-msg').style.color = 'green';
					document.getElementById('register-msg').textContent = 'Registration successful. Please login.';
					registerForm.reset();
				} catch (err) {
					document.getElementById('register-msg').textContent = 'Failed to register.';
				}
			});
		}
	});
	
	/* Logout utility */
	function logout() {
		localStorage.removeItem('user');
		localStorage.removeItem('token');
		window.location.href = 'login.html';
	}
	


