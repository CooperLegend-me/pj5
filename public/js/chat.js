// Функция для экранирования HTML
function escapeHtml(unsafe) {
    if (!unsafe) return '';
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Глобальная функция для отправки сообщений
function sendMessage(orderId) {
    const messageInput = document.getElementById(`message-input-${orderId}`);
    const message = messageInput.value.trim();
    
    if (!message) return false;
    
    // Получаем токен из формы
    const form = document.getElementById(`chat-form-${orderId}`);
    if (!form) {
        console.error('Chat form not found');
        return false;
    }

    const tokenInput = form.querySelector('input[name="_token"]');
    if (!tokenInput) {
        console.error('CSRF token not found');
        alert('Ошибка безопасности. Пожалуйста, обновите страницу.');
        return false;
    }

    const token = tokenInput.value;
    const isAdmin = window.location.pathname.includes('/admin/');
    const endpoint = isAdmin ? `/admin/orders/${orderId}/messages` : `/orders/${orderId}/messages`;

    // Очищаем поле ввода сразу
    messageInput.value = '';
    
    fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ message: message })
    })
    .then(response => {
        if (response.status === 419) {
            window.location.reload();
            throw new Error('CSRF token mismatch');
        }
        if (response.status === 401) {
            window.location.href = '/login';
            throw new Error('Not authenticated');
        }
        if (response.status === 403) {
            alert('У вас нет прав для отправки сообщений в этом чате');
            throw new Error('Forbidden');
        }
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const container = document.getElementById(`messages-${orderId}`);
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isAdmin ? 'message-admin' : 'message-user'}`;
            messageDiv.setAttribute('data-message-id', data.message.id);
            
            messageDiv.innerHTML = `
                <div class="message-header">
                    <span class="message-name">${escapeHtml(data.message.user.name)}</span>
                    <span class="message-time">${new Date(data.message.created_at).toLocaleString('ru-RU')}</span>
                </div>
                <div class="message-content">${escapeHtml(data.message.message)}</div>
            `;
            container.appendChild(messageDiv);
            scrollToBottom(container);
        } else {
            console.error('Error:', data.message);
            alert('Ошибка при отправке сообщения');
            messageInput.value = message;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (!error.message.includes('CSRF token mismatch') && 
            !error.message.includes('Not authenticated') && 
            !error.message.includes('Forbidden')) {
            alert('Ошибка при отправке сообщения. Попробуйте обновить страницу.');
            messageInput.value = message;
        }
    });

    return false;
}

function scrollToBottom(container) {
    container.scrollTop = container.scrollHeight;
}

// Хранилище для экземпляров чатов
const chatInstances = new Map();

// Класс для управления чатом
class ChatInstance {
    constructor(container, orderId) {
        this.container = container;
        this.orderId = orderId;
        this.form = document.getElementById(`chat-form-${orderId}`);
        this.input = this.form.querySelector('input[type="text"]');
        this.submitButton = this.form.querySelector('button[type="submit"]');
        this.lastMessageId = 0;
        this.isAdmin = window.location.pathname.includes('/admin/');
        this.initialized = false;
        this.updateInterval = null;

        // Получаем ID последнего сообщения
        const messages = container.querySelectorAll('.message');
        if (messages.length > 0) {
            const lastMessage = messages[messages.length - 1];
            this.lastMessageId = parseInt(lastMessage.getAttribute('data-message-id')) || 0;
        }

        this.initializeEventListeners();
        this.startUpdateInterval();
    }

    initializeEventListeners() {
        // Обработчик отправки формы
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            sendMessage(this.orderId);
            return false;
        });

        // Обработчик нажатия Enter
        this.input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendMessage(this.orderId);
            }
        });
    }

    addMessage(message) {
        const messageId = parseInt(message.id);
        if (messageId > this.lastMessageId) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${message.is_admin ? 'message-admin' : 'message-user'}`;
            messageDiv.setAttribute('data-message-id', messageId);
            
            messageDiv.innerHTML = `
                <div class="message-header">
                    <span class="message-name">${escapeHtml(message.user.name)}</span>
                    <span class="message-time">${new Date(message.created_at).toLocaleString('ru-RU')}</span>
                </div>
                <div class="message-content">${escapeHtml(message.message)}</div>
            `;
            this.container.appendChild(messageDiv);
            this.lastMessageId = messageId;
            scrollToBottom(this.container);
        }
    }

    updateMessages() {
        const endpoint = this.isAdmin ? `/admin/orders/${this.orderId}/messages` : `/orders/${this.orderId}/messages`;

        fetch(endpoint)
            .then(response => {
                if (response.status === 419) {
                    window.location.reload();
                    throw new Error('CSRF token mismatch');
                }
                if (response.status === 401) {
                    window.location.href = '/login';
                    throw new Error('Not authenticated');
                }
                if (response.status === 403) {
                    this.container.innerHTML = '<div class="error-message">У вас нет доступа к этому чату</div>';
                    this.stopUpdateInterval();
                    throw new Error('Forbidden');
                }
                return response.json();
            })
            .then(data => {
                if (data.success && Array.isArray(data.messages)) {
                    // Clear existing messages if this is first load
                    if (!this.initialized) {
                        this.container.innerHTML = '';
                        this.initialized = true;
                    }
                    data.messages.forEach(message => {
                        this.addMessage(message);
                    });
                }
            })
            .catch(error => {
                if (!error.message.includes('Forbidden')) {
                    console.error('Error:', error);
                }
            });
    }

    stopUpdateInterval() {
        if (this.updateInterval) {
            clearInterval(this.updateInterval);
            this.updateInterval = null;
        }
    }

    startUpdateInterval() {
        this.stopUpdateInterval();
        this.updateInterval = setInterval(() => this.updateMessages(), 3000);
    }
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    // Находим все контейнеры с сообщениями
    const messageContainers = document.querySelectorAll('[id^="messages-"]');
    
    messageContainers.forEach(container => {
        const orderId = container.id.replace('messages-', '');
        // Создаем экземпляр чата и сохраняем его
        chatInstances.set(orderId, new ChatInstance(container, orderId));
        // Прокручиваем к последнему сообщению
        scrollToBottom(container);
    });
}); 