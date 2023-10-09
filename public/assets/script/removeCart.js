
const cartListContainer = document.getElementById('listContainer');
const removeBtns = document.querySelectorAll('.remove-btn');

removeBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
        const slug = btn.dataset.slug;
        removeCart(e, slug);
    });
});

function removeCart(e, slug) {
    axios.post('/api/remove-cart', {slug: slug}).then(({ data }) => {
        if (data.stage === 'success') {
            if(data.cartCount > 0){
                const btnContainer = e.target.closest('.item');
                btnContainer.classList.add('animate__fadeOut');
                if (btnContainer) {
                    btnContainer.remove();
                }
            }else{
                cartListContainer.innerHTML = `
                    <div class="d-flex flex-column gap-2 align-item-start">
                        <h3 class="placeholder" style="text-align: left;">There is no item inside cart.</h3>
                        <a href="/" class="fill_btn"
                            style="text-align: center; display: flex; justify-content: center; align-items: center; text-decoration: none; padding: .5rem 1rem; font-size: 15px">Go
                            shopping</a>
                    </div>
                `;
                window.location.href = "/";
            }

            updateCartCount(data.cartCount); // Update cart count to Show Cart Btn
            updateTotal(data.subTotal, data.tax, data.total); // Update subtotal, tax, total
        }
    }).catch(error => {
     console.log(error);
    });
}
