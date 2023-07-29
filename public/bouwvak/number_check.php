<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simple Form</title>
  <!-- Bootstrap 5 CSS Link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="row">
      <div class="col-12">
        <h3>Bouwvak Bakstenen Bonanza!!</h3>
        <?php if(isset($_GET['prize'])): ?>
          <?php if (empty($_GET['prize']) || $_GET['prize'] == "helaas"): ?>
            <div class="alert alert-danger" role="alert">
              Er is helaas geen prijs voor nummer <?php echo $_GET['number']; ?>
            </div>
            <div>
              <a href="/bouwvak/number_check.php">Nog een nummer checken</a>
              <a href="/bouwvak">Terug</a>
            </div>
          <?php else: ?>
            <div class="alert alert-success" role="alert">
              Gewonnen prijs: <u><?php echo $_GET['prize']; ?></u>.<br/><br/>Gefeliciteerd!
            </div>
            <div>
              <small><i>Prijs uitreiken bij prijstafel. Alleen bovenstaande prijs, niet ruilen voor iets anders!</i></small>
            </div>
            <div>
              <a href="/bouwvak/number_check.php">Nog een nummer checken</a>
              <a href="/bouwvak">Terug</a>
            </div>
          <?php endif ?>
        <?php else: ?>
          <form action="check.php" method="post">
            <div class="mb-3">
              <label for="number" class="form-label">Baksteen nummer:</label>
              <input type="text" class="form-control" name="number" id="number" placeholder="voer hier nummer in" required>
            </div>
            <button type="submit" class="btn btn-primary">Prijs?</button>
          </form>
        <?php endif ?>
      </div>
    </div>
  </div>

  <!-- Bootstrap 5 JS and Popper.js links (required for Bootstrap features) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
