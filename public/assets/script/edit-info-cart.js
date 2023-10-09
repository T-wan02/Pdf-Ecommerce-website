const editBtnForm = document.querySelectorAll('.edit-form-btn');

const formContainers = document.querySelectorAll('.information');
const confirmForm = document.getElementById('confirmForm');

let emailData;
let paymentData = {};

confirmForm.addEventListener('submit', (e) => {
     e.preventDefault();

     const submitBtn = confirmForm.querySelector('button[type="submit"]');

     submitBtn.disabled = true;
     submitBtn.innerHTML = `<span class="threeDot-loader"></span>`;

     const formData = new FormData();

     document.getElementById('emailInfo').value = emailData;
     document.getElementById('paymentInfo').value = JSON.stringify(paymentData);

     confirmForm.submit();

     // const paymentForm = document.getElementById('payment-form');
     // const paymentFormData = new FormData(paymentForm);

     // formData.append('email', emailData); // Replace with the email data you want to send
     // formData.append('paymentInfo', JSON.stringify(paymentData));
     // formData.append('payment', paymentForm);

     // Include the CSRF token in the request headers
     // const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Replace with the actual way you retrieve the CSRF token

     // axios.post('/api/checkout/', formData, {
     //      headers: {
     //        'Content-Type': 'multipart/form-data', // Set the content type to multipart/form-data for FormData
     //        'X-CSRF-TOKEN': csrfToken, // Include the CSRF token in the headers
     //      },
     // }).then(({data}) => {
     //      console.log(data);
     // }).catch(err => {
     //      console.error(err);
     // });
});

formContainers.forEach(container => {
     const form = container.querySelector('.form-container');
     form.addEventListener('submit', async (e) => {
          e.preventDefault();
          
          const type = form.dataset.type;
          const payment = document.querySelector('.payment');
          const confirmForm = document.getElementById('confirmForm');

          if(type == 'email'){
               const email = form.querySelector('input[name="email"]');
               const paymentFormDataDisabled = form.querySelector('.form-data-disabled');

               emailData = email.value;
               
               container.classList.remove('active');
               container.classList.add('done');

               paymentFormDataDisabled.innerHTML = `
                    <span>${emailData}</span>
               `;

               payment.classList.add('active');
          }else if(type == 'payment'){
               function stripeTokenHandler(token) {
                    var form = document.getElementById('confirmForm');
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', token.id);
                    form.appendChild(hiddenInput);
               }

               // Display loading stage on the button
               const submitBtn = form.querySelector('button[type="submit"]');
               submitBtn.innerHTML = `<span class="threeDot-loader"></span>`;
               submitBtn.disabled = true;

               try {
                    // Generate Stripe token asynchronously
                    const result = await stripe.createToken(cardElement);

                    if (result.error) {
                        cardErrors.textContent = result.error.message;
                    } else {
                        stripeTokenHandler(result.token);

                         const paymentForm = document.querySelector('.payment-form');
                         const paymentFormDataDisabled = form.querySelector('.form-data-disabled');

                        const paymentFormData = new FormData(paymentForm);
                        for (var [key, value] of paymentFormData.entries()) { 
                             paymentData[key] = value;
                        }

                        paymentFormDataDisabled.innerHTML = `
                             <span>${paymentData.fName} ${paymentData.lName}</span>
                             <span>${paymentData.phoneNumber}</span>
                             <span>${paymentData.postalCode}, ${paymentData.city}, ${paymentData.state}</span>
                             <span>${paymentData.address}</span>
                             <span>${paymentData.country}</span>
                        `;

                        container.classList.remove('active');
                        container.classList.remove('no_data');
                        container.classList.add('done');

                         submitBtn.disabled = false;
                        container.nextElementSibling.classList.add('active');
                    }
               } catch (error) {
                    console.error(error);
               } finally {
                    submitBtn.innerHTML = 'Submit';
               }
          }else if(type == 'confirm'){
               form.classList.add('done');
          }
     });
});

editBtnForm.forEach(btn => {
     btn.addEventListener('click', (e) => {
          const information = btn.closest('.information');
          const email = document.querySelector('.email');
          const payment = document.querySelector('.payment');
          const confirm = document.querySelector('.confirm');

          const type = btn.dataset.type;
          if(type == 'email'){
               information.classList.add('active');
               information.classList.remove('done');

               payment.classList.add('no_data');
               payment.classList.remove('active');
               payment.classList.remove('done');

               confirm.classList.remove('active');
          }else if(type == 'payment'){               
               information.classList.add('active');
               information.classList.remove('no_data');
               information.classList.remove('done');

               confirm.classList.remove('active');
          }else if(type == 'confirm'){
               information.classList.add('active');
          }
     });
});