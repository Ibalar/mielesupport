<?php

declare(strict_types=1);

/**
 * Contact Form Template Part
 *
 * Multi-step contact form with 3 steps:
 * - Step 1: Category, Brand, Problem Description
 * - Step 2: Review/Preview
 * - Step 3: Back/Submit
 */

// Get ACF fields for form options
$categories = get_field('form_categories') ?: [];
$brands = get_field('form_brands') ?: [];

// Default categories if ACF is empty
if (empty($categories)) {
    $categories = [
        ['value' => 'refrigerator', 'label' => 'Refrigerator'],
        ['value' => 'dishwasher', 'label' => 'Dishwasher'],
        ['value' => 'washer', 'label' => 'Washing Machine'],
        ['value' => 'dryer', 'label' => 'Dryer'],
        ['value' => 'oven', 'label' => 'Oven/Stove'],
        ['value' => 'other', 'label' => 'Other'],
    ];
}

// Default brands if ACF is empty
if (empty($brands)) {
    $brands = [
        ['value' => 'miele', 'label' => 'Miele'],
        ['value' => 'bosch', 'label' => 'Bosch'],
        ['value' => 'samsung', 'label' => 'Samsung'],
        ['value' => 'lg', 'label' => 'LG'],
        ['value' => 'whirlpool', 'label' => 'Whirlpool'],
        ['value' => 'other', 'label' => 'Other'],
    ];
}

// Get admin email from ACF or use default
$admin_email = get_field('form_admin_email') ?: get_option('admin_email');

// Generate nonce for security
$form_nonce = wp_create_nonce('contact_form_submit');
?>

