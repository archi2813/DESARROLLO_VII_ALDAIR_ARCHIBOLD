<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a href="dashboard.php" class="navbar-brand"><i class="bi bi-trophy-fill me-2"></i>Fantasy Fútbol</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="mainNav" class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a href="dashboard.php" class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'dashboard.php') !== false ? 'active' : '' ?>">Mercado</a></li>
        <li class="nav-item"><a href="ranking.php" class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'ranking.php') !== false ? 'active' : '' ?>">Ranking</a></li>
        <li class="nav-item"><a href="mi_equipo.php" class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'mi_equipo.php') !== false ? 'active' : '' ?>">Mi equipo</a></li>
        <li class="nav-item"><a href="logout.php" class="nav-link">Cerrar sesión</a></li>
      </ul>
    </div>
  </div>
</nav>
