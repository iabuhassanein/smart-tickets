<template>
  <MainLayout>
    <div class="dashboard-container">
      <h1>Dashboard</h1>

      <!-- Statistics Cards -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-content">
            <div class="stat-info">
              <p class="stat-label">Total Tickets</p>
              <p class="stat-value">{{ totalTickets }}</p>
            </div>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-content">
            <div class="stat-info">
              <p class="stat-label">New Tickets</p>
              <p class="stat-value">{{ ticketsByStatus.new || 0 }}</p>
            </div>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-content">
            <div class="stat-info">
              <p class="stat-label">In Progress</p>
              <p class="stat-value">{{ ticketsByStatus.in_progress || 0 }}</p>
            </div>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-content">
            <div class="stat-info">
              <p class="stat-label">Done</p>
              <p class="stat-value">{{ ticketsByStatus.done || 0 }}</p>
            </div>
          </div>
        </div>
      </div>
        <!-- Category Statistics -->
        <div class="category-section">
            <div class="section-header">
                <h3>Tickets Per Category</h3>
            </div>
            <div class="category-grid">
                <div
                    v-for="(count, category) in ticketsByCategory"
                    :key="category"
                    class="category-item"
                >
                    <span class="category-label">{{ formatCategoryLabel(category) }}</span>
                    <span class="category-count">{{ count }}</span>
                </div>
            </div>
        </div>

      <!-- Charts Section -->
      <div class="charts-grid">
        <div class="chart-card">
          <h3>Tickets by Status</h3>
          <div class="chart-container">
            <canvas ref="statusChart"></canvas>
          </div>
        </div>

        <div class="chart-card">
          <h3>Tickets by Category</h3>
          <div class="chart-container">
            <canvas ref="categoryChart"></canvas>
          </div>
        </div>
      </div>

    </div>
  </MainLayout>
</template>

<script>
import MainLayout from "../Layouts/MainLayout.vue";
import { Chart, registerables } from 'chart.js';
import {dashboardStats} from "../ServerActions/Tickets.js";

Chart.register(...registerables);

export default {
    name: 'Dashboard',
    components: { MainLayout },
    data() {
        return {
            ticketsByStatus: {},
            ticketsByCategory: {},
            statusChart: null,
            categoryChart: null
        }
    },
    computed: {
        totalTickets() {
            return Object.values(this.ticketsByStatus).reduce((sum, count) => sum + count, 0);
        }
    },
    mounted() {
        this.fetchTicketStatistics();
    },
    beforeUnmount() {
        if (this.statusChart) {
            this.statusChart.destroy();
        }
        if (this.categoryChart) {
            this.categoryChart.destroy();
        }
    },
    methods: {
        async fetchTicketStatistics() {
            let _this = this
            dashboardStats().then(response => {
                _this.ticketsByStatus = response.tickets_by_status
                _this.ticketsByCategory = response.tickets_by_category
                _this.$nextTick(() => {
                    _this.createStatusChart();
                    _this.createCategoryChart();
                });
            }).catch(error => {
                console.log(error);
            })
        },
        createStatusChart() {
            const ctx = this.$refs.statusChart.getContext('2d');

            if (this.statusChart) {
                this.statusChart.destroy();
            }

            this.statusChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: Object.keys(this.ticketsByStatus).map(status => this.formatStatusLabel(status)),
                    datasets: [{
                        data: Object.values(this.ticketsByStatus),
                        backgroundColor: [
                            '#fbbf24',
                            '#f97316',
                            '#10b981'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });
        },

        createCategoryChart() {
            const ctx = this.$refs.categoryChart.getContext('2d');

            if (this.categoryChart) {
                this.categoryChart.destroy();
            }

            const colors = [
                '#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6',
                '#ec4899', '#06b6d4', '#84cc16', '#f97316', '#6366f1',
                '#14b8a6', '#f43f5e'
            ];

            this.categoryChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: Object.keys(this.ticketsByCategory).map(category => this.formatCategoryLabel(category)),
                    datasets: [{
                        data: Object.values(this.ticketsByCategory),
                        backgroundColor: colors.slice(0, Object.keys(this.ticketsByCategory).length),
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
        },

        formatStatusLabel(status) {
            const statusLabels = {
                new: 'New',
                in_progress: 'In Progress',
                done: 'Done'
            };
            return statusLabels[status] || status;
        },

        formatCategoryLabel(category) {
            const categoryLabels = {
                technical_support: 'Technical Support',
                billing_payment: 'Billing & Payment',
                account_access: 'Account Access',
                bug_report: 'Bug Report',
                feature_request: 'Feature Request',
                general_inquiry: 'General Inquiry',
                refund_request: 'Refund Request',
                installation_help: 'Installation Help',
                performance_issue: 'Performance Issue',
                security_concern: 'Security Concern',
                data_export: 'Data Export',
                integration_support: 'Integration Support'
            };
            return categoryLabels[category] || category.replace(/_/g, ' ');
        }
    }
}
</script>

<style scoped>
.dashboard-container {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

h1 {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 30px;
    color: #333;
}

/* Statistics Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    border: 1px solid #e5e7eb;
}

.stat-content {
    display: flex;
    align-items: center;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-right: 15px;
}

.stat-icon.total {
    background-color: #dbeafe;
}

.stat-icon.new {
    background-color: #fef3c7;
}

.stat-icon.progress {
    background-color: #fed7aa;
}

.stat-icon.done {
    background-color: #d1fae5;
}

.stat-info {
    flex: 1;
}

.stat-label {
    font-size: 14px;
    color: #6b7280;
    margin: 0 0 5px 0;
    font-weight: 500;
}

.stat-value {
    font-size: 24px;
    font-weight: bold;
    color: #1f2937;
    margin: 0;
}

/* Charts */
.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.chart-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    border: 1px solid #e5e7eb;
}

.chart-card h3 {
    font-size: 18px;
    font-weight: 600;
    margin: 0 0 20px 0;
    color: #333;
}

.chart-container {
    position: relative;
    height: 300px;
}

/* Category Section */
.category-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    margin-bottom: 40px;
}

.section-header {
    padding: 20px;
    border-bottom: 1px solid #e5e7eb;
}

.section-header h3 {
    font-size: 18px;
    font-weight: 600;
    margin: 0;
    color: #333;
}

.category-grid {
    padding: 20px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 15px;
}

.category-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    background-color: #f9fafb;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
}

.category-label {
    font-size: 14px;
    font-weight: 500;
    color: #374151;
}

.category-count {
    font-size: 14px;
    font-weight: bold;
    color: #1f2937;
    background-color: #e5e7eb;
    padding: 4px 8px;
    border-radius: 12px;
    min-width: 24px;
    text-align: center;
}

</style>
