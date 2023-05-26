
document.addEventListener('DOMContentLoaded', function() {
    const readMoreBtns = document.querySelectorAll('.read-more-btn');

    readMoreBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const hiddenContent = this.previousElementSibling.querySelector('.hidden-content');
            hiddenContent.classList.toggle('show');
            this.textContent = hiddenContent.classList.contains('show') ? 'Lire moins' : 'Lire plus';
        });
    });
});
