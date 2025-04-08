
        async function fetchTermekek() {
            const response = await fetch('/api/termekek');
            const data = await response.json();
            return data;
        }

        async function loadTermekek() {
            const termekek = await fetchTermekek();
            const termekekLista = document.getElementById('termekek-lista');
            termekek.forEach(termek => {
                const li = document.createElement('li');
                li.textContent = termek.name;
                termekekLista.appendChild(li);
            });
        }

        document.addEventListener('DOMContentLoaded', loadTermekek);
