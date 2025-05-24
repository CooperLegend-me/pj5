<template>
  <div class="stats-container">
    <div class="stats-header">
      <h2>Статистика заказов</h2>
      <div class="stats-filters">
        <select v-model="timeRange" @change="loadStats">
          <option value="week">За неделю</option>
          <option value="month">За месяц</option>
          <option value="year">За год</option>
        </select>
      </div>
    </div>
    
    <div class="stats-grid">
      <div class="stats-card">
        <h3>Популярные типы домов</h3>
        <canvas ref="houseTypeChart"></canvas>
      </div>
      
      <div class="stats-card">
        <h3>Статусы заказов</h3>
        <canvas ref="statusChart"></canvas>
      </div>
      
      <div class="stats-card">
        <h3>Средняя стоимость</h3>
        <div class="average-cost">
          {{ formatPrice(averageCost) }} ₽
        </div>
      </div>
      
      <div class="stats-card">
        <h3>Количество заказов</h3>
        <div class="total-orders">
          {{ totalOrders }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Chart from 'chart.js/auto'

export default {
  data() {
    return {
      timeRange: 'month',
      houseTypeChart: null,
      statusChart: null,
      averageCost: 0,
      totalOrders: 0
    }
  },
  mounted() {
    this.loadStats()
  },
  methods: {
    async loadStats() {
      try {
        const response = await axios.get(`/api/admin/stats?timeRange=${this.timeRange}`)
        const data = response.data
        
        this.updateHouseTypeChart(data.houseTypes)
        this.updateStatusChart(data.statuses)
        this.averageCost = data.averageCost
        this.totalOrders = data.totalOrders
      } catch (error) {
        console.error('Error loading stats:', error)
      }
    },
    updateHouseTypeChart(data) {
      const ctx = this.$refs.houseTypeChart.getContext('2d')
      
      if (this.houseTypeChart) {
        this.houseTypeChart.destroy()
      }
      
      this.houseTypeChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: data.map(item => item.name),
          datasets: [{
            data: data.map(item => item.count),
            backgroundColor: [
              '#FF6384',
              '#36A2EB',
              '#FFCE56'
            ]
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      })
    },
    updateStatusChart(data) {
      const ctx = this.$refs.statusChart.getContext('2d')
      
      if (this.statusChart) {
        this.statusChart.destroy()
      }
      
      this.statusChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: data.map(item => item.name),
          datasets: [{
            data: data.map(item => item.count),
            backgroundColor: [
              '#FF6384',
              '#36A2EB',
              '#FFCE56',
              '#4BC0C0'
            ]
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      })
    },
    formatPrice(price) {
      return new Intl.NumberFormat('ru-RU').format(price)
    }
  }
}
</script>

<style scoped>
.stats-container {
  padding: 2rem;
}

.stats-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 2rem;
}

.stats-card {
  background: white;
  border-radius: 8px;
  padding: 1.5rem;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.stats-card h3 {
  margin-bottom: 1rem;
  color: #333;
}

.average-cost, .total-orders {
  font-size: 2rem;
  font-weight: bold;
  color: #007bff;
  text-align: center;
  margin-top: 1rem;
}

.stats-filters select {
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  background-color: white;
}
</style> 