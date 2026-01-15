// class DashboardManager {
//     constructor() {
//         this.currentPeriod = 'month';
//         this.isLoading = false;
//         this.charts = {
//             traffic: null,
//             source: null,
//             destinations: null
//         };
//         this.dataCache = new Map();
//         this.autoRefreshInterval = null;
//         this.initialize();
//     }

//     initialize() {
//         this.setupEventListeners();
//         this.loadAllData();
//         this.startAutoRefresh();
//     }

//     setupEventListeners() {
//         // Gestionnaire des boutons de période
//         document.querySelectorAll('.period-btn').forEach(btn => {
//             btn.addEventListener('click', async (e) => {
//                 if (this.isLoading) return;
                
//                 const period = e.target.getAttribute('data-period') || this.getPeriodFromText(e.target.textContent);
//                 await this.changePeriod(period);
//             });
//         });

//         // Boutons d'actualisation
//         document.getElementById('refreshChart')?.addEventListener('click', () => this.refreshTrafficChart());
//         document.getElementById('refreshSourceChart')?.addEventListener('click', () => this.refreshSourceData());
//         document.getElementById('refreshCanalData')?.addEventListener('click', () => this.refreshSourceData());

//         // Boutons plein écran
//         document.querySelectorAll('[data-tooltip="Plein écran"]').forEach(btn => {
//             btn.addEventListener('click', (e) => this.toggleFullscreen(e.target.closest('.chart-card')));
//         });

//         // Boutons de téléchargement
//         document.querySelectorAll('[data-tooltip="Télécharger"]').forEach(btn => {
//             btn.addEventListener('click', (e) => this.downloadChartData(e.target.closest('.chart-card')));
//         });

//         // Observer la visibilité de la page
//         document.addEventListener('visibilitychange', () => {
//             if (document.visibilityState === 'visible') {
//                 this.resumeAutoRefresh();
//             } else {
//                 this.pauseAutoRefresh();
//             }
//         });

//         // Gestion des résize pour les graphiques
//         let resizeTimer;
//         window.addEventListener('resize', () => {
//             clearTimeout(resizeTimer);
//             resizeTimer = setTimeout(() => this.handleResize(), 250);
//         });
//     }

//     async changePeriod(period) {
//         if (this.currentPeriod === period || this.isLoading) return;
        
//         this.currentPeriod = period;
        
//         // Mettre à jour le bouton actif
//         document.querySelectorAll('.period-btn').forEach(btn => {
//             btn.classList.remove('active');
//             const btnPeriod = btn.getAttribute('data-period') || this.getPeriodFromText(btn.textContent);
//             if (btnPeriod === period) {
//                 btn.classList.add('active');
//             }
//         });
        
//         // Vider le cache pour cette période
//         this.dataCache.clear();
        
//         await this.loadAllData();
//         this.showNotification(`Période changée: ${this.getPeriodName(period)}`, 'success');
//     }

//     async loadAllData() {
//         if (this.isLoading) return;
        
//         this.isLoading = true;
//         this.showGlobalLoading(true);
        
//         try {
//             // Charger en parallèle
//             await Promise.allSettled([
//                 this.loadKPIData(),
//                 this.loadTrafficChart(),
//                 this.loadSourcesData(),
//                 this.loadDestinationsChart()
//             ]);
//         } catch (error) {
//             console.error('Erreur lors du chargement des données:', error);
//             this.showNotification('Erreur lors du chargement des données', 'error');
//         } finally {
//             this.isLoading = false;
//             this.showGlobalLoading(false);
//         }
//     }

//     async loadKPIData(forceRefresh = false) {
//         const cacheKey = `kpis-${this.currentPeriod}`;
        
//         // Vérifier le cache
//         if (!forceRefresh && this.dataCache.has(cacheKey)) {
//             const data = this.dataCache.get(cacheKey);
//             this.updateKPICards(data.kpis, data.comparison_text);
//             return;
//         }
        
//         try {
//             // Afficher le chargement
//             this.showKPIloading(true);
            
//             const response = await fetch(`/api/dashboard/kpis?period=${this.currentPeriod}`);
            
//             if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
//             const data = await response.json();
            
//             // Mettre en cache
//             this.dataCache.set(cacheKey, data);
            
//             // Mettre à jour l'interface
//             this.updateKPICards(data.kpis, data.comparison_text);
            
//         } catch (error) {
//             console.error('Erreur KPI:', error);
//             this.showKPIError();
//             throw error;
//         } finally {
//             this.showKPIloading(false);
//         }
//     }

//     updateKPICards(kpis, comparisonText) {
//         const formatNumber = (num) => {
//             if (num >= 1000000) return (num / 1000000).toFixed(1) + 'M';
//             if (num >= 1000) return (num / 1000).toFixed(1) + 'k';
//             return new Intl.NumberFormat('fr-FR').format(num);
//         };

//         const kpiCards = document.querySelectorAll('.kpi-card');
        
//         if (!kpiCards.length) return;

//         // Calcul des pourcentages pour les barres de progression
//         const maxUniqueVisitors = Math.max(kpis.unique_visitors.value, 1);
//         const maxSessions = Math.max(kpis.total_sessions.value, 1);
//         const maxDuration = Math.max(kpis.avg_session_duration.raw_value || 600, 1); // 10 minutes max
//         const maxBounceRate = 100; // Pourcentage

//         // Carte 1: Visiteurs Uniques
//         this.updateKPICard(kpiCards[0], {
//             value: formatNumber(kpis.unique_visitors.value),
//             trend: kpis.unique_visitors.trend,
//             direction: kpis.unique_visitors.trend_direction,
//             progress: Math.min((kpis.unique_visitors.value / maxUniqueVisitors) * 100, 100),
//             comparison: comparisonText || 'vs période précédente'
//         });

//         // Carte 2: Sessions Totales
//         this.updateKPICard(kpiCards[1], {
//             value: formatNumber(kpis.total_sessions.value),
//             trend: kpis.total_sessions.trend,
//             direction: kpis.total_sessions.trend_direction,
//             progress: Math.min((kpis.total_sessions.value / maxSessions) * 100, 100),
//             comparison: comparisonText || 'vs période précédente'
//         });

//         // Carte 3: Durée Moyenne Session
//         const durationValue = kpis.avg_session_duration.raw_value || 0;
//         this.updateKPICard(kpiCards[2], {
//             value: kpis.avg_session_duration.value,
//             trend: kpis.avg_session_duration.trend,
//             direction: kpis.avg_session_duration.trend_direction,
//             progress: Math.min((durationValue / maxDuration) * 100, 100),
//             comparison: comparisonText || 'vs période précédente'
//         });

//         // Carte 4: Taux de Rebond
//         this.updateKPICard(kpiCards[3], {
//             value: `${kpis.bounce_rate.value}%`,
//             trend: kpis.bounce_rate.trend,
//             direction: kpis.bounce_rate.trend_direction,
//             progress: Math.min(kpis.bounce_rate.value, 100),
//             isBounce: true,
//             comparison: comparisonText || 'vs période précédente'
//         });

//         // Carte 5: Nouveaux Visiteurs
//         this.updateKPICard(kpiCards[4], {
//             value: formatNumber(kpis.new_visitors.value),
//             trend: kpis.new_visitors.trend,
//             direction: kpis.new_visitors.trend_direction,
//             progress: kpis.new_visitors.percentage,
//             comparison: `${kpis.new_visitors.percentage}% du total`
//         });

//         // Carte 6: Visiteurs Récurrents
//         this.updateKPICard(kpiCards[5], {
//             value: formatNumber(kpis.returning_visitors.value),
//             trend: kpis.returning_visitors.trend,
//             direction: kpis.returning_visitors.trend_direction,
//             progress: kpis.returning_visitors.percentage,
//             comparison: `${kpis.returning_visitors.percentage}% du total`
//         });
//     }

//     updateKPICard(card, data) {
//         // Valeur principale
//         const valueEl = card.querySelector('.kpi-value');
//         if (valueEl) {
//             valueEl.textContent = data.value;
//             valueEl.classList.remove('loading', 'error');
//         }

//         // Tendance
//         const trendEl = card.querySelector('.kpi-trend');
//         if (trendEl) {
//             trendEl.className = `kpi-trend trend-${data.direction}`;
//             const arrowIcon = data.direction === 'up' ? 'fa-arrow-up' : 
//                             data.direction === 'down' ? 'fa-arrow-down' : 'fa-minus';
            
//             trendEl.innerHTML = `
//                 <div class="trend-content">
//                     <i class="fas ${arrowIcon}"></i>
//                     <span>${data.trend >= 0 ? '+' : ''}${data.trend}%</span>
//                     <span class="comparison">${data.comparison}</span>
//                 </div>
//             `;
            
//             // Pour le taux de rebond, inverser la couleur
//             if (data.isBounce) {
//                 trendEl.classList.add('bounce-rate');
//             }
//         }

//         // Barre de progression
//         const progressFill = card.querySelector('.progress-fill');
//         if (progressFill) {
//             progressFill.style.width = `${data.progress}%`;
//             progressFill.style.transition = 'width 0.8s ease';
//         }
//     }

//     async loadTrafficChart(forceRefresh = false) {
//         const cacheKey = `traffic-${this.currentPeriod}`;
        
//         // Vérifier le cache
//         if (!forceRefresh && this.dataCache.has(cacheKey)) {
//             this.renderTrafficChart(this.dataCache.get(cacheKey));
//             return;
//         }
        
//         const canvas = document.getElementById('trafficChart');
//         if (!canvas) return;
        
//         const container = canvas.closest('.chart-container');
//         const loadingEl = container?.querySelector('.chart-loading');
        
//         if (loadingEl) loadingEl.style.display = 'flex';
        
//         try {
//             const response = await fetch(`/api/dashboard/traffic-chart?period=${this.currentPeriod}`);
            
//             if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
//             const data = await response.json();
            
//             // Mettre en cache
//             this.dataCache.set(cacheKey, data);
            
//             // Rendre le graphique
//             this.renderTrafficChart(data);
            
//         } catch (error) {
//             console.error('Erreur graphique trafic:', error);
//             this.showChartError(canvas, 'Erreur de chargement du graphique');
//         } finally {
//             if (loadingEl) loadingEl.style.display = 'none';
//         }
//     }

//     renderTrafficChart(data) {
//         const canvas = document.getElementById('trafficChart');
//         if (!canvas) return;
        
//         const ctx = canvas.getContext('2d');
        
//         // Détruire le graphique existant
//         if (this.charts.traffic) {
//             this.charts.traffic.destroy();
//         }
        
//         // Mettre à jour le titre selon la période
//         const titleMap = {
//             'today': 'Évolution du Trafic - Aujourd\'hui',
//             'week': 'Évolution du Trafic - Cette Semaine',
//             'month': 'Évolution du Trafic - Ce Mois',
//             'quarter': 'Évolution du Trafic - Ce Trimestre',
//             'year': 'Évolution du Trafic - Cette Année'
//         };
        
//         const chartTitle = document.querySelector('.full-width-chart .chart-title');
//         if (chartTitle) {
//             chartTitle.textContent = titleMap[this.currentPeriod] || 'Évolution du Trafic';
//         }
        
//         this.charts.traffic = new Chart(ctx, {
//             type: 'line',
//             data: {
//                 labels: data.labels || [],
//                 datasets: [
//                     {
//                         label: 'Visiteurs uniques',
//                         data: data.unique_visitors_data || [],
//                         borderColor: '#FF6B35',
//                         backgroundColor: 'rgba(255, 107, 53, 0.1)',
//                         tension: 0.4,
//                         fill: true,
//                         borderWidth: 3,
//                         pointRadius: 4,
//                         pointBackgroundColor: '#FF6B35',
//                         pointBorderColor: '#FFFFFF',
//                         pointBorderWidth: 2,
//                         pointHoverRadius: 6
//                     },
//                     {
//                         label: 'Sessions',
//                         data: data.total_sessions_data || [],
//                         borderColor: '#004E89',
//                         backgroundColor: 'rgba(0, 78, 137, 0.1)',
//                         tension: 0.4,
//                         fill: true,
//                         borderWidth: 3,
//                         pointRadius: 4,
//                         pointBackgroundColor: '#004E89',
//                         pointBorderColor: '#FFFFFF',
//                         pointBorderWidth: 2,
//                         pointHoverRadius: 6
//                     }
//                 ]
//             },
//             options: {
//                 responsive: true,
//                 maintainAspectRatio: false,
//                 plugins: {
//                     legend: {
//                         display: false
//                     },
//                     tooltip: {
//                         backgroundColor: 'rgba(0, 0, 0, 0.8)',
//                         padding: 12,
//                         titleFont: {
//                             size: 14,
//                             weight: 'bold'
//                         },
//                         bodyFont: {
//                             size: 13
//                         },
//                         cornerRadius: 8,
//                         mode: 'index',
//                         intersect: false,
//                         callbacks: {
//                             label: (context) => {
//                                 let label = context.dataset.label || '';
//                                 if (label) {
//                                     label += ': ';
//                                 }
//                                 label += new Intl.NumberFormat('fr-FR').format(context.parsed.y);
//                                 return label;
//                             }
//                         }
//                     }
//                 },
//                 scales: {
//                     y: {
//                         beginAtZero: true,
//                         grid: {
//                             color: 'rgba(0, 0, 0, 0.05)'
//                         },
//                         ticks: {
//                             callback: function(value) {
//                                 if (value >= 1000) {
//                                     return (value / 1000).toFixed(0) + 'k';
//                                 }
//                                 return value;
//                             }
//                         }
//                     },
//                     x: {
//                         grid: {
//                             display: false
//                         }
//                     }
//                 },
//                 interaction: {
//                     intersect: false,
//                     mode: 'index'
//                 },
//                 animation: {
//                     duration: 750,
//                     easing: 'easeOutQuart'
//                 }
//             }
//         });
//     }

