let cos = JSON.parse(localStorage.getItem('cos-cumparaturi')) || [];

document.addEventListener('DOMContentLoaded', () => {
    afiseazaCos();

    // Toggle vizibilitate coș
    document.getElementById('deschide-cos').addEventListener('click', () => {
        document.getElementById('cos-dropdown').classList.toggle('cos-ascuns');
    });

    // Adăugare produs
    document.querySelectorAll('.btn-adauga').forEach(buton => {
        buton.addEventListener('click', () => {
            const nume = buton.getAttribute('data-nume');
            const pret = parseInt(buton.getAttribute('data-pret'));
            
            cos.push({ nume, pret });
            actualizeazaTot();
        });
    });

    // Golire coș
    document.getElementById('goleste-cos').addEventListener('click', () => {
        cos = [];
        actualizeazaTot();
    });
});

function actualizeazaTot() {
    localStorage.setItem('cos-cumparaturi', JSON.stringify(cos));
    afiseazaCos();
}

function afiseazaCos() {
    const lista = document.getElementById('lista-cos');
    const numar = document.getElementById('numar-produse');
    const total = document.getElementById('total-plata');
    
    lista.innerHTML = '';
    let suma = 0;

    cos.forEach(item => {
        const li = document.createElement('li');
        li.textContent = `${item.nume} - ${item.pret} MDL`;
        lista.appendChild(li);
        suma += item.pret;
    });

    numar.textContent = cos.length;
    total.textContent = suma;
}