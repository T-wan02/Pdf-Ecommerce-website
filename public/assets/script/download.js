const downloadBtns = document.querySelectorAll('.download-btn');

downloadBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();

        let slug = btn.dataset.slug;
        var fileName = `${slug}.pdf`;

        var a = document.createElement('a');
        a.href = `/receipt/${cartToken}/download/${fileName}`;

        a.download = fileName;

        document.body.appendChild(a);
        a.click();

        document.body.removeChild(a);
    });
});