//     async loadSourcesData(forceRefresh = false) {
//         const cacheKey = `sources-${this.currentPeriod}`;
        
//         // Vérifier le cache
//         if (!forceRefresh && this.dataCache.has(cacheKey)) {
//             const data = this.dataCache.get(cacheKey);
//             this.renderSourceChart(data);
//             this.renderCanalDistribution(data);
//             return;
//         }
        
//         try {
//             // Afficher les états de chargement
//             this.showSourceLoading(true);
            
//             const response = await fetch(`/api/dashboard/sources?period=${this.currentPeriod}`);
            
//             if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
//             const data = await response.json();
            
//             // Mettre en cache
//             this.dataCache.set(cacheKey, data);
            
//             // Rendre les graphiques
//             this.renderSourceChart(data);
//             this.renderCanalDistribution(data);
            
//         } catch (error) {
//             console.error('Erreur sources:', error);
//             this.showSourceError();
//         } finally {
//             this.showSourceLoading(false);
//         }
//     }

//     renderSourceChart(data) {
//         const canvas = document.getElementById('sourceChart');
//         if (!canvas) return;
        
//         const ctx = canvas.getContext('2d');
        
//         // Détruire le graphique existant
//         if (this.charts.source) {
//             this.charts.source.destroy();
//         }
        
//         const sources = data.sources || [];
//         const total = sources.reduce((sum, source) => sum + (source.count || 0), 0);
        
//         // Mettre à jour le titre
//         const titleMap = {
//             'today': 'Sources du Trafic - Aujourd\'hui',
//             'week': 'Sources du Trafic - Cette Semaine',
//             'month': 'Sources du Trafic - Ce Mois',
//             'quarter': 'Sources du Trafic - Ce Trimestre',
//             'year': 'Sources du Trafic - Cette Année'
//         };
        
//         const chartTitle = canvas.closest('.chart-card').querySelector('.chart-title');
//         if (chartTitle) {
//             chartTitle.textContent = titleMap[this.currentPeriod] || 'Sources de Trafic';
//         }
        
//         this.charts.source = new Chart(ctx, {
//             type: 'doughnut',
//             data: {
//                 labels: sources.map(s => s.source),
//                 datasets: [{
//                     data: sources.map(s => s.percentage),
//                     backgroundColor: this.getSourceColors(sources.length),
//                     borderWidth: 2,
//                     borderColor: '#fff',
//                     hoverOffset: 15
//                 }]
//             },
//             options: {
//                 responsive: true,
//                 maintainAspectRatio: false,
//                 plugins: {
//                     legend: {
//                         position: 'bottom',
//                         labels: {
//                             padding: 20,
//                             font: {
//                                 size: 12,
//                                 weight: '600'
//                             },
//                             usePointStyle: true,
//                             pointStyle: 'circle'
//                         }
//                     },
//                     tooltip: {
//                         backgroundColor: 'rgba(0, 0, 0, 0.8)',
//                         padding: 12,
//                         cornerRadius: 8,
//                         callbacks: {
//                             label: (context) => {
//                                 const source = sources[context.dataIndex];
//                                 return [
//                                     `${source.source}: ${source.percentage}%`,
//                                     `Visites: ${new Intl.NumberFormat('fr-FR').format(source.count || 0)}`,
//                                     `Total: ${new Intl.NumberFormat('fr-FR').format(total)}`
//                                 ];
//                             }
//                         }
//                     }
//                 },
//                 cutout: '65%',
//                 animation: {
//                     animateScale: true,
//                     animateRotate: true
//                 }
//             }
//         });
//     }

//     renderCanalDistribution(data) {
//         const container = document.getElementById('canalData');
//         if (!container) return;
        
//         const sources = data.sources || [];
//         const total = sources.reduce((sum, source) => sum + (source.count || 0), 0);
        
//         // Trier par pourcentage décroissant
//         const sortedSources = [...sources].sort((a, b) => b.percentage - a.percentage);
        
//         // Générer le HTML
//         let html = '';
        
//         sortedSources.forEach((source, index) => {
//             if (index < 5) { // Limiter à 5 canaux principaux
//                 const color = this.getSourceColor(index);
//                 const icon = this.getSourceIcon(source.source);
                
//                 html += `
//                     <div style="margin-bottom: 1.5rem;">
//                         <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
//                             <span style="font-weight: 600;">
//                                 <i class="fas ${icon}" style="color: ${color}; margin-right: 0.5rem;"></i>
//                                 ${source.source}
//                             </span>
//                             <span style="font-weight: 700; color: ${color};">${source.percentage}%</span>
//                         </div>
//                         <div class="progress-bar">
//                             <div class="progress-fill" style="width: ${source.percentage}%; background: ${color};"></div>
//                         </div>
//                         <div style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.25rem;">
//                             ${new Intl.NumberFormat('fr-FR').format(source.count || 0)} visites
//                         </div>
//                     </div>
//                 `;
//             }
//         });
        
//         // Ajouter le résumé avec la période
//         const periodName = this.getPeriodName(this.currentPeriod);
//         html += `
//             <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
//                 <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
//                     <span style="color: var(--text-secondary);">
//                         <i class="fas fa-chart-pie" style="margin-right: 0.5rem;"></i>
//                         Total des visites (${periodName.toLowerCase()})
//                     </span>
//                     <span style="font-weight: 700;">${new Intl.NumberFormat('fr-FR').format(total)}</span>
//                 </div>
//                 <div style="font-size: 0.9rem; color: var(--text-secondary);">
//                     ${sortedSources.length} sources de trafic
//                 </div>
//             </div>
//         `;
        
//         container.innerHTML = html;
//     }

//     async loadDestinationsChart(forceRefresh = false) {
//         const cacheKey = `cities-${this.currentPeriod}`;
        
//         // Vérifier le cache
//         if (!forceRefresh && this.dataCache.has(cacheKey)) {
//             this.renderDestinationsChart(this.dataCache.get(cacheKey));
//             return;
//         }
        
//         try {
//             const canvas = document.getElementById('destinationsChart');
//             if (!canvas) return;
            
//             const container = canvas.closest('.chart-container');
//             const loadingEl = container?.querySelector('.chart-loading');
            
//             if (loadingEl) loadingEl.style.display = 'flex';
            
//             const response = await fetch(`/api/dashboard/top-cities?period=${this.currentPeriod}`);
            
//             if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
//             const data = await response.json();
            
//             // Mettre en cache
//             this.dataCache.set(cacheKey, data);
            
//             // Rendre le graphique
//             this.renderDestinationsChart(data);
            
//         } catch (error) {
//             console.error('Erreur destinations:', error);
//         } finally {
//             const loadingEl = document.querySelector('#destinationsChart')?.closest('.chart-container')?.querySelector('.chart-loading');
//             if (loadingEl) loadingEl.style.display = 'none';
//         }
//     }

//     renderDestinationsChart(data) {
//         const canvas = document.getElementById('destinationsChart');
//         if (!canvas) return;
        
//         const ctx = canvas.getContext('2d');
        
//         // Détruire le graphique existant
//         if (this.charts.destinations) {
//             this.charts.destinations.destroy();
//         }
        
//         const cities = data.cities || [];
//         const maxVisits = Math.max(...cities.map(c => c.count), 1);
        
//         // Mettre à jour le titre selon la période
//         const titleMap = {
//             'today': 'Top Villes - Aujourd\'hui',
//             'week': 'Top Villes - Cette Semaine',
//             'month': 'Top Villes - Ce Mois',
//             'quarter': 'Top Villes - Ce Trimestre',
//             'year': 'Top Villes - Cette Année'
//         };
        
//         const chartTitle = canvas.closest('.chart-card')?.querySelector('.chart-title');
//         if (chartTitle) {
//             chartTitle.textContent = titleMap[this.currentPeriod] || 'Top Villes';
//         }
        
//         this.charts.destinations = new Chart(ctx, {
//             type: 'bar',
//             data: {
//                 labels: cities.map(c => c.city),
//                 datasets: [{
//                     label: 'Visites',
//                     data: cities.map(c => c.count),
//                     backgroundColor: cities.map((_, i) => 
//                         `hsla(${i * 60}, 70%, 60%, 0.8)`
//                     ),
//                     borderRadius: 8,
//                     borderWidth: 0,
//                     hoverBackgroundColor: cities.map((_, i) => 
//                         `hsla(${i * 60}, 70%, 50%, 1)`
//                     )
//                 }]
//             },
//             options: {
//                 responsive: true,
//                 maintainAspectRatio: false,
//                 plugins: {
//                     legend: {
//                         display: false
//                     },
//                     tooltip: {
//                         backgroundColor: 'rgba(0, 0, 0, 0.8)',
//                         padding: 12,
//                         cornerRadius: 8,
//                         callbacks: {
//                             label: (context) => {
//                                 const percentage = ((context.parsed.y / maxVisits) * 100).toFixed(1);
//                                 return [
//                                     `Visites: ${new Intl.NumberFormat('fr-FR').format(context.parsed.y)}`,
//                                     `Part: ${percentage}%`
//                                 ];
//                             }
//                         }
//                     }
//                 },
//                 scales: {
//                     y: {
//                         beginAtZero: true,
//                         grid: {
//                             color: 'rgba(0, 0, 0, 0.05)'
//                         },
//                         ticks: {
//                             callback: function(value) {
//                                 if (value >= 1000) {
//                                     return (value / 1000).toFixed(0) + 'k';
//                                 }
//                                 return value;
//                             }
//                         }
//                     },
//                     x: {
//                         grid: {
//                             display: false
//                         }
//                     }
//                 },
//                 animation: {
//                     duration: 1000,
//                     easing: 'easeOutQuart'
//                 }
//             }
//         });
//     }

//     // Méthodes d'actualisation
//     async refreshTrafficChart() {
//         await this.loadTrafficChart(true);
//         this.showNotification('Graphique de trafic actualisé', 'success');
//     }

//     async refreshSourceData() {
//         await this.loadSourcesData(true);
//         this.showNotification('Données des sources actualisées', 'success');
//     }

//     async refreshAllData() {
//         this.dataCache.clear();
//         await this.loadAllData();
//         this.showNotification('Toutes les données actualisées', 'success');
//     }

//     // Gestion du plein écran
//     toggleFullscreen(chartCard) {
//         if (!chartCard) return;
        
//         const isFullscreen = chartCard.classList.contains('fullscreen');
//         const fullscreenBtn = chartCard.querySelector('[data-tooltip="Plein écran"]');
        
//         if (!isFullscreen) {
//             chartCard.classList.add('fullscreen');
//             chartCard.style.position = 'fixed';
//             chartCard.style.top = '0';
//             chartCard.style.left = '0';
//             chartCard.style.width = '100vw';
//             chartCard.style.height = '100vh';
//             chartCard.style.zIndex = '9999';
//             chartCard.style.borderRadius = '0';
//             chartCard.style.padding = '20px';
//             chartCard.style.background = 'white';
//             chartCard.style.overflow = 'auto';
            
//             if (fullscreenBtn) {
//                 fullscreenBtn.innerHTML = '<i class="fas fa-compress"></i>';
//                 fullscreenBtn.setAttribute('data-tooltip', 'Quitter plein écran');
//             }
            
//             // Redessiner les graphiques
//             setTimeout(() => {
//                 Object.values(this.charts).forEach(chart => {
//                     if (chart) chart.resize();
//                 });
//             }, 100);
            
//             // Écouter la touche Échap
//             document.addEventListener('keydown', this.handleEscapeKey);
//         } else {
//             chartCard.classList.remove('fullscreen');
//             chartCard.style.cssText = '';
            
