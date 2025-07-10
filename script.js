// script.js

document.addEventListener('DOMContentLoaded', function() {
    // --- Client-side Form Validation (for add_post.php & edit_post.php) ---
    const postForm = document.querySelector('form'); // Select the form

    if (postForm) { // Ensure the form exists on the page
        postForm.addEventListener('submit', function(event) {
            const titleInput = document.getElementById('title');
            const contentInput = document.getElementById('content');
            const authorInput = document.getElementById('author');

            let isValid = true;

            // Simple validation and Bootstrap's validation classes
            if (!titleInput.value.trim()) {
                titleInput.classList.add('is-invalid');
                isValid = false;
            } else {
                titleInput.classList.remove('is-invalid');
                titleInput.classList.add('is-valid');
            }

            if (!contentInput.value.trim()) {
                contentInput.classList.add('is-invalid');
                isValid = false;
            } else {
                contentInput.classList.remove('is-invalid');
                contentInput.classList.add('is-valid');
            }

            if (!authorInput.value.trim()) {
                authorInput.classList.add('is-invalid');
                isValid = false;
            } else {
                authorInput.classList.remove('is-invalid');
                authorInput.classList.add('is-valid');
            }

            if (!isValid) {
                event.preventDefault(); // Stop form submission if not valid
                alert('Please fill in all required fields!'); // Simple alert for overall feedback
            }

            // You can add more complex validation here
            // E.g., minimum length, character types, etc.
        });

        // Add event listeners to remove validation styles on input for better UX
        const formInputs = postForm.querySelectorAll('input, textarea');
        formInputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });
        });
    }

    // --- Real-time Post Search/Filter ---
    const postSearchInput = document.getElementById('postSearchInput');
    const postItems = document.querySelectorAll('.post-item'); // Select all individual post card wrappers

    if (postSearchInput && postItems.length > 0) {
        postSearchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase(); // Get search term, convert to lowercase for case-insensitive search

            postItems.forEach(item => {
                const titleElement = item.querySelector('.card-title');
                const contentElement = item.querySelector('.card-text');
                const authorElement = item.querySelector('.card-subtitle');

                if (titleElement && contentElement && authorElement) {
                    const titleText = titleElement.textContent.toLowerCase();
                    const contentText = contentElement.textContent.toLowerCase();
                    const authorText = authorElement.textContent.toLowerCase();

                    // Check if the search term is found in title, content, or author
                    if (titleText.includes(searchTerm) || contentText.includes(searchTerm) || authorText.includes(searchTerm)) {
                        item.style.display = ''; // Show the item
                    } else {
                        item.style.display = 'none'; // Hide the item
                    }
                }
            });
        });
    }
});