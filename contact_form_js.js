// Mail function for form submission
function mail() {
    // Get form element
    const form = document.querySelector('form[action="process_form.php"]');
    
    if (!form) {
        console.error('Contact form not found');
        return false;
    }
    
    // Get form data
    const formData = new FormData(form);
    
    // Basic client-side validation
    const name = formData.get('name');
    const email = formData.get('Email');
    const message = formData.get('message');
    
    if (!name.trim()) {
        showMessage('Please enter your name', 'error');
        return false;
    }
    
    if (!email.trim()) {
        showMessage('Please enter your email', 'error');
        return false;
    }
    
    if (!isValidEmail(email)) {
        showMessage('Please enter a valid email address', 'error');
        return false;
    }
    
    if (!message.trim()) {
        showMessage('Please enter a message', 'error');
        return false;
    }
    
    // Show loading state
    const submitBtn = form.querySelector('.contact-submit-btn');
    const originalBtnText = submitBtn.textContent;
    submitBtn.textContent = 'Sending...';
    submitBtn.disabled = true;
    
    // Send AJAX request
    fetch('process_form.php', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            showMessage(data.message, 'success');
            form.reset(); // Clear form on success
        } else {
            showMessage(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('An error occurred. Please try again later.', 'error');
    })
    .finally(() => {
        // Reset button state
        submitBtn.textContent = originalBtnText;
        submitBtn.disabled = false;
    });
    
    return false; // Prevent default form submission
}

// Email validation function
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Function to show messages to user
function showMessage(message, type) {
    // Remove existing message if any
    const existingMessage = document.getElementById('form-message');
    if (existingMessage) {
        existingMessage.remove();
    }
    
    // Create message element
    const messageDiv = document.createElement('div');
    messageDiv.id = 'form-message';
    messageDiv.textContent = message;
    
    // Style based on type
    if (type === 'success') {
        messageDiv.style.cssText = `
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        `;
    } else {
        messageDiv.style.cssText = `
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        `;
    }
    
    // Insert message before form
    const form = document.querySelector('form[action="process_form.php"]');
    form.parentNode.insertBefore(messageDiv, form);
    
    // Auto-hide success messages after 5 seconds
    if (type === 'success') {
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.remove();
            }
        }, 5000);
    }
}

// Alternative: Handle form submission with event listener (more modern approach)
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="process_form.php"]');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            mail(); // Call our custom mail function
        });
    }
});