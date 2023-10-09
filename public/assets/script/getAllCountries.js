async function getAllCountries(){
     const countriesSelect = document.getElementById('countriesSelect');

     await fetch('https://restcountries.com/v3.1/all')
     .then(response => response.json())
     .then(data => {
          // Sort the data alphabetically by country name
          data.sort((a, b) => a.name.common.localeCompare(b.name.common));

          countriesSelect.innerHTML = '';
          data.forEach(d => {
               countriesSelect.innerHTML += `
                    <option value="${d.cca2}">${d.name.common}</option>
               `;
          });
     })
     .catch(error => {
          console.error('Error:', error);
     });
}

getAllCountries();