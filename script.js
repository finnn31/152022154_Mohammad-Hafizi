// Ambil data dari API yang kamu buat
fetch('http://localhost/cuaca/get.php') // Ganti dengan URL dari file PHP yang kamu buat
    .then(response => response.json())
    .then(data => {
        // Tampilkan data suhu max, min, dan rata-rata
        document.getElementById('suhu-max').innerText = data.suhumax;
        document.getElementById('suhu-min').innerText = data.suhumin;
        document.getElementById('suhu-rata').innerText = data.suhurata;

        // Tampilkan data detail nilai_suhu_max_humid_max
        const detailSuhuMaxTable = document.getElementById('detail-suhu-max');
        data.nilai_suhu_max_humid_max.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.idx}</td>
                <td>${item.suhu} °C</td>
                <td>${item.humid} %</td>
                <td>${item.kecerahan} lux</td>
                <td>${item.timestamp}</td>
            `;
            detailSuhuMaxTable.appendChild(row);
        });

        // Tampilkan data month_year_max
        const monthYearMaxList = document.getElementById('month-year-max');
        data.month_year_max.forEach(item => {
            const listItem = document.createElement('li');
            listItem.innerText = item.month_year;
            monthYearMaxList.appendChild(listItem);
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
