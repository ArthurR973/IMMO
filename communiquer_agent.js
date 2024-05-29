function sendMessage() {
    const input = document.getElementById('message-input');
    const message = input.value;
    if (message.trim() !== '') {
        const messageContainer = document.createElement('div');
        messageContainer.classList.add('message');
        messageContainer.innerText = message;
        document.getElementById('messages').appendChild(messageContainer);
        input.value = '';

        // Simulate a reply from the agent
        setTimeout(() => {
            const agentMessageContainer = document.createElement('div');
            agentMessageContainer.classList.add('message', 'message-agent');
            agentMessageContainer.innerText = "Merci pour votre message. Je vous répondrai dès que possible.";
            document.getElementById('messages').appendChild(agentMessageContainer);
        }, 1000);
    }
}

function startAudioCall() {
    alert("Fonctionnalité d'appel audio en cours de développement.");
    // Intégration de WebRTC pour un appel audio
}

function startVideoCall() {
    alert("Fonctionnalité d'appel vidéo en cours de développement.");
    // Intégration de WebRTC pour un appel vidéo
}

function sendEmail() {
    window.location.href = 'mailto:thierry.marx@omnesimmobilier.fr';
}
