// form.js
// Reusable form handlers for add and edit customer forms

// Handle input change for a form state object
export function handleInputChange(e, formState, setFormState) {
  setFormState({ ...formState, [e.target.name]: e.target.value });
}

// Reset form state to initial values
export function resetForm(setFormState, initialState) {
  setFormState(initialState);
}