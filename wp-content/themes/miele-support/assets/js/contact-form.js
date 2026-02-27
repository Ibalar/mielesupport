/**
 * Contact Form Multi-Step Handler
 *
 * Handles step navigation, validation, and form submission
 */
(function () {
    'use strict';

    // DOM Elements
    const form = document.getElementById('contact-form');
    if (!form) return;

    const steps = form.querySelectorAll('.contact-form__step[data-step]');
    const stepIndicators = document.querySelectorAll('.contact-form__step-indicator');
    const stepLines = document.querySelectorAll('.contact-form__step-line');

    // Buttons
    const nextButtons = form.querySelectorAll('.contact-form__btn-next');
    const backButtons = form.querySelectorAll('.contact-form__btn-back');
    const previewButton = form.querySelector('.contact-form__btn-preview');
    const submitButton = form.querySelector('.contact-form__btn-submit');
    const resetButton = form.querySelector('.contact-form__btn-reset');

    // Form fields
    const categorySelect = document.getElementById('category');
    const brandSelect = document.getElementById('brand');
    const problemTextarea = document.getElementById('problem_description');
    const nameInput = document.getElementById('contact_name');
    const phoneInput = document.getElementById('contact_phone');
    const emailInput = document.getElementById('contact_email');

    // Current step tracking
    let currentStep = 1;
    const totalSteps = 3;

    /**
     * Initialize the form
     */
    function init() {
        bindEvents();
        updateStepIndicators();
    }

    /**
     * Bind event listeners
     */
    function bindEvents() {
        // Next buttons
        nextButtons.forEach(button => {
            button.addEventListener('click', handleNextClick);
        });

        // Back buttons
        backButtons.forEach(button => {
            button.addEventListener('click', handleBackClick);
        });

        // Preview button
        if (previewButton) {
            previewButton.addEventListener('click', handlePreviewClick);
        }

        // Form submission
        form.addEventListener('submit', handleSubmit);

        // Reset button
        if (resetButton) {
            resetButton.addEventListener('click', handleReset);
        }

        // Real-time validation
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', () => validateField(input));
            input.addEventListener('input', () => clearFieldError(input));
        });
    }

    /**
     * Handle Next button click
     */
    function handleNextClick(e) {
        const button = e.target;
        const nextStep = parseInt(button.dataset.next, 10);

        // Validate current step before proceeding
        if (!validateStep(currentStep)) {
            return;
        }

        // If going to step 3 from step 2, update review data
        if (currentStep === 2 && nextStep === 3) {
            updateReviewData();
        }

        goToStep(nextStep);
    }

    /**
     * Handle Back button click
     */
    function handleBackClick(e) {
        const button = e.target;
        const backStep = parseInt(button.dataset.back, 10);
        goToStep(backStep);
    }

    /**
     * Handle Preview button click (go to step 2)
     */
    function handlePreviewClick() {
        if (!validateStep(1)) {
            return;
        }
        updateReviewData();
        goToStep(2);
    }

    /**
     * Navigate to a specific step
     */
    function goToStep(step) {
        // Hide all steps
        steps.forEach(s => s.classList.add('contact-form__step--hidden'));

        // Show target step
        const targetStep = form.querySelector(`.contact-form__step[data-step="${step}"]`);
        if (targetStep) {
            targetStep.classList.remove('contact-form__step--hidden');
        }

        // Update current step
        currentStep = step;

        // Update step indicators
        updateStepIndicators();

        // Scroll to top of form
        const formWrapper = document.querySelector('.contact-form-wrapper');
        if (formWrapper) {
            formWrapper.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    /**
     * Update step indicators visual state
     */
    function updateStepIndicators() {
        stepIndicators.forEach((indicator, index) => {
            const stepNum = index + 1;
            indicator.classList.remove('active', 'completed');

            if (stepNum === currentStep) {
                indicator.classList.add('active');
            } else if (stepNum < currentStep) {
                indicator.classList.add('completed');
            }
        });

        // Update step lines
        stepLines.forEach((line, index) => {
            line.classList.remove('completed');
            if (index < currentStep - 1) {
                line.classList.add('completed');
            }
        });
    }

    /**
     * Validate a specific step
     */
    function validateStep(step) {
        let isValid = true;

        if (step === 1) {
            // Validate Step 1 fields
            isValid = validateField(categorySelect) && isValid;
            isValid = validateField(brandSelect) && isValid;
            isValid = validateField(problemTextarea) && isValid;
        } else if (step === 3) {
            // Validate Step 3 fields
            isValid = validateField(nameInput) && isValid;
            isValid = validateField(phoneInput) && isValid;
            isValid = validateField(emailInput) && isValid;
        }

        return isValid;
    }

    /**
     * Validate a single field
     */
    function validateField(field) {
        if (!field) return true;

        const value = field.value.trim();
        const fieldName = field.name;
        let isValid = true;
        let errorMessage = '';

        // Required validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'This field is required';
        }

        // Email validation
        if (isValid && fieldName === 'contact_email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Please enter a valid email address';
            }
        }

        // Phone validation
        if (isValid && fieldName === 'contact_phone' && value) {
            const phoneRegex = /^[\d\s\-\+\(\)]{10,}$/;
            if (!phoneRegex.test(value)) {
                isValid = false;
                errorMessage = 'Please enter a valid phone number';
            }
        }

        // Show/hide error
        const fieldContainer = field.closest('.contact-form__field');
        const errorElement = document.querySelector(`.contact-form__error[data-field="${fieldName}"]`);

        if (!isValid) {
            fieldContainer?.classList.add('has-error');
            if (errorElement) {
                errorElement.textContent = errorMessage;
            }
        } else {
            fieldContainer?.classList.remove('has-error');
            if (errorElement) {
                errorElement.textContent = '';
            }
        }

        return isValid;
    }

    /**
     * Clear field error
     */
    function clearFieldError(field) {
        const fieldName = field.name;
        const fieldContainer = field.closest('.contact-form__field');
        const errorElement = document.querySelector(`.contact-form__error[data-field="${fieldName}"]`);

        fieldContainer?.classList.remove('has-error');
        if (errorElement) {
            errorElement.textContent = '';
        }
    }

    /**
     * Update review data on step 2
     */
    function updateReviewData() {
        // Category
        const categoryValue = categorySelect?.value || '';
        const categoryOption = categorySelect?.querySelector(`option[value="${categoryValue}"]`);
        const categoryLabel = categoryOption?.textContent || categoryValue;
        document.querySelector('[data-review="category"]').textContent = categoryLabel;

        // Brand
        const brandValue = brandSelect?.value || '';
        const brandOption = brandSelect?.querySelector(`option[value="${brandValue}"]`);
        const brandLabel = brandOption?.textContent || brandValue;
        document.querySelector('[data-review="brand"]').textContent = brandLabel;

        // Problem Description
        document.querySelector('[data-review="problem_description"]').textContent = problemTextarea?.value || '';
    }

    /**
     * Handle form submission
     */
    async function handleSubmit(e) {
        e.preventDefault();

        // Validate step 3 before submission
        if (!validateStep(3)) {
            return;
        }

        // Show loading state
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.classList.add('is-loading');
        }

        // Collect form data
        const formData = new FormData(form);
        formData.append('action', 'contact_form_submit');

        try {
            const response = await fetch(mieleSupportAjax?.ajaxurl || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });

            const data = await response.json();

            if (data.success) {
                // Show success message
                goToStep('success');
            } else {
                // Show error
                showSubmitError(data.data?.message || 'An error occurred. Please try again.');
            }
        } catch (error) {
            console.error('Form submission error:', error);
            showSubmitError('Network error. Please check your connection and try again.');
        } finally {
            // Remove loading state
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.classList.remove('is-loading');
            }
        }
    }

    /**
     * Show submission error
     */
    function showSubmitError(message) {
        const errorStep = form.querySelector('.contact-form__step[data-step="error"]');
        const errorText = errorStep?.querySelector('.contact-form__error-text');

        if (errorText) {
            errorText.textContent = message;
        }

        goToStep('error');
    }

    /**
     * Handle form reset
     */
    function handleReset() {
        form.reset();

        // Clear all errors
        const fieldContainers = form.querySelectorAll('.contact-form__field');
        fieldContainers.forEach(container => container.classList.remove('has-error'));

        const errorElements = form.querySelectorAll('.contact-form__error');
        errorElements.forEach(el => el.textContent = '');

        // Go back to step 1
        goToStep(1);
    }

    // Initialize
    init();
})();