//             if (fullscreenBtn) {
//                 fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
//                 fullscreenBtn.setAttribute('data-tooltip', 'Plein écran');
//             }
            
//             document.removeEventListener('keydown', this.handleEscapeKey);
            
//             // Redessiner les graphiques
//             setTimeout(() => {
//                 Object.values(this.charts).forEach(chart => {
//                     if (chart) chart.resize();
//                 });
//             }, 100);
//         }
//     }

//     handleEscapeKey = (e) => {
//         if (e.key === 'Escape') {
//             const fullscreenCard = document.querySelector('.chart-card.fullscreen');
//             if (fullscreenCard) {
//                 this.toggleFullscreen(fullscreenCard);
//             }
//         }
//     }

//     // Téléchargement des données
//     async downloadChartData(chartCard) {
//         const chartTitle = chartCard.querySelector('.chart-title')?.textContent || 'donnees';
//         const canvas = chartCard.querySelector('canvas');
        
//         if (canvas) {
//             // Télécharger l'image
//             const link = document.createElement('a');
//             link.download = `${chartTitle.toLowerCase().replace(/\s+/g, '-')}.png`;
//             link.href = canvas.toDataURL('image/png');
//             link.click();
//             this.showNotification(`Graphique "${chartTitle}" téléchargé`, 'success');
//         } else {
//             // Pour les cartes sans canvas, essayer de télécharger les données
//             try {
//                 let dataUrl;
//                 const chartId = chartCard.querySelector('canvas')?.id;
                
//                 switch(chartId) {
//                     case 'trafficChart':
//                         dataUrl = await this.exportTrafficData();
//                         break;
//                     case 'sourceChart':
//                         dataUrl = await this.exportSourceData();
//                         break;
//                     default:
//                         throw new Error('Données non disponibles');
//                 }
                
//                 const link = document.createElement('a');
//                 link.download = `${chartTitle.toLowerCase().replace(/\s+/g, '-')}.json`;
//                 link.href = dataUrl;
//                 link.click();
//                 this.showNotification(`Données "${chartTitle}" téléchargées`, 'success');
//             } catch (error) {
//                 this.showNotification('Impossible de télécharger les données', 'error');
//             }
//         }
//     }

//     async exportTrafficData() {
//         const response = await fetch(`/api/dashboard/traffic-chart?period=${this.currentPeriod}`);
//         const data = await response.json();
//         const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
//         return URL.createObjectURL(blob);
//     }

//     async exportSourceData() {
//         const response = await fetch(`/api/dashboard/sources?period=${this.currentPeriod}`);
//         const data = await response.json();
//         const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
//         return URL.createObjectURL(blob);
//     }

//     // Gestion des tables
//     filterTable(input) {
//         const searchTerm = input.value.toLowerCase();
//         const table = input.closest('.table-card').querySelector('tbody');
//         const rows = table.querySelectorAll('tr');
        
//         rows.forEach(row => {
//             const text = row.textContent.toLowerCase();
//             row.style.display = text.includes(searchTerm) ? '' : 'none';
//         });
//     }

//     handleRowClick(row) {
//         // Exemple: basculer la sélection
//         row.classList.toggle('selected');
        
//         // Vous pouvez ajouter ici plus de logique pour les détails
//         if (row.classList.contains('selected')) {
//             console.log('Ligne sélectionnée:', row);
//         }
//     }

//     // Gestion du rafraîchissement automatique
//     startAutoRefresh(interval = 300000) { // 5 minutes par défaut
//         this.autoRefreshInterval = setInterval(() => {
//             if (document.visibilityState === 'visible') {
//                 this.refreshAllData();
//             }
//         }, interval);
//     }

//     pauseAutoRefresh() {
//         if (this.autoRefreshInterval) {
//             clearInterval(this.autoRefreshInterval);
//             this.autoRefreshInterval = null;
//         }
//     }

//     resumeAutoRefresh() {
//         if (!this.autoRefreshInterval) {
//             this.startAutoRefresh();
//         }
//     }

//     handleResize() {
//         // Redimensionner tous les graphiques
//         Object.values(this.charts).forEach(chart => {
//             if (chart) chart.resize();
//         });
//     }

//     // Méthodes utilitaires
//     getPeriodFromText(text) {
//         const periodMap = {
//             'Aujourd\'hui': 'today',
//             'Semaine': 'week',
//             'Mois': 'month',
//             'Trimestre': 'quarter',
//             'Année': 'year'
//         };
//         return periodMap[text.trim()] || 'month';
//     }

//     getPeriodName(periodKey) {
//         const periods = {
//             'today': "Aujourd'hui",
//             'week': 'Semaine',
//             'month': 'Mois',
//             'quarter': 'Trimestre',
//             'year': 'Année'
//         };
//         return periods[periodKey] || 'Mois';
//     }

//     getSourceColors(count) {
//         const baseColors = [
//             '#FF6B35', // Organique
//             '#004E89', // Direct
//             '#06D6A0', // Réseaux sociaux
//             '#FFB627', // Payant
//             '#667eea',  // Email
//             '#764ba2',  // Référence
//             '#FF4081',  // Autre 1
//             '#9C27B0',  // Autre 2
//             '#3F51B5',  // Autre 3
//             '#009688'   // Autre 4
//         ];
        
//         // Si on a besoin de plus de couleurs, on génère des variations
//         if (count <= baseColors.length) {
//             return baseColors.slice(0, count);
//         }
        
//         // Générer des couleurs supplémentaires
//         const colors = [...baseColors];
//         for (let i = baseColors.length; i < count; i++) {
//             const hue = (i * 137.508) % 360; // Utiliser l'angle d'or
//             colors.push(`hsl(${hue}, 70%, 60%)`);
//         }
        
//         return colors;
//     }

//     getSourceColor(index) {
//         const colors = this.getSourceColors(10);
//         return colors[index % colors.length];
//     }

//     getSourceIcon(sourceName) {
//         const iconMap = {
//             'Organique': 'fa-search',
//             'SEO': 'fa-search',
//             'Direct': 'fa-link',
//             'Réseaux Sociaux': 'fa-share-alt',
//             'Social': 'fa-share-alt',
//             'Payant (CPC)': 'fa-ad',
//             'Ads': 'fa-ad',
//             'Email': 'fa-envelope',
//             'Referral': 'fa-external-link-alt',
//             'Autre': 'fa-circle'
//         };
        
//         return iconMap[sourceName] || 'fa-circle';
//     }

//     // Méthodes d'affichage d'état
//     showGlobalLoading(show) {
//         const overlay = document.getElementById('globalLoading');
//         if (overlay) {
//             overlay.style.display = show ? 'flex' : 'none';
//         }
        
//         // Désactiver les boutons pendant le chargement
//         document.querySelectorAll('.period-btn, .chart-btn').forEach(btn => {
//             btn.disabled = show;
//         });
//     }

//     showKPIloading(show) {
//         const kpiValues = document.querySelectorAll('.kpi-value');
//         kpiValues.forEach(el => {
//             if (show) {
//                 el.classList.add('loading');
//                 el.textContent = 'Chargement...';
//             } else {
//                 el.classList.remove('loading');
//             }
//         });
//     }

//     showKPIError() {
//         const kpiValues = document.querySelectorAll('.kpi-value');
//         kpiValues.forEach(el => {
//             el.classList.remove('loading');
//             el.classList.add('error');
//             el.textContent = 'Erreur';
//         });
//     }

//     showSourceLoading(show) {
//         const sourceLoading = document.querySelector('#sourceChart')?.closest('.chart-container')?.querySelector('.chart-loading');
//         const canalData = document.getElementById('canalData');
        
//         if (sourceLoading) {
//             sourceLoading.style.display = show ? 'flex' : 'none';
//         }
        
//         if (canalData && show) {
//             canalData.innerHTML = `
//                 <div class="loading-placeholder">
//                     <div class="spinner small" style="margin: 0 auto 1rem;"></div>
//                     <p style="text-align: center; color: var(--text-secondary);">Chargement des données...</p>
//                 </div>
//             `;
//         }
//     }

//     showSourceError() {
//         const canalData = document.getElementById('canalData');
//         if (canalData) {
//             canalData.innerHTML = `
//                 <div style="text-align: center; padding: 2rem; color: var(--warning);">
//                     <i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 1rem;"></i>
//                     <p>Erreur lors du chargement des données</p>
//                     <button onclick="dashboard.refreshSourceData()" style="margin-top: 1rem; padding: 0.5rem 1rem; background: var(--primary); color: white; border: none; border-radius: 4px; cursor: pointer;">
//                         Réessayer
//                     </button>
//                 </div>
//             `;
//         }
//     }

//     showChartError(canvas, message) {
//         const ctx = canvas.getContext('2d');
//         const width = canvas.width;
//         const height = canvas.height;
        
//         ctx.clearRect(0, 0, width, height);
//         ctx.fillStyle = '#f8f9fa';
//         ctx.fillRect(0, 0, width, height);
        
//         ctx.fillStyle = '#6c757d';
//         ctx.font = '16px Arial';
//         ctx.textAlign = 'center';
//         ctx.fillText(message, width / 2, height / 2);
//     }

//     showNotification(message, type = 'info') {
//         // Créer le conteneur s'il n'existe pas
//         let container = document.getElementById('notificationContainer');
//         if (!container) {
//             container = document.createElement('div');
//             container.id = 'notificationContainer';
//             container.style.cssText = `
//                 position: fixed;
//                 top: 20px;
//                 right: 20px;
//                 z-index: 99999;
//             `;
//             document.body.appendChild(container);
//         }
        
//         // Créer la notification
//         const notification = document.createElement('div');
//         notification.className = `notification notification-${type}`;
        
//         const icons = {
//             success: 'fa-check-circle',
//             error: 'fa-exclamation-circle',
//             warning: 'fa-exclamation-triangle',
//             info: 'fa-info-circle'
//         };
        
//         notification.innerHTML = `
//             <div class="notification-content">
//                 <i class="fas ${icons[type] || icons.info}"></i>
//                 <span>${message}</span>
//                 <button class="notification-close">&times;</button>
//             </div>
//         `;
        
//         container.appendChild(notification);
        
//         // Animation d'entrée
//         requestAnimationFrame(() => {
//             notification.classList.add('show');
//         });
        
//         // Fermer la notification
//         const closeBtn = notification.querySelector('.notification-close');
//         closeBtn.addEventListener('click', () => {
//             notification.classList.remove('show');
//             setTimeout(() => notification.remove(), 300);
//         });
        
//         // Auto-suppression
//         setTimeout(() => {
//             if (notification.parentNode) {
//                 notification.classList.remove('show');
//                 setTimeout(() => notification.remove(), 300);
//             }
//         }, 5000);
//     }

//     // Méthodes de débogage
//     logPerformance() {
//         console.log('Performance du Dashboard:');
//         console.log(`- Cache size: ${this.dataCache.size}`);
//         console.log(`- Charts loaded: ${Object.values(this.charts).filter(c => c).length}`);
//         console.log(`- Current period: ${this.currentPeriod}`);
//         console.log(`- Is loading: ${this.isLoading}`);
//     }

//     // Nettoyage
//     destroy() {
//         this.pauseAutoRefresh();
        
//         // Détruire tous les graphiques
//         Object.values(this.charts).forEach(chart => {
//             if (chart) chart.destroy();
//         });
        
//         // Nettoyer les écouteurs d'événements
//         document.removeEventListener('keydown', this.handleEscapeKey);
        
//         // Vider le cache
//         this.dataCache.clear();
//     }
// }

// // Initialisation globale
// document.addEventListener('DOMContentLoaded', () => {
//     window.dashboard = new DashboardManager();
    
//     // Exposer globalement pour le débogage
//     window.dashboard = dashboard;
    
//     // Initialiser les tooltips
//     initTooltips();
// });

// // Fonction pour initialiser les tooltips
// function initTooltips() {
//     const tooltipElements = document.querySelectorAll('[data-tooltip]');
    
//     tooltipElements.forEach(element => {
//         let tooltip = null;
//         let hideTimeout = null;
        
//         element.addEventListener('mouseenter', (e) => {
//             if (hideTimeout) {
//                 clearTimeout(hideTimeout);
//                 hideTimeout = null;
//             }
            
//             tooltip = document.createElement('div');
//             tooltip.className = 'custom-tooltip';
//             tooltip.textContent = e.currentTarget.getAttribute('data-tooltip');
            
//             document.body.appendChild(tooltip);
            
//             const rect = e.currentTarget.getBoundingClientRect();
//             const tooltipRect = tooltip.getBoundingClientRect();
            
