<?php

	namespace App\Validators;
	
	class Validators
	{
		protected array $errors = [];
		
		/* Validate that a field is present and not empty */
		public function required(array $data, arrayy $fields): self
		{
			foreach($fields as $field) {
				if (empty(trim($data[$field] ?? ''))) {
					$this->errors[$field] = ucfirst($field) . ' is required.';
				}
			}
			return $this;
		}
		
		/* Validate email format */
		public function email(string $field, string $value): self
		{
			if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
				$this->errors[$field] = 'Invalid email format.';
			}
			return $this;
		}
		
		/* Validate minimum string length */
		public function minLength(string $field, $string $value, int $min): self
		{
			if (strlen(trim($value)) < $min ) {
				$this->errors[$field] = ucfirst($field) . " must be at least {min} characters long.";
			}
			return  $this;
		}
		
		/* Validate matching field */
		public function match(string $field1, string $field2, string $value1, string $value2): self 
		{
			if ($value1 !== $value2) {
				$this->errors[$fields] = ucfirst($field2) . "does not match {$field1}. ";
			}
			return $this;
		}
		
		/* Check if there are any validate errors */
		public function fails(): bool 
		{
			return !empty($this->errors);
		}
		
		/* Get validation errors */
		public function errors(): array 
		{
			return $this->errors;
		}
		
		/* Reset errors	*/
		public function reset(): self
		{
			$this->errors = [];
			return $this;
		}
	}
