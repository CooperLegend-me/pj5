function sendMessage(orderId) {
    const messageInput = document.getElementById(`message-input-${orderId}`);
    const message = messageInput.value.trim();
    
    if (!message) return;
    
    // Get CSRF token from meta tag
    const token = document.querySelector('meta[name="csrf-token"]');
    
    if (!token) {
        console.error('CSRF token not found');
        alert('Ошибка безопасности. Пожалуйста, обновите страницу и попробуйте снова.');
        return;
    }

    const csrfToken = token.getAttribute('content');
    
    fetch(`/orders/${orderId}/messages`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ message: message })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Clear input
            messageInput.value = '';
            
            // Add message to chat
            const messagesContainer = document.getElementById(`messages-${orderId}`);
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message message-user';
            messageDiv.setAttribute('data-message-id', data.message.id);
            
            messageDiv.innerHTML = `
                <div class="message-header">
                    <span class="message-name">${escapeHtml(data.message.user.name)}</span>
                    <span class="message-time">${new Date(data.message.created_at).toLocaleString('ru-RU')}</span>
                </div>
                <div class="message-content">${escapeHtml(data.message.message)}</div>
            `;
            
            messagesContainer.appendChild(messageDiv);
            scrollToBottom(messagesContainer);
        } else {
            throw new Error(data.message || 'Произошла ошибка при отправке сообщения');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Произошла ошибка при отправке сообщения. Пожалуйста, попробуйте еще раз.');
    });
}

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function scrollToBottom(container) {
    container.scrollTop = container.scrollHeight;
}

// Initialize message handling when document is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners for Enter key in message inputs
    document.querySelectorAll('[id^="message-input-"]').forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const orderId = this.id.replace('message-input-', '');
                sendMessage(orderId);
            }
        });
    });
}); 