//             let top = rect.top - tooltipRect.height - 10;
//             let left = rect.left + (rect.width / 2) - (tooltipRect.width / 2);
            
//             // Ajuster si le tooltip dépasse de l'écran
//             if (top < 10) top = rect.bottom + 10;
//             if (left < 10) left = 10;
//             if (left + tooltipRect.width > window.innerWidth - 10) {
//                 left = window.innerWidth - tooltipRect.width - 10;
//             }
            
//             tooltip.style.top = `${top}px`;
//             tooltip.style.left = `${left}px`;
            
//             tooltip.classList.add('show');
//         });
        
//         element.addEventListener('mouseleave', () => {
//             if (tooltip) {
//                 tooltip.classList.remove('show');
//                 hideTimeout = setTimeout(() => {
//                     if (tooltip && tooltip.parentNode) {
//                         tooltip.remove();
//                         tooltip = null;
//                     }
//                 }, 300);
//             }
//         });
//     });
// }

// // Styles CSS dynamiques
// const dashboardStyles = `
//     /* États de chargement */
//     .kpi-value.loading {
//         color: #aaa;
//         font-style: italic;
//         background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
//         background-size: 200% 100%;
//         animation: loadingShimmer 1.5s infinite;
//         border-radius: 4px;
//         min-height: 2.5rem;
//         display: inline-block;
//         min-width: 100px;
//     }
    
//     .kpi-value.error {
//         color: #dc3545 !important;
//     }
    
//     @keyframes loadingShimmer {
//         0% { background-position: -200% 0; }
//         100% { background-position: 200% 0; }
//     }
    
//     .chart-loading {
//         position: absolute;
//         top: 0;
//         left: 0;
//         right: 0;
//         bottom: 0;
//         background: rgba(255, 255, 255, 0.9);
//         display: none;
//         flex-direction: column;
//         align-items: center;
//         justify-content: center;
//         z-index: 10;
//         border-radius: inherit;
//     }
    
//     .spinner {
//         width: 40px;
//         height: 40px;
//         border: 4px solid rgba(0, 0, 0, 0.1);
//         border-top-color: var(--primary, #3498db);
//         border-radius: 50%;
//         animation: spin 1s ease-in-out infinite;
//     }
    
//     .spinner.small {
//         width: 24px;
//         height: 24px;
//         border-width: 3px;
//     }
    
//     @keyframes spin {
//         to { transform: rotate(360deg); }
//     }
    
//     /* Notifications */
//     .notification {
//         background: white;
//         border-radius: 8px;
//         box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
//         margin-bottom: 10px;
//         transform: translateX(120%);
//         opacity: 0;
//         transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
//         overflow: hidden;
//         max-width: 400px;
//         border-left: 4px solid;
//     }
    
//     .notification.show {
//         transform: translateX(0);
//         opacity: 1;
//     }
    
//     .notification-success {
//         border-left-color: #06D6A0;
//     }
    
//     .notification-error {
//         border-left-color: #FF6B35;
//     }
    
//     .notification-warning {
//         border-left-color: #FFB627;
//     }
    
//     .notification-info {
//         border-left-color: #3498db;
//     }
    
//     .notification-content {
//         display: flex;
//         align-items: center;
//         padding: 16px 20px;
//         gap: 12px;
//     }
    
//     .notification-content i {
//         font-size: 1.2em;
//     }
    
//     .notification-success .notification-content i {
//         color: #06D6A0;
//     }
    
//     .notification-error .notification-content i {
//         color: #FF6B35;
//     }
    
//     .notification-close {
//         background: none;
//         border: none;
//         font-size: 1.5em;
//         cursor: pointer;
//         margin-left: auto;
//         color: #999;
//         padding: 0;
//         width: 24px;
//         height: 24px;
//         display: flex;
//         align-items: center;
//         justify-content: center;
//         transition: color 0.2s;
//     }
    
//     .notification-close:hover {
//         color: #333;
//     }
    
//     /* Tooltips */
//     .custom-tooltip {
//         position: fixed;
//         background: rgba(0, 0, 0, 0.85);
//         color: white;
//         padding: 8px 12px;
//         border-radius: 6px;
//         font-size: 12px;
//         font-weight: 500;
//         z-index: 99999;
//         pointer-events: none;
//         white-space: nowrap;
//         transform: translateY(-10px);
//         opacity: 0;
//         transition: all 0.2s ease;
//         box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
//     }
    
//     .custom-tooltip.show {
//         transform: translateY(0);
//         opacity: 1;
//     }
    
//     .custom-tooltip:after {
//         content: '';
//         position: absolute;
//         bottom: -5px;
//         left: 50%;
//         transform: translateX(-50%);
//         border-width: 5px 5px 0;
//         border-style: solid;
//         border-color: rgba(0, 0, 0, 0.85) transparent transparent;
//     }
    
//     /* États désactivés */
//     button:disabled {
//         opacity: 0.5;
//         cursor: not-allowed !important;
//     }
    
//     /* Plein écran */
//     .chart-card.fullscreen {
//         box-shadow: 0 0 0 100vmax rgba(0, 0, 0, 0.5);
//     }
    
//     /* Animation des tendances */
//     .trend-content {
//         display: flex;
//         align-items: center;
//         gap: 6px;
//     }
    
//     .trend-up {
//         color: #06D6A0;
//     }
    
//     .trend-down {
//         color: #FF6B35;
//     }
    
//     .kpi-trend.bounce-rate.trend-up {
//         color: #FF6B35;
//     }
    
//     .kpi-trend.bounce-rate.trend-down {
//         color: #06D6A0;
//     }
    
//     /* Loading overlay global */
//     #globalLoading {
//         position: fixed;
//         top: 0;
//         left: 0;
//         right: 0;
//         bottom: 0;
//         background: rgba(255, 255, 255, 0.95);
//         display: none;
//         flex-direction: column;
//         align-items: center;
//         justify-content: center;
//         z-index: 99999;
//     }
    
//     .loading-content {
//         text-align: center;
//         padding: 2rem;
//         background: white;
//         border-radius: 12px;
//         box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
//     }
    
//     /* Placeholder pour les données en cours de chargement */
//     .loading-placeholder {
//         padding: 2rem;
//         text-align: center;
//         color: var(--text-secondary);
//     }
    
//     /* Responsive */
//     @media (max-width: 768px) {
//         .notification {
//             left: 20px;
//             right: 20px;
//             max-width: none;
//         }
        
//         .custom-tooltip {
//             max-width: 200px;
//             white-space: normal;
//             text-align: center;
//         }
//     }
// `;


// // dashboard-geographic.js



// // Injecter les styles
// const styleSheet = document.createElement('style');
// styleSheet.textContent = dashboardStyles;
// document.head.appendChild(styleSheet);

// // Export pour utilisation dans d'autres fichiers
// if (typeof module !== 'undefined' && module.exports) {
//     module.exports = { DashboardManager };
// }


class DashboardManager {
    constructor() {
        this.currentPeriod = 'month';
        this.isLoading = false;
        this.charts = {
            traffic: null,
            source: null,
            destinations: null
        };
        this.dataCache = new Map();
        this.autoRefreshInterval = null;
        this.geographicManager = null;
        this.initialize();
    }

    initialize() {
        this.setupEventListeners();
        this.loadAllData();
        this.startAutoRefresh();
        
        // Initialiser le gestionnaire géographique après un délai
        setTimeout(() => {
            this.initGeographicManager();
        }, 100);
    }

    initGeographicManager() {
        if (document.getElementById('visitorMap')) {
            this.geographicManager = new GeographicManager(this);
        }
    }

