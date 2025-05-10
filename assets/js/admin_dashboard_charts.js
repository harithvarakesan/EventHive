// Chart.js setup for admin dashboard
window.addEventListener('DOMContentLoaded', function() {
  if (window.Chart) {
    // Example: Events per Month
    var ctxEvents = document.getElementById('eventsPerMonthChart').getContext('2d');
    new Chart(ctxEvents, {
      type: 'bar',
      data: window.eventsPerMonthData,
      options: {
        responsive: true,
        plugins: {legend: {display: false}},
        scales: {y: {beginAtZero: true}}
      }
    });
    // Example: Participants per Event
    var ctxParticipants = document.getElementById('participantsPerEventChart').getContext('2d');
    new Chart(ctxParticipants, {
      type: 'pie',
      data: window.participantsPerEventData,
      options: {responsive: true}
    });
  }
});