<div class="contact-form-wrapper">
    <!-- Step Indicators -->
    <div class="contact-form__steps">
        <div class="contact-form__step-indicator active" data-step="1">
            <span class="contact-form__step-number">1</span>
            <span class="contact-form__step-label">Details</span>
        </div>
        <div class="contact-form__step-line"></div>
        <div class="contact-form__step-indicator" data-step="2">
            <span class="contact-form__step-number">2</span>
            <span class="contact-form__step-label">Review</span>
        </div>
        <div class="contact-form__step-line"></div>
        <div class="contact-form__step-indicator" data-step="3">
            <span class="contact-form__step-number">3</span>
            <span class="contact-form__step-label">Submit</span>
        </div>
    </div>

    <!-- Form -->
    <form id="contact-form" class="contact-form" method="post" action="">
        <?php wp_nonce_field('contact_form_submit', 'contact_form_nonce'); ?>
        <input type="hidden" name="action" value="contact_form_submit">

        <!-- Step 1: Category, Brand, Problem Description -->
        <div class="contact-form__step" data-step="1">
            <div class="contact-form__header">
                <h2 class="contact-form__title">Describe Your Problem</h2>
                <p class="contact-form__subtitle">Please provide details about your appliance issue</p>
            </div>

            <div class="contact-form__fields">
                <!-- Category Select -->
                <div class="contact-form__field">
                    <label for="category" class="contact-form__label">
                        Category <span class="contact-form__required">*</span>
                    </label>
                    <div class="contact-form__select-wrapper">
                        <select name="category" id="category" class="contact-form__select" required>
                            <option value="">Select a category</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo esc_attr($category['value'] ?? $category); ?>">
                                    <?php echo esc_html($category['label'] ?? $category); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="contact-form__select-arrow">
                            <svg width="12" height="8" viewBox="0 0 12 8" fill="none">
                                <path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    <span class="contact-form__error" data-field="category"></span>
                </div>

                <!-- Brand Select -->
                <div class="contact-form__field">
                    <label for="brand" class="contact-form__label">
                        Brand <span class="contact-form__required">*</span>
                    </label>
                    <div class="contact-form__select-wrapper">
                        <select name="brand" id="brand" class="contact-form__select" required>
                            <option value="">Select a brand</option>
                            <?php foreach ($brands as $brand) : ?>
                                <option value="<?php echo esc_attr($brand['value'] ?? $brand); ?>">
                                    <?php echo esc_html($brand['label'] ?? $brand); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="contact-form__select-arrow">
                            <svg width="12" height="8" viewBox="0 0 12 8" fill="none">
                                <path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    <span class="contact-form__error" data-field="brand"></span>
                </div>

                <!-- Problem Description -->
                <div class="contact-form__field">
                    <label for="problem_description" class="contact-form__label">
                        Problem Description <span class="contact-form__required">*</span>
                    </label>
                    <textarea
                        name="problem_description"
                        id="problem_description"
                        class="contact-form__textarea"
                        rows="5"
                        placeholder="Describe the problem with your appliance..."
                        required
                    ></textarea>
                    <span class="contact-form__error" data-field="problem_description"></span>
                </div>
            </div>

            <!-- Step 1 Buttons -->
            <div class="contact-form__actions contact-form__actions--step1">
                <button type="button" class="btn btn--outline contact-form__btn-preview">
                    Preview
                </button>
                <button type="button" class="btn btn--primary contact-form__btn-next" data-next="2">
                    Next
                </button>
            </div>
        </div>

        <!-- Step 2: Review -->
        <div class="contact-form__step contact-form__step--hidden" data-step="2">
            <div class="contact-form__header">
                <h2 class="contact-form__title">Review Your Information</h2>
                <p class="contact-form__subtitle">Please review your details before submitting</p>
            </div>

            <div class="contact-form__review">
                <div class="contact-form__review-item">
                    <span class="contact-form__review-label">Category:</span>
                    <span class="contact-form__review-value" data-review="category"></span>
                </div>
                <div class="contact-form__review-item">
                    <span class="contact-form__review-label">Brand:</span>
                    <span class="contact-form__review-value" data-review="brand"></span>
                </div>
                <div class="contact-form__review-item">
                    <span class="contact-form__review-label">Problem Description:</span>
                    <span class="contact-form__review-value" data-review="problem_description"></span>
                </div>
            </div>

            <!-- Step 2 Buttons -->
            <div class="contact-form__actions contact-form__actions--step2">
                <button type="button" class="btn btn--outline contact-form__btn-back" data-back="1">
                    Back
                </button>
                <button type="button" class="btn btn--primary contact-form__btn-next" data-next="3">
                    Continue
                </button>
            </div>
        </div>

        <!-- Step 3: Contact Info & Submit -->
        <div class="contact-form__step contact-form__step--hidden" data-step="3">
            <div class="contact-form__header">
                <h2 class="contact-form__title">Contact Information</h2>
                <p class="contact-form__subtitle">Please provide your contact details so we can reach you</p>
            </div>

            <div class="contact-form__fields">
                <!-- Name -->
                <div class="contact-form__field">
                    <label for="contact_name" class="contact-form__label">
                        Full Name <span class="contact-form__required">*</span>
                    </label>
                    <input
                        type="text"
                        name="contact_name"
                        id="contact_name"
                        class="contact-form__input"
                        placeholder="Enter your full name"
                        required
                    >
                    <span class="contact-form__error" data-field="contact_name"></span>
                </div>

                <!-- Phone -->
                <div class="contact-form__field">
                    <label for="contact_phone" class="contact-form__label">
                        Phone Number <span class="contact-form__required">*</span>
                    </label>
                    <input
                        type="tel"
                        name="contact_phone"
                        id="contact_phone"
                        class="contact-form__input"
                        placeholder="+1 (XXX) XXX-XXXX"
                        required
                    >
                    <span class="contact-form__error" data-field="contact_phone"></span>
                </div>

                <!-- Email -->
                <div class="contact-form__field">
                    <label for="contact_email" class="contact-form__label">
                        Email Address <span class="contact-form__required">*</span>
                    </label>
                    <input
                        type="email"
                        name="contact_email"
                        id="contact_email"
                        class="contact-form__input"
                        placeholder="your@email.com"
                        required
                    >
                    <span class="contact-form__error" data-field="contact_email"></span>
                </div>
            </div>

            <!-- Step 3 Buttons -->
            <div class="contact-form__actions contact-form__actions--step3">
                <button type="button" class="btn btn--outline contact-form__btn-back" data-back="2">
                    Back
                </button>
                <button type="submit" class="btn btn--primary contact-form__btn-submit">
                    Submit Request
                </button>
            </div>
        </div>

        <!-- Success Message -->
        <div class="contact-form__step contact-form__step--hidden" data-step="success">
            <div class="contact-form__success">
                <div class="contact-form__success-icon">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <h2 class="contact-form__success-title">Thank You!</h2>
                <p class="contact-form__success-text">
                    Your request has been submitted successfully. Our team will contact you shortly.
                </p>
                <button type="button" class="btn btn--primary contact-form__btn-reset">
                    Submit Another Request
                </button>
            </div>
        </div>

        <!-- Error Message -->
        <div class="contact-form__step contact-form__step--hidden" data-step="error">
            <div class="contact-form__error-message">
                <div class="contact-form__error-icon">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
                <h2 class="contact-form__error-title">Something Went Wrong</h2>
                <p class="contact-form__error-text">
                    We couldn't submit your request. Please try again later.
                </p>
                <button type="button" class="btn btn--primary contact-form__btn-back" data-back="3">
                    Go Back
                </button>
            </div>
        </div>
    </form>
</div>
