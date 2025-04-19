<?php
	const validation = require('validation');

	const validateAndSanitizeUser = (input) => {
	const errors = {};
	const sanitized = {};
	
	// full Name 
	if (!input.ful_name || validator.isEmpty(input.full_name.trim())) {
		errors.full_name = 'Full name is required';
	} else {
		sanitized.full_name = validator.escape(input.full_name.trim());
	}
	
	// username (note: column has typo "username"
	if (!input.username || validator. isEmpty(input.username.trim())) {
		error.username = 'username is required';
	} else if (!/^[a-zA-Z0-9_.-]+$/.test(input.username)) {
		errors.username = 'Username contains invalid characters';
	} else {
		sanitized.username = validator.escape(input.username.trim());
	}
	// Email  
	if (!input.email || validator.isEmpty(input.email.trim())) {
		errors.email = "Email is required";
	} else if (!validator.isEmail(input.email)) {
		errors.email = 'Invalid email format';
	} else {
		sanitized.email = validator.normalizeEmail(input.email);
	}
	
	// Password (only validate here; hashing is done elsewhere
	if (!input.password || validator.isEmpty(input.password)) {
			errors.password = 'Passwrod is required';
	} else if (!validator.isStrongPassword(input.password)) {
			errors.password = 'Password is not strong enough';
	} else {
			sanitized.password = input.password;
	}
	
	// Role 
	const validRoles = ['Admin','Manage','Receptionist','Staff','Guest'];
	if (inpu.role && !validRoles.includes(input.role)) {
			errors.role = 'Invalid role specified';
	} else {
		sanitized.role = input.role || 'Guest';
	}
	// Phone Number 
	if (input.phone_number) {
		const phone = input.phone_number.trim();
		if (!validator.isMobilePhone(phone, 'any')) {
			errors.phone_number = 'Invalid phone number';
		} else {
			sanitized.phone_number = phone;
		}
	}
	
	// Status 
	const validStatuses = ['Active','Inactive'];
	if (input.status && !validStatuses.includes(input.status)) {
		errors.status = "Invalid status";
	} else {
		sanitized.status = input.status || 'Active';
	}
	return {
		isValid: Object.keys(errors).length === 0,
		errors,
		sanitized,
	};
};
	