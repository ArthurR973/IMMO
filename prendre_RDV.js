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
        const rowIndex = selectedSlot.parentNode.rowIndex - 1;
        const colIndex = selectedSlot.cellIndex - 1;

        // Envoyer les données au serveur via AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'manage_appointment.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert(xhr.responseText);
                // Mettre à jour l'emploi du temps localement
                if (action === 'save') {
                    scheduleData[rowIndex][colIndex] = 'busy';
                    selectedSlot.classList.remove('selected');
                    selectedSlot.classList.add('busy');
                } else if (action === 'cancel') {
                    scheduleData[rowIndex][colIndex] = 'free';
                    selectedSlot.classList.remove('selected');
                    selectedSlot.classList.remove('busy');
                    selectedSlot.classList.add('free');
                }
            } else {
                alert('Erreur lors de l\'exécution de l\'action.');
            }
        };
        xhr.send(`action=${action}&rowIndex=${rowIndex}&colIndex=${colIndex}`);
    }
});
