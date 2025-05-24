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
    const messageText = message;
    messageInput.value = '';

    fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ message: messageText })
    })
    .then(response => {
        if (response.status === 401) {
            window.location.href = '/login';
            throw new Error('Unauthorized');
        }
        if (response.status === 403) {
            console.error('Access denied');
            messageInput.value = messageText;
            throw new Error('Access denied');
        }
        if (response.status === 419) {
            window.location.reload();
            throw new Error('CSRF token mismatch');
        }
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Добавляем сообщение сразу после успешной отправки
            const container = document.getElementById(`messages-${orderId}`);
            if (!container) {
                console.error('Messages container not found');
                return;
            }

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
            
            // Обновляем lastMessageId
            const chatInstance = chatInstances.get(orderId);
            if (chatInstance) {
                chatInstance.lastMessageId = data.message.id;
            }
        } else {
            console.error('Error:', data.message);
            messageInput.value = messageText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        messageInput.value = messageText;
        if (error.message.includes('status: 419')) {
            window.location.reload();
        }
    });

    return false;
}

function escapeHtml(unsafe) {
    if (typeof unsafe !== 'string') return '';
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function scrollToBottom(container) {
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
}

// Хранилище для экземпляров чатов
const chatInstances = new Map();

// Класс для управления чатом
class ChatInstance {
    constructor(container, orderId) {
        if (!container || !orderId) {
            throw new Error('Container and orderId are required');
        }

        this.container = container;
        this.orderId = orderId;
        this.form = document.getElementById(`chat-form-${orderId}`);
        this.input = this.form ? this.form.querySelector('input[type="text"]') : null;
        this.submitButton = this.form ? this.form.querySelector('button[type="submit"]') : null;
        this.lastMessageId = 0;
        this.isAdmin = window.location.pathname.includes('/admin/');
        this.updateInterval = null;

        // Получаем ID последнего сообщения
        const messages = container.querySelectorAll('.message');
        if (messages.length > 0) {
            const lastMessage = messages[messages.length - 1];
            const messageId = lastMessage.getAttribute('data-message-id');
            this.lastMessageId = messageId ? parseInt(messageId) : 0;
        }

        this.initializeEventListeners();
        this.startUpdateInterval();
    }

    initializeEventListeners() {
        if (!this.form || !this.input || !this.submitButton) {
            console.error('Required elements not found');
            return;
        }

        // Обработчик формы
        this.form.onsubmit = (e) => {
            e.preventDefault();
            return false;
        };

        // Обработчик нажатия Enter
        this.input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage(this.orderId);
            }
        });

        // Обработчик кнопки отправки
        this.submitButton.addEventListener('click', (e) => {
            e.preventDefault();
            sendMessage(this.orderId);
        });
    }

    addMessage(message) {
        if (!message || !message.id || !message.message || !message.user) {
            console.error('Invalid message format:', message);
            return;
        }

        const messageId = parseInt(message.id);
        if (isNaN(messageId) || messageId <= 0) {
            console.error('Invalid message ID:', message);
            return;
        }

        // Проверяем, не существует ли уже сообщение с таким ID
        if (this.container.querySelector(`[data-message-id="${messageId}"]`)) {
            return;
        }

        if (messageId > this.lastMessageId) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${message.is_admin ? 'message-admin' : 'message-user'}`;
            messageDiv.setAttribute('data-message-id', messageId);
            
            const userName = message.user.name ? escapeHtml(message.user.name) : 'Unknown User';
            const messageContent = escapeHtml(message.message);
            const messageTime = message.created_at ? new Date(message.created_at).toLocaleString('ru-RU') : new Date().toLocaleString('ru-RU');
            
            messageDiv.innerHTML = `
                <div class="message-header">
                    <span class="message-name">${userName}</span>
                    <span class="message-time">${messageTime}</span>
                </div>
                <div class="message-content">${messageContent}</div>
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
                if (response.status === 401) {
                    window.location.href = '/login';
                    throw new Error('Unauthorized');
                }
                if (response.status === 403) {
                    console.error('Access denied');
                    throw new Error('Access denied');
                }
                if (response.status === 419) {
                    window.location.reload();
                    throw new Error('CSRF token mismatch');
                }
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success && Array.isArray(data.messages)) {
                    data.messages.forEach(message => {
                        this.addMessage(message);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching messages:', error);
                if (error.message === 'Access denied') {
                    // Останавливаем обновление сообщений при отсутствии доступа
                    if (this.updateInterval) {
                        clearInterval(this.updateInterval);
                        this.updateInterval = null;
                    }
                }
            });
    }

    startUpdateInterval() {
        // Очищаем предыдущий интервал, если он существует
        if (this.updateInterval) {
            clearInterval(this.updateInterval);
        }
        
        // Устанавливаем новый интервал
        this.updateInterval = setInterval(() => this.updateMessages(), 3000);
    }

    destroy() {
        if (this.updateInterval) {
            clearInterval(this.updateInterval);
        }
    }
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    const messageContainers = document.querySelectorAll('[id^="messages-"]');
    
    messageContainers.forEach(container => {
        const orderId = container.id.replace('messages-', '');
        if (!chatInstances.has(orderId)) {
            try {
                const chatInstance = new ChatInstance(container, orderId);
                chatInstances.set(orderId, chatInstance);
                scrollToBottom(container);
            } catch (error) {
                console.error('Error initializing chat:', error);
            }
        }
    });
}); 