<template>
  <div class="chat-container">
    <div class="chat-header">
      <h3>Чат по заказу</h3>
      <div class="order-status">
        Статус: {{ orderStatus }}
      </div>
    </div>
    <div class="messages" ref="messagesContainer">
      <div v-for="message in messages" :key="message.id" 
           :class="['message', message.is_admin ? 'admin' : 'user']">
        <div class="message-header">
          <span class="sender">{{ decodeUnicode(message.user.name) }}</span>
          <span class="time">{{ formatTime(message.created_at) }}</span>
        </div>
        <div class="message-content">{{ decodeUnicode(message.message) }}</div>
      </div>
    </div>
    <div class="chat-input">
      <input type="text" v-model="newMessage" @keyup.enter="sendMessage" 
             placeholder="Введите сообщение...">
      <button @click="sendMessage" :disabled="!newMessage.trim()">Отправить</button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    orderId: {
      type: Number,
      required: true
    },
    orderStatus: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      messages: [],
      newMessage: '',
      polling: null,
      isLoading: false
    }
  },
  mounted() {
    this.loadMessages()
    this.startPolling()
  },
  beforeUnmount() {
    this.stopPolling()
  },
  methods: {
    decodeUnicode(str) {
      if (!str) return '';
      return str.replace(/\\u[\dA-F]{4}/gi, function(match) {
        return String.fromCharCode(parseInt(match.replace(/\\u/g, ''), 16));
      });
    },
    async loadMessages() {
      if (this.isLoading) return;
      
      this.isLoading = true;
      try {
        const response = await axios.get(`/orders/${this.orderId}/messages`)
        if (response.data.success) {
          this.messages = response.data.messages
          this.scrollToBottom()
        } else {
          console.error('Ошибка при загрузке сообщений:', response.data.message)
        }
      } catch (error) {
        console.error('Ошибка при загрузке сообщений:', error)
      } finally {
        this.isLoading = false
      }
    },
    async sendMessage() {
      if (!this.newMessage.trim() || this.isLoading) return;

      this.isLoading = true;
      try {
        const response = await axios.post(`/orders/${this.orderId}/messages`, {
          message: this.newMessage.trim()
        })
        
        if (response.data.success) {
          this.messages.push(response.data.message)
          this.newMessage = ''
          this.scrollToBottom()
        } else {
          console.error('Ошибка при отправке сообщения:', response.data.message)
        }
      } catch (error) {
        console.error('Ошибка при отправке сообщения:', error)
      } finally {
        this.isLoading = false
      }
    },
    startPolling() {
      this.polling = setInterval(() => {
        if (!this.isLoading) {
          this.loadMessages()
        }
      }, 5000)
    },
    stopPolling() {
      if (this.polling) {
        clearInterval(this.polling)
      }
    },
    scrollToBottom() {
      this.$nextTick(() => {
        const container = this.$refs.messagesContainer
        if (container) {
          container.scrollTop = container.scrollHeight
        }
      })
    },
    formatTime(timestamp) {
      return new Date(timestamp).toLocaleString('ru-RU', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      })
    }
  }
}
</script>

<style scoped>
.chat-container {
  display: flex;
  flex-direction: column;
  height: 400px;
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
}

.chat-header {
  padding: 1rem;
  background-color: #f8f9fa;
  border-bottom: 1px solid #ddd;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.messages {
  flex: 1;
  overflow-y: auto;
  padding: 1rem;
  display: flex;
  flex-direction: column;
}

.message {
  margin-bottom: 1rem;
  max-width: 80%;
  opacity: 1;
  transition: opacity 0.3s ease;
}

.message.user {
  margin-left: auto;
  align-self: flex-end;
}

.message.admin {
  margin-right: auto;
  align-self: flex-start;
}

.message-header {
  font-size: 0.8rem;
  color: #666;
  margin-bottom: 0.25rem;
}

.message-content {
  padding: 0.5rem 1rem;
  border-radius: 1rem;
  background-color: #e9ecef;
  word-break: break-word;
}

.message.user .message-content {
  background-color: #007bff;
  color: white;
}

.message.admin .message-content {
  background-color: #e9ecef;
}

.chat-input {
  padding: 1rem;
  border-top: 1px solid #ddd;
  display: flex;
  gap: 0.5rem;
}

.chat-input input {
  flex: 1;
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.chat-input button {
  padding: 0.5rem 1rem;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.chat-input button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.chat-input button:not(:disabled):hover {
  background-color: #0056b3;
}

.order-status {
  font-size: 0.9rem;
  color: #666;
}
</style> 