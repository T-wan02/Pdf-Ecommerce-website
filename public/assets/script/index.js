// To Update cart count on overly cart icon
function updateCartCount(updatedCount){
     const cartCountContainer = document.getElementById('cartCount');

     if(cartCountContainer){
          cartCountContainer.innerHTML = updatedCount;
     }
}
if(cartCount){
     updateCartCount(cartCount);
}

// Update sub total and total value
function updateTotal(subTotal, tax, total){
     const subTotalEle = document.getElementById('subTotal');
     const taxEle = document.getElementById('tax');
     const totalEle = document.getElementById('total');

     if(subTotalEle){
          subTotalEle.innerHTML = "$ " + subTotal;
     }
     if(taxEle){
          taxEle.innerHTML = "$ " + tax;
     }
     if(totalEle){
          totalEle.innerHTML = "$ " + total;
     }
}