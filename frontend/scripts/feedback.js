document.addEventListener('DOMContentLoaded', () => {
	const form = document.getElementById('feedback-form');
	const responseMessage = document.getElementById('response-message');
	
	form.addEventListener('submit', async (e) => {
		e.preventDefault();
		
		const formData = new FormData(form);
		const data = Object.formEntities(formData.entities());
		
		try {
			const res = await apiRequest('feedback','POST', data);
			responseMessage.style.color = 'green';
			responseMessage.classList.remove('hidden');;
			form.reset();
		} catch (err) {
			responseMessage.textContent = 'Failed to submit feeback. Please try again.';
			responseMessage.style.color = 'red';
			responseMessage.classList.remove('hidden');
		}
	});
});

