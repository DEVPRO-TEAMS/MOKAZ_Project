@extends('layouts.app')
@section('content')
    <style>
        :root {
            --primary: #FF6B35;
            --primary-dark: #E85A29;
            --primary-light: #FFE9E0;
            --secondary: #004E89;
            --secondary-dark: #003D6E;
            --secondary-light: #E6F0F9;
            --success: #06D6A0;
            --success-dark: #04A777;
            --success-light: #E6FBF5;
            --warning: #FFB627;
            --warning-dark: #F5A623;
            --warning-light: #FFF5E6;
            --danger: #EF476F;
            --danger-dark: #D43A5E;
            --danger-light: #FDE8ED;
            --info: #667eea;
            --info-dark: #5568d3;
            --info-light: #F0F3FF;
            --bg-main: #FAFBFC;
            --bg-card: #FFFFFF;
            --bg-sidebar: #0F172A;
            --text-primary: #1A202C;
            --text-secondary: #718096;
            --text-light: #CBD5E0;
            --text-white: #FFFFFF;
            --border: #E2E8F0;
            --border-light: #F1F5F9;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.1);
            --shadow-sm: 0 2px 10px rgba(0, 0, 0, 0.04);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --transition: all 0.3s ease;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--border);
        }

        .header-left h1 {
            font-family: 'Clash Display', sans-serif;
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 0.375rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .header-subtitle i {
            color: var(--primary);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .period-selector {
            display: flex;
            gap: 0.25rem;
            background: var(--bg-card);
            padding: 0.375rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
        }

        .period-btn {
            padding: 0.625rem 1.5rem;
            border: none;
            background: transparent;
            border-radius: var(--radius-md);
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            color: var(--text-secondary);
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .period-btn.active {
            background: var(--primary);
            color: var(--text-white);
            box-shadow: var(--shadow-sm);
        }

        .period-btn:hover:not(.active) {
            background: var(--bg-main);
            color: var(--text-primary);
        }

        /* KPI Cards Grid */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .kpi-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .kpi-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .kpi-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 100%);
        }

        .kpi-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .kpi-title {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kpi-icon {
            width: 52px;
            height: 52px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: var(--shadow-sm);
        }

        .kpi-value {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            font-family: 'Clash Display', sans-serif;
        }

        .kpi-trend {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .trend-up {
            color: var(--success);
        }

        .trend-down {
            color: var(--danger);
        }

        .trend-neutral {
            color: var(--warning);
        }




        /* Responsive */
        @media (max-width: 1200px) {
            .chart-section, .map-section {
                grid-template-columns: 1fr;
            }
            
            .kpi-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 992px) {
            
            .header {
                flex-direction: column;
                gap: 1.5rem;
                align-items: flex-start;
            }
            
            .header-right {
                width: 100%;
                justify-content: space-between;
            }
            
            .period-selector {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 768px) {
            .kpi-grid {
                grid-template-columns: 1fr;
            }
            
            .table-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
            
            .table-actions {
                width: 100%;
                flex-direction: column;
            }
            
            .search-box {
                width: 100%;
            }
            
            .export-btn {
                width: 100%;
                justify-content: center;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            .footer {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .kpi-card, .chart-card, .table-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .kpi-card:nth-child(2) { animation-delay: 0.1s; }
        .kpi-card:nth-child(3) { animation-delay: 0.2s; }
        .kpi-card:nth-child(4) { animation-delay: 0.3s; }
        .kpi-card:nth-child(5) { animation-delay: 0.4s; }
        .kpi-card:nth-child(6) { animation-delay: 0.5s; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-main);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-secondary);
        }

        /* Tooltip */
        [data-tooltip] {
            position: relative;
        }

        [data-tooltip]:before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--text-primary);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 1000;
        }

        [data-tooltip]:hover:before {
            opacity: 1;
            visibility: visible;
            bottom: calc(100% + 5px);
        }
    </style>

    <div class="container-fluid py-4">
        <!-- En-tête -->
        {{-- <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-handshake me-2 text-danger"></i>
                    Tableau de Bord - Demandes de Partenariat
                </h1>
                <p class="text-muted">Gestion et suivi des demandes de partenariat</p>
            </div>
        </div> --}}

        <!-- Main Content -->
        <header class="header py-5">
            <div class="header-left">
                <h1>Tableau de Bord Statistiques</h1>
                <p class="header-subtitle">
                    <i class="fas fa-chart-line"></i>
                    Vue d'ensemble des performances de la plateforme MOKAZ
                </p>
            </div>
            <div class="header-right">
                <div class="period-selector">
                    <button class="period-btn">Aujourd'hui</button>
                    <button class="period-btn">Semaine</button>
                    <button class="period-btn active">Mois</button>
                    <button class="period-btn">Trimestre</button>
                    <button class="period-btn">Année</button>
                </div>
                {{-- <div class="user-profile">
                    <div class="user-avatar">AD</div>
                    <div class="user-info">
                        <div class="user-name">Admin MOKAZ</div>
                        <div class="user-role">Administrateur Principal</div>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </div> --}}
            </div>
        </header>
        <!-- KPI Cards -->
            <section class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div>
                            <div class="kpi-title">Visiteurs Uniques</div>
                        </div>
                        <div class="kpi-icon" style="background: var(--primary-light); color: var(--primary);">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="kpi-value">47,532</div>
                    <div class="kpi-trend trend-up">
                        <i class="fas fa-arrow-up"></i>
                        <span>+12.5%</span>
                        <span style="color: var(--text-secondary); font-weight: 500;">vs mois dernier</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 75%;"></div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-header">
                        <div>
                            <div class="kpi-title">Sessions Totales</div>
                        </div>
                        <div class="kpi-icon" style="background: var(--secondary-light); color: var(--secondary);">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                    </div>
                    <div class="kpi-value">89,247</div>
                    <div class="kpi-trend trend-up">
                        <i class="fas fa-arrow-up"></i>
                        <span>+18.3%</span>
                        <span style="color: var(--text-secondary); font-weight: 500;">vs mois dernier</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 85%;"></div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-header">
                        <div>
                            <div class="kpi-title">Durée Moyenne Session</div>
                        </div>
                        <div class="kpi-icon" style="background: var(--success-light); color: var(--success);">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="kpi-value">4m 32s</div>
                    <div class="kpi-trend trend-up">
                        <i class="fas fa-arrow-up"></i>
                        <span>+8.2%</span>
                        <span style="color: var(--text-secondary); font-weight: 500;">vs mois dernier</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 65%;"></div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-header">
                        <div>
                            <div class="kpi-title">Taux de Rebond</div>
                        </div>
                        <div class="kpi-icon" style="background: var(--warning-light); color: var(--warning);">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="kpi-value">32.8%</div>
                    <div class="kpi-trend trend-down">
                        <i class="fas fa-arrow-down"></i>
                        <span>-5.7%</span>
                        <span style="color: var(--text-secondary); font-weight: 500;">vs mois dernier</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 33%; background: var(--success);"></div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-header">
                        <div>
                            <div class="kpi-title">Nouveaux Visiteurs</div>
                        </div>
                        <div class="kpi-icon" style="background: var(--info-light); color: var(--info);">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <div class="kpi-value">28,945</div>
                    <div class="kpi-trend trend-up">
                        <i class="fas fa-arrow-up"></i>
                        <span>+15.4%</span>
                        <span style="color: var(--text-secondary); font-weight: 500;">61% du total</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 61%;"></div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-header">
                        <div>
                            <div class="kpi-title">Visiteurs Récurrents</div>
                        </div>
                        <div class="kpi-icon" style="background: rgba(118, 75, 162, 0.15); color: #764ba2;">
                            <i class="fas fa-redo"></i>
                        </div>
                    </div>
                    <div class="kpi-value">18,587</div>
                    <div class="kpi-trend trend-up">
                        <i class="fas fa-arrow-up"></i>
                        <span>+9.1%</span>
                        <span style="color: var(--text-secondary); font-weight: 500;">39% du total</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 39%;"></div>
                    </div>
                </div>
            </section>

        <!-- Statistiques principales -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="dashboard-card stat-card">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Demandes</div>
                                <div class="h5 mb-0 font-weight-bold" id="totalRequests">156</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="dashboard-card stat-card pending">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">En Attente</div>
                                <div class="h5 mb-0 font-weight-bold" id="pendingRequests">42</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="dashboard-card stat-card actif">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Approuvées</div>
                                <div class="h5 mb-0 font-weight-bold" id="activeRequests">89</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="dashboard-card stat-card inactif">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Rejetées</div>
                                <div class="h5 mb-0 font-weight-bold" id="inactiveRequests">25</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="row mb-4" style="min-height: 40vh;">
            <div class="col-xl-8 col-lg-7 h-100">
                <div class="card dashboard-card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Évolution des Demandes</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="min-height: 100%; ">
                            <canvas id="requestsChart" style="min-height: 300px; "></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                <div class="card dashboard-card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Répartition par État</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Récupération des données passées depuis le contrôleur
        const partnerships = {!! json_encode($partnerships) !!};
        const monthlyData = {!! json_encode($monthlyData) !!};

        // Mise à jour des statistiques principales
        document.getElementById('totalRequests').textContent = {!! $totalRequests !!};
        document.getElementById('pendingRequests').textContent = {!! $pendingRequests !!};
        document.getElementById('activeRequests').textContent = {!! $activeRequests !!};
        document.getElementById('inactiveRequests').textContent = {!! $inactiveRequests !!};

        // Initialisation des graphiques
        function initCharts() {
            // Graphique d'évolution des demandes
            const requestsCtx = document.getElementById('requestsChart').getContext('2d');
            new Chart(requestsCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                    datasets: [{
                        label: 'Demandes',
                        data: monthlyData,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.parsed.y} demandes`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            // Graphique de répartition par état
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['En attente', 'Approuvé', 'Rejeté'],
                    datasets: [{
                        data: [
                            {!! $pendingRequests !!},
                            {!! $activeRequests !!},
                            {!! $inactiveRequests !!}
                        ],
                        backgroundColor: [
                            '#ffc107',
                            '#28a745',
                            '#dc3545'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Le reste de votre code JavaScript peut rester inchangé
        document.addEventListener('DOMContentLoaded', function() {
            initCharts();
        });
    </script>
@endsection
