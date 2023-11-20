document.getElementById('upload-button').addEventListener('click', function (event) {
    const title = document.getElementById('title').value;
    const file = document.getElementById('file').value;

    if (title.trim() !== '' && file.trim() !== '') {
        event.preventDefault(); // Prevent the form submission
        document.querySelector('.loader-container').style.display = 'block';
        this.disabled = true;

        this.closest('form').submit();
    }
});
