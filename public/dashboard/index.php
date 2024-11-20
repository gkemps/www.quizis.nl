<?php
include "../connect.php";

// select quiz
$quizcode = "";
if (isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI'])) {
    $path = explode("/", $_SERVER['REQUEST_URI']);
    if (count($path) > 2 && $path[2][0] != "?") {
        $quizcode = $path[count($path) - 1];
    }
}

$sql = "SELECT * FROM quiz_Quiz WHERE quiz_Location_id = 1 AND private = 0 AND date > NOW() ORDER BY date ASC LIMIT 1";
if ($quizcode != "") {
    $sql = "SELECT * FROM quiz_Quiz WHERE code = '{$quizcode}' ORDER BY date ASC LIMIT 1";
}

if (!$result = $conn->query($sql)) {
    die("Error: " . $conn->error . " (Query: $sql)");
}

if ($result->num_rows > 0) {
    $quiz = $result->fetch_assoc();
} else {
    die("Geen quiz gevonden");
}

// date
$date = new DateTime($quiz['date']);
// format
$formatter = new \IntlDateFormatter('nl_NL', \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT);
$formatter->setPattern('EEEE d LLLL HH:mm');

$when = ucfirst($formatter->format($date) . " uur");

// select teams
$sql = "SELECT * FROM quiz_Team WHERE quiz_Quiz_id = {$quiz['id']} order by dateCreated ASC";
if (!$result = $conn->query($sql)) {
    die("Error: " . $conn->error . " (Query: $sql)");
}

$teams = $result->fetch_all(MYSQLI_ASSOC);

$teamsCount = count($teams);

// loop over teams and determine the number of team members
$paidMembers = 0;
$paidTeams = 0;
$totalMembers = 0;
foreach ($teams as $k => $team) {
    // determine the number of team members
    // by deviding the paid amount by the price per person
    $teamMembers = $quiz['maxTeamMembers'];
    if ($team['datePaid'] != null) {
        $teamMembers = 0;
        if ($quiz['pricePerTeam'] > 0) {
            $teamMembers = $quiz['maxTeamMembers'];
        } elseif ($quiz['pricePerPerson'] > 0) {
            $teamMembers = $team['amount'] / $quiz['pricePerPerson'];
        }
        $paidMembers += $teamMembers;
        $paidTeams++;
    } else {
        $teamMembers = $team['teamMembers'];
    }
    $totalMembers += $teamMembers;
}

// query the last 3 quiz ids located at the same location
$sql = "SELECT id FROM quiz_Quiz WHERE quiz_Location_id = {$quiz['quiz_Location_id']} AND private = 0 AND date < NOW() ORDER BY date DESC LIMIT 3";

if (!$result = $conn->query($sql)) {
    die("Error: " . $conn->error . " (Query: $sql)");
}

$quizIds = $result->fetch_all(MYSQLI_ASSOC);

$quizIds = array_map(function ($quiz) {
    return $quiz['id'];
}, $quizIds);

// find the team names that participated in at least 2 of the last 3 quizzes
$sql = "SELECT name, COUNT(id) as count FROM quiz_Team WHERE quiz_quiz_id IN (" . implode(",", $quizIds) . ") GROUP BY name HAVING count > 1";


if (!$result = $conn->query($sql)) {
    die("Error: " . $conn->error . " (Query: $sql)");
}

$pastTeams = $result->fetch_all(MYSQLI_ASSOC);

$stillExpectedTeams = array_map(function ($team) {
    return $team['name'];
}, $pastTeams);

// find the teams in $stillExpectedTeams that are not in $teams
$stillExpectedTeams = array_filter($stillExpectedTeams, function ($team) use ($teams) {
    foreach ($teams as $t) {
        // trim and lowercose both teams
        $team1 = strtolower(trim($t['name']));
        $team2 = strtolower(trim($team));

        if ($team1 == $team2 || levenshtein($team1, $team2) < 3) {
            return false;
        }
    }
    return true;
});

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pub Quiz Dashboard</title>
    <link rel="stylesheet" href="/dashboard/style.css">
</head>

<body>
    <header>
        <h1><?php echo $quiz['name']; ?></h1>
        <p><?php echo $when; ?></p>
    </header>
    <main>
        <!-- Summary Cards -->
        <section id="summary">
            <div class="card">
                <h2>Teams ingeschreven</h2>
                <p id="total-teams">
                    <?php echo $teamsCount; ?>
                </p>
            </div>
            <div class="card">
                <h2>Teams betaald</h2>
                <p id="paid-teams">
                    <?php echo $paidTeams; ?>
                </p>
            </div>
            <div class="card">
                <h2>Deelnemers verwacht</h2>
                <p id="total-members">
                    <?php echo $totalMembers; ?>
                </p>
            </div>
            <div class="card">
                <h2>Deelnemers bevestigd</h2>
                <p id="revenue">
                    <?php echo $paidMembers; ?>
                </p>
            </div>
        </section>

        <!-- Teams Table -->
        <section id="teams-overview">
            <h2>Teams Overzicht</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nr</th>
                        <th>Teamnaam</th>
                        <th>Captain</th>
                        <th>Deelnemers</th>
                        <th>Ingeschreven</th>
                        <th>Betaald</th>
                    </tr>
                </thead>
                <tbody id="teams-table">
                    <?php foreach ($teams as $k => $team): ?>
                        <?php
                        //determine the number of team members
                        //by deviding the paid amount by the price per person
                    
                        $teamMembers = $quiz['maxTeamMembers'] . "?";
                        if ($team['datePaid'] != null) {
                            if ($quiz['pricePerTeam'] > 0) {
                                $teamMembers = $quiz['maxTeamMembers'];
                            } elseif ($quiz['pricePerPerson'] > 0) {
                                $teamMembers = $team['amount'] / $quiz['pricePerPerson'];
                            }
                        } else {
                            $teamMembers = $team['teamMembers'];
                        }

                        if ($teamMembers == 0) {
                            $teamMembers = $quiz['maxTeamMembers'] . "?";
                        }

                        ?>
                        <tr>
                            <td><?php echo $k + 1; ?></td>
                            <td><?php echo $team['name']; ?></td>
                            <td><?php echo $team['captain']; ?> (<?php echo $team['email']; ?>)</td>
                            <td><?php echo $teamMembers; ?></td>
                            <td><?php echo $team['dateCreated'] ?></td>
                            <td><?php echo $team['datePaid'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>


        <!-- Expected Teams Table -->
        <section id="teams-overview">
            <h2>Niet ingescheven, maar van laatste 3x minimaal 2x meegedaan</h2>
            <table>
                <thead>
                    <tr>
                        <th>Teamnaam</th>
                    </tr>
                </thead>
                <tbody id="teams-table">
                    <?php foreach ($stillExpectedTeams as $team): ?>
                        <tr>
                            <td><?php echo $team; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

</body>

</html>