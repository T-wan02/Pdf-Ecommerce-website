
function checkout(){
     axios.get('/api/checkout/getCartToken').then(({data}) => {
          if(data.stage === 'success'){
               window.location.href = `/checkout?cartToken=${data.data}`;
          }
     });
}