    setupEventListeners() {
        // Gestionnaire des boutons de période
        document.querySelectorAll('.period-btn').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                if (this.isLoading) return;
                
                const period = e.target.getAttribute('data-period') || this.getPeriodFromText(e.target.textContent);
                await this.changePeriod(period);
            });
        });

        // Boutons d'actualisation
        document.getElementById('refreshChart')?.addEventListener('click', () => this.refreshTrafficChart());
        document.getElementById('refreshSourceChart')?.addEventListener('click', () => this.refreshSourceData());
        document.getElementById('refreshCanalData')?.addEventListener('click', () => this.refreshSourceData());
        document.getElementById('refreshMap')?.addEventListener('click', () => this.refreshGeographicData());
        document.getElementById('refreshCountries')?.addEventListener('click', () => this.refreshGeographicData());

        // Boutons plein écran
        document.querySelectorAll('[data-tooltip="Plein écran"]').forEach(btn => {
            btn.addEventListener('click', (e) => this.toggleFullscreen(e.target.closest('.chart-card')));
        });

        // Boutons de téléchargement
        document.querySelectorAll('[data-tooltip="Télécharger"]').forEach(btn => {
            btn.addEventListener('click', (e) => this.downloadChartData(e.target.closest('.chart-card')));
        });

        // Bouton légende carte
        document.getElementById('toggleLegend')?.addEventListener('click', () => {
            if (this.geographicManager) this.geographicManager.toggleLegend();
        });

        // Observer la visibilité de la page
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
                this.resumeAutoRefresh();
            } else {
                this.pauseAutoRefresh();
            }
        });

        // Gestion des résize pour les graphiques
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => this.handleResize(), 250);
        });
    }

    async changePeriod(period) {
        if (this.currentPeriod === period || this.isLoading) return;
        
        this.currentPeriod = period;
        
        // Mettre à jour le bouton actif
        document.querySelectorAll('.period-btn').forEach(btn => {
            btn.classList.remove('active');
            const btnPeriod = btn.getAttribute('data-period') || this.getPeriodFromText(btn.textContent);
            if (btnPeriod === period) {
                btn.classList.add('active');
            }
        });
        
        // Vider le cache pour cette période
        this.dataCache.clear();
        
        // Notifier le changement de période au gestionnaire géographique
        if (this.geographicManager) {
            this.geographicManager.currentPeriod = period;
            this.geographicManager.dataCache.delete(`geographic-${period}`);
            
            // Créer un événement personnalisé
            const event = new CustomEvent('periodChanged', { detail: { period } });
            document.dispatchEvent(event);
        }
        
        await this.loadAllData();
        this.showNotification(`Période changée: ${this.getPeriodName(period)}`, 'success');
    }

    async loadAllData() {
        if (this.isLoading) return;
        
        this.isLoading = true;
        this.showGlobalLoading(true);
        
        try {
            // Charger en parallèle
            await Promise.allSettled([
                this.loadKPIData(),
                this.loadTrafficChart(),
                this.loadSourcesData(),
                this.loadDestinationsChart(),
                this.loadGeographicData()
            ]);
        } catch (error) {
            console.error('Erreur lors du chargement des données:', error);
            this.showNotification('Erreur lors du chargement des données', 'error');
        } finally {
            this.isLoading = false;
            this.showGlobalLoading(false);
        }
    }

    async loadKPIData(forceRefresh = false) {
        const cacheKey = `kpis-${this.currentPeriod}`;
        
        // Vérifier le cache
        if (!forceRefresh && this.dataCache.has(cacheKey)) {
            const data = this.dataCache.get(cacheKey);
            this.updateKPICards(data.kpis, data.comparison_text);
            return;
        }
        
        try {
            // Afficher le chargement
            this.showKPIloading(true);
            
            const response = await fetch(`/api/dashboard/kpis?period=${this.currentPeriod}`);
            
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const data = await response.json();
            
            // Mettre en cache
            this.dataCache.set(cacheKey, data);
            
            // Mettre à jour l'interface
            this.updateKPICards(data.kpis, data.comparison_text);
            
        } catch (error) {
            console.error('Erreur KPI:', error);
            this.showKPIError();
            throw error;
        } finally {
            this.showKPIloading(false);
        }
    }

    updateKPICards(kpis, comparisonText) {
        const formatNumber = (num) => {
            if (num >= 1000000) return (num / 1000000).toFixed(1) + 'M';
            if (num >= 1000) return (num / 1000).toFixed(1) + 'k';
            return new Intl.NumberFormat('fr-FR').format(num);
        };

        const kpiCards = document.querySelectorAll('.kpi-card');
        
        if (!kpiCards.length) return;

        // Calcul des pourcentages pour les barres de progression
        const maxUniqueVisitors = Math.max(kpis.unique_visitors.value, 1);
        const maxSessions = Math.max(kpis.total_sessions.value, 1);
        const maxDuration = Math.max(kpis.avg_session_duration.raw_value || 600, 1); // 10 minutes max
        const maxBounceRate = 100; // Pourcentage

        // Carte 1: Visiteurs Uniques
        this.updateKPICard(kpiCards[0], {
            value: formatNumber(kpis.unique_visitors.value),
            trend: kpis.unique_visitors.trend,
            direction: kpis.unique_visitors.trend_direction,
            progress: Math.min((kpis.unique_visitors.value / maxUniqueVisitors) * 100, 100),
            comparison: comparisonText || 'vs période précédente'
        });

        // Carte 2: Sessions Totales
        this.updateKPICard(kpiCards[1], {
            value: formatNumber(kpis.total_sessions.value),
            trend: kpis.total_sessions.trend,
            direction: kpis.total_sessions.trend_direction,
            progress: Math.min((kpis.total_sessions.value / maxSessions) * 100, 100),
            comparison: comparisonText || 'vs période précédente'
        });

        // Carte 3: Durée Moyenne Session
        const durationValue = kpis.avg_session_duration.raw_value || 0;
        this.updateKPICard(kpiCards[2], {
            value: kpis.avg_session_duration.value,
            trend: kpis.avg_session_duration.trend,
            direction: kpis.avg_session_duration.trend_direction,
            progress: Math.min((durationValue / maxDuration) * 100, 100),
            comparison: comparisonText || 'vs période précédente'
        });

        // Carte 4: Taux de Rebond
        this.updateKPICard(kpiCards[3], {
            value: `${kpis.bounce_rate.value}%`,
            trend: kpis.bounce_rate.trend,
            direction: kpis.bounce_rate.trend_direction,
            progress: Math.min(kpis.bounce_rate.value, 100),
            isBounce: true,
            comparison: comparisonText || 'vs période précédente'
        });

        // Carte 5: Nouveaux Visiteurs
        this.updateKPICard(kpiCards[4], {
            value: formatNumber(kpis.new_visitors.value),
            trend: kpis.new_visitors.trend,
            direction: kpis.new_visitors.trend_direction,
            progress: kpis.new_visitors.percentage,
            comparison: `${kpis.new_visitors.percentage}% du total`
        });

        // Carte 6: Visiteurs Récurrents
        this.updateKPICard(kpiCards[5], {
            value: formatNumber(kpis.returning_visitors.value),
            trend: kpis.returning_visitors.trend,
            direction: kpis.returning_visitors.trend_direction,
            progress: kpis.returning_visitors.percentage,
            comparison: `${kpis.returning_visitors.percentage}% du total`
        });
    }

    updateKPICard(card, data) {
        // Valeur principale
        const valueEl = card.querySelector('.kpi-value');
        if (valueEl) {
            valueEl.textContent = data.value;
            valueEl.classList.remove('loading', 'error');
        }

        // Tendance
        const trendEl = card.querySelector('.kpi-trend');
        if (trendEl) {
            trendEl.className = `kpi-trend trend-${data.direction}`;
            const arrowIcon = data.direction === 'up' ? 'fa-arrow-up' : 
                            data.direction === 'down' ? 'fa-arrow-down' : 'fa-minus';
            
            trendEl.innerHTML = `
                <div class="trend-content">
                    <i class="fas ${arrowIcon}"></i>
                    <span>${data.trend >= 0 ? '+' : ''}${data.trend}%</span>
                    <span class="comparison">${data.comparison}</span>
                </div>
            `;
            
            // Pour le taux de rebond, inverser la couleur
            if (data.isBounce) {
                trendEl.classList.add('bounce-rate');
            }
        }

        // Barre de progression
        const progressFill = card.querySelector('.progress-fill');
        if (progressFill) {
            progressFill.style.width = `${data.progress}%`;
            progressFill.style.transition = 'width 0.8s ease';
        }
    }

    async loadTrafficChart(forceRefresh = false) {
        const cacheKey = `traffic-${this.currentPeriod}`;
        
        // Vérifier le cache
        if (!forceRefresh && this.dataCache.has(cacheKey)) {
            this.renderTrafficChart(this.dataCache.get(cacheKey));
            return;
        }
        
        const canvas = document.getElementById('trafficChart');
        if (!canvas) return;
        
        const container = canvas.closest('.chart-container');
        const loadingEl = container?.querySelector('.chart-loading');
        
        if (loadingEl) loadingEl.style.display = 'flex';
        
        try {
            const response = await fetch(`/api/dashboard/traffic-chart?period=${this.currentPeriod}`);
            
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const data = await response.json();
            
            // Mettre en cache
            this.dataCache.set(cacheKey, data);
            
            // Rendre le graphique
            this.renderTrafficChart(data);
            
        } catch (error) {
            console.error('Erreur graphique trafic:', error);
            this.showChartError(canvas, 'Erreur de chargement du graphique');
        } finally {
            if (loadingEl) loadingEl.style.display = 'none';
        }
    }

    renderTrafficChart(data) {
        const canvas = document.getElementById('trafficChart');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        
        // Détruire le graphique existant
        if (this.charts.traffic) {
            this.charts.traffic.destroy();
        }
        
        // Mettre à jour le titre selon la période
        const titleMap = {
            'today': 'Évolution du Trafic - Aujourd\'hui',
            'week': 'Évolution du Trafic - Cette Semaine',
            'month': 'Évolution du Trafic - Ce Mois',
            'quarter': 'Évolution du Trafic - Ce Trimestre',
            'year': 'Évolution du Trafic - Cette Année'
        };
        
        const chartTitle = document.querySelector('.full-width-chart .chart-title');
        if (chartTitle) {
            chartTitle.textContent = titleMap[this.currentPeriod] || 'Évolution du Trafic';
        }
        
        this.charts.traffic = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels || [],
                datasets: [
                    {
                        label: 'Visiteurs uniques',
                        data: data.unique_visitors_data || [],
                        borderColor: '#FF6B35',
                        backgroundColor: 'rgba(255, 107, 53, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointBackgroundColor: '#FF6B35',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Sessions',
                        data: data.total_sessions_data || [],
                        borderColor: '#004E89',
                        backgroundColor: 'rgba(0, 78, 137, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointBackgroundColor: '#004E89',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        cornerRadius: 8,
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: (context) => {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += new Intl.NumberFormat('fr-FR').format(context.parsed.y);
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000) {
                                    return (value / 1000).toFixed(0) + 'k';
                                }
                                return value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                animation: {
                    duration: 750,
                    easing: 'easeOutQuart'
                }
            }
        });
    }

    async loadSourcesData(forceRefresh = false) {
        const cacheKey = `sources-${this.currentPeriod}`;
        
        // Vérifier le cache
        if (!forceRefresh && this.dataCache.has(cacheKey)) {
            const data = this.dataCache.get(cacheKey);
            this.renderSourceChart(data);
            this.renderCanalDistribution(data);
            return;
        }
        
        try {
            // Afficher les états de chargement
            this.showSourceLoading(true);
            
            const response = await fetch(`/api/dashboard/sources?period=${this.currentPeriod}`);
            
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const data = await response.json();
            
            // Mettre en cache
            this.dataCache.set(cacheKey, data);
            
            // Rendre les graphiques
            this.renderSourceChart(data);
            this.renderCanalDistribution(data);
            
        } catch (error) {
            console.error('Erreur sources:', error);
            this.showSourceError();
        } finally {
            this.showSourceLoading(false);
        }
    }

    renderSourceChart(data) {
        const canvas = document.getElementById('sourceChart');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        
        // Détruire le graphique existant
        if (this.charts.source) {
            this.charts.source.destroy();
        }
        
        const sources = data.sources || [];
        const total = sources.reduce((sum, source) => sum + (source.count || 0), 0);
        
        // Mettre à jour le titre
        const titleMap = {
            'today': 'Sources du Trafic - Aujourd\'hui',
            'week': 'Sources du Trafic - Cette Semaine',
            'month': 'Sources du Trafic - Ce Mois',
            'quarter': 'Sources du Trafic - Ce Trimestre',
            'year': 'Sources du Trafic - Cette Année'
        };
        
        const chartTitle = canvas.closest('.chart-card').querySelector('.chart-title');
        if (chartTitle) {
            chartTitle.textContent = titleMap[this.currentPeriod] || 'Sources de Trafic';
        }
        
        this.charts.source = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: sources.map(s => s.source),
                datasets: [{
                    data: sources.map(s => s.percentage),
                    backgroundColor: this.getSourceColors(sources.length),
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 15
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
                                size: 12,
                                weight: '600'
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: (context) => {
                                const source = sources[context.dataIndex];
                                return [
                                    `${source.source}: ${source.percentage}%`,
                                    `Visites: ${new Intl.NumberFormat('fr-FR').format(source.count || 0)}`,
                                    `Total: ${new Intl.NumberFormat('fr-FR').format(total)}`
                                ];
                            }
                        }
                    }
                },
                cutout: '65%',
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });
    }

    renderCanalDistribution(data) {
        const container = document.getElementById('canalData');
        if (!container) return;
        
        const sources = data.sources || [];
        const total = sources.reduce((sum, source) => sum + (source.count || 0), 0);
        
        // Trier par pourcentage décroissant
        const sortedSources = [...sources].sort((a, b) => b.percentage - a.percentage);
        
        // Générer le HTML
        let html = '';
        
        sortedSources.forEach((source, index) => {
            if (index < 5) { // Limiter à 5 canaux principaux
                const color = this.getSourceColor(index);
                const icon = this.getSourceIcon(source.source);
                
                html += `
                    <div style="margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="font-weight: 600;">
                                <i class="fas ${icon}" style="color: ${color}; margin-right: 0.5rem;"></i>
                                ${source.source}
                            </span>
                            <span style="font-weight: 700; color: ${color};">${source.percentage}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: ${source.percentage}%; background: ${color};"></div>
                        </div>
                        <div style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.25rem;">
                            ${new Intl.NumberFormat('fr-FR').format(source.count || 0)} visites
                        </div>
                    </div>
                `;
            }
        });
        
        // Ajouter le résumé avec la période
        const periodName = this.getPeriodName(this.currentPeriod);
        html += `
            <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: var(--text-secondary);">
                        <i class="fas fa-chart-pie" style="margin-right: 0.5rem;"></i>
                        Total des visites (${periodName.toLowerCase()})
                    </span>
                    <span style="font-weight: 700;">${new Intl.NumberFormat('fr-FR').format(total)}</span>
                </div>
                <div style="font-size: 0.9rem; color: var(--text-secondary);">
                    ${sortedSources.length} sources de trafic
                </div>
            </div>
        `;
        
        container.innerHTML = html;
    }

    async loadDestinationsChart(forceRefresh = false) {
        const cacheKey = `cities-${this.currentPeriod}`;
        
        // Vérifier le cache
        if (!forceRefresh && this.dataCache.has(cacheKey)) {
            this.renderDestinationsChart(this.dataCache.get(cacheKey));
            return;
        }
        
        try {
            const canvas = document.getElementById('destinationsChart');
            if (!canvas) return;
            
            const container = canvas.closest('.chart-container');
            const loadingEl = container?.querySelector('.chart-loading');
            
            if (loadingEl) loadingEl.style.display = 'flex';
            
            const response = await fetch(`/api/dashboard/top-cities?period=${this.currentPeriod}`);
            
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const data = await response.json();
            
            // Mettre en cache
            this.dataCache.set(cacheKey, data);
            
            // Rendre le graphique
            this.renderDestinationsChart(data);
            
        } catch (error) {
            console.error('Erreur destinations:', error);
        } finally {
            const loadingEl = document.querySelector('#destinationsChart')?.closest('.chart-container')?.querySelector('.chart-loading');
            if (loadingEl) loadingEl.style.display = 'none';
        }
    }

    renderDestinationsChart(data) {
        const canvas = document.getElementById('destinationsChart');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        
        // Détruire le graphique existant
        if (this.charts.destinations) {
            this.charts.destinations.destroy();
        }
        
        const cities = data.cities || [];
        const maxVisits = Math.max(...cities.map(c => c.count), 1);
        
        // Mettre à jour le titre selon la période
        const titleMap = {
            'today': 'Top Villes - Aujourd\'hui',
            'week': 'Top Villes - Cette Semaine',
            'month': 'Top Villes - Ce Mois',
            'quarter': 'Top Villes - Ce Trimestre',
            'year': 'Top Villes - Cette Année'
        };
        
        const chartTitle = canvas.closest('.chart-card')?.querySelector('.chart-title');
        if (chartTitle) {
            chartTitle.textContent = titleMap[this.currentPeriod] || 'Top Villes';
        }
        
        this.charts.destinations = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: cities.map(c => c.city),
                datasets: [{
                    label: 'Visites',
                    data: cities.map(c => c.count),
                    backgroundColor: cities.map((_, i) => 
                        `hsla(${i * 60}, 70%, 60%, 0.8)`
                    ),
                    borderRadius: 8,
                    borderWidth: 0,
                    hoverBackgroundColor: cities.map((_, i) => 
                        `hsla(${i * 60}, 70%, 50%, 1)`
                    )
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
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: (context) => {
                                const percentage = ((context.parsed.y / maxVisits) * 100).toFixed(1);
                                return [
                                    `Visites: ${new Intl.NumberFormat('fr-FR').format(context.parsed.y)}`,
                                    `Part: ${percentage}%`
                                ];
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000) {
                                    return (value / 1000).toFixed(0) + 'k';
                                }
                                return value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }
        });
    }

    async loadGeographicData(forceRefresh = false) {
        if (this.geographicManager) {
            await this.geographicManager.loadGeographicData(forceRefresh);
        }
    }

    // Méthodes d'actualisation
    async refreshTrafficChart() {
        await this.loadTrafficChart(true);
        this.showNotification('Graphique de trafic actualisé', 'success');
    }

    async refreshSourceData() {
        await this.loadSourcesData(true);
        this.showNotification('Données des sources actualisées', 'success');
    }

    async refreshGeographicData() {
        if (this.geographicManager) {
            this.geographicManager.refreshGeographicData();
        }
    }

    async refreshAllData() {
        this.dataCache.clear();
        await this.loadAllData();
        this.showNotification('Toutes les données actualisées', 'success');
    }

    // Gestion du plein écran
    toggleFullscreen(chartCard) {
        if (!chartCard) return;
        
        const isFullscreen = chartCard.classList.contains('fullscreen');
        const fullscreenBtn = chartCard.querySelector('[data-tooltip="Plein écran"]');
        
        if (!isFullscreen) {
            chartCard.classList.add('fullscreen');
            chartCard.style.position = 'fixed';
            chartCard.style.top = '0';
            chartCard.style.left = '0';
            chartCard.style.width = '100vw';
            chartCard.style.height = '100vh';
            chartCard.style.zIndex = '9999';
            chartCard.style.borderRadius = '0';
            chartCard.style.padding = '20px';
            chartCard.style.background = 'white';
            chartCard.style.overflow = 'auto';
            
            if (fullscreenBtn) {
                fullscreenBtn.innerHTML = '<i class="fas fa-compress"></i>';
                fullscreenBtn.setAttribute('data-tooltip', 'Quitter plein écran');
            }
            
            // Redessiner les graphiques
            setTimeout(() => {
                Object.values(this.charts).forEach(chart => {
                    if (chart) chart.resize();
                });
                if (this.geographicManager && this.geographicManager.map) {
                    this.geographicManager.map.invalidateSize();
                }
            }, 100);
            
            // Écouter la touche Échap
            document.addEventListener('keydown', this.handleEscapeKey);
        } else {
            chartCard.classList.remove('fullscreen');
            chartCard.style.cssText = '';
            
            if (fullscreenBtn) {
                fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
                fullscreenBtn.setAttribute('data-tooltip', 'Plein écran');
            }
            
            document.removeEventListener('keydown', this.handleEscapeKey);
            
            // Redessiner les graphiques
            setTimeout(() => {
                Object.values(this.charts).forEach(chart => {
                    if (chart) chart.resize();
                });
                if (this.geographicManager && this.geographicManager.map) {
                    this.geographicManager.map.invalidateSize();
                }
            }, 100);
        }
    }

    handleEscapeKey = (e) => {
        if (e.key === 'Escape') {
            const fullscreenCard = document.querySelector('.chart-card.fullscreen');
            if (fullscreenCard) {
                this.toggleFullscreen(fullscreenCard);
            }
        }
    }

    // Téléchargement des données
    async downloadChartData(chartCard) {
        const chartTitle = chartCard.querySelector('.chart-title')?.textContent || 'donnees';
        const canvas = chartCard.querySelector('canvas');
        
        if (canvas) {
            // Télécharger l'image
            const link = document.createElement('a');
            link.download = `${chartTitle.toLowerCase().replace(/\s+/g, '-')}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
            this.showNotification(`Graphique "${chartTitle}" téléchargé`, 'success');
        } else {
            // Pour les cartes sans canvas, essayer de télécharger les données
            try {
                let dataUrl;
                const chartId = chartCard.querySelector('canvas')?.id;
                
                switch(chartId) {
                    case 'trafficChart':
                        dataUrl = await this.exportTrafficData();
                        break;
                    case 'sourceChart':
                        dataUrl = await this.exportSourceData();
                        break;
                    default:
                        throw new Error('Données non disponibles');
                }
                
                const link = document.createElement('a');
                link.download = `${chartTitle.toLowerCase().replace(/\s+/g, '-')}.json`;
                link.href = dataUrl;
                link.click();
                this.showNotification(`Données "${chartTitle}" téléchargées`, 'success');
            } catch (error) {
                this.showNotification('Impossible de télécharger les données', 'error');
            }
        }
    }

    async exportTrafficData() {
        const response = await fetch(`/api/dashboard/traffic-chart?period=${this.currentPeriod}`);
        const data = await response.json();
        const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
        return URL.createObjectURL(blob);
    }

    async exportSourceData() {
        const response = await fetch(`/api/dashboard/sources?period=${this.currentPeriod}`);
        const data = await response.json();
        const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
        return URL.createObjectURL(blob);
    }

    // Gestion des tables
    filterTable(input) {
        const searchTerm = input.value.toLowerCase();
        const table = input.closest('.table-card').querySelector('tbody');
        const rows = table.querySelectorAll('tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    }

    handleRowClick(row) {
        // Exemple: basculer la sélection
        row.classList.toggle('selected');
        
        // Vous pouvez ajouter ici plus de logique pour les détails
        if (row.classList.contains('selected')) {
            console.log('Ligne sélectionnée:', row);
        }
    }

    // Gestion du rafraîchissement automatique
    startAutoRefresh(interval = 300000) { // 5 minutes par défaut
        this.autoRefreshInterval = setInterval(() => {
            if (document.visibilityState === 'visible') {
                this.refreshAllData();
            }
        }, interval);
    }

    pauseAutoRefresh() {
        if (this.autoRefreshInterval) {
            clearInterval(this.autoRefreshInterval);
            this.autoRefreshInterval = null;
        }
    }

    resumeAutoRefresh() {
        if (!this.autoRefreshInterval) {
            this.startAutoRefresh();
        }
    }

    handleResize() {
        // Redimensionner tous les graphiques
        Object.values(this.charts).forEach(chart => {
            if (chart) chart.resize();
        });
        
        // Redimensionner la carte si elle existe
        if (this.geographicManager && this.geographicManager.map) {
            this.geographicManager.map.invalidateSize();
        }
    }

    // Méthodes utilitaires
    getPeriodFromText(text) {
        const periodMap = {
            'Aujourd\'hui': 'today',
            'Semaine': 'week',
            'Mois': 'month',
            'Trimestre': 'quarter',
            'Année': 'year'
        };
        return periodMap[text.trim()] || 'month';
    }

    getPeriodName(periodKey) {
        const periods = {
            'today': "Aujourd'hui",
            'week': 'Semaine',
            'month': 'Mois',
            'quarter': 'Trimestre',
            'year': 'Année'
        };
        return periods[periodKey] || 'Mois';
    }

    getSourceColors(count) {
        const baseColors = [
            '#FF6B35', // Organique
            '#004E89', // Direct
            '#06D6A0', // Réseaux sociaux
            '#FFB627', // Payant
            '#667eea',  // Email
            '#764ba2',  // Référence
            '#FF4081',  // Autre 1
            '#9C27B0',  // Autre 2
            '#3F51B5',  // Autre 3
            '#009688'   // Autre 4
        ];
        
        // Si on a besoin de plus de couleurs, on génère des variations
        if (count <= baseColors.length) {
            return baseColors.slice(0, count);
        }
        
        // Générer des couleurs supplémentaires
        const colors = [...baseColors];
        for (let i = baseColors.length; i < count; i++) {
            const hue = (i * 137.508) % 360; // Utiliser l'angle d'or
            colors.push(`hsl(${hue}, 70%, 60%)`);
        }
        
        return colors;
    }

    getSourceColor(index) {
        const colors = this.getSourceColors(10);
        return colors[index % colors.length];
    }

    getSourceIcon(sourceName) {
        const iconMap = {
            'Organique': 'fa-search',
            'SEO': 'fa-search',
            'Direct': 'fa-link',
            'Réseaux Sociaux': 'fa-share-alt',
            'Social': 'fa-share-alt',
            'Payant (CPC)': 'fa-ad',
            'Ads': 'fa-ad',
            'Email': 'fa-envelope',
            'Referral': 'fa-external-link-alt',
            'Autre': 'fa-circle'
        };
        
        return iconMap[sourceName] || 'fa-circle';
    }

    // Méthodes d'affichage d'état
    showGlobalLoading(show) {
        const overlay = document.getElementById('globalLoading');
        if (overlay) {
            overlay.style.display = show ? 'flex' : 'none';
        }
        
        // Désactiver les boutons pendant le chargement
        document.querySelectorAll('.period-btn, .chart-btn').forEach(btn => {
            btn.disabled = show;
        });
    }

    showKPIloading(show) {
        const kpiValues = document.querySelectorAll('.kpi-value');
        kpiValues.forEach(el => {
            if (show) {
                el.classList.add('loading');
                el.textContent = 'Chargement...';
            } else {
                el.classList.remove('loading');
            }
        });
    }

    showKPIError() {
        const kpiValues = document.querySelectorAll('.kpi-value');
        kpiValues.forEach(el => {
            el.classList.remove('loading');
            el.classList.add('error');
            el.textContent = 'Erreur';
        });
    }

    showSourceLoading(show) {
        const sourceLoading = document.querySelector('#sourceChart')?.closest('.chart-container')?.querySelector('.chart-loading');
        const canalData = document.getElementById('canalData');
        
        if (sourceLoading) {
            sourceLoading.style.display = show ? 'flex' : 'none';
        }
        
        if (canalData && show) {
            canalData.innerHTML = `
                <div class="loading-placeholder">
                    <div class="spinner small" style="margin: 0 auto 1rem;"></div>
                    <p style="text-align: center; color: var(--text-secondary);">Chargement des données...</p>
                </div>
            `;
        }
    }

    showSourceError() {
        const canalData = document.getElementById('canalData');
        if (canalData) {
            canalData.innerHTML = `
                <div style="text-align: center; padding: 2rem; color: var(--warning);">
                    <i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                    <p>Erreur lors du chargement des données</p>
                    <button onclick="dashboard.refreshSourceData()" style="margin-top: 1rem; padding: 0.5rem 1rem; background: var(--primary); color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Réessayer
                    </button>
                </div>
            `;
        }
    }

    showChartError(canvas, message) {
        const ctx = canvas.getContext('2d');
        const width = canvas.width;
        const height = canvas.height;
        
        ctx.clearRect(0, 0, width, height);
        ctx.fillStyle = '#f8f9fa';
        ctx.fillRect(0, 0, width, height);
        
        ctx.fillStyle = '#6c757d';
        ctx.font = '16px Arial';
        ctx.textAlign = 'center';
        ctx.fillText(message, width / 2, height / 2);
    }

    showNotification(message, type = 'info') {
        // Créer le conteneur s'il n'existe pas
        let container = document.getElementById('notificationContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'notificationContainer';
            container.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 99999;
            `;
            document.body.appendChild(container);
        }
        
        // Créer la notification
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas ${icons[type] || icons.info}"></i>
                <span>${message}</span>
                <button class="notification-close">&times;</button>
            </div>
        `;
        
        container.appendChild(notification);
        
        // Animation d'entrée
        requestAnimationFrame(() => {
            notification.classList.add('show');
        });
        
        // Fermer la notification
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        });
        
        // Auto-suppression
        setTimeout(() => {
            if (notification.parentNode) {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }
        }, 5000);
    }

    // Méthodes de débogage
    logPerformance() {
        console.log('Performance du Dashboard:');
        console.log(`- Cache size: ${this.dataCache.size}`);
        console.log(`- Charts loaded: ${Object.values(this.charts).filter(c => c).length}`);
        console.log(`- Current period: ${this.currentPeriod}`);
        console.log(`- Is loading: ${this.isLoading}`);
    }

    // Nettoyage
    destroy() {
        this.pauseAutoRefresh();
        
        // Détruire tous les graphiques
        Object.values(this.charts).forEach(chart => {
            if (chart) chart.destroy();
        });
        
        // Détruire le gestionnaire géographique
        if (this.geographicManager) {
            this.geographicManager.destroy();
            this.geographicManager = null;
        }
        
        // Nettoyer les écouteurs d'événements
        document.removeEventListener('keydown', this.handleEscapeKey);
        
        // Vider le cache
        this.dataCache.clear();
    }
}

class GeographicManager {
    constructor(dashboard) {
        this.dashboard = dashboard;
        this.map = null;
        this.markersLayer = null;
        this.heatLayer = null;
        this.legend = null;
        this.currentPeriod = 'month';
        this.dataCache = new Map();
        this.isLoading = false;
        this.initialize();
    }

    initialize() {
        this.setupEventListeners();
        this.initMap();
        this.loadGeographicData();
    }

    setupEventListeners() {
        // Synchroniser avec la période du dashboard
        document.addEventListener('periodChanged', (e) => {
            this.currentPeriod = e.detail.period;
            this.loadGeographicData();
        });
    }

    initMap() {
        // Initialiser la carte Leaflet
        this.map = L.map('visitorMap').setView([8, -5], 4); // Centre sur l'Afrique
        
        // Ajouter le fond de carte OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributeurs',
            maxZoom: 18,
            minZoom: 2
        }).addTo(this.map);
        
        // Créer les couches
        this.markersLayer = L.layerGroup().addTo(this.map);
        this.heatLayer = L.layerGroup().addTo(this.map);
        
        // Ajouter les contrôles
        L.control.scale({ imperial: false }).addTo(this.map);
        
        // Créer la légende
        this.createLegend();
        
        // Gérer le redimensionnement
        window.addEventListener('resize', () => {
            setTimeout(() => this.map.invalidateSize(), 100);
        });
    }

    createLegend() {
        this.legend = L.control({ position: 'bottomright' });
        
        this.legend.onAdd = () => {
            const div = L.DomUtil.create('div', 'leaflet-control leaflet-control-legend');
            div.innerHTML = `
                <div class="legend-title">Intensité des visites</div>
                <div class="legend-scale">
                    <div class="legend-color" style="background: #34bf49;"></div>
                    <span class="legend-label">Faible</span>
                </div>
                <div class="legend-scale">
                    <div class="legend-color" style="background: #ffd700;"></div>
                    <span class="legend-label">Moyenne</span>
                </div>
                <div class="legend-scale">
                    <div class="legend-color" style="background: #ff6b35;"></div>
                    <span class="legend-label">Forte</span>
                </div>
            `;
            
            // Empêcher les événements de la carte
            L.DomEvent.disableClickPropagation(div);
            L.DomEvent.disableScrollPropagation(div);
            
            return div;
        };
        
        this.legend.addTo(this.map);
    }

    toggleLegend() {
        const legend = document.querySelector('.leaflet-control-legend');
        if (legend) {
            legend.style.display = legend.style.display === 'none' ? 'block' : 'none';
        }
    }

    async loadGeographicData(forceRefresh = false) {
        if (this.isLoading) return;
        
        const cacheKey = `geographic-${this.currentPeriod}`;
        
        // Vérifier le cache
        if (!forceRefresh && this.dataCache.has(cacheKey)) {
            const data = this.dataCache.get(cacheKey);
            this.renderGeographicData(data);
            return;
        }
        
        this.isLoading = true;
        this.showLoading(true);
        
        try {
            const response = await fetch(`/api/dashboard/geographic?period=${this.currentPeriod}`);
            
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const data = await response.json();
            
            // Mettre en cache
            this.dataCache.set(cacheKey, data);
            
            // Rendre les données
            this.renderGeographicData(data);
            
        } catch (error) {
            console.error('Erreur données géographiques:', error);
            this.showError();
            this.dashboard.showNotification('Erreur lors du chargement des données géographiques', 'error');
        } finally {
            this.isLoading = false;
            this.showLoading(false);
        }
    }

    refreshGeographicData() {
        this.dataCache.delete(`geographic-${this.currentPeriod}`);
        this.loadGeographicData(true);
        this.dashboard.showNotification('Données géographiques actualisées', 'success');
    }

    renderGeographicData(data) {
        // Mettre à jour les titres
        this.updateTitles(data.period);
        
        // Rendre la carte
        this.renderMap(data);
        
        // Rendre la liste des pays
        this.renderCountriesList(data);
        
        // Rendre la répartition par continent
        this.renderContinentsList(data);
        
        // Mettre à jour les statistiques globales
        this.updateGlobalStats(data);
    }

    updateTitles(period) {
        const periodNames = {
            'today': "Aujourd'hui",
            'week': 'Cette Semaine',
            'month': 'Ce Mois',
            'quarter': 'Ce Trimestre',
            'year': 'Cette Année'
        };
        
        const periodName = periodNames[period] || period;
        
        // Titre de la carte
        const mapTitle = document.getElementById('mapTitle');
        if (mapTitle) {
            mapTitle.textContent = `Origine Géographique - ${periodName}`;
        }
        
        // Titre des pays
        const countryTitle = document.getElementById('countryTitle');
        if (countryTitle) {
            countryTitle.textContent = `Top 10 Pays - ${periodName}`;
        }
    }

    renderMap(data) {
        // Nettoyer les anciennes données
        this.markersLayer.clearLayers();
        this.heatLayer.clearLayers();
        
        const cities = data.cities || [];
        if (cities.length === 0) return;
        
        // Calculer les valeurs max/min pour l'échelle
        const maxVisits = Math.max(...cities.map(c => c.count), 1);
        const minVisits = Math.min(...cities.map(c => c.count), 1);
        
        // Points de chaleur pour les données de densité
        const heatPoints = [];
        
        // Ajouter les marqueurs pour chaque ville
        cities.forEach((city, index) => {
            if (!city.latitude || !city.longitude) return;
            
            // Calculer la taille et la couleur basée sur le nombre de visites
            const normalizedValue = (city.count - minVisits) / (maxVisits - minVisits);
            const radius = 8 + (normalizedValue * 20); // Entre 8 et 28 pixels
            const color = this.getHeatColor(normalizedValue);
            
            // Ajouter au heatmap
            heatPoints.push([city.latitude, city.longitude, city.count]);
            
            // Créer le marqueur circulaire
            const marker = L.circleMarker([city.latitude, city.longitude], {
                radius: radius,
                fillColor: color,
                color: '#fff',
                weight: 2,
                opacity: 0.8,
                fillOpacity: 0.7
            }).addTo(this.markersLayer);
            
            // Info-bulle détaillée
            const popupContent = `
                <div class="map-popup">
                    <div class="popup-header">
                        <span class="popup-city">${city.city}</span>
                        <span class="popup-country">${city.country}</span>
                    </div>
                    <div class="popup-stats">
                        <div class="popup-stat">
                            <span class="popup-label">Visites</span>
                            <span class="popup-value">${city.count.toLocaleString('fr-FR')}</span>
                        </div>
                        <div class="popup-stat">
                            <span class="popup-label">Part mondiale</span>
                            <span class="popup-value">${city.percentage}%</span>
                        </div>
                    </div>
                    <div class="popup-coords">
                        ${city.latitude.toFixed(4)}°, ${city.longitude.toFixed(4)}°
                    </div>
                </div>
            `;
            
            marker.bindPopup(popupContent);
            
            // Effets au survol
            marker.on('mouseover', function(e) {
                this.openPopup();
                this.setStyle({
                    fillOpacity: 0.9,
                    weight: 3
                });
            });
            
            marker.on('mouseout', function(e) {
                this.closePopup();
                this.setStyle({
                    fillOpacity: 0.7,
                    weight: 2
                });
            });
        });
        
        // Ajuster la vue de la carte
        if (cities.length > 0) {
            const bounds = L.latLngBounds(cities.map(city => [city.latitude, city.longitude]));
            this.map.fitBounds(bounds.pad(0.1));
        }
    }

    getHeatColor(intensity) {
        // Dégradé de couleur du vert au rouge
        const colors = [
            [52, 191, 73],    // Vert clair
            [154, 205, 50],   // Vert jaune
            [255, 215, 0],    // Jaune
            [255, 165, 0],    // Orange
            [255, 107, 53],   // Orange rouge
            [220, 20, 60]     // Rouge
        ];
        
        const index = Math.floor(intensity * (colors.length - 1));
        const color1 = colors[index];
        const color2 = colors[Math.min(index + 1, colors.length - 1)];
        const ratio = (intensity * (colors.length - 1)) - index;
        
        const r = Math.round(color1[0] + (color2[0] - color1[0]) * ratio);
        const g = Math.round(color1[1] + (color2[1] - color1[1]) * ratio);
        const b = Math.round(color1[2] + (color2[2] - color1[2]) * ratio);
        
        return `rgb(${r}, ${g}, ${b})`;
    }

    renderCountriesList(data) {
        const container = document.getElementById('countryList');
        if (!container) return;
        
        const countries = data.countries || [];
        const totalVisits = data.statistics.total_visits || 1;
        
        let html = '';
        
        countries.forEach((country, index) => {
            const rankClass = index < 3 ? 'top-3' : '';
            const percentage = country.percentage || ((country.count / totalVisits) * 100).toFixed(1);
            
            html += `
                <div class="country-item">
                    <div class="country-info">
                        <span class="country-rank ${rankClass}">${index + 1}</span>
                        <span class="country-flag">${country.flag}</span>
                        <span class="country-name">${country.country}</span>
                    </div>
                    <div class="country-stats">
                        <span class="country-count">${country.count.toLocaleString('fr-FR')}</span>
                        <span class="country-percentage">${percentage}% mondial</span>
                    </div>
                </div>
            `;
        });
        
        // Ajouter un résumé si des données
        if (countries.length > 0) {
            const topCountriesPercentage = data.statistics.global_distribution.top_10_countries_percentage || 0;
            
            html += `
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span style="color: var(--text-secondary); font-size: 0.9rem;">
                            <i class="fas fa-chart-bar" style="margin-right: 0.5rem;"></i>
                            Couverture mondiale
                        </span>
                        <span style="font-weight: 700; font-size: 0.9rem;">${topCountriesPercentage}%</span>
                    </div>
                    <div style="font-size: 0.8rem; color: var(--text-secondary);">
                        ${countries.length} pays / ${data.statistics.global_distribution.countries_count || 0} au total
                    </div>
                </div>
            `;
        } else {
            html = `
                <div class="empty-state">
                    <div style="text-align: center; padding: 2rem;">
                        <i class="fas fa-globe" style="font-size: 2rem; color: var(--text-secondary); margin-bottom: 1rem;"></i>
                        <p style="color: var(--text-secondary);">Aucune donnée géographique disponible</p>
                    </div>
                </div>
            `;
        }
        
        container.innerHTML = html;
    }

    renderContinentsList(data) {
        const container = document.getElementById('continentsList');
        if (!container) return;
        
        const continents = data.continents || {};
        const totalVisits = data.statistics.total_visits || 1;
        
        let html = '';
        
        // Trier les continents par pourcentage décroissant
        const sortedContinents = Object.entries(continents)
            .map(([key, continent]) => ({ key, ...continent }))
            .sort((a, b) => b.percentage - a.percentage);
        
        sortedContinents.forEach(continent => {
            const iconClass = continent.icon || 'fa-globe';
            
            html += `
                <div class="continent-item">
                    <div class="continent-info">
                        <div class="continent-icon" style="background: ${continent.color || '#999'}">
                            <i class="fas ${iconClass}"></i>
                        </div>
                        <span class="continent-name">${continent.name}</span>
                    </div>
                    <div class="continent-stats">
                        <span class="continent-percentage" style="color: ${continent.color || '#999'}">
                            ${continent.percentage}%
                        </span>
                        <span class="continent-visits">
                            ${continent.visits.toLocaleString('fr-FR')} visites
                        </span>
                    </div>
                </div>
            `;
        });
        
        // Ajouter une barre de progression totale
        if (sortedContinents.length > 0) {
            const totalPercentage = sortedContinents.reduce((sum, c) => sum + c.percentage, 0);
            
            html += `
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                    <div class="progress-bar" style="height: 6px; margin-bottom: 0.5rem;">
                        ${sortedContinents.map(continent => `
                            <div class="progress-fill" 
                                 style="width: ${continent.percentage}%; background: ${continent.color}; 
                                        display: inline-block; height: 100%;">
                            </div>
                        `).join('')}
                    </div>
                    <div style="font-size: 0.8rem; color: var(--text-secondary); text-align: center;">
                        Total couvert: ${totalPercentage.toFixed(1)}%
                    </div>
                </div>
            `;
        }
        
        container.innerHTML = html;
    }

    updateGlobalStats(data) {
        const overlay = document.getElementById('globalStatsOverlay');
        if (!overlay) return;
        
        const topCountry = data.statistics.global_distribution.top_country;
        const africaPercentage = data.continents?.africa?.percentage || 0;
        const topCountriesPercentage = data.statistics.global_distribution.top_10_countries_percentage || 0;
        
        overlay.innerHTML = `
            <div class="global-stats">
                <div class="global-stat-item">
                    <div class="global-stat-label">
                        <i class="fas fa-globe"></i>
                        Couverture
                    </div>
                    <div class="global-stat-value">${topCountriesPercentage}%</div>
                </div>
                ${topCountry ? `
                <div class="global-stat-item">
                    <div class="global-stat-label">
                        ${topCountry.flag} ${topCountry.name}
                    </div>
                    <div class="global-stat-value">${topCountry.percentage}%</div>
                </div>
                ` : ''}
                <div class="global-stat-item">
                    <div class="global-stat-label">
                        <i class="fas fa-globe-africa"></i>
                        Afrique
                    </div>
                    <div class="global-stat-value">${africaPercentage}%</div>
                </div>
                <div class="global-stat-item">
                    <div class="global-stat-label">
                        <i class="fas fa-users"></i>
                        Total
                    </div>
                    <div class="global-stat-value">${data.statistics.total_visits.toLocaleString('fr-FR')}</div>
                </div>
            </div>
        `;
    }

    showLoading(show) {
        const mapLoading = document.querySelector('.map-loading');
        const countryList = document.getElementById('countryList');
        const continentsList = document.getElementById('continentsList');
        
        if (mapLoading) {
            mapLoading.style.display = show ? 'flex' : 'none';
        }
        
        if (countryList && show) {
            countryList.innerHTML = `
                <div class="loading-placeholder">
                    <div class="spinner small" style="margin: 0 auto 1rem;"></div>
                    <p style="text-align: center; color: var(--text-secondary);">Chargement des données...</p>
                </div>
            `;
        }
        
        if (continentsList && show) {
            continentsList.innerHTML = `
                <div class="loading-placeholder">
                    <div class="spinner small" style="margin: 0 auto 0.5rem;"></div>
                    <p style="text-align: center; color: var(--text-secondary); font-size: 0.9rem;">Chargement...</p>
                </div>
            `;
        }
    }

    showError() {
        const countryList = document.getElementById('countryList');
        const continentsList = document.getElementById('continentsList');
        const mapContainer = document.getElementById('visitorMap');
        
        if (countryList) {
            countryList.innerHTML = `
                <div style="text-align: center; padding: 2rem; color: var(--warning);">
                    <i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                    <p>Erreur lors du chargement des données</p>
                    <button onclick="geographicManager.refreshGeographicData()" style="margin-top: 1rem; padding: 0.5rem 1rem; background: var(--primary); color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Réessayer
                    </button>
                </div>
            `;
        }
        
        if (continentsList) {
            continentsList.innerHTML = `
                <div style="text-align: center; padding: 1rem; color: var(--warning);">
                    <i class="fas fa-exclamation-circle" style="margin-right: 0.5rem;"></i>
                    Données indisponibles
                </div>
            `;
        }
        
        if (mapContainer) {
            mapContainer.innerHTML = `
                <div style="height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 2rem; color: var(--warning);">
                    <i class="fas fa-exclamation-triangle" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                    <p>Erreur lors du chargement de la carte</p>
                    <button onclick="geographicManager.refreshGeographicData()" style="margin-top: 1rem; padding: 0.5rem 1rem; background: var(--primary); color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Réessayer
                    </button>
                </div>
            `;
        }
        
        // Nettoyer l'overlay
        const overlay = document.getElementById('globalStatsOverlay');
        if (overlay) {
            overlay.innerHTML = `
                <div class="global-stats">
                    <div class="global-stat-item">
                        <div class="global-stat-label">❌ Erreur</div>
                        <div class="global-stat-value">--</div>
                    </div>
                </div>
            `;
        }
    }

    // Méthodes utilitaires
    formatNumber(num) {
        if (num >= 1000000) return (num / 1000000).toFixed(1) + 'M';
        if (num >= 1000) return (num / 1000).toFixed(1) + 'k';
        return new Intl.NumberFormat('fr-FR').format(num);
    }

    destroy() {
        if (this.map) {
            this.map.remove();
            this.map = null;
        }
        
        this.markersLayer = null;
        this.heatLayer = null;
        this.legend = null;
        
        // Nettoyer les écouteurs d'événements
        document.removeEventListener('periodChanged', () => {});
    }
}

// Initialisation globale
document.addEventListener('DOMContentLoaded', () => {
    window.dashboard = new DashboardManager();
    
    // Exposer globalement pour le débogage
    window.dashboard = dashboard;
    
    // Initialiser les tooltips
    initTooltips();
});

// Fonction pour initialiser les tooltips
function initTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    
    tooltipElements.forEach(element => {
        let tooltip = null;
        let hideTimeout = null;
        
        element.addEventListener('mouseenter', (e) => {
            if (hideTimeout) {
                clearTimeout(hideTimeout);
                hideTimeout = null;
            }
            
            tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip';
            tooltip.textContent = e.currentTarget.getAttribute('data-tooltip');
            
            document.body.appendChild(tooltip);
            
            const rect = e.currentTarget.getBoundingClientRect();
            const tooltipRect = tooltip.getBoundingClientRect();
            
            let top = rect.top - tooltipRect.height - 10;
            let left = rect.left + (rect.width / 2) - (tooltipRect.width / 2);
            
            // Ajuster si le tooltip dépasse de l'écran
            if (top < 10) top = rect.bottom + 10;
            if (left < 10) left = 10;
            if (left + tooltipRect.width > window.innerWidth - 10) {
                left = window.innerWidth - tooltipRect.width - 10;
            }
            
            tooltip.style.top = `${top}px`;
            tooltip.style.left = `${left}px`;
            
            tooltip.classList.add('show');
        });
        
        element.addEventListener('mouseleave', () => {
            if (tooltip) {
                tooltip.classList.remove('show');
                hideTimeout = setTimeout(() => {
                    if (tooltip && tooltip.parentNode) {
                        tooltip.remove();
                        tooltip = null;
                    }
                }, 300);
            }
        });
    });
}

// Styles CSS dynamiques
const combinedStyles = `
    /* États de chargement */
    .kpi-value.loading {
        color: #aaa;
        font-style: italic;
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loadingShimmer 1.5s infinite;
        border-radius: 4px;
        min-height: 2.5rem;
        display: inline-block;
        min-width: 100px;
    }
    
    .kpi-value.error {
        color: #dc3545 !important;
    }
    
    @keyframes loadingShimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    
    .chart-loading {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 10;
        border-radius: inherit;
    }
    
    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid rgba(0, 0, 0, 0.1);
        border-top-color: var(--primary, #3498db);
        border-radius: 50%;
        animation: spin 1s ease-in-out infinite;
    }
    
    .spinner.small {
        width: 24px;
        height: 24px;
        border-width: 3px;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* Notifications */
    .notification {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        margin-bottom: 10px;
        transform: translateX(120%);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        overflow: hidden;
        max-width: 400px;
        border-left: 4px solid;
    }
    
    .notification.show {
        transform: translateX(0);
        opacity: 1;
    }
    
    .notification-success {
        border-left-color: #06D6A0;
    }
    
    .notification-error {
        border-left-color: #FF6B35;
    }
    
    .notification-warning {
        border-left-color: #FFB627;
    }
    
    .notification-info {
        border-left-color: #3498db;
    }
    
    .notification-content {
        display: flex;
        align-items: center;
        padding: 16px 20px;
        gap: 12px;
    }
    
    .notification-content i {
        font-size: 1.2em;
    }
    
    .notification-success .notification-content i {
        color: #06D6A0;
    }
    
    .notification-error .notification-content i {
        color: #FF6B35;
    }
    
    .notification-close {
        background: none;
        border: none;
        font-size: 1.5em;
        cursor: pointer;
        margin-left: auto;
        color: #999;
        padding: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
    }
    
    .notification-close:hover {
        color: #333;
    }
    
    /* Tooltips */
    .custom-tooltip {
        position: fixed;
        background: rgba(0, 0, 0, 0.85);
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        z-index: 99999;
        pointer-events: none;
        white-space: nowrap;
        transform: translateY(-10px);
        opacity: 0;
        transition: all 0.2s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .custom-tooltip.show {
        transform: translateY(0);
        opacity: 1;
    }
    
    .custom-tooltip:after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        border-width: 5px 5px 0;
        border-style: solid;
        border-color: rgba(0, 0, 0, 0.85) transparent transparent;
    }
    
    /* États désactivés */
    button:disabled {
        opacity: 0.5;
        cursor: not-allowed !important;
    }
    
    /* Plein écran */
    .chart-card.fullscreen {
        box-shadow: 0 0 0 100vmax rgba(0, 0, 0, 0.5);
    }
    
    /* Animation des tendances */
    .trend-content {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .trend-up {
        color: #06D6A0;
    }
    
    .trend-down {
        color: #FF6B35;
    }
    
    .kpi-trend.bounce-rate.trend-up {
        color: #FF6B35;
    }
    
    .kpi-trend.bounce-rate.trend-down {
        color: #06D6A0;
    }
    
    /* Loading overlay global */
    #globalLoading {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.95);
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 99999;
    }
    
    .loading-content {
        text-align: center;
        padding: 2rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    /* Placeholder pour les données en cours de chargement */
    .loading-placeholder {
        padding: 2rem;
        text-align: center;
        color: var(--text-secondary);
    }
    
    /* Popup de la carte */
    .map-popup {
        padding: 10px;
        min-width: 200px;
    }
    
    .popup-header {
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eee;
    }
    
    .popup-city {
        font-size: 1.1rem;
        font-weight: 700;
        color: #333;
        display: block;
    }
    
    .popup-country {
        font-size: 0.9rem;
        color: #666;
    }
    
    .popup-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 10px;
    }
    
    .popup-stat {
        display: flex;
        flex-direction: column;
    }
    
    .popup-label {
        font-size: 0.8rem;
        color: #888;
        margin-bottom: 2px;
    }
    
    .popup-value {
        font-size: 1rem;
        font-weight: 700;
        color: #333;
    }
    
    .popup-coords {
        font-size: 0.75rem;
        color: #999;
        font-style: italic;
        text-align: center;
        padding-top: 8px;
        border-top: 1px solid #eee;
    }
    
    /* Contrôles Leaflet personnalisés */
    .leaflet-control-legend {
        background: rgba(255, 255, 255, 0.95);
        padding: 12px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(5px);
    }
    
    .leaflet-control-legend .legend-title {
        font-weight: 700;
        margin-bottom: 8px;
        font-size: 0.9rem;
        color: #333;
    }
    
    .leaflet-control-legend .legend-scale {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
    }
    
    .leaflet-control-legend .legend-scale:last-child {
        margin-bottom: 0;
    }
    
    .leaflet-control-legend .legend-color {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .leaflet-control-legend .legend-label {
        font-size: 0.8rem;
        color: #666;
    }
    
    /* Animation des marqueurs */
    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 0.7;
        }
        50% {
            transform: scale(1.05);
            opacity: 0.9;
        }
        100% {
            transform: scale(1);
            opacity: 0.7;
        }
    }
    
    .leaflet-marker-pulse {
        animation: pulse 2s infinite;
    }
    
    /* Styles responsive */
    @media (max-width: 768px) {
        .notification {
            left: 20px;
            right: 20px;
            max-width: none;
        }
        
        .custom-tooltip {
            max-width: 200px;
            white-space: normal;
            text-align: center;
        }
        
        .map-overlay {
            top: 10px;
            left: 10px;
            right: 10px;
            min-width: auto;
        }
        
        .global-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }
        
        .global-stat-item {
            flex-direction: column;
            align-items: flex-start;
            padding: 5px 0;
            border-bottom: none;
        }
        
        .leaflet-control-legend {
            bottom: 40px;
            right: 10px;
            padding: 8px;
        }
        
        .popup-stats {
            grid-template-columns: 1fr;
        }
    }
    
    /* Mode plein écran */
    .chart-card.fullscreen #visitorMap {
        height: calc(100vh - 100px) !important;
    }
    
    /* Thème sombre */
    @media (prefers-color-scheme: dark) {
        .leaflet-control-legend {
            background: rgba(40, 40, 40, 0.9);
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .leaflet-control-legend .legend-title {
            color: #fff;
        }
        
        .leaflet-control-legend .legend-label {
            color: #ccc;
        }
        
        .map-overlay {
            background: rgba(40, 40, 40, 0.9);
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .map-popup {
            background: #2d2d2d;
            color: #fff;
        }
        
        .popup-city {
            color: #fff;
        }
        
        .popup-country {
            color: #ccc;
        }
        
        .popup-value {
            color: #fff;
        }
        
        .popup-label {
            color: #aaa;
        }
    }
`;

// Injecter les styles
const styleSheet = document.createElement('style');
styleSheet.textContent = combinedStyles;
document.head.appendChild(styleSheet);

// Export pour utilisation dans d'autres fichiers
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { DashboardManager, GeographicManager };
}