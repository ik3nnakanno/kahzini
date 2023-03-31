{/* <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
const commentForms = document.querySelectorAll('.comment-form');
var comments = $('.comments');
// Iterate through each form and attach event listener
commentForms.forEach(function (form) {
    form.addEventListener('submit', function (event) {
        // Prevent default form submission behavior
        event.preventDefault();

        // Get form data
        const formData = new FormData(event.target);

        // Create fetch request to submit form data
        fetch('comment.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                // Update page content with new comment data
                const newComment = data;
                comments.val('');
                form.previousElementSibling.insertAdjacentHTML('beforeend', newComment);
            })
            .catch(error => console.error(error));
    });
}); */}