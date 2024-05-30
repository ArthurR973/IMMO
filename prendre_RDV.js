document.addEventListener('DOMContentLoaded', () => {
    // Simuler la récupération de l'emploi du temps depuis une base de données
    const scheduleData = [
        ['busy', 'free', 'free', 'busy', 'busy', 'busy'],
        ['free', 'busy', 'free', 'busy', 'free', 'busy']
    ];

    // Afficher le planning complet
    const largeSchedule = document.querySelector('.schedule.large tbody');
    largeSchedule.innerHTML = ''; // Clear any existing rows
    scheduleData.forEach((row, rowIndex) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${rowIndex === 0 ? '9H - 12H' : '13H30 - 15H30'}</td>
        `;
        row.forEach((cell, colIndex) => {
            const td = document.createElement('td');
            td.className = cell;
            if (cell === 'free') {
                td.addEventListener('click', () => selectTimeSlot(td, rowIndex, colIndex));
            }
            tr.appendChild(td);
        });
        largeSchedule.appendChild(tr);
    });

    // Fonction pour sélectionner un créneau horaire
    let selectedSlot = null;
    function selectTimeSlot(td, rowIndex, colIndex) {
        if (selectedSlot) {
            selectedSlot.classList.remove('selected');
        }
        selectedSlot = td;
        td.classList.add('selected');
        selectedSlot.dataset.row = rowIndex;
        selectedSlot.dataset.col = colIndex;
    }

    // Fonction pour enregistrer le rendez-vous
    window.saveAppointment = function() {
        if (!selectedSlot) {
            alert('Veuillez sélectionner un créneau horaire.');
            return;
        }
        sendRequest('save');
    };

    // Fonction pour annuler le rendez-vous
    window.cancelAppointment = function() {
        if (!selectedSlot) {
            alert('Veuillez sélectionner un créneau horaire à annuler.');
            return;
        }
        sendRequest('cancel');
    };

    // Fonction pour envoyer la requête au serveur
    function sendRequest(action) {
        const rowIndex = selectedSlot.dataset.row;
        const colIndex = selectedSlot.dataset.col;

        fetch('manage_appointment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `action=${action}&rowIndex=${rowIndex}&colIndex=${colIndex}&id_agent=14`
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            // Mettre à jour l'emploi du temps localement
            if (action === 'save') {
                selectedSlot.classList.remove('selected');
                selectedSlot.classList.add('busy');
            } else if (action === 'cancel') {
                selectedSlot.classList.remove('selected');
                selectedSlot.classList.remove('busy');
                selectedSlot.classList.add('free');
            }
        })
        .catch(error => {
            alert('Erreur lors de l\'exécution de l\'action.');
            console.error(error);
        });
    }